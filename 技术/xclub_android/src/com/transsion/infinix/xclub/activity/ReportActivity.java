package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;

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

public class ReportActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
           
	    private LinearLayout tvback;
		private String pid;
		private RadioGroup radioGroup;
		private RadioButton rbspam;
		private RadioButton rbIllegal;
		private RadioButton rbMal;
		private RadioButton rbDupl;
		private RadioButton rbOther;
		private Button btsubmit;
		private ArrayList<BasicNameValuePair> mParams;
		private BaseDao dao;
		private String auth;
		private String uid;
		private String saltkey;
		private String message;
		private LoginInfo logininfo;

		private void initView() {
			tvback=(LinearLayout)findViewById(R.id.tvback);
			btsubmit=(Button)findViewById(R.id.btsubmit);
			radioGroup=(RadioGroup)findViewById(R.id.radioGroup);
			rbspam=(RadioButton)findViewById(R.id.rbspam);
			rbIllegal=(RadioButton)findViewById(R.id.rbIllegal);
			rbMal=(RadioButton)findViewById(R.id.rbMal);
			rbDupl=(RadioButton)findViewById(R.id.rbDupl);
			rbOther=(RadioButton)findViewById(R.id.rbOther);
			
			mParams=new ArrayList<BasicNameValuePair>();
			
			tvback.setOnClickListener(this);
			btsubmit.setOnClickListener(this);
			
		}
		private void setLisenter() {
			radioGroup.setOnCheckedChangeListener(new OnCheckedChangeListener() {
				
				@Override
				public void onCheckedChanged(RadioGroup group, int checkedId) {
					switch (checkedId) {
					case R.id.rbspam:
						message="Adverting/Spam";	
						break;
					case R.id.rbIllegal:
						message="Illegal content";
						break;
					case R.id.rbMal:
						message="Malicious irrigation";
						break;
					case R.id.rbDupl:
						message="Duplicated post";
						break;
					case R.id.rbOther:
						message="Other";
						break;
					default:
						break;
					}
					mParams.add(new BasicNameValuePair("message",message));
				}
			});
			
		}
		private void setData() {
			pid=getIntent().getStringExtra("pid");
			uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
		    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
		    auth=PreferenceUtils.getPrefString(this, "auth", "");
			
		}

		@Override
		public void onClick(View v) {
			switch (v.getId()) {
			case R.id.tvback:
				animFinish();
				break;
			case R.id.btsubmit:
				Report();
				break;
			default:
				break;
			}
			
		}
		private void Report() {
			
			 if(!NetUtil.isConnect(this)){
		 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
		 			return;
		 		}
	         mParams.add(new BasicNameValuePair("version","5"));
	         mParams.add(new BasicNameValuePair("module","report"));
	         mParams.add(new BasicNameValuePair("mobile","no"));
	         mParams.add(new BasicNameValuePair("rid",pid));
	         mParams.add(new BasicNameValuePair("uid",uid));
		     mParams.add(new BasicNameValuePair("saltkey",saltkey));
		     mParams.add(new BasicNameValuePair("auth",auth));
	         
	         dao = new BaseDao(ReportActivity.this, mParams, this, null);
	         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                 Constant.BASE_URL, "get", "false");
	         MasterApplication.getInstanse().showLoadDataDialogUtil(ReportActivity.this,dao);
			
		}
		@Override
		public void onBegin() {
			// TODO Auto-generated method stub
			
		}
		@Override
		public void onComplete(BaseEntity result) {
			MasterApplication.getInstanse().closeLoadDataDialogUtil();
			if(result!=null){
				Log.i("info","result:"+result.toString());
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
				if(logininfo.getMessage().getMessageval().equals("report_succeed")){
					ToastManager.showShort(this, "Report success");
					animFinish();
				}else{
					ToastManager.showShort(this, logininfo.getMessage().getMessagestr().toString());
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
			setContentView(R.layout.activity_report);
	    	initView();
	    	setLisenter();
	    	setData();
			
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
