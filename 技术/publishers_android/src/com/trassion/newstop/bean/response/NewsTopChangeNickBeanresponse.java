package com.trassion.newstop.bean.response;

import com.trassion.newstop.bean.JavaBean;

public class NewsTopChangeNickBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1448564116185607817L;
	
	private String code;
	private String msg;
	private String nick;
	private String signature;
	
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
	public String getNick() {
		return nick;
	}
	public void setNick(String nick) {
		this.nick = nick;
	}
	public String getSignature() {
		return signature;
	}
	public void setSignature(String signature) {
		this.signature = signature;
	}
	
	

}
