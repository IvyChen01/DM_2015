package com.trassion.newstop.activity.view;

import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.CommonProblemAdapter;
import com.trassion.newstop.adapter.SystemMessageAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Problem;
import com.trassion.newstop.bean.response.NewsTopFAQBeanresponse;
import com.trassion.newstop.bean.response.NewsTopSystemMessageBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.Toast;

public class CommonProblemMainLayout extends RelativeLayout implements IAppLayout,UICallBackInterface{

	private View rootView;
	private Context context;
	private ListView listView;
	private ArrayList<Problem>moreProblem=new ArrayList<Problem>();
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private NewsTopFAQBeanresponse response;
	private CommonProblemAdapter adapter;
	private String jsonStr;

	public CommonProblemMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public CommonProblemMainLayout(Context context) {
		super(context);
		this.context=context;
		LayoutInflater mLayoutInflater = LayoutInflater.from(context);
		// 将默认布局加载到View里面
		rootView = mLayoutInflater.inflate(R.layout.common_problem_main, this, true);
		
		initView();
		initData();
		initListener();
	}

	@Override
	public void initView() {
		listView=(ListView)findViewById(R.id.listView);
		jsonStr = FileCache.getCachePostList("commonProblem");
		
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context,CommonProblemMainLayout.this);
		
	}

	@Override
	public void initData() {
		resquestFAQ();
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
	private void resquestFAQ() {
		if (NetworkUtil.isOnline(context)) {
			mHttpAgent.isShowProgress = true;
			NewsApplication.modelName="commonProblem";
			request.getNewsTopListByGETFAQRequest(mHttpAgent, Utils.getPhoneIMEI(context),Constants.HTTP_GET_FAQ);
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			initFAQAd();
		}
		
	}
	private void initFAQAd() {
	       JavaBean bean = JSON.parseObject(jsonStr,NewsTopFAQBeanresponse.class);
			
			response=(NewsTopFAQBeanresponse)bean;
			if(adapter==null){
			 adapter=new CommonProblemAdapter(context,response.getData());
			}
			 listView.setAdapter(adapter);
		
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopFAQBeanresponse)bean;
			
			adapter=new CommonProblemAdapter(context, response.getData());
			listView.setAdapter(adapter);
			
		}
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			
		}else{
			ToastManager.showLong(context, R.string.common_cannot_connect);
		}
	}

}
