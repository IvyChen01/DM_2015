package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.AdapterView.OnItemClickListener;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.CollectionPostAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.bean.PostListInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

public class MyPostActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
     
	private LinearLayout tvback;
	private TextView tvTitle;
	private ListView list;
	private ArrayList<BasicNameValuePair> mParams;
	private String uid;
	private String saltkey;
	private String auth;
	private BaseDao dao;
	private LoginInfo logininfo;
	private ArrayList<PostListInfo> forum_threadlist;
	private CollectionPostAdapter adapter;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		tvTitle=(TextView)findViewById(R.id.tvTitle);
		tvTitle.setText("My Post");
		
        list=(ListView)findViewById(R.id.listView);
		
		mParams=new ArrayList<BasicNameValuePair>();
        
		list.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent=new Intent(MyPostActivity.this,RecommendActivity.class);
				intent.putExtra("tid",forum_threadlist.get(position).getTid());
				intent.putExtra("favrite", forum_threadlist.get(position).getHas_favorite());
				animStartActivity(intent);
				
			}
		});
		
		tvback.setOnClickListener(this);
		
	}

	private void setData() {
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
	    
		mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","mythread"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("uid",uid));
	    mParams.add(new BasicNameValuePair("saltkey",saltkey));
	    mParams.add(new BasicNameValuePair("auth",auth));
        
	    if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(this, dao);
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
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getVariables().getForum_threadlist()!=null){
		     if(logininfo.getVariables().getForum_threadlist().size()>0){
			 forum_threadlist=logininfo.getVariables().getForum_threadlist();
			 adapter=new CollectionPostAdapter(this, logininfo.getVariables().getForum_threadlist());
			 list.setAdapter(adapter);
		     }else{
		    	 ToastManager.showShort(this, "You have not made any posts");
		     }
			}
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
		}
		
	}

	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_my_collection);
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
