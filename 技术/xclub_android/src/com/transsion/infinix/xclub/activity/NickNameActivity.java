package com.transsion.infinix.xclub.activity;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.content.Intent;
import android.os.Bundle;
import android.text.InputType;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class NickNameActivity extends BaseActivity implements OnClickListener{
	private LinearLayout tvback;
	private Button btComplete;
	private EditText etNickName;
	private int type;
	private TextView tvTitle;
	private TextView tv;
	
	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		etNickName=(EditText)findViewById(R.id.etNickName);
		btComplete=(Button)findViewById(R.id.btComplete);
		tvTitle=(TextView)findViewById(R.id.tvTitle);
		tv=(TextView)findViewById(R.id.tv);
		
		type=getIntent().getIntExtra("type", 0);
		
		if(type==1){
			etNickName.setHint("Enter Phone");
			etNickName.setInputType(InputType.TYPE_CLASS_NUMBER);
			tvTitle.setText("Phone");
			tv.setVisibility(View.VISIBLE);
		}else{
			tv.setVisibility(View.GONE);
		}
		
		
	}
	private void setLisenter() {
		tvback.setOnClickListener(this);
		btComplete.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.btComplete:
			sendNickName();
		default:
			break;
		}
		
	}

	private void sendNickName() {
		String nickName=etNickName.getText().toString();
		if(TextUtils.isEmpty(nickName)&&type!=1){
			ToastManager.showShort(this, "Please fill in the nickname");
			return;
		}else if(TextUtils.isEmpty(nickName)&&type==1){
			ToastManager.showShort(this, "Please fill in your mobile phone number");
			return;
		}
		if(type==1){
			Intent intent=new Intent(Constant.ACTION_PHONE_SUCCESS);
		     intent.putExtra(Constant.KEY_IS_SUCCESS, true);
		     Bundle bundle = new Bundle();
		     bundle.putString("Values",nickName);
			 intent.putExtras(bundle);
			 sendBroadcast(intent);
			 animFinish();
			 return;
		}
		 Intent intent=new Intent(Constant.ACTION_NICKNAME_SUCCESS);
	     intent.putExtra(Constant.KEY_IS_SUCCESS, true);
	     Bundle bundle = new Bundle();
	     bundle.putString("Values",nickName);
		 intent.putExtras(bundle);
		 sendBroadcast(intent);
		animFinish();
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_nickname);
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
