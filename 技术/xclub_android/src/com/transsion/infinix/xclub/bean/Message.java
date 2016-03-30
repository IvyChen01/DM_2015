package com.transsion.infinix.xclub.bean;

import java.util.ArrayList;

public class Message {
    private String dateline;//发送时间
    private String message;//消息内容
    private String author;//发送者的昵称
    private String authorid;
    private String msgfrom;//发送者
    private String msgtoid;//收消息者的id
    private String avatar;//发送者的头像
    private String msgfromid;//发送者的id
    private String isnew;//是否有新消息
    private String pmnum;//消息条数
    private String touid;//发送者的uid
    private String tousername;
    private String uid_avatar;
    private ArrayList<ImageInfo> message_imgsrc=new ArrayList<ImageInfo>();
	public String getTousername() {
		return tousername;
	}
	public void setTousername(String tousername) {
		this.tousername = tousername;
	}
	public String getDateline() {
		return dateline;
	}
	public void setDateline(String dateline) {
		this.dateline = dateline;
	}
	public String getMessage() {
		return message;
	}
	public void setMessage(String message) {
		this.message = message;
	}
	public String getAuthor() {
		return author;
	}
	public void setAuthor(String author) {
		this.author = author;
	}
	public String getMsgfrom() {
		return msgfrom;
	}
	public void setMsgfrom(String msgfrom) {
		this.msgfrom = msgfrom;
	}
	public String getMsgtoid() {
		return msgtoid;
	}
	public void setMsgtoid(String msgtoid) {
		this.msgtoid = msgtoid;
	}
	public String getAvatar() {
		return avatar;
	}
	public void setAvatar(String avatar) {
		this.avatar = avatar;
	}
	public String getMsgfromid() {
		return msgfromid;
	}
	public void setMsgfromid(String msgfromid) {
		this.msgfromid = msgfromid;
	}
	public String getIsnew() {
		return isnew;
	}
	public void setIsnew(String isnew) {
		this.isnew = isnew;
	}
	public String getPmnum() {
		return pmnum;
	}
	public void setPmnum(String pmnum) {
		this.pmnum = pmnum;
	}
	public String getTouid() {
		return touid;
	}
	public void setTouid(String touid) {
		this.touid = touid;
	}
	public String getAuthorid() {
		return authorid;
	}
	public void setAuthorid(String authorid) {
		this.authorid = authorid;
	}
	public String getUid_avatar() {
		return uid_avatar;
	}
	public void setUid_avatar(String uid_avatar) {
		this.uid_avatar = uid_avatar;
	}
	public ArrayList<ImageInfo> getMessage_imgsrc() {
		return message_imgsrc;
	}
	public void setMessage_imgsrc(ArrayList<ImageInfo> message_imgsrc) {
		this.message_imgsrc = message_imgsrc;
	}
	
    
}
