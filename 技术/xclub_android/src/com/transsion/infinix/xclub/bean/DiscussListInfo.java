package com.transsion.infinix.xclub.bean;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class DiscussListInfo implements Serializable{
   
	/**
	 * 
	 */
	private static final long serialVersionUID = -7160210544600464481L;
	
	private String pid;//回复的pid
	private String tid;//帖子的id
	private String first;//主贴
	private String author;//用户名
	private String authorid;//发帖的id
	private String dateline;//发表时间
	private String message;//发表内容
	private List<ImageInfo> imgage=new ArrayList<ImageInfo>();
	private String position;//位置
	private String status;
	private String memberstatus;
	private String dbdateline;
	private String avatar;//图像地址
	private String bigavatar;
	private String support;//赞成
	private String unsupport;//反对
	private String level;   //标签
	private String gender;  //性别
	private String addscore;//赞成人数
	private String minusscore;//反对人数
	private String from;
	private String views;
	public String getViews() {
		return views;
	}
	public void setViews(String views) {
		this.views = views;
	}
	private String quote;
	private String subject;
	public String getSubject() {
		return subject;
	}
	public void setSubject(String subject) {
		this.subject = subject;
	}
	public boolean hasShowAll = false; 
	public String getPid() {
		return pid;
	}
	public void setPid(String pid) {
		this.pid = pid;
	}
	public String getTid() {
		return tid;
	}
	public void setTid(String tid) {
		this.tid = tid;
	}
	public String getFirst() {
		return first;
	}
	public void setFirst(String first) {
		this.first = first;
	}
	public String getAuthor() {
		return author;
	}
	public void setAuthor(String author) {
		this.author = author;
	}
	public String getAuthorid() {
		return authorid;
	}
	public void setAuthorid(String authorid) {
		this.authorid = authorid;
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
	public String getPosition() {
		return position;
	}
	public void setPosition(String position) {
		this.position = position;
	}
	public String getSupport() {
		return support;
	}
	public void setSupport(String support) {
		this.support = support;
	}
	public String getUnsupport() {
		return unsupport;
	}
	public void setUnsupport(String unsupport) {
		this.unsupport = unsupport;
	}
	public String getStatus() {
		return status;
	}
	public void setStatus(String status) {
		this.status = status;
	}

	public String getMemberstatus() {
		return memberstatus;
	}
	public void setMemberstatus(String memberstatus) {
		this.memberstatus = memberstatus;
	}
	public String getDbdateline() {
		return dbdateline;
	}
	public void setDbdateline(String dbdateline) {
		this.dbdateline = dbdateline;
	}
	public String getAvatar() {
		return avatar;
	}
	public void setAvatar(String avatar) {
		this.avatar = avatar;
	}
	public String getLevel() {
		return level;
	}
	public void setLevel(String level) {
		this.level = level;
	}
	public String getGender() {
		return gender;
	}
	public void setGender(String gender) {
		this.gender = gender;
	}
	public List<ImageInfo> getImgage() {
		return imgage;
	}
	public void setImgage(List<ImageInfo> imgage) {
		this.imgage = imgage;
	}
	public String getAddscore() {
		return addscore;
	}
	public void setAddscore(String addscore) {
		this.addscore = addscore;
	}
	public String getMinusscore() {
		return minusscore;
	}
	public void setMinusscore(String minusscore) {
		this.minusscore = minusscore;
	}
	public String getQuote() {
		return quote;
	}
	public void setQuote(String quote) {
		this.quote = quote;
	}
	public boolean isHasShowAll() {
		return hasShowAll;
	}
	public void setHasShowAll(boolean hasShowAll) {
		this.hasShowAll = hasShowAll;
	}
	public String getFrom() {
		return from;
	}
	public void setFrom(String from) {
		this.from = from;
	}
	public String getBigavatar() {
		return bigavatar;
	}
	public void setBigavatar(String bigavatar) {
		this.bigavatar = bigavatar;
	}
}
