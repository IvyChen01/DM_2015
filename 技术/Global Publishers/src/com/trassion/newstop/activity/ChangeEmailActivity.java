package com.trassion.newstop.activity;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopChangeNickBeanresponse;
import com.trassion.newstop.bean.response.NewsTopChangeSignatureBeanresponse;
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

public class ChangeEmailActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView title;
	private TextView tvfinish;
	private TextView twoTitle;
	private String type;
	private EditText editName;
	private EditText editNewEmail;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private NewsTopChangeSignatureBeanresponse response;
	
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_change);
		Intent intent=getIntent();
		 type=intent.getStringExtra("CODE");
		 
		 request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
		
		auth=PreferenceUtils.getPrefString(this, "auth", "");
		saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		editName=(EditText)findViewById(R.id.editName);
		editNewEmail=(EditText)findViewById(R.id.editNewEmail);
		
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
		if(type.equals("email")){
			title.setText("Binding Email");
			editName.setHint("Please input your current email");
			editNewEmail.setHint("please input your new email");
			editName.setVisibility(View.VISIBLE);
		}else if(type.equals("phone")){
			title.setText("Binding Phone Number");
//			editName.setHint("Please input your phone number");
			editNewEmail.setHint("Please input your phone number");
			editName.setVisibility(View.GONE);
		}

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
			if(type.equals("email")){
			requestChangeEmail();
			}else if(type.equals("phone")){
				requestChangePhone();	
			}
			break;

		default:
			break;
		}
		
	}
	private void requestChangePhone() {
		String newPhone=editNewEmail.getText().toString();
		String oldPhone=editName.getText().toString();
		String phone=PreferenceUtils.getPrefString(this, "phone", "");
		
		if(TextUtils.isEmpty(newPhone)){
			ToastManager.showShort(this, "Please enter your phone");
			return;
		}
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByChangePhoneRequest(mHttpAgent, Utils.getPhoneIMEI(this), newPhone,auth,saltkey,Constants.HTTP_CHANGE_EMAIL);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	private void requestChangeEmail() {
		String email=editNewEmail.getText().toString();
		String oldmial=editName.getText().toString();
		String emailNumber=PreferenceUtils.getPrefString(this, "email", "");
		
		if(TextUtils.isEmpty(oldmial)){
			ToastManager.showShort(this, "Please enter your email address to modify");
			return;
		}
		if(TextUtils.isEmpty(email)){
			ToastManager.showShort(this, "Please enter your email");
			return;
		}
		if(emailNumber.equals(email)){
			ToastManager.showShort(this, "You enter the E-mail address is not correct");
			return;
		}
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByChangeEmailRequest(mHttpAgent, Utils.getPhoneIMEI(this), email,auth,saltkey,Constants.HTTP_CHANGE_PHONE);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		mHttpAgent.isShowProgress = false;
		if(bean!=null){
			response=(NewsTopChangeSignatureBeanresponse)bean;
			
			if(type.equals("email")){
			PreferenceUtils.setPrefString(this, "email", response.getEmail());
			}else if(type.equals("phone")){
				PreferenceUtils.setPrefString(this, "phone", response.getPhone());
			}
			Intent intent = new Intent();
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

}
