package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.CommentInfo;
import com.trassion.newstop.bean.JavaBean;

public class NewsTopAddCommentBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 4314852854204380828L;
	
	private String code;
	private String msg;
	private ArrayList<CommentInfo>data;
	
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
	public ArrayList<CommentInfo> getData() {
		return data;
	}
	public void setData(ArrayList<CommentInfo> data) {
		this.data = data;
	}
}
