package com.trassion.newstop.bean;

public class FeedbackInfo extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = -4543486378670646945L;
	
	private String id;
	private String content;
	private String feedback_date;
	private String from_id;
	private String to_id;
	private String image;
	
	public String getFrom_id() {
		return from_id;
	}
	public void setFrom_id(String from_id) {
		this.from_id = from_id;
	}
	public String getTo_id() {
		return to_id;
	}
	public void setTo_id(String to_id) {
		this.to_id = to_id;
	}
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public String getFeedback_date() {
		return feedback_date;
	}
	public void setFeedback_date(String feedback_date) {
		this.feedback_date = feedback_date;
	}
	public String getImage() {
		return image;
	}
	public void setImage(String image) {
		this.image = image;
	}

}
