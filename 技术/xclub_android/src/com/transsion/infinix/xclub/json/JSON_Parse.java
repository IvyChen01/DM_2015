package com.transsion.infinix.xclub.json;

import java.util.ArrayList;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import com.transsion.infinix.xclub.entity.BaseEntity;



import android.content.DialogInterface;
import android.text.TextUtils;

public class JSON_Parse {
	
	/**
	 * 解析基础数据
	 * @param result
	 * @return
	 */
	public static BaseEntity parse(String result){
		if(TextUtils.isEmpty(result))
			return null;
		try {
		    BaseEntity be=new BaseEntity();
		    JSONObject obj = new JSONObject(result);
		    if(obj.isNull("code")==false){
		        be.setCode(obj.getString("code"));
		        
//		    //  这里 可以 直接判断 登陆 是否过期，如果 过期 则提示用户 就不用 在往 下面 解析下去了
//	            
//	            if(be.getCode().equals("499")){
//	                
//	                return "499";
//	            }
		    }
		    if(obj.isNull("ret")==false){
		        be.setMsg(obj.getString("msg"));
		    }
		    
		    if(obj.isNull("ret")==false){
		        be.setRet(obj.getInt("ret"));
		    }
		    be.setMessage(result);
		    
		    return be;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
}
