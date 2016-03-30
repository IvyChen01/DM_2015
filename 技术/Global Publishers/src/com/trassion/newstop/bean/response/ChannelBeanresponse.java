package com.trassion.newstop.bean.response;

import java.util.ArrayList;

import com.trassion.newstop.bean.ChannelItemInfo;
import com.trassion.newstop.bean.JavaBean;

public class ChannelBeanresponse extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -6010062941438962605L;
	
	private int code;
	
	private String msg;
	
	private ArrayList<ChannelItemInfo> data;

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

	public ArrayList<ChannelItemInfo> getData() {
		return data;
	}

	public void setData(ArrayList<ChannelItemInfo> data) {
		this.data = data;
	}
	
	

}
