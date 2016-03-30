package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.NewsAdapter.ViewHolder;
import com.trassion.newstop.bean.Message;
import com.trassion.newstop.bean.Myfeed;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.TextView;

public class SystemMessageAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<Message> moreMessage;
	private Message message;
	private Context context;

	public SystemMessageAdapter(Context context,ArrayList<Message> moreMessage){
		
		inflater=LayoutInflater.from(context);
		if(moreMessage!=null){
			this.moreMessage=moreMessage;
		}else{
			moreMessage=new ArrayList<Message>();
		}
	}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return moreMessage.size();
	}

	@Override
	public Message getItem(int position) {
		// TODO Auto-generated method stub
		return moreMessage.get(position);
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
			view=inflater.inflate(R.layout.system_message_item, null);
			mHolder=new ViewHolder();
			mHolder.tvTime=(TextView)view.findViewById(R.id.tvTime);
			mHolder.tvMessage=(TextView)view.findViewById(R.id.tvMessage);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		message=moreMessage.get(position);
		mHolder.tvTime.setText(message.getMessage_date());
		mHolder.tvMessage.setText(message.getContent());
		
		return view;
	}
	static class ViewHolder{
    	private TextView tvTime;
    	private TextView tvMessage;
    }
}

