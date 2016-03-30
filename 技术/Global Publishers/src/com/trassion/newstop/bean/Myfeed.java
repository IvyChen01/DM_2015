package com.trassion.newstop.bean;


public class Myfeed {
     
	private String name;
	private String time;
	private String comment;
	private String content;
	public boolean operatHasShow = false;
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getTime() {
		return time;
	}
	public void setTime(String time) {
		this.time = time;
	}
	public String getComment() {
		return comment;
	}
	public void setComment(String comment) {
		this.comment = comment;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public boolean isOperatHasShow() {
		return operatHasShow;
	}
	public void setOperatHasShow(boolean operatHasShow) {
		this.operatHasShow = operatHasShow;
	}
	
}
