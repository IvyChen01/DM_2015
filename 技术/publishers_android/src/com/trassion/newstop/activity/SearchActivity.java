package com.trassion.newstop.activity;

import com.trassion.newstop.adapter.NewsAdapter;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.bean.response.NewsTopModelBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class SearchActivity extends BaseActivity implements OnClickListener,UICallBackInterface{

	private TextView tvfinish;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private EditText etSearch;
	private NewsTopModelBeanresponse response;
	private ListView listView;
	private NewsAdapter mAdapter;
	private NewsInfo news;
	private ImageView ivClear;
	private InputMethodManager imm;
	
	public  final static String SER_KEY = "com.trassion.newstop.fragment";

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_search);
		
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
		
	}

	@Override
	public void initWidget() {
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		etSearch=(EditText)findViewById(R.id.etSearch);
		listView=(ListView)findViewById(R.id.listView);
		ivClear=(ImageView)findViewById(R.id.ivClear);
		
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		
//		listView.setOnItemClickListener(new OnItemClickListener() {
//
//
//			@Override
//			public void onItemClick(AdapterView<?> parent, View view,
//					int position, long id) {
//				news=response.getData().get(position);
//		        Intent intent = new  Intent(SearchActivity.this, NewsContentActivity.class);
//		        Bundle mBundle = new Bundle();    
//		        mBundle.putSerializable(SER_KEY,news);    
//		        intent.putExtras(mBundle);    
//		        startActivity(intent);
//		        overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
//				
//			}
//		});
		
		tvfinish.setOnClickListener(this);
		ivClear.setOnClickListener(this);
		
	}

	@Override
	public void initData() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			response=(NewsTopModelBeanresponse)bean;
			if(mAdapter == null){
				mAdapter = new NewsAdapter(this, response.getData());
			}
			listView.setAdapter(mAdapter);
		}
		
	}

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		if(errorFlag==NewsApplication.MSG_CANCEL_REQUEST){
			this.finish();
		}else{
			ToastManager.showLong(this, R.string.common_cannot_connect);
		}
		
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvfinish:
			requestSearch();
			break;
		case R.id.ivClear:
			etSearch.setText("");
			break;

		default:
			break;
		}
		
	}

	private void requestSearch() {
		String keywords=etSearch.getText().toString();
		imm.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
		
		if(TextUtils.isEmpty(keywords)){
			ToastManager.showShort(this, "Please input the content of the search");
			return;
		}
		
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListBySearchRequest(mHttpAgent, Utils.getPhoneIMEI(this),keywords, "1", "10000",Constants.HTTP_GET_SEARCH );
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

}
