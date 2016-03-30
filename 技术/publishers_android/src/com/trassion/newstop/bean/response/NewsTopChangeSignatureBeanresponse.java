package com.trassion.newstop.bean.response;

import com.trassion.newstop.bean.JavaBean;

public class NewsTopChangeSignatureBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1448564476185547817L;
	
	private String code;
	private String msg;
	private String signature;
	private String email;
	private String phone;
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
	public String getSignature() {
		return signature;
	}
	public void setSignature(String signature) {
		this.signature = signature;
	}
	public String getEmail() {
		return email;
	}
	public void setEmail(String email) {
		this.email = email;
	}
	public String getPhone() {
		return phone;
	}
	public void setPhone(String phone) {
		this.phone = phone;
	}
	
	
	

}
