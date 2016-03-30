package com.trassion.newstop.activity;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopLoginBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class LoginActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView tvfinish;
	private TextView title;
	private TextView twoTitle;
	private TextView tvForgetPassword;
	private TextView tvRegister;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private EditText editName;
	private EditText editPassword;
	private Animation anim;
	private NewsTopLoginBeanresponse response;
	private String username;
	private String password;
	private InputMethodManager imm;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_login);
		
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
		
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		tvForgetPassword=(TextView)findViewById(R.id.tvForgetPassword);
		tvRegister=(TextView)findViewById(R.id.tvRegister);
		editName=(EditText)findViewById(R.id.editName);
		editPassword=(EditText)findViewById(R.id.editPassword);
		
		title.setText("Login");
		tvfinish.setVisibility(View.VISIBLE);
		tvfinish.setText("DONE");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		twoTitle.setTypeface(type);
		tvForgetPassword.setTypeface(type);
		tvRegister.setTypeface(type);
		
		tvRegister.setOnClickListener(this);
		tvForgetPassword.setOnClickListener(this);
		tvfinish.setOnClickListener(this);
	}

	@Override
	public void initData() {
		// TODO Auto-generated method stub

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
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvRegister:
			StartActivity(RegisterActivity.class);
			break;
		case R.id.tvForgetPassword:
			StartActivity(FindPasswordActivity.class);
			break;
		case R.id.tvfinish:
			requestLogin();
			break;
		default:
			break;
		}
		
	}

	private void requestLogin() {
		 username=editName.getText().toString().trim();
		 password=editPassword.getText().toString().trim();
		
		if(TextUtils.isEmpty(username)){
			initEditTextErrorAnim();
			editName.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your username");
			return;
		}
		if(TextUtils.isEmpty(password)){
			initEditTextErrorAnim();
			editPassword.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your password");
			return;
		}
		imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByLoginRequest(mHttpAgent, Utils.getPhoneIMEI(this), username, password, Constants.HTTP_GET_LOGIN);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopLoginBeanresponse)bean;
			if(response.getCode().equals("0")){
				 loginSuccess();
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
	private void loginSuccess() {
		// TODO Auto-generated method stub
		PreferenceUtils.setPrefString(this, "username", username);
		PreferenceUtils.setPrefString(this, "pwd", password);
		PreferenceUtils.setPrefString(this, "email", response.getUserinfo().getEmail());
		PreferenceUtils.setPrefString(this, "saltkey", response.getSaltkey());
		PreferenceUtils.setPrefString(this, "auth", response.getAuth());
		PreferenceUtils.setPrefString(this, "phone", response.getUserinfo().getPhone());
		PreferenceUtils.setPrefString(this, "nick", response.getUserinfo().getNick());
		PreferenceUtils.setPrefString(this, "signature", response.getUserinfo().getSignature());
		PreferenceUtils.setPrefString(this, "uid", response.getUserinfo().getUid());
		PreferenceUtils.setPrefString(this, "photo", response.getUserinfo().getPhoto());
		PreferenceUtils.setPrefString(this, "date", response.getUserinfo().getRegister_date());
		PreferenceUtils.setPrefBoolean(this, "isLogin", true);
		
		Bundle bundle = new Bundle();
		Intent intent=new Intent(this,MainActivity.class);
		bundle.putBoolean("isLogin", true);
		intent.putExtras(bundle);
		setResult(RESULT_OK, intent);
		
		onBackPressed();
		
	}
	/**
     * ��������Ķ���
     */
    public void initEditTextErrorAnim()
    {
        if (anim == null)
            anim = AnimationUtils.loadAnimation(this, R.anim.shake);
    }
	
}
