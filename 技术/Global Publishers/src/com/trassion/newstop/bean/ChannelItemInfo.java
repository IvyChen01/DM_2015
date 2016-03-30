package com.trassion.newstop.bean;

public class ChannelItemInfo extends JavaBean{
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1328364116185607817L;

	private String channel;
	
	private String index;//列表序号
	
	private String follow;//是否关注
	
	private String followIndex;

	
	public String getChannel() {
		return channel;
	}

	public void setChannel(String channel) {
		this.channel = channel;
	}

	public String getIndex() {
		return index;
	}

	public void setIndex(String index) {
		this.index = index;
	}

	public String getFollow() {
		return follow;
	}

	public void setFollow(String follow) {
		this.follow = follow;
	}

	public String getFollowIndex() {
		return followIndex;
	}

	public void setFollowIndex(String followIndex) {
		this.followIndex = followIndex;
	}
	
	

}
