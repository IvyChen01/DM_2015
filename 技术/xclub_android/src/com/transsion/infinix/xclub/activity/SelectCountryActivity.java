package com.transsion.infinix.xclub.activity;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.LinearLayout;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.trassion.infinix.xclub.R;

public class SelectCountryActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	private ListView mChooseListView;
	private String[] country;
	private ListAdapter mListAdapter;
	private LinearLayout tvback;
	private ArrayList<BasicNameValuePair> mParams;
	private LoginInfo logininfo;
	private BaseDao dao;
	String cacheCountryPath=Constant.TEXT_PATH+"/country.ca";//»º´æ¹ú¼Ò
	private String level;
	
	private void initView() {
		// TODO Auto-generated method stub
		tvback=(LinearLayout)findViewById(R.id.tvback);
		mChooseListView = (ListView)findViewById(R.id.lv_choose);
		country = getResources().getStringArray(R.array.country);
		 level=PreferenceUtils.getPrefString(this, "Level", "");
		
		tvback.setOnClickListener(this);
		
		
		
        mChooseListView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Bundle bundle = new Bundle();
				Intent intent = new Intent(getApplicationContext(),
						SelectCountryActivity.class);
				bundle.putString("name", logininfo.getVariables().getTypeid_arr().get(position).getName());
				bundle.putString("typeid", logininfo.getVariables().getTypeid_arr().get(position).getTypeid());
				intent.putExtras(bundle);
				setResult(RESULT_OK, intent);
				finish();
				
			}
		});
  }
	private void setData() {
		if(FileUtils.read( cacheCountryPath)!=null){
			 logininfo=GetJsonData.get(FileUtils.read( cacheCountryPath), LoginInfo.class);
			 if(level.contains("LV")){
		    	   logininfo.getVariables().getTypeid_arr().remove(0);
		       }
			   ArrayList<HashMap<String, String>> mProvinceArrayList = new ArrayList<HashMap<String, String>>();  
		        for (int i = 0; i < country.length; i++) {  
		            HashMap<String, String> map = new HashMap<String, String>();  
		            map.put("country", logininfo.getVariables().getTypeid_arr().get(i).getName());  
		            mProvinceArrayList.add(map);  
			}
		       
		        mListAdapter = new SimpleAdapter(this, mProvinceArrayList, R.layout.country_list_item , new String[] {"country"}, new int[] {  
		                R.id.country_item_textview});
		        mChooseListView.setAdapter(mListAdapter);
		}else{
		       mParams=new ArrayList<BasicNameValuePair>();
		       mParams.add(new BasicNameValuePair("version","5"));
               mParams.add(new BasicNameValuePair("module","typeid"));
               mParams.add(new BasicNameValuePair("mobile","no"));
        
               dao = new BaseDao(SelectCountryActivity.this, mParams, this, null);
               dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                     Constant.BASE_URL, "get", "false");
		}
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
		if(result!=null){
			try {
				FileUtils.copyString(result.toString(), cacheCountryPath);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			   logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			   ArrayList<HashMap<String, String>> mProvinceArrayList = new ArrayList<HashMap<String, String>>();  
		       if(level.contains("LV")){
		    	   logininfo.getVariables().getTypeid_arr().remove(0);
		       }
			   for (int i = 0; i < country.length; i++) {  
		            HashMap<String, String> map = new HashMap<String, String>();  
		            map.put("country", logininfo.getVariables().getTypeid_arr().get(i).getName());  
		            mProvinceArrayList.add(map);  
			}
		       
		        mListAdapter = new SimpleAdapter(this, mProvinceArrayList, R.layout.country_list_item , new String[] {"country"}, new int[] {  
		                R.id.country_item_textview});
		        mChooseListView.setAdapter(mListAdapter);
		        
		}
		
	}
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_select_country);
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
