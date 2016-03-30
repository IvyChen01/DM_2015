package com.transsion.infinix.xclub.bean;

import java.util.ArrayList;
import java.util.List;

public class PostListInfo {
   
	private String tid;//帖子id
	private String author;//作者
	private String authorid;//作者id
	private String subject;//帖子标题
	private String dateline;//发表时间
	public String getBigavatar() {
		return bigavatar;
	}
	public void setBigavatar(String bigavatar) {
		this.bigavatar = bigavatar;
	}
	private String views;//查看次数
	private String replies;//回复帖子次数
	private String avatar;//作者头像
	private String bigavatar;
	private String has_favorite;//是否加入收藏
	private String favid;//收藏id
	private String images_num;//图片数量
	private String sticky;
	private List<ImageInfo> images=new ArrayList<ImageInfo>();
	private String message;
	public String getTid() {
		return tid;
	}
	public void setTid(String tid) {
		this.tid = tid;
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
	public String getSubject() {
		return subject;
	}
	public void setSubject(String subject) {
		this.subject = subject;
	}
	public String getDateline() {
		return dateline;
	}
	public void setDateline(String dateline) {
		this.dateline = dateline;
	}
	public String getViews() {
		return views;
	}
	public void setViews(String views) {
		this.views = views;
	}
	public String getReplies() {
		return replies;
	}
	public void setReplies(String replies) {
		this.replies = replies;
	}
	public String getAvatar() {
		return avatar;
	}
	public void setAvatar(String avatar) {
		this.avatar = avatar;
	}
	public String getHas_favorite() {
		return has_favorite;
	}
	public void setHas_favorite(String has_favorite) {
		this.has_favorite = has_favorite;
	}
	public String getFavid() {
		return favid;
	}
	public void setFavid(String favid) {
		this.favid = favid;
	}
	public List<ImageInfo> getImages() {
		return images;
	}
	public void setImages(List<ImageInfo> images) {
		this.images = images;
	}
	public String getImages_num() {
		return images_num;
	}
	public void setImages_num(String images_num) {
		this.images_num = images_num;
	}
	public String getMessage() {
		return message;
	}
	public void setMessage(String message) {
		this.message = message;
	}
	public String getSticky() {
		return sticky;
	}
	public void setSticky(String sticky) {
		this.sticky = sticky;
	}
	
	
}
