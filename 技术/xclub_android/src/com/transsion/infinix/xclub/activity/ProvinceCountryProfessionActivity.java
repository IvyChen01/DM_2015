package com.transsion.infinix.xclub.activity;


import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

import org.apache.http.message.BasicNameValuePair;

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

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

/**
 * 省份城市职业选择页面
 * @author L&Q
 *
 */
public class ProvinceCountryProfessionActivity extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	private ListView mChooseListView;
	private ListAdapter mListAdapter;
	private LinearLayout tvback;
	private String[] country;
	private String[] profession;
	private String type;
	private TextView tvTitle;
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private String saltkey;
	private String auth;
	private LoginInfo logininfo;
	String cacheCountryPath=Constant.TEXT_PATH+"/select_country.ca";
		
		private void initView() {
			// TODO Auto-generated method stub
			tvback=(LinearLayout)findViewById(R.id.tvback);
			mChooseListView = (ListView)findViewById(R.id.lv_choose);
			tvTitle=(TextView)findViewById(R.id.tvTitle);
			tvback.setOnClickListener(this);
			 Bundle extras = getIntent().getExtras();
			 type=extras.getString("type");
			
	  }
		private void setData() {
			    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
			    auth=PreferenceUtils.getPrefString(this, "auth", "");
			    
			if(type.equals("1")){
				if(FileUtils.read( cacheCountryPath)!=null){
				 logininfo=GetJsonData.get(FileUtils.read( cacheCountryPath), LoginInfo.class);
				   ArrayList<HashMap<String, String>> mProvinceArrayList = new ArrayList<HashMap<String, String>>();  
			        for (int i = 0; i < logininfo.getVariables().getNationlist().size(); i++) {  
			            HashMap<String, String> map = new HashMap<String, String>();  
			            map.put("country", logininfo.getVariables().getNationlist().get(i).getName());  
			            mProvinceArrayList.add(map);  
				}
			       
			        mListAdapter = new SimpleAdapter(this, mProvinceArrayList, R.layout.country_list_item , new String[] {"country"}, new int[] {  
			                R.id.country_item_textview});
			        mChooseListView.setAdapter(mListAdapter);
			}else{
	            
	               mParams=new ArrayList<BasicNameValuePair>();
			       mParams.add(new BasicNameValuePair("version","5"));
	               mParams.add(new BasicNameValuePair("module","nationlist"));
	               mParams.add(new BasicNameValuePair("mobile","no"));
	               
	               mParams.add(new BasicNameValuePair("saltkey",saltkey));
	   	           mParams.add(new BasicNameValuePair("auth",auth));
	        
	               dao = new BaseDao(this, mParams, this, null);
	               dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
	                     Constant.BASE_URL, "get", "false");
	        }
//			
//	        mListAdapter = new SimpleAdapter(this, mProvinceArrayList, R.layout.country_list_item , new String[] {"profession"}, new int[] {  
//                    R.id.country_item_textview});
//	        mChooseListView.setAdapter(mListAdapter);
			}else if(type.equals("2")){
				tvTitle.setText("profession");
				profession = getResources().getStringArray(R.array.profession);
				ArrayList<HashMap<String, String>> mProvinceArrayList = new ArrayList<HashMap<String, String>>();  
		        for (int i = 0; i < profession.length; i++) {  
		            HashMap<String, String> map = new HashMap<String, String>();  
		            map.put("profession", profession[i]);  
		            mProvinceArrayList.add(map);  
		        }
				
		        mListAdapter = new SimpleAdapter(this, mProvinceArrayList, R.layout.country_list_item , new String[] {"profession"}, new int[] {  
	                    R.id.country_item_textview});
		        mChooseListView.setAdapter(mListAdapter);	
			}
		}
		private void setListener() {
			mChooseListView.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> parent, View view,
						int position, long id) {
				if(type.equals("1")){
					Intent intent=new Intent(Constant.ACTION_CHOOSECOUNTRY_SUCCESS);
				     intent.putExtra(Constant.KEY_IS_SUCCESS, true);
				     Bundle bundle = new Bundle();
				     bundle.putString("Values", logininfo.getVariables().getNationlist().get(position).getName());
				     bundle.putString("Code", logininfo.getVariables().getNationlist().get(position).getCode());
				     Log.i("info","区号:"+logininfo.getVariables().getNationlist().get(position).getCode());
					 intent.putExtras(bundle);
					 ProvinceCountryProfessionActivity.this.sendBroadcast(intent);
					animFinish();
				}else if(type.equals("2")){
					Intent intent=new Intent(Constant.ACTION_CHOOSEWORK_SUCCESS);
				     intent.putExtra(Constant.KEY_IS_SUCCESS, true);
				     Bundle bundle = new Bundle();
				     bundle.putString("Values", profession[position]);
					 intent.putExtras(bundle);
					 ProvinceCountryProfessionActivity.this.sendBroadcast(intent);
					 animFinish();
				}
					
				}
			});
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
			        for (int i = 0; i < logininfo.getVariables().getNationlist().size(); i++) {  
			            HashMap<String, String> map = new HashMap<String, String>();  
			            map.put("country", logininfo.getVariables().getNationlist().get(i).getName());  
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
			setListener();
			
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
