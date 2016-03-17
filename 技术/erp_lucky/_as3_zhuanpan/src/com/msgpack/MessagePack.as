package com.msgpack {
    import flash.utils.ByteArray;
    import flash.utils.Endian;
    import flash.utils.getDefinitionByName;
    import flash.utils.getQualifiedClassName;

    public class MessagePack {
        private static const FLOAT_MIN_VALUE : Number = -1.40129846432481707e+45;
        private static const FLOAT_MAX_VALUE : Number = 1.40129846432481707e+45;
        private static const DOUBLE_FLOAT_MIN_VALUE : Number = -4.94065645841246544e+324;
        private static const DOUBLE_FLOAT_MAX_VALUE : Number = 4.94065645841246544e+324;

        public static function decode(input : ByteArray) : * {
            // bigendian
            //input.position = 0;
            input.endian = Endian.BIG_ENDIAN;
            var byteType : uint = input.readUnsignedByte();
            if ( (byteType & 0x80) == 0) {
                return byteType;
            } else if ( (byteType & 0xE0) == 0xE0) {
                var fixnumNeg : int = -((byteType ^ 0xFF) + 1);
                return fixnumNeg;
            } else if (byteType == 0xCC) {
                var u8 : uint = input.readUnsignedByte();
                return u8;
            } else if (byteType == 0xCD) {
                var u16 : uint = input.readUnsignedShort();
                return u16;
            } else if (byteType == 0xCE) {
                var u32 : uint = input.readUnsignedInt();
                return u32;
            } else if (byteType == 0xCF) {
                var uhigh : uint = input.readUnsignedInt();
                var ulow : uint = input.readUnsignedInt();
                var u64 : Int64 = new Int64(uhigh, ulow, false);
                return u64;
            } else if (byteType == 0xD0) {
                var i8 : int = input.readByte();
                return i8;
            } else if (byteType == 0xD1) {
                var i16 : int = input.readShort();
                return i16;
            } else if (byteType == 0xD2) {
                var i32 : int = input.readInt();
                return i32;
            } else if (byteType == 0xD3) {
                var ihigh : uint = input.readUnsignedInt();
                var ilow : uint = input.readUnsignedInt();
                var i64 : Int64 = new Int64(ihigh, ilow, true);
                return i64;
            } else if (byteType == 0xC0) {
                return null;
            } else if (byteType == 0xC3) {
                return true;
            } else if (byteType == 0xC2) {
                return false;
            } else if (byteType == 0xCA) {
                var f32 : Number = input.readFloat();
                return f32;
            } else if (byteType == 0xCB) {
                var f64 : Number = input.readDouble();
                return f64;
            }
            // Bytes 
            else if ( (byteType & 0xE0) == 0xA0) {
                var lenFix : uint = (byteType & 0x1F);
                if (lenFix == 0) {
                    return "";
                }
                var rawBytesFix : ByteArray = new ByteArray();
                input.readBytes(rawBytesFix, 0, lenFix);
                return rawBytesFix.readUTFBytes(rawBytesFix.length);
            } else if (byteType == 0xDA) {
                var len16 : uint = input.readUnsignedShort();
                if (len16 == 0) {
                    return "";
                }
                var rawBytes16 : ByteArray = new ByteArray();
                input.readBytes(rawBytes16, 0, len16);
                return rawBytes16.readUTFBytes(rawBytes16.length);
            } else if (byteType == 0xDB) {
                var len32 : uint = input.readUnsignedInt();
                if (len32 == 0) {
                    return "";
                }
                var rawBytes32 : ByteArray = new ByteArray();
                input.readBytes(rawBytes32, 0, len32);
                return rawBytes32.readUTFBytes(rawBytes32.length);
            }
            // Array 
            else if ( (byteType & 0xF0) == 0x90) {
                var alen : int = (byteType & 0x0F);
                var arr : Array = [];
                for (; alen > 0; --alen) {
                    arr.push(decode(input));
                }
                return arr;
            } else if (byteType == 0xDC) {
                var alen16 : int = input.readUnsignedShort();
                var arr16 : Array = [];
                for (; alen16 > 0; --alen16) {
                    arr16.push(decode(input));
                }
                return arr16;
            } else if (byteType == 0xDD) {
                var alen32 : uint = input.readUnsignedInt();
                var arr32 : Array = [];
                for (; alen32 > 0; --alen32) {
                    arr32.push(decode(input));
                }
                return arr32;
            }
            else if ( (byteType & 0xF0) == 0x80) {
                var mlen : int = (byteType & 0x0F);
                var map : Object = {};
                for (; mlen > 0; --mlen) {
                    var k : * = decode(input);
                    map[k] = decode(input);
                }
                return map;
            } else if (byteType == 0xDE) {
                var mlen16 : int = input.readUnsignedShort();
                var map16 : Object = {};
                for (; mlen16 > 0; --mlen16) {
                    var k16 : * = decode(input);
                    map16[k16] = decode(input);
                }
                return map16;
            } else if (byteType == 0xDF) {
                var mlen32 : uint = input.readUnsignedInt();
                var map32 : Object = {};
                for (; mlen32 > 0; --mlen32) {
                    var k32 : * = decode(input);
                    map32[k32] = decode(input);
                }
                return map32;
            } else {
                throw new Error("unknown type " + byteType);
            }
            throw new Error("should return");
        }

        public static function encode(data : *) : ByteArray {
            var output : ByteArray = new ByteArray();
            output.endian = Endian.BIG_ENDIAN;
            encodeData(output, data);
            output.position = 0;
            return output;
        }

        private static function encodeData(output : ByteArray, data : *) : void {
            if (data == null) {
                encodeNull(output);
                return;
            }
            if (data is IPackable) {
                encodeObject(output, data);
                return;
            }
            var name : String = getQualifiedClassName(data);
            var type : Class = getDefinitionByName(name) as Class;
            if (type == int) {
                encodeInt(output, data);
            } else if (type == uint) {
                encodeUint(output, data);
            } else if (type == Boolean) {
                encodeBoolean(output, data);
            } else if (type == null) {
                encodeNull(output);
            } else if (type == Number) {
                encodeNumber(output, data);
            } else if (type == String || type == XML) {
                encodeString(output, data);
            } else if (type == ByteArray) {
                encodeByteArray(output, data);
            } else if (type == Array) {
                encodeArray(output, data);
            } else if (type == Int64) {
                encodeInt64(output, data);
            } else {
                encodeObject(output, data);
            }
        }

        private static function encodeObject(output : ByteArray, data : *) : void {
            var fields : Array = [];
            if (data is IPackable) {
                fields = (data as IPackable).getFieldNames();
            }
            else {
                for (var k : String in data) {
                    fields.push(k);
                }
            }
            if (fields.length <= 0x0F) {
                output.writeByte(0x80 | fields.length);
            }
            else if (fields.length <= 0xFFFF) {
                output.writeByte(0xDE);
                output.writeShort(fields.length);
            }
            else {
                output.writeByte(0xDF);
                output.writeInt(fields.length);
            }
            for each (var name : String in fields) {
                encodeData(output, name);
                encodeData(output, data[name]);
            }
        }

        private static function encodeArray(output : ByteArray, data : Array) : void {
            if (data.length <= 0x0F) {
                output.writeByte(0x90 | data.length);
            }
            else if (data.length <= 0xFFFF) {
                output.writeByte(0xDC);
                output.writeShort(data.length);
            }
            else {
                output.writeByte(0xDD);
                output.writeInt(data.length);
            }
            for each (var item : * in data) {
                encodeData(output, item);
            }
        }

        private static function encodeByteArray(output : ByteArray, data : ByteArray) : void {
            if (data.length <= 0x1F) {
                output.writeByte(0xA0 | data.length);
            }
            else if (data.length <= 0xFFFF) {
                output.writeByte(0xDA);
                output.writeShort(data.length);
            }
            else {
                output.writeByte(0xDB);
                output.writeInt(data.length);
            }
            output.writeBytes(data, 0, data.length);
        }

        private static function encodeString(output : ByteArray, data : String) : void {
            var utfBytes : ByteArray = new ByteArray();
            utfBytes.writeUTFBytes(data);
            encodeByteArray(output, utfBytes);
        }

        private static function encodeNumber(output : ByteArray, data : Number) : void {
            var roundCheck:Number = data % 1;
            if (data >= int.MIN_VALUE && data <= int.MAX_VALUE && roundCheck == 0) {
                encodeInt(output, data);
            }
            else if (data >= FLOAT_MIN_VALUE && data <= FLOAT_MAX_VALUE) {
                output.writeByte(0xCA);
                output.writeFloat(data);
            }
            else if (data >= DOUBLE_FLOAT_MIN_VALUE && data <= DOUBLE_FLOAT_MAX_VALUE) {
                output.writeByte(0xCB);
                output.writeDouble(data);
            }
            else {
                throw new Error("Out of Range");
            }
        }
        
        private static function encodeInt64(output : ByteArray, data : Int64) : void {
            if (data.high == 0) {
                encodeUint(output, data.low);
            }
            else if (data.signed) {
                output.writeByte(0xD3);
                output.writeInt(data.high);
                output.writeInt(data.low);
            }
            else {
                output.writeByte(0xCF);
                output.writeInt(data.high);
                output.writeInt(data.low);
            }
        }

        private static function encodeNull(output : ByteArray) : void {
            output.writeByte(0xC0);
        }

        private static function encodeBoolean(output : ByteArray, data : Boolean) : void {
            if (data) {
                output.writeByte(0xC3);
            } else {
                output.writeByte(0xC2);
            }
        }

        private static function encodeUint(output : ByteArray, value : uint) : void {
            if(value < (1 << 7)) {
                output.writeByte(value);
            } else {
                if(value < (1 << 8)) {
                    // unsigned 8
                    output.writeByte(0xcc);
                    output.writeByte(value);
                } else if(value < (1 << 16)) {
                    // unsigned 16
                    output.writeByte(0xcd);
                    output.writeShort(value);
                } else {
                    // unsigned 32
                    output.writeByte(0xce);
                    output.writeUnsignedInt(value);
                }
            }
        }

        private static function encodeInt(output : ByteArray, value : int) : void {
            if(value < -(1 << 5)) {
                if(value < -(1 << 15)) {
                    // signed 32
                    output.writeByte(0xd2);
                    output.writeInt(value);
                } else if(value < -(1 << 7)) {
                    // signed 16
                    output.writeByte(0xd1);
                    output.writeShort(value);
                } else {
                    // signed 8
                    output.writeByte(0xd0);
                    output.writeByte(value);
                }
            } else if(value < (1 << 7)) {
                // fixnum
                output.writeByte(value);
            } else {
                if(value < (1 << 8)) {
                    // unsigned 8
                    output.writeByte(0xcc);
                    output.writeByte(value);
                } else if(value < (1 << 16)) {
                    // unsigned 16
                    output.writeByte(0xcd);
                    output.writeShort(value);
                } else {
                    // unsigned 32
                    output.writeByte(0xce);
                    output.writeUnsignedInt(value);
                }
            }
        }
    }
}
