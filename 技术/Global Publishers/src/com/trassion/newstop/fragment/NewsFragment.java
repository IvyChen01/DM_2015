package com.trassion.newstop.fragment;


import java.util.ArrayList;


import com.alibaba.fastjson.JSON;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.activity.SearchActivity;
import com.trassion.newstop.adapter.NewsAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.News;
import com.trassion.newstop.bean.NewsEntity;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.PullToRefresh.PullToRefreshLayout;
import com.trassion.newstop.view.PullToRefresh.PullToRefreshLayout.OnRefreshListener;
import com.trassion.newstop.view.PullToRefresh.PullableListView;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

public class NewsFragment extends Fragment implements OnRefreshListener,UICallBackInterface{
	private final static String TAG = "NewsFragment";
	Activity activity;
	ArrayList<NewsEntity> newsList = new ArrayList<NewsEntity>();
	private ArrayList<News> moreNews=new ArrayList<News>();
	PullableListView mListView;
	NewsAdapter mAdapter;
	String text;
	int channel_id;
	ImageView detail_loading;
	public final static int SET_NEWSLIST = 0;
	//Toast��ʾ��
	private RelativeLayout notify_view;
	private TextView notify_view_text;
	private PullToRefreshLayout refreshLayout;
	
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	
	private NewsTopModelBeanresponse response;
	
	private PullToRefreshLayout pullToRefreshLayout;
	
	private NewsInfo news;
	
	private View v;
	private int page=1;
	
	public  final static String SER_KEY = "com.trassion.newstop.fragment"; 
	
	private Handler mHandler = new Handler(){
		public void handleMessage(Message msg) {
			refreshLayout.loadmoreFinish(PullToRefreshLayout.SUCCEED);
		};
	};
	@SuppressWarnings("unchecked")
	@Override
	public void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		Bundle args = getArguments();
		text = args != null ? args.getString("text") : "";
		channel_id = args != null ? args.getInt("id", 0) : 0;
		initData();
		super.onCreate(savedInstanceState);
//		requestNewsTopList(text);
	}

	@Override
	public void onAttach(Activity activity) {
		// TODO Auto-generated method stub
		this.activity = activity;
		super.onAttach(activity);
	}
	/** �˷�����˼Ϊfragment�Ƿ�ɼ� ,�ɼ�ʱ��������� */
	@Override
	public void setUserVisibleHint(boolean isVisibleToUser) {
		if (isVisibleToUser) {
			//fragment�ɼ�ʱ��������
			if(newsList !=null && newsList.size() !=0){
				handler.obtainMessage(SET_NEWSLIST).sendToTarget();
			}else{
				new Thread(new Runnable() {
					@Override
					public void run() {
						// TODO Auto-generated method stub
						try {
							Thread.sleep(2);
						} catch (InterruptedException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
						handler.obtainMessage(SET_NEWSLIST).sendToTarget();
					}
				}).start();
			}
		}else{
			//fragment���ɼ�ʱ��ִ�в���
		}
		super.setUserVisibleHint(isVisibleToUser);
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		View view = LayoutInflater.from(getActivity()).inflate(R.layout.news_fragment, null);
		mListView = (PullableListView) view.findViewById(R.id.mListView);
		TextView item_textview = (TextView)view.findViewById(R.id.item_textview);
		
		refreshLayout = (PullToRefreshLayout)view.findViewById(R.id.refresh);
		refreshLayout.setOnRefreshListener(this);
		
		refreshLayout.canPull=true;
		
		detail_loading = (ImageView)view.findViewById(R.id.detail_loading);
		//Toast��ʾ��
		notify_view = (RelativeLayout)view.findViewById(R.id.notify_view);
		notify_view_text = (TextView)view.findViewById(R.id.notify_view_text);
		item_textview.setText(text);
		
		request = new NewsTopInfoListRequest(activity);
		mHttpAgent = new HttpTransAgent(activity, NewsFragment.this);
		
		if(channel_id==0){
			v=LayoutInflater.from(getActivity()).inflate(R.layout.search_view,null);
			mListView.addHeaderView(v);
			
			LinearLayout search=(LinearLayout)v.findViewById(R.id.btnSearch);
			search.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					Intent intent = new  Intent(activity, SearchActivity.class);
			        startActivity(intent);
			        activity.overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
					
				}
			});
		}
		
		return view;
	}

	private void initData() {
	}
	
	Handler handler = new Handler() {
		@Override
		public void handleMessage(Message msg) {
			// TODO Auto-generated method stub
			switch (msg.what) {
			case SET_NEWSLIST:
				detail_loading.setVisibility(View.GONE);
				requestNewsTopList(text);
				break;
			default:
				break;
			}
			super.handleMessage(msg);
		}
	};
	
	
	
	/* ��ʼ��֪ͨ��Ŀ*/
	private void initNotify() {
		new Handler().postDelayed(new Runnable() {
			
			@Override
			public void run() {
				// TODO Auto-generated method stub
				notify_view_text.setText(String.format(getString(R.string.ss_pattern_update), 10));
				notify_view.setVisibility(View.VISIBLE);
				new Handler().postDelayed(new Runnable() {
					
					@Override
					public void run() {
						// TODO Auto-generated method stub
						notify_view.setVisibility(View.GONE);
					}
				}, 2000);
			}
		}, 1000);
	}
	/* �ݻ���ͼ */
	@Override
	public void onDestroyView() {
		// TODO Auto-generated method stub
		super.onDestroyView();
		mAdapter = null;
	}
	/* �ݻٸ�Fragment��һ����FragmentActivity ���ݻٵ�ʱ������Ŵݻ� */
	@Override
	public void onDestroy() {
		// TODO Auto-generated method stub
		super.onDestroy();
	}

	@Override
	public void onRefresh(final PullToRefreshLayout pullToRefreshLayout) {
		
		 this.pullToRefreshLayout=pullToRefreshLayout;
		if (NetworkUtil.isOnline(activity)) {
			mHttpAgent.isShowProgress = false;
			request.getNewsTopListByModelRequest(mHttpAgent, Utils.getPhoneIMEI(activity), "1", "20", text,Constants.HTTP_GET_NEW_MODEL_ID );
		} else {
			Toast.makeText(activity, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
	}

	@Override
	public void onLoadMore(final PullToRefreshLayout pullToRefreshLayout) {
		 this.pullToRefreshLayout=pullToRefreshLayout;
		 
		if(page<(Integer.parseInt(response.getTotal()))/20+1){
			String currentPage=(++page)+"";
		if (NetworkUtil.isOnline(activity)) {
			mHttpAgent.isShowProgress = false;
			request.getNewsTopListByModelRequest(mHttpAgent, Utils.getPhoneIMEI(activity), currentPage, "20", text,Constants.HTTP_GET_MORE_MODEL_ID );
		} else {
			Toast.makeText(activity, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		}else{
			pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
		}
	}
	private void requestNewsTopList(String channel) {
		if (NetworkUtil.isOnline(activity)) {
			mHttpAgent.isShowProgress = false;
			NewsApplication.modelName=channel;
			request.getNewsTopListByModelRequest(mHttpAgent, Utils.getPhoneIMEI(activity), "1", "20", channel,Constants.HTTP_GET_MODEL_ID );
		} else {
			Toast.makeText(activity, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			String jsonStr = FileCache.getCachePostList(text);
			
			if (!jsonStr.equals("")) {
				JavaBean bean = JSON.parseObject(jsonStr,NewsTopModelBeanresponse.class);
				
				response=(NewsTopModelBeanresponse)bean;
				
				 if(mAdapter == null){
					 mAdapter = new NewsAdapter(activity, response.getData());
				 }
				     mListView.setAdapter(mAdapter);
			
			} 
		}
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopModelBeanresponse)bean;
			if(msgId==Constants.HTTP_GET_MODEL_ID){
			  if(mAdapter == null){
				 mAdapter = new NewsAdapter(activity, response.getData());
			 }
			     mListView.setAdapter(mAdapter);
			     String modelName = text;
					if(Utils.isNotEmpty(modelName)){
						
					}
			}else if(msgId==Constants.HTTP_GET_NEW_MODEL_ID){
				  if(mAdapter == null){
						 mAdapter = new NewsAdapter(activity, response.getData());
					 }
					     mListView.setAdapter(mAdapter);
					     pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
			}else if(msgId==Constants.HTTP_GET_MORE_MODEL_ID){
				mAdapter.notifyChanged(response.getData());
				refreshLayout.loadmoreFinish(PullToRefreshLayout.SUCCEED);
				
				pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
			}
		}
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
				if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
					activity.finish();
				}else{
					ToastManager.showLong(activity, R.string.common_cannot_connect);
				}
		
	}
}
