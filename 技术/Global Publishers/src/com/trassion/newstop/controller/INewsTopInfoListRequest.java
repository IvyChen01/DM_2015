package com.trassion.newstop.controller;

import java.util.Map;

import com.trassion.newstop.http.parse.HttpTransAgent;


public interface INewsTopInfoListRequest {
	
	
	/**
	 * 获取所有栏目名称
	 * @param handle
	 */
	public void getNewsTopListByChannelRequest(HttpTransAgent handle,String imei,int msgId);
	/**
	 * 获取所有栏目名称
	 * @param handle
	 */
	public void getNewsTopListByModelRequest(HttpTransAgent handle,String imei,String page,String pagesize,String channel,int msgId);
	/**
	 * 获取新闻评论
	 * @param handle
	 */
	public void getNewsTopListByCommentRequest(HttpTransAgent handle,String imei,String page,String pagesize,String newsId,int msgId);
	/**
	 * 注册
	 * @param handle
	 */
	public void getNewsTopListByRegisterRequest(HttpTransAgent handle,String imei,String verify,String username,String password,String email,int msgId);
    /**
     * 登录
     * @param handle
     * @param imei
     * @param username
     * @param password
     * @param msgId
     */
	public void getNewsTopListByLoginRequest(HttpTransAgent handle,String imei,String username,String password,int msgId);
	
	/**
	 * 修改昵称
	 * @param handle
	 * @param imei
	 * @param nick
	 * @param msgId
	 */
	public void getNewsTopListByChangeNickRequest(HttpTransAgent handle,String imei,String nick,int msgId);
	
	/**
	 * 修改签名
	 * @param handle
	 * @param imei
	 * @param singature
	 * @param msgId
	 */
	public void getNewsTopListByChangeSignatureRequest(HttpTransAgent handle,String imei, String singature, int msgId);
	
	/**
	 * 修改邮箱
	 * @param handle
	 * @param imei
	 * @param email
	 * @param msgId
	 */
	public void getNewsTopListByChangeEmailRequest(HttpTransAgent handle, String imei,String email,String auth,String saltkey, int msgId);
     
	/**
	 * 修改手机
	 * @param handle
	 * @param imei
	 * @param phone
	 * @param auth
	 * @param saltkey
	 * @param msgId
	 */
	public void getNewsTopListByChangePhoneRequest(HttpTransAgent handle, String imei,String phone, String auth, String saltkey, int msgId);
	
	/**
	 * 退出
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param msgId
	 */
	public void getNewsTopListByLoginOutRequest(HttpTransAgent handle, String imei,String auth, String saltkey, int msgId);
	
	/**
	 * 发送评论
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param newsId
	 * @param msgId
	 */
	public void getNewsTopListBySendCommentRequest(HttpTransAgent handle, String imei,String auth, String saltkey, String newsId,String content, int msgId);
	
	/**
	 * 点赞
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param commentId
	 * @param msgId
	 */
	public void getNewsTopListByAddCommentRequest(HttpTransAgent handle, String imei,String auth, String saltkey, String commentId, int msgId);
	
	/**
	 * 收藏新闻
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param newsId
	 * @param msgId
	 */
	public void getNewsTopListByCollectNewsRequest(HttpTransAgent handle, String imei,String auth, String saltkey, String newsId, int msgId);
	
	/**
	 * 获取收藏新闻列表
	 * @param handle
	 * @param imei
	 * @param page
	 * @param pagesize
	 * @param auth
	 * @param saltkey
	 * @param msgId
	 */
	public void getNewsTopListByGetCollectNewsTopRequest(HttpTransAgent handle,String imei, String page, String pagesize, String auth,String saltkey, int msgId);
	
	/**
	 * 获取评论过的新闻
	 * @param handle
	 * @param imei
	 * @param page
	 * @param pagesize
	 * @param auth
	 * @param saltkey
	 * @param msgId
	 */
	public void getNewsTopListByMyCommentNewsTopRequest(HttpTransAgent handle,String imei, String page, String pagesize, String auth,String saltkey, int msgId);
	
	/**
	 * 取消收藏新闻
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param newsId
	 * @param msgId
	 */
	public void getNewsTopListByCancelCollectNewsRequest(HttpTransAgent handle,String imei, String auth, String saltkey, String newsId, int msgId);
	
	/**
	 * 修改密码
	 * @param handle
	 * @param imei
	 * @param srcPassword
	 * @param newPassword
	 * @param msgId
	 */
	public void getNewsTopListByChangePasswordRequest(HttpTransAgent handle,String imei, String auth, String saltkey, String srcPassword,String newPassword, int msgId);
	
	/**
	 * 找回密码
	 * @param handle
	 * @param imei
	 * @param username
	 * @param verify
	 * @param msgId
	 */
	public void getNewsTopListByFindPasswordRequest(HttpTransAgent handle,String imei, String username, String verify, int msgId);
	
	/**
	 * 获取系统消息
	 * @param handle
	 * @param imei
	 * @param page
	 * @param pagesize
	 * @param msgId
	 */
	public void getNewsTopListByGetSystemMessageRequest(HttpTransAgent handle,String imei, String page, String pagesize, int msgId);
	
	/**
	 * 搜索
	 * @param handle
	 * @param imei
	 * @param keywords
	 * @param page
	 * @param pagesize
	 * @param msgId
	 */
	public void getNewsTopListBySearchRequest(HttpTransAgent handle, String imei,String keywords, String page, String pagesize, int msgId);
	
	/**
	 * 获取FAQ
	 * @param handle
	 * @param imei
	 * @param msgId
	 */
	public void getNewsTopListByGETFAQRequest(HttpTransAgent handle, String imei,int msgId);
	
	/**
	 * 获取反馈内容
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param msgId
	 */
	public void getNewsTopListByFeedbackNewsTopRequest(HttpTransAgent handle,String imei, String auth, String saltkey, int msgId);
	
	/**
	 * 提交反馈
	 * @param handle
	 * @param imei
	 * @param auth
	 * @param saltkey
	 * @param content
	 * @param msgId
	 */
	public void getNewsTopListByAddFeedbackNewsTopRequest(HttpTransAgent handle,String imei, String auth, String saltkey, String content,String image, int msgId);
	
	/**
	 * 获取版本号
	 * @param handle
	 * @param imei
	 * @param msgId
	 */
	public void getNewsTopListByGetVersionRequest(HttpTransAgent handle, String imei,int msgId);
	
	/**
	 * 上传图片
	 * @param handle
	 * @param params
	 * @param msgId
	 */
	public void getNewsTopListUpLoadmageRequest(HttpTransAgent handle,String imei,Map<String, String> params, int msgId);
	
	/**
	 * facebook登录
	 * @param handle
	 * @param imei
	 * @param id
	 * @param name
	 * @param photo
	 * @param sign
	 * @param msgId
	 */
	public void getNewsTopListByLoginTypeNewsTopRequest(HttpTransAgent handle,String imei, String id, String name, String photo, String sign,
			int msgId);
}
