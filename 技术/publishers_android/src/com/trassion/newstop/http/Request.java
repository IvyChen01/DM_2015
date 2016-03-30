package com.trassion.newstop.http;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import android.content.Context;

public class Request {

	private Map<String, List<String>> headers;
	private String requestUrl;
	private int msgId;
	private HttpListener listener;
	private boolean isPost = true;
	private Context context;
	private String modelName;
	private Map<String,String> params;
	
	public Request(String url, int msgId, HttpListener listener,Context context,String modelName) {
		super();
		this.requestUrl = url;
		this.msgId = msgId;
		this.listener = listener;
		this.context = context;
		this.modelName = modelName;
	}
	public Request(String url, int msgId, HttpListener listener,Context context,Map<String,String> params) {
		super();
		this.requestUrl = url;
		this.msgId = msgId;
		this.listener = listener;
		this.context = context;
		this.params=params;
	}
	public String getModelName() {
		return modelName;
	}

	public void setModelName(String modelName) {
		this.modelName = modelName;
	}
	public Context getContext() {
		return context;
	}

	public boolean isPost() {
		return isPost;
	}

	public void setPost(boolean isPost) {
		this.isPost = isPost;
	}

	public HttpListener getListener() {
		return listener;
	}

	public String getURL() {
		return requestUrl;
	}
	public Map<String, String> getParams() {
		return params;
	}
	public void setParams(Map<String, String> params) {
		this.params = params;
	}
	public Map<String, List<String>> getHeaders() {
		return headers;
	}

	public int getMsgId() {
		return msgId;
	}

	public void addHeader(String key, List<String> value) {

		if (headers == null) {
			headers = new HashMap<String, List<String>>();
		}
		headers.put(key, value);
	}

}