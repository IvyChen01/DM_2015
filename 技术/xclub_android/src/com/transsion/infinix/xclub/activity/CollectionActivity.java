package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.app.Dialog;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;

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
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

public class CollectionActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
         
	private LinearLayout tvback;
	private ArrayList<BasicNameValuePair> mParams;
	private String uid;
	private String saltkey;
	private String auth;
	private BaseDao dao;
	private LoginInfo logininfo;
	private ListView list;
	private LayoutInflater inflater;
	private CollectionPostAdapter adapter;
	private ArrayList<PostListInfo> forum_threadlist;
	
	private Button cancel;
	private Button confirm;
	private Dialog dialog;
	private String favid;
	private int currentPosition;
    
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.cancle:
			dialog.dismiss();
			break;
		case R.id.confirm:
			if(!NetUtil.isConnect(this)){
				ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
	 		}
			delete();
			break;

		default:
			break;
		}
		
	}

	private void delete() {
		ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
		mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","delfavthread"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("favid",favid));
        mParams.add(new BasicNameValuePair("uid",uid));
	    mParams.add(new BasicNameValuePair("saltkey",saltkey));
	    mParams.add(new BasicNameValuePair("auth",auth));
	    Log.i("info", "favid:"+favid);
	    dao = new BaseDao(CollectionActivity.this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        dialog.dismiss();
        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
        PreferenceUtils.setPrefBoolean(this, "isCollect", true);
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
		    	 ToastManager.showShort(this, "You haven't collected any posts");
		     }
			}
			if(logininfo.getMessage().getMessageval()!=null){
				if(logininfo.getMessage().getMessageval().equals("do_success")){
					forum_threadlist.remove(currentPosition);
					 adapter.notifyChanged(forum_threadlist);
				}else{
					ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
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
		
	}

	@Override
	public void initWidget() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		list=(ListView)findViewById(R.id.listView);
		PreferenceUtils.setPrefBoolean(this, "isCollect", false);
		
		mParams=new ArrayList<BasicNameValuePair>();
		inflater = LayoutInflater.from(this);
		
		dialog=new Dialog(CollectionActivity.this,R.style.dialog);
		View v=inflater.inflate(R.layout.dialog_collection,null);
		cancel=(Button)v.findViewById(R.id.cancle);
		confirm=(Button)v.findViewById(R.id.confirm);
		dialog.setContentView(v);
		
		tvback.setOnClickListener(this);
		cancel.setOnClickListener(this);
		confirm.setOnClickListener(this);
	    
		list.setOnItemLongClickListener(new OnItemLongClickListener() {



			@Override
			public boolean onItemLongClick(AdapterView<?> parent, View view,
					int position, long id) {
				favid=forum_threadlist.get(position).getFavid();
				currentPosition=position;
				dialog.show();
				return true;
			}
		});
		list.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent=new Intent(CollectionActivity.this,RecommendActivity.class);
				intent.putExtra("tid",forum_threadlist.get(position).getTid());
				intent.putExtra("favrite", forum_threadlist.get(position).getHas_favorite());
				animStartActivity(intent);
				
			}
		});
		
	}

	@Override
	public void getData() {
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
	    
		mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","myfavthread"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("uid",uid));
	    mParams.add(new BasicNameValuePair("saltkey",saltkey));
	    mParams.add(new BasicNameValuePair("auth",auth));
	    
	    if(!NetUtil.isConnect(this)){
	    	ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
        dao = new BaseDao(CollectionActivity.this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		
	}
}
