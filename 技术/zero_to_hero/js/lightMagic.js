/**
 * Created by rrr on 2015/4/14.
 */
var _ = (function(_,w){
    var __ = w.__ = {},
        Math = w.Math,
        Number = w.Number,
        String = w.String,
        Array = w.Array,
        isNaN = w.isNaN,
        Date = w.Date,
        Regexp = w.RegExp,
        Error = w.Error,
        toString = Object.prototype.toString;
    __.Number = {
        /**
         * 判断一个Javascript对象是不是整形
         * @param v
         * @returns {boolean}
         */
        isInit        :       function(v){
            return /^\d+$/g.test(v)
        },
        /**
         * 将任意的Javascript数据类型转化成整数
         * @param v
         * @returns {number}
         */
        toNumber        :       function(v){
            if(isNaN(v)) return 0
            else return Number(v)
        }
    }
    __.Math = {
        /**
         * 保留小数点后的n位数
         * @param number {float}
         * @param n {number}
         */
        toFixDigits     :       function(number,n){
                if(0 === n) return number;
                var slice = String.prototype.slice,
                    indexOf = String.prototype.indexOf,
                    pos = indexOf.call(number,"."),
                    number = _.Number.toNumber(number);
                if(pos == -1) return number + "." + _.String.copy("0",n);
                else if(slice.call(number,pos + 1).length < n) return ~~number + "." + slice.call(number,pos + 1) + __.String.copy("0",n - slice.call(number,pos + 1))
                return ~~number + "." + slice.call(number,pos + 1,pos + n +1);
        },
        /**
         * 返回区间随机数
         * @param num1 {Number}
         * @param num2 {Number}
         */
        getRangeRandom  :       function(num1,num2){
            var num1 = ~~num1,
                num2 = ~~num2;
            if(0 === num2) return Math.floor(Math.random() * (num1 + 1));
            else if(num2 < num1 && num2 > 0) return Math.floor(Math.random() * (num1 - num2 + 1)) + num2
            return Math.floor(Math.random() * (num2 -num1 + 1)) + num1
        },
        /**
         * 求n的斐波那契数列
         * @param n {Number}
         * @returns {*}
         */
        fibonacci       :       function(n){
            if(isNaN(n)) return -1;
            if (0 === n) return 0;
            else if(1 === n || 2 === n) return 1;
            else{
                return this.fibonacci(n - 1) + this.fibonacci(n - 2)
            }
        },
        /**
         * @description 求n个数的平均值
         * @param x {...Number}
         * @returns {number}
         */
        average         :       function(x){
            var i = 0,
                sum = 0;
            while(arguments[i] !== undefined){
                sum += arguments[i];
                i++;
            }
            return sum / i;
        }
    }

    __.String = {
        isString       :      function(value){
            return toString.call(value) === "[object String]";
        },
        /**
         * 把一个字符串复制n次返回新的字符串
         * @param str {String}
         * @param n {Number}
         */
        copy            :       function(str,n){
            if(n === 0) return str;
            var arr = [];
            for(var i = 0; i < n; i++){arr[i] = str;}
            return arr.join("");
        },
        find            :       function(str,value,sensitive){
            var sensitive = sensitive || true,
                regexp = sensitive ? new Regexp(value,"g") : new Regexp(value,"ig"),
                hasIndex = [],
                len = value.length;
            if(!regexp.test(str)) return [];
            while(regexp.lastIndex !== 0){
                hasIndex.push(regexp.lastIndex - len);
                regexp.test(str)
            }
            return hasIndex;
        },
        replace         :       function(str,oldv,newv,options){
           var options = options || {},
               sensitive = (options.sensitive || true) ? 'i' : '';
            if(options.nth >= str.length) return str;
           var indexArr = this.find(str,oldv);
           if(indexArr.length === 0) return str;
           if(options.nth === undefined) {
               str = str.replace(new Regexp(oldv,'g' + sensitive),newv);
           }
           else{
              var index = indexArr[(options.nth - 1) > 0 ? options.nth - 1 : 0],
                  len = oldv.length;
              str = str.substr(0,index) + newv.toString() + str.substr(index + len)
           }
           return str;
        }

    }
    __.Date = {
        /**
         * @description 返回当天日期
         * @param rules
         * @param {Object} [options] 配置选项
         * @returns {string}
         */
        today        :       function(rules,options){
            var monthLang = (options || {}).monthLang || "CN",
                rules = rules.toLowerCase() || "",
                date = new Date(),
                today = date.getDate(),
                month = date.getMonth() + 1,
                year = date.getFullYear(),
                hours = date.getHours(),
                minutes = date.getMinutes(),
                seconds =  date.getSeconds(),
                regexpRules = /^(?:(yy|mm|dd)([\s\W\u5e74])(yy|mm|dd)([\s\W\u6708])(yy|mm|dd)(\u65e5|))/,
                regexpLongTime = /(?:hh:mm:ss)$/,
                longTime = " " + hours + ":" + minutes + ":" + seconds,
                monthEn = {
                    "01" : "Wednesday",
                    "02" : "Febuary",
                    "03" : "March",
                    "04" : "April",
                    "05" : "May",
                    "06" : "June",
                    "07" : "July",
                    "08" : "August",
                    "09" : "September",
                    "10" : "October",
                    "11" : "November",
                    "12" : "December"
                },
                dateFormats = {};

            today = today > 9 ? today : "0" + today;
            month = month > 9 ? month : "0" + month;
            dateFormats = {
                "yy" : year,
                "mm" : monthLang.toUpperCase() === "EN" ? monthEn[month] : month,
                "dd" : today
            }
            if(regexpRules.test(rules)){
                if(!regexpLongTime.test(rules)) longTime = "";
                if(Regexp.$1 === Regexp.$3 || Regexp.$1 === Regexp.$5 || Regexp.$3 === Regexp.$5) {
                    return year + "-" + month + "-" + today + longTime;
                }
                return dateFormats[Regexp.$1] + Regexp.$2 + dateFormats[Regexp.$3] + Regexp.$4 + dateFormats[Regexp.$5] + (Regexp.$6 || "");
            }
            else{
                return year + "-" + month + "-" + today + longTime;
            }
        },
        getWeek     :       function(options){
            var lang = (options || {}).lang || "CN";
            if(lang.toUpperCase() === "EN") return (new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saterday"))[(new Date()).getDay()]
            return "星期" + (new Array("日","一","二","三","四","五","六"))[(new Date()).getDay()]
        }
    }
    __.Array = {
        /**
         * @description 判断数据是否是数组
         * @param value
         * @returns {boolean}
         */
        isArray     :       function(value){
            return value instanceof Array;
        },
        /**
         * @description 判断数组是否为空
         * @param value
         * @returns {boolean}
         */
        isEmpty     :       function(value){
            return !!value.length;
        },
        /**
         * @description 深度拷贝一个数组
         * @param array {Array} 原始数组
         * @returns temArray {Array}
         */
        copy        :       function(array){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            var temArray = [];
            this.forEach(array,function(i,v){
                if(__.Array.isArray(v))
                     temArray[i] = __.Array.copy(v);
                else if(__.Object.isObject(v))
                     temArray[i] = __.Object.copy(v);
                else
                    temArray[i] = v;
            });
            return temArray;
        },
        /**
         * 返回数组中的最大值，多维数组或非数值类型返回NaN
         * @param array ｛Array｝
         * @returns {number}
         */
        max         :       function(array){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            return Math.max.apply({},array);
        },
        /**
         * 返回数组中的最小值，多维数组或非数值类型返回NaN
         * @param array ｛Array｝
         * @returns {number}
         */
        min         :       function(array){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            return Math.min.apply({},array);
        },
        /**
         * 求数组的平均值，多维数组或非数值类型返回NaN
         * @param array
         * @returns {number}
         */
        average     :       function(array){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            return __.Math.average.apply({},array);
        },
        /**
         * @description 检测数组中是否包含某一个值，包含返回该值在数组中的坐标，不包含返回-1.
         * @param array ｛Array｝
         * @param value
         * @returns {Number}
         */
        find    :       function(array,value){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            var has = [];
            this.forEach(array,function(i,v){
                if(__.Object.isObject(value)){
                    if(__.Object.isObject(v)){
                        if(__.Object.isEqual(value,v)){
                            has.push(i);
                        }
                    }
                }
                if(__.Array.isArray(value)){
                    if(__.Array.isArray(v)){
                        if(__.Array.isEqual(value,v)){
                            has.push(i);
                        }
                    }
                }
                else if(__.Function.isFunction(value)){
                    if(__.Function.isFunction(v)){
                        if(__.Function.isEqual(value,v)){
                            has.push(i);
                        }
                    }
                }
                else if(v.toString() === "NaN"){
                    if(value.toString() === "NaN"){
                        has.push(i);
                    }
                }
                if(v === value) {
                    has.push(i);
                }
            })
            return has;
        },
        /**
         * @description 遍历数组
         * @param array {Array}
         * @param callback {Function}
         */
        forEach     :       function(array,callback){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");
            var len = array.length,
                i = 0;
            for(;i < len; i++){
                callback(i,array[i]);
            }
        },
        /**
         * @description 删除数组中的元素或一组元素
         * @param array
         * @param values
         */
        deleteValue :       function(array,values){
            if(!this.isArray(array)) throw new Error("TypeError:Not a array!");

            if(this.isArray(values)){
                this.forEach(values,function(i,v){
                    if(__.Array.isArray(v))
                    {
                        var index =  __.Array.find(array,v);
                        __.Array.forEach(index,function(i,v){
                            v -= i;
                            array.splice(v,1);
                        })
                    }
                    else
                        __.Array.deleteValue(array,v)
                })
            }
            else{
                var index = this.find(array,values);
                this.forEach(index,function(i,v){
                    v -= i;
                    array.splice(v,1);
                })
            }
            return array;
        },
        isEqual     :       function(array1,array2){
            if(!this.isArray(array1) || !this.isArray(array2)) throw new Error("TypeError:Not a array!");
            if(array1.length !== array2.length) return false;

            var equal = true;
            this.forEach(array1,function(i,v){
                if(__.Array.isArray(v) && __.Array.isArray(array2[i])){
                    equal = __.Array.isEqual(v,array2[i])
                }
                else if(__.Object.isObject(v) && __.Object.isObject(array2[i])){
                    equal = __.Object.isEqual(v,array2[i])
                }
                else if(__.Function.isFunction(v) && __.Function.isFunction(array2[i])){
                    equal = __.Function.isEqual(v,array2[i]);
                }
                else if(v.toString() === "NaN"){
                    if(array2[i].toString() !== "NaN"){
                        equal = false;
                        return;
                    }
                }
                else if(v !== array2[i]) {
                    equal = false;
                    return;
                }
            })
            return equal;
        }

    }
    __.Object = {
        /**
         * @description 判断是不是一个对象
         * @param value
         * @returns {boolean}
         */
        isObject    :       function(value){
            if(Object.prototype.toString.call(value) === "[object Object]") return true;
            return false;
        },
        isEmpty     :       function(obj){
            return !this.length(obj);
        },
        isEqual     :       function(obj1,obj2){
            if(!this.isObject(obj1) || !this.isObject(obj2)) throw new Error("TypeError:Not a Object!");
            if(this.length(obj1) !== this.length(obj2)) return false;
            var equal = true;
            this.forEach(obj1,function(i,v){
                if(__.Object.isObject(v) && __.Object.isObject(obj2[i])) {
                    equal = __.Object.isEqual(v,obj2[i])
                }
                else if(__.Array.isArray(v) && __.Array.isArray(obj2[i])){
                    equal = __.Array.isEqual(v,obj2[i]);
                }
                else if(__.Function.isFunction(v) && __.Function.isFunction(obj2[i])){
                    equal = __.Function.isEqual(v,obj2[i]);
                }
                else if(v.toString() === "NaN"){
                    if(obj2[i].toString() !== "NaN"){
                        equal = false;
                        return;
                    }
                }
                else if(v !== obj2[i]){
                    equal = false;
                    return;
                }
            })
            return equal;
        },
        forEach     :       function(obj,callback){
            if(!this.isObject(obj)) throw new Error("TypeError:Not a Object!");
            for(var i in obj){
                if(obj.hasOwnProperty(i))
                    callback(i,obj[i]);
            }
        },
        length      :       function(obj){
            if(!this.isObject(obj)) throw new Error("TypeError:Not a Object!");
            var count = 0,
                i;
            for(i in obj){
                if(obj.hasOwnProperty(i)) count++;
            }
            return count;
        },
        deleteAttr  :       function(obj,attr){
            if(!this.isObject(obj)) throw new Error("TypeError:Not a Object!");
            if(obj.hasOwnProperty(attr)) delete obj[attr];
            return obj;
        },
        copy        :       function(obj){
            if(!this.isObject(obj)) throw new Error("TypeError:Not a Object!");
            var tmpObj = {};
            this.forEach(obj,function(i,v){
                    if(__.Array.isArray(v))
                        tmpObj[i] = __.Array.copy(v);
                    else if(__.Object.isObject(v))
                        tmpObj[i] = __.Object.copy(v);
                    else
                        tmpObj[i] = v;
            })
            return tmpObj;
        }

    }
    __.Function  = {
        isFunction      :       function(fun){
            return fun instanceof Function
        },
        isEqual         :       function(fun1,fun2){
            if(!this.isFunction(fun1) || !this.isFunction(fun2)) throw new Error("TypeError:Not a Function");
            return fun1.toString() === fun2.toString()
        }

    }
    _ = __;
    return _;
})(_ || {},window);