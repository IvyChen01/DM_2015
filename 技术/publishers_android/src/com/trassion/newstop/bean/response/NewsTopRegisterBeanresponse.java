package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.CommentInfo;
import com.trassion.newstop.bean.JavaBean;

public class NewsTopRegisterBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -4543466678670646845L;
    
	private String code;
	private String msg;
	private String image;
	
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
	public String getImage() {
		return image;
	}
	public void setImage(String image) {
		this.image = image;
	}
	
}
