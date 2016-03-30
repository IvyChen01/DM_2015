package com.transsion.infinix.xclub.activity;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.trassion.infinix.xclub.R;

import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.RelativeLayout;

public class SingeNatureActivity extends BaseActivity implements OnClickListener{
        private RelativeLayout tvback;

		private void initView() {
			tvback=(RelativeLayout)findViewById(R.id.title_left);
		}

		private void setLisenter() {
			tvback.setOnClickListener(this);
		}

		@Override
		public void onClick(View v) {
			switch (v.getId()) {
			case R.id.title_left:
				animFinish();
				break;

			default:
				break;
			}
			
		}

		@Override
		public void setContentView() {
			setContentView(R.layout.activity_signature);
	    	initView();
	    	setLisenter();
			
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
