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
	 * ������������
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
		        
//		    //  ���� ���� ֱ���ж� ��½ �Ƿ���ڣ���� ���� ����ʾ�û� �Ͳ��� ���� ���� ������ȥ��
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
