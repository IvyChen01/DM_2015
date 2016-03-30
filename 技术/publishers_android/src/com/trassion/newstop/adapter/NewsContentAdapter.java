package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.nostra13.universalimageloader.core.ImageLoader;
import com.trassion.newstop.activity.CommentsDetailsActivity;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.NewsAdapter.ViewHolder;
import com.trassion.newstop.bean.Comment;
import com.trassion.newstop.bean.CommentInfo;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.Problem;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.ImageManager;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

public class NewsContentAdapter extends BaseAdapter implements UICallBackInterface{

	private LayoutInflater inflater;
	ArrayList<CommentInfo> data;
	private CommentInfo comment;
	private Context context;
	private ImageLoader imageloader;
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private ImageManager imageManager;

	public NewsContentAdapter(Context context,ArrayList<CommentInfo> data){
		
		this.context=context;
		inflater=LayoutInflater.from(context);
		imageloader=ImageLoader.getInstance();
		imageManager=new ImageManager();
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context,NewsContentAdapter.this);
		
		auth=PreferenceUtils.getPrefString(context, "auth", "");
		saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
		
		if(data!=null){
			this.data=data;
		}else{
			data=new ArrayList<CommentInfo>();
		}
	}
	 public void notifyChanged(ArrayList<CommentInfo> data){
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
	public CommentInfo getItem(int position) {
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
		final ViewHolder mHolder;
		if(view==null){
			view=inflater.inflate(R.layout.news_content_item, null);
			mHolder=new ViewHolder();
			mHolder.tvName=(TextView)view.findViewById(R.id.tvName);
			mHolder.tvTime=(TextView)view.findViewById(R.id.tvTime);
//			mHolder.tvTotal=(TextView)view.findViewById(R.id.tvTotal);
			mHolder.tvLike=(TextView)view.findViewById(R.id.tvLike);
			mHolder.tvPresent=(TextView)view.findViewById(R.id.tvPresent);
			mHolder.layout_like=(LinearLayout)view.findViewById(R.id.layout_like);
//			mHolder.message=(LinearLayout)view.findViewById(R.id.message);
			mHolder.imgHeader=(ImageView)view.findViewById(R.id.imgHeader);
			mHolder.imglike=(ImageView)view.findViewById(R.id.imglike);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		if(data.size()>0){
		comment=data.get(position);
		mHolder.tvName.setText(comment.getUsername());
		mHolder.tvTime.setText(comment.getComment_date());
		mHolder.tvLike.setText(comment.getLike_count());
		mHolder.tvPresent.setText(comment.getContent());
		
		if(comment.getLiked().equals("0")){
			mHolder.imglike.setBackgroundResource(R.drawable.icon_like_normal);
		}else if(comment.getLiked().equals("1")){
			mHolder.imglike.setBackgroundResource(R.drawable.icon_like_press);
		}
		
		imageloader.displayImage(comment.getPhoto(), mHolder.imgHeader,imageManager.option,imageManager.animateFirstListener);
		
		}
		
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
		mHolder.layout_like.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				if(comment.getLiked().equals("0")){
				requestAddLike(comment.getId());
				if (NetworkUtil.isOnline(context)) {
				   mHolder.imglike.setBackgroundResource(R.drawable.icon_like_press);
				   mHolder.tvLike.setText(Integer.parseInt((comment.getLike_count())+1)+"");
				   data.get(position).setLiked("1");
				   data.get(position).setLike_count(Integer.parseInt((comment.getLike_count())+1)+"");
				}
				}else if(comment.getLiked().equals("1")){
					ToastManager.showLong(context, "You have thumb up");
				}
			}

		});
		return view;
	}
	static class ViewHolder{
    	private TextView tvName;
//    	private LinearLayout message;
    	private LinearLayout layout_like;
    	private ImageView imgHeader;
    	public ImageView imglike;
    	private TextView tvTime;
//    	private TextView tvTotal;
    	private TextView tvLike;
    	private TextView tvPresent;
    }
	private void requestAddLike(String commentId) {
		if (NetworkUtil.isOnline(context)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByAddCommentRequest(mHttpAgent, Utils.getPhoneIMEI(context), auth, saltkey,commentId, Constants.HTTP_ADD_LIKE);
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}
	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		if(bean!=null){
			if(msgId==Constants.HTTP_ADD_LIKE){
			NewsTopRegisterBeanresponse	response=(NewsTopRegisterBeanresponse)bean;
				if(response.getCode().equals("0")){
					
				 
				}
			}
		}
		
	}
	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
		
	}
}

