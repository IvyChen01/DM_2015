package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.QuestionInfo;

public class NewsTopFAQBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1448563876195647817L;
	
	private String code;
	private String msg;
	private ArrayList<QuestionInfo>data;
	
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
	public ArrayList<QuestionInfo> getData() {
		return data;
	}
	public void setData(ArrayList<QuestionInfo> data) {
		this.data = data;
	}
	
	

}
