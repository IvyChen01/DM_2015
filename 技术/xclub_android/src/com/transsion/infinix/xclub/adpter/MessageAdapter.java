package com.transsion.infinix.xclub.adpter;

import java.util.ArrayList;

import com.transsion.infinix.xclub.activity.MessageActivity;
import com.transsion.infinix.xclub.bean.Message;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.trassion.infinix.xclub.R;

import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class MessageAdapter extends BaseAdapter {
    private ArrayList<Message>list;
	private LayoutInflater inflater;
	private Message message;
	private Context context;
	private ImageLoader mImageLoader;
	private String uid;
	private String touid;
	
	public void setInvitations(ArrayList<Message>list){
    	if(list!=null)
    		this.list=list;
    	else
    		this.list=new ArrayList<Message>();
    }
	public MessageAdapter(Context context ,ArrayList<Message>list) {
		this.context=context;
		this.setInvitations(list);
		inflater=LayoutInflater.from(context);
		uid=PreferenceUtils.getPrefInt(context,"uid", 0)+"";
		mImageLoader = ImageLoader.getInstance(context);
		
	}
	public void changeMessage(ArrayList<Message>list){
		this.setInvitations(list);
		this.notifyDataSetChanged();
	}
	
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return list.size();
	}

	@Override
	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return list.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	ViewHolder holder=null;
	public View getView(int position, View convertView, ViewGroup parent) {
		if(convertView==null){
			holder=new ViewHolder();
			convertView=inflater.inflate(R.layout.message_item, null);
			holder.tvName=(TextView)convertView.findViewById(R.id.tvName);
			holder.imgHead=(ImageView)convertView.findViewById(R.id.imgHead);
			holder.imgPoint=(ImageView)convertView.findViewById(R.id.imgPoint);
			holder.btnDelete=(Button)convertView.findViewById(R.id.btnDelete);
			 convertView.setTag(holder);
		}else{
			holder = (ViewHolder) convertView.getTag();  
		}
		message=list.get(position);
		String url=message.getAvatar().substring(message.getAvatar().indexOf("http"),message.getAvatar().indexOf("small") + 5);
		if(holder.imgHead!=null){
			try{
				mImageLoader.DisplayImage(url, holder.imgHead, 1, Constant.LESSNUM-position, 0, R.drawable.picture);
			}catch(Exception e){
				e.printStackTrace();
			}
		}
		Log.i("info", "fromid:"+message.getMsgfromid());
		Log.i("info", "uid:"+uid);
		if(!message.getMsgfromid().equals(uid)){
			holder.tvName.setText(message.getMsgfrom());	
		}else{
			holder.tvName.setText(message.getTousername());
		}
		if(message.getIsnew().equals("0")){
			holder.imgPoint.setVisibility(View.GONE);
		}else{
			holder.imgPoint.setVisibility(View.VISIBLE);
		}
        holder.btnDelete.setOnClickListener(new OnClickListener() {
			

			@Override
			public void onClick(View v) {
				if(!message.getMsgfromid().equals(uid)){
					touid=message.getMsgfromid();
				}else{
					touid=message.getMsgtoid();
				}
				((MessageActivity) context).deleteMessage(touid);
			}
		});
		return convertView;
	}
    class ViewHolder{
    	private TextView tvName;
    	private ImageView imgHead;
    	private Button  btnDelete;
    	private ImageView imgPoint;
    }
    
}
