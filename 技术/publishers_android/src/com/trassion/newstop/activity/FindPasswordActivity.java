package com.trassion.newstop.activity;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.config.Configurations;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Typeface;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class FindPasswordActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView title;
	private TextView tvfinish;
	private TextView twoTitle;
	private String imgCodeUrl;
	private ImageLoader imageloader;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private ImageView imgCode;
	private EditText editUserName;
	private EditText editCode;
	private NewsTopRegisterBeanresponse response;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_find_password);
		
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
		imageloader=ImageLoader.getInstance();
		
		imgCodeUrl=Configurations.URL_NEWSTOP_REGISTER_CODE+"&imei="+Utils.getPhoneIMEI(this);

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		imgCode=(ImageView)findViewById(R.id.imgCode);
		editUserName=(EditText)findViewById(R.id.editUserName);
		editCode=(EditText)findViewById(R.id.editCode);
		
		title.setText("Find Password");
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
		imageloader.displayImage(imgCodeUrl, imgCode);
	}
	
	@Override
	public void onBackPressed() {
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvfinish:
			requsetFindPassword();
			break;
		default:
			break;
		}
		
	}

	private void requsetFindPassword() {
		String username=editUserName.getText().toString();
		String verify=editCode.getText().toString();
		
		if(TextUtils.isEmpty(username)){
			ToastManager.showShort(this, "Please enter your username or Email");
			return;
		}
		if(TextUtils.isEmpty(verify)){
			ToastManager.showShort(this, "Please enter the verification code");
			return;
		}
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByFindPasswordRequest(mHttpAgent, Utils.getPhoneIMEI(this), username, verify, Constants.HTTP_CANCAL_FIND_PASSWORD);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopRegisterBeanresponse)bean;
			if(response.getCode().equals("0")){
				ToastManager.showShort(this, "Check your email");
				onBackPressed();
			}else{
				ToastManager.showLong(this, response.getMsg());
			}
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
}
