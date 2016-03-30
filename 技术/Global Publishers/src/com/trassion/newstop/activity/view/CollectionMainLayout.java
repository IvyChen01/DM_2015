package com.trassion.newstop.activity.view;

import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.activity.NewsContentActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.MyFeedAdapter;
import com.trassion.newstop.adapter.NewsAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.News;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.MyFoodListView;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;

public class CollectionMainLayout extends LinearLayout implements IAppLayout,UICallBackInterface{

	private View rootView;
	private MyFoodListView listView;
	private Context context;
	
	private ArrayList<News> moreNews=new ArrayList<News>();
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private NewsTopModelBeanresponse response;
	private NewsAdapter mAdapter;
	public  final static String SER_KEY = "com.trassion.newstop.fragment"; 
	private NewsInfo news;
	private String jsonStr;

	public CollectionMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public CollectionMainLayout(Context context) {
		super(context);
		this.context=context;
		LayoutInflater mLayoutInflater = LayoutInflater.from(context);
		// ��Ĭ�ϲ��ּ��ص�View����
		rootView = mLayoutInflater.inflate(R.layout.collection_main, this, true);
		
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context, CollectionMainLayout.this);
		
		auth=PreferenceUtils.getPrefString(context, "auth", "");
		saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
	    
		initView();
		initData();
		initListener();
	}

	@Override
	public void initView() {
		
		 jsonStr = FileCache.getCachePostList("collection");
		
		listView=(MyFoodListView)findViewById(R.id.listView);
		
		
	}

	@Override
	public void initData() {
		
			requestCollecttionNewsTop();
		
	}
     
	private void requestCollecttionNewsTop() {
		if (NetworkUtil.isOnline(context)) {
				
			mHttpAgent.isShowProgress = false;
			NewsApplication.modelName="collection";
			request.getNewsTopListByGetCollectNewsTopRequest(mHttpAgent, Utils.getPhoneIMEI(context), "1", "20",auth,saltkey, Constants.HTTP_GET_COLLECT_NEWS );
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			if (!jsonStr.equals("")) {
				initCollectAd();
			}
		}
		
	}
	private void initCollectAd() {
		JavaBean bean = JSON.parseObject(jsonStr,NewsTopModelBeanresponse.class);
		
		response=(NewsTopModelBeanresponse)bean;
		
		 if(mAdapter == null){
			 mAdapter = new NewsAdapter(context, response.getData());
		 }
		 listView.setAdapter(mAdapter);
		
	}
	@Override
	public void initListener() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onResume() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPause() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopModelBeanresponse)bean;
			   if(mAdapter == null){
				  mAdapter = new NewsAdapter(context, response.getData());
			}
			     listView.setAdapter(mAdapter);
		}
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		mHttpAgent.isShowProgress = false;
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			
		}else{
			ToastManager.showLong(context, R.string.common_cannot_connect);
		}

		
	}

}
