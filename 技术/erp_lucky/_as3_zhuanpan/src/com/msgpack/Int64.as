package com.msgpack {
    public class Int64 {
        public var high : uint = 0;
        public var low : uint = 0;
        public var signed : Boolean = false;

        public function Int64(high : uint, low : uint, signed : Boolean = false) {
            this.high = high;
            this.low = low;
            this.signed = signed;
        }

        public function get value() : Number {
            return (high + 0.0) * (1.0 + 0xFFFFFFFF) + (low + 0.0);
        }

        public function equals(other : *) : Boolean {
            if (!(other is Int64)) {
                return false;
            }
            var o : Int64 = (other as Int64);
            return high == o.high && low == o.low;
        }

    }
}
