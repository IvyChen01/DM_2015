package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.MessageAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.bean.Message;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.ScrollListView;
import com.trassion.infinix.xclub.R;

public class MessageActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{

	private LinearLayout tvback;
	private ScrollListView listView;
	private MessageAdapter adapter;
	private ArrayList<BasicNameValuePair> mParams;
	private String uid;
	private String saltkey;
	private String auth;
	private BaseDao dao;
	private LinearLayout note_message;
	
	private ImageView imgPoint;
	private ArrayList<Message>list;
	private MasterApplication masterApplication;

	private void initView() {
		PreferenceUtils.setPrefBoolean(this, "isDelete", false);
		tvback=(LinearLayout)findViewById(R.id.tvback);
		note_message=(LinearLayout)findViewById(R.id.note_message);
		imgPoint=(ImageView)findViewById(R.id.imgPoint);
		listView=(ScrollListView)findViewById(R.id.listView);
		masterApplication=MasterApplication.getInstanse();

		tvback.setOnClickListener(this);
		note_message.setOnClickListener(this);
		
		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				    if(list.size()>0){
					Intent intent=new Intent(MessageActivity.this,FeedBackActivity.class);
					if(!list.get(position).getTouid().equals(uid)){
						intent.putExtra("touid",list.get(position).getTouid());	
					}else{
					intent.putExtra("touid",list.get(position).getMsgfromid());
					}
					animStartActivity(intent);
				    }
				
			}
		});
		
	}
	 private void setData() {
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
		
		mParams=new ArrayList<BasicNameValuePair>();
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","mypm"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth",auth));
        
        
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
	}
	 private void noteMessage() {
		 ArrayList<BasicNameValuePair> params=new ArrayList<BasicNameValuePair>();
		         params.add(new BasicNameValuePair("version","5"));
		         params.add(new BasicNameValuePair("module","mynotelist"));
		         params.add(new BasicNameValuePair("mobile","no"));
	        
		         params.add(new BasicNameValuePair("saltkey",saltkey));
		         params.add(new BasicNameValuePair("auth",auth));
		        
	        
	        
	        dao = new BaseDao(this, params, this, null);
	        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                Constant.BASE_URL, "get", "false");
	        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		}

	 public void deleteMessage(String touid){
		 ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
		    mParams.add(new BasicNameValuePair("version","5"));
	        mParams.add(new BasicNameValuePair("module","delmypm"));
	        mParams.add(new BasicNameValuePair("mobile","no"));
	        mParams.add(new BasicNameValuePair("uid",touid));
	        
	        mParams.add(new BasicNameValuePair("saltkey",saltkey));
	        mParams.add(new BasicNameValuePair("auth",auth));
	        
	        dao = new BaseDao(this, mParams, this, null);
	        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                Constant.BASE_URL, "get", "false");
	        PreferenceUtils.setPrefBoolean(this, "isDelete", true);
	        MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
	 }
	
	@Override
	public void onClick(View v) {
		Intent intent=new Intent();
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.note_message:
			intent.setClass(this, NoteMessageActivity.class);
			animStartActivity(intent);
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
			masterApplication.logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(masterApplication.logininfo.getMessage().getMessageval()!=null){
				MasterApplication.getInstanse().closeLoadDataDialogUtil();
				 if(masterApplication.logininfo.getMessage().getMessageval().equals("delete_pm_success")){
					 setData();
				 }else{
					 ToastManager.showShort(this, masterApplication.logininfo.getMessage().getMessagestr());
				 }
			}else if(masterApplication.logininfo.getVariables().getList().size()>0){
				list=masterApplication.logininfo.getVariables().getList();
				if(!PreferenceUtils.getPrefBoolean(this, "isDelete", false)){
					adapter=new MessageAdapter(this,masterApplication.logininfo.getVariables().getList());
					listView.setAdapter(adapter);
				}else{
					adapter.changeMessage(masterApplication.logininfo.getVariables().getList());
					 PreferenceUtils.setPrefBoolean(this, "isDelete", false);
				}					
			}else if(masterApplication.logininfo.getVariables().getList().size()==0){
				if(PreferenceUtils.getPrefBoolean(this, "isDelete", false)){
					adapter.changeMessage(masterApplication.logininfo.getVariables().getList());
					 PreferenceUtils.setPrefBoolean(this, "isDelete", false);
				}
			}
			if(masterApplication.logininfo.getVariables().getNotelist().size()>0){
				for(int i=0;i<masterApplication.logininfo.getVariables().getNotelist().size();i++){
					MasterApplication.getInstanse().closeLoadDataDialogUtil();
					if(!masterApplication.logininfo.getVariables().getNotelist().get(i).getIsnew().equals("0")){
						imgPoint.setVisibility(View.VISIBLE);
						break;
					}else{
						imgPoint.setVisibility(View.GONE);
					}
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
		setContentView(R.layout.activity_message);
		initView();
		setData();
		noteMessage();
		
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
