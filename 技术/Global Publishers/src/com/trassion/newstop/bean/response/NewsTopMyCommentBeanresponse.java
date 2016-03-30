package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.MyCommentInfo;

public class NewsTopMyCommentBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -5596905430453579823L;
	
	private int code;
	private String msg;
	private String total;
	private ArrayList<MyCommentInfo>data;
	private String commentCount;
	private String collect_date;
	private String collected;
	private String username;
	private String nick;
	private String liked;
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
	public ArrayList<MyCommentInfo> getData() {
		return data;
	}
	public void setData(ArrayList<MyCommentInfo> data) {
		this.data = data;
	}
	
	

}
