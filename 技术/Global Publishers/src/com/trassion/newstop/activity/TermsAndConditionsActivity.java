package com.trassion.newstop.activity;

import java.util.ArrayList;

import android.graphics.Typeface;
import android.widget.ListView;
import android.widget.TextView;

import com.trassion.newstop.adapter.TermsAdapter;
import com.trassion.newstop.bean.News;

public class TermsAndConditionsActivity extends BaseActivity{
    
	private ArrayList<News> moreNews=new ArrayList<News>();
	private ListView listView;
	private TextView title;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_terms_and_conditions);
		
	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		listView=(ListView)findViewById(R.id.listView);
		
		
		title.setText("Terms And Conditions");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		
	}

	@Override
	public void initData() {
		News news=new News();
			news.setTime("2015.12.30 14:28");
			moreNews.add(news);
			
			TermsAdapter adapter=new TermsAdapter(this, moreNews);
			listView.setAdapter(adapter);
		
	}
	@Override
	public void onBackPressed() {
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

}
