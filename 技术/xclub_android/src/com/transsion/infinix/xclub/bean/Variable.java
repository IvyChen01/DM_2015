package com.transsion.infinix.xclub.bean;

import java.util.ArrayList;
import java.util.List;

public class Variable {
	
	private String cookiepre;
	private String auth;
	private String saltkey;
	private String member_uid;
	private String member_username;
	private String groupid;
	private String formhash;
	private String ismoderator;
	private String readccess;
	private String code;
	private String fid;
	private String id;
	private String favid;
	private String favtimes;
	private String uploadavatar;
	private Notice notice=new Notice();
	private ArrayList<Message>list=new ArrayList<Message>();
	private ArrayList<NoteMessage>notelist=new ArrayList<NoteMessage>();
	private ArrayList<CountryInfo>typeid_arr=new ArrayList<CountryInfo>();
	private ArrayList<CountryInfo>nationlist=new ArrayList<CountryInfo>();
	private ArrayList<PostListInfo> forum_threadlist=new ArrayList<PostListInfo>();
	private ArrayList<DiscussListInfo> postlist=new ArrayList<DiscussListInfo>();
	private ArrayList<SearchHotInfo>hotsearch=new ArrayList<SearchHotInfo>();
	private VersionInfo app_version;
	private ArrayList<ImagesInfo>ad_list=new ArrayList<ImagesInfo>();
	private String welcome;
	private String tw;
	private String url;
	private String message;
	private String phonecode;
	private String days;
	private String mdays;
	private String lasted;
	private String has_sign;
	private String totalpage;//总页数
	private String page;
	private String ppp;
	private String tid;
	private String pid;
	
	//个人信息
	private String avatar;
	private String username;
	private String email;
	private String uid;
	private String level;
	private String regdate;
	private String realname;
	private String nationality;
	private String gender;
	private String birthyear;
	private String birthmonth;
	private String birthday;
	private String occupation;
	private String credits;
	private String mobile;
	private String telephone;
	private String bigavatar;
	
	
	public String getBigavatar() {
		return bigavatar;
	}
	public void setBigavatar(String bigavatar) {
		this.bigavatar = bigavatar;
	}
	public ArrayList<PostListInfo> getForum_threadlist() {
		return forum_threadlist;
	}
	public void setForum_threadlist(ArrayList<PostListInfo> forum_threadlist) {
		this.forum_threadlist = forum_threadlist;
	}
	public String getCookiepre() {
		return cookiepre;
	}
	public void setCookiepre(String cookiepre) {
		this.cookiepre = cookiepre;
	}
	public String getAuth() {
		return auth;
	}
	public void setAuth(String auth) {
		this.auth = auth;
	}
	public String getSaltkey() {
		return saltkey;
	}
	public void setSaltkey(String saltkey) {
		this.saltkey = saltkey;
	}
	public String getMember_username() {
		return member_username;
	}
	public void setMember_username(String member_username) {
		this.member_username = member_username;
	}
	public String getGroupid() {
		return groupid;
	}
	public void setGroupid(String groupid) {
		this.groupid = groupid;
	}
	public String getFormhash() {
		return formhash;
	}
	public void setFormhash(String formhash) {
		this.formhash = formhash;
	}
	public String getIsmoderator() {
		return ismoderator;
	}
	public void setIsmoderator(String ismoderator) {
		this.ismoderator = ismoderator;
	}
	public String getReadccess() {
		return readccess;
	}
	public void setReadccess(String readccess) {
		this.readccess = readccess;
	}
	
	public Notice getNotice() {
		return notice;
	}
	public void setNotice(Notice notice) {
		this.notice = notice;
	}
	public String getMember_uid() {
		return member_uid;
	}
	public void setMember_uid(String member_uid) {
		this.member_uid = member_uid;
	}
	public String getCode() {
		return code;
	}
	public void setCode(String code) {
		this.code = code;
	}
	public ArrayList<CountryInfo> getTypeid_arr() {
		return typeid_arr;
	}
	public void setTypeid_arr(ArrayList<CountryInfo> typeid_arr) {
		this.typeid_arr = typeid_arr;
	}
	public String getFid() {
		return fid;
	}
	public void setFid(String fid) {
		this.fid = fid;
	}
	public ArrayList<DiscussListInfo> getPostlist() {
		return postlist;
	}
	public void setPostlist(ArrayList<DiscussListInfo> postlist) {
		this.postlist = postlist;
	}
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getFavid() {
		return favid;
	}
	public void setFavid(String favid) {
		this.favid = favid;
	}
	public String getFavtimes() {
		return favtimes;
	}
	public void setFavtimes(String favtimes) {
		this.favtimes = favtimes;
	}
	public ArrayList<Message> getList() {
		return list;
	}
	public void setList(ArrayList<Message> list) {
		this.list = list;
	}
	public ArrayList<NoteMessage> getNotelist() {
		return notelist;
	}
	public void setNotelist(ArrayList<NoteMessage> notelist) {
		this.notelist = notelist;
	}
	public String getUploadavatar() {
		return uploadavatar;
	}
	public void setUploadavatar(String uploadavatar) {
		this.uploadavatar = uploadavatar;
	}
	public String getAvatar() {
		return avatar;
	}
	public void setAvatar(String avatar) {
		this.avatar = avatar;
	}
	public String getUsername() {
		return username;
	}
	public void setUsername(String username) {
		this.username = username;
	}
	public String getEmail() {
		return email;
	}
	public void setEmail(String email) {
		this.email = email;
	}
	public String getUid() {
		return uid;
	}
	public void setUid(String uid) {
		this.uid = uid;
	}
	public String getLevel() {
		return level;
	}
	public void setLevel(String level) {
		this.level = level;
	}
	public String getRegdate() {
		return regdate;
	}
	public void setRegdate(String regdate) {
		this.regdate = regdate;
	}
	public String getRealname() {
		return realname;
	}
	public void setRealname(String realname) {
		this.realname = realname;
	}
	public String getGender() {
		return gender;
	}
	public void setGender(String gender) {
		this.gender = gender;
	}
	public String getBirthyear() {
		return birthyear;
	}
	public void setBirthyear(String birthyear) {
		this.birthyear = birthyear;
	}
	public String getBirthmonth() {
		return birthmonth;
	}
	public void setBirthmonth(String birthmonth) {
		this.birthmonth = birthmonth;
	}
	public String getBirthday() {
		return birthday;
	}
	public void setBirthday(String birthday) {
		this.birthday = birthday;
	}
	public String getTelephone() {
		return telephone;
	}
	public void setTelephone(String telephone) {
		this.telephone = telephone;
	}
	public String getNationality() {
		return nationality;
	}
	public void setNationality(String nationnality) {
		this.nationality = nationnality;
	}
	public String getOccupation() {
		return occupation;
	}
	public void setOccupation(String occupation) {
		this.occupation = occupation;
	}
	public String getCredits() {
		return credits;
	}
	public void setCredits(String credits) {
		this.credits = credits;
	}
	public String getMobile() {
		return mobile;
	}
	public void setMobile(String mobile) {
		this.mobile = mobile;
	}
	public ArrayList<CountryInfo> getNationlist() {
		return nationlist;
	}
	public void setNationlist(ArrayList<CountryInfo> nationlist) {
		this.nationlist = nationlist;
	}
	public ArrayList<SearchHotInfo> getHotsearch() {
		return hotsearch;
	}
	public void setHotsearch(ArrayList<SearchHotInfo> hotsearch) {
		this.hotsearch = hotsearch;
	}
	public VersionInfo getApp_version() {
		return app_version;
	}
	public void setApp_version(VersionInfo app_version) {
		this.app_version = app_version;
	}
	public ArrayList<ImagesInfo> getAd_list() {
		return ad_list;
	}
	public void setAd_list(ArrayList<ImagesInfo> ad_list) {
		this.ad_list = ad_list;
	}
	public String getWelcome() {
		return welcome;
	}
	public void setWelcome(String welcome) {
		this.welcome = welcome;
	}
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}
	public String getMessage() {
		return message;
	}
	public void setMessage(String message) {
		this.message = message;
	}
	public String getPhonecode() {
		return phonecode;
	}
	public void setPhonecode(String phonecode) {
		this.phonecode = phonecode;
	}
	public String getDays() {
		return days;
	}
	public void setDays(String days) {
		this.days = days;
	}
	public String getMdays() {
		return mdays;
	}
	public void setMdays(String mdays) {
		this.mdays = mdays;
	}
	public String getLasted() {
		return lasted;
	}
	public void setLasted(String lasted) {
		this.lasted = lasted;
	}
	public String getHas_sign() {
		return has_sign;
	}
	public void setHas_sign(String has_sign) {
		this.has_sign = has_sign;
	}
	public String getTotalpage() {
		return totalpage;
	}
	public void setTotalpage(String totalpage) {
		this.totalpage = totalpage;
	}
	public String getPage() {
		return page;
	}
	public void setPage(String page) {
		this.page = page;
	}
	public String getPpp() {
		return ppp;
	}
	public void setPpp(String ppp) {
		this.ppp = ppp;
	}
	public String getTid() {
		return tid;
	}
	public void setTid(String tid) {
		this.tid = tid;
	}
	public String getPid() {
		return pid;
	}
	public void setPid(String pid) {
		this.pid = pid;
	}
	public String getTw() {
		return tw;
	}
	public void setTw(String tw) {
		this.tw = tw;
	}
	
}
