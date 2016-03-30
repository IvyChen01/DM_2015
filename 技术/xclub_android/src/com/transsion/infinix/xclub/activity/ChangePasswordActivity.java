package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;

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
import com.trassion.infinix.xclub.R;

public class ChangePasswordActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
      
	    private LinearLayout tvback;
		private EditText etPwd;
		private EditText etNewPwd;
		private EditText etConfirmNewPwd;
		private Button btComplete;
		private ArrayList<BasicNameValuePair> mParams;
		private String uid;
		private String saltkey;
		private String auth;
		private BaseDao dao;
		private LoginInfo logininfo;
		private String pwd;

		@Override
		public void onClick(View v) {
			switch (v.getId()) {
			case R.id.tvback:
				animFinish();
				break;
			case R.id.btComplete:
				ChangePassword();
				break;
			default:
				break;
			}
			
		}

		private void ChangePassword() {
		  pwd=etPwd.getText().toString();
	     String newpwd=etNewPwd.getText().toString();
	     String confirmnewPwd=etConfirmNewPwd.getText().toString();
			if(TextUtils.isEmpty(pwd)){
				   ToastManager.showShort(this, "Please write down enter passwaord");
				   initEditTextErrorAnim();
				   etPwd.startAnimation(anim);
				   return;
			   }
			if(TextUtils.isEmpty(newpwd)){
				   ToastManager.showShort(this, "please write down new enter password");
				   initEditTextErrorAnim();
				   etNewPwd.startAnimation(anim);
				   return;
			   }
			if(TextUtils.isEmpty(confirmnewPwd)){
				   ToastManager.showShort(this, "Please write down enter new enter passwaord");
				   initEditTextErrorAnim();
				   etConfirmNewPwd.startAnimation(anim);
				   return;
			   }
			if(newpwd.equals(pwd)){
				   ToastManager.showShort(this, "The same as the old password");
				   return;
			   }
			if(!newpwd.equals(confirmnewPwd)){
				   ToastManager.showShort(this, "The new password is not consistent with the confirmation password");
				   return;
			   }
			if(!NetUtil.isConnect(this)){
	 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
		}
			 mParams=new ArrayList<BasicNameValuePair>();
	         mParams.add(new BasicNameValuePair("version","5"));
	         mParams.add(new BasicNameValuePair("module","changepwd"));
	         mParams.add(new BasicNameValuePair("mobile","no"));
	         mParams.add(new BasicNameValuePair("newpassword",newpwd));
	         mParams.add(new BasicNameValuePair("oldpassword",pwd));
	         mParams.add(new BasicNameValuePair("newpassword2",confirmnewPwd));
	         
	         mParams.add(new BasicNameValuePair("uid",uid));
	         mParams.add(new BasicNameValuePair("saltkey",saltkey));
	         mParams.add(new BasicNameValuePair("auth",auth));
	         
	         dao = new BaseDao(this, mParams, this, null);
	         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                 Constant.BASE_URL, "get", "false");
	         MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
	}

		@Override
		public void onBegin() {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void onComplete(BaseEntity result) {
			MasterApplication.getInstanse().closeLoadDataDialogUtil();
			if(result!=null){
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
				if(logininfo.getMessage().getMessageval().equals("profile_succeed")){
					ToastManager.showShort(this, "Success!");
					PreferenceUtils.setPrefString(this, "pwd", pwd);
					Intent intent=new Intent(this,LoginActivity.class);
					animStartActivity(intent);
					animFinish();
				}else{
					ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
				}
			}else{
				ToastManager.showShort(this, "Data requests failed, please try again later");
			}
			
		}

		@Override
		public void onNetworkNotConnection() {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void setContentView() {
			setContentView(R.layout.activity_change_password);
			
		}

		@Override
		public void initWidget() {
			tvback=(LinearLayout)findViewById(R.id.tvback);
			etPwd=(EditText)findViewById(R.id.etPwd);
			etNewPwd=(EditText)findViewById(R.id.etNewPwd);
			etConfirmNewPwd=(EditText)findViewById(R.id.etConfirmNewPwd);
			btComplete=(Button)findViewById(R.id.btComplete);
			
			uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
		    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
		    auth=PreferenceUtils.getPrefString(this, "auth", "");
		    
		    btComplete.setOnClickListener(this);
			tvback.setOnClickListener(this);
			
		}

		@Override
		public void getData() {
			// TODO Auto-generated method stub
			
		}
}
