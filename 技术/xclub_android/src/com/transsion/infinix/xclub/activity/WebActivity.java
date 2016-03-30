package com.transsion.infinix.xclub.activity;

import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.LinearLayout;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.trassion.infinix.xclub.R;

public class WebActivity extends BaseActivity {
	
	private WebView webView;
	private LinearLayout tvback;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_web);
        
		webView=(WebView)findViewById(R.id.webView);
		tvback=(LinearLayout)findViewById(R.id.tvback);
		tvback.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				animFinish();
				
			}
		});
		initWebView(webView);
	}

	@Override
	public void initWidget() {
		String url=getIntent().getStringExtra("URL");
		Log.i("info","url+++:"+url);
		
		try {
			webView.loadUrl(url);
			webView.setWebViewClient(new WebViewClient() {
				@Override
				 public boolean shouldOverrideUrlLoading(WebView view, String url)  
	            {   
	                //  重写此方法表明点击网页里面的链接还是在当前的webview里跳转，不跳到浏览器那边  
	                view.loadUrl(url);  
	                        return true;  
	            }
			});
		} catch (Exception e) {
			// TODO: handle exception
		}

	}
	private void initWebView(WebView webView) {   
		WebSettings settings = webView.getSettings();
		// 基本的设置
		settings.setJavaScriptEnabled(true);
		settings.setBuiltInZoomControls(true);// support zoom
		settings.setUseWideViewPort(true);
		settings.setLoadWithOverviewMode(true);

		settings.setCacheMode(WebSettings.LOAD_DEFAULT);
		settings.setDomStorageEnabled(true);
		/*
		 * if (Build.VERSION.SDK_INT >= 8) {// 这里是支持flash的相关设置
		 * settings.setPluginState(WebSettings.PluginState.ON); } else {
		 * settings.setPluginsEnabled(true); }
		 */
		webView.setScrollBarStyle(View.SCROLLBARS_OUTSIDE_OVERLAY);
		// 去掉滚动条
		webView.setVerticalScrollBarEnabled(false);
		webView.setHorizontalScrollBarEnabled(false);

		// 去掉缩放按钮
		if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.HONEYCOMB) {
			// Use the API 11+ calls to disable the controls
			settings.setBuiltInZoomControls(true);
			settings.setDisplayZoomControls(false);
		} else {
			// do noting
		}

//		// JAVA
//		webView.addJavascriptInterface(new WebCallAndroid(this)
//
//		, "hsWebIn");
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub

	}

}
