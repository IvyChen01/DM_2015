package com.trassion.newstop.activity;

import java.util.ArrayList;

import com.trassion.newstop.adapter.MyFeedAdapter;
import com.trassion.newstop.bean.Myfeed;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Typeface;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class FriendsMessageActivity extends BaseActivity implements OnClickListener{

	private TextView title;
	private ImageView imgAdd;
	private ListView listView;
	
	private ArrayList<Myfeed> mFeeds=new ArrayList<Myfeed>();
	private RelativeLayout postMessage;
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_friends_message);
	}

	@Override
	public void initWidget(){
		
		title=(TextView)findViewById(R.id.title);
		imgAdd=(ImageView)findViewById(R.id.imgAdd);
		listView=(ListView)findViewById(R.id.listView);
		postMessage=(RelativeLayout)findViewById(R.id.postMessage);
		
		title.setText("Friends Message");
		imgAdd.setVisibility(View.VISIBLE);
		imgAdd.setBackgroundResource(R.drawable.fm_nav_icon_addfriend);
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		
		imgAdd.setOnClickListener(this);
		postMessage.setOnClickListener(this);
	}

	@Override
	public void initData() {
		Myfeed feed=new Myfeed();
		for(int i=0;i<10;i++){
			feed.setName("Wisdomodoki");
			feed.setOperatHasShow(false);
			mFeeds.add(feed);
			
		}
//		MyFeedAdapter adapter=new MyFeedAdapter(this,mFeeds,true);
//		listView.setAdapter(adapter);

	}
	@Override
	public void onBackPressed() {
			Intent intent = new Intent(getApplicationContext(), MainActivity.class);
			setResult(MainActivity.CHANNELRESULT, intent);
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.imgAdd:
			StartActivity(AddFriendsActivity.class);
			break;
		case R.id.postMessage:
			StartActivity(PostMessageActivity.class);
			break;

		default:
			break;
		}
	}

}
