package com.trassion.newstop.bean;

import com.trassion.newstop.bean.response.ChannelBeanresponse;
import com.trassion.newstop.bean.response.NewsTopAddCommentBeanresponse;
import com.trassion.newstop.bean.response.NewsTopChangeNickBeanresponse;
import com.trassion.newstop.bean.response.NewsTopChangeSignatureBeanresponse;
import com.trassion.newstop.bean.response.NewsTopCommentBeanresponse;
import com.trassion.newstop.bean.response.NewsTopCommentInfoBeanresponse;
import com.trassion.newstop.bean.response.NewsTopFAQBeanresponse;
import com.trassion.newstop.bean.response.NewsTopFeedbackresBeanponse;
import com.trassion.newstop.bean.response.NewsTopLoginBeanresponse;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.bean.response.NewsTopMyCommentBeanresponse;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.bean.response.NewsTopSystemMessageBeanresponse;
import com.trassion.newstop.bean.response.NewsTopVersionBeanresponse;
import com.trassion.newstop.tool.Constants;





public class BeanFactory {

	private static BeanFactory instance = new BeanFactory();

	private BeanFactory() {

	}

	public static BeanFactory getInstance() {
		return instance;
	}

	public JavaBean productionBean(int msgId) {
		JavaBean bean = null;
		switch (msgId) {
		case Constants.HTTP_GET_CHANNEL_ID:
			bean = new ChannelBeanresponse();
			break;
		case Constants.HTTP_GET_MODEL_ID:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_GET_COMMENT:
			bean=new NewsTopCommentBeanresponse();
			break;
		case Constants.HTTP_GET_REGISTER:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_LOGIN:
			bean=new NewsTopLoginBeanresponse();
			break;
		case Constants.HTTP_CHANGE_NICK:
			bean=new NewsTopChangeNickBeanresponse();
			break;
		case Constants.HTTP_CHANGE_SIGNATURE:
			bean=new NewsTopChangeSignatureBeanresponse();
			break;
		case Constants.HTTP_CHANGE_EMAIL:
			bean=new NewsTopChangeSignatureBeanresponse();
			break;
		case Constants.HTTP_CHANGE_PHONE:
			bean=new NewsTopChangeSignatureBeanresponse();
			break;
		case Constants.HTTP_LOGIN_OUT:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_SEND_COMMENT:
			bean=new NewsTopAddCommentBeanresponse();
			break;
		case Constants.HTTP_ADD_LIKE:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_COLLECT_NEWS:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_COLLECT_NEWS:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_CANCAL_COLLECT_NEWS:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_MYCOMMENT_NEWS:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_CANCAL_CHANGE_PASSWORD:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_CANCAL_FIND_PASSWORD:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_SYSTEM_MESSAGE:
			bean=new NewsTopSystemMessageBeanresponse();
			break;
		case Constants.HTTP_GET_SEARCH:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_GET_FAQ:
			bean=new NewsTopFAQBeanresponse();
			break;
		case Constants.HTTP_GET_FEEDBACK:
			bean=new NewsTopFeedbackresBeanponse();
			break;
		case Constants.HTTP_ADD_FEEDBACK:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_MORE_MODEL_ID:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_GET_NEW_MODEL_ID:
			bean=new NewsTopModelBeanresponse();
			break;
		case Constants.HTTP_GET_MORE_COMMENT:
			bean=new NewsTopCommentBeanresponse();
			break;
		case Constants.HTTP_GET_VERSION:
			bean=new NewsTopVersionBeanresponse();
			break;
		case Constants.HTTP_UPLOAD_IMAGE:
			bean=new NewsTopRegisterBeanresponse();
			break;
		case Constants.HTTP_GET_LOGIN_TYPE:
			bean=new NewsTopLoginBeanresponse();
			break;
		default:
			break;
		}
		return bean;
	}
}
