package com.trassion.newstop.activity;

import java.util.ArrayList;

import android.graphics.Typeface;
import android.widget.ListView;
import android.widget.TextView;

import com.trassion.newstop.adapter.AddFriendsAdapter;
import com.trassion.newstop.adapter.LikedFriendsAdapter;
import com.trassion.newstop.bean.FriendInformation;

public class LikedFriendsActivity extends BaseActivity {
	
	private ArrayList<FriendInformation> friendInformation=new ArrayList<FriendInformation>();
	private ListView listView;
	private TextView title;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_who_has_liked);

	}

	@Override
	public void initWidget() {
		listView=(ListView)findViewById(R.id.listView);
		title=(TextView)findViewById(R.id.title);
		
		
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		title.setText("Who Has Liked");

	}

	@Override
	public void initData() {
		FriendInformation friend1=new FriendInformation();
		friend1.setName("Her World Singapore");
		friendInformation.add(friend1);
		
		
		FriendInformation friend3=new FriendInformation();
		friend3.setName("Jerry");
		friendInformation.add(friend3);
		
		FriendInformation friend4=new FriendInformation();
		friend4.setName("Apple");
		friendInformation.add(friend4);
		
		FriendInformation friend6=new FriendInformation();
		friend6.setName("Penta");
		friend6.setPresent("Certain trademarks are owned by The Proximity Division...");
		friendInformation.add(friend6);
		
		LikedFriendsAdapter adapter=new LikedFriendsAdapter(this,friendInformation);
		listView.setAdapter(adapter);

	}

}
