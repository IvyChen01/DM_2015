package com.trassion.newstop.config;

import com.trassion.newstop.tool.Constants;

public class Configurations {
	
	/**
	 * ��ȡ������Ŀ���
	 */
	public static final String URL_NEWSTOP_CHILIDMODEL=Constants.HOT+"?m=news&a=getChannel";
	/**
	 * ��ȡģ������
	 */
	public static final String URL_NEWSTOP_MODEL_NAME_LIST=Constants.HOT+"?m=news&a=getChannelNews";
	/**
	 * ��ȡ��������
	 */
	public static final String URL_NEWSTOP_MODEL_RECENTNEWS_LIST=Constants.HOT+"?m=news&a=getRecentNews";
	/**
	 * ��ȡ����
	 */
	public static final String URL_NEWSTOP_COMMENT=Constants.HOT+"?m=news&a=getComment";
	/**
	 * ��������
	 */
	public static final String URL_NEWSTOP_SEND_COMMENT=Constants.HOT+"?m=news&a=addComment";
	/**
	 * ע��
	 */
	public static final String URL_NEWSTOP_REGISTER=Constants.HOT+"?m=user&a=register";
	/**
	 * ��¼
	 */
	public static final String URL_NEWSTOP_LOGIN=Constants.HOT+"?m=user&a=login";
	/**
	 * ��ȡ��֤��
	 */
	public static final String URL_NEWSTOP_REGISTER_CODE=Constants.HOT+"?m=user&a=verify";
	/**
	 * �޸��ǳ�
	 */
	public static final String URL_NEWSTOP_CHANGE_NICK=Constants.HOT+"?m=user&a=setNick";
	/**
	 * �޸�ǩ��
	 */
	public static final String URL_NEWSTOP_CHANGE_SIGNATURE=Constants.HOT+"?m=user&a=setSignature";
	/**
	 * �޸�����
	 */
	public static final String URL_NEWSTOP_CHANGE_EMAIL=Constants.HOT+"?m=user&a=setEmail";
	/**
	 * �޸��ֻ�
	 */
	public static final String URL_NEWSTOP_CHANGE_PHONE=Constants.HOT+"?m=user&a=setPhone";
	/**
	 * �˳�
	 */
	public static final String URL_NEWSTOP_LOGIN_OUT=Constants.HOT+"?m=user&a=logout";
	/**
	 * �ϴ�ͷ��
	 */
	public static final String URL_NEWSTOP_UPLOAD_PHOTO=Constants.HOT+"?m=user&a=uploadPhoto";
	/**
	 * ����
	 */
	public static final String URL_NEWSTOP_ADD_LIKE=Constants.HOT+"?m=news&a=like";
	/**
	 * �ղ�
	 */
	public static final String URL_NEWSTOP_COLLECT_NEWS=Constants.HOT+"?m=news&a=collect";
	/**
	 * ȡ���ղ�
	 */
	public static final String URL_NEWSTOP_CANCLE_COLLECT_NEWS=Constants.HOT+"?m=news&a=uncollect";
	/**
	 * ��ȡ�ղ������б�
	 */
	public static final String URL_NEWSTOP_GET_COLLECT_NEWSTOP=Constants.HOT+"?m=news&a=getCollection";
	/**
	 * ��ȡ�ղ������б�
	 */
	public static final String URL_NEWSTOP_MYCOMMENTS_NEWSTOP=Constants.HOT+"?m=news&a=getMyComments";
	/**
	 * �޸�����
	 */
	public static final String URL_NEWSTOP_CHANGE_PASSWORD=Constants.HOT+"?m=user&a=changePassword";
	/**
	 * �һ�����
	 */
	public static final String URL_NEWSTOP_FIND_PASSWORD=Constants.HOT+"?m=user&a=resetPassword";
	/**
	 * ��ȡϵͳ��Ϣ
	 */
	public static final String URL_NEWSTOP_SYSTEM_MESSAGE=Constants.HOT+"?m=info&a=getSystemMessage";
	/**
	 * ����
	 */
	public static final String URL_NEWSTOP_SEARCH=Constants.HOT+"?m=news&a=search";
	/**
	 * ��ȡFAQ
	 */
	public static final String URL_NEWSTOP_GET_FAQ=Constants.HOT+"?m=info&a=getFaq";
	/**
	 * ��ȡ����
	 */
	public static final String URL_NEWSTOP_GET_FEEDBACK=Constants.HOT+"?m=info&a=getFeedback";
	/**
	 * ��ȡ����
	 */
	public static final String URL_NEWSTOP_ADD_FEEDBACK=Constants.HOT+"?m=info&a=setFeedback";
	/**
	 * ��ȡ�汾��
	 */
	public static final String URL_NEWSTOP_GET_VERSION=Constants.HOT+"?m=info&a=getVersion";
	/**
	 * �ϴ�ͼƬ
	 */
	public static final String URL_NEWSTOP_UPLOAD=Constants.HOT+"?m=info&a=uploadImage";
	/**
	 * �ϴ�ͼƬ
	 */
	public static final String URL_NEWSTOP_LOGIN_TYPE=Constants.HOT+"?m=user&a=fbLogin";
}
