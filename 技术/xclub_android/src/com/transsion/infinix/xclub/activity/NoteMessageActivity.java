package com.transsion.infinix.xclub.activity;
import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.app.Dialog;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;


import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.NoteMessageAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.bean.NoteMessage;
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
import com.transsion.infinix.xclub.util.Utils;
import com.trassion.infinix.xclub.R;


public class NoteMessageActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{

	private LinearLayout tvback;
	private LinearLayout linearLayout_message;
	private ListView list;
	private NoteMessageAdapter adapter;
	private MasterApplication masterApplication;
	private Dialog dialog;
	private Button cancel;
	private Button confirm;
	private String tid;
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private String saltkey;
	private String auth;
	private LoginInfo logininfo;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		list=(ListView)findViewById(R.id.listView);
		masterApplication=MasterApplication.getInstanse();
		tvback.setOnClickListener(this);
		
		dialog=new Dialog(this,R.style.dialog);
		View v=LayoutInflater.from(this).inflate(R.layout.dialog_collection,null);
		TextView tvContent=(TextView)v.findViewById(R.id.tvContent);
		tvContent.setText("Delete the cache right now?");
		cancel=(Button)v.findViewById(R.id.cancle);
		confirm=(Button)v.findViewById(R.id.confirm);
		dialog.setContentView(v);
		
		saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
	    auth=PreferenceUtils.getPrefString(this, "auth", "");
		
		cancel.setOnClickListener(this);
		confirm.setOnClickListener(this);
		
		list.setOnItemLongClickListener(new OnItemLongClickListener() {

			@Override
			public boolean onItemLongClick(AdapterView<?> parent, View view,
					int position, long id) {
				tid=masterApplication.logininfo.getVariables().getNotelist().get(position).getId();
				dialog.show();
				return false;
			}
		});
		
	}
	private void setData() {
	if(masterApplication.logininfo.getVariables().getNotelist()!=null){
		if(masterApplication.logininfo.getVariables().getNotelist().size()>0){
			adapter=new NoteMessageAdapter(this,masterApplication.logininfo.getVariables().getNotelist()){
				@Override
				public void deleteMessage(String id) {
					tid=id;
					dialog.show();
					super.deleteMessage(id);
				}
			};
			list.setAdapter(adapter);
		}
	}
		
}

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
			 dialog.dismiss();
			 delete();
			break;
		default:
			break;
		}
		
	}
	private void delete() {
		mParams=new ArrayList<BasicNameValuePair>();
        mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","delmynotelist"));
        mParams.add(new BasicNameValuePair("mobile","no"));
        mParams.add(new BasicNameValuePair("id",tid));
        
        mParams.add(new BasicNameValuePair("saltkey",saltkey));
        mParams.add(new BasicNameValuePair("auth",auth));
        
        dao = new BaseDao(NoteMessageActivity.this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(NoteMessageActivity.this,dao);
		
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
			
		}
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_note_feedback);
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
	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onComplete(BaseEntity result) {
		if(result!=null){
			logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			if(logininfo.getMessage()!=null &&logininfo.getMessage().getMessageval()!=null){
				if(logininfo.getMessage().getMessageval().equals("delete succsess")){
					 noteMessage();
				}else{
				    ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
				    MasterApplication.getInstanse().closeLoadDataDialogUtil();
				}
			}
			if(logininfo.getVariables().getNotelist().size()>0){
				adapter.notifyChanged(logininfo.getVariables().getNotelist());
				MasterApplication.getInstanse().closeLoadDataDialogUtil();
			}
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
			MasterApplication.getInstanse().closeLoadDataDialogUtil();
		}
		
	}
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
}
