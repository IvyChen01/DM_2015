package com.trassion.newstop.activity;

import java.util.ArrayList;

import com.trassion.newstop.adapter.CommentsDetailsAdapter;
import com.trassion.newstop.adapter.NewsContentAdapter;
import com.trassion.newstop.bean.Comment;

import android.graphics.Typeface;
import android.view.View;
import android.widget.ListView;
import android.widget.TextView;

public class CommentsDetailsActivity extends BaseActivity {

	private TextView title;
	private ListView listView;
	private CommentsDetailsAdapter adapter;

	private ArrayList<Comment> moreComment=new ArrayList<Comment>();
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_comments_details);

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		listView=(ListView)findViewById(R.id.listView);
		
		
		title.setText("Comments Details");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
	}

	@Override
	public void initData() {
//		Comment comment=new Comment();
//		for(int i=0;i<10;i++){
//			comment.setName("Wisdomodoki");
//			moreComment.add(comment);
//		}
//		 adapter=new CommentsDetailsAdapter(this, moreComment);
//		listView.setAdapter(adapter);

	}

}
