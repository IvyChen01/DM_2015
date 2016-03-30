package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.bean.FriendInformation;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class LikedFriendsAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<FriendInformation> friendInformation;
	private FriendInformation friend;
	private static int[] mImageIds = new int[] {R.drawable.af_headprotriat_1,
		R.drawable.af_headprotriat_3,R.drawable.af_headprotriat_4,R.drawable.af_headprotriat_6,};

	public LikedFriendsAdapter(Context context,ArrayList<FriendInformation> moreNews){
		
		inflater=LayoutInflater.from(context);
		if(moreNews!=null){
			this.friendInformation=moreNews;
		}else{
			moreNews=new ArrayList<FriendInformation>();
		}
	}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return friendInformation.size();
	}

	@Override
	public FriendInformation getItem(int position) {
		// TODO Auto-generated method stub
		return friendInformation.get(position);
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
			view=inflater.inflate(R.layout.liked_item, null);
			mHolder=new ViewHolder();
			mHolder.tvName=(TextView)view.findViewById(R.id.tvName);
			mHolder.imgHeader=(ImageView)view.findViewById(R.id.imgHeader);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		friend=friendInformation.get(position);
		mHolder.tvName.setText(friend.getName());
		mHolder.imgHeader.setBackgroundResource(mImageIds[position]);
		return view;
	}
	static class ViewHolder{
    	private TextView tvName;
    	private ImageView imgHeader;
    }
}

