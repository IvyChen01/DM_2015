package com.trassion.newstop.bean;

import java.util.ArrayList;

public class Comment extends JavaBean{
	
	/**
	 * 
	 */
	private static final long serialVersionUID = -2596805434043509723L;
	
	private String newsid;
	private String title;
	private String content;
	private String excerpt;
	private String pubdate;
	private String channel;
	private String tags;
	private ArrayList<ImageInfo>images;
    private String commentCount;
    
    private String comment;
    private String author;
    private String comment_date;
    private String like_count;
    private String nick;
	private String photo;
	private String username;
	private String collected;
	private String liked;
	private String collect_date;
	
	public String getNewsid() {
		return newsid;
	}
	public void setNewsid(String newsid) {
		this.newsid = newsid;
	}
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public String getExcerpt() {
		return excerpt;
	}
	public void setExcerpt(String excerpt) {
		this.excerpt = excerpt;
	}
	public String getPubdate() {
		return pubdate;
	}
	public void setPubdate(String pubdate) {
		this.pubdate = pubdate;
	}
	public String getChannel() {
		return channel;
	}
	public void setChannel(String channel) {
		this.channel = channel;
	}
	public String getTags() {
		return tags;
	}
	public void setTags(String tags) {
		this.tags = tags;
	}
	public ArrayList<ImageInfo> getImages() {
		return images;
	}
	public void setImages(ArrayList<ImageInfo> images) {
		this.images = images;
	}
	public String getCommentCount() {
		return commentCount;
	}
	public void setCommentCount(String commentCount) {
		this.commentCount = commentCount;
	}
	public String getComment() {
		return comment;
	}
	public void setComment(String comment) {
		this.comment = comment;
	}
	public String getAuthor() {
		return author;
	}
	public void setAuthor(String author) {
		this.author = author;
	}
	public String getComment_date() {
		return comment_date;
	}
	public void setComment_date(String comment_date) {
		this.comment_date = comment_date;
	}
	public String getLike_count() {
		return like_count;
	}
	public void setLike_count(String like_count) {
		this.like_count = like_count;
	}
	public String getNick() {
		return nick;
	}
	public void setNick(String nick) {
		this.nick = nick;
	}
	public String getPhoto() {
		return photo;
	}
	public void setPhoto(String photo) {
		this.photo = photo;
	}
	public String getUsername() {
		return username;
	}
	public void setUsername(String username) {
		this.username = username;
	}
	public String getCollected() {
		return collected;
	}
	public void setCollected(String collected) {
		this.collected = collected;
	}
	public String getLiked() {
		return liked;
	}
	public void setLiked(String liked) {
		this.liked = liked;
	}
	public String getCollect_date() {
		return collect_date;
	}
	public void setCollect_date(String collect_date) {
		this.collect_date = collect_date;
	}
	
	

}
