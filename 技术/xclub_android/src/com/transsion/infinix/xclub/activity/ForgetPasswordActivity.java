package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
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
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

public class ForgetPasswordActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	
	private LinearLayout tvback;
	private EditText etEmail;
	private Button btComplete;
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private LoginInfo logininfo;
	
	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		etEmail=(EditText)findViewById(R.id.etEmail);
		btComplete=(Button)findViewById(R.id.btComplete);
		
		tvback.setOnClickListener(this);
		btComplete.setOnClickListener(this);
		
	}
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
		String name=etEmail.getText().toString();
		 if(TextUtils.isEmpty(name)){
        	 ToastManager.showShort(this, "Please enter your email address or user name");
        	 return;
         }
         if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
         mParams=new ArrayList<BasicNameValuePair>();
         mParams.add(new BasicNameValuePair("version","5"));
         mParams.add(new BasicNameValuePair("module","forgetpwd"));
         mParams.add(new BasicNameValuePair("mobile","no"));
         mParams.add(new BasicNameValuePair("username",name));
         
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
			 if(logininfo.getMessage().getMessageval().equals("getpasswd_send_succeed")){
				 ToastManager.showLong(this, "To the email, please check ");
			 }else{
				 //µÇÂ¼Ê§°Ü
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
      setContentView(R.layout.activity_forget_password);
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
