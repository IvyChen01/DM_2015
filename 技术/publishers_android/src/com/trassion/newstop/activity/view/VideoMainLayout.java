package com.trassion.newstop.activity.view;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.myinterface.IAppLayout;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;

public class VideoMainLayout extends LinearLayout implements IAppLayout{

	private View rootView;

	public VideoMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public VideoMainLayout(Context context) {
		super(context);
		LayoutInflater mLayoutInflater = LayoutInflater.from(context);
		// 将默认布局加载到View里面
		rootView = mLayoutInflater.inflate(R.layout.video_main, this, true);
	    
		initView();
		initData();
		initListener();
	}

	@Override
	public void initView() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void initData() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void initListener() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onResume() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPause() {
		// TODO Auto-generated method stub
		
	}

}
