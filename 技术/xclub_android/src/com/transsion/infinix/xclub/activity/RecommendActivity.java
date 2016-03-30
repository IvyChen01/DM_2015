package com.transsion.infinix.xclub.activity;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.ActivityNotFoundException;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Handler.Callback;
import android.os.Looper;
import android.os.Message;
import android.provider.MediaStore;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.ViewGroup.LayoutParams;
import android.view.inputmethod.InputMethodManager;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.facebook.Facebook.ShareParams;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.system.email.Email;
import cn.sharesdk.system.text.ShortMessage;
import cn.sharesdk.twitter.Twitter;
import cn.sharesdk.whatsapp.WhatsApp;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.PostCommentAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.ActionItem;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.HttpFormUtil;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.IMageUtil;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.EmoteInputView;
import com.transsion.infinix.xclub.view.PostListView;
import com.transsion.infinix.xclub.view.PostScoreDilog;
import com.transsion.infinix.xclub.view.TitlePopup;
import com.transsion.infinix.xclub.view.PostListView.IXListViewListener;
import com.transsion.infinix.xclub.view.TitlePopup.OnItemOnClickListener;
import com.trassion.infinix.xclub.R;


public class RecommendActivity extends BaseActivity implements IXListViewListener, OnClickListener,OnItemOnClickListener,DialogInterface.OnClickListener,RequestListener<BaseEntity>, PlatformActionListener, Callback{
	private static final int FLAG_CHOOSE_IMG = 2;
	private static final int FLAG_CHOOSE_PHONE = 1;
	private static final int FLAG_SHARE_FACEBOOK=3;
	private static final int FLAG_SHARE_TWITTER=4;
	private static final int FLAG_SHARE_WHATSAPP=5;
	private static final int FLAG_SHARE_EMAIL=6;
	private static final int FLAG_SHARE_MESSAGE=7;
	private static final int MSG_AUTH_CANCEL = 10;
	private static final int MSG_AUTH_ERROR= 11;
	private static final int MSG_AUTH_COMPLETE = 12;
	private WebView webView;
	private LinearLayout tvback;
	private PostListView list;
	private String tid;
	private BaseDao dao;
	private LoginInfo logininfo;
	private PostCommentAdapter adapter;
	private ImageView imgFace;
	private EmoteInputView mInputView;
	private EditText etContent;
	private InputMethodManager imm=null; //软键盘管理
	private ImageView imgPictrue;
	private String[] items = { "Photo","Gallery"};
	private LayoutInflater inflater;
	private TitlePopup titlePopup;
	private int isShowing=2;
	private static String localTempImageFileName = "";
	File cacheFilePath = new File(Constant.TMP_PATH);
	private Map<String, String> mFile = new LinkedHashMap<String, String>();// 存放上传图片地址 
	private String currentUploadPath = "";// 当前正在上传的图片路径
	private String message;//帖子内容
	private String picPath;
	private File file;
	private Button send;
	private ArrayList<BasicNameValuePair> params;
	private String pid="";
	private String uid;
	private String saltkey;
	private String auth;
	private ArrayList<BasicNameValuePair> mParams;
	private RelativeLayout btCollection;
	private String formhash;
	private String favrite;
	private int page=1;
	private PostScoreDilog dialog;
	public PopupWindow pop;
	private ImageView imgCollect;
	private RelativeLayout layout_closeDialog;
	private String authorid;
	private boolean thread=false;
	private ImageView imgThread;
	private int type=0;
	private String shares="0";
	private String mPhoneModel;
	private String tpid;
	private android.app.Dialog dlg;
	private String share_url;
	private String title;
	private EditText etContet;
	private EditText etMassage;
	private android.app.Dialog sharedialog;
	private int shareType;
	private android.app.Dialog shareTypeDialog;
	private TextView etEmailOrPhone;
	private String url_share;
	private ImageLoader mImgLoader;
	private Handler mHandler;
	
	private void initView() {
		PreferenceUtils.setPrefBoolean(this, "Comment", false);
		list=(PostListView)findViewById(R.id.listView);
		imgFace=(ImageView)findViewById(R.id.imgFace);
		imgPictrue=(ImageView)findViewById(R.id.imgPictrue);
		btCollection=(RelativeLayout)findViewById(R.id.btCollection);
		send=(Button)findViewById(R.id.send);
		mImgLoader = ImageLoader.getInstance(this);
		params = new ArrayList<BasicNameValuePair>();
	    inflater=LayoutInflater.from(this);
//		View view=inflater.inflate(R.layout.post_webview, null);
//		webView=(WebView)view.findViewById(R.id.webView);
//		
//		webView.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
//		webView.getSettings().setCacheMode(WebSettings.LOAD_NO_CACHE);
//		webView.getSettings().setJavaScriptEnabled(true);
//		webView.getSettings().setLoadWithOverviewMode(false);
//		webView.getSettings().setBuiltInZoomControls(false);
//		webView.getSettings().setDisplayZoomControls(false);
//		webView.setVerticalScrollBarEnabled(false);
//		webView.setHorizontalScrollBarEnabled(false);
//		
//		webView.getSettings().setJavaScriptEnabled(true);
		
		
		mParams = new ArrayList<BasicNameValuePair>();
		initPopuptWindow();
		
		etContent=(EditText)findViewById(R.id.etContent);
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		mInputView = (EmoteInputView) findViewById(R.id.chat_eiv_inputview);
		mInputView.setEditText(etContent);
		
//		list.addHeaderView(view);
		list.setPullLoadEnable(true);
		tvback=(LinearLayout)findViewById(R.id.tvback);
		
		tvback.setOnClickListener(this);
		imgFace.setOnClickListener(this);
		imgPictrue.setOnClickListener(this);
		btCollection.setOnClickListener(this);
		send.setOnClickListener(this);
		list.setXListViewListener(this);
		
		etContent.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {
				if (mInputView.isShown()) {
					mInputView.setVisibility(View.GONE);
					imm.showSoftInput(etContent, 0);
					etContent.requestFocus();
					etContent.setFocusable(true);
				}
				mInputView.setVisibility(View.GONE);
				return false;
			}
		});
		etContent.addTextChangedListener(new TextWatcher() {
			String befText;

			@Override
			public void onTextChanged(CharSequence s, int start, int before,
					int count) {

			}

			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
				befText = etContent.getText().toString();
			}

			@Override
			public void afterTextChanged(Editable s) {
				// 判断是否删除图片，如删除则在mFile中移除该图片路径
				String nowText = etContent.getText().toString();
				if(nowText.length()>0){
					send.setBackgroundResource(R.drawable.comment_send_pressed);
				}else{
					send.setBackgroundResource(R.drawable.commment_send_bg);
				}
				if (nowText.length() < befText.length() && mFile.size() > 0) {
					for (Map.Entry<String, String> entry : mFile.entrySet()) {
						if (!nowText.contains(entry.getValue())) {
							mFile.remove(entry.getKey());
							break;
						}
					}
				}
			}
		});

	}
	
	private void setData() {
		tid=getIntent().getStringExtra("tid");
		title=getIntent().getStringExtra("Title");
		PreferenceUtils.setPrefString(this, "tid", tid);
		favrite=getIntent().getStringExtra("favrite");
		url_share =PreferenceUtils.getPrefString(this, "url_share", "");
		Log.i("info", "url图片："+url_share);
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
	    mPhoneModel= TextUtils.getPhoneModel(this);
	    boolean isCheck=getIntent().getBooleanExtra("isCheck", false);
	    View view = LayoutInflater.from(this).inflate(
				R.layout.pop_comment, null);
        titlePopup = new TitlePopup(this, TextUtils.dip2px(this, 165), TextUtils.dip2px(this, 40));
		
		titlePopup.addAction(new ActionItem(this, "", R.drawable.post_item_score));
		titlePopup.addAction(new ActionItem(this, "",R.drawable.post_item_comment_bg));
		titlePopup.addAction(new ActionItem(this, "",R.drawable.post_report_bg));
		titlePopup.setItemOnClickListener(this);
	    if(isCheck){
	    	shares="1";
	    }else{
	    	shares="0";
	    }
//		String url=Constant.FORUM_URL+"mod=viewthread&from=api&ordertype=1&threads=thread&mobile=yes&tid="+tid+"&auth="+auth+"&saltkey="+saltkey+"&Shares"+shares;
		share_url=Constant.FORUM_URL+"mod=viewthread&extra=page%3D1"+"&tid="+tid;
//
//		try {
//			webView.loadUrl(url);
//			webView.setWebViewClient(new WebViewClient() {
//				@Override
//				public boolean shouldOverrideUrlLoading(WebView view, String url) {
//					Log.i("info", "url22222:"+url);
//					if (url.endsWith(".jpg") || url.endsWith(".png")
//							|| url.endsWith(".gif") || url.endsWith(".bmp")){
//						return true;
//					}else if(url.contains("http")){
//						//下载附件
//						url = url+ "?auth=" + auth + "&saltkey=" + saltkey;
//						Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
//						startActivity(intent);
//						overridePendingTransition(R.anim.in_from_right, R.anim.out_to_left);
//					}else{
//						view.loadUrl(url);
//					}
//					return true;
//				}
//			});
//		} catch (Exception e) {
//			// TODO: handle exception
//		}
	    
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","viewthread"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("tid",tid));
        mParams.add(new BasicNameValuePair("uid",uid));
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth",auth));
        
        
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        
        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		
	}
	 private void initPopuptWindow(){
		    LayoutInflater inflater = LayoutInflater.from(this);
			View popView = inflater.inflate(R.layout.post_module_select_dialog, null);
			if(pop==null){
			   pop = new PopupWindow(popView,LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT);
			}
			imgCollect=(ImageView)popView.findViewById(R.id.imgCollect);
			imgThread=(ImageView)popView.findViewById(R.id.imgThread);
			popView.findViewById(R.id.module_thread).setOnClickListener(this);
			popView.findViewById(R.id.module_collect).setOnClickListener(this);
			popView.findViewById(R.id.module_report).setOnClickListener(this);
			popView.findViewById(R.id.module_like).setOnClickListener(this);
			popView.findViewById(R.id.module_share).setOnClickListener(this);
			
			 // 点击其他地方消失  
			popView.setOnTouchListener(new OnTouchListener() {  
	            @Override  
	            public boolean onTouch(View v, MotionEvent event) {  
	                // TODO Auto-generated method stub  
	                if (pop != null && pop.isShowing()) {  
	                	pop.dismiss();    
	                }  
	                return false;  
	            }  
	        });  
			
//			pop.setContentView(popView);
			pop.setFocusable(true);
//			pop.setAnimationStyle(R.style.dialog_anim);
			
     }
	 private void getPopupWindow() {  
	        if (null != pop && pop.isShowing()) {  
	            pop.dismiss();  
	            return;  
	        } else if(null != pop && !pop.isShowing()){  
	        	pop.showAsDropDown(findViewById(R.id.layout_top), 0, 0);
	        	if(favrite!=null && favrite.equals("1")){
	 			   imgCollect.setBackgroundResource(R.drawable.post_collect_pressed);
	 		    }
	        	if(thread){
	        	   imgThread.setBackgroundResource(R.drawable.post_thread_pressed);
	        	}else{
	        		imgThread.setBackgroundResource(R.drawable.post_thread_bg);
	        	}
	        }  
	    }
	 
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.imgFace:
			if(mInputView.isShown()){
				imm.hideSoftInputFromWindow(etContent.getWindowToken(), 0);
			    mInputView.setVisibility(View.GONE);
				}else{
					imm.hideSoftInputFromWindow(etContent.getWindowToken(), 0);
				    mInputView.setVisibility(View.VISIBLE);
				}
			break;
		case R.id.imgPictrue:
			Dialog();
			break;
		case R.id.btCollection:
			 getPopupWindow();
			break;
		case R.id.module_share:
			pop.dismiss();
			ToShareType();
//		    sharedialog = new Dialog(this, R.style.WhiteDialog);
//			View dlgView = View.inflate(this, R.layout.tpl_other_plat_dialog, null);
//			View tvFacebook = dlgView.findViewById(R.id.tvFacebook);
//			tvFacebook.setTag(sharedialog);
//			tvFacebook.setOnClickListener(this);
//			View tvTwitter = dlgView.findViewById(R.id.tvTwitter);
//			tvTwitter.setTag(sharedialog);
//			tvTwitter.setOnClickListener(this);
//			
//			sharedialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
//			sharedialog.setContentView(dlgView);
//			sharedialog.show();
			break;
		case R.id.share_facebook:
			ShareType(FLAG_SHARE_FACEBOOK);
			break;
		case R.id.share_twitter:
			ShareType(FLAG_SHARE_TWITTER);
			break;
		case R.id.share_whatsapp:
			ShareType(FLAG_SHARE_WHATSAPP);
			break;
        case R.id.share_email:
        	ShareType(FLAG_SHARE_EMAIL);
			break;
        case R.id.share_message:
        	ShareType(FLAG_SHARE_MESSAGE);
	        break;
        case R.id.copy_link:
        	shareTypeDialog.dismiss();
        	ClipboardManager cm =(ClipboardManager) this.getSystemService(Context.CLIPBOARD_SERVICE);
        	//将文本数据复制到剪贴板
        	cm.setText(share_url);
        	ToastManager.showShort(this, "Copy success");
        	break;
		case R.id.btShare:
			dlg.dismiss();
			imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);  
			
			String message=etMassage.getText().toString();
			String emailOrPhone=etEmailOrPhone.getText().toString().trim();
//			ShareSDK.initSDK(this);
			ShareParams sp = new ShareParams();
			sp.setText(message+" "+title+" "+share_url);
			
           if(url!=null&&!url.equals("")){
        	   sp.setImagePath(mImgLoader.getCachePath(url));
			}
			
			if(shareType==FLAG_SHARE_FACEBOOK){
				Platform facebook = ShareSDK.getPlatform (Facebook.NAME);
				facebook. setPlatformActionListener (this); // 设置分享事件回调
				facebook.SSOSetting(true);
				// 执行图文分享
				facebook.share(sp);
			}else if(shareType==FLAG_SHARE_TWITTER){
				Platform twitter = ShareSDK.getPlatform (Twitter.NAME);
				twitter. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				twitter.share(sp);
			}else if(shareType==FLAG_SHARE_WHATSAPP){
				Platform whatsapp = ShareSDK.getPlatform (WhatsApp.NAME);
				whatsapp. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				whatsapp.share(sp);
			}else if(shareType==FLAG_SHARE_EMAIL){
				sp.setAddress(emailOrPhone);
				Platform email = ShareSDK.getPlatform (Email.NAME);
				email. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				email.share(sp);
			}else if(shareType==FLAG_SHARE_MESSAGE){
				sp.setAddress(emailOrPhone);
				Platform shortMessage = ShareSDK.getPlatform (ShortMessage.NAME);
				shortMessage. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				shortMessage.share(sp);
			}
			
			break;
		case R.id.btCancel:
			dlg.dismiss();
			break;
		case R.id.module_thread:
			if (pop != null && pop.isShowing()) {  
            	pop.dismiss();   
            }
			if(thread){
				mParams.clear();
				setData();
				PreferenceUtils.setPrefBoolean(this, "Comment", true);
                thread=false;
			}else{
			thread=true;
			if(!authorid.equals("")){
			mParams.add(new BasicNameValuePair("authorid",authorid));
			}
			setData();
			PreferenceUtils.setPrefBoolean(this, "Comment", true);
			PreferenceUtils.setPrefString(this, "ChangeType", "1");
			}
			break;
		case R.id.module_collect:
		   if(!NetUtil.isConnect(this)){
 			 ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			 return;
 		    }
		   if(favrite!=null && favrite.equals("1")){
			  ToastManager.showShort(this, "You already have this post");
		       return;
		    }else{
		       Collect();
		  }
			break;
		case R.id.module_like:
			if (pop != null && pop.isShowing()) {  
            	pop.dismiss();   
            }
			OpenPostScoreDialog();
			break;
		case R.id.module_report:
			ClosePopWindow();
			
			Intent intent=new Intent(this,ReportActivity.class);
			intent.putExtra("pid",pid);
			intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
			animStartActivity(intent);
			break;
		case R.id.layout_closeDialog:
			if(dialog!=null&&dialog.isShowing()){
			dialog.dismiss();
			}
			break;
		case R.id.send:
			doComment();
			break;
		default:
			break;
		}
		
	}
	
	private void ToShareType() {
		 shareTypeDialog = new Dialog(this, R.style.ActionSheet01);
			LinearLayout layout = (LinearLayout) inflater.inflate(R.layout.tpl_other_plat_dialog, null);
			
			layout.findViewById(R.id.share_facebook).setOnClickListener(this);
			layout.findViewById(R.id.share_twitter).setOnClickListener(this);
			layout.findViewById(R.id.share_email).setOnClickListener(this);
			layout.findViewById(R.id.share_message).setOnClickListener(this);
			layout.findViewById(R.id.share_whatsapp).setOnClickListener(this);
			layout.findViewById(R.id.copy_link).setOnClickListener(this);
			
			Window w = shareTypeDialog.getWindow();
			WindowManager.LayoutParams lp = w.getAttributes();

			final int cFullFillWidth = 10000;
			layout.setMinimumWidth(cFullFillWidth);
			/*
			 * lp.x = 0; final int cMakeBottom = -1000; lp.y = cMakeBottom;
			 */
			lp.gravity = Gravity.BOTTOM;
			shareTypeDialog.onWindowAttributesChanged(lp);
//			dlg.setCanceledOnTouchOutside(false);

			shareTypeDialog.setContentView(layout);
			shareTypeDialog.show();
		
	}

	private void ShareType(int type) {
		shareTypeDialog.dismiss();
		shareType=type;
		dlg = new Dialog(this, R.style.xclub_dialog_style_with_title);
		View view = View.inflate(this, R.layout.share_plat_dialog, null);
		TextView tvTitle = (TextView) view.findViewById(R.id.tvTitle);
		TextView theme=(TextView) view.findViewById(R.id.tvTheme);
		TextView tvType=(TextView)view.findViewById(R.id.tvType);
		ImageView share_img=(ImageView)view.findViewById(R.id.share_img);
		if(url!=null&&!url.equals(""))
		mImgLoader.DisplayImage(url, share_img, 1, Constant.LESSNUM, 0, R.drawable.picture);
		View  share=view.findViewById(R.id.btShare);
		View  cancel=view.findViewById(R.id.btCancel);
		etMassage=(EditText)view.findViewById(R.id.etContent);
		etEmailOrPhone=(TextView)view.findViewById(R.id.etEmailOrPhone);
		if(type==FLAG_SHARE_FACEBOOK){
			theme.setText("Facebook");
			tvType.setText("Share your mind to facebook:");
		    theme.setBackgroundColor(0xFF345799);
		    share.setBackgroundColor(0xFF345799);
			etEmailOrPhone.setVisibility(View.GONE);
		}else if(type==FLAG_SHARE_TWITTER){
			theme.setText("Twitter");
			theme.setBackgroundColor(0xFF1BA4E7);
			share.setBackgroundColor(0xFF1BA4E7);
			tvType.setText("Share your mind to twitter:");
			etEmailOrPhone.setVisibility(View.GONE);
		}else if(type==FLAG_SHARE_WHATSAPP){
			theme.setText("Whatsapp");
			theme.setBackgroundColor(0xFF18C73A);
			share.setBackgroundColor(0xFF18C73A);
			tvType.setText("Share your mind to whatsapp:");
			etEmailOrPhone.setVisibility(View.GONE);
		}else if(type==FLAG_SHARE_EMAIL){
			theme.setText("Email");
			theme.setBackgroundColor(0xFF3278CB);
			share.setBackgroundColor(0xFF3278CB);
			tvType.setText("Share your mind to email:");
			etEmailOrPhone.setHint("Please enter your e-mail");
			etEmailOrPhone.setVisibility(View.VISIBLE);
		}else if(type==FLAG_SHARE_MESSAGE){
			theme.setText("Message");
			theme.setBackgroundColor(0xFF30CC2C);
			share.setBackgroundColor(0xFF30CC2C);
			tvType.setText("Share your mind to message:");
			etEmailOrPhone.setHint("Please enter your phone number");
			etEmailOrPhone.setVisibility(View.VISIBLE);
		}
		tvTitle.setTag(dlg);
		share.setTag(dlg);
		cancel.setTag(dlg);
		tvTitle.setText(title+""+share_url);
		share.setOnClickListener(this);
		cancel.setOnClickListener(this);
		
		dlg.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dlg.setContentView(view);
		dlg.show();
		
	}

	private void doComment() {
		if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
		message=etContent.getText().toString();
		if(message.equals("")){
			ToastManager.showShort(this, "Content can not be empty");
			return;
		}
		 params.clear();
		 MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		 PreferenceUtils.setPrefBoolean(this, "Comment", true);
		 PreferenceUtils.setPrefString(this, "ChangeType", "3");
		if (mFile.size()> 0)
			uploadFile();// 先上传图片
	  else
		sendNewComment(false);// 发送纯文本
		
	}
	private void ClosePopWindow() {
		if(pop!=null &&pop.isShowing()){
			pop.dismiss();
		}
	}
	public void OpenPostScoreDialog() {
		    dialog=new PostScoreDilog(RecommendActivity.this){
			@Override
			public void Send(String score, String reason, boolean isCheck) {
				// TODO Auto-generated method stub
				if(score.equals("0")){
					ToastManager.showShort(RecommendActivity.this, "Please score");
					return;
				}
				ArrayList<BasicNameValuePair> mParams = new ArrayList<BasicNameValuePair>();
				if(isCheck){
					mParams.add(new BasicNameValuePair("sendreasonpm","on"));
				}
			        mParams.add(new BasicNameValuePair("version","5"));
			        mParams.add(new BasicNameValuePair("module","sendrate"));
			        mParams.add(new BasicNameValuePair("mobile","no"));
			        mParams.add(new BasicNameValuePair("tid",tid));
			        mParams.add(new BasicNameValuePair("pid",pid));
			        mParams.add(new BasicNameValuePair("score2",score));
			        mParams.add(new BasicNameValuePair("reason",reason));
			        
			        mParams.add(new BasicNameValuePair("saltkey",saltkey));
			        mParams.add(new BasicNameValuePair("auth",auth));
			        
			        
			        dao = new BaseDao(RecommendActivity.this, mParams, RecommendActivity.this, null);
			        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
			                Constant.BASE_URL, "get", "false");
			        MasterApplication.getInstanse().showLoadDataDialogUtil(RecommendActivity.this,dao);
				super.Send(score, reason, isCheck);
			}
			
			
		};
		dialog.show();
		 layout_closeDialog=(RelativeLayout)dialog.findViewById(R.id.layout_closeDialog);
		layout_closeDialog.setOnClickListener(this);
	}
	private void Collect() {
		ArrayList<BasicNameValuePair> mParams = new ArrayList<BasicNameValuePair>();
		    mParams.add(new BasicNameValuePair("version","5"));
	        mParams.add(new BasicNameValuePair("module","favthread"));
	        mParams.add(new BasicNameValuePair("mobile","no"));
	        mParams.add(new BasicNameValuePair("id",tid));
	        mParams.add(new BasicNameValuePair("uid",uid));
	        mParams.add(new BasicNameValuePair("saltkey",saltkey));
	        mParams.add(new BasicNameValuePair("auth",auth));
	        
	        dao = new BaseDao(this, mParams, this, null);
	        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                Constant.BASE_URL, "get", "false");
	        MasterApplication.getInstanse().showLoadDataDialogUtil(RecommendActivity.this,dao);
	}
	private void uploadFile() {
		if (mFile.size()> 0) {
			String sys_authkey=PreferenceUtils.getPrefString(this, "sys_authkey", "");
			
	         final Map<String, String> params = new HashMap<String, String>();
	         params.put("uid", uid);
	         params.put("type", "image");
	         params.put("fid", "41");
	         params.put("auth", auth);
	         params.put("saltkey", saltkey);
	         params.put("hash", sys_authkey);
			for (Map.Entry<String, String> entry : mFile.entrySet()) {
				picPath = entry.getValue();
				// 赋值当前正在上传的图片路径
				currentUploadPath = picPath;
				break;
			}
			 params.put("filePath", currentUploadPath);
			 Runnable runnable=new Runnable() {
				
				@Override
				public void run() {
					Message msg=new Message();
					Bundle data=new Bundle();
					String result = HttpFormUtil.post(Constant.BASE_PICTRUE_URL, params);
					data.putString("value", result);
					msg.setData(data);
					handler.sendMessage(msg);
				}
			};
			new Thread(runnable).start();
			
		}
	}
      Handler handler=new Handler(){
		@SuppressWarnings("null")
		public void handleMessage(Message msg) {
			Bundle data=msg.getData();
			String result=data.getString("value");
			Log.i("info","result:"+result);
			if(result!=null ||!result.equals("")){
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
				int code=Integer.parseInt(logininfo.getVariables().getCode());
				if(code>0){
//					if(file!=null&&file.exists()){
//						file.delete();
//					}
					mFile.remove(currentUploadPath);
					String fileid = "[attach]" + logininfo.getVariables().getCode() + "[/attach]";// 图文排版
					message = message.replace(picPath, fileid);
					String fkey = "attachnew[" + logininfo.getVariables().getCode()
							+ "][decription]";// 参数
					Log.i("info","code:"+fkey);
					 params.add(new BasicNameValuePair(fkey,""));
					if (mFile.size() > 0) {// 如果还有附件继续上传
						uploadFile();
					}else{
						// 发送帖子
						sendNewComment(true);
						currentUploadPath = "";
					}
				} else {
					 MasterApplication.getInstanse().closeLoadDataDialogUtil();
					String tips = "";
					switch (code) {
					case -1:
					case -4:
					case -7:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips1);
						break;
					case -2:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips2);
						break;
					case -3:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips3);
						break;
					case -5:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips4);
						break;
					case -6:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips5);
						break;
					case -8:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips6);
						break;
					case -9:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips7);
						break;
					case -10:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips8);
						break;
					case -11:
						tips = RecommendActivity.this.getString(R.string.upload_pic_tips9);
						break;
					default:
						break;
					}
					ToastManager.showShort(RecommendActivity.this, tips);
				}
			}else{
			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
			  ToastManager.showShort(RecommendActivity.this, getString(R.string.upload_photo_error));
			}
		}
	};
	private int totalPage;
	private int currentPage;
	private String url="";
	
	
	private void sendNewComment(boolean uploadFile) {
		 if(type==0){
			 params.add(new BasicNameValuePair("version","5"));
		     params.add(new BasicNameValuePair("module","sendreply"));
		     params.add(new BasicNameValuePair("mobile","no"));
		     params.add(new BasicNameValuePair("tid",tid));
		     params.add(new BasicNameValuePair("message", message));
		     params.add(new BasicNameValuePair("pid", pid));
		     params.add(new BasicNameValuePair("saltkey",saltkey));
		     params.add(new BasicNameValuePair("auth",auth));
		 }else if(type==1){
			 params.add(new BasicNameValuePair("version","5"));
		     params.add(new BasicNameValuePair("module","sendreply"));
		     params.add(new BasicNameValuePair("mobile","no"));
		     params.add(new BasicNameValuePair("tid",tid));
		     params.add(new BasicNameValuePair("message", message));
		     params.add(new BasicNameValuePair("repquote", pid));
		     params.add(new BasicNameValuePair("saltkey",saltkey));
		     params.add(new BasicNameValuePair("auth",auth));
		 }
		     params.add(new BasicNameValuePair("phone_type",mPhoneModel));
	     if (uploadFile) {
	 		 params.add(new BasicNameValuePair("uploadalbum", "2"));// 附加参数名为uploadalbum的参数值为2
	 	     params.add(new BasicNameValuePair("replycredit_times", "1"));// 附加参数名为replycredit_times的参数值为1
	 	     params.add(new BasicNameValuePair("replycredit_membertimes", "1"));// 附加参数名为replycredit_membertimes的参数值为1
	         }
	      type=0;
	     dao = new BaseDao(this, params, this, null);
	     dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                Constant.BASE_URL, "get", "false");
	        
		
	}
	private void Dialog() {
		AlertDialog.Builder builder=new AlertDialog.Builder(this)
		.setTitle("Select")
		.setItems(items, (DialogInterface.OnClickListener) this);
		builder.create();
		builder.show();
		
		
	}
	public void onClick(DialogInterface dialog, int which) {
		switch (which) {
		case 0:
			String status = Environment.getExternalStorageState();
			if (status.equals(Environment.MEDIA_MOUNTED)) {
				try {
					localTempImageFileName = "";
					localTempImageFileName = String.valueOf((new Date())
							.getTime()) + ".png";
					
					if (!cacheFilePath.exists()) {
						cacheFilePath.mkdirs();
					}
					Intent intent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
					File f = new File(cacheFilePath, localTempImageFileName);
					Uri u = Uri.fromFile(f);
					intent.putExtra(MediaStore.EXTRA_OUTPUT, u);
					intent.putExtra(MediaStore.Images.Media.MIME_TYPE,  "image/jpeg");
					startActivityForResult(intent, FLAG_CHOOSE_PHONE);
				} catch (ActivityNotFoundException e) {
					e.printStackTrace();
				}
			}
		  break;
		case 1:
			Intent intent = new Intent();
			intent.setAction(Intent.ACTION_PICK);
			intent.setType("image/png,image/jpeg");
			startActivityForResult(intent, FLAG_CHOOSE_IMG);
			break;
		}
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == FLAG_CHOOSE_IMG && resultCode == RESULT_OK) {
			if (data != null) {
				Uri uri = data.getData();
				if (!TextUtils.isEmpty(uri.getAuthority())) {
					Cursor cursor = getContentResolver().query(uri,
							new String[] { MediaStore.Images.Media.DATA },
							null, null, null);
					if (null == cursor) {
						Toast.makeText(this, "The picture was not found", 0).show();
						return;
					}
					cursor.moveToFirst();
					String path = cursor.getString(cursor.getColumnIndex(MediaStore.Images.Media.DATA));
					 File f = new File(path);
					 File dest = new File(cacheFilePath, f.getName());
					 try{
						 FileUtils.copy(f, dest);
						 comprassBitmap(dest.getAbsolutePath(), 1);
						 handlerImage(dest.getAbsolutePath(), 0);
					 }catch (Exception e) {
					 }
				}
			}
			
	     }else if (requestCode == FLAG_CHOOSE_PHONE && resultCode == RESULT_OK) {
		     File f = new File(cacheFilePath, localTempImageFileName);
			   if(!f.exists()){
				Toast.makeText(this, "Get a picture of failure", 0).show();
				return;
			}
			
			comprassBitmap(f.getAbsolutePath(), 1);
			handlerImage(f.getAbsolutePath(), 1);
			
	  }
	}
	 private void comprassBitmap(String path, int type){
			Bitmap tmpbitmap = TextUtils.getBitmap(path);
			if(tmpbitmap.getWidth() < 720 && tmpbitmap.getHeight() < 1280){
				tmpbitmap.recycle(); 
				return;
			}
			 file = new File(path);  
			BitmapFactory.Options options = new BitmapFactory.Options();  
	        options.inJustDecodeBounds = true; 
			Bitmap bitmap = IMageUtil.zoomBitmap(path, 720, 1028);
			try {  
				FileOutputStream out = new FileOutputStream(file);
	            if (type == 0) {  
	            	bitmap.compress(Bitmap.CompressFormat.PNG, 100, out);
				} else{
					bitmap.compress(Bitmap.CompressFormat.JPEG, 80, out);
				}
	            
				  out.flush();  
				  out.close();
				  
			} catch (FileNotFoundException e) {  
			   e.printStackTrace();  
			} catch (IOException e) {  
			   e.printStackTrace();  
			}  

		}
	 /**
		 * 处理获取的图片
		 * 0表示相册选择的 1表示从相机拍的
		 */
		private void handlerImage(String path, int type){
			 //File src = new File(path);
			 //String target = Constants.TMP_PATH + File.separator + src.getName() + "temp" ;
			 try {
				 //FileUtils.copy(path, target);
				 Bitmap b = IMageUtil.createPreviewBitmap(path, 125, 125);
				 mFile.put(path, path);
				 mInputView.setBitmapText(path, b);// 将选择图片显示在输入框
//				 genUploadImageView(path, null, b, type);
			} catch (Exception e) {
				e.printStackTrace();
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
    	   logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
    	   if(logininfo.getVariables().getPostlist().size()>0){
    	    if(!PreferenceUtils.getPrefBoolean(this, "Comment", false)){
    	       pid=logininfo.getVariables().getPostlist().get(0).getPid();
    	       if(logininfo.getVariables().getPostlist().get(0).getImgage().size()>0){
    	         url=logininfo.getVariables().getPostlist().get(0).getImgage().get(0).getUrl();
    	       }
    	       PreferenceUtils.setPrefString(this, "pid", pid);
    	       authorid=logininfo.getVariables().getPostlist().get(0).getAuthorid();
    	       adapter=new PostCommentAdapter(this, logininfo.getVariables().getPostlist(),share_url){

				@Override
				public void Clicked(View v,String pid) {
					if(isShowing==1){
						isShowing=2;
						titlePopup.dismiss();
					}else{
					   titlePopup.setAnimationStyle(R.style.cricleBottomAnimation);
					   titlePopup.show(v);
					   tpid=pid;
					   isShowing=1;
					}
					super.Clicked(v,pid);
				}
    	       };
              list.setAdapter(adapter);
              page=Integer.parseInt(logininfo.getVariables().getPage());
              if(logininfo.getVariables().getTotalpage()!=null){
               totalPage=Integer.parseInt(logininfo.getVariables().getTotalpage());
              }
    	    }else{
    	    	adapter.notifyChanged(logininfo.getVariables().getPostlist());
    	    	currentPage=Integer.parseInt(logininfo.getVariables().getPage());
 			    etContent.setText("");
    	    	MasterApplication.getInstanse().closeLoadDataDialogUtil();
    	    	PreferenceUtils.setPrefBoolean(this, "Comment", false);
    	    	imm.hideSoftInputFromWindow(etContent.getWindowToken(),0);
    	    	mInputView.setVisibility(View.GONE);
    	    	pid="0";
    	    	onLoad();
    	    }
    	   }else if(logininfo.getMessage().getMessageval()!=null){
    		   if(logininfo.getMessage().getMessageval().equals("favorite_do_success")){
    			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
    			   ToastManager.showShort(this, "Collection success");
    			   imgCollect.setBackgroundResource(R.drawable.post_collect_pressed);
    			   ClosePopWindow();
    		   }else if(logininfo.getMessage().getMessageval().equals("thread_rate_succeed")){
    			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
    			   ToastManager.showShort(this, "Score success");
    			   dialog.dismiss();
    		   }else{
    			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
    			   ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
    		   }
    	   }else{
    		   MasterApplication.getInstanse().closeLoadDataDialogUtil();
    		   ToastManager.showShort(this, "Data requests failed, please try again later");
    	   }
    	  
       }else{
    	   ToastManager.showShort(this, "Data requests failed, please try again later");
    	   PreferenceUtils.setPrefBoolean(this, "Comment", false);
    	   page=currentPage;
    	   onLoad();
       }
		
	}
	
	private void onLoad() {
		list.stopLoadMore();
	}
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onRefresh() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onLoadMore() {
		// TODO Auto-generated method stub
		if(page<totalPage){
		++page;
		Log.i("info", "page:"+page);
		mParams.add(new BasicNameValuePair("page",page+""));
		dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
		PreferenceUtils.setPrefBoolean(this, "Comment", true);
		PreferenceUtils.setPrefString(this, "ChangeType", "2");
		}else{
			onLoad();
		}
	}
	@Override
	public void setContentView() {
		ShareSDK.initSDK(this);
        setContentView(R.layout.activity_recommend);
		initView();
		setData();
		
	}
	@Override
	public void initWidget() {
		mHandler = new Handler(Looper.getMainLooper(), this);
	}
	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onItemClick(ActionItem item, int position) {
	
		if(position==0){
			Intent intent=new Intent(this,ReportActivity.class);
			intent.putExtra("pid",tpid);
			animStartActivity(intent);
		}else if(position==1){
			pid=tpid;
			type=1;
   		   imm.showSoftInput(etContent, 0);
		}else if(position==2){
			pid=tpid;
			OpenPostScoreDialog();
		}
		
	}

	@Override
	public void onCancel(Platform arg0, int action) {
		// TODO Auto-generated method stub
		if (action == Platform.ACTION_USER_INFOR) {
			Message msg = new Message();
			msg.what = MSG_AUTH_CANCEL;
			msg.arg2 = action;
			mHandler.sendMessage(msg);
		}
	}

	@Override
	public void onComplete(Platform arg0, int action, HashMap<String, Object> arg2) {
		    ShareSDK.removeCookieOnAuthorize(true);
			ToastManager.showShort(this, "Share success");
			if(action==Platform.ACTION_USER_INFOR){
				Message msg = new Message();
				msg.what = MSG_AUTH_COMPLETE;
				msg.arg2 = action;
				mHandler.sendMessage(msg);
			}
		
	}

	@Override
	public void onError(Platform arg0, int action, Throwable t) {
		// TODO Auto-generated method stub
		ToastManager.showShort(this, "Share the failure");
		if (action == Platform.ACTION_USER_INFOR) {
			Message msg = new Message();
			msg.what = MSG_AUTH_ERROR;
			msg.arg2 = action;
			mHandler.sendMessage(msg);
		}
		t.printStackTrace();
	}
	/**处理操作结果*/
	public boolean handleMessage(Message msg) {
		switch(msg.what) {
			case MSG_AUTH_CANCEL: {
				// 取消
				ToastManager.showShort(RecommendActivity.this, "Stop sharing");
			} break;
			case MSG_AUTH_ERROR: {
				// 失败
				ToastManager.showShort(RecommendActivity.this, "Share the failure");
			} break;
			case MSG_AUTH_COMPLETE: {
				// 成功
				ToastManager.showShort(RecommendActivity.this, "Share success");
				
			} 
			break;
	    }
		return false;

	}
	
}
