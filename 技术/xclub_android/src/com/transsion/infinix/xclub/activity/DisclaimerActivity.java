package com.transsion.infinix.xclub.activity;

import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.trassion.infinix.xclub.R;

public class DisclaimerActivity extends BaseActivity implements OnClickListener{

	private LinearLayout tvback;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_disclaimer);
        
	}

	@Override
	public void initWidget() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
        
		tvback.setOnClickListener(this);
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub

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

}
