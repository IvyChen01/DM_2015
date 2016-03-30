package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Message;

public class NewsTopSystemMessageBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 7448564116985677817L;
	
	private String code;
	private String msg;
	private String total;
	private ArrayList<Message>data;
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
	public String getTotal() {
		return total;
	}
	public void setTotal(String total) {
		this.total = total;
	}
	public ArrayList<Message> getData() {
		return data;
	}
	public void setData(ArrayList<Message> data) {
		this.data = data;
	}
	
	
	
	

}
