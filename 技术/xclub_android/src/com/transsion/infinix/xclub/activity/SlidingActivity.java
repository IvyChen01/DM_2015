package com.transsion.infinix.xclub.activity;



import java.io.IOException;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.VersionInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.fragment.MainFragment;
import com.transsion.infinix.xclub.fragment.RightFragment;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.util.VersionUtil;
import com.transsion.infinix.xclub.view.SlidingMenu;
import com.trassion.infinix.xclub.R;
import com.umeng.analytics.MobclickAgent;

import android.app.FragmentManager.OnBackStackChangedListener;
import android.content.Intent;
import android.os.Handler;
import android.os.Message;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentManager.BackStackEntry;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.KeyEvent;
import android.widget.Toast;

public class SlidingActivity extends BaseActivity{
	SlidingMenu mSlidingMenu;
	RightFragment rightFragment;
//	LeftFragment leftFragment;
	MainFragment mainFragment;
	private VersionUtil version;
	private long exitTime = 0;
	private int step;
	
	private void setData() {
		
		if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
		try
        {
            new VersionUtil(c, handler).checkVersionNo(SlidingActivity.class.getSimpleName());
        } catch (IOException e)
        {
            e.printStackTrace();
        }
	}
	private Handler handler = new Handler()
    {
        @SuppressWarnings("deprecation")
		public void handleMessage(Message msg)
        {
            if (msg.what == Constant.RETURNWEHLCOME)
            {
                MasterApplication.getInstanse().closeLoadDataDialogUtil();
                VersionInfo versionBean= MasterApplication.getInstanse().logininfo.getVariables().getApp_version();
                if(versionBean!=null){// 说明 不需要更新
                    Log.i("info", "url:"+MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getLink());
                    version.showDailog(MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getLink(), 
                            "Xclub", MasterApplication.getInstanse().logininfo.getVariables().getApp_version().getMessage());
                }else{
//                    ToastManager.showShort(SlidingActivity.this, "Has been the latest version");

                }
                
            }
        }
    };
	private FragmentManager fm;
	private void initListener() {
		// TODO Auto-generated method stub
		    mSlidingMenu.setCanSliding(false,true);
//         viewPageFragment.setMyPageChangeListener(new MyPageChangeListener() {
//			
//			@Override
//			public void onPageSelected(int position) {
//				 if(viewPageFragment.isFirst()){
//					mSlidingMenu.setCanSliding(false,false);
//				}else if(viewPageFragment.isEnd()){
//					mSlidingMenu.setCanSliding(false,true);
//				}else{
//					mSlidingMenu.setCanSliding(false,false);
//				}
//			}
//		});
	}
	
	private void init() {
		// TODO Auto-generated method stub
		mSlidingMenu = (SlidingMenu) findViewById(R.id.slidingMenu);
		mSlidingMenu.setLeftView(getLayoutInflater().inflate(
				R.layout.left_frame, null));
		mSlidingMenu.setRightView(getLayoutInflater().inflate(
				R.layout.right_frame, null));
		mSlidingMenu.setCenterView(getLayoutInflater().inflate(
				R.layout.center_frame, null));
		
		FragmentTransaction t = this.getSupportFragmentManager()
				.beginTransaction();
//		leftFragment = new LeftFragment();
//		t.replace(R.id.left_frame, leftFragment);
		
		rightFragment = new RightFragment();
		t.replace(R.id.right_frame, rightFragment);
		mainFragment = new MainFragment();
		t.replace(R.id.center_frame, mainFragment);
		t.commit();
		
	}

	public void showRight() {
		mSlidingMenu.showRightView();
		step=1;
	}
	@Override
	public void setContentView() {
		setContentView(R.layout.alidingmenu_activity);
		MobclickAgent.openActivityDurationTrack(false);
		init();
		initListener();
		setData();
		
	}
	@Override
	public void initWidget() {
		 version=new VersionUtil(SlidingActivity.this, null);
		int type=getIntent().getIntExtra("type", 0);
		if(type==1){
			Intent intent=new Intent(this,LoginActivity.class);
			animStartActivity(intent);
		}
	}
	@Override
	public void getData() {
	}
	/**
	 * 退出软件
	 * 
	 * @param keyCode
	 * @param event
	 * @return
	 */
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			boolean isOpenMenu=PreferenceUtils.getPrefBoolean(this, "isOpenSlidingMenu", false);
			if(isOpenMenu){
				showRight();
				PreferenceUtils.setPrefBoolean(this, "isOpenSlidingMenu", false);
				return false;
			}else{
				exitApp();
				return true;
			}
			
		}
		return super.onKeyDown(keyCode, event);
	}

	/**
	 * 退出程序
	 */
	public void exitApp() {
		if ((System.currentTimeMillis() - exitTime) > 2000) {
			Toast.makeText(this, R.string.home_exit_tip,
					Toast.LENGTH_SHORT).show();
			exitTime = System.currentTimeMillis();
		} else {
			finish();
		}
	}
}
