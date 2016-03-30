package com.trassion.newstop.activity;

import java.util.ArrayList;


import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.LinearLayout.LayoutParams;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.trassion.newstop.activity.view.MineMainLayout;
import com.trassion.newstop.activity.view.VideoMainLayout;
import com.trassion.newstop.adapter.NewsFragmentpagerAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.ChannelItem;
import com.trassion.newstop.bean.ChannelManage;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.ColumnHorizontalScrollView;


/**
 * ����ʱ�䣺2015-12-29 ����14:07:42  
 * ��Ŀ��ƣ�NewsTop  
 * @author chen  
 * @version 1.0   
 * @since   
 */
public class MainActivity extends BaseActivity implements OnClickListener{
	/** �Զ���HorizontalScrollView */
	private ColumnHorizontalScrollView mColumnHorizontalScrollView;
	LinearLayout mRadioGroup_content;
	LinearLayout ll_more_columns;
	RelativeLayout rl_column;
	private ViewPager mViewPager;
	private ImageView button_more_columns;
	/**�û�ѡ������ŷ����б�*/
	private ArrayList<ChannelItem>userChannelList=new ArrayList<ChannelItem>();
	/** ��ǰѡ�е���Ŀ  */
	private int columnSelectIndex=0;
	/** ����Ӱ���� */
	public ImageView shade_left;
	/**����Ӱ���� */
    public ImageView shade_right;
    /** ��Ļ��� */
    private int mScreenWidth=0;
    /** Item��� */
    private int mItemWidth=0;
    private ArrayList<Fragment>fragments=new ArrayList<Fragment>();
    /** ����CODE */
    public final static int CHANNELREQUEST=1;
    public final static int ACCOUNTREQUEST=2;
    /** ����ص�RESULTCODE*/
    public final static int CHANNELRESULT=10;
    /**����һ���˳�ʱ�� */
    private long mExitTime;
    
	private int currentIndex;
    /** �ײ�3��button */
    private LinearLayout[] layoutArray=new  LinearLayout[3];
    private ImageView[] imgArray=new  ImageView[3];
    private TextView[] tvArray=new  TextView[3];
    
    VideoMainLayout mVideoMainLayout;
    MineMainLayout mineMainLayout;
    
    LinearLayout llManagerMainLayout;
    
    IAppLayout nowLayout;
	private LinearLayout home_layout;
	
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	
	private NewsTopModelBeanresponse response;
	private boolean before;
    
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_main);
		mScreenWidth=Utils.getWindowsWidth(this);
		mItemWidth=mScreenWidth/7;
		
//		before=PreferenceUtils.getPrefBoolean(this, "isLogin", false);
	}

	@Override
	public void initWidget() {
		// TODO Auto-generated method stub
		llManagerMainLayout = (LinearLayout) findViewById(R.id.manager_main_layout);
		home_layout=(LinearLayout)findViewById(R.id.home_layout);
		
        mColumnHorizontalScrollView=(ColumnHorizontalScrollView)findViewById(R.id.mColumnHorizontalScrollView);
        mRadioGroup_content=(LinearLayout)findViewById(R.id.mRadioGroup_content);
        ll_more_columns=(LinearLayout)findViewById(R.id.ll_more_columns);
        rl_column=(RelativeLayout)findViewById(R.id.rl_column);
        button_more_columns=(ImageView)findViewById(R.id.button_more_columns);
        mViewPager=(ViewPager)findViewById(R.id.mViewPager);
        shade_left=(ImageView)findViewById(R.id.shade_left);
        shade_right=(ImageView)findViewById(R.id.shade_right);
        layoutArray[0]=(LinearLayout)findViewById(R.id.news_home);
        layoutArray[1]=(LinearLayout)findViewById(R.id.news_video);
        layoutArray[2]=(LinearLayout)findViewById(R.id.news_mine);
        imgArray[0]=(ImageView)findViewById(R.id.imgHome);
        imgArray[1]=(ImageView)findViewById(R.id.imgVideo);
        imgArray[2]=(ImageView)findViewById(R.id.imgMine);
        tvArray[0]=(TextView)findViewById(R.id.tvHome);
        tvArray[1]=(TextView)findViewById(R.id.tvVideo);
        tvArray[2]=(TextView)findViewById(R.id.tvMine);
        
        for (LinearLayout layout : layoutArray) {
	    	layout.setOnClickListener(this);
		}
        button_more_columns.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent intent_channel = new  Intent(MainActivity.this, ChannelActivity.class);
				startActivityForResult(intent_channel, CHANNELREQUEST);
				overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
			}
		});
	}

	/**
	 * ����Ŀ���仯ʱ����
	 */
	public void initData() {
		
		setChangelView();
	}
    private void setChangelView() {
		// TODO Auto-generated method stub
    	if((ArrayList<ChannelItem>)ChannelManage.getManage(NewsApplication.getApp().getSQLHelper()).getUserChannel()!=null)
    		userChannelList=((ArrayList<ChannelItem>)ChannelManage.getManage(NewsApplication.getApp().getSQLHelper()).getUserChannel());
		initTabColumn();
		initFragment();
	}
	private void initTabColumn() {
		// TODO Auto-generated method stub
		mRadioGroup_content.removeAllViews();
		int count =  userChannelList.size();
		mColumnHorizontalScrollView.setParam(this, mScreenWidth, mRadioGroup_content, shade_left, shade_right, ll_more_columns, rl_column);
		for(int i = 0; i< count; i++){
			LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(LayoutParams.WRAP_CONTENT , LayoutParams.WRAP_CONTENT);
			params.leftMargin = 5;
			params.rightMargin = 5;
//			TextView localTextView = (TextView) mInflater.inflate(R.layout.column_radio_item, null);
			TextView columnTextView = new TextView(this);
			columnTextView.setTextAppearance(this, R.style.top_category_scroll_view_item_text);
//			localTextView.setBackground(getResources().getDrawable(R.drawable.top_category_scroll_text_view_bg));
//			columnTextView.setBackgroundResource(R.drawable.radio_buttong_bg);
			columnTextView.setGravity(Gravity.CENTER);
			columnTextView.setPadding(5, 5, 5, 5);
			columnTextView.setId(i);
			columnTextView.setText(userChannelList.get(i).getName());
			columnTextView.setTextColor(getResources().getColorStateList(R.color.top_category_scroll_text_color_day));
			if(columnSelectIndex == i){
				columnTextView.setSelected(true);
			}
			columnTextView.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
			          for(int i = 0;i < mRadioGroup_content.getChildCount();i++){
				          View localView = mRadioGroup_content.getChildAt(i);
				          if (localView != v)
				        	  localView.setSelected(false);
				          else{
				        	  localView.setSelected(true);
				        	  mViewPager.setCurrentItem(i);
				          }
			          }
				}

			});
			mRadioGroup_content.addView(columnTextView, i ,params);
		}
	}
    /**
     * ViewPager�л�����
     */
	private void initFragment() {
		fragments.clear();//���
		int count =  userChannelList.size();
		for(int i = 0; i< count;i++){
			Bundle data = new Bundle();
    		data.putString("text", userChannelList.get(i).getName());
    		data.putInt("id", userChannelList.get(i).getId());
//    		data.putSerializable("response", response.getData());
			NewsFragment newfragment = new NewsFragment();
			newfragment.setArguments(data);
			fragments.add(newfragment);
		}
		NewsFragmentpagerAdapter mAdapetr = new NewsFragmentpagerAdapter(getSupportFragmentManager(), fragments);
//		mViewPager.setOffscreenPageLimit(0);
		mViewPager.setAdapter(mAdapetr);
		mViewPager.setOnPageChangeListener(pageListener);
	}
	/** 
	 *  ViewPager�л�����
	 * */
	public OnPageChangeListener pageListener= new OnPageChangeListener(){

		@Override
		public void onPageScrollStateChanged(int arg0) {
		}

		@Override
		public void onPageScrolled(int arg0, float arg1, int arg2) {
		}

		@Override
		public void onPageSelected(int position){
			// TODO Auto-generated method stub
			mViewPager.setCurrentItem(position);
			selectTab(position);
		}
	};
	/**
	 * ѡ���Column�����Tab
	 */
	private void selectTab(int tab_postion){
		columnSelectIndex = tab_postion;
		for (int i = 0; i < mRadioGroup_content.getChildCount(); i++) {
			View checkView = mRadioGroup_content.getChildAt(tab_postion);
			int k = checkView.getMeasuredWidth();
			int l = checkView.getLeft();
			int i2 = l + k / 2 - mScreenWidth / 2;
			// rg_nav_content.getParent()).smoothScrollTo(i2, 0);
			mColumnHorizontalScrollView.smoothScrollTo(i2, 0);
			// mColumnHorizontalScrollView.smoothScrollTo((position - 2) *
			// mItemWidth , 0);
		}
		//�ж��Ƿ�ѡ��
		for (int j = 0; j <  mRadioGroup_content.getChildCount(); j++) {
			View checkView = mRadioGroup_content.getChildAt(j);
			boolean ischeck;
			if (j == tab_postion) {
				ischeck = true;
			} else {
				ischeck = false;
			}
			checkView.setSelected(ischeck);
		}
	}
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		// TODO Auto-generated method stub
		if(keyCode==KeyEvent.KEYCODE_BACK){
			if((System.currentTimeMillis()-mExitTime)>2000){
				Toast.makeText(this, "Just press one more time to exit", Toast.LENGTH_SHORT).show();
				mExitTime=System.currentTimeMillis();
			}else{
				finish();
			}
		}
		return true;
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		switch (requestCode) {
		case CHANNELREQUEST:
			if(resultCode==CHANNELRESULT){
				setChangelView();
			}
			break;
		case ACCOUNTREQUEST:
			if(requestCode==ACCOUNTREQUEST){
				before=PreferenceUtils.getPrefBoolean(this, "isLogin", false);
				setMineView(before);
			}
            break;
		default:
			break;
		}
		super.onActivityResult(requestCode, resultCode, data);
	}
	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
	   case R.id.news_home:
		   currentIndex=0;
		   llManagerMainLayout.setVisibility(View.GONE);
		   home_layout.setVisibility(View.VISIBLE);
		   break;
	   case R.id.news_video:
		   currentIndex=1;
//		   llManagerMainLayout.setVisibility(View.VISIBLE);
//		   home_layout.setVisibility(View.GONE);
//		   if (null != mVideoMainLayout) {
//				nowLayout = mVideoMainLayout;
//				// ɾ�����е��Ӳ���
//				llManagerMainLayout.removeAllViews();
//				// ����µĲ���
//				llManagerMainLayout.addView((View) nowLayout);
//				nowLayout.initData();
//			} else {
//				// ��ͨ����¼Ĭ��װ�����ǵ���������
//				nowLayout = new VideoMainLayout(this);
//				// ɾ�����е��Ӳ���
//				llManagerMainLayout.removeAllViews();
//				// ����µĲ���
//				llManagerMainLayout.addView((View) nowLayout);
//
//			}
		   break;
	   case R.id.news_mine:
		   currentIndex=2;
		   before=PreferenceUtils.getPrefBoolean(this, "isLogin", false);
		   setMineView(before);
		   break;
		default:
			break;
		}
		updateLayoutTextColor();
	}

	private void setMineView(Boolean isLogin) {
		// TODO Auto-generated method stub
		llManagerMainLayout.setVisibility(View.VISIBLE);
		   home_layout.setVisibility(View.GONE);
		   if (null != mineMainLayout) {
				nowLayout = mineMainLayout;
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);
				nowLayout.initData();
			} else {
				// ��ͨ����¼Ĭ��װ�����ǵ���������
				nowLayout = new MineMainLayout(this,isLogin);
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);

			}
	}

	private void updateLayoutTextColor() {
		for (int i = 0; i < layoutArray.length; i++) {
			if (i == currentIndex) {
				tvArray[i].setTextColor(0xffcc0000);
			} else {
				tvArray[i].setTextColor(0xff4f4f4f);
			}
			if(currentIndex==0){
				imgArray[0].setBackgroundResource(R.drawable.tab_icon_home_press);
				imgArray[1].setBackgroundResource(R.drawable.tab_icon_video_normal);
				imgArray[2].setBackgroundResource(R.drawable.tab_icon_mine_normal);
			}
			if(currentIndex==1){
				imgArray[0].setBackgroundResource(R.drawable.tab_icon_home_normal);
				imgArray[1].setBackgroundResource(R.drawable.tab_icon_video_press);
				imgArray[2].setBackgroundResource(R.drawable.tab_icon_mine_normal);
			}
			if(currentIndex==2){
				imgArray[0].setBackgroundResource(R.drawable.tab_icon_home_normal);
				imgArray[1].setBackgroundResource(R.drawable.tab_icon_video_normal);
				imgArray[2].setBackgroundResource(R.drawable.tab_icon_mine_press);
			}
		}
		
	}
	

}
