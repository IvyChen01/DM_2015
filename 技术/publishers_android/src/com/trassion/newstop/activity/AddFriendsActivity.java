package com.trassion.newstop.activity;

import java.util.ArrayList;

import android.content.Intent;
import android.graphics.Typeface;
import android.widget.TextView;

import com.trassion.newstop.adapter.AddFriendsAdapter;
import com.trassion.newstop.bean.FriendInformation;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.MyFoodListView;
import com.trassion.newstop.view.XwScrollView;

public class AddFriendsActivity extends BaseActivity {

	private MyFoodListView listView;
	private XwScrollView mXSVContainer;
	
	private ArrayList<FriendInformation> friendInformation=new ArrayList<FriendInformation>();
	private TextView title;
	private TextView twoTitle;

	@Override
	public void setContentView() {
		setContentView(R.layout.activity_add_friends);

	}

	@Override
	public void initWidget() {
		mXSVContainer=(XwScrollView)findViewById(R.id.mXSVContainer);
		listView=(MyFoodListView)findViewById(R.id.listView);
		title=(TextView)findViewById(R.id.title);
		twoTitle=(TextView)findViewById(R.id.twoTitle);
		
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		twoTitle.setTypeface(type);
		
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		title.setText("Add Friends");
		
        mXSVContainer.post(new Runnable() {
			
			@Override
			public void run() {
				mXSVContainer.scrollTo(0, 0);
			}
		});

	}

	@Override
	public void initData() {
		
		FriendInformation friend1=new FriendInformation();
			friend1.setName("Her World Singapore");
			friend1.setPresent("Merry Christmas");
			friendInformation.add(friend1);
			
			FriendInformation friend2=new FriendInformation();
			friend2.setName("Aaron");
			friend2.setPresent("Adobe,the Adobe logo,and Photoshop are either...");
			friendInformation.add(friend2);
			
			FriendInformation friend3=new FriendInformation();
			friend3.setName("Jerry");
			friend3.setPresent("PANTONE@ colors displayed here may not match...");
			friendInformation.add(friend3);
			
			FriendInformation friend4=new FriendInformation();
			friend4.setName("Apple");
			friend4.setPresent("TOYO COLOR¡¡FINDER@ SYSTEM¡¡AND SOFTWARE @...");
			friendInformation.add(friend4);
			
			FriendInformation friend5=new FriendInformation();
			friend5.setName("BBS NEWS");
			friend5.setPresent("Potions copyright Eastman Kodak Company.");
			friendInformation.add(friend5);
			
			FriendInformation friend6=new FriendInformation();
			friend6.setName("Penta");
			friend6.setPresent("Certain trademarks are owned by The Proximity Division...");
			friendInformation.add(friend6);
			
		AddFriendsAdapter adapter=new AddFriendsAdapter(this,friendInformation);
		listView.setAdapter(adapter);
		Utils.setListViewHeightBasedOnChildren(listView);

	}
	
	@Override
	public void onBackPressed() {
			finish();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}


}
