
package com.transsion.infinix.xclub.fragment;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;

import org.apache.http.message.BasicNameValuePair;



import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.LoginActivity;
import com.transsion.infinix.xclub.activity.RecommendActivity;
import com.transsion.infinix.xclub.activity.SearchActivity;
import com.transsion.infinix.xclub.activity.SlidingActivity;
import com.transsion.infinix.xclub.activity.WebActivity;
import com.transsion.infinix.xclub.activity.WritePostActivity;
import com.transsion.infinix.xclub.adpter.PostAdapter;
import com.transsion.infinix.xclub.bean.ImagesInfo;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.CRequest;
import com.transsion.infinix.xclub.util.DateTimeUtils;
import com.transsion.infinix.xclub.util.DisplayUtil;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.XListView;
import com.transsion.infinix.xclub.view.BannerPager.OnSingleTouchListener;
import com.transsion.infinix.xclub.view.XListView.IXListViewListener;
import com.trassion.infinix.xclub.R;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.os.SystemClock;
import android.support.v4.app.Fragment;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.Toast;
import android.widget.ImageView.ScaleType;
import android.widget.LinearLayout.LayoutParams;
import android.widget.Switch;



public class MainFragment extends Fragment implements IXListViewListener, OnPageChangeListener,OnClickListener,OnSingleTouchListener,RequestListener<BaseEntity>{
	private ViewPager mViewPager;
	private List<ImageView> imageViewList;
	private LinearLayout llPoints;
	private int previousSelectPosition = 0;
	private boolean isLoop = true;
	private  XListView  list;
	private Context context;
	private Thread thread;
	private PostAdapter adapter;
	private Handler mHandler;
	private ImageView ivRight;
	private ImageView ivWriteCode;
	private LinearLayout search;
	private ImageButton btsearch;
	private ImageView imgLocat;
	private PopupWindow popupWindow;
	private ImageButton bthome;
	private ArrayList<BasicNameValuePair> mParams;
	private LinearLayout[] layoutArray=new  LinearLayout[16]; 
	private ImageView[] imgArray=new ImageView[16];
	private int currentIndex=-1;
	private BaseDao dao;
	
	public  LoginInfo logininfo;
	private int page=1;
	//缓存文件名称
	String cacheFilePath = Constant.TEXT_PATH+"/post.ca";
	
	private Handler handler = new Handler() {

		@Override
		public void handleMessage(Message msg) {
			mViewPager.setCurrentItem(mViewPager.getCurrentItem() + 1);
		}
	};
	private String saltkey;
	private String auth;
	private RelativeLayout layout_bottom;
	private RelativeLayout head_layout;
	private int totalpage;
	private int Currentpage;
	private ImageLoader mImgLoader;
	private String tid;
	private ArrayList<ImagesInfo>ad_list;
	private String uid;

	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View view = inflater.inflate(R.layout.page1, null);
		initView(view,inflater);
		setData();
		return view;
	}
	
	/**
	 * 实例化控件
	 * @param view
	 * @param inflater
	 */
	private void initView(View view,LayoutInflater inflater) {
		ivRight=(ImageView)view.findViewById(R.id.ivRright);
		imgLocat=(ImageView)view.findViewById(R.id.imgLocat);
		ivWriteCode=(ImageView)view.findViewById(R.id.ivWriteCode);
		bthome=(ImageButton)view.findViewById(R.id.bthome);
		search=(LinearLayout)view.findViewById(R.id.layout_search);
		btsearch=(ImageButton)view.findViewById(R.id.btSearch);
		head_layout = (RelativeLayout)view.findViewById(R.id.head_layout);
		layout_bottom = (RelativeLayout)view.findViewById(R.id.layout_bottom);
		mImgLoader = ImageLoader.getInstance(context);
		setUpPopWindow(view,inflater);
		
		search.setOnClickListener(this);
		btsearch.setOnClickListener(this);
		ivWriteCode.setOnClickListener(this);
		imgLocat.setOnClickListener(this);
		bthome.setOnClickListener(this);
		layout_bottom.setOnClickListener(this);
		
		context=view.getContext();
		list=(com.transsion.infinix.xclub.view.XListView)view.findViewById(R.id.listView);
		list.setPullLoadEnable(true);
		
		//图片轮询
		View v=inflater.inflate(R.layout.banner, null);
		mViewPager=(ViewPager)v.findViewById(R.id.viewpager);
		llPoints=(LinearLayout)v.findViewById(R.id.ll_points);
		list.addHeaderView(v);
		if(thread==null){
		 thread=new Thread(new Runnable() {
			 
				@Override
				public void run() {
					while (isLoop) {
						SystemClock.sleep(6000);
						
							handler.sendEmptyMessage(0);
					}
				}
			});
		 thread.start();
		}
		prepareData(view);
		list.setXListViewListener(this);
		mHandler = new Handler();
		
	}
    private void setUpPopWindow(View view,LayoutInflater inflater) {
		View v=inflater.inflate(R.layout.pop_set_country, null);
		popupWindow = new PopupWindow(v,LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT);
		
		layoutArray[0]=(LinearLayout)v.findViewById(R.id.layout_cote);
		layoutArray[1]=(LinearLayout)v.findViewById(R.id.layout_egypt);
		layoutArray[2]=(LinearLayout)v.findViewById(R.id.layout_france);
		layoutArray[3]=(LinearLayout)v.findViewById(R.id.layout_ghana);
		layoutArray[4]=(LinearLayout)v.findViewById(R.id.layout_kenya);
		layoutArray[5]=(LinearLayout)v.findViewById(R.id.layout_Morocco);
		layoutArray[6]=(LinearLayout)v.findViewById(R.id.layout_nigeria);
		layoutArray[7]=(LinearLayout)v.findViewById(R.id.layout_pakistan);
		layoutArray[8]=(LinearLayout)v.findViewById(R.id.layout_KSA);
		layoutArray[9]=(LinearLayout)v.findViewById(R.id.layout_UAE);
		layoutArray[10]=(LinearLayout)v.findViewById(R.id.layout_indonesia);
		layoutArray[11]=(LinearLayout)v.findViewById(R.id.layout_thailand);
		layoutArray[12]=(LinearLayout)v.findViewById(R.id.layout_other_country);
		layoutArray[13]=(LinearLayout)v.findViewById(R.id.layout_all);
		layoutArray[14]=(LinearLayout)v.findViewById(R.id.layout_vietnam);
		layoutArray[15]=(LinearLayout)v.findViewById(R.id.layout_rom);
		
		imgArray[0]=(ImageView)v.findViewById(R.id.imgCote);
		imgArray[1]=(ImageView)v.findViewById(R.id.imgEgypt);
		imgArray[2]=(ImageView)v.findViewById(R.id.imgFrance);
		imgArray[3]=(ImageView)v.findViewById(R.id.imgGhana);
		imgArray[4]=(ImageView)v.findViewById(R.id.imgKenya);
		imgArray[5]=(ImageView)v.findViewById(R.id.imgMorocco);
		imgArray[6]=(ImageView)v.findViewById(R.id.imgNigeria);
		imgArray[7]=(ImageView)v.findViewById(R.id.imgPakistan);
		imgArray[8]=(ImageView)v.findViewById(R.id.imgKSA);
		imgArray[9]=(ImageView)v.findViewById(R.id.imgUAE);
		imgArray[10]=(ImageView)v.findViewById(R.id.imgIndoesia);
		imgArray[11]=(ImageView)v.findViewById(R.id.imgThailand);
		imgArray[12]=(ImageView)v.findViewById(R.id.imgOther);
		imgArray[13]=(ImageView)v.findViewById(R.id.imgAll);
		imgArray[14]=(ImageView)v.findViewById(R.id.imgVietnam);
		imgArray[15]=(ImageView)v.findViewById(R.id.imgRom);
		
		for (LinearLayout layout : layoutArray) {
	    	layout.setOnClickListener(this);
		}
		
		popupWindow.setContentView(v);
		popupWindow.setFocusable(true);
		v.setOnTouchListener(new OnTouchListener() {  
            @Override  
            public boolean onTouch(View v, MotionEvent event) {  
                // TODO Auto-generated method stub  
                if (popupWindow != null && popupWindow.isShowing()) {  
                	popupWindow.dismiss();    
                }  
                return false;  
            }  
        });
		
	}

	private void setData() {
    	 saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
		 auth=PreferenceUtils.getPrefString(context, "auth", "");
    	 mParams=new ArrayList<BasicNameValuePair>();
        
        if(FileUtils.read( cacheFilePath)!=null){
        	
        	logininfo=GetJsonData.get(FileUtils.read( cacheFilePath), LoginInfo.class);
        	page=Integer.parseInt(logininfo.getVariables().getPage());
			totalpage=Integer.parseInt(logininfo.getVariables().getTotalpage());
        	adapter=new PostAdapter(context, logininfo.getVariables().getForum_threadlist());
			list.setAdapter(adapter);
        }else{
        	ChangePostListView();
       
        }
	}

	private void ChangePostListView() {
		mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","threadlist"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth", auth));
	    dao = new BaseDao(MainFragment.this, mParams, context, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
            Constant.BASE_URL, "get", "false");
        PreferenceUtils.setPrefBoolean(context, "isCache", false);
	}

	@Override
	public void onStart() {
		// TODO Auto-generated method stub
		super.onStart();
	}
	@Override
	public void onDestroy() {
		// TODO Auto-generated method stub
		super.onDestroy();
	}
	@SuppressWarnings("deprecation")
	private void prepareData(View v) {
		imageViewList = new ArrayList<ImageView>();
		
		int[] imageResIDs = getImageResIDs();
		ImageView iv = null;
		View view;
		if(MasterApplication.getInstanse().logininfo!=null&&MasterApplication.getInstanse().logininfo.getVariables().getAd_list().size()>0){
			ad_list=MasterApplication.getInstanse().logininfo.getVariables().getAd_list();
			for(int i=0;i<MasterApplication.getInstanse().logininfo.getVariables().getAd_list().size();i++){
				iv = new ImageView(context);
				iv.setScaleType(ScaleType.FIT_XY);
				mImgLoader.DisplayImage(MasterApplication.getInstanse().logininfo.getVariables().getAd_list().get(i).getImages(),iv, 1, Constant.LESSNUM-i, 0, R.drawable.picture);
				imageViewList.add(iv);
				  
				// 添加点view对象
				view = new View(v.getContext());

				view.setBackgroundDrawable(getResources().getDrawable(
						R.drawable.point_background));
				LayoutParams lp = new LayoutParams(DisplayUtil.dip2px(v.getContext(), 7), DisplayUtil.dip2px(v.getContext(), 7));

				lp.leftMargin = DisplayUtil.dip2px(v.getContext(), 4);
				// .MATCH_PARENT = 10;
				view.setLayoutParams(lp);
				view.setEnabled(false);
				llPoints.addView(view);
			}
		}else{
		if(imageResIDs.length!=0){
			for (int i = 0; i < imageResIDs.length; i++) {
				iv = new ImageView(v.getContext());
				iv.setScaleType(ScaleType.FIT_XY);
			//	iv.setBackgroundResource(imageResIDs[i]);
				iv.setImageResource(imageResIDs[i]);
				imageViewList.add(iv);
  
				// 添加点view对象
				view = new View(v.getContext());

				view.setBackgroundDrawable(getResources().getDrawable(
						R.drawable.point_background));
				LayoutParams lp = new LayoutParams(DisplayUtil.dip2px(v.getContext(), 7), DisplayUtil.dip2px(v.getContext(), 7));

				lp.leftMargin = DisplayUtil.dip2px(v.getContext(), 4);
				// .MATCH_PARENT = 10;
				view.setLayoutParams(lp);
				view.setEnabled(false);
				llPoints.addView(view);
		 	}
		  }
		}
		ViewPagerAdapter adapter = new ViewPagerAdapter(imageViewList);
		mViewPager.setAdapter(adapter);
		mViewPager.setOnPageChangeListener(this);

		llPoints.getChildAt(previousSelectPosition).setEnabled(true);
		mViewPager.setCurrentItem(0);
	}
	private int[] getImageResIDs() {
		return new int[] { R.drawable.picture1,
				R.drawable.picture2,R.drawable.picture3};
	}

	
	class ViewPagerAdapter extends PagerAdapter {
		private List<ImageView> list;
		private boolean frist = true;
		ViewPagerAdapter(List<ImageView> list){
			this.list = list;
			for(int i=0;i<list.size();i++)
			{
			    final int position=i;
				list.get(i).setOnClickListener(new OnClickListener() {
					

					@Override
					public void onClick(View v) {
						if(ad_list==null){
							ToastManager.showShort(context, "Data requests failed, please try again later");
							return;
						}
						String url=ad_list.get(position).getLink();
						Log.i("info","url"+url);
						@SuppressWarnings("unchecked")
						Map<String,String> mapRequest=CRequest.URLRequest(url);
						Set<Map.Entry<String, String>> set = mapRequest.entrySet();  
						Iterator<Map.Entry<String, String>> iterator2 = set.iterator();
						while (iterator2.hasNext()) {  
						    Map.Entry<String, String> entry = iterator2.next(); 
						    if(entry.getKey().equals("tid")){
						     tid=entry.getValue();
						    }
						} 
						if(url.contains("tid")){
						  Intent intent=new Intent(context,RecommendActivity.class);
						  intent.putExtra("tid",tid);
						  context.startActivity(intent);
						}else{
						
					      Intent intent=new Intent(context,WebActivity.class);
						  intent.putExtra("URL",url);
					      context.startActivity(intent);
						}
						
					}
				});
			}
		}
		@Override
		public int getCount() {
			return Integer.MAX_VALUE;
		}

		/**
		 * 判断出去的view是否等于进来的view 如果为true直接复用
		 */
		@Override
		public boolean isViewFromObject(View arg0, Object arg1) {
			return arg0 == arg1;
		}

		/**
		 * 销毁预加载以外的view对象, 会把需要销毁的对象的索引位置传进来就是position
		 */
		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			
//			   container.removeView(imageViewList.get(position %
//			   imageViewList.size()));
			 
		}

		/**
		 * 创建一个view
		 */
		@Override
		public Object instantiateItem(ViewGroup container,  int position) {
			try {
				container.addView(
						imageViewList.get(position % imageViewList.size()), 0);
			} catch (Exception e) {
//				e.printStackTrace();
			}
			return imageViewList.get(position % imageViewList.size());

		}
	}
	public void onActivityCreated(Bundle savedInstanceState) {
		ivRight.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				((SlidingActivity) getActivity()).showRight();
			}
		});
		super.onActivityCreated(savedInstanceState);
		
	}
	@Override
	public void onPageScrollStateChanged(int position) {
		
	}
	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onPageSelected(int position) {
		// TODO Auto-generated method stub
		llPoints.getChildAt(previousSelectPosition).setEnabled(false); // 把前一个点置为normal状态
		llPoints.getChildAt(position % imageViewList.size()).setEnabled(true); // 把当前选中的position对应的点置为enabled状态
		previousSelectPosition = position % imageViewList.size();
		
	}

	@Override
	public void onRefresh() {
//		mParams.clear();
		ChangePostListView();
//		imgLocat.setBackgroundResource(R.drawable.locat_bg);
//		for (int i = 0; i < layoutArray.length; i++) {
//				imgArray[i].setBackgroundResource(R.drawable.oval_country);
//		}
	}

	@Override
	public void onLoadMore() {
		if(page<totalpage){
		 ++page;
		 Log.i("info", "page:"+page);
		mParams.add(new BasicNameValuePair("page", page+""));
		ChangePostListView();
        PreferenceUtils.setPrefBoolean(context, "isCache", true);
		}else{
			onLoad();
		}
	}
	private void onLoad() {
		list.stopRefresh();
		list.stopLoadMore();
		list.setRefreshTime(PreferenceUtils.getPrefString(context, "DateTime", ""));
		PreferenceUtils.setPrefString(context, "DateTime", DateTimeUtils.getCurrentTime(System.currentTimeMillis()));
	}
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == Constant.GO_TO_ISLOGIN ) {
			if(data!=null){
			Bundle extras = data.getExtras();
			Boolean isLogin=extras.getBoolean("isLogin");
			if(isLogin){
				Intent intent=new Intent();
				intent.setClass(context,WritePostActivity.class);
			    context.startActivity(intent);
			}
			}
		}
	}
	private void Logion() {
		Intent intent=new Intent(context,LoginActivity.class);
		intent.putExtra("Login_NOT", 1);
		startActivityForResult(intent, Constant.GO_TO_ISLOGIN);
		ToastManager.showShort(context, "Please login");
	}
	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.ivWriteCode:
	     uid=PreferenceUtils.getPrefInt(context,"uid", 0)+"";
	     if(uid.equals("0")){
				Logion();
				
			}else{
	       intent.setClass(context,WritePostActivity.class);
	       context.startActivity(intent);
			}
			break;
		case R.id.layout_search:
		case R.id.btSearch:
			intent.setClass(context, SearchActivity.class);
			context.startActivity(intent);
			break;
		case R.id.imgLocat:
			if(popupWindow!=null &&!popupWindow.isShowing()){
				popupWindow.showAsDropDown(head_layout, 0, 0);
			}else{
				ClosePopWindow();
			}
			break;
		case R.id.layout_bottom:
			break;
		case R.id.bthome:
			if(!NetUtil.isConnect(context)){
	 			ToastManager.showShort(context, "Unable to connect to the network, please check your network");
	 			return;
	 		}
			if(list.getFirstVisiblePosition()!=0){
				mParams.clear();
				ChangePostListView();
		        MasterApplication.getInstanse().showLoadDataDialogUtil(context,dao);
			}
			imgLocat.setBackgroundResource(R.drawable.locat_bg);
			for (int i = 0; i < layoutArray.length; i++) {
					imgArray[i].setBackgroundResource(R.drawable.oval_country);
			}
			break;
		case R.id.layout_cote:
			currentIndex=0;
			imgLocat.setBackgroundResource(R.drawable.cote_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "20"));
			break;
		case R.id.layout_egypt:
			currentIndex=1;
			imgLocat.setBackgroundResource(R.drawable.egypt_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "9"));
			break;
		case R.id.layout_france:
			currentIndex=2;
			imgLocat.setBackgroundResource(R.drawable.france_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "10"));
			break;
		case R.id.layout_ghana:
			currentIndex=3;
			imgLocat.setBackgroundResource(R.drawable.ghana_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "11"));
			break;
		case R.id.layout_kenya:
			currentIndex=4;
			imgLocat.setBackgroundResource(R.drawable.kenya_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "12"));
			break;
		case R.id.layout_Morocco:
			currentIndex=5;
			imgLocat.setBackgroundResource(R.drawable.morocco_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "13"));
			break;
		case R.id.layout_nigeria:
			currentIndex=6;
			imgLocat.setBackgroundResource(R.drawable.nigeria_con);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "14"));
			break;
		case R.id.layout_pakistan:
			currentIndex=7;
			imgLocat.setBackgroundResource(R.drawable.pakistan_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "15"));
			break;
		case R.id.layout_KSA:
			currentIndex=8;
			imgLocat.setBackgroundResource(R.drawable.ksa_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "16"));
			break;
		case R.id.layout_UAE:
			currentIndex=9;
			imgLocat.setBackgroundResource(R.drawable.uae_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "17"));
			break;
		case R.id.layout_indonesia:
			currentIndex=10;
			imgLocat.setBackgroundResource(R.drawable.indonesia_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "163"));
			break;
		case R.id.layout_thailand:
			currentIndex=11;
			imgLocat.setBackgroundResource(R.drawable.thailand_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "164"));
			break;
		case R.id.layout_other_country:
			currentIndex=12;
			imgLocat.setBackgroundResource(R.drawable.locat_bg);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "18"));
			break;
		case R.id.layout_all:
			currentIndex=13;
			imgLocat.setBackgroundResource(R.drawable.locat_bg);
			ClosePopWindow();
			mParams.clear();
			break;
		case R.id.layout_vietnam:
			currentIndex=14;
			imgLocat.setBackgroundResource(R.drawable.vietnam_icon);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "173"));
			break;
		case R.id.layout_rom:
			currentIndex=15;
			imgLocat.setBackgroundResource(R.drawable.locat_bg);
			ClosePopWindow();
			mParams.clear();
			mParams.add(new BasicNameValuePair("typeid", "175"));
			break;
		default:
			break;
		}
		if(currentIndex>=0){
			updateLayoutImageView();
			ChangePostListView();
			MasterApplication.getInstanse().showLoadDataDialogUtil(context,dao);
			}
	}
	private void ClosePopWindow() {
		if(popupWindow!=null&&popupWindow.isShowing()){
			popupWindow.dismiss();
		}
	}

	private void updateLayoutImageView() {
		for (int i = 0; i < layoutArray.length; i++) {
			if (i == currentIndex) {
				imgArray[i].setBackgroundResource(R.drawable.choise_country);
			} else {
				imgArray[i].setBackgroundResource(R.drawable.oval_country);

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
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getForum_threadlist()!=null){
			if(!PreferenceUtils.getPrefBoolean(context, "isCache", false)){
			if(currentIndex<0){
			try {
				FileUtils.copyString(result.toString(), cacheFilePath);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			}
			adapter=new PostAdapter(context,logininfo.getVariables().getForum_threadlist());
			list.setAdapter(adapter);
			page=Integer.parseInt(logininfo.getVariables().getPage());
			totalpage=Integer.parseInt(logininfo.getVariables().getTotalpage());
			currentIndex=-1;
			onLoad();
			}else{
				adapter.notifyChanged(logininfo.getVariables().getForum_threadlist());
				Currentpage=Integer.parseInt(logininfo.getVariables().getPage());
			    onLoad();
			}
			}
		}else{
			ToastManager.showShort(context, "Data requests failed, please try again later");
		    page=Currentpage;
		    onLoad();
		}
	}
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
		
	}

	@Override
	public void onSingleTouch(){
		
	}
    
}

