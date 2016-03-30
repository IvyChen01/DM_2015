package com.transsion.infinix.xclub.json;



import com.alibaba.fastjson.JSON;

public class GetJsonData {

    public static <T>  T get(String jsonString, Class<T> clazz){

        return JSON.parseObject(jsonString, clazz);
    }
}
