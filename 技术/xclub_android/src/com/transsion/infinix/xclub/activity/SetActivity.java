package com.transsion.infinix.xclub.activity;

import java.io.File;
import java.io.IOException;

import android.app.Dialog;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.VersionInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.util.VersionUtil;
import com.trassion.infinix.xclub.R;

public class SetActivity extends BaseActivity implements OnClickListener{
       
	private LinearLayout tvback;
	private TextView tvVersion;
	private TextView tvCurrentVersion;
	private Dialog dialog;
	private Button cancel;
	private Button confirm;
	private LinearLayout layout_cache;
	private TextView mSizeTextView;
	
	long fileSize = 0;
	private RelativeLayout isupdate;
	private RelativeLayout layout_about;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		tvVersion=(TextView)findViewById(R.id.tvVersion);
		tvCurrentVersion=(TextView)findViewById(R.id.tvCurrentVersion);
		layout_cache=(LinearLayout)findViewById(R.id.layout_cache);
		isupdate=(RelativeLayout)findViewById(R.id.isupdate);
		mSizeTextView=(TextView)findViewById(R.id.systemsetting_remove_size);
		layout_about=(RelativeLayout)findViewById(R.id.layout_about);
		
		tvVersion.setText("Xclub Android "+new VersionUtil(this,null).getVersionNo());
		tvCurrentVersion.setText("V"+new VersionUtil(this,null).getVersionNo());
		
		dialog=new Dialog(SetActivity.this,R.style.dialog);
		View v=LayoutInflater.from(this).inflate(R.layout.dialog_collection,null);
		TextView tvContent=(TextView)v.findViewById(R.id.tvContent);
		tvContent.setText("Delete the cache right now?");
		cancel=(Button)v.findViewById(R.id.cancle);
		confirm=(Button)v.findViewById(R.id.confirm);
		dialog.setContentView(v);
		
		new Thread(){
			public void run(){
				try {
					fileSize = FileUtils.getFileSize(new File(Constant.BASE_PATH));
					mHandler.sendEmptyMessage(0);
				} catch (Exception e) {
					e.printStackTrace();
					fileSize = 0;
					mHandler.sendEmptyMessage(0);
				}
			}
		}.start();
		
	}
	private Handler mHandler = new Handler(){
		@Override
		public void handleMessage(Message msg) {
			if (msg.what == 0) {
				updateCacheSize(FileUtils.FormetFileSize(fileSize));
			} else if (msg.what == 1) {
				updateCacheSize(FileUtils.FormetFileSize(fileSize));
				ToastManager.showShort(SetActivity.this, "Cache success");
			}
		}
	};
	private void setListener() {
		tvback.setOnClickListener(this);
		layout_cache.setOnClickListener(this);
		cancel.setOnClickListener(this);
		confirm.setOnClickListener(this);
		isupdate.setOnClickListener(this);
		layout_about.setOnClickListener(this);
	}
	private void updateCacheSize(String cacheSize){
		mSizeTextView.setText(cacheSize);
    }
	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
            break;
		case R.id.layout_cache:
			dialog.show();
			break;
		case R.id.layout_about:
			intent.setClass(this, AboutActivity.class);
			animStartActivity(intent);
			break;
		case R.id.isupdate:
			 MasterApplication.getInstanse().showLoadDataDialogUtil(SetActivity.this,null);
			    try
	            {
	                new VersionUtil(SetActivity.this, handler).checkVersionNo(SetActivity.class.getSimpleName());
	            } catch (IOException e)
	            {
	                e.printStackTrace();
	            }
			break;
		case R.id.cancle:
			dialog.dismiss();
			break;
		case R.id.confirm:
			dialog.dismiss();
			new Thread(new Runnable() {
				@Override
				public void run() {
					FileUtils.deleteDirectory(Constant.BASE_PATH);
					fileSize = 0;
					mHandler.sendEmptyMessage(1);
					
				}
			}).start();
			
			break;
		default:
			break;
		}
		
	}
	private Handler handler = new Handler()
    {
        @SuppressWarnings("deprecation")
		public void handleMessage(Message msg)
        {
        	MasterApplication.getInstanse().closeLoadDataDialogUtil();
            if (msg.what == Constant.RETURNWEHLCOME){
                VersionInfo versionBean= MasterApplication.getInstanse().logininfo.getVariables().getApp_version();
                if(versionBean!=null){// 说明 不需要更新
                    Log.i("info", "url:"+MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getLink());
                    new VersionUtil(c, null).showDailog(MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getLink(), 
                            "Xclub", MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getMessage());
                }else{
                    ToastManager.showShort(SetActivity.this, "Has been the latest version");
                    
                }
                
            }else if(msg.what == Constant.RETURNNOWEHLCOME){
            	ToastManager.showShort(SetActivity.this, "Has been the latest version");
            }
        }
    };

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_set);
		initView();
		setListener();
		
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
