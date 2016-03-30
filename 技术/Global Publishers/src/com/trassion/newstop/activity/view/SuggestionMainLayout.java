package com.trassion.newstop.activity.view;

import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.FeedbackActivity;
import com.trassion.newstop.activity.LoginActivity;
import com.trassion.newstop.activity.MainActivity;
import com.trassion.newstop.activity.PostMessageActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.SystemMessageAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Message;
import com.trassion.newstop.bean.response.NewsTopFeedbackresBeanponse;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.bean.response.NewsTopSystemMessageBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.DateTools;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.XwScrollView;
import android.view.View.OnClickListener;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Handler;
import android.text.TextUtils;
import android.util.AttributeSet;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

public class SuggestionMainLayout extends RelativeLayout implements IAppLayout,OnClickListener,UICallBackInterface{

	private View rootView;
	private Context context;
	private XwScrollView scrollView;
	private LinearLayout linearLayout;
	
	private ArrayList<Message> moreMessage=new ArrayList<Message>();
	
	Handler handler = new Handler();
	
	private LayoutInflater mLayoutInflater;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private String jsonStr;
	private LinearLayout imgSend;
	private ImageLoader imageloader;
	private ImageManager imageManager;
	private boolean isLogin;

	public SuggestionMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public SuggestionMainLayout(Context context) {
		super(context);
		this.context=context;
		 mLayoutInflater = LayoutInflater.from(context);
		// ��Ĭ�ϲ��ּ��ص�View����
		rootView = mLayoutInflater.inflate(R.layout.suggestion_main, this, true);
		
		initView();
		initData();
		initListener();
	}

	@Override
	public void initView() {
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context, SuggestionMainLayout.this);
		
		jsonStr = FileCache.getCachePostList("suggestion");
		
		auth=PreferenceUtils.getPrefString(context, "auth", "");
		saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
		
		imageloader=ImageLoader.getInstance();
		imageManager=new ImageManager();
		
		scrollView = (XwScrollView) findViewById(R.id.xwScrollView_chat);
		linearLayout = (LinearLayout) findViewById(R.id.layout_message);
		imgSend=(LinearLayout)findViewById(R.id.imgSend);
		
		imgSend.setOnClickListener(this);
	}

	@Override
	public void initData() {
		isLogin=PreferenceUtils.getPrefBoolean(context, "isLogin", true);
		if(isLogin){
		requestFeedback();
		}else{
			Intent intent = new  Intent(context, LoginActivity.class);
			((Activity) context).startActivityForResult(intent, MainActivity.ACCOUNTREQUEST);
			((Activity) context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
		}
		handler.post(new Runnable() {

			@Override
			public void run() {

				try {
					int scrollViewHeight = scrollView.getHeight();
					int linearLayoutHeight = linearLayout.getHeight();
					if (linearLayoutHeight > scrollViewHeight) {
						scrollView.scrollTo(0, linearLayoutHeight
								- scrollViewHeight);
					}
				} catch (Exception e) {
					// TODO: handle exception
				}
			}
		});
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
	private void setViewData(String message,String time,String imgUrl, View view) {
//		String url=avatar.substring(avatar.indexOf("http"),avatar.indexOf("small") + 5);
		TextView tvText = (TextView)view.findViewById(R.id.tvMessage);
		
		TextView tvTime=(TextView)view.findViewById(R.id.tvTime);
		
		ImageView imgView=(ImageView)view.findViewById(R.id.imgView);
		
		if(imgUrl!=null&&!imgUrl.equals("")){
		   imageloader.displayImage(imgUrl, imgView, imageManager.mDisplayImageOption, imageManager.animateFirstListener);
		}
		
		tvText.setText(message);
		tvTime.setText(time);
		
		initMessageView();
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.imgSend:
			StartActivity(PostMessageActivity.class);
			break;

		default:
			break;
		}
		
	}
	private void requestFeedback() {
		if (NetworkUtil.isOnline(context)) {
			mHttpAgent.isShowProgress = true;
			NewsApplication.modelName="suggestion";
			request.getNewsTopListByFeedbackNewsTopRequest(mHttpAgent, Utils.getPhoneIMEI(context), auth, saltkey,Constants.HTTP_GET_FEEDBACK );
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			JavaBean bean = JSON.parseObject(jsonStr,NewsTopSystemMessageBeanresponse.class);
			initFeedbackAd(bean);
		}
		
	}
	private void initFeedbackAd(JavaBean bean) {
		View view;
        NewsTopFeedbackresBeanponse	response=(NewsTopFeedbackresBeanponse)bean;
		if(response.getData().size()>0){
			for(int i=0;i<response.getData().size();i++){
				if(response.getData().get(i).getFrom_id().equals("system")){
					 view = mLayoutInflater.inflate(R.layout.left, null);
					 linearLayout.addView(view);
					setViewData(response.getData().get(i).getContent(),response.getData().get(i).getFeedback_date(),response.getData().get(i).getImage(),view);
				}else{
					view = mLayoutInflater.inflate(R.layout.right, null);
					 linearLayout.addView(view);
					setViewData(response.getData().get(i).getContent(),response.getData().get(i).getFeedback_date(),response.getData().get(i).getImage(),view);
				}
			}
		}

	}
	private void requestAddFeedback() {
//		String content=editMessage.getText().toString();
		
//		if(TextUtils.isEmpty(content)){
//			ToastManager.showShort(context, "Please input the content of the feedback");
//			return;
//		}
		
//		if (NetworkUtil.isOnline(context)) {
//			mHttpAgent.isShowProgress = true;
//			request.getNewsTopListByAddFeedbackNewsTopRequest(mHttpAgent, Utils.getPhoneIMEI(context), auth, saltkey,content,Constants.HTTP_ADD_FEEDBACK );
//		} else {
//			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
//		}
		
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		mHttpAgent.isShowProgress = false;
		View view;
		if(bean!=null){
			if(msgId==Constants.HTTP_GET_FEEDBACK){
				initFeedbackAd(bean);
			}else if(msgId==Constants.HTTP_ADD_FEEDBACK){
				NewsTopRegisterBeanresponse response=(NewsTopRegisterBeanresponse)bean;
				if(response.getCode().equals("0")){
//					String message=editMessage.getText().toString();
//					 view = mLayoutInflater.inflate(R.layout.right, null);
//					linearLayout.addView(view);
//					setViewData(message,DateTools.getSystemCurrentTime(),view);
//					editMessage.setText("");
					initMessageView();
				}else{
					ToastManager.showShort(context, response.getMsg());
				}
				
			}
		}
		
	}
	
	
	private void initMessageView() {
		handler.post(new Runnable() {

			@Override
			public void run() {

				try {
					int scrollViewHeight = scrollView.getHeight();
					int linearLayoutHeight = linearLayout.getHeight();
					if (linearLayoutHeight > scrollViewHeight) {
						scrollView.scrollTo(0, linearLayoutHeight
								- scrollViewHeight);
					}
				} catch (Exception e) {
					// TODO: handle exception
				}
			}
		});
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		mHttpAgent.isShowProgress = false;
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			
		}else{
			ToastManager.showLong(context, R.string.common_cannot_connect);
		}
		
	}
	private void StartActivity(Class<? extends Activity> activity) {
		Intent intent = new  Intent(context, activity);
		((Activity) context).startActivityForResult(intent, FeedbackActivity.ACCOUNTREQUEST);
		((Activity) context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
		
	}

}
