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
		//���Activity����ջ
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
	 /** ���ö�Ӧ��XML�����ļ� */
    public abstract void setContentView();

    /** ��ʼ���ؼ� */
    public abstract void initWidget();

    /** ��ʼ������ */
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
     * ����
     */
    public void animFinish(){
//        MasterApplication.getInstanse().closeLoadDataDialogUtil();
    	finish();
    	overridePendingTransition(0, R.anim.roll_down);
    }
    /**
     * ��������Ķ���
     */
    public void initEditTextErrorAnim()
    {
        if (anim == null)
            anim = AnimationUtils.loadAnimation(this, R.anim.shake);
    }

	
}
