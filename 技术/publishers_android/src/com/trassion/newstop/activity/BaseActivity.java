package com.trassion.newstop.activity;



import com.trassion.newstop.application.CurrentActivityContext;
import com.trassion.newstop.listener.BackGestureListener;
import com.trassion.newstop.type.CalligraphyContextWrapper;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.GestureDetector;
import android.view.MotionEvent;
import android.view.View;

public abstract class BaseActivity extends FragmentActivity{
	
	private GestureDetector mGestureDetector;
	/** �Ƿ���Ҫ�������ƹرչ��� */
	private boolean mNeedBackGesture = false;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		CurrentActivityContext.getInstance().setCurrentContext(this);
		initGestureDetector();
		 setContentView();
	        initWidget();
	        initData();
	}
	private void initGestureDetector() {
		if (mGestureDetector == null) {
			mGestureDetector = new GestureDetector(getApplicationContext(),
					new BackGestureListener(this));
		}
	}

	@Override
	public boolean dispatchTouchEvent(MotionEvent ev) {
		// TODO Auto-generated method stub
		if(mNeedBackGesture){
			return mGestureDetector.onTouchEvent(ev) || super.dispatchTouchEvent(ev);
		}
		return super.dispatchTouchEvent(ev);
	}
	
	/*
	 * �����Ƿ�������Ƽ���
	 */
	public void setNeedBackGesture(boolean mNeedBackGesture){
		this.mNeedBackGesture = mNeedBackGesture;
	}
	
	/*
	 * ����
	 */
	public void doBack(View view) {
		onBackPressed();
	}
	protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
	@Override
	public void onBackPressed() {
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}
	public void animStartActivityForResult(Intent intent, int requestCode){
    	startActivityForResult(intent, requestCode);
    	overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
    }
	public void StartActivity(Class<? extends Activity> activity) {
		Intent intent = new  Intent(this, activity);
		startActivity(intent);
		overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
		
	}
	public void StartActivityForResult(Class<? extends Activity> activity, int requestCode,String type){
		Intent intent = new  Intent(this, activity);
		intent.putExtra("CODE", type);
    	startActivityForResult(intent, requestCode);
    	overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
    }
	 /** ���ö�Ӧ��XML�����ļ� */
    public abstract void setContentView();

    /** ��ʼ���ؼ� */
    public abstract void initWidget();

    /** ��ʼ������ */
    public abstract void initData();
}
