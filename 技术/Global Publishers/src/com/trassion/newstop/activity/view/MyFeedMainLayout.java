package com.trassion.newstop.activity.view;

import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.MyFeedAdapter;
import com.trassion.newstop.adapter.NewsAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.bean.response.NewsTopMyCommentBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.MyFoodListView;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.Toast;

public class MyFeedMainLayout extends LinearLayout implements IAppLayout,UICallBackInterface{

	private View rootView;
	private MyFoodListView listView;
	
    private Context context;
	private ArrayList<Myfeed> mFeeds=new ArrayList<Myfeed>();
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private NewsTopModelBeanresponse response;
	private String jsonStr;
	private MyFeedAdapter adapter;

	public MyFeedMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public MyFeedMainLayout(Context context) {
		super(context);
		this.context=context;
		LayoutInflater mLayoutInflater = LayoutInflater.from(context);
		// 将默认布局加载到View里面
		rootView = mLayoutInflater.inflate(R.layout.my_feed_main, this, true);
	    
		initView();
		initData();
		initListener();
	}

	@Override
	public void initView() {
		listView=(MyFoodListView)findViewById(R.id.listView);
		jsonStr = FileCache.getCachePostList("myfeed");
		
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context, MyFeedMainLayout.this);
		
		auth=PreferenceUtils.getPrefString(context, "auth", "");
		saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
		
	}

	@Override
	public void initData() {
		
		requestMyCommentsNewsTop();
		
	}

	private void requestMyCommentsNewsTop() {
		if (NetworkUtil.isOnline(context)) {
			mHttpAgent.isShowProgress = false;
			NewsApplication.modelName="myfeed";
//			if (!jsonStr.equals("")) {
//				initMyFeedAd();
//			}
			
			request.getNewsTopListByMyCommentNewsTopRequest(mHttpAgent, Utils.getPhoneIMEI(context), "1", "20",auth,saltkey, Constants.HTTP_GET_MYCOMMENT_NEWS );
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			if (!jsonStr.equals("")) {
				initMyFeedAd();
			}
		}
		
	}
	private void initMyFeedAd() {
		
        JavaBean bean = JSON.parseObject(jsonStr,NewsTopModelBeanresponse.class);
		response=(NewsTopModelBeanresponse)bean;
		
		 adapter=new MyFeedAdapter(context,response.getData(),false);
		 listView.setAdapter(adapter);
		 Utils.setListViewHeightBasedOnChildren(listView);
		
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
//			if(!jsonStr.equals("")){
//				adapter.notifyChanged(response.getData());
//			}else{
			   adapter=new MyFeedAdapter(context,response.getData(),false);
			   listView.setAdapter(adapter);
			   Utils.setListViewHeightBasedOnChildren(listView);
//			}
		}
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
		
	}

}
