package com.trassion.newstop.bean;

public class CommentInfo extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 4314852883304380828L;
	
	private String newsid;
	private String content;
	private String comment_date;
	private String like_count;
	private String id;
	private String username;
	private String photo;
	private String liked;
	public String getNewsid() {
		return newsid;
	}
	public void setNewsid(String newsid) {
		this.newsid = newsid;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
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
	public String getUsername() {
		return username;
	}
	public void setUsername(String username) {
		this.username = username;
	}
	public String getPhoto() {
		return photo;
	}
	public void setPhoto(String photo) {
		this.photo = photo;
	}
	public String getLiked() {
		return liked;
	}
	public void setLiked(String liked) {
		this.liked = liked;
	}
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	
	

}
