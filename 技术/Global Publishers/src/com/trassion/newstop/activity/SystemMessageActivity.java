package com.trassion.newstop.activity;

import java.util.ArrayList;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.adapter.MyFeedAdapter;
import com.trassion.newstop.adapter.SystemMessageAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Message;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.bean.response.NewsTopSystemMessageBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.content.Intent;
import android.graphics.Typeface;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class SystemMessageActivity extends BaseActivity implements UICallBackInterface{

	private ListView listView;

	private TextView title;

	private NewsTopInfoListRequest request;

	private HttpTransAgent mHttpAgent;

	private NewsTopSystemMessageBeanresponse response;

	private String jsonStr;

	private SystemMessageAdapter adapter;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_system_message);
		
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);

	}

	@Override
	public void initWidget() {
		listView=(ListView)findViewById(R.id.listView);
		jsonStr = FileCache.getCachePostList("systemMessage");
		title=(TextView)findViewById(R.id.title);
		
		
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		title.setText("System Message");

	}

	@Override
	public void initData() {
		
		requestSystemMessage();

	}
	private void requestSystemMessage() {
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			NewsApplication.modelName="systemMessage";
			request.getNewsTopListByGetSystemMessageRequest(mHttpAgent, Utils.getPhoneIMEI(this), "1", "10000", Constants.HTTP_GET_SYSTEM_MESSAGE );
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			initSystemAd();
		}
		
	}

	private void initSystemAd() {
       JavaBean bean = JSON.parseObject(jsonStr,NewsTopSystemMessageBeanresponse.class);
		
		response=(NewsTopSystemMessageBeanresponse)bean;
		if(adapter==null){
		 adapter=new SystemMessageAdapter(this,response.getData());
		}
		 listView.setAdapter(adapter);
		 Utils.setListViewHeightBasedOnChildren(listView);
		
	}

	@Override
	public void onBackPressed() {
			Intent intent = new Intent(getApplicationContext(), MainActivity.class);
			setResult(MainActivity.CHANNELRESULT, intent);
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		mHttpAgent.isShowProgress = false;
		if(bean!=null){
			response=(NewsTopSystemMessageBeanresponse)bean;
			
			adapter=new SystemMessageAdapter(this,response.getData());
			listView.setAdapter(adapter);	
		}
		
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		mHttpAgent.isShowProgress = false;
		
        if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			ToastManager.showLong(this, R.string.common_cannot_connect);
		}
		
	}

}
