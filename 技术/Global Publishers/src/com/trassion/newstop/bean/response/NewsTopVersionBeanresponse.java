package com.trassion.newstop.bean.response;

import com.trassion.newstop.bean.JavaBean;

public class NewsTopVersionBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -2314852854204350828L;
	
	private String code;
	private String msg;
	private String version;
	private String apkUrl;
	private String log;
	
	public String getLog() {
		return log;
	}
	public void setLog(String log) {
		this.log = log;
	}
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
	public String getVersion() {
		return version;
	}
	public void setVersion(String version) {
		this.version = version;
	}
	public String getApkUrl() {
		return apkUrl;
	}
	public void setApkUrl(String apkUrl) {
		this.apkUrl = apkUrl;
	}
	
	

}
