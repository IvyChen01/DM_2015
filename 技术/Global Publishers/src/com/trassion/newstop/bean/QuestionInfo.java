package com.trassion.newstop.bean;

public class QuestionInfo extends JavaBean{

	/**
	 * 
	 */
	private static final long serialVersionUID = 6448563476193647827L;
	
	private String id;
	private String question;
	private String answer;
	private String pubdate;
	
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getQuestion() {
		return question;
	}
	public void setQuestion(String question) {
		this.question = question;
	}
	public String getAnswer() {
		return answer;
	}
	public void setAnswer(String answer) {
		this.answer = answer;
	}
	public String getPubdate() {
		return pubdate;
	}
	public void setPubdate(String pubdate) {
		this.pubdate = pubdate;
	}
	
	

}
