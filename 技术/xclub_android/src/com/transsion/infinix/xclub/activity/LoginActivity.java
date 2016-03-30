package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.LoginQuestionDilog;
import com.trassion.infinix.xclub.R;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class LoginActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
    private Button btRegister;
    private LinearLayout tvback;
	private Button btLogin;
	private EditText etPwd;
	private EditText etUserName;
	
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private LoginInfo logininfo;
	private String username;
	private String pwd;
	private int login_type;
	private ImageView tvForgotgPwd;
	private int login_not=0;
	private TextView tvQuestion;
	private LoginQuestionDilog dialog;
	private LinearLayout loginAnswer;
	private String questionid="0";
	private EditText etAnswer;
	private String answer;
	private LinearLayout layout_question;

	private void initView() {
		btRegister=(Button)findViewById(R.id.btRegister);
		btLogin=(Button)findViewById(R.id.btLogin);
		tvback=(LinearLayout)findViewById(R.id.tvback);
		tvForgotgPwd=(ImageView)findViewById(R.id.tvForgotgPwd);
		etUserName=(EditText)findViewById(R.id.etUserName);
		loginAnswer=(LinearLayout)findViewById(R.id.loginAnswer);
		layout_question=(LinearLayout)findViewById(R.id.layout_question);
		etAnswer=(EditText)findViewById(R.id.etAnswer);
		etPwd=(EditText)findViewById(R.id.etPwd);
		tvQuestion=(TextView)findViewById(R.id.tvQuestion);
		String userName=PreferenceUtils.getPrefString(this, "username", "");
		String password=PreferenceUtils.getPrefString(this, "pwd", "");
		login_type=getIntent().getIntExtra("Login_type", 0);
		login_not=getIntent().getIntExtra("LOGIN_NOT", 0);
		Log.i("info","login_not:"+login_not);
		if(!userName.equals("")){
			etUserName.setText(userName);
		}
		if(!password.equals("")){
			etPwd.setText(password);
		}
		btRegister.setOnClickListener(this);
		btLogin.setOnClickListener(this);
		tvForgotgPwd.setOnClickListener(this);
		tvQuestion.setOnClickListener(this);
		tvback.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.btLogin:
			Login();
			break;
		case R.id.btRegister:
			if(login_type==1){
			intent.setClass(LoginActivity.this,RegisterActivity.class);
			intent.putExtra("Login_type", 1);
			animStartActivity(intent);
			}else if(login_type==2){
				intent.setClass(LoginActivity.this,RegisterActivity.class);
				intent.putExtra("Login_type", 2);
				animStartActivity(intent);	
			}else{
				intent.setClass(LoginActivity.this,RegisterActivity.class);
				intent.putExtra("Login_type", 3);
				animStartActivity(intent);	
			}
			break;
		case R.id.tvQuestion:
			dialog=new LoginQuestionDilog(LoginActivity.this){
				@Override
				public void ItemClick(String question,int position) {
					// TODO Auto-generated method stub
					super.ItemClick(question,position);
					questionid=position+"";
					tvQuestion.setText(question);
					if(question.equals("Security Question(Please ignore if not set)")){
						loginAnswer.setVisibility(View.GONE);
						tvQuestion.setTextColor(0xFFD1D1D1);
					}else{
					    loginAnswer.setVisibility(View.VISIBLE);
					    tvQuestion.setTextColor(0xFF000000);
					}
					dialog.dismiss();
				}
			};
			dialog.show();
			break;
		case R.id.tvback:
			animFinish();
            break;
		case R.id.tvForgotgPwd:
			intent.setClass(LoginActivity.this,ForgetPasswordActivity.class);
			animStartActivity(intent);
			break;
		default:
			break;
		}
		
	}
    //µÇÂ¼
	private void Login(){
		
		  username = etUserName.getText().toString();
          pwd = etPwd.getText().toString();
         if(TextUtils.isEmpty(username)){
        	 initEditTextErrorAnim();
        	 etUserName.startAnimation(anim);
        	 ToastManager.showShort(this, "Please enter your account number");
        	 return;
         }
         if(TextUtils.isEmpty(pwd)){
        	 initEditTextErrorAnim();
        	 etPwd.startAnimation(anim);
        	 ToastManager.showShort(this, "Please enter your password");
        	 return;
         }
         if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
         if(!questionid.equals("0")){
        	 answer=etAnswer.getText().toString();
        	 if(TextUtils.isEmpty(answer)){
        		 initEditTextErrorAnim();
        		 etAnswer.startAnimation(anim);
            	 ToastManager.showShort(this, "Please enter your answer");
            	 return;
        	 }else{
        	 }
         }
         mParams=new ArrayList<BasicNameValuePair>();
         mParams.add(new BasicNameValuePair("version","5"));
         mParams.add(new BasicNameValuePair("module","login"));
         mParams.add(new BasicNameValuePair("loginsubmit","yes"));
         mParams.add(new BasicNameValuePair("username",username));
         mParams.add(new BasicNameValuePair("password",pwd));
         if(!questionid.equals("0")){
         mParams.add(new BasicNameValuePair("questionid",questionid));
         mParams.add(new BasicNameValuePair("answer",answer));
         }
         dao = new BaseDao(LoginActivity.this, mParams, this, null);
         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                 Constant.BASE_URL, "get", "false");
         MasterApplication.getInstanse().showLoadDataDialogUtil(LoginActivity.this,dao);
     
	}

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		 MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			if(result.getRet()==0){
					   logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
					 if(logininfo.getMessage().getMessageval().equals("login_succeed")){
						 Log.i("info","uid"+logininfo.getVariables().getMember_uid());
						 ToastManager.showLong(this, "Success!");
						 loginSuccess();
					 }else{
						 if(logininfo.getMessage().getMessagestr().equals("Please input security Q&A")){
							 layout_question.setVisibility(View.VISIBLE);
							 ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
							 
						 }else{
						 //µÇÂ¼Ê§°Ü
						 ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
						 }
					 }
			}
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
		}
		
	}

	private void loginSuccess() {
		PreferenceUtils.setPrefString(this, "username", username);
		PreferenceUtils.setPrefString(this, "pwd", pwd);
		PreferenceUtils.setPrefString(this, "auth", logininfo.getVariables().getAuth());
		PreferenceUtils.setPrefString(this, "saltkey", logininfo.getVariables().getSaltkey());
		PreferenceUtils.setPrefString(this, "sys_authkey", logininfo.getSys_authkey());
		PreferenceUtils.setPrefString(this, "Has_sign", logininfo.getVariables().getHas_sign());
		PreferenceUtils.setPrefInt(this, "uid", Integer.parseInt(logininfo.getVariables().getMember_uid()));
		if(login_not==1){
			Bundle bundle = new Bundle();
			Intent intent=new Intent(this,SlidingActivity.class);
			bundle.putBoolean("isLogin", true);
			intent.putExtras(bundle);
			setResult(RESULT_OK, intent);
			
			Intent in=new Intent(Constant.ACTION_LOGIN_SUCCESS);
			in.putExtra(Constant.KEY_IS_SUCCESS, true);
			this.sendBroadcast(in);
		}else{
		Intent intent=new Intent(Constant.ACTION_LOGIN_SUCCESS);
		intent.putExtra(Constant.KEY_IS_SUCCESS, true);
		this.sendBroadcast(intent);
		}
		login_not=0;
		animFinish();
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_login);
		initView();
		
	}

	@Override
	public void initWidget() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
}
