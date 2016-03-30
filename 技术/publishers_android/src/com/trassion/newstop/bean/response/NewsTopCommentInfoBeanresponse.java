package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.Comment;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.NewsInfo;

public class NewsTopCommentInfoBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -2696805438433509823L;
	
	private int code;
	private String msg;
	private String total;
	private ArrayList<Comment>data;
	public int getCode() {
		return code;
	}
	public void setCode(int code) {
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
	public ArrayList<Comment> getData() {
		return data;
	}
	public void setData(ArrayList<Comment> data) {
		this.data = data;
	}
}
