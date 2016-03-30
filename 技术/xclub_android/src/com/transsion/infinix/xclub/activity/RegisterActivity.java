package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.http.message.BasicNameValuePair;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.UpdatePersonalInformationActivy.CountryReceiver;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.annotation.SuppressLint;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class RegisterActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	
	private LinearLayout tvback;
	private EditText etPoneOrEmail,etName,etPassword,etConfirmPassword,etCode;
	private TextView tvCountry;
	private BaseDao dao;
	private ArrayList<BasicNameValuePair> mParams;
	private Button btComplete;
	private TextView[] textArray=new TextView[2];
	private ImageView[] imageViewArray=new ImageView[2];
	private int currentIndex=-1;
	private ImageView imgEmailCode;
	private ImageLoader mImageLoader;
	private ImageView imgPhoneCode;
	private ImageManager imageManager;
	private CountryReceiver countryReceiver;
	private String values;
	private String country_code;
	private int type;
	private String phoneOrEmail;
	private Button timeOut;
	private int startTime;
	private TimerTask task;
	private int login_type;
	private LinearLayout layout_register_type;
	private String phone;
	private CheckBox checkbox;
	private boolean isCheck;
	private TextView tvTerms;
	private String imgUrl;

	@Override
	protected void onDestroy() {
		// TODO Auto-generated method stub
		unregisterReceiver(countryReceiver);
		super.onDestroy();
	}

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		etPoneOrEmail=(EditText)findViewById(R.id.etPoneOrEmail);
		tvCountry=(TextView)findViewById(R.id.tvCountry);
		etName=(EditText)findViewById(R.id.etName);
		etPassword=(EditText)findViewById(R.id.etPassword);
		etConfirmPassword=(EditText)findViewById(R.id.etConfirmPassword);
		imgEmailCode=(ImageView)findViewById(R.id.imgEmailCode);
		etCode=(EditText)findViewById(R.id.etCode);
		btComplete=(Button)findViewById(R.id.btComplete);
		mImageLoader=ImageLoader.getInstance(this);
		checkbox=(CheckBox)findViewById(R.id.checkbox);
		tvTerms=(TextView)findViewById(R.id.tvTerms);
		layout_register_type=(LinearLayout)findViewById(R.id.layout_register_type);
		textArray[0]=(TextView)findViewById(R.id.tvPhone);
		textArray[1]=(TextView)findViewById(R.id.tvEmail);
		imageViewArray[0]=(ImageView)findViewById(R.id.imageView1);
		imageViewArray[1]=(ImageView)findViewById(R.id.imageView2);
		imgPhoneCode=(ImageView)findViewById(R.id.imgPhoneCode);
		imgEmailCode=(ImageView)findViewById(R.id.imgEmailCode);
		timeOut=(Button)findViewById(R.id.timeOut);
		
		tvback.setOnClickListener(this);
		btComplete.setOnClickListener(this);
		imgPhoneCode.setOnClickListener(this);
		imgEmailCode.setOnClickListener(this);
		tvCountry.setOnClickListener(this);
		tvTerms.setOnClickListener(this);
		
		for (TextView textView : textArray) {
	    	textView.setOnClickListener(this);
		}
		for (ImageView imageView : imageViewArray) {
			imageView.setOnClickListener(this);
		}
		checkbox.setOnCheckedChangeListener(new OnCheckedChangeListener() {
			

			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				isCheck=isChecked;
				
			}
		});
//		reset();
	}
	private void setUpView() {
		// TODO Auto-generated method stub
		login_type=getIntent().getIntExtra("Login_type", 0);
		if(login_type==1){
			layout_register_type.setVisibility(View.GONE);
			imgPhoneCode.setVisibility(View.GONE);
			imgEmailCode.setVisibility(View.VISIBLE);
			etPoneOrEmail.setHint("Enter the Email");
			type=1;
			getEmailCode();
		}else if(login_type==2){
			layout_register_type.setVisibility(View.GONE);
			imgPhoneCode.setVisibility(View.VISIBLE);
			imgEmailCode.setVisibility(View.GONE);
			type=0;
		}else{
			layout_register_type.setVisibility(View.VISIBLE);
			imgPhoneCode.setVisibility(View.VISIBLE);
			imgEmailCode.setVisibility(View.GONE);
			type=0;
		}
	}
	private void getPhoneCode() {
		startTime=60;
		phoneOrEmail=etPoneOrEmail.getText().toString().trim();
		String country=tvCountry.getText().toString();
		
		if(country.equals("Choose the country")){
			ToastManager.showShort(this, "Choose the country");
			return;
		}
		if(TextUtils.isEmpty(phoneOrEmail)){
			initEditTextErrorAnim();
			etPoneOrEmail.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your mobile phone");
			return;
		}
	    ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
	    mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("module","verificationcode"));
        mParams.add(new BasicNameValuePair("internationalCode",country_code));
        mParams.add(new BasicNameValuePair("tel",phoneOrEmail));
        mParams.add(new BasicNameValuePair("flag","1"));
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(this, dao);
	}
	private void getEmailCode() {
		// TODO Auto-generated method stub
		mParams=new ArrayList<BasicNameValuePair>();
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("module","seccodehtml"));
        if(imgUrl!=null){
        mImageLoader.removeCacheImage(imgUrl);
        mImageLoader.memoryCache.remove(imgUrl);
        }
		dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(this, dao);
       
	}

	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		Bundle bundle = new Bundle();
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.tvTerms:
			intent.setClass(RegisterActivity.this, AgreementActivity.class);
			animStartActivity(intent);
			break;
		case R.id.btComplete:
			Register();
			break;
		case R.id.tvPhone:
			currentIndex=0;
			type=0;
			imgPhoneCode.setVisibility(View.VISIBLE);
			imgEmailCode.setVisibility(View.GONE);
			etPoneOrEmail.setHint("Enter Phone number");
			ClearEditText();
			break;
		case R.id.tvCountry:
			intent.setClass(RegisterActivity.this, ProvinceCountryProfessionActivity.class);
			bundle.putString("type", "1");
			intent.putExtras(bundle);
			animStartActivity(intent);
			break;
		case R.id.tvEmail:
			currentIndex=1;
			type=1;
			etPoneOrEmail.setHint("Enter the Email");
			imgEmailCode.setVisibility(View.VISIBLE);
			imgPhoneCode.setVisibility(View.GONE);
			timeOut.setVisibility(View.GONE);
			ClearEditText();
			getEmailCode();
			break;
		case R.id.imgEmailCode:
			getEmailCode();
			break;
		case R.id.imgPhoneCode:
			getPhoneCode();
			break;
		default:
			break;
		}
		if(currentIndex>=0){
		   updateButtonTextColor();
		}
	}

	private void ClearEditText() {
		tvCountry.setText("Choose the country");
		etPoneOrEmail.setText("");
		etName.setText("");
		etPassword.setText("");
		etConfirmPassword.setText("");
		etCode.setText("");
		
	}
	private void updateButtonTextColor() {
		for (int i = 0; i < textArray.length; i++) {
			if (i == currentIndex) {
				textArray[i].setTextColor(0xFF000000);
				imageViewArray[i].setVisibility(View.VISIBLE);
			} else {
				textArray[i].setTextColor(0xFFA1A1A1);
				imageViewArray[i].setVisibility(View.GONE);
			}
		}
        currentIndex=-1;
		
	}

	private void Register() {
		phoneOrEmail=etPoneOrEmail.getText().toString().trim();
		String useName=etName.getText().toString().trim();
		String pwd=etPassword.getText().toString().trim();
		String confirmPwd=etConfirmPassword.getText().toString().trim();
		String code=etCode.getText().toString().trim();
		String country=tvCountry.getText().toString();
		
		if(country.equals("Choose the country")){
			ToastManager.showShort(this, "Choose the country");
			return;
		}
		if(TextUtils.isEmpty(phoneOrEmail)){
			initEditTextErrorAnim();
			etPoneOrEmail.startAnimation(anim);
			if(type==0){
			    ToastManager.showShort(this, "Please enter your mobile phone");
			}else if(type==1){
				ToastManager.showShort(this, "Please enter your email address");	
			}
			return;
		}
		if(TextUtils.isEmpty(useName)){
			initEditTextErrorAnim();
			etName.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your username");
			return;
		}
		if(TextUtils.isEmpty(pwd)){
			initEditTextErrorAnim();
			etPassword.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your password");
			return;
		}
		if(TextUtils.isEmpty(confirmPwd)){
			initEditTextErrorAnim();
			etConfirmPassword.startAnimation(anim);
			ToastManager.showShort(this, "Please enter your password again");
			return;
		}
		if(!pwd.equals(confirmPwd)){
			ToastManager.showShort(this, "Two times the password is not consistent");
			return;
		}
		if(TextUtils.isEmpty(code)){
			initEditTextErrorAnim();
			etCode.startAnimation(anim);
			ToastManager.showShort(this, "Please enter the verification code");
			return;
		}
		if(!isCheck){
			ToastManager.showShort(this, "Whether to agree to the terms of the agreement ");
			return;
		}
		if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
		
		mParams=new ArrayList<BasicNameValuePair>();
		mParams.clear();
		if(type==0){
			    mParams.add(new BasicNameValuePair("version","5"));
		        mParams.add(new BasicNameValuePair("mobile","no"));
		        mParams.add(new BasicNameValuePair("module","registerbyphone"));
		        mParams.add(new BasicNameValuePair("nick",useName));
		        mParams.add(new BasicNameValuePair("password",pwd));
		        mParams.add(new BasicNameValuePair("password2",confirmPwd));
		        mParams.add(new BasicNameValuePair("vcode",code));
		        mParams.add(new BasicNameValuePair("tel",phoneOrEmail));
		}else if(type==1){
                mParams.add(new BasicNameValuePair("version","5"));
                mParams.add(new BasicNameValuePair("mobile","no"));
                mParams.add(new BasicNameValuePair("module","register"));
                mParams.add(new BasicNameValuePair("username",useName));
                mParams.add(new BasicNameValuePair("password",pwd));
                mParams.add(new BasicNameValuePair("password2",confirmPwd));
                mParams.add(new BasicNameValuePair("email",phoneOrEmail));
                mParams.add(new BasicNameValuePair("code",code));
		}
		        dao = new BaseDao(this, mParams, this, null);
                dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                    Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(RegisterActivity.this, dao);
	}

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}
	final Handler handler = new Handler() {
		@Override
		public void handleMessage(Message msg) {
			// 因为有重新发送,这个方法会重复掉用;
			switch (msg.what) {
			case 1:
			    
			    
			    if(startTime==0){
                    timeOut.setText("(60 seconds later) to send ");
                }else{
                    timeOut.setText("(" + startTime + "seconds later) to send");
                }
                
                if (startTime <=0){
                    task.cancel();
                    imgPhoneCode.setVisibility(View.VISIBLE);
                    timeOut.setVisibility(View.GONE);
                }
			}
		  }
		};

	@Override
	public void onComplete(BaseEntity result) {
		 MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			LoginInfo logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getUrl()!=null){
                imgUrl=logininfo.getVariables().getUrl();
				mImageLoader.DisplayImage(logininfo.getVariables().getUrl(),imgEmailCode, 1, Constant.LESSNUM, 0, R.drawable.code_deft);
				
			}
			 if(logininfo.getVariables().getMessage()!=null&&!logininfo.getVariables().getMessage().equals("succeed")){
					ToastManager.showShort(this, logininfo.getVariables().getMessage());
			}
			 if(logininfo.getVariables().getPhonecode()!=null){
				 if(logininfo.getVariables().getPhonecode().equals("0")){
					 if (null != task) {
							task.cancel();
						}
						task = new TimerTask() {
							@Override
							public void run() {
//								if (startTime == 0) {
//									startTime = 59;
//								}
								startTime--;

								Message message = new Message();
								message.what = 1;
								handler.sendMessage(message);
							}
						};
						Timer timer = new Timer();
						timer.schedule(task, 1000, 1000);
						imgPhoneCode.setVisibility(View.GONE);
						timeOut.setVisibility(View.VISIBLE);
						
				 }else{
					 ToastManager.showShort(this,logininfo.getVariables().getMessage() );
				 }
			 }
			 if(logininfo.getMessage().getMessageval()!=null){
			 if(logininfo.getMessage().getMessageval().equals("register_succeed")){
				 ToastManager.showLong(this, "Registered success");
				 register();
			 }else{
				 //登录失败
				 ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
			 }
		   }
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
		}
		
	}
	

	private void register() {
		animFinish();
		
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
	class CountryReceiver extends BroadcastReceiver{

		@Override
		public void onReceive(Context context, Intent intent) {
			String action = intent.getAction();
			if(action.equals(Constant.ACTION_CHOOSECOUNTRY_SUCCESS)){
			boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
			  if(isSuccess){
				  Bundle extras = intent.getExtras();
				  values=extras.getString("Values");
				  country_code=extras.getString("Code");
				  tvCountry.setText(values);
				 
			  }
			}
		}
	}
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_register);
		initView();
		setUpView();
		
	}

	@Override
	public void initWidget() {
		countryReceiver=new CountryReceiver();
		IntentFilter filter=new IntentFilter(Constant.ACTION_CHOOSECOUNTRY_SUCCESS);
		registerReceiver(countryReceiver, filter);
		
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
	
}
