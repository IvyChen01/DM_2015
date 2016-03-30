package com.trassion.newstop.bean;

public class Message extends JavaBean{
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1445564476185547217L;
	
	
	private String id;
	private String message_date;
	private String time;
	private String content;
	
	public String getTime() {
		return time;
	}
	public void setTime(String time) {
		this.time = time;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getMessage_date() {
		return message_date;
	}
	public void setMessage_date(String message_date) {
		this.message_date = message_date;
	}
	
	

}
