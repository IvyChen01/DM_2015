package com.transsion.infinix.xclub.activity;

import android.content.Intent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.util.Utils;
import com.transsion.infinix.xclub.util.VersionUtil;
import com.trassion.infinix.xclub.R;

public class AboutActivity extends BaseActivity implements OnClickListener{

	private LinearLayout back;
	private TextView tvOffvial;
	private TextView tvBbs;
	private TextView tvFacebook;
	private TextView tvTwitter;
	private ImageView imgAgreement;
	private ImageView imgDisclaimer;
	private TextView tvVersion;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_about);

	}

	@Override
	public void initWidget() {
		back=(LinearLayout)findViewById(R.id.tvback);
		imgAgreement=(ImageView)findViewById(R.id.imgAgreement);
		imgDisclaimer=(ImageView)findViewById(R.id.imgDisclaimer);
		tvOffvial=(TextView)findViewById(R.id.tvOffvial);
		tvBbs=(TextView)findViewById(R.id.tvBbs);
		tvFacebook=(TextView)findViewById(R.id.tvFacebook);
		tvTwitter=(TextView)findViewById(R.id.tvTwitter);
		tvVersion=(TextView)findViewById(R.id.tvVersion);
		tvVersion.setText("Xclub Android "+new VersionUtil(this,null).getVersionNo());
		
        back.setOnClickListener(this);
        imgAgreement.setOnClickListener(this);
        imgDisclaimer.setOnClickListener(this);
        
        Utils.getUtils().addLinks("",tvOffvial);
        Utils.getUtils().addLinks("",tvBbs);
        Utils.getUtils().addLinks("",tvFacebook);
        Utils.getUtils().addLinks("",tvTwitter);
	}

	@Override
	public void getData() {
		

	}

	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.imgAgreement:
			intent.setClass(this, AgreementActivity.class);
			animStartActivity(intent);
			break;
		case R.id.imgDisclaimer:
			intent.setClass(this, DisclaimerActivity.class);
			animStartActivity(intent);
			break;
		default:
			break;
		}
		
	}

}
