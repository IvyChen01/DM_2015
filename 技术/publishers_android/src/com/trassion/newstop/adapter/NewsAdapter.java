package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.NewsContentActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.bean.CommentInfo;
import com.trassion.newstop.bean.News;
import com.trassion.newstop.bean.NewsInfo;
import com.trassion.newstop.fragment.NewsFragment;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.tool.Utils;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class NewsAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<NewsInfo>data;
	private NewsInfo news;
	private ImageLoader imageloader;
	private Context context;
	private ImageManager imageManager;

	public NewsAdapter(Context context,ArrayList<NewsInfo>data){
		
		this.context=context;
		imageloader=ImageLoader.getInstance();
		imageManager=new ImageManager();
		inflater=LayoutInflater.from(context);
		if(data!=null){
			this.data=data;
		}else{
			data=new ArrayList<NewsInfo>();
		}
	}
	 public void notifyChanged(ArrayList<NewsInfo> data){
	    	for(int i=0;i<data.size();i++){
	    		news=data.get(i);
	    		this.data.add(news);
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
	public View getView(final int position, View convertView, ViewGroup parent) {
		View view=convertView;
		ViewHolder mHolder;
		if(view==null){
			view=inflater.inflate(R.layout.news_item, null);
			mHolder=new ViewHolder();
			mHolder.tvTitle=(TextView)view.findViewById(R.id.tvTitle);
			mHolder.tvTime=(TextView)view.findViewById(R.id.tvTime);
			mHolder.tvComments=(TextView)view.findViewById(R.id.tvComments);
			mHolder.tvType=(TextView)view.findViewById(R.id.tvType);
			mHolder.tvTime_two=(TextView)view.findViewById(R.id.tvTime_two);
			mHolder.layout_picture=(LinearLayout)view.findViewById(R.id.layout_picture);
			mHolder.picture_one=(ImageView)view.findViewById(R.id.picture_one);
			mHolder.picture_two=(ImageView)view.findViewById(R.id.picture_two);
			mHolder.picture_three=(ImageView)view.findViewById(R.id.picture_three);
			mHolder.picture_four=(ImageView)view.findViewById(R.id.picture_four);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		news=data.get(position);
		mHolder.tvTitle.setText(Utils.replaceChart(news.getTitle()));
		mHolder.tvComments.setText(news.getCommentCount()+" Comments");
		mHolder.tvType.setText(news.getAuthor());
		if(news.getImages().size()==0){
			mHolder.picture_one.setVisibility(View.GONE);
			mHolder.layout_picture.setVisibility(View.GONE);
			mHolder.tvTime.setText(news.getPubdate());
			mHolder.tvTime.setVisibility(View.VISIBLE);
			mHolder.tvTime_two.setVisibility(View.GONE);
		}
		if(news.getImages()!=null && news.getImages().size()>=3){
			imageloader.displayImage(news.getImages().get(0).getMedium_img(), mHolder.picture_two,imageManager.mDisplayImageOption,imageManager.animateFirstListener);
			imageloader.displayImage(news.getImages().get(1).getMedium_img(), mHolder.picture_three,imageManager.mDisplayImageOption,imageManager.animateFirstListener);
			imageloader.displayImage(news.getImages().get(2).getMedium_img(), mHolder.picture_four,imageManager.mDisplayImageOption,imageManager.animateFirstListener);
			mHolder.tvTime.setText(news.getPubdate());
			mHolder.tvTime.setVisibility(View.VISIBLE);
			mHolder.tvTime_two.setVisibility(View.GONE);
			mHolder.picture_one.setVisibility(View.GONE);
			mHolder.layout_picture.setVisibility(View.VISIBLE);
		}else if(news.getImages()!=null && news.getImages().size()<=2 && news.getImages().size()>=1){
			imageloader.displayImage(news.getImages().get(0).getMedium_img(), mHolder.picture_one,imageManager.mDisplayImageOption,imageManager.animateFirstListener);
			mHolder.tvTime_two.setText(news.getPubdate());
			mHolder.tvTime.setVisibility(View.GONE);
			mHolder.tvTime_two.setVisibility(View.VISIBLE);
			mHolder.picture_one.setVisibility(View.VISIBLE);
			mHolder.layout_picture.setVisibility(View.GONE);
		}
		if(news.getImages().size()==0){
			mHolder.picture_one.setVisibility(View.GONE);
			mHolder.layout_picture.setVisibility(View.GONE);
			mHolder.tvTime.setText(news.getPubdate());
			mHolder.tvTime.setVisibility(View.VISIBLE);
			mHolder.tvTime_two.setVisibility(View.GONE);
		}
		view.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				 Intent intent = new  Intent(context, NewsContentActivity.class);
			        Bundle mBundle = new Bundle();    
			        mBundle.putSerializable(NewsFragment.SER_KEY,data.get(position));    
			        intent.putExtras(mBundle);    
			        context.startActivity(intent);
			        ((Activity) context).overridePendingTransition(R.anim.slide_in_right, R.anim.slide_out_left);
				
			}
		});
		return view;
	}
	static class ViewHolder{
    	private TextView tvTitle;
    	private TextView tvTime;
    	private TextView tvType;
    	private TextView tvComments;
    	private TextView tvTime_two;
    	private LinearLayout layout_picture;
    	private ImageView picture_one;
    	private ImageView picture_two;
    	private ImageView picture_three;
    	private ImageView picture_four;
    }
}

