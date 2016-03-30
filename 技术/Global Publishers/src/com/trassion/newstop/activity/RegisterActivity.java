package com.trassion.newstop.activity;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.config.Configurations;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class RegisterActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView title;
	private TextView tvfinish;
	private TextView twoTitle;
	private TextView tvAgreeTerms;
	private TextView tvLogin;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private ImageView imgCode;
	private ImageLoader imageloader;
	private String imgCodeUrl;
	private EditText userName;
	private EditText etEmail;
	private EditText etPassword;
	private EditText etConfirmPassword;
	private EditText code;
	private Animation anim;
	private NewsTopRegisterBeanresponse response;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_register);
		
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
		tvAgreeTerms=(TextView)findViewById(R.id.tvAgreeTerms);
		
		imgCode=(ImageView)findViewById(R.id.imgCode);
		tvLogin=(TextView)findViewById(R.id.tvLogin);
		userName=(EditText)findViewById(R.id.editUserName);
		etEmail=(EditText)findViewById(R.id.editEmail);
		etPassword=(EditText)findViewById(R.id.editPassword);
		etConfirmPassword=(EditText)findViewById(R.id.editConfirmPassword);
		code=(EditText)findViewById(R.id.editCode);
		
		title.setText("Register");
		tvfinish.setVisibility(View.VISIBLE);
		tvfinish.setText("DONE");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		twoTitle.setTypeface(type);
		tvAgreeTerms.setTypeface(type);
		tvLogin.setTypeface(type);
		
		tvAgreeTerms.setOnClickListener(this);
		tvLogin.setOnClickListener(this);
		imgCode.setOnClickListener(this);
		tvfinish.setOnClickListener(this);

	}

	@Override
	public void initData() {
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
		case R.id.tvAgreeTerms:
			StartActivity(TermsAndConditionsActivity.class);
			break;
		case R.id.tvLogin:
			StartActivity(LoginActivity.class);
			break;
		case R.id.imgCode:
			imageloader.displayImage(imgCodeUrl, imgCode);
			break;
		case R.id.tvfinish:
			requestNewsTopRegister();
			break;
		default:
			break;
		}
		
	}
	private void requestNewsTopRegister() {
		String username=userName.getText().toString().trim();
		String email=etEmail.getText().toString().trim();
		String password=etPassword.getText().toString().trim();
		String confirmPassword=etConfirmPassword.getText().toString().trim();
		String verify=code.getText().toString().trim();
		
		if(TextUtils.isEmpty(username)){
			initEditTextErrorAnim();
			userName.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your username");
			return;
		}
		if(TextUtils.isEmpty(email)){
			initEditTextErrorAnim();
			etEmail.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your username");
			return;
		}
		if(TextUtils.isEmpty(password)){
			initEditTextErrorAnim();
			etPassword.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your password");
			return;
		}
		if(TextUtils.isEmpty(confirmPassword)){
			initEditTextErrorAnim();
			etConfirmPassword.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your password again");
			return;
		}
		if(TextUtils.isEmpty(verify)){
			initEditTextErrorAnim();
			code.startAnimation(anim);
			ToastManager.showShort(this, "Please enter the verification code");
			return;
		}
		if(!password.equals(confirmPassword)){
			ToastManager.showShort(this, "You two do not match the password input");
			return;
		}
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByRegisterRequest(mHttpAgent, Utils.getPhoneIMEI(this), verify, username, confirmPassword, email, Constants.HTTP_GET_REGISTER);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		mHttpAgent.hasShowProgress=false;
		if(bean!=null){
			response=(NewsTopRegisterBeanresponse)bean;
			if(response.getCode().equals("0")){
		    ToastManager.showLong(this, "Registered success");
				onBackPressed();
			}else{
				ToastManager.showLong(this, response.getMsg());
			}
		}
		
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			ToastManager.showLong(this, R.string.common_cannot_connect);
		}
	}
	/**
     * ÊäÈë¿ò´íÎóµÄ¶¯»­
     */
    public void initEditTextErrorAnim()
    {
        if (anim == null)
            anim = AnimationUtils.loadAnimation(this, R.anim.shake);
    }
}
