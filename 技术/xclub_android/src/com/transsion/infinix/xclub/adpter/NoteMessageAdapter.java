package com.transsion.infinix.xclub.adpter;

import java.util.ArrayList;

import com.transsion.infinix.xclub.activity.RecommendActivity;
import com.transsion.infinix.xclub.bean.NoteMessage;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class NoteMessageAdapter extends BaseAdapter {
	private ArrayList<NoteMessage> notelist;
	private NoteMessage noteMessage;
	private LayoutInflater inflater;
	private ImageLoader mImageLoader;
	private Context context;
	
	public void setInvitations(ArrayList<NoteMessage>notelist){
    	if(notelist!=null)
    		this.notelist=notelist;
    	else
    		this.notelist=new ArrayList<NoteMessage>();
    }
    
	public NoteMessageAdapter(Context context ,ArrayList<NoteMessage>notelist) {
		this.context=context;
		this.setInvitations(notelist);
		inflater=LayoutInflater.from(context);
		mImageLoader = ImageLoader.getInstance(context);
	}
	public void notifyChanged(ArrayList<NoteMessage> notelist){
    	this.setInvitations(notelist);
    	notifyDataSetChanged();
    }
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return notelist.size();
	}

	@Override
	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return notelist.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	ViewHolder holder=null;
	public View getView(final int position, View convertView, ViewGroup parent) {
		if(convertView==null){
			holder=new ViewHolder();
			convertView=inflater.inflate(R.layout.note_message_item, null);
			holder.tvMessage=(TextView)convertView.findViewById(R.id.tvMessage);
			holder.imgHead=(ImageView)convertView.findViewById(R.id.imghead);
			 convertView.setTag(holder);
		}else{
			holder = (ViewHolder) convertView.getTag();  
		}
		    noteMessage=notelist.get(position);
		    String message=TextUtils.replaceChart(noteMessage.getNote());
		    holder.tvMessage.setText(noteMessage.getNote());
		    String url=noteMessage.getAvatar().substring(noteMessage.getAvatar().indexOf("http"),noteMessage.getAvatar().indexOf("small") + 5);
		   
		    	try {
		    		mImageLoader.DisplayImage(url, holder.imgHead, 1, Constant.LESSNUM-position, 0, R.drawable.picture);
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
		    holder.tvMessage.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					if(!NetUtil.isConnect(context)){
			 			ToastManager.showShort(context, "Õ¯¬Á“Ï≥£");
			 			return;
			 		}
					Intent intent=new Intent(context,RecommendActivity.class);
					intent.putExtra("tid",notelist.get(position).getNotevar().getTid());
					intent.putExtra("favrite", notelist.get(position).getNotevar().getHas_favorite());
					intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
					context.startActivity(intent);
					
				}
			});
		    holder.tvMessage.setOnLongClickListener(new OnLongClickListener() {
				
				@Override
				public boolean onLongClick(View v) {
					deleteMessage(notelist.get(position).getId());
					return false;
				}

			});
		    
		return convertView;
	}
	public void deleteMessage(String id) {
		// TODO Auto-generated method stub
		
	}
	class ViewHolder{
    	private TextView tvMessage;
    	private ImageView imgHead;
    }
}
