package com.msgpack {
    import flash.utils.getDefinitionByName;
    import flash.utils.getQualifiedClassName;
    public class Util {
        
        public static function xtrace(obj:*, name:String):void {
            trace(name + " = " + inspect(obj) + "\n");
        }
        
        private static const cache_size : int = 10;
        private static const indent : String = "  ";
        private static var spaceCache : Array = [];
        public static function space(len:int) : String {
            if (len <= 0) {
                return "";
            }
            if (spaceCache.length == 0) {
                spaceCache.push("");
                for (var i:int = 1; i <= cache_size; ++i) {
                    var idx:int = (int)(i/2);
                    var str : String = (i%2 == 0 ? "" : indent) + spaceCache[idx] + spaceCache[idx];
                    spaceCache.push(str);
                }
            }
            if (len < spaceCache.length) {
                return spaceCache[len];
            }
            var half : String = space((int)(len/2));
            return (len % 2 == 0 ? "" : indent) + half + half;
        }

        public static function inspect(obj: *, depth:int=0) : String {
            var prefix : String = space(depth);
            var prefix2 : String = space(depth + 1);
            if (obj == null) {
                return "null";
            }
            var clazz : Class = getDefinitionByName(getQualifiedClassName(obj)) as Class;
            var key : String = "";
            var str : String = "";
            if (clazz == Object) {
                str = "{\n";
                for (key in obj) {
                    str += prefix2 + key + " : " + inspect(obj[key], depth+1) + ",\n";
                }
                str += prefix + "}";
            }
            else if (clazz == Array) {
                str += "[";
                var sp : String= "";
                for each (var val : * in obj) {
                    str += sp + inspect(val);
                    if (sp.length == 0) sp = ",";
                }
                str += "]";
            }
            else if (clazz == String) {
                str = "'" + obj + "'";
            }
            else {
                str = "" + obj;
            }
            return str;
        }
        
    }
}
