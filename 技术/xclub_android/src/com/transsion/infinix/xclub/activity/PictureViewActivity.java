package com.transsion.infinix.xclub.activity;


import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.ViewGroup.LayoutParams;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;

import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.facebook.Facebook.ShareParams;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.instagram.Instagram;
import cn.sharesdk.twitter.Twitter;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.touch.GestureImageView;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.XclubProgressDialog;
import com.trassion.infinix.xclub.R;

public class PictureViewActivity extends BaseActivity implements OnClickListener, PlatformActionListener{
	private String[] imgUrl;
	private int currentIndex=0;
	List<View> imageViews = new ArrayList<View>();
	private LinearLayout tvback;
	private LinearLayout tvSave;
	private TextView indexTextView;
	private ViewPager pictureViewPager;
	private ImageLoader mImgLoader;
	private XclubProgressDialog xclubProgressDialog;
	private String[] description;
	private TextView tvContent;
	private RelativeLayout btSaveOrshare;
	private PopupWindow pop;
	private LayoutInflater inflater;
	private PopupWindow shareView;
	private LinearLayout ll;
	private Dialog dlg;
	private EditText etMassage;
	private static final int FLAG_SHARE_FACEBOOK=1;
	private static final int FLAG_SHARE_TWITTER=2;
	private static final int FLAG_SHARE_INSTAGRAM=3;
	private InputMethodManager imm=null; //软键盘管理
	private int shareType;
	private String postUrl;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_loading_picture);

	}

	@Override
	public void initWidget() {
		Intent intent=getIntent();
        Bundle bundle=intent.getExtras();
        imgUrl=bundle.getStringArray("picUrl");
        postUrl=bundle.getString("PostUrl");
        description=bundle.getStringArray("Description");
        currentIndex=bundle.getInt("initIndex");
        tvback=(LinearLayout)findViewById(R.id.tvback);
        btSaveOrshare=(RelativeLayout)findViewById(R.id.btSaveOrshare);
        indexTextView = (TextView) findViewById(R.id.indexTextView);
        ll=(LinearLayout)findViewById(R.id.ll);
		pictureViewPager = (ViewPager) findViewById(R.id.pictureViewPager);
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		 inflater = LayoutInflater.from(this);
		initPopuptWindow();
//		initSharePopupWindow();
		mImgLoader = ImageLoader.getInstance(this);
		
		for (int i = 0; i < imgUrl.length; i++) {
			imageViews.add(createImageView(imgUrl[i],i));
		}

		indexTextView.setText((currentIndex + 1) + "/" + imageViews.size());
		
		PagerAdapter pagerAdapter = new PagerAdapter() {

			@Override
			public int getCount() {
				return imageViews.size();
			}

			@Override
			public boolean isViewFromObject(View arg0, Object arg1) {
				return arg0 == arg1;
			}

			@Override
			public void destroyItem(ViewGroup container, int position,
					Object object) {
				container.removeView(imageViews.get(position));
			}

			@Override
			public CharSequence getPageTitle(int position) {
				return String.valueOf(position);

			}

			@Override
			public Object instantiateItem(ViewGroup container, int position) {
				View view = imageViews.get(position);
				container.addView(view, 0);

				return imageViews.get(position);
			}
		};

		pictureViewPager.setAdapter(pagerAdapter);
		pictureViewPager.setCurrentItem(currentIndex);
		
		pictureViewPager.setOnPageChangeListener(new OnPageChangeListener() {

			@Override
			public void onPageSelected(int arg0) {
				indexTextView.setText((arg0 + 1) + "/" + imageViews.size());
			}

			@Override
			public void onPageScrolled(int arg0, float arg1, int arg2) {
			}

			@Override
			public void onPageScrollStateChanged(int arg0) {
			}
		});
        
        
	}

	private void initSharePopupWindow() {
		 dlg = new Dialog(this, R.style.ActionSheet01);
		LinearLayout layout = (LinearLayout) inflater.inflate(R.layout.share_pictrue_dialog, null);
		
		layout.findViewById(R.id.share_facebook).setOnClickListener(this);
		layout.findViewById(R.id.share_twitter).setOnClickListener(this);
		layout.findViewById(R.id.share_instagram).setOnClickListener(this);
		
		Window w = dlg.getWindow();
		WindowManager.LayoutParams lp = w.getAttributes();

		final int cFullFillWidth = 10000;
		layout.setMinimumWidth(cFullFillWidth);
		/*
		 * lp.x = 0; final int cMakeBottom = -1000; lp.y = cMakeBottom;
		 */
		lp.gravity = Gravity.BOTTOM;
		dlg.onWindowAttributesChanged(lp);
//		dlg.setCanceledOnTouchOutside(false);

		dlg.setContentView(layout);
		dlg.show();
	}

	private void initPopuptWindow() {
		View popView = inflater.inflate(R.layout.picture_save_dialog, null);
		if(pop==null){
		   pop = new PopupWindow(popView,LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT);
		}
		popView.findViewById(R.id.download_pictrue).setOnClickListener(this);
		popView.findViewById(R.id.shared_pictrue).setOnClickListener(this);
		
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
		
//		pop.setContentView(popView);
		pop.setFocusable(true);
		
		
	}

	private View createImageView(String url, int index) {
		View view = this.getLayoutInflater().inflate(R.layout.loading_picture_layout, null);
		GestureImageView iv = (GestureImageView) view.findViewById(R.id.picImageView);
		 tvContent=(TextView)view.findViewById(R.id.tvContent);
			tvContent.setText(description[index]);
		iv.setTag(url);
		
		mImgLoader.DisplayImage(url, iv, 1, Constant.LESSNUM-currentIndex, 10, R.drawable.picture);
	
		ImageView thunbIV = (ImageView) view.findViewById(R.id.thumbImageView);
		if(imgUrl != null && imgUrl.length <= index){
			mImgLoader.DisplayImage(imgUrl[index], thunbIV, 1, Constant.LESSNUM-currentIndex, 10, R.drawable.picture);
		}
		
		return view;
	}

	@Override
	public void getData() {
		tvback.setOnClickListener(this);
        btSaveOrshare.setOnClickListener(this);

	}
	@Override
	protected void onDestroy() {
		super.onDestroy();
		imageViews.clear();
	}
	private void showProgressDialog(){
		 if(xclubProgressDialog != null && xclubProgressDialog.isShowing()){
			 xclubProgressDialog.dismiss();
		 }
		 xclubProgressDialog = new XclubProgressDialog(this);
		 xclubProgressDialog.setMessage("Is save pictures, please wait...");
		 xclubProgressDialog.show();
	}
	private void getPopupWindow() {  
        if (null != pop && pop.isShowing()) {  
            pop.dismiss();  
            return;  
        } else if(null != pop && !pop.isShowing()){  
        	pop.showAsDropDown(findViewById(R.id.layout_top), 0, 0);
        }  
    }
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			finish();
			break;
		case R.id.btSaveOrshare:
			getPopupWindow();
			break;
		case R.id.shared_pictrue:
			getPopupWindow();
			initSharePopupWindow();
			break;
		case R.id.share_facebook:
			if(dlg!=null&&dlg.isShowing()){
				dlg.dismiss();
			}
			ShareType(FLAG_SHARE_FACEBOOK);
			break;
		case R.id.share_twitter:
			if(dlg!=null&&dlg.isShowing()){
				dlg.dismiss();
			}
			ShareType(FLAG_SHARE_TWITTER);
			break;
		case R.id.share_instagram:
			if(dlg!=null&&dlg.isShowing()){
				dlg.dismiss();
			}
			ShareType(FLAG_SHARE_INSTAGRAM);
			break;
		case R.id.btShare:
			dlg.dismiss();
			imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
			String message=etMassage.getText().toString();
			ShareSDK.initSDK(this);
			ShareParams sp = new ShareParams();
			sp.setText(message+" "+postUrl);
        	   sp.setImagePath(mImgLoader.getCachePath(imgUrl[currentIndex]));
			
			
			if(shareType==FLAG_SHARE_FACEBOOK){
				Platform facebook = ShareSDK.getPlatform (Facebook.NAME);
				facebook.setPlatformActionListener (this); // 设置分享事件回调
				facebook.SSOSetting(true);
				// 执行图文分享
				facebook.share(sp);
			}else if(shareType==FLAG_SHARE_TWITTER){
				Platform facebook = ShareSDK.getPlatform (Twitter.NAME);
				facebook. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				facebook.share(sp);
			}else{
				Platform facebook = ShareSDK.getPlatform (Instagram.NAME);
				facebook. setPlatformActionListener (this); // 设置分享事件回调
				// 执行图文分享
				facebook.share(sp);
			}
			break;
		case R.id.btCancel:
			imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
			dlg.dismiss();
			break;
		case R.id.download_pictrue:
			getPopupWindow();
			showProgressDialog();
			 
			 int i = pictureViewPager.getCurrentItem();
			 View view = imageViews.get(i);
			 ImageView iv = (ImageView) view.findViewById(R.id.picImageView);
			 Drawable drawable = iv.getDrawable();
			 if(drawable != null){
				 final Bitmap b = ((BitmapDrawable)drawable).getBitmap();
				 if(b != null && !b.isRecycled()){
					 new Thread(new Runnable() {
						
						@Override
						public void run() {
							saveBitmap(java.util.UUID.randomUUID().toString(), b);
							
						}
					}).start();
					 
				 }
			 }else{
				  ToastManager.showShort(this,"Image to load, please try again later");
			 }
			break;

		default:
			break;
		}
		
	}
	private void ShareType(int type) {
		shareType=type;
		dlg = new Dialog(this, R.style.xclub_dialog_style_with_title);
		View view = View.inflate(this, R.layout.share_plat_dialog, null);
		TextView tvTitle = (TextView) view.findViewById(R.id.tvTitle);
		ImageView shareImg=(ImageView)view.findViewById(R.id.share_img);
		etMassage=(EditText)view.findViewById(R.id.etContent);
		TextView theme=(TextView) view.findViewById(R.id.tvTheme);
		mImgLoader.DisplayImage(imgUrl[currentIndex], shareImg, 1, Constant.LESSNUM-currentIndex, 10, R.drawable.picture);
		if(type==FLAG_SHARE_FACEBOOK){
			theme.setText("Facebook");
		}else if(type==FLAG_SHARE_TWITTER){
			theme.setText("Twitter");
		}else if(type==FLAG_SHARE_INSTAGRAM){
			theme.setText("Instagram");
		}
		View  share=view.findViewById(R.id.btShare);
		View  cancel=view.findViewById(R.id.btCancel);
		tvTitle.setText(postUrl);
		share.setTop(30);
		tvTitle.setTag(dlg);
		share.setTag(dlg);
		cancel.setTag(dlg);
		share.setOnClickListener(this);
		cancel.setOnClickListener(this);
		
		dlg.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dlg.setContentView(view);
		dlg.show();
		
	}
	Handler uiHandler = new Handler(){
		@Override
		public void handleMessage(Message msg) {
			if(msg.what == 0){
				  ToastManager.showShort(PictureViewActivity.this, "Images saved successfully");
				  if(xclubProgressDialog != null){
					  xclubProgressDialog.dismiss();

				  }
			} else if (msg.what == 1){
				ToastManager.showShort(PictureViewActivity.this, "Save failed, please check the capacity of SD card");
				  if(xclubProgressDialog != null){
					  xclubProgressDialog.dismiss();
				  }
			} 
		}
		
	};
	/**
	 * 保存图片
	 * @param fileName
	 * @param mBitmap
	 */
	private void saveBitmap(String fileName, Bitmap mBitmap){
//		MediaStore.Images.Media.insertImage(getContentResolver(), mBitmap, "", ""); 
		if (!FileUtils.isExist(Constant.FILE_SAVE_PATH)){
			FileUtils.createDir(Constant.FILE_SAVE_PATH);
		}
		  File f = new File(Constant.FILE_SAVE_PATH + File.separator + fileName + ".png");
		  try {
		        f.createNewFile();
		  } catch (IOException e) {
		  }
		  
		  FileOutputStream fOut = null;
		  
		  try {
		       fOut = new FileOutputStream(f);
		  } catch (FileNotFoundException e) {
		      e.printStackTrace();
		      uiHandler.sendEmptyMessage(1);
		      return;
		  }
		  
		  mBitmap.compress(Bitmap.CompressFormat.PNG, 100, fOut);
		  try {
		       fOut.flush();
		  } catch (IOException e) {
		       e.printStackTrace();
		       uiHandler.sendEmptyMessage(1);
		  }
		  
		  try {
		       fOut.close();
		  } catch (IOException e) {
		       e.printStackTrace();
		  }
		  
	      Intent scanIntent = new Intent(Intent.ACTION_MEDIA_SCANNER_SCAN_FILE);
	      scanIntent.setData(Uri.fromFile(f));
	      this.sendBroadcast(scanIntent);

		  uiHandler.sendEmptyMessage(0);
		  
	}

	@Override
	public void onCancel(Platform arg0, int arg1) {
		// TODO Auto-generated method stub
		ToastManager.showShort(this, "Stop sharing");
	}

	@Override
	public void onComplete(Platform arg0, int action, HashMap<String, Object> arg2) {
		    ShareSDK.removeCookieOnAuthorize(true);
			ToastManager.showShort(this, "Share success");
		
	}

	@Override
	public void onError(Platform arg0, int arg1, Throwable arg2) {
		// TODO Auto-generated method stub
		ToastManager.showShort(this, "Share the failure");
	}

}
