package com.transsion.infinix.xclub;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import com.transsion.infinix.xclub.activity.GuideActivity;
import com.transsion.infinix.xclub.activity.SlidingActivity;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.trassion.infinix.xclub.R;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.util.DisplayMetrics;
import android.widget.ImageView;

public class WelcomeActivity extends BaseActivity implements RequestListener<BaseEntity>{
    
	private static final int GO_HOME = 100;
	private static final int GO_GUIDE = 200;
	private ImageView ImgWelcome;
	private boolean isFirst;
    
	private Handler mHandler = new Handler() {
		  @Override
		  public void handleMessage(Message msg) {
		    switch (msg.what) {
			    case GO_HOME:
			      goHome();
				    break;
			    case GO_GUIDE:
			      goGuide();
				    break;
			    }
		    }
		  };
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private long fileSize=0;
	private ImageLoader loader;
	private int width;


	private void init() {
		ImgWelcome=(ImageView)findViewById(R.id.welcomelayout);
		
		SharedPreferences preferences = getSharedPreferences("first_pref", MODE_PRIVATE);
		isFirst = preferences.getBoolean("isFirst", true);
		 String url_splash =PreferenceUtils.getPrefString(this, "url_splash", ""); 
		 if(!TextUtils.isEmpty(url_splash)){
				//»ñÈ¡ÆÁÄ»¿í¶È
				int width = getScreenWidth();
				ImageLoader loader = ImageLoader.getInstance(this);
				Bitmap bitmap = loader.getWelcomeBitmap(url_splash, width);
				if(bitmap != null){
					ImgWelcome.setBackgroundDrawable(new BitmapDrawable(getResources(), bitmap));
				}
			}else{
				ImgWelcome.setBackgroundResource(R.drawable.welcome);
			}
			if(!isFirst) {
				mHandler.sendEmptyMessageDelayed(GO_HOME, 3000);
			} else {
				PreferenceUtils.setPrefInt(this, "uid", 0);
				mHandler.sendEmptyMessageDelayed(GO_GUIDE, 3000);
				FileUtils.deleteDirectory(Constant.BASE_PATH);
		
			}
		
		if(!NetUtil.isConnect(this)){
			return;
 		}
		 mParams=new ArrayList<BasicNameValuePair>();
         mParams.add(new BasicNameValuePair("version","5"));
         mParams.add(new BasicNameValuePair("module","adpic"));
         mParams.add(new BasicNameValuePair("mobile","no"));
         
         dao = new BaseDao(this, mParams, this, null);
         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                 Constant.BASE_URL, "get", "false");
		
	}
	private int getScreenWidth(){
		DisplayMetrics dm = new DisplayMetrics();
		getWindowManager().getDefaultDisplay().getMetrics(dm);
		return dm.widthPixels;
	}
	private void goHome() {
		Intent intent = new Intent(WelcomeActivity.this, SlidingActivity.class);
		startActivity(intent);
		overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
		this.finish();
	}
	
	 private void goGuide() {
	    Intent intent = new Intent(WelcomeActivity.this, GuideActivity.class);
	    startActivity(intent);
	    overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
	    this.finish();
	  }

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		if(result!=null){
		MasterApplication.getInstanse().logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
		 if(MasterApplication.getInstanse().logininfo.getVariables().getWelcome()!=null){
			PreferenceUtils.setPrefString(this, "url_splash", MasterApplication.getInstanse().logininfo.getVariables().getWelcome());
		    PreferenceUtils.setPrefString(this, "url_share", MasterApplication.getInstanse().logininfo.getVariables().getTw());
		 }
		}
		
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_welcome);
		init();
		
	}

	@Override
	public void initWidget() {
		// TODO Auto-generated method stub
		PreferenceUtils.setPrefBoolean(c, "isDownloadName", true);
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
	
}
