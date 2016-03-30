package com.transsion.infinix.xclub.bean;

import android.widget.ImageView;


public class InvitationInfo {
	private int id;
	private String name;
	private String CardContent;
	private String time;
	private String massage;
	private String Praise;
	private int ivhead;
	
	public int getIvhead() {
		return ivhead;
	}
	public void setIvhead(int ivhead) {
		this.ivhead = ivhead;
	}
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getCardContent() {
		return CardContent;
	}
	public void setCardContent(String cardContent) {
		CardContent = cardContent;
	}
	public String getTime() {
		return time;
	}
	public void setTime(String time) {
		this.time = time;
	}
	public String getMassage() {
		return massage;
	}
	public void setMassage(String massage) {
		this.massage = massage;
	}
	public String getPraise() {
		return Praise;
	}
	public void setPraise(String praise) {
		Praise = praise;
	}
	
	
	

}
