package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.bean.News;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class TermsAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<News> moreNews;
	private News news;

	public TermsAdapter(Context context,ArrayList<News> moreNews){
		
		inflater=LayoutInflater.from(context);
		if(moreNews!=null){
			this.moreNews=moreNews;
		}else{
			moreNews=new ArrayList<News>();
		}
	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return moreNews.size();
	}

	@Override
	public News getItem(int position) {
		// TODO Auto-generated method stub
		return moreNews.get(position);
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
			view=inflater.inflate(R.layout.terms_and_conditions_item, null);
			mHolder=new ViewHolder();
			mHolder.tvTitle=(TextView)view.findViewById(R.id.tvContent);
			mHolder.tvTime=(TextView)view.findViewById(R.id.tvTime);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		news=moreNews.get(position);
		mHolder.tvTime.setText(news.getTime());
		return view;
	}
	static class ViewHolder{
    	private TextView tvTitle;
    	private TextView tvTime;
    }
}

