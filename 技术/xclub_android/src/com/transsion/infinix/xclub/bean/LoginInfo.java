package com.transsion.infinix.xclub.bean;

import java.util.ArrayList;
import java.util.List;

public class LoginInfo {
         
	private String Version;
	private String Charset;
	private String sys_authkey;
	private Variable Variables=new Variable();
	private MessageInfo Message=new MessageInfo();
	
	
	
	public String getVersion() {
		return Version;
	}
	public void setVersion(String version) {
		Version = version;
	}
	public String getCharset() {
		return Charset;
	}
	public void setCharset(String charset) {
		Charset = charset;
	}
	public Variable getVariables() {
		return Variables;
	}
	public void setVariables(Variable variables) {
		Variables = variables;
	}
	public MessageInfo getMessage() {
		return Message;
	}
	public void setMessage(MessageInfo message) {
		Message = message;
	}
	public String getSys_authkey() {
		return sys_authkey;
	}
	public void setSys_authkey(String sys_authkey) {
		this.sys_authkey = sys_authkey;
	}
	
	
	
}
