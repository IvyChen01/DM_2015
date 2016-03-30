package com.trassion.newstop.activity;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.graphics.Typeface;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class ChangePasswordActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView title;
	private TextView tvfinish;
	private TextView twoTitle;
	private EditText editKey;
	private EditText editPassword;
	private EditText editConfirmPassword;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private NewsTopRegisterBeanresponse response;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_change_password);
		
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
		
		editKey=(EditText)findViewById(R.id.editKey);
		editPassword=(EditText)findViewById(R.id.editPassword);
		editConfirmPassword=(EditText)findViewById(R.id.editConfirmPassword);
		
		title.setText("Change Password");
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
	public void onBackPressed() {
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopRegisterBeanresponse)bean;
			if(response.getCode().equals("0")){
				ToastManager.showShort(this, "Password is changed");
				PreferenceUtils.setPrefBoolean(this, "isLogin", false);
				StartActivity(LoginActivity.class);
				this.finish();
			}else{
				ToastManager.showShort(this, response.getMsg());
				
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

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvfinish:
			requestChangePwd();
			
			break;

		default:
			break;
		}
		
	}

	private void requestChangePwd() {
		String pwd=editKey.getText().toString().trim();
		String newsPwd=editPassword.getText().toString().trim();
		String ConfirmPwd=editConfirmPassword.getText().toString().trim();
		
		if(TextUtils.isEmpty(pwd)){
			ToastManager.showShort(this, "Please enter your password");
			return;
		}
		if(TextUtils.isEmpty(newsPwd)){
			ToastManager.showShort(this, "Please enter your new password");
			return;
		}
		if(TextUtils.isEmpty(ConfirmPwd)){
			ToastManager.showShort(this, "Please enter your new password again");
			return;
		}
		if(!newsPwd.equals(ConfirmPwd)){
			ToastManager.showShort(this, "You two do not match the new password input");
			return;
		}
			if (NetworkUtil.isOnline(this)) {
				mHttpAgent.isShowProgress = true;
				request.getNewsTopListByChangePasswordRequest(mHttpAgent, Utils.getPhoneIMEI(this),auth,saltkey, pwd, newsPwd, Constants.HTTP_CANCAL_CHANGE_PASSWORD);
			} else {
				Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			}
		
	}

}
