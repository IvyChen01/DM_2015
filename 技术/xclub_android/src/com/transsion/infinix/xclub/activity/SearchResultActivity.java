package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.PostAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.PostListView;
import com.transsion.infinix.xclub.view.PostListView.IXListViewListener;
import com.trassion.infinix.xclub.R;

public class SearchResultActivity extends BaseActivity implements IXListViewListener,OnClickListener,RequestListener<BaseEntity>{

	 private LinearLayout tvback;
	private MasterApplication masterApplication;
	private PostListView list;
	private PostAdapter adapter;
	private int page;
	private int totalPage;
	private BaseDao dao;
	private String saltkey;
	private String auth;
	private String message;
	private LoginInfo logininfo;
	private int currentpage;
	private int type;
	private String url;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		list=(PostListView)findViewById(R.id.listView);
		list.setPullLoadEnable(true);
		masterApplication=MasterApplication.getInstanse();
		
		saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
		auth=PreferenceUtils.getPrefString(this, "auth", "");
		type=getIntent().getIntExtra("Type", 0);
		message=getIntent().getStringExtra("Message");
		url=getIntent().getStringExtra("URL");
		
		tvback.setOnClickListener(this);
		list.setXListViewListener(this);
	}
	private void setData() {
		adapter=new PostAdapter(this, masterApplication.logininfo.getVariables().getForum_threadlist());
		adapter.setResult(message);
		list.setAdapter(adapter);
		page=Integer.parseInt(masterApplication.logininfo.getVariables().getPage());
		totalPage=Integer.parseInt(masterApplication.logininfo.getVariables().getTotalpage());
	}


	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
         
		default:
			break;
		}
		
	}

	@Override
	public void onRefresh() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onLoadMore() {
		if(page<totalPage){
			++page;
			if(type==1){
			search();
			}else{
				dao = new BaseDao(this, null,this, null);
		        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
		        		url+"&page"+page, "get", "false");
			}
		}else{
			onLoad();
		}
	}
	private void onLoad() {
		list.stopLoadMore();
	}
	private void search() {
		 if(!NetUtil.isConnect(this)){
	 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
	 		}
		    ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
	           mParams.add(new BasicNameValuePair("version","5"));
               mParams.add(new BasicNameValuePair("module","searchthread"));
               mParams.add(new BasicNameValuePair("mobile","no"));
               mParams.add(new BasicNameValuePair("srchtxt",message));
               mParams.add(new BasicNameValuePair("page",page+""));
        
               mParams.add(new BasicNameValuePair("saltkey",saltkey));
	           mParams.add(new BasicNameValuePair("auth",auth));
 
              dao = new BaseDao(this, mParams, this, null);
              dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                  Constant.BASE_URL, "get", "false");
	}

	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		if(result!=null){
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getForum_threadlist().size()>0){
				adapter.notifyChanged(logininfo.getVariables().getForum_threadlist());
				currentpage=Integer.parseInt(logininfo.getVariables().getPage());
				onLoad();
			}
		}else{
			page=currentpage;
			ToastManager.showShort(this, "Data requests failed, please try again later");
			onLoad();
		}
		
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void setContentView() {
        setContentView(R.layout.activity_search_reasult);
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
