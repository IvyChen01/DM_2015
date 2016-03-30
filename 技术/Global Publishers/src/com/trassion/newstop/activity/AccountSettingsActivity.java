package com.trassion.newstop.activity;


import java.io.File;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.twitter.Twitter;

import com.alibaba.fastjson.JSON;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.view.MineMainLayout;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.HeaderPhotoInfo;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopChangeSignatureBeanresponse;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.config.Configurations;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.HttpFormUtil;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.IMageUtil;
import com.trassion.newstop.image.ImageCutActivity;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.SelectDialog;

import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Typeface;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;
import android.widget.CompoundButton.OnCheckedChangeListener;

public class AccountSettingsActivity extends BaseActivity implements OnClickListener,DialogInterface.OnClickListener,UICallBackInterface,PlatformActionListener{

	private TextView title;
	private TextView twoTitle;
	private RelativeLayout layout_Header;
	private String mImageFilePath; //���� ��ַ 
	private String path;
	private ImageView imgHead;
	private RelativeLayout layout_NickName;
	private RelativeLayout layout_phone;
	private RelativeLayout layout_email;
	private RelativeLayout layout_signature;
	private ToggleButton togglebutton_facebook;
//	private ToggleButton togglebutton_google;
	private ToggleButton togglebutton_twitter;
//	private ToggleButton togglebutton_instagram;
	private String username;
	private String signature;
	private String phone;
	private String photoUrl;
	private String email;
	private ImageLoader imageloader;
	private TextView tvName;
	private TextView tvSignture;
	private TextView tvPhone;
	private TextView tvEmail;
	private String nick;
	private RelativeLayout rlSignOut;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private HeaderPhotoInfo photo;
	private NewsTopRegisterBeanresponse response;
	private RelativeLayout rlPwd;
	private ImageManager imageManager;
	private Handler mhandler;
	
	public static final int REQUEST_SIGNATURE = 6;
	public static final int REQUEST_NICK = 7;
	private static final int REQUEST_CAMERA = 8;
	public static final int REQUEST_EMAIL = 9;
	public static final int REQUEST_PHONE = 10;
	private static final int REQUEST_IMG_CUT = 13;
    private static final int REQUEST_PICTURE = 12;
    
    private static final int MSG_USERID_FOUND = 11;
	private static final int MSG_LOGIN = 12;
	private static final int MSG_AUTH_CANCEL = 13;
	private static final int MSG_AUTH_ERROR= 14;
	private static final int MSG_AUTH_COMPLETE = 15;
	@Override
	public void setContentView() {
		requestWindowFeature(Window.FEATURE_NO_TITLE); 
		setContentView(R.layout.activity_account_settings);
		
		  request = new NewsTopInfoListRequest(this);
		  mHttpAgent = new HttpTransAgent(this,this);
			
		  auth=PreferenceUtils.getPrefString(this, "auth", "");
		  saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");

		
		  imageloader=ImageLoader.getInstance();
		  imageManager=new ImageManager();
		  
		  mhandler = new Handler();
		  
		  username=PreferenceUtils.getPrefString(this, "username", "");
		  nick=PreferenceUtils.getPrefString(this, "nick", "");
		  signature=PreferenceUtils.getPrefString(this, "signature", "");
		  phone=PreferenceUtils.getPrefString(this, "phone", "");
		  photoUrl=PreferenceUtils.getPrefString(this, "photo", "");
		  email=PreferenceUtils.getPrefString(this, "email", "");
	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		layout_Header=(RelativeLayout)findViewById(R.id.llHead);
		layout_NickName=(RelativeLayout)findViewById(R.id.rlNickName);
		layout_phone=(RelativeLayout)findViewById(R.id.rlPhone);
		layout_email=(RelativeLayout)findViewById(R.id.rlEmail);
		layout_signature=(RelativeLayout)findViewById(R.id.rlSignature);
		rlPwd=(RelativeLayout)findViewById(R.id.rlPwd);
		rlSignOut=(RelativeLayout)findViewById(R.id.rlSignOut);
		
		imgHead=(ImageView)findViewById(R.id.imgHead);//ͷ��
		tvName=(TextView)findViewById(R.id.tvName);
		tvSignture=(TextView)findViewById(R.id.tvSignture);
		tvPhone=(TextView)findViewById(R.id.tvPhone);
		tvEmail=(TextView)findViewById(R.id.tvEmail);
		 photo=new HeaderPhotoInfo();
		
		tvName.setText(nick);
		tvSignture.setText(signature);
		tvPhone.setText(phone);
		tvEmail.setText(email);
		
		imageloader.displayImage(photoUrl, imgHead,imageManager.option,imageManager.animateFirstListener);
		
		togglebutton_facebook=(ToggleButton)findViewById(R.id.togglebutton_facebook);
//		togglebutton_google=(ToggleButton)findViewById(R.id.togglebutton_google);
		togglebutton_twitter=(ToggleButton)findViewById(R.id.togglebutton_twitter);
//		togglebutton_instagram=(ToggleButton)findViewById(R.id.togglebutton_instagram);
		
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		title.setText("Account Settings");
		
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		twoTitle.setTypeface(type);
		
		
		
		layout_Header.setOnClickListener(this);
		layout_NickName.setOnClickListener(this);
		layout_phone.setOnClickListener(this);
		layout_email.setOnClickListener(this);
		layout_signature.setOnClickListener(this);
		rlSignOut.setOnClickListener(this);
		rlPwd.setOnClickListener(this);
		
		togglebutton_facebook.setOnCheckedChangeListener(mFacebookModeChangeListener);
//		togglebutton_google.setOnCheckedChangeListener(mGoogleModeChangeListener);
		togglebutton_twitter.setOnCheckedChangeListener(mTwitterModeChangeListener);
//		togglebutton_instagram.setOnCheckedChangeListener(mInstagramModeChangeListener);

	}
	public boolean handleMessage(Message msg) {
		switch(msg.what) {
			case MSG_USERID_FOUND: {
				//����û��Ѿ���¼����ȡ�û�useID
//				Toast.makeText(context, R.string.userid_found, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_LOGIN: {
				//����ע��ҳ��
//				AuthManager.showDetailPage(context, ShareSDK.platformNameToId(String.valueOf(msg.obj)));
			}
			break;
			case MSG_AUTH_CANCEL: {
				//ȡ����Ȩ
				Toast.makeText(this, R.string.auth_cancel, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_ERROR: {
				//��Ȩʧ��
				Toast.makeText(this, R.string.auth_error, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_COMPLETE: {
			}
			break;
			
		}
		return false;
	}
	private void login(String plat, String userId, HashMap<String, Object> userInfo) {
		Message msg = new Message();
		msg.what = MSG_LOGIN;
		msg.obj = plat;
		mhandler.sendMessage(msg);
	}
	//ִ����Ȩ,��ȡ�û���Ϣ
			//�ĵ���http://wiki.mob.com/Android_%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E8%B5%84%E6%96%99
			private void authorize(Platform plat) {
				if (plat == null) {
//					popupOthers();
					return;
				}
				
				if(plat.isValid()) {
					String userId = plat.getDb().getUserId();
					if (!TextUtils.isEmpty(userId)) {
						mhandler.sendEmptyMessage(MSG_USERID_FOUND);
						login(plat.getName(), userId, null);
						return;
					}
				}
				plat.setPlatformActionListener(AccountSettingsActivity.this);
				//�ر�SSO��Ȩ
				plat.SSOSetting(true);
				plat.showUser(null);
			}
	OnCheckedChangeListener mFacebookModeChangeListener = new OnCheckedChangeListener() {

		@Override
		public void onCheckedChanged(CompoundButton buttonView,
				boolean isChecked) {
			if (isChecked == true) {
				 ShareSDK.initSDK(AccountSettingsActivity.this);
				 Platform facebook = ShareSDK.getPlatform(Facebook.NAME);
				 facebook.setPlatformActionListener(AccountSettingsActivity.this);
				 authorize(facebook);
			} else {
				
			}
		}
	};
//	OnCheckedChangeListener mGoogleModeChangeListener = new OnCheckedChangeListener() {
//
//		@Override
//		public void onCheckedChanged(CompoundButton buttonView,
//				boolean isChecked) {
//			if (isChecked == true) {
//				
//			} else {
//				
//			}
//		}
//	};
	OnCheckedChangeListener mTwitterModeChangeListener = new OnCheckedChangeListener() {

		@Override
		public void onCheckedChanged(CompoundButton buttonView,
				boolean isChecked) {
			if (isChecked == true) {
				ShareSDK.initSDK(AccountSettingsActivity.this);
				Platform twitter = ShareSDK.getPlatform(Twitter.NAME);
				twitter.setPlatformActionListener(AccountSettingsActivity.this);
				 authorize(twitter);
			} else {
				
			}
		}
	};
//	OnCheckedChangeListener mInstagramModeChangeListener = new OnCheckedChangeListener() {
//
//		@Override
//		public void onCheckedChanged(CompoundButton buttonView,
//				boolean isChecked) {
//			if (isChecked == true) {
//				
//			} else {
//				
//			}
//		}
//	};

	@Override
	public void initData() {
		// TODO Auto-generated method stub

	}
	@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub
		super.onBackPressed();
		Intent intent = new Intent(getApplicationContext(), MainActivity.class);
		setResult(MainActivity.ACCOUNTREQUEST, intent);
		finish();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.llHead:
			new SelectDialog(this).choosePicDialog().show();
			break;
		case R.id.rlNickName:
			StartActivityForResult(NickNameActivity.class, REQUEST_NICK,"nick");
			break;
		case R.id.rlSignature:
			StartActivityForResult(SignatureActivity.class, REQUEST_SIGNATURE,"signature");
			break;
		case R.id.rlEmail:
			StartActivityForResult(ChangeEmailActivity.class, REQUEST_EMAIL,"email");
			break;
		case R.id.rlPhone:
			StartActivityForResult(ChangeEmailActivity.class, REQUEST_PHONE,"phone");
			break;
		case R.id.rlPwd:
			StartActivity(ChangePasswordActivity.class);
			break;
		case R.id.rlSignOut:
			requstLoginOut();
			break;
		default:
			break;
		}
		
	}

	private void requstLoginOut() {
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByLoginOutRequest(mHttpAgent, Utils.getPhoneIMEI(this),auth,saltkey,Constants.HTTP_LOGIN_OUT);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void onClick(DialogInterface dialog, int which) {
		switch (which) {
		case 0://ͼƬ
			Intent intent = new Intent(
					Intent.ACTION_PICK,
					android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
			animStartActivityForResult(intent, REQUEST_PICTURE);
			break;
		case 1://����
			boolean sdCardExist = Environment.getExternalStorageState().equals(
					android.os.Environment.MEDIA_MOUNTED);
			if (sdCardExist) {

				Intent intentCamera = new Intent(
						"android.media.action.IMAGE_CAPTURE");
				// ������Ƭ ��ַ
				mImageFilePath = "/mnt/sdcard/newsTopImageCache/";
				File file = new File(mImageFilePath);
				if (!file.exists()) {
					file.mkdir();
				}
				// ��� �����Ƭ��
				SimpleDateFormat s = new SimpleDateFormat("yyyyMMddHHmmss");
				String uristr = s.format(new Date());
				File mOutPhotoFile = new File(mImageFilePath, uristr + ".png");
				Uri uri = Uri.fromFile(mOutPhotoFile);
				intentCamera.putExtra(MediaStore.EXTRA_OUTPUT, uri);
				intentCamera.putExtra(MediaStore.EXTRA_VIDEO_QUALITY, 1);
				mImageFilePath = mOutPhotoFile.getAbsolutePath();

				animStartActivityForResult(intentCamera, REQUEST_CAMERA);
			} else {
				Toast.makeText(this, "Sorry, please insert the SD card", Toast.LENGTH_SHORT).show();
			}
		default:
			break;
		}
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if(requestCode== REQUEST_NICK){
			String nick=PreferenceUtils.getPrefString(this, "nick", "");
			tvName.setText(nick);
		}else if(requestCode==REQUEST_SIGNATURE){
			String signature=PreferenceUtils.getPrefString(this, "signature", "");
			tvSignture.setText(signature);
		}else if(requestCode==REQUEST_EMAIL){
			String email=PreferenceUtils.getPrefString(this, "email", "");
			tvEmail.setText(email);
			
		}else if(requestCode==REQUEST_PHONE){
			String phone=PreferenceUtils.getPrefString(this, "phone", "");
			tvPhone.setText(phone);
		}
		else if (requestCode == REQUEST_CAMERA) {// �����ϴ�

			if (mImageFilePath == null) {
				return;
			}
			File tempFile = new File(mImageFilePath);
			if (tempFile!= null && tempFile.exists()) {// �ж� ��ǰ�Ƿ� ����
				Uri uri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
				if (uri!= null) {
					Intent intents = new Intent(this, ImageCutActivity.class);
					intents.putExtra(ImageCutActivity.PATH, mImageFilePath);
					animStartActivityForResult(intents, REQUEST_IMG_CUT);

				} else {
					ToastManager.showShort(this, "The photo was not found");
				}
			}

			// ͷ��
			// imageView_touXinag = (ImageView) findViewById(R.id.myPhoto);
			// imageView_touXinag.setImageBitmap(returnBitMap(userInfo.getPhoto_file_name()));

			// listview_foot_progress=(ProgressBar)findViewById(R.id.listview_foot_progress);
		} else if (requestCode == REQUEST_PICTURE) {// ѡ�񱾵�ͼƬ
			if (data == null) {
				return;
			}
			// File tempFile = new File(mImageFilePath);
			// if (tempFile != null && tempFile.exists())
			// {// �жϵ�ǰ ͼƬ �Ƿ����
			// return;
			// }
			try {
				Uri uri = data.getData();
				if (uri != null) {
					String[] proj = { MediaStore.Images.Media.DATA };

					Cursor cursor = managedQuery(uri, proj, null, null, null);
					int column_index = cursor
							.getColumnIndexOrThrow(MediaStore.Images.Media.DATA); //
					cursor.moveToFirst(); //
					mImageFilePath = cursor.getString(column_index);
					Intent intents = new Intent(this, ImageCutActivity.class);
					intents.putExtra(ImageCutActivity.PATH, mImageFilePath);
					animStartActivityForResult(intents, REQUEST_IMG_CUT);
				} else {
					ToastManager.showShort(this, "The photo was not found");
				}

			} catch (Exception e) {
				ToastManager.showShort(this, "Sorry, the file format you choose is a problem");
			}
		} else if (requestCode == REQUEST_IMG_CUT) {
			if (null == data) {
				return;
			}
			path = data.getStringExtra(ImageCutActivity.RESULT_PATH);
			// ��ʼ�ϴ�ͷ��
			loadImg(path);
		} 
		super.onActivityResult(requestCode, resultCode, data);
	}
	private void loadImg(String path) {
		// TODO Auto-generated method stub
		Log.i("path","path:"+path);
		 final Map<String, String> params = new HashMap<String, String>();
		 params.put("imei", Utils.getPhoneIMEI(this));
		 params.put("saltkey", saltkey);
         params.put("auth", auth);
         params.put("filePath", path);
         mHttpAgent.isShowProgress=true;
         Runnable runnable=new Runnable() {
				
				@Override
				public void run() {
					Message msg=new Message();
					Bundle data=new Bundle();
					String result = HttpFormUtil.post(Configurations.URL_NEWSTOP_UPLOAD_PHOTO, params);
					data.putString("value", result);
					msg.setData(data);
					handler.sendMessage(msg);
				}
			};
			new Thread(runnable).start();
		
	}
   Handler handler=new Handler(){
		@SuppressWarnings("null")
		public void handleMessage(Message msg) {
			mHttpAgent.isShowProgress=false;
			Bundle data=msg.getData();
			String result=data.getString("value");
			if(result!=null){
				HeaderPhotoInfo photoInfo=JSON.parseObject(result.toString(), photo.getClass());
			if(photoInfo.getCode().equals("0")){
				ToastManager.showShort(AccountSettingsActivity.this, "Success!");
				if (!TextUtils.isEmpty(path)) {
					Bitmap bitmap=BitmapFactory.decodeFile(path);
					imgHead.setImageBitmap(IMageUtil.toRoundBitmap(bitmap));
					PreferenceUtils.setPrefString(AccountSettingsActivity.this, "photo", photoInfo.getPhoto());
				}
				
			}else{
				ToastManager.showShort(AccountSettingsActivity.this, photoInfo.getMsg());
			}
			}else{
				ToastManager.showShort(AccountSettingsActivity.this, "Unable to connect to the network, please check your network");
			}
		 }
   
		};

	

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopRegisterBeanresponse)bean;
			if(response.getCode().equals("0")){
				PreferenceUtils.setPrefBoolean(this, "isLogin", false);
				Intent intent=new Intent(this,MainActivity.class);
				setResult(RESULT_OK, intent);
				
				onBackPressed();
			}else{
				ToastManager.showLong(this, response.getMsg());
			}
		}
		
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			ToastManager.showLong(this, R.string.common_cannot_connect);
		}
		
	}

	@Override
	public void onCancel(Platform arg0, int arg1) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(Platform arg0, int arg1, HashMap<String, Object> arg2) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onError(Platform arg0, int arg1, Throwable arg2) {
		// TODO Auto-generated method stub
		
	}

}
