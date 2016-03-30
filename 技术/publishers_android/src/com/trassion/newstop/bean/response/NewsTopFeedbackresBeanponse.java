package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.FeedbackInfo;
import com.trassion.newstop.bean.JavaBean;

public class NewsTopFeedbackresBeanponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1328364116364606917L;

    private String code;
    private String msg;
    private ArrayList<FeedbackInfo>data;
    
	public String getCode() {
		return code;
	}
	public void setCode(String code) {
		this.code = code;
	}
	public String getMsg() {
		return msg;
	}
	public void setMsg(String msg) {
		this.msg = msg;
	}
	public ArrayList<FeedbackInfo> getData() {
		return data;
	}
	public void setData(ArrayList<FeedbackInfo> data) {
		this.data = data;
	}
    
    
}
