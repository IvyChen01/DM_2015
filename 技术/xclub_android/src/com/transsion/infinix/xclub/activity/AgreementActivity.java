package com.transsion.infinix.xclub.activity;

import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.util.VersionUtil;
import com.trassion.infinix.xclub.R;

public class AgreementActivity extends BaseActivity implements OnClickListener{

	private LinearLayout back;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_agreement);
        
	}

	@Override
	public void initWidget() {
		back=(LinearLayout)findViewById(R.id.tvback);
		
        back.setOnClickListener(this);
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
