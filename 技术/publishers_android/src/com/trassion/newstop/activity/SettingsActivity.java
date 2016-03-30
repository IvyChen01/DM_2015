package com.trassion.newstop.activity;

import java.io.File;
import java.io.IOException;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.FileUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.VersionUtil;
import com.trassion.newstop.view.SelectDialog;

import android.app.Activity;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class SettingsActivity extends BaseActivity implements OnClickListener,DialogInterface.OnClickListener{

	private TextView title;
	private TextView tvfinish;
	private TextView tvTerms;
	private RelativeLayout rlClearCache;
	private RelativeLayout rlCheckVersion;
	
	private long fileSize;
	private TextView tvClearCache;
	private Dialog dialog;
	private Button cancel;
	private Button confirm;
	private RelativeLayout rlHelp;

	@Override
	public void setContentView() {
		requestWindowFeature(Window.FEATURE_NO_TITLE); 
		setContentView(R.layout.activity_settings);

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		tvTerms=(TextView)findViewById(R.id.tvTerms);
		tvClearCache=(TextView)findViewById(R.id.tvClearCache);
		rlClearCache=(RelativeLayout)findViewById(R.id.rlClearCache);
		rlCheckVersion=(RelativeLayout)findViewById(R.id.rlCheckVersion);
		rlHelp=(RelativeLayout)findViewById(R.id.rlHelp);
		
		title.setText("Settings");
		tvfinish.setVisibility(View.VISIBLE);
		tvfinish.setText("Feedback");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		
		dialog=new Dialog(SettingsActivity.this,R.style.dialog);
		View v=LayoutInflater.from(this).inflate(R.layout.dialog_cache,null);
		cancel=(Button)v.findViewById(R.id.btnDialogCancel);
		confirm=(Button)v.findViewById(R.id.btnDialogYes);
		dialog.setContentView(v);
		
		tvfinish.setOnClickListener(this);
		tvTerms.setOnClickListener(this);
		rlClearCache.setOnClickListener(this);
		rlCheckVersion.setOnClickListener(this);
		cancel.setOnClickListener(this);
		confirm.setOnClickListener(this);
		rlHelp.setOnClickListener(this);

	}

	@Override
	public void initData() {
		new Thread(){

			public void run(){
				try {
					fileSize = FileUtils.getFileSize(new File(Constants.APP_DIR));
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
				ToastManager.showShort(SettingsActivity.this, "Cache success");
			}
		}
	};
	private void updateCacheSize(String cacheSize){
		tvClearCache.setText(cacheSize);
    }

	

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvfinish:
			StartActivity(FeedbackActivity.class);
			break;
		case R.id.tvTerms:
			StartActivity(TermsAndConditionsActivity.class);
			break;
		case R.id.rlClearCache:
			dialog.show();
			break;
		case R.id.rlCheckVersion:
			 try {
				new VersionUtil(SettingsActivity.this, handler).checkVersionNo(SettingsActivity.class.getSimpleName());
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			break;
		case R.id.btnDialogCancel:
			dialog.dismiss();
			break;
		case R.id.btnDialogYes:
			dialog.dismiss();
			new Thread(new Runnable() {
				@Override
				public void run() {
					FileUtils.deleteDirectory(Constants.APP_DIR);
					fileSize = 0;
					mHandler.sendEmptyMessage(1);
					
				}
			}).start();
			
			break;
		case R.id.rlHelp:
			StartActivity(FeedbackActivity.class);
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
            if (msg.what == Constants.RETURNWEHLCOME){
                if(NewsApplication.NEWVERSIONNUMBER!=null){// ˵�� ����Ҫ����
                    new VersionUtil(SettingsActivity.this, null).showDailog(NewsApplication.versionUrl, 
                            "Global Publisher News", NewsApplication.versionLog);
                }else{
                    ToastManager.showShort(SettingsActivity.this, "Has been the latest version");
                    
                }
                
            }else if(msg.what == Constants.RETURNNOWEHLCOME){
            	ToastManager.showShort(SettingsActivity.this, "Has been the latest version");
            }
        }
    };
	@Override
	public void onBackPressed() {
			Intent intent = new Intent(getApplicationContext(), MainActivity.class);
			setResult(MainActivity.CHANNELRESULT, intent);
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void onClick(DialogInterface dialog, int which) {
		switch (which) {
		case 0:
			ToastManager.showShort(this, "OK");
			break;
		case 1:
			ToastManager.showShort(this, "NO");
			break;

		default:
			break;
		}
		
	}
}
