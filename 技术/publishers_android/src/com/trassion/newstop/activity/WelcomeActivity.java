package com.trassion.newstop.activity;


import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.ChannelItem;
import com.trassion.newstop.bean.ChannelManage;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.ChannelBeanresponse;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.Utils;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.view.animation.Animation.AnimationListener;
import android.widget.Toast;

public class WelcomeActivity extends BaseActivity implements UICallBackInterface{

	private AlphaAnimation start_anima;
	private View view;
	
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}
	@Override
	public void setContentView() {
		view = View.inflate(this, R.layout.welcome, null);
		setContentView(view);
	}

	@Override
	public void initWidget() {
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this, this);
		
		requestNewsList();
	}

	@Override
	public void initData() {
		
	}
	private void requestNewsList() {
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = false;
			NewsApplication.modelName="ChanelModel";
			request.getNewsTopListByChannelRequest(mHttpAgent,Utils.getPhoneIMEI(this),Constants.HTTP_GET_CHANNEL_ID);
		} else {
            String jsonStr = FileCache.getCachePostList("ChanelModel");
			
			if (!jsonStr.equals("")) {
				JavaBean bean = JSON.parseObject(jsonStr,ChannelBeanresponse.class);
				
				ChannelBeanresponse response=(ChannelBeanresponse)bean;
				ChannelManage.initChannelItem(response.getData());
				StartMainActivity();
			}
		}
	}
	public void StartMainActivity(){
		start_anima = new AlphaAnimation(0.3f, 1.0f);
		start_anima.setDuration(2000);
		view.startAnimation(start_anima);
		start_anima.setAnimationListener(new AnimationListener() {
			
			@Override
			public void onAnimationStart(Animation animation) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void onAnimationRepeat(Animation animation) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void onAnimationEnd(Animation animation) {
				// TODO Auto-generated method stub
				redirectTo();
			}
		});
	}
	private void redirectTo() {
		startActivity(new Intent(getApplicationContext(), MainActivity.class));
		finish();
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			ChannelBeanresponse response=(ChannelBeanresponse)bean;
			ChannelManage.initChannelItem(response.getData());
			StartMainActivity();
		}
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			Toast.makeText(WelcomeActivity.this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}
	
}
