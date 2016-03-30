/*
 * Copyright (C) 2012 yueyueniao
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package com.transsion.infinix.xclub.fragment;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;

import org.apache.http.message.BasicNameValuePair;




import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.CollectionActivity;
import com.transsion.infinix.xclub.activity.ContactActivity;
import com.transsion.infinix.xclub.activity.LoginActivity;
import com.transsion.infinix.xclub.activity.MessageActivity;
import com.transsion.infinix.xclub.activity.MyPostActivity;
import com.transsion.infinix.xclub.activity.PersonalCenterActivity;
import com.transsion.infinix.xclub.activity.SetActivity;
import com.transsion.infinix.xclub.activity.VersionActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.IMageUtil;
import com.transsion.infinix.xclub.util.LevelUtil;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.PlatformDb;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.twitter.Twitter;
import android.annotation.SuppressLint;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.v4.app.Fragment;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;


public class RightFragment extends Fragment implements OnClickListener,RequestListener<BaseEntity>, PlatformActionListener{
	
	private static final int MSG_USERID_FOUND = 11;
	private static final int MSG_LOGIN = 12;
	private static final int MSG_AUTH_CANCEL = 13;
	private static final int MSG_AUTH_ERROR= 14;
	private static final int MSG_AUTH_COMPLETE = 15;
	
    private ImageView imglogin;
    private TextView tvName;
    private Context context;
    private LinearLayout layout_login_true;
    private LinearLayout layout_login_false;
    private LinearLayout layout_contact;
    private LoginSuccessReceiver loginSuccessReceiver;
	private LinearLayout layout_set;
	private ImageView login_phone;
	private View view;
	private ImageView imgHeader;
	private String uid;
	private String auth;
	private String saltkey;
	private BaseDao dao;
	private MasterApplication masterAplication;
	private TextView tvUserName;
	private TextView tvLevel;
	private ImageLoader mImgLoader;
    private LinearLayout[] layoutArray=new  LinearLayout[6]; 
    private int currentIndex=-1;
	private ImageView login_facebook;
	private ImageView login_email;
	private String tid;
	private String userName;
	private String url;
	private ImageView imgLevel;
	private LevelUtil leveUtil;
	private RelativeLayout layout_level;
	private TextView tvAdmin;
	private ImageView imgCheck;
	private ImageView imgCheck_in;
	private Calendar pickCal;
	private boolean isSuccess=false;
	private int date;
	private Handler handler;
	private String str;
	//解析部分用户资料字段
    String id,name,token,urlimage,urlIcon;
	private ArrayList<BasicNameValuePair>  mParams;
	private ImageView login_twitter;
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		 view = inflater.inflate(R.layout.right, null);
		context=view.getContext();
		 handler = new Handler();
//		 Platform facebook = ShareSDK.getPlatform(context, Facebook.NAME);
//		 facebook.setPlatformActionListener(RightFragment.this);
//		 facebook.showUser(null);
		initView();
		setListener(view);
		return view;
	}
	
	private void initView(){
		// TODO Auto-generated method stub
		int perent=PreferenceUtils.getPrefInt(context, "uid", 0);
		layout_login_false=(LinearLayout)view.findViewById(R.id.layout_login_false);
		layout_login_true=(LinearLayout)view.findViewById(R.id.layout_login_true);
		
	    masterAplication=MasterApplication.getInstanse();
	    mImgLoader = ImageLoader.getInstance(context);
	    pickCal = Calendar.getInstance();
	    
		PreferenceUtils.setPrefBoolean(context,"isChangeHeader", false);

		if(perent<=0){
			LoginOut();
			
		}else{
			LoginSuccess();
			
		}
	}
	private void LoginOut() {
		imglogin=(ImageView)view.findViewById(R.id.login_icon);
		layout_set=(LinearLayout)view.findViewById(R.id.layout_set);
		layout_contact=(LinearLayout)view.findViewById(R.id.layout_contact);
		login_facebook=(ImageView)view.findViewById(R.id.login_facebook);
		login_email=(ImageView)view.findViewById(R.id.login_email);
		login_phone=(ImageView)view.findViewById(R.id.login_phone);
		login_twitter=(ImageView)view.findViewById(R.id.login_twitter);
		layout_login_false.setVisibility(View.VISIBLE);
		layout_login_true.setVisibility(View.GONE);
		imglogin.setOnClickListener(this);
		login_phone.setOnClickListener(this);
		layout_set.setOnClickListener(this);
		layout_contact.setOnClickListener(this);
		login_facebook.setOnClickListener(this);
		login_email.setOnClickListener(this);
		login_twitter.setOnClickListener(this);
		
	}
	@Override
	public void onResume() {
		// TODO Auto-generated method stub
		super.onResume();
		if(PreferenceUtils.getPrefBoolean(context, "isChangeHeader", false)){
			UpdatePersonalMessage();
			PreferenceUtils.setPrefBoolean(context, "isChangeHeader", false);
		}
	}

	private void LoginSuccess() {
		imgHeader=(ImageView)view.findViewById(R.id.imgHeader);
		tvUserName=(TextView)view.findViewById(R.id.tvUserName);
		imgLevel=(ImageView)view.findViewById(R.id.imgLevel);
		imgCheck=(ImageView)view.findViewById(R.id.imgCheck);
		imgCheck_in=(ImageView)view.findViewById(R.id.imgCheck_in);
		tvLevel=(TextView)view.findViewById(R.id.tvLevel);
		layout_level=(RelativeLayout)view.findViewById(R.id.layout_level);
		tvAdmin=(TextView)view.findViewById(R.id.tvAdmin);
		layoutArray[0]=(LinearLayout)view.findViewById(R.id.layout_message);
		layoutArray[1]=(LinearLayout)view.findViewById(R.id.personal_center);
		layoutArray[2]=(LinearLayout)view.findViewById(R.id.layout_collection);
		layoutArray[3]=(LinearLayout)view.findViewById(R.id.layout_mypost);
		layoutArray[4]=(LinearLayout)view.findViewById(R.id.layout_set_login);
		layoutArray[5]=(LinearLayout)view.findViewById(R.id.layout_contact_login);
		leveUtil=new LevelUtil(context);
	    layout_login_true.setVisibility(View.VISIBLE);
	    layout_login_false.setVisibility(View.GONE);
	    
	    imgHeader.setOnClickListener(this);
	    imgCheck.setOnClickListener(this);
	    for (LinearLayout layout : layoutArray) {
	    	layout.setOnClickListener(this);
		}
	    
	    setUpView();
	}

	private void setUpView() {
		uid=PreferenceUtils.getPrefInt(context,"uid", 0)+"";
		auth=PreferenceUtils.getPrefString(context, "auth", "");
	    saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
	    tid=PreferenceUtils.getPrefString(context, "UID", "");
		userName=PreferenceUtils.getPrefString(context, "UserName", "");
		url=PreferenceUtils.getPrefString(context, "URL", "");
		
		String level=PreferenceUtils.getPrefString(context, "Level", "");
		String sign=PreferenceUtils.getPrefString(context, "Has_sign", "");
		date=PreferenceUtils.getPrefInt(context, "Date", 0);
         
			if(tid.equals(uid)){
				 tvUserName.setText(userName);
				 leveUtil.SetLevel(layout_level, tvAdmin, level, imgLevel, tvLevel);
				    mImgLoader.DisplayImage(url, imgHeader, 1, Constant.LESSNUM, 60, R.drawable.img_head_bg);
				    if(isSuccess){
				    	if(sign.equals("0")){
				    		imgCheck.setVisibility(View.VISIBLE);
							imgCheck_in.setVisibility(View.GONE);
				    	}else{
				    		imgCheck.setVisibility(View.GONE);
							imgCheck_in.setVisibility(View.VISIBLE);
				    	}
				    }else{
				    	if(sign.equals("0")||date!=pickCal.get(Calendar.DAY_OF_MONTH)){
							imgCheck.setVisibility(View.VISIBLE);
							imgCheck_in.setVisibility(View.GONE);
						}else if(sign.equals("1")&&date==pickCal.get(Calendar.DAY_OF_MONTH)){
							imgCheck.setVisibility(View.GONE);
							imgCheck_in.setVisibility(View.VISIBLE);
						}
				    }
			}else{
				 if(!NetUtil.isConnect(context)){
			 			ToastManager.showShort(context, "Unable to connect to the network, please check your network");
			 			return;
			 		}
				    if(sign.equals("0")){
				    	imgCheck.setVisibility(View.VISIBLE);
						imgCheck_in.setVisibility(View.GONE);
				    }else{
				    	imgCheck.setVisibility(View.GONE);
						imgCheck_in.setVisibility(View.VISIBLE);
				    }
				UpdatePersonalMessage();
		    
			}
	}

	private void UpdatePersonalMessage() {
		
		ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","profile"));
        mParams.add(new BasicNameValuePair("mobile","no"));
  
        mParams.add(new BasicNameValuePair("uid",uid));
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth",auth));
     
        dao = new BaseDao(RightFragment.this, mParams, context, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
              Constant.BASE_URL, "get", "false");
		
	}

	private void setListener(View view) {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onDestroy() {
		context.unregisterReceiver(loginSuccessReceiver);
		super.onDestroy();
	}
	public void onActivityCreated(Bundle savedInstanceState) {
		loginSuccessReceiver=new LoginSuccessReceiver();
		IntentFilter filter=new IntentFilter(Constant.ACTION_LOGIN_SUCCESS);
		IntentFilter filter1=new IntentFilter(Constant.ACTION_SIGONOUT_SUCCESS);
		context.registerReceiver(loginSuccessReceiver, filter);
		context.registerReceiver(loginSuccessReceiver, filter1);
		super.onActivityCreated(savedInstanceState);
		
	}
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.login_icon:
			intent.setClass(context,LoginActivity.class);
			intent.putExtra("Login_type", 3);
			context.startActivity(intent);
			break;
			
		case R.id.login_phone:
			intent.setClass(context,LoginActivity.class);
			intent.putExtra("Login_type", 2);
			context.startActivity(intent);
			break;
		case R.id.login_facebook:
//			intent.setClass(context, FacebookLoginActivity.class);
//			context.startActivity(intent);
			 ShareSDK.initSDK(context);
			Platform facebook = ShareSDK.getPlatform(Facebook.NAME);
			 facebook.setPlatformActionListener(RightFragment.this);
			 authorize(facebook);
			 final String[] PERMISSIONS = {"user_about_me",
				  "user_birthday", "user_photos",
				  "publish_actions", "user_friends"};
			 facebook.authorize(PERMISSIONS);

//			 facebook.showUser(null);
			break;
		case R.id.login_twitter:
			ShareSDK.initSDK(context);
			Platform twitter = ShareSDK.getPlatform(Twitter.NAME);
			twitter.setPlatformActionListener(RightFragment.this);
			 authorize(twitter);
			 final String[] PERMISSION = {"user_about_me",
				  "user_birthday", "user_photos",
				  "publish_actions", "user_friends"};
			 twitter.authorize(PERMISSION);
			   break;
		case R.id.login_email:
			intent.setClass(context, LoginActivity.class);
			intent.putExtra("Login_type", 1);
			context.startActivity(intent);
			break;
		case R.id.imgHeader:
			intent.setClass(context, PersonalCenterActivity.class);
			context.startActivity(intent);
			break;
		case R.id.imgCheck:
			initCheck();
			break;
		case R.id.layout_set:
			intent.setClass(context,SetActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_set_login:
			currentIndex=4;
			intent.setClass(context,SetActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_contact:
			intent.setClass(context, ContactActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_contact_login:
			currentIndex=5;
			intent.setClass(context, ContactActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_message:
			currentIndex=0;
			intent.setClass(context, MessageActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_collection:
			currentIndex=2;
			intent.setClass(context, CollectionActivity.class);
			context.startActivity(intent);
			break;
		case R.id.layout_mypost:
			currentIndex=3;
			intent.setClass(context, MyPostActivity.class);
			context.startActivity(intent);
			break;
		case R.id.personal_center:
			currentIndex=1;
			intent.setClass(context, PersonalCenterActivity.class);
			context.startActivity(intent);
			break;
		default:
			break;
		}
		if(currentIndex>=0){
		updateLayoutTextColor();
		}
	}
	private void initCheck() {
		
		 if(!NetUtil.isConnect(context)){
	 		ToastManager.showShort(context, "Unable to connect to the network, please check your network");
	 		    return;
	 		}
		 ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
	        mParams.add(new BasicNameValuePair("version","5"));
	        mParams.add(new BasicNameValuePair("module","dsu_sign"));
	        mParams.add(new BasicNameValuePair("mobile","no"));
	  
	        mParams.add(new BasicNameValuePair("saltkey",saltkey));
	        mParams.add(new BasicNameValuePair("auth",auth));
	     
	        dao = new BaseDao(RightFragment.this, mParams, context, null);
	        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	              Constant.BASE_URL, "get", "false");
	        MasterApplication.getInstanse().showLoadDataDialogUtil(context,dao);
		
	}

	@SuppressLint("ResourceAsColor")
	private void updateLayoutTextColor() {
		// TODO Auto-generated method stub
		for (int i = 0; i < layoutArray.length; i++) {
			if (i == currentIndex) {
				layoutArray[i].setBackgroundResource(R.drawable.layout_bg);
			} else {
				layoutArray[i].setBackgroundResource(R.drawable.layout_background);

			}
		}
	}
	//执行授权,获取用户信息
		//文档：http://wiki.mob.com/Android_%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E8%B5%84%E6%96%99
		private void authorize(Platform plat) {
			if (plat == null) {
//				popupOthers();
				return;
			}
			
			if(plat.isValid()) {
				String userId = plat.getDb().getUserId();
				if (!TextUtils.isEmpty(userId)) {
					handler.sendEmptyMessage(MSG_USERID_FOUND);
					login(plat.getName(), userId, null);
					return;
				}
			}
			plat.setPlatformActionListener(RightFragment.this);
			//关闭SSO授权
			plat.SSOSetting(true);
			plat.showUser(null);
		}
     class LoginSuccessReceiver extends BroadcastReceiver{


		@Override
		public void onReceive(Context context, Intent intent) {
			String action = intent.getAction();
			if(action.equals(Constant.ACTION_LOGIN_SUCCESS)){
			 isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
			  if(isSuccess){
				  layout_login_true.setVisibility(View.VISIBLE);
				  layout_login_false.setVisibility(View.GONE);
				  PreferenceUtils.setPrefInt(context, "Date", pickCal.get(Calendar.DAY_OF_MONTH));
				  LoginSuccess();
			  }
			}
			if(action.equals(Constant.ACTION_SIGONOUT_SUCCESS)){
				boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
				  if(isSuccess){
					  layout_login_true.setVisibility(View.GONE);
					  layout_login_false.setVisibility(View.VISIBLE);
					  LoginOut();
					
				  }
				}
			}
		}
	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			masterAplication.logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(masterAplication.logininfo.getVariables().getUid()!=null){
				String url=masterAplication.logininfo.getVariables().getBigavatar();
			    tvUserName.setText(masterAplication.logininfo.getVariables().getUsername());
			    String level=masterAplication.logininfo.getVariables().getLevel();
			    PreferenceUtils.setPrefString(context, "Level", level);
			    leveUtil.SetLevel(layout_level, tvAdmin, level, imgLevel, tvLevel);
			    mImgLoader.DisplayImage(url, imgHeader, 1, Constant.LESSNUM, 60, R.drawable.img_head_bg);
			    PreferenceUtils.setPrefString(context, "UID", masterAplication.logininfo.getVariables().getUid());
			    PreferenceUtils.setPrefString(context, "UserName", masterAplication.logininfo.getVariables().getUsername());
			    PreferenceUtils.setPrefString(context, "Level", masterAplication.logininfo.getVariables().getLevel());
				PreferenceUtils.setPrefString(context, "Gender", masterAplication.logininfo.getVariables().getGender());
				PreferenceUtils.setPrefString(context, "Year", masterAplication.logininfo.getVariables().getBirthyear()+"");
				PreferenceUtils.setPrefString(context, "Month", masterAplication.logininfo.getVariables().getBirthmonth()+"");
				PreferenceUtils.setPrefString(context, "Day", masterAplication.logininfo.getVariables().getBirthday()+"");
				PreferenceUtils.setPrefString(context, "Nationality", masterAplication.logininfo.getVariables().getNationality());
				PreferenceUtils.setPrefString(context, "Occupation", masterAplication.logininfo.getVariables().getOccupation());
				PreferenceUtils.setPrefString(context, "Mobile", masterAplication.logininfo.getVariables().getMobile());
				PreferenceUtils.setPrefString(context, "Credits", masterAplication.logininfo.getVariables().getCredits());
				PreferenceUtils.setPrefString(context, "Realname", masterAplication.logininfo.getVariables().getRealname());
				PreferenceUtils.setPrefString(context, "URL", url);
				PreferenceUtils.setPrefString(context, "Email", masterAplication.logininfo.getVariables().getEmail());
			}
			if(masterAplication.logininfo.getMessage()!=null && masterAplication.logininfo.getMessage().getMessageval()!=null){
				if( masterAplication.logininfo.getMessage().getMessageval().equals("login_succeed")||masterAplication.logininfo.getMessage().getMessageval().equals("register_succeed")){
				    
				    PreferenceUtils.setPrefString(context, "auth", masterAplication.logininfo.getVariables().getAuth());
					PreferenceUtils.setPrefString(context, "saltkey", masterAplication.logininfo.getVariables().getSaltkey());
					PreferenceUtils.setPrefString(context, "sys_authkey", masterAplication.logininfo.getSys_authkey());
					PreferenceUtils.setPrefInt(context, "uid", Integer.parseInt(masterAplication.logininfo.getVariables().getMember_uid()));
					imgCheck.setVisibility(View.GONE);
					imgCheck_in.setVisibility(View.VISIBLE);
				}else if(masterAplication.logininfo.getMessage().getMessageval().equals("success")){
					imgCheck.setVisibility(View.GONE);
					imgCheck_in.setVisibility(View.VISIBLE);
				}else{
					ToastManager.showShort(context, masterAplication.logininfo.getMessage().getMessagestr());
				}
			}
		}else{
			ToastManager.showShort(context, "Data requests failed, please try again later");
		}
		
	}
	private void login(String plat, String userId, HashMap<String, Object> userInfo) {
		Message msg = new Message();
		msg.what = MSG_LOGIN;
		msg.obj = plat;
		handler.sendMessage(msg);
	}
	public boolean handleMessage(Message msg) {
		switch(msg.what) {
			case MSG_USERID_FOUND: {
				//如何用户已经登录，获取用户useID
//				Toast.makeText(context, R.string.userid_found, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_LOGIN: {
				//调用注册页面
//				AuthManager.showDetailPage(context, ShareSDK.platformNameToId(String.valueOf(msg.obj)));
			}
			break;
			case MSG_AUTH_CANCEL: {
				//取消授权
				Toast.makeText(context, R.string.auth_cancel, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_ERROR: {
				//授权失败
				Toast.makeText(context, R.string.auth_error, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_COMPLETE: {
				
			}
			break;
			
		}
		return false;
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onCancel(Platform arg0, int action) {
		if (action == Platform.ACTION_USER_INFOR) {
			handler.sendEmptyMessage(MSG_AUTH_CANCEL);
		}
	}

	@Override
	public void onComplete(Platform platform, int action, HashMap<String, Object> res) {
		if (action == Platform.ACTION_USER_INFOR) {
		            PlatformDb platDB = platform.getDb();//获取数平台数据DB
		            //通过DB获取各种数据
		           token= platDB.getToken();  
		           urlimage=platDB.getUserGender();
		           urlIcon= platDB.getUserIcon();
		            id= platDB.getUserId();
		           name= platDB.getUserName();
		           handler.sendEmptyMessage(MSG_AUTH_COMPLETE);
		           platform.removeAccount(true);
					login(platform.getName(), platform.getDb().getUserId(), res);
					
					  //授权成功
					  mParams=new ArrayList<BasicNameValuePair>();
			          mParams.add(new BasicNameValuePair("version","5"));
			          mParams.add(new BasicNameValuePair("module","loginbyouter"));
			          mParams.add(new BasicNameValuePair("mobile","no"));
			          mParams.add(new BasicNameValuePair("oauthid",id));
			          dao = new BaseDao(RightFragment.this, mParams, context, null);
			          dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
			                  Constant.BASE_URL, "get", "false");
			          MasterApplication.getInstanse().showLoadDataDialogUtil(context,dao);
		        }
		
	}

	@Override
	public void onError(Platform arg0, int action, Throwable t) {
		if (action == Platform.ACTION_USER_INFOR) {
			handler.sendEmptyMessage(MSG_AUTH_ERROR);
		}
		t.printStackTrace();
	}
}
