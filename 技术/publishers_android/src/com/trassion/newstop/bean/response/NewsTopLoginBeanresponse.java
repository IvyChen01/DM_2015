package com.trassion.newstop.bean.response;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.UserInfo;

public class NewsTopLoginBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 3914852883304380828L;
     
	private String code;
	private String msg;
	private String saltkey;
	private String auth;
	private UserInfo userinfo;
	
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

	public String getSaltkey() {
		return saltkey;
	}
	public void setSaltkey(String saltkey) {
		this.saltkey = saltkey;
	}
	public String getAuth() {
		return auth;
	}
	public void setAuth(String auth) {
		this.auth = auth;
	}
	public UserInfo getUserinfo() {
		return userinfo;
	}
	public void setUserinfo(UserInfo userinfo) {
		this.userinfo = userinfo;
	}
	
}
