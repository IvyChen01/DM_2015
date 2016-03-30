package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.content.Context;
import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.ScrollView;
import android.widget.TextView;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.ImageInfo;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.util.Utils;
import com.transsion.infinix.xclub.view.EmoteInputView;
import com.trassion.infinix.xclub.R;

public class FeedBackActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
    
	private LinearLayout tvback;
	private LinearLayout linearLayout;
	private ScrollView scrollView;
	private ArrayList<BasicNameValuePair> mParams;
	private String uid;
	private String saltkey;
	private String auth;
	private BaseDao dao;
	private String touid;
	private LoginInfo logininfo;
	private LayoutInflater inflater;
	private ImageLoader mImageLoader;
	Handler handler = new Handler();
	private ImageView imgFace;
	private EmoteInputView mInputView;
	private EditText etContent;
	private InputMethodManager imm;
	private Button send;
	private String message;


	private void initView() {
		inflater=LayoutInflater.from(this);
		tvback=(LinearLayout)findViewById(R.id.tvback);
//		imgFace=(ImageView)findViewById(R.id.imgFace);
		linearLayout = (LinearLayout) findViewById(R.id.linearLayout_message);
		scrollView = (ScrollView) findViewById(R.id.scrollView_group_chat);
		send=(Button)findViewById(R.id.send);
		etContent=(EditText)findViewById(R.id.etContent);
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		mInputView = (EmoteInputView) findViewById(R.id.chat_eiv_inputview);
		mInputView.setEditText(etContent);

		mImageLoader = ImageLoader.getInstance(this);
		
		tvback.setOnClickListener(this);
//		imgFace.setOnClickListener(this);
		send.setOnClickListener(this);
		
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
			
			@Override
			public void onTextChanged(CharSequence s, int start, int before, int count) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
				// TODO Auto-generated method stub
				
			}
			
			@Override
			public void afterTextChanged(Editable s) {
				if(etContent.getText().length()>0){
					send.setBackgroundResource(R.drawable.comment_send_pressed);
				}else{
					send.setBackgroundResource(R.drawable.commment_send_bg);
				}
				
			}
		});
		
	}
	private void setData() {
		touid=getIntent().getStringExtra("touid");
		Log.i("info", "touid:"+touid);
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
		
		mParams=new ArrayList<BasicNameValuePair>();
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","mypm"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("touid",touid));
        mParams.add(new BasicNameValuePair("subop","view"));
        
        mParams.add(new BasicNameValuePair("uid",uid));
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth",auth));
        
        
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
		
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
//		case R.id.imgFace:
//			if(mInputView.isShown()){
//				imm.hideSoftInputFromWindow(etContent.getWindowToken(), 0);
//			    mInputView.setVisibility(View.GONE);
//				}else{
//					imm.hideSoftInputFromWindow(etContent.getWindowToken(), 0);
//				    mInputView.setVisibility(View.VISIBLE);
//				}
//			break;
		case R.id.send:
			if(!NetUtil.isConnect(this)){
	 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
	 		}
			message=etContent.getText().toString();
			if(message.equals("")){
				ToastManager.showShort(this, "Content can not be empty");
				return;
			}
			sendMessage();
			break;
		default:
			break;
		}
		
	}

	private void sendMessage() {
		Log.i("info", "message:"+message);
	  ArrayList<BasicNameValuePair>	params=new ArrayList<BasicNameValuePair>();
        params.add(new BasicNameValuePair("version","5"));
        params.add(new BasicNameValuePair("module","sendpm"));
        params.add(new BasicNameValuePair("mobile","no"));
        params.add(new BasicNameValuePair("touid",touid));
        params.add(new BasicNameValuePair("message",message));
        
        params.add(new BasicNameValuePair("saltkey",saltkey));
        params.add(new BasicNameValuePair("auth",auth));
		
        dao = new BaseDao(this, params, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
	}

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub

	}

	@Override
	public void onComplete(BaseEntity result) {
		String avatar;
		if(result!=null){
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getMessage().getMessageval()!=null){
				  if(logininfo.getMessage().getMessageval().equals("do_success")){
					  ToastManager.showShort(this, "Success!");
					  etContent.setText("");
					  setData();
				  }else{
					  ToastManager.showShort(this, "Failure");
				  }
			}else if(logininfo.getVariables().getList().size()>0){
				linearLayout.removeAllViews();
				for(int i=0;i<logininfo.getVariables().getList().size();i++){
					View view=null;
					if(logininfo.getVariables().getList().get(i).getMsgfromid().equals(uid)){
						view = View.inflate(this, R.layout.message_right, null);
					}else{
						view=View.inflate(this, R.layout.message_left, null);
					}
					if(!logininfo.getVariables().getList().get(i).getMsgfromid().equals(uid)){
						 avatar=logininfo.getVariables().getList().get(i).getAvatar();
					}else{
						avatar=logininfo.getVariables().getList().get(i).getUid_avatar();
					}
					linearLayout.addView(view);
					setViewData(avatar,logininfo.getVariables().getList().get(i).getMessage(),logininfo.getVariables().getList().get(i).getMessage_imgsrc(),view);
				}
			}
			handler.post(new Runnable() {

				@Override
				public void run() {

					try {
						int scrollViewHeight = scrollView.getHeight();
						int linearLayoutHeight = linearLayout.getHeight();
						if (linearLayoutHeight > scrollViewHeight) {
							scrollView.scrollTo(0, linearLayoutHeight
									- scrollViewHeight);
						}
					} catch (Exception e) {
						// TODO: handle exception
					}
				}
			});
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
		}
		
	}
    
	private void setViewData(String avatar,String message,ArrayList<ImageInfo> message_imgsrc, View view) {
		String url=avatar.substring(avatar.indexOf("http"),avatar.indexOf("small") + 5);
		TextView tvText = (TextView)view.findViewById(R.id.tv_text);
		ImageView imghead=(ImageView)view.findViewById(R.id.imghead);
		ListView listView=(ListView)view.findViewById(R.id.listView);
		
//		if(message_imgsrc!=null && message_imgsrc.size()>0){
//		MessagePhotoAdapter adapter=new MessagePhotoAdapter(this, message_imgsrc, mImageLoader);
//		listView.setAdapter(adapter);
//		listView.setVisibility(View.VISIBLE);
//		}else{
//			listView.setVisibility(View.GONE);
//		}
		tvText.setVisibility(View.VISIBLE);
		
		String messages=TextUtils.replaceChart(message);
		tvText.setText(messages);
		//链接样式, 显示表情
	    Utils.getUtils().addLinks("",tvText);
		mImageLoader.DisplayImage(url, imghead, 1, Constant.LESSNUM, 0, R.drawable.picture);
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_feedback);
		initView();
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
