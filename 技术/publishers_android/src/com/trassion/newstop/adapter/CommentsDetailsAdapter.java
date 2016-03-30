package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.trassion.newstop.activity.CommentsDetailsActivity;
import com.trassion.newstop.activity.LikedFriendsActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.NewsAdapter.ViewHolder;
import com.trassion.newstop.bean.Comment;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.Problem;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CommentsDetailsAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<Comment> moreComment;
	private Comment comment;
	private Context context;

	public CommentsDetailsAdapter(Context context,ArrayList<Comment> moreComment){
		
		this.context=context;
		inflater=LayoutInflater.from(context);
		if(moreComment!=null){
			this.moreComment=moreComment;
		}else{
			moreComment=new ArrayList<Comment>();
		}
	}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return moreComment.size();
	}

	@Override
	public Comment getItem(int position) {
		// TODO Auto-generated method stub
		return moreComment.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View view=convertView;
		ViewHolder mHolder;
		if(view==null){
			view=inflater.inflate(R.layout.news_content_comment_item, null);
			mHolder=new ViewHolder();
			mHolder.tvName=(TextView)view.findViewById(R.id.tvName);
			mHolder.tvUserName=(TextView)view.findViewById(R.id.tvUserName);
			mHolder.layout_present=(LinearLayout)view.findViewById(R.id.layout_present);
			mHolder.layout_comment=(LinearLayout)view.findViewById(R.id.layout_comment);
			mHolder.layout_friends=(LinearLayout)view.findViewById(R.id.layout_friends);
			mHolder.title=(TextView)view.findViewById(R.id.tvTitle);
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		comment=moreComment.get(position);
//		mHolder.tvName.setText(comment.getName());
		
		if(position==0){
//			mHolder.tvUserName.setText(comment.getName());
			mHolder.layout_present.setVisibility(View.VISIBLE);
			mHolder.layout_comment.setVisibility(View.GONE);
		}else if(position==1){
			mHolder.layout_present.setVisibility(View.GONE);
			mHolder.layout_comment.setVisibility(View.VISIBLE);
			mHolder.title.setVisibility(View.VISIBLE);
			Typeface face = Typeface.createFromAsset(context.getAssets(),"fonts/Roboto-Medium.ttf");
			mHolder.title.setTypeface(face);
		}else{
			mHolder.layout_present.setVisibility(View.GONE);
			mHolder.layout_comment.setVisibility(View.VISIBLE);
			mHolder.title.setVisibility(View.GONE);
		}
		mHolder.layout_friends.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Intent intent = new  Intent(context, LikedFriendsActivity.class);
				context.startActivity(intent);
				((Activity)context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
				
			}
		});
		
		return view;
	}
	static class ViewHolder{
    	private TextView tvName;
    	private LinearLayout layout_present;
    	private LinearLayout layout_comment;
    	private LinearLayout layout_friends;
    	private TextView title;
    	private TextView tvUserName;
    }
}

