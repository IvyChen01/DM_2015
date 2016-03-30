package com.trassion.newstop.activity.view;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;


import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.PlatformDb;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.twitter.Twitter;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.AccountSettingsActivity;
import com.trassion.newstop.activity.FeedbackActivity;
import com.trassion.newstop.activity.LoginActivity;
import com.trassion.newstop.activity.MainActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.activity.RegisterActivity;
import com.trassion.newstop.activity.SettingsActivity;
import com.trassion.newstop.activity.SystemMessageActivity;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.response.NewsTopLoginBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.Md5Util;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.MyFoodListView;
import com.trassion.newstop.view.XwScrollView;

import android.app.Activity;
import android.app.Dialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Typeface;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.util.AttributeSet;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.view.View.OnClickListener;

public class MineMainLayout extends LinearLayout implements IAppLayout,OnClickListener,UICallBackInterface, PlatformActionListener{

	private View rootView;
	private TextView tvName;
	private Context context;
	private TextView tvFollow;
	private TextView tvFollowers;
	private Button btnMyself;
	private RelativeLayout llSetting;
	private ImageView imgHeader;
	private TextView tvPresent;
	private LinearLayout btnFriends;
	private LinearLayout btnNotice;
	private LinearLayout btnFeedback;
	private LinearLayout mCollection;
	private LinearLayout myFeed;
	private ImageView imgMyfeed;
	private ImageView imgCollection;
	private TextView tvMyfeed;
	private TextView tvCollection;
	private ImageView oneTab;
	private ImageView twoTab;
	private MyFoodListView listView;
	private ArrayList<Myfeed> mFeeds=new ArrayList<Myfeed>();
	
	private CollectionMainLayout collect;
	private MyFeedMainLayout myfeedMainLayout;
	private IAppLayout nowLayout;
	private LinearLayout llManagerMainLayout;
	
	private XwScrollView mXSVContainer;
	private Dialog settingTypeDialog;
	private LayoutInflater mLayoutInflater;
	private XwScrollView mXSVContainer_before;
	private ImageButton btnLogin;
	private Button btnSeting;
	private ImageButton btnRegister;
//	private ImageButton btnGoogle;
	private ImageButton btnFacebook;
	private ImageButton btnTwitter;
	
	private Boolean isLogin;
	private ImageLoader imageloader;
	private ImageManager imageManager;
	private Handler handler;
	//���������û������ֶ�
    String id,name,token,urlimage,urlIcon;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private NewsTopLoginBeanresponse response;
	
	private static final int MSG_USERID_FOUND = 11;
	private static final int MSG_LOGIN = 12;
	private static final int MSG_AUTH_CANCEL = 13;
	private static final int MSG_AUTH_ERROR= 14;
	private static final int MSG_AUTH_COMPLETE = 15;

	public MineMainLayout(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
	public MineMainLayout(Context context,Boolean isLogin) {
		super(context);
		this.context=context;
		 mLayoutInflater = LayoutInflater.from(context);
		// ��Ĭ�ϲ��ּ��ص�View����
		rootView = mLayoutInflater.inflate(R.layout.mine_main, this, true);
		
		handler = new Handler();
		
		this.isLogin=isLogin;
		
		initView();
		initData();
		initListener();
	}
     /**
      * ʵ��ؼ�
      */
	@Override
	public void initView() {
		mXSVContainer_before=(XwScrollView)findViewById(R.id.mXSVContainer_before);
		mXSVContainer=(XwScrollView)findViewById(R.id.mXSVContainer);
		
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context, MineMainLayout.this);
		
		imageloader=ImageLoader.getInstance();
		imageManager=new ImageManager();
		
		initLoginBeforeView();
		initLoginSuccessView();
		
		
	}
	
	
	private void initLoginBeforeView() {
		// TODO Auto-generated method stub
		btnLogin=(ImageButton)findViewById(R.id.btnLogin);
		btnSeting=(Button)findViewById(R.id.btnSeting);
		btnRegister=(ImageButton)findViewById(R.id.btnRegister);
		
//		btnGoogle=(ImageButton)findViewById(R.id.btnGoogle);
		btnFacebook=(ImageButton)findViewById(R.id.btnFacebook);
		btnTwitter=(ImageButton)findViewById(R.id.btnTwitter);
	}
	private void initLoginSuccessView() {
		llManagerMainLayout=(LinearLayout)findViewById(R.id.layout_list);
		tvName=(TextView)findViewById(R.id.tvName);//�û���
//		tvFollow=(TextView)findViewById(R.id.tvFollow);
//		tvFollowers=(TextView)findViewById(R.id.tvFollowers);
		btnMyself=(Button)findViewById(R.id.btnMyself);//�������ϱ༭
		llSetting=(RelativeLayout)findViewById(R.id.llSetting);//����
		imgHeader=(ImageView)findViewById(R.id.imgHeader);//ͷ��
		tvPresent=(TextView)findViewById(R.id.tvPresent);//���˽���
//		btnFriends=(LinearLayout)findViewById(R.id.btnFriends);//����
		btnNotice=(LinearLayout)findViewById(R.id.btnNotice);//ϵͳ��Ϣ
		btnFeedback=(LinearLayout)findViewById(R.id.btnFeedback);//����
		myFeed=(LinearLayout)findViewById(R.id.myFeed);//��̬
		imgMyfeed=(ImageView)findViewById(R.id.imgMyfeed);//MyfeedͼƬ
		imgCollection=(ImageView)findViewById(R.id.imgCollection);//�ղ�ͼƬ
		tvMyfeed=(TextView)findViewById(R.id.tvMyfeed);
		tvCollection=(TextView)findViewById(R.id.tvCollection);
		oneTab=(ImageView)findViewById(R.id.oneTab);//��̬�»���
		twoTab=(ImageView)findViewById(R.id.twoTab);//�ղ��»���
		listView=(MyFoodListView)findViewById(R.id.listView);
		
		mCollection=(LinearLayout)findViewById(R.id.mCollection);//�ղ�
		
		Typeface type = Typeface.createFromAsset(context.getAssets(),"fonts/Roboto-Bold.ttf");
		tvName.setTypeface(type);
//		tvFollow.setTypeface(type);
//		tvFollowers.setTypeface(type);
		
         mXSVContainer.post(new Runnable() {
			
			@Override
			public void run() {
				mXSVContainer.scrollTo(0, 0);
			}
		});
		
	}
	private void ToShareType() {
		    settingTypeDialog = new Dialog(context, R.style.ActionSheet01);
			LinearLayout layout = (LinearLayout) mLayoutInflater.inflate(R.layout.tpl_other_palt_dialog, null);
			
			layout.findViewById(R.id.nigthMode).setOnClickListener(this);
			layout.findViewById(R.id.fontSettings).setOnClickListener(this);
			layout.findViewById(R.id.settings).setOnClickListener(this);
			
			Window w = settingTypeDialog.getWindow();
			WindowManager.LayoutParams lp = w.getAttributes();

			final int cFullFillWidth = 10000;
			layout.setMinimumWidth(cFullFillWidth);
			/*
			 * lp.x = 0; final int cMakeBottom = -1000; lp.y = cMakeBottom;
			 */
			lp.gravity = Gravity.BOTTOM;
			settingTypeDialog.onWindowAttributesChanged(lp);
//			dlg.setCanceledOnTouchOutside(false);

			settingTypeDialog.setContentView(layout);
			settingTypeDialog.show();
		
	}

	@Override
	public void initData() {
		 String username=PreferenceUtils.getPrefString(context, "username", "");
		 String nick=PreferenceUtils.getPrefString(context, "nick", "");
		 String signature=PreferenceUtils.getPrefString(context, "signature", "");
		 String photo=PreferenceUtils.getPrefString(context, "photo", "");
		if(isLogin){
			mXSVContainer_before.setVisibility(View.GONE);
			mXSVContainer.setVisibility(View.VISIBLE);
			tvName.setText(nick);
			tvPresent.setText(signature);
			if(photo!=null &&!photo.equals("")){
			imageloader.displayImage(photo, imgHeader,imageManager.options,imageManager.animateFirstListener);
			
			nowLayout = new MyFeedMainLayout(context);
			// ɾ�����е��Ӳ���
			llManagerMainLayout.removeAllViews();
			// ����µĲ���
			llManagerMainLayout.addView((View) nowLayout);
			}
		}else{
			mXSVContainer_before.setVisibility(View.VISIBLE);
			mXSVContainer.setVisibility(View.GONE);
		}
//		Myfeed feed=new Myfeed();
//		for(int i=0;i<10;i++){
//			feed.setName("Wisdomodoki");
//			mFeeds.add(feed);
//		}
//		MyFeedAdapter adapter=new MyFeedAdapter(context,mFeeds,false);
//		listView.setAdapter(adapter);
//		Utils.setListViewHeightBasedOnChildren(listView);
		// ��ͨ����¼Ĭ��װ�����ǵ���������

		
	}
    /**
     * ����
     */
	@Override
	public void initListener() {
		// TODO Auto-generated method stub
		myFeed.setOnClickListener(this);
		mCollection.setOnClickListener(this);
		llSetting.setOnClickListener(this);
		btnMyself.setOnClickListener(this);
//		btnFriends.setOnClickListener(this);
		btnNotice.setOnClickListener(this);
		btnFeedback.setOnClickListener(this);
		
		btnLogin.setOnClickListener(this);
		btnSeting.setOnClickListener(this);
		btnRegister.setOnClickListener(this);
		
//		btnGoogle.setOnClickListener(this);
		btnFacebook.setOnClickListener(this);
		btnTwitter.setOnClickListener(this);
	}

	@Override
	public void onResume() {
		
	}

	@Override
	public void onPause() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.llSetting:
			ToShareType();
			break;
//		case R.id.btnGoogle:
//			break;
		case R.id.btnFacebook:
			 ShareSDK.initSDK(context);
				Platform facebook = ShareSDK.getPlatform(Facebook.NAME);
				 facebook.setPlatformActionListener(MineMainLayout.this);
				 authorize(facebook);
			break;
		case R.id.btnTwitter:
			ShareSDK.initSDK(context);
			Platform twitter = ShareSDK.getPlatform(Twitter.NAME);
			twitter.setPlatformActionListener(MineMainLayout.this);
			 authorize(twitter);
			break;
		case R.id.btnMyself:
			StartActivity(AccountSettingsActivity.class);
			break;
//		case R.id.btnFriends:
//			StartActivity(FriendsMessageActivity.class);
//			break;
		case R.id.btnNotice:
			StartActivity(SystemMessageActivity.class);
			break;
		case R.id.btnFeedback:
			StartActivity(FeedbackActivity.class);
			break;
		case R.id.myFeed:
			setMyFeedView();
			break;
        case R.id.mCollection:
			setCollectionView();
			break;
        case R.id.settings:
           settingTypeDialog.dismiss();
           StartActivity(SettingsActivity.class);
        	break;
        case R.id.btnLogin:
        	StartActivity(LoginActivity.class);
        	break;
        case R.id.btnSeting:
        	StartActivity(SettingsActivity.class);
        	break;
        case R.id.btnRegister:
        	StartActivity(RegisterActivity.class);
            break;
		default:
			break;
		}
		
	}
	private void login(String plat, String userId, HashMap<String, Object> userInfo) {
		Message msg = new Message();
		msg.what = MSG_LOGIN;
		msg.obj = plat;
		handler.sendMessage(msg);
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
						handler.sendEmptyMessage(MSG_USERID_FOUND);
						login(plat.getName(), userId, null);
						return;
					}
				}
				plat.setPlatformActionListener(MineMainLayout.this);
				//�ر�SSO��Ȩ
				plat.SSOSetting(true);
				plat.showUser(null);
			}
	private void setCollectionView() {
		
		imgMyfeed.setImageResource(R.drawable.me_icon_myfeed_normal);
		imgCollection.setImageResource(R.drawable.me_icon_collection_select);
		tvMyfeed.setTextColor(0xff333333);
		tvCollection.setTextColor(0xffcc0000);
		oneTab.setVisibility(View.GONE);
		twoTab.setVisibility(View.VISIBLE);
		
		if (null != collect) {
			nowLayout = collect;
			// ɾ�����е��Ӳ���
			llManagerMainLayout.removeAllViews();
			// ����µĲ���
			llManagerMainLayout.addView((View) nowLayout);
			nowLayout.initData();
		} else {
			// ��ͨ����¼Ĭ��װ�����ǵ���������
			nowLayout = new CollectionMainLayout(context);
			// ɾ�����е��Ӳ���
			llManagerMainLayout.removeAllViews();
			// ����µĲ���
			llManagerMainLayout.addView((View) nowLayout);

		}
		
	}
	private void setMyFeedView() {
		
		imgMyfeed.setImageResource(R.drawable.me_icon_myfeed_select);
		imgCollection.setImageResource(R.drawable.me_icon_collection_normal);
		tvMyfeed.setTextColor(0xffcc0000);
		tvCollection.setTextColor(0xff333333);
		oneTab.setVisibility(View.VISIBLE);
		twoTab.setVisibility(View.GONE);
		
		   if (null != myfeedMainLayout) {
				nowLayout = myfeedMainLayout;
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);
				nowLayout.initData();
			} else {
				// ��ͨ����¼Ĭ��װ�����ǵ���������
				nowLayout = new MyFeedMainLayout(context);
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);

			}
		
	}
	private void StartActivity(Class<? extends Activity> activity) {
		Intent intent = new  Intent(context, activity);
		((Activity) context).startActivityForResult(intent, MainActivity.ACCOUNTREQUEST);
		((Activity) context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
		
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
				Toast.makeText(context, R.string.auth_cancel, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_ERROR: {
				//��Ȩʧ��
				Toast.makeText(context, R.string.auth_error, Toast.LENGTH_SHORT).show();
			}
			break;
			case MSG_AUTH_COMPLETE: {
				ToastManager.showShort(context, name);
			}
			break;
			
		}
		return false;
	}
	@Override
	public void onCancel(Platform arg0, int arg1) {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onComplete(Platform platform, int action, HashMap<String, Object> res) {
		if (action == Platform.ACTION_USER_INFOR) {
            PlatformDb platDB = platform.getDb();//��ȡ��ƽ̨���DB
            //ͨ��DB��ȡ�������
           token= platDB.getToken();  
           urlimage=platDB.getUserGender();
           urlIcon= platDB.getUserIcon();
            id= platDB.getUserId();
           name= platDB.getUserName();
           handler.sendEmptyMessage(MSG_AUTH_COMPLETE);
			login(platform.getName(), platform.getDb().getUserId(), res);
			 platform.removeAccount(true);
			
			 requsetLogin(id,name,urlIcon);
			
        }
		
	}
	private void requsetLogin(String id,String name,String urlIcon) {
		if (NetworkUtil.isOnline(context)) {
		mHttpAgent.isShowProgress = false;
		NewsApplication.modelName="collection";
		String sign=Md5Util.MD5("aSDEdi23847djfh47ydx,_1a" +Utils.getPhoneIMEI(context) + id + name + urlIcon);
		request.getNewsTopListByLoginTypeNewsTopRequest(mHttpAgent,Utils.getPhoneIMEI(context),id,name,urlIcon,sign, Constants.HTTP_GET_LOGIN_TYPE );
	} else {
		Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
	}
		
	}
	@Override
	public void onError(Platform arg0, int action, Throwable t) {
		if (action == Platform.ACTION_USER_INFOR) {
			handler.sendEmptyMessage(MSG_AUTH_ERROR);
		}
		t.printStackTrace();
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopLoginBeanresponse)bean;
			if(response.getCode().equals("0")){
				 loginSuccess();
			}else{
				ToastManager.showLong(context, response.getMsg());
			}
		}
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			
		}else{
			ToastManager.showLong(context, R.string.common_cannot_connect);
		}
		
	}
	private void loginSuccess() {
		// TODO Auto-generated method stub
		PreferenceUtils.setPrefString(context, "email", response.getUserinfo().getEmail());
		PreferenceUtils.setPrefString(context, "saltkey", response.getSaltkey());
		PreferenceUtils.setPrefString(context, "auth", response.getAuth());
		PreferenceUtils.setPrefString(context, "phone", response.getUserinfo().getPhone());
		PreferenceUtils.setPrefString(context, "nick", response.getUserinfo().getNick());
		PreferenceUtils.setPrefString(context, "signature", response.getUserinfo().getSignature());
		PreferenceUtils.setPrefString(context, "uid", response.getUserinfo().getUid());
		PreferenceUtils.setPrefString(context, "photo", response.getUserinfo().getPhoto());
		PreferenceUtils.setPrefString(context, "date", response.getUserinfo().getRegister_date());
		PreferenceUtils.setPrefBoolean(context, "isLogin", true);
		
		mXSVContainer_before.setVisibility(View.GONE);
		mXSVContainer.setVisibility(View.VISIBLE);
		tvName.setText(response.getUserinfo().getNick());
		tvPresent.setText(response.getUserinfo().getSignature());
		if(response.getUserinfo().getPhoto()!=null &&!response.getUserinfo().getPhoto().equals("")){
		imageloader.displayImage(response.getUserinfo().getPhoto(), imgHeader,imageManager.options,imageManager.animateFirstListener);
		}
		nowLayout = new MyFeedMainLayout(context);
		// ɾ�����е��Ӳ���
		llManagerMainLayout.removeAllViews();
		// ����µĲ���
		llManagerMainLayout.addView((View) nowLayout);
		
	 }
}
