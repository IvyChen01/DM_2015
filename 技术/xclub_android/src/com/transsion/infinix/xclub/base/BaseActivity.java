package com.transsion.infinix.xclub.base;




import com.trassion.infinix.xclub.R;
import com.umeng.analytics.MobclickAgent;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;


public abstract class BaseActivity extends FragmentActivity {
	public Animation anim;
	public static Context c;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		CurrentActivityContext.getInstance().setCurrentContext(this);
		c=BaseActivity.this;
		//添加Activity到堆栈
        AppManager.getAppManager().addActivity(this);
        MobclickAgent.updateOnlineConfig(this);
        MobclickAgent.setSessionContinueMillis(600000);
        setContentView();
        initWidget();
        getData();
	}
	@Override
	protected void onResume() {
		// TODO Auto-generated method stub
		super.onResume();
		MobclickAgent.onResume(this);
	}
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		MobclickAgent.onPause(this);
	}
	 /** 设置对应的XML布局文件 */
    public abstract void setContentView();

    /** 初始化控件 */
    public abstract void initWidget();

    /** 初始化数据 */
    public abstract void getData();

	/**
     * 
     * @param intent
     */
    public void animStartActivity(Intent intent){
    	startActivity(intent);
    	overridePendingTransition(R.anim.roll_up, R.anim.roll);
    }
    
    /**
     * 
     * @param intent
     * @param requestCode
     */
    public void animStartActivityForResult(Intent intent, int requestCode){
    	startActivityForResult(intent, requestCode);
    	overridePendingTransition(R.anim.roll_up, R.anim.roll);
    }
    
    /**
     * 结束
     */
    public void animFinish(){
//        MasterApplication.getInstanse().closeLoadDataDialogUtil();
    	finish();
    	overridePendingTransition(0, R.anim.roll_down);
    }
    /**
     * 输入框错误的动画
     */
    public void initEditTextErrorAnim()
    {
        if (anim == null)
            anim = AnimationUtils.loadAnimation(this, R.anim.shake);
    }

	
}
