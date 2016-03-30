package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.NewsInfo;

public class NewsTopModelBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -5596805430433509823L;
	
	private int code;
	private String msg;
	private String total;
	private ArrayList<NewsInfo>data;
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
	public ArrayList<NewsInfo> getData() {
		return data;
	}
	public void setData(ArrayList<NewsInfo> data) {
		this.data = data;
	}
}
