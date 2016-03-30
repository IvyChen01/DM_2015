package com.trassion.newstop.controller;

import java.util.Map;

import android.content.Context;

import com.trassion.newstop.config.Configurations;
import com.trassion.newstop.http.parse.HttpTransAgent;

public class NewsTopInfoListRequest implements INewsTopInfoListRequest{
	
	private Context mContext;

	public NewsTopInfoListRequest(Context context) {
		this.mContext = context;
	}
    /**
     * ��ȡ��Ŀ
     */
	@Override
	public void getNewsTopListByChannelRequest(HttpTransAgent handle,String imei,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_CHILIDMODEL+"&imei="+imei;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
    /**
     * ��ȡָ����Ŀ����
     */
	@Override
	public void getNewsTopListByModelRequest(HttpTransAgent handle,
			String imei, String page, String pagesize, String channel, int msgId) {
		String  requestUrl;
		String res=" ";
		String channelInfo = channel.replace(res, "%20");
		if(channel.equals("Recommend")){
		   requestUrl=Configurations.URL_NEWSTOP_MODEL_RECENTNEWS_LIST+"&imei="+imei+"&page="+page+"&pagesize="+pagesize;
		}else{
		   requestUrl = Configurations.URL_NEWSTOP_MODEL_NAME_LIST+"&imei="+imei+"&page="+page+"&pagesize="+pagesize+"&channel="+channelInfo;
		}
		  handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ��ȡָ����Ŀ��������
	 */
	@Override
	public void getNewsTopListByCommentRequest(HttpTransAgent handle,String imei,String page, String pagesize,String newsId,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_COMMENT+"&imei="+imei+"&page="+page+"&pagesize="+pagesize+"&newsId="+newsId;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ������������
	 */
	@Override
	public void getNewsTopListBySendCommentRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String content,String newsId,int msgId) {
		
		String res=" ";
		String c = content.replace(res, "%20");
		String requestUrl = Configurations.URL_NEWSTOP_SEND_COMMENT+"&imei="+imei+"&newsId="+newsId+"&auth="+auth+"&saltkey="+saltkey+"&content="+c;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ע��
	 * @param handle
	 * @param imei
	 * @param msgId
	 */
	@Override
	public void getNewsTopListByRegisterRequest(HttpTransAgent handle,String imei,String verify,String username,String password,String email,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_REGISTER+"&imei="+imei+"&verify="+verify+"&username="+username+"&password="+password+"&email="+email;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ��¼
	 */
	@Override
	public void getNewsTopListByLoginRequest(HttpTransAgent handle,String imei,String username,String password,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_LOGIN+"&imei="+imei+"&username="+username+"&password="+password;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �һ�����
	 */
	@Override
	public void getNewsTopListByFindPasswordRequest(HttpTransAgent handle,String imei,String username,String verify,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_FIND_PASSWORD+"&imei="+imei+"&username="+username+"&verify="+verify;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �޸�����
	 */
	@Override
	public void getNewsTopListByChangePasswordRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String srcPassword,String newPassword,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_CHANGE_PASSWORD+"&imei="+imei+"&auth="+auth+"&saltkey="+saltkey+"&srcPassword="+srcPassword+"&newPassword="+newPassword;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �޸��ǳ�
	 */
	@Override
	public void getNewsTopListByChangeNickRequest(HttpTransAgent handle,String imei,String nick,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_CHANGE_NICK+"&imei="+imei+"&nick="+nick;
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �޸�ǩ��
	 */
	@Override
	public void getNewsTopListByChangeSignatureRequest(HttpTransAgent handle,String imei,String signature,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_CHANGE_SIGNATURE+"&imei="+imei+"&signature="+signature;
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �޸�����
	 */
	@Override
	public void getNewsTopListByChangeEmailRequest(HttpTransAgent handle,String imei,String email,String auth,String saltkey,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_CHANGE_EMAIL+"&imei="+imei+"&email="+email+"&auth="+auth+"&saltkey="+saltkey;
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �޸��ֻ�
	 */
	@Override
	public void getNewsTopListByChangePhoneRequest(HttpTransAgent handle,String imei,String phone,String auth,String saltkey,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_CHANGE_PHONE+"&imei="+imei+"&phone="+phone+"&auth="+auth+"&saltkey="+saltkey;
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	
	/**
	 * �˳�
	 */
	@Override
	public void getNewsTopListByLoginOutRequest(HttpTransAgent handle,String imei,String auth,String saltkey,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_LOGIN_OUT+"&imei="+imei+"&auth="+auth+"&saltkey="+saltkey;
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ����
	 */
	@Override
	public void getNewsTopListByAddCommentRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String commentId,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_ADD_LIKE+"&imei="+imei+"&auth="+auth+"&saltkey="+saltkey+"&commentId="+commentId;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �ղ�����
	 */
	@Override
	public void getNewsTopListByCollectNewsRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String newsId,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_COLLECT_NEWS+"&imei="+imei+"&newsId="+newsId+"&auth="+auth+"&saltkey="+saltkey;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ȡ���ղ�����
	 */
	@Override
	public void getNewsTopListByCancelCollectNewsRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String newsId,int msgId) {
		
		String requestUrl = Configurations.URL_NEWSTOP_CANCLE_COLLECT_NEWS+"&imei="+imei+"&newsId="+newsId+"&auth="+auth+"&saltkey="+saltkey;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * ��ȡ�ղ������б�
     */
	@Override
	public void getNewsTopListByGetCollectNewsTopRequest(HttpTransAgent handle,String imei, String page, String pagesize, String auth,String saltkey, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_GET_COLLECT_NEWSTOP+"&imei="+imei+"&page="+page+"&pagesize="+pagesize+"&auth="+auth+"&saltkey="+saltkey;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * ��ȡ���۹������
     */
	@Override
	public void getNewsTopListByMyCommentNewsTopRequest(HttpTransAgent handle,String imei, String page, String pagesize, String auth,String saltkey, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_MYCOMMENTS_NEWSTOP+"&imei="+imei+"&page="+page+"&pagesize="+pagesize+"&auth="+auth+"&saltkey="+saltkey;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * ��ȡϵͳ��Ϣ
     */
	@Override
	public void getNewsTopListByGetSystemMessageRequest(HttpTransAgent handle,String imei, String page, String pagesize, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_SYSTEM_MESSAGE+"&imei="+imei+"&page="+page+"&pagesize="+pagesize;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * ����
     */
	@Override
	public void getNewsTopListBySearchRequest(HttpTransAgent handle,
			String imei, String keywords, String page,String pagesize,int msgId) {
		String  requestUrl;
		String res=" ";
		String key = keywords.replace(res, "%20");
		   requestUrl=Configurations.URL_NEWSTOP_SEARCH+"&imei="+imei+"&page="+page+"&pagesize="+pagesize+"&keywords="+key;
		  
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ��ȡFAQ
	 */
	@Override
	public void getNewsTopListByGETFAQRequest(HttpTransAgent handle,String imei,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_GET_FAQ+"&imei="+imei;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * ��ȡ��������
     */
	@Override
	public void getNewsTopListByFeedbackNewsTopRequest(HttpTransAgent handle,String imei,String auth,String saltkey, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_GET_FEEDBACK+"&imei="+imei+"&auth="+auth+"&saltkey="+saltkey;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
     * �ύ��������
     */
	@Override
	public void getNewsTopListByAddFeedbackNewsTopRequest(HttpTransAgent handle,String imei,String auth,String saltkey,String content,String image, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_ADD_FEEDBACK+"&imei="+imei+"&auth="+auth+"&saltkey="+saltkey+"&content="+content+"&image="+image;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * ���°汾
	 */
	@Override
	public void getNewsTopListByGetVersionRequest(HttpTransAgent handle,String imei,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_GET_VERSION+"&imei="+imei;
		
		handle.sendRequst(requestUrl, msgId, true,null);
	}
	/**
	 * �����ϴ�ͼƬ
	 */
	@Override
	public void getNewsTopListUpLoadmageRequest(HttpTransAgent handle,String imei,Map<String, String> params,int msgId) {
		String requestUrl = Configurations.URL_NEWSTOP_UPLOAD+"&imei="+imei;
		
		handle.sendRequstMap(requestUrl, msgId, params);
	}
	/**
     * ��ȡ�ղ������б�
     */
	@Override
	public void getNewsTopListByLoginTypeNewsTopRequest(HttpTransAgent handle,String imei, String id, String name, String photo,String sign, int msgId) {
		
		String  requestUrl=Configurations.URL_NEWSTOP_LOGIN_TYPE+"&imei="+imei+"&id="+id+"&name="+name+"&photo="+photo+"&sign="+sign;
		 
		   handle.sendRequst(requestUrl, msgId, true,null);
	}

}
