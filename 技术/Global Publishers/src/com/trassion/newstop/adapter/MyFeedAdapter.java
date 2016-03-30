package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.CommentsDetailsActivity;
import com.trassion.newstop.activity.NewsContentActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.bean.MyCommentInfo;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.view.SelectDialog;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.TranslateAnimation;
import android.view.animation.Animation.AnimationListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class MyFeedAdapter extends BaseAdapter implements OnClickListener{

	private LayoutInflater inflater;
	private ArrayList<NewsInfo>data;
	private NewsInfo comment;
	private Context context;
	private boolean isFourse;
	private Dialog settingTypeDialog;
	private ImageLoader imageloader;
	private ImageManager imageManager;
	public  final static String SER_KEY = "com.trassion.newstop.fragment"; 

	public MyFeedAdapter(Context context,ArrayList<NewsInfo>data,boolean isFourse){
		
		this.context=context;
		inflater=LayoutInflater.from(context);
		imageloader=ImageLoader.getInstance();
		imageManager=new ImageManager();
		
		this.isFourse=isFourse;
		if(data!=null){
			this.data=data;
		}else{
			data=new ArrayList<NewsInfo>();
		}
	}
	public void notifyChanged(ArrayList<NewsInfo> data){
    	for(int i=0;i<data.size();i++){
    		comment=data.get(i);
    		this.data.add(comment);
    	}
    	notifyDataSetChanged();
    }
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return data.size();
	}

	@Override
	public NewsInfo getItem(int position) {
		// TODO Auto-generated method stub
		return data.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View view=convertView;
		final ViewHolder mHolder;
		if(view==null){
			view=inflater.inflate(R.layout.my_feed_item, null);
			mHolder=new ViewHolder();
			mHolder.tvName=(TextView)view.findViewById(R.id.tvName);
			mHolder.tvTime=(TextView)view.findViewById(R.id.tvTime);
			mHolder.tvComment=(TextView)view.findViewById(R.id.tvComment);
			mHolder.tvContent=(TextView)view.findViewById(R.id.tvContent);
			mHolder.tvMessage=(TextView)view.findViewById(R.id.tvMessage);
			mHolder.imageView=(ImageView)view.findViewById(R.id.imageView);
			mHolder.imgHead=(ImageView)view.findViewById(R.id.imgHead);
			mHolder.imgAddFriend=(ImageButton)view.findViewById(R.id.imgFriends);
			mHolder.llShare=(LinearLayout)view.findViewById(R.id.llShare);
			mHolder.layout_news=(LinearLayout)view.findViewById(R.id.layout_news);
//			mHolder.message=(LinearLayout)view.findViewById(R.id.message);
			mHolder.openLL=(LinearLayout)view.findViewById(R.id.openLL);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		comment=data.get(position);
		mHolder.tvName.setText(comment.getNick());
		mHolder.tvTime.setText(comment.getComment_date());
		mHolder.tvComment.setText(comment.getComment());
		mHolder.tvContent.setText(comment.getTitle());
		mHolder.tvMessage.setText(comment.getLike_count());
		
		if(comment.getImages().size()>0){
			imageloader.displayImage(comment.getImages().get(0).getMedium_img(), mHolder.imageView,imageManager.mDisplayImageOption,imageManager.animateFirstListener);
		}
		imageloader.displayImage(comment.getPhoto(), mHolder.imgHead,imageManager.option,imageManager.animateFirstListener);
		if(isFourse){
			mHolder.imgAddFriend.setVisibility(View.VISIBLE);
		}else{
			mHolder.imgAddFriend.setVisibility(View.GONE);
		}
		mHolder.layout_news.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				
				Intent intent = new  Intent(context, NewsContentActivity.class);
				Bundle mBundle = new Bundle();    
		        mBundle.putSerializable(SER_KEY,comment);    
		        intent.putExtras(mBundle);    
		        context.startActivity(intent);
				((Activity)context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
			}
		});
//		mHolder.message.setOnClickListener(new OnClickListener() {
//			
//			@Override
//			public void onClick(View v) {
//				Intent intent = new  Intent(context, CommentsDetailsActivity.class);
//				context.startActivity(intent);
//				((Activity)context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
//				
//			}
//		});
	
		return view;
	}
	static class ViewHolder{
    	private TextView tvName;
    	private TextView tvTime;
    	private TextView tvComment;
    	private TextView tvMessage;
    	private ImageView imageView;
    	private ImageView imgHead;
    	private TextView tvContent;
    	private ImageButton imgAddFriend;
    	private LinearLayout llShare;
    	private LinearLayout layout_news;
    	private LinearLayout message;
    	private LinearLayout openLL;
    }
	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
	}
}

