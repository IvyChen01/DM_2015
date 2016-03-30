package com.trassion.newstop.activity;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopChangeNickBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.content.Intent;
import android.graphics.Typeface;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class NickNameActivity extends BaseActivity implements UICallBackInterface,OnClickListener{

	private TextView title;
	private TextView tvfinish;
	private TextView twoTitle;
	
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private EditText editName;
	private NewsTopChangeNickBeanresponse response;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_nickname);
        
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		editName=(EditText)findViewById(R.id.editName);
		
		title.setText("Nickname");
		tvfinish.setVisibility(View.VISIBLE);
		tvfinish.setText("DONE");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		twoTitle.setTypeface(type);
		
		tvfinish.setOnClickListener(this);

	}

	@Override
	public void initData() {
		// TODO Auto-generated method stub

	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		mHttpAgent.isShowProgress = false;
		if(bean!=null){
			response=(NewsTopChangeNickBeanresponse)bean;
			
			PreferenceUtils.setPrefString(this, "nick", response.getNick());
			
			Intent intent = new Intent();
			intent.putExtra("NICK", response.getNick());
			setResult(RESULT_OK, intent);
			
			onBackPressed();
			
		}
		
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			ToastManager.showLong(this, R.string.common_cannot_connect);
		}
		
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvfinish:
		 requestChangeUserName();
			break;

		default:
			break;
		}
		
	}

	private void requestChangeUserName() {
	  String username=editName.getText().toString();
		if(TextUtils.isEmpty(username)){
			ToastManager.showShort(this, "Please enter your nick");
			return;
		}
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByChangeNickRequest(mHttpAgent, Utils.getPhoneIMEI(this), username, Constants.HTTP_CHANGE_NICK);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}
}
