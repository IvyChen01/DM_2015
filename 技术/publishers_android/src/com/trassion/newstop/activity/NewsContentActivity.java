package com.trassion.newstop.activity;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.locks.ReentrantReadWriteLock.ReadLock;
import java.util.zip.Inflater;

import android.app.Dialog;
import android.content.Context;
import android.os.Handler;
import android.os.Message;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.view.View.OnKeyListener;
import android.view.View.OnTouchListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AbsListView;
import android.widget.AbsListView.OnScrollListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import cn.sharesdk.facebook.Facebook;
import cn.sharesdk.facebook.Facebook.ShareParams;
import cn.sharesdk.framework.Platform;
import cn.sharesdk.framework.PlatformActionListener;
import cn.sharesdk.framework.ShareSDK;
import cn.sharesdk.twitter.Twitter;
import cn.sharesdk.whatsapp.WhatsApp;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.adapter.NewsContentAdapter;
import com.trassion.newstop.bean.Comment;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.bean.response.NewsTopAddCommentBeanresponse;
import com.trassion.newstop.bean.response.NewsTopCommentBeanresponse;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.SelectDialog;
import com.trassion.newstop.view.PullToRefresh.PullToRefreshLayout;
import com.trassion.newstop.view.PullToRefresh.PullToRefreshLayout.OnRefreshListener;

public class NewsContentActivity extends BaseActivity implements OnRefreshListener,OnClickListener,PlatformActionListener,UICallBackInterface{

	private static final int FLAG_SHARE_FACEBOOK=1;
	private static final int FLAG_SHARE_TWITTER=2;
	
	private PullToRefreshLayout refreshLayout;
	private ListView mListView;
	private ArrayList<Comment> moreComment=new ArrayList<Comment>();
	private NewsContentAdapter adapter;
	
	private ImageView imgShare;
	private ImageButton btnShare;
	
	private NewsInfo news;
	
	private LayoutInflater inflater;
	
	private ImageView[] images=new ImageView[20];
	
	private ImageLoader imageloader;
	
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private RelativeLayout rl_content;
	private RelativeLayout rlSend;
	private EditText editContent;
	private ImageView ivSend;
	private String auth;
	private String saltkey;
	
	private int page=1;
	
	private NewsTopCommentBeanresponse response;
	private InputMethodManager imm;
	
	private Handler mHandler = new Handler(){
		public void handleMessage(Message msg) {
			refreshLayout.loadmoreFinish(PullToRefreshLayout.SUCCEED);
		};
	};
	private ImageView btnCollection;
	private ImageManager imageManager;
	private ImageButton btnMessage;
	private TextView tvNum;
	private Dialog shareTypeDialog;
	private Dialog dlg;
	private EditText etMassage;
	private int shareType;

	@Override
	public void setContentView() {
		ShareSDK.initSDK(this);
		setContentView(R.layout.activity_news_content);
		
		 imageloader=ImageLoader.getInstance();
		 imageManager=new ImageManager();
		 imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		 
		 auth=PreferenceUtils.getPrefString(this, "auth", "");
		 saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
		
		imgShare=(ImageView)findViewById(R.id.imgAdd);
		btnShare=(ImageButton)findViewById(R.id.btnShare);
		rl_content=(RelativeLayout)findViewById(R.id.rl_content);
		rlSend=(RelativeLayout)findViewById(R.id.rlSend);
		editContent=(EditText)findViewById(R.id.editContent);
		btnCollection=(ImageView)findViewById(R.id.btnCollection);
		btnMessage=(ImageButton)findViewById(R.id.btnMessage);
		tvNum=(TextView)findViewById(R.id.tvNum);
		ivSend=(ImageView)findViewById(R.id.ivSend);
		
		inflater=LayoutInflater.from(this);
        
		imgShare.setOnClickListener(this);
		btnShare.setOnClickListener(this);
		ivSend.setOnClickListener(this);
		btnCollection.setOnClickListener(this);
		btnMessage.setOnClickListener(this);
		
		 news = (NewsInfo)getIntent().getSerializableExtra(NewsFragment.SER_KEY);
		 
		 request = new NewsTopInfoListRequest(this);
		 mHttpAgent = new HttpTransAgent(this,this);
		 
		 requestNewsTopComntent(news.getNewsid());
		 
		 editContent.addTextChangedListener(new TextWatcher() {
				String befText;

				@Override
				public void onTextChanged(CharSequence s, int start, int before,
						int count) {

				}

				@Override
				public void beforeTextChanged(CharSequence s, int start, int count,
						int after) {
					befText = editContent.getText().toString();
				}

				@Override
				public void afterTextChanged(Editable s) {
					// �ж��Ƿ�ɾ��ͼƬ����ɾ������mFile���Ƴ��ͼƬ·��
					String nowText = editContent.getText().toString();
					if(nowText.length()>0){
						rl_content.setVisibility(View.GONE);
						rlSend.setVisibility(View.VISIBLE);
					}else{
						rl_content.setVisibility(View.VISIBLE);
						rlSend.setVisibility(View.GONE);
					}
				}
			});

	}


	@Override
	public void initWidget() {
		refreshLayout = (PullToRefreshLayout)findViewById(R.id.refresh);
		btnShare=(ImageButton)findViewById(R.id.btnShare);
		
		refreshLayout.canPull=false;
		
		refreshLayout.setOnRefreshListener(this);
		
		mListView = (ListView)findViewById(R.id.mListView);
		
		
		
		initNewsTop();

	}

	private void initNewsTop() {
		View v=inflater.inflate(R.layout.view_news_top, null);
		TextView tvTitle=(TextView)v.findViewById(R.id.tvTitle);
		TextView tvFrom=(TextView)v.findViewById(R.id.tvFrom);
		TextView tvTime=(TextView)v.findViewById(R.id.tvTime);
		TextView tvContent=(TextView)v.findViewById(R.id.tvContent);
		
		images[0]=(ImageView)v.findViewById(R.id.imgpicture4);
		images[1]=(ImageView)v.findViewById(R.id.imgpicture5);
		images[2]=(ImageView)v.findViewById(R.id.imgpicture6);
		images[3]=(ImageView)v.findViewById(R.id.imgpicture7);
		images[4]=(ImageView)v.findViewById(R.id.imgpicture8);
		images[5]=(ImageView)v.findViewById(R.id.imgpicture9);
		images[6]=(ImageView)v.findViewById(R.id.imgpicture10);
		images[7]=(ImageView)v.findViewById(R.id.imgpicture11);
		images[8]=(ImageView)v.findViewById(R.id.imgpicture12);
		images[9]=(ImageView)v.findViewById(R.id.imgpicture13);
		images[10]=(ImageView)v.findViewById(R.id.imgpicture14);
		images[11]=(ImageView)v.findViewById(R.id.imgpicture15);
		images[12]=(ImageView)v.findViewById(R.id.imgpicture16);
		images[13]=(ImageView)v.findViewById(R.id.imgpicture17);
		images[14]=(ImageView)v.findViewById(R.id.imgpicture18);
		images[15]=(ImageView)v.findViewById(R.id.imgpicture19);
		images[16]=(ImageView)v.findViewById(R.id.imgpicture20);
		images[17]=(ImageView)v.findViewById(R.id.imgpicture21);
		images[18]=(ImageView)v.findViewById(R.id.imgpicture22);
		images[19]=(ImageView)v.findViewById(R.id.imgpicture23);
		
		if(news.getImages().size()>0){
			for(int i=0;i<news.getImages().size();i++){
				try {
					if(i<=20){
						imageloader.displayImage(news.getImages().get(i).getFull_img(), images[i],imageManager.mDisplayImageOption,imageManager.animateFirstListener);  
					}
					} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
    	}
		
		tvTitle.setText(Utils.replaceChart(news.getTitle()));
		tvFrom.setText(news.getAuthor());
		tvTime.setText(news.getPubdate());
		tvContent.setText(Utils.replaceChart(news.getContent()));
		
		mListView.addHeaderView(v);
		
	}

	@Override
	public void initData() {
         if(news.getCollected().equals("0")){
        	 btnCollection.setBackgroundResource(R.drawable.bottom_icon_collection_normal);
         }else if(news.getCollected().equals("1")){
        	 btnCollection.setBackgroundResource(R.drawable.bottom_icon_collection_press);
         }
         
	}
	private void ToShareType() {
		 shareTypeDialog = new Dialog(this, R.style.ActionSheet01);
			LinearLayout layout = (LinearLayout) inflater.inflate(R.layout.share_palt_dialog, null);
			
			layout.findViewById(R.id.share_facebook).setOnClickListener(this);
			layout.findViewById(R.id.share_twitter).setOnClickListener(this);
			
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
		View view = View.inflate(this, R.layout.share_dialog, null);
		TextView tvNewsName = (TextView) view.findViewById(R.id.tvNewsName);
		TextView tvNewsTitle=(TextView) view.findViewById(R.id.tvNewsTitle);
		ImageView share_img=(ImageView)view.findViewById(R.id.imgPicture);
		if(news.getImages().get(0).getMedium_img()!=null&&!news.getImages().get(0).getMedium_img().equals(""))
		imageloader.displayImage(news.getImages().get(0).getMedium_img(), share_img, imageManager.mDisplayImageOption,imageManager.animateFirstListener);
		View  share=view.findViewById(R.id.btnDialogShare);
		View  cancel=view.findViewById(R.id.btnDialogCancel);
		etMassage=(EditText)view.findViewById(R.id.etNewscontent);
		if(type==FLAG_SHARE_FACEBOOK){
			tvNewsName.setText("Share to facebook");
		}else if(type==FLAG_SHARE_TWITTER){
			tvNewsName.setText("Share to twitter");
		}
		tvNewsName.setTag(dlg);
		share.setTag(dlg);
		cancel.setTag(dlg);
		tvNewsTitle.setText(news.getTitle()+"");
		share.setOnClickListener(this);
		cancel.setOnClickListener(this);
		
		dlg.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dlg.setContentView(view);
		dlg.show();
		
		etMassage.setOnKeyListener(new OnKeyListener() {
			
			@Override
			public boolean onKey(View v, int keyCode, KeyEvent event) {
				if(keyCode==KeyEvent.KEYCODE_ENTER){//修改回车键功能 
					// 先隐藏键盘 
					imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
				}
				return false;
			}
		});
	}

	@Override
	public void onRefresh(final PullToRefreshLayout pullToRefreshLayout) {
		// TODO Auto-generated method stub
//		new Handler() {
//			@Override
//			public void handleMessage(Message msg) {
//				// ǧ������˸��߿ؼ�ˢ�������Ŷ��
//				pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
//			}
//		}.sendEmptyMessageDelayed(0, 2000);
//		
//		adapter.notifyDataSetChanged();
	}

	@Override
	public void onLoadMore(PullToRefreshLayout pullToRefreshLayout) {
		
		
		if(page<(Integer.parseInt(response.getTotal()))/20+1){
			String currentPage=(++page)+"";
			if (NetworkUtil.isOnline(this)) {
				mHttpAgent.isShowProgress = false;
				request.getNewsTopListByCommentRequest(mHttpAgent, Utils.getPhoneIMEI(this),currentPage,"20", news.getNewsid(),Constants.HTTP_GET_MORE_COMMENT );
			} else {
				Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			}

		}else{
			pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
		}
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.imgAdd:
			ToShareType();
			break;
		case R.id.btnShare:
			ToShareType();
           break;
		case R.id.ivSend:
			requestSendComment();
			break;
		case R.id.btnCollection:
			if(news.getCollected().equals("0")){
			requestCollectionNews();
			}else if(news.getCollected().equals("1")){
				requestCancelCollectionNews();
			}
			break;
		case R.id.btnMessage:
			mListView.setSelection(1);
			break;
		case R.id.share_facebook:
			ShareType(FLAG_SHARE_FACEBOOK);
			break;
		case R.id.share_twitter:
			ShareType(FLAG_SHARE_TWITTER);
			break;
		case R.id.btnDialogShare:
			dlg.dismiss();
			imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);  
			
			String message=etMassage.getText().toString();
//			ShareSDK.initSDK(this);
			ShareParams sp = new ShareParams();
			sp.setText(message+" "+news.getTitle());
			
           if(news.getImages().get(0).getMedium_img()!=null&&!news.getImages().get(0).getMedium_img().equals("")){
        	   sp.setImageUrl(news.getImages().get(0).getMedium_img());
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
			}
			
			break;
		case R.id.btnDialogCancel:
			dlg.dismiss();
			break;
		default:
			break;
		}
		
	}




	private void requestCollectionNews() {
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByCollectNewsRequest(mHttpAgent, Utils.getPhoneIMEI(this), auth, saltkey, news.getNewsid(), Constants.HTTP_COLLECT_NEWS);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}
	private void requestCancelCollectionNews() {
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByCollectNewsRequest(mHttpAgent, Utils.getPhoneIMEI(this), auth, saltkey, news.getNewsid(), Constants.HTTP_CANCAL_COLLECT_NEWS);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}



	private void requestSendComment() {
	  String content=editContent.getText().toString();
	  if(TextUtils.isEmpty(content)){
			ToastManager.showShort(this, "Comment cannot be empty");
			return;
		}
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListBySendCommentRequest(mHttpAgent, Utils.getPhoneIMEI(this), auth, saltkey, content, news.getNewsid(), Constants.HTTP_SEND_COMMENT);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}


	private void requestNewsTopComntent(String newsId) {
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByCommentRequest(mHttpAgent, Utils.getPhoneIMEI(this),"1","20", newsId,Constants.HTTP_GET_COMMENT );
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}
   

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			if(msgId==Constants.HTTP_GET_COMMENT){
				mHttpAgent.isShowProgress=false;
			response=(NewsTopCommentBeanresponse)bean;
			
			adapter=new NewsContentAdapter(this, response.getData());
			mListView.setAdapter(adapter);
			if(response.getTotal().equals("0")){
				tvNum.setVisibility(View.GONE);
			}else{
				tvNum.setVisibility(View.VISIBLE);
			}
			tvNum.setText(response.getTotal());
			}else if(msgId==Constants.HTTP_GET_MORE_COMMENT){
				mHttpAgent.isShowProgress=false;
			    response=(NewsTopCommentBeanresponse)bean;
			    adapter.notifyChanged(response.getData());
			    refreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
			}else if(msgId==Constants.HTTP_SEND_COMMENT){
				editContent.setText("");
				imm.hideSoftInputFromWindow(editContent.getWindowToken(), 0);
				
				NewsTopAddCommentBeanresponse res=(NewsTopAddCommentBeanresponse)bean;
				if(res.getCode().equals("0")){
					adapter.notifyChanged(res.getData());
					tvNum.setVisibility(View.VISIBLE);
					tvNum.setText((Integer.parseInt(response.getTotal())+1)+"");
				}else if(res.getMsg().equals("Not login!")){
					 StartActivity(LoginActivity.class);
					 ToastManager.showShort(this, res.getMsg());
				}else{
					ToastManager.showShort(this, res.getMsg());
				}
			}else if(msgId==Constants.HTTP_COLLECT_NEWS){
				NewsTopRegisterBeanresponse	response=(NewsTopRegisterBeanresponse)bean;
				if(response.getCode().equals("0")){
					btnCollection.setBackgroundResource(R.drawable.bottom_icon_collection_press);
					ToastManager.showShort(this, "Collection of success");
					news.setCollected("1");
				}else{
					ToastManager.showShort(this, response.getMsg());
				}
			}else if(msgId==Constants.HTTP_CANCAL_COLLECT_NEWS){
				NewsTopRegisterBeanresponse	response=(NewsTopRegisterBeanresponse)bean;
				if(response.getCode().equals("0")){
					btnCollection.setBackgroundResource(R.drawable.bottom_icon_collection_normal);
					ToastManager.showShort(this, "Cancel the collection success");
					news.setCollected("0");
				}else{
					ToastManager.showShort(this, response.getMsg());
				}
			}
		}
		
	}


	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
		
	}


	@Override
	public void onCancel(Platform arg0, int arg1) {
		// TODO Auto-generated method stub
		
	}


	@Override
	public void onComplete(Platform arg0, int arg1, HashMap<String, Object> arg2) {
		 ShareSDK.removeCookieOnAuthorize(true);
		ToastManager.showShort(this, "Share success");
		
	}


	@Override
	public void onError(Platform arg0, int arg1, Throwable arg2) {
		// TODO Auto-generated method stub
		
	}
}
