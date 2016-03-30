package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnKeyListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.SearchHotAdapter;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.bean.SearchHotInfo;
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

public class SearchActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	private  LinearLayout tvback;
	private Button btSearch;
	private EditText editContent;
	private String saltkey;
	private String auth;
	private BaseDao dao;
	private MasterApplication masterApplication;
	private ArrayList<SearchHotInfo>hotsearch;
	private GridView gvHot;
	private SearchHotAdapter adapter;
	private String message;
	private String url;
	private int type;
	
	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		btSearch=(Button)findViewById(R.id.btSearch);
		editContent=(EditText)findViewById(R.id.search_word);
		gvHot=(GridView)findViewById(R.id.gvHot);
		
		saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
		auth=PreferenceUtils.getPrefString(this, "auth", "");
		
		masterApplication=MasterApplication.getInstanse();
		
		gvHot.setOnItemClickListener(new OnItemClickListener() {


			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				     type=2;
				 dao = new BaseDao(SearchActivity.this, null, SearchActivity.this, null);
			        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
			        		hotsearch.get(position).getUrl(), "get", "false");
			        url=hotsearch.get(position).getUrl();
			        MasterApplication.getInstanse().showLoadDataDialogUtil(SearchActivity.this,dao);
			}
		});
		editContent.setOnKeyListener(new OnKeyListener() {
			
			@Override
			public boolean onKey(View v, int keyCode, KeyEvent event) {
				if(keyCode==KeyEvent.KEYCODE_ENTER){//修改回车键功能 
					// 先隐藏键盘 
					((InputMethodManager) getSystemService(INPUT_METHOD_SERVICE)) 
					.hideSoftInputFromWindow( 
					SearchActivity.this 
					.getCurrentFocus() 
					.getWindowToken(), 
					InputMethodManager.HIDE_NOT_ALWAYS);
					search();
				}
				return false;
			}
		});
	}
	private void setLisentener() {
		tvback.setOnClickListener(this);
		btSearch.setOnClickListener(this);
	}
	private void setData() {
		if(!NetUtil.isConnect(this)){
 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
 			return;
 		}
		ArrayList<BasicNameValuePair> params=new ArrayList<BasicNameValuePair>();
        params.add(new BasicNameValuePair("version","5"));
        params.add(new BasicNameValuePair("module","hotsearch"));
        params.add(new BasicNameValuePair("mobile","no"));
  
//        params.add(new BasicNameValuePair("saltkey",saltkey));
//        params.add(new BasicNameValuePair("auth",auth));

        dao = new BaseDao(this, params, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
            Constant.BASE_URL, "get", "false");
        MasterApplication.getInstanse().showLoadDataDialogUtil(SearchActivity.this,dao);
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.btSearch:
			search();
			break;
		default:
			break;
		}
		
	}
	private void search() {
		     type=1;
		 message=editContent.getText().toString();
		if(TextUtils.isEmpty(message)){
			ToastManager.showShort(this, "Search content can not be empty");
			return;
		}
		 if(!NetUtil.isConnect(this)){
	 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
	 		}
		    ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
	           mParams.add(new BasicNameValuePair("version","5"));
               mParams.add(new BasicNameValuePair("module","searchthread"));
               mParams.add(new BasicNameValuePair("mobile","no"));
               mParams.add(new BasicNameValuePair("srchtxt",message));
         
               mParams.add(new BasicNameValuePair("saltkey",saltkey));
	           mParams.add(new BasicNameValuePair("auth",auth));
  
               dao = new BaseDao(this, mParams, this, null);
               dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                   Constant.BASE_URL, "get", "false");
               MasterApplication.getInstanse().showLoadDataDialogUtil(SearchActivity.this,dao);
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
			if(masterApplication.logininfo.getVariables().getForum_threadlist().size()>0){
				Intent intent=new Intent(this,SearchResultActivity.class);
				if(message!=null){
				intent.putExtra("Message", message);
				}
				intent.putExtra("Type", type);
				intent.putExtra("URL", url);
				animStartActivity(intent);
				animFinish();
			}else if(masterApplication.logininfo.getVariables().getHotsearch().size()>0){
				hotsearch=masterApplication.logininfo.getVariables().getHotsearch();
				adapter=new SearchHotAdapter(this, masterApplication.logininfo.getVariables().getHotsearch());
				gvHot.setAdapter(adapter);
				
			}else{
				ToastManager.showShort(this, "No relevant subject");
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
		setContentView(R.layout.activity_search);
		initView();
		setLisentener();
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
