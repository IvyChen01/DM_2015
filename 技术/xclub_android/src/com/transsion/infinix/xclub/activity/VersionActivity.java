package com.transsion.infinix.xclub.activity;

import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.trassion.infinix.xclub.R;

public class VersionActivity extends BaseActivity implements OnClickListener{
    
    private LinearLayout tvback;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		
		tvback.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;

		default:
			break;
		}
		
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_version);
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
