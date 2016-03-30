package com.transsion.infinix.xclub.activity;

import java.io.File;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.HttpFormUtil;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageCutActivity;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.IMageUtil;
import com.transsion.infinix.xclub.util.LevelUtil;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.ModifyAvatarDialog;
import com.trassion.infinix.xclub.R;

import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
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
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

public class PersonalCenterActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
    private LinearLayout tvback;
    private RelativeLayout layout_level;
	private Button btSignOut;
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private LoginInfo logininfo;
	private ImageView imghead;
	 /** 照相 地址 */
	private String mImageFilePath;
	private String path;
	private RelativeLayout updatePwd;
	private RelativeLayout ll_Information;
	private String uid;
	private String saltkey;
	private String auth;
	private String sys_authkey;
	private MasterApplication masterApplication;
	private ImageLoader mImgLoader;
//	private ImageManager imageManager;
	private TextView tvName;
	private TextView tvpoints;
	private TextView tvLevel;
	private ImageView imgLevel;
	private RelativeLayout relativelayout_level;
	private TextView tvAdmin;
	private String url;
	private static final int REQUEST_IMG_CUT = 13;
    private static final int REQUEST_CAMERA = 8;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		layout_level=(RelativeLayout)findViewById(R.id.layout_level);
		tvpoints=(TextView)findViewById(R.id.tvpoints);
		btSignOut=(Button)findViewById(R.id.btSignOut);
		imghead=(ImageView)findViewById(R.id.imghead);
		tvLevel=(TextView)findViewById(R.id.tvLevel);
		imgLevel=(ImageView)findViewById(R.id.imgLevel);
		tvName=(TextView)findViewById(R.id.tvName);
		updatePwd=(RelativeLayout)findViewById(R.id.updatePwd);
		ll_Information=(RelativeLayout)findViewById(R.id.ll_Information);
		relativelayout_level=(RelativeLayout)findViewById(R.id.relativelayout_level);
		tvAdmin=(TextView)findViewById(R.id.tvAdmin);
		
		masterApplication=MasterApplication.getInstanse();
		mImgLoader = ImageLoader.getInstance(this);
//	    imageManager=new ImageManager();
		
	}
	private void setListener() {
		tvback.setOnClickListener(this);
		layout_level.setOnClickListener(this);
		btSignOut.setOnClickListener(this);
		imghead.setOnClickListener(this);
		updatePwd.setOnClickListener(this);
		ll_Information.setOnClickListener(this);
	}
	private void setData() {
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
		auth=PreferenceUtils.getPrefString(this, "auth", "");
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    sys_authkey=PreferenceUtils.getPrefString(this, "sys_authkey", "");
	    
	    url=PreferenceUtils.getPrefString(this, "URL", "");
	    String tid=PreferenceUtils.getPrefString(this, "UID", "");
	    String userName=PreferenceUtils.getPrefString(this, "UserName", "");
	    String credits=PreferenceUtils.getPrefString(this, "Credits", "");
	    String currentlevel=PreferenceUtils.getPrefString(this, "Level", "");
	    if(tid.equals(uid)){
	    	   new LevelUtil(this).SetLevel(relativelayout_level, tvAdmin, currentlevel, imgLevel, tvLevel);
	    		 tvName.setText(userName);
	    		 tvpoints.setText(credits+" points");
	    		 
	    		 mImgLoader.DisplayImage(url, imghead, 1, Constant.LESSNUM, 60, R.drawable.img_head_bg);
	    }else if(masterApplication.logininfo!=null &&masterApplication.logininfo.getVariables().getAvatar()!=null){
		    	String uri=masterApplication.logininfo.getVariables().getAvatar().substring(masterApplication.logininfo.getVariables().getAvatar().indexOf("http"),masterApplication.logininfo.getVariables().getAvatar().indexOf("small") + 5);
		    	mImgLoader.DisplayImage(uri, imghead, 1, Constant.LESSNUM, 60, R.drawable.img_head_bg);
		    	tvName.setText(masterApplication.logininfo.getVariables().getUsername());
		    	tvpoints.setText(masterApplication.logininfo.getVariables().getCredits()+" points");
		    	 String level=masterApplication.logininfo.getVariables().getLevel();
		    	 new LevelUtil(this).SetLevel(relativelayout_level, tvAdmin, level, imgLevel, tvLevel);
		    }
	}
	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.layout_level:
			intent.setClass(this, IntegraiActivity.class);
			animStartActivity(intent);
			break;
		case R.id.btSignOut:
			 if(!NetUtil.isConnect(this)){
		 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
		 			return;
		 		}
			SignOut();
			break;
		case R.id.imghead:
			showChooiceDialog();
			break;
		case R.id.updatePwd:
			intent.setClass(this, ChangePasswordActivity.class);
			animStartActivity(intent);
			break;
		case R.id.ll_Information:
			intent.setClass(this, UpdatePersonalInformationActivy.class);
			animStartActivity(intent);
			break;
		default:
			break;
		}
		
	}
	private void showChooiceDialog() {
		//调用选择那种方式的dialog
				ModifyAvatarDialog modifyAvatarDialog = new ModifyAvatarDialog(this){
					//选择本地相册
					@Override
					public void doGoToImg() {
						this.dismiss();
						Intent intent1 = new Intent(
								Intent.ACTION_PICK,
								android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
						animStartActivityForResult(intent1, 12);
					}
					//选择相机拍照
					@Override
					public void doGoToPhone() {
						this.dismiss();
						boolean sdCardExist = Environment.getExternalStorageState().equals(
								android.os.Environment.MEDIA_MOUNTED);
						if (sdCardExist) {

							Intent intentCamera = new Intent(
									"android.media.action.IMAGE_CAPTURE");
							// 保存照片 地址
							mImageFilePath = "/mnt/sdcard/itelImageCache/";
							File file = new File(mImageFilePath);
							if (!file.exists()) {
								file.mkdir();
							}
							// 随机 生成照片名
							SimpleDateFormat s = new SimpleDateFormat("yyyyMMddHHmmss");
							String uristr = s.format(new Date());
							File mOutPhotoFile = new File(mImageFilePath, uristr + ".png");
							Uri uri = Uri.fromFile(mOutPhotoFile);
							intentCamera.putExtra(MediaStore.EXTRA_OUTPUT, uri);
							intentCamera.putExtra(MediaStore.EXTRA_VIDEO_QUALITY, 1);
							mImageFilePath = mOutPhotoFile.getAbsolutePath();

							animStartActivityForResult(intentCamera, 8);
						} else {
							Toast.makeText(PersonalCenterActivity.this, "Sorry, please insert the SD card", Toast.LENGTH_SHORT).show();
						}
					}
				};
				modifyAvatarDialog.show();
		
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if (requestCode == REQUEST_CAMERA) {// 拍照上传

			if (mImageFilePath == null) {
				return;
			}
			File tempFile = new File(mImageFilePath);
			if (tempFile != null && tempFile.exists()) {// 判断 当前是否 照相
				Uri uri2 = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
				if (uri2 != null) {
					Intent intents = new Intent(this, ImageCutActivity.class);
					intents.putExtra(ImageCutActivity.PATH, mImageFilePath);
					animStartActivityForResult(intents, 13);

				} else {
					ToastManager.showShort(this, "The photo was not found");
				}
			}

			// 头像
			// imageView_touXinag = (ImageView) findViewById(R.id.myPhoto);
			// imageView_touXinag.setImageBitmap(returnBitMap(userInfo.getPhoto_file_name()));

			// listview_foot_progress=(ProgressBar)findViewById(R.id.listview_foot_progress);
		} else if (requestCode == 12) {// 选择本地图片
			if (data == null) {
				return;
			}
			// File tempFile = new File(mImageFilePath);
			// if (tempFile != null && tempFile.exists())
			// {// 判断当前 图片 是否存在
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
					animStartActivityForResult(intents, 13);
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
			// 开始上传头像
			loadImg(path);
		} 
		super.onActivityResult(requestCode, resultCode, data);
	}
	private void loadImg(String path) {
		// TODO Auto-generated method stub
		Log.i("path","path:"+path);
		 final Map<String, String> params = new HashMap<String, String>();
		 params.put("saltkey", saltkey);
         params.put("auth", auth);
         params.put("filePath", path);
         params.put("uid", uid);
         MasterApplication.getInstanse().showLoadDataDialogUtil(PersonalCenterActivity.this,dao);
         Runnable runnable=new Runnable() {
				
				@Override
				public void run() {
					Message msg=new Message();
					Bundle data=new Bundle();
					String result = HttpFormUtil.post(Constant.BASE_IMGHEAD_URL, params);
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
			MasterApplication.getInstanse().closeLoadDataDialogUtil();
			Bundle data=msg.getData();
			String result=data.getString("value");
			if(result!=null){
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getUploadavatar().equals("api_uploadavatar_success")){
				ToastManager.showShort(PersonalCenterActivity.this, "Success!");
				mImgLoader.removeCacheImage(url);
				mImgLoader.memoryCache.remove(url);
				if (!TextUtils.isEmpty(path)) {
					Bitmap bitmap=BitmapFactory.decodeFile(path);
					imghead.setImageBitmap(IMageUtil.toRoundBitmap(bitmap));
				}
				PreferenceUtils.setPrefBoolean(PersonalCenterActivity.this, "isChangeHeader", true);
				PreferenceUtils.setPrefString(PersonalCenterActivity.this, "HeaderPath", path);
				
			}else if(logininfo.getVariables().getUploadavatar().equals("api_uploadavatar_unavailable_user")){
				ToastManager.showShort(PersonalCenterActivity.this, "Please login");
			}else if(logininfo.getVariables().getUploadavatar().equals("api_uploadavatar_unavailable_pic")){
				ToastManager.showShort(PersonalCenterActivity.this, "Avatar file is not uploaded");
			}else if(logininfo.getVariables().getUploadavatar().equals("api_uploadavatar_unusable_image")){
				ToastManager.showShort(PersonalCenterActivity.this, "Avatar upload format can only be GIF, JPG, png");
			}else if(logininfo.getVariables().getUploadavatar().equals("api_uploadavatar_uc_error")){
				ToastManager.showShort(PersonalCenterActivity.this, "Avatar upload failed");
			}
			}else{
				ToastManager.showShort(PersonalCenterActivity.this, "Unable to connect to the network, please check your network");
			}
		 }
   
		};
		
	private void SignOut() {
		 mParams=new ArrayList<BasicNameValuePair>();
         mParams.add(new BasicNameValuePair("version","5"));
         mParams.add(new BasicNameValuePair("module","logout"));
         mParams.add(new BasicNameValuePair("mobile","no"));
         
         mParams.add(new BasicNameValuePair("uid",uid));
         mParams.add(new BasicNameValuePair("saltkey",saltkey));
         mParams.add(new BasicNameValuePair("auth",auth));
         
         dao = new BaseDao(PersonalCenterActivity.this, mParams, this, null);
         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                 Constant.BASE_URL, "get", "false");
         MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
	}

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getUid()!=null){
				
			}
			if(logininfo.getMessage().getMessageval()!=null){
			 if(logininfo.getMessage().getMessageval().equals("location_logout_succeed_mobile")){
				 SignOutSuccess();
			 }else{
				 //登录失败
				 ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
			 }
			}
		}else{
			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
		}
		
	}
	private void SignOutSuccess() {
		ToastManager.showShort(this, "Success!");
		 PreferenceUtils.setPrefString(this, "auth", logininfo.getVariables().getAuth());
	     PreferenceUtils.setPrefString(this, "saltkey", logininfo.getVariables().getSaltkey());
	     PreferenceUtils.setPrefInt(this, "uid", Integer.parseInt(logininfo.getVariables().getMember_uid()));
	     Intent intent=new Intent(Constant.ACTION_SIGONOUT_SUCCESS);
	     intent.putExtra(Constant.KEY_IS_SUCCESS, true);
		 this.sendBroadcast(intent);
	     animFinish();
		
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}


	@Override
	public void setContentView() {
		setContentView(R.layout.activity_personal_center);
		initView();
		setListener();
		setData();
		
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
