package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.CommentInfo;
import com.trassion.newstop.bean.JavaBean;

public class NewsTopCommentBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1328364116185606917L;

	
	private String total;
	private ArrayList<CommentInfo> data;
	
	public String getTotal() {
		return total;
	}
	public void setTotal(String total) {
		this.total = total;
	}
	public ArrayList<CommentInfo> getData() {
		return data;
	}
	public void setData(ArrayList<CommentInfo> data) {
		this.data = data;
	}
	
	
}
