package com.transsion.infinix.xclub.adpter;

import java.lang.ref.SoftReference;
import java.util.ArrayList;
import java.util.Collections;
import java.util.LinkedList;
import java.util.List;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.RecommendActivity;
import com.transsion.infinix.xclub.bean.InvitationInfo;
import com.transsion.infinix.xclub.bean.PostListInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.util.Utils;
import com.trassion.infinix.xclub.R;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Message;
import android.text.Spannable;
import android.text.SpannableStringBuilder;
import android.text.style.ForegroundColorSpan;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class PostAdapter extends BaseAdapter {
    private ArrayList<PostListInfo> forum_threadlist;
    private PostListInfo postInfo;
    private LayoutInflater inflater;
    Context context;
	private ImageLoader mImgLoader;
	private String message;
	private String result;
	
    
    public void setInvitations(ArrayList<PostListInfo>forum_threadlist){
    	if(forum_threadlist!=null)
    		this.forum_threadlist=forum_threadlist;
    	else
    		this.forum_threadlist=new ArrayList<PostListInfo>();
    }
    public PostAdapter(Context context,ArrayList<PostListInfo> forum_threadlist){
    	this.context=context;
    	this.setInvitations(forum_threadlist);
    	inflater=LayoutInflater.from(context);
    	mImgLoader = ImageLoader.getInstance(context);

    }
    public void notifyChanged(ArrayList<PostListInfo> forum_threadlist){
    	for(int i=0;i<forum_threadlist.size();i++){
    		postInfo=forum_threadlist.get(i);
    		this.forum_threadlist.add(postInfo);
    	}
    	this.setInvitations(this.forum_threadlist);
    	notifyDataSetChanged();
    }
    
	public void setResult(String result) {
		this.result = result;
	}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return forum_threadlist.size();
	}

	@Override
	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return forum_threadlist.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}
    
	ViewHolder holder=null;
	public View getView(final int position, View contentView, ViewGroup parent) {
		
		if(contentView==null){
			contentView=inflater.inflate(R.layout.xclub_item, null);
			holder=new ViewHolder();
			holder.name=(TextView)contentView.findViewById(R.id.tvName);
			holder.time=(TextView)contentView.findViewById(R.id.tvTime);
			holder.title=(TextView)contentView.findViewById(R.id.tvTitle);
			holder.CardContent=(TextView)contentView.findViewById(R.id.tvContent);
			holder.massage=(TextView)contentView.findViewById(R.id.tvMessage);
			holder.Praise=(TextView)contentView.findViewById(R.id.tvNumber);
			holder.ivhead=(ImageView)contentView.findViewById(R.id.imghead);
			holder.imageViews[0]=(ImageView)contentView.findViewById(R.id.imgpicture1);
			holder.imageViews[1]=(ImageView)contentView.findViewById(R.id.imgpicture2);
			holder.imageViews[2]=(ImageView)contentView.findViewById(R.id.imgpicture3);
			holder.bottom=(LinearLayout)contentView.findViewById(R.id.layout_bottom);
			holder.layout_top=(LinearLayout)contentView.findViewById(R.id.layout_top);
			holder.layout_content=(LinearLayout)contentView.findViewById(R.id.layout_content);
			holder.tvTitle_top=(TextView)contentView.findViewById(R.id.tvTitle_top);
			
			contentView.setTag(holder);
		}else{
			holder=(ViewHolder)contentView.getTag();
		}
		postInfo=forum_threadlist.get(position);
		
		if(postInfo.getSticky()!=null && postInfo.getSticky().equals("1")){
			holder.layout_top.setVisibility(View.VISIBLE);
			holder.layout_content.setVisibility(View.GONE);
			String subject=TextUtils.replaceChart(postInfo.getSubject());
			 if(result!=null){
         		holder.tvTitle_top.setText(TextUtils.getString(subject, result));
			}else{
			        holder.tvTitle_top.setText(subject);
			}
		}else{
			holder.layout_top.setVisibility(View.GONE);
			holder.layout_content.setVisibility(View.VISIBLE);
			
			String url=postInfo.getBigavatar();
		    holder.name.setText(postInfo.getAuthor());
		    String subject=TextUtils.replaceChart(postInfo.getSubject());
            if(result!=null){
            		holder.title.setText(TextUtils.getString(subject, result));
			}else{
			        holder.title.setText(subject);
			}
			if(postInfo.getMessage()!=null){
				message = TextUtils.replaceChart(postInfo.getMessage().toString());
			}
			holder.CardContent.setText(message);
			holder.time.setText(postInfo.getDateline());
			holder.massage.setText(postInfo.getReplies());
			holder.Praise.setText(postInfo.getViews());
			//链接样式, 显示表情
			Utils.getUtils().addLinks("",holder.CardContent);javascript:;
			if(holder.ivhead!=null){
				try{
					mImgLoader.DisplayImage(url, holder.ivhead, 1, Constant.LESSNUM-position, 10, R.drawable.img_head_bg);
				}catch(Exception e){
					e.printStackTrace();
				}
			}
			
			if(postInfo.getImages()!=null && postInfo.getImages().size()>0){
				holder.bottom.setVisibility(View.VISIBLE);
				for(int i=0;i<postInfo.getImages().size();i++){
					try {
						mImgLoader.DisplayImage(postInfo.getImages().get(i).getAttachment(),holder.imageViews[i], 1, Constant.LESSNUM-position, 0, R.drawable.picture);
					} catch (Exception e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
				}
				if(postInfo.getImages().size()>=3){
					holder.imageViews[0].setVisibility(View.VISIBLE);
					holder.imageViews[1].setVisibility(View.VISIBLE);
					holder.imageViews[2].setVisibility(View.VISIBLE);
				}else if(postInfo.getImages().size()>=2){
					holder.imageViews[0].setVisibility(View.VISIBLE);
					holder.imageViews[1].setVisibility(View.VISIBLE);
					holder.imageViews[2].setVisibility(View.GONE);
				}else{
					holder.imageViews[1].setVisibility(View.GONE);
					holder.imageViews[2].setVisibility(View.GONE);
					holder.imageViews[0].setVisibility(View.VISIBLE);
				}
			}else{
				holder.bottom.setVisibility(View.GONE);
			}
	        contentView.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					if(!NetUtil.isConnect(context)){
			 			ToastManager.showShort(context, "Data requests failed, please try again later");
			 			return;
			 		}
					Intent intent=new Intent(context,RecommendActivity.class);
					intent.putExtra("tid",forum_threadlist.get(position).getTid());
					intent.putExtra("Title",forum_threadlist.get(position).getSubject());
					intent.putExtra("favrite", forum_threadlist.get(position).getHas_favorite());
					intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
					context.startActivity(intent);
					
				}
			});
		}
		holder.tvTitle_top.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				if(!NetUtil.isConnect(context)){
		 			ToastManager.showShort(context, "Data requests failed, please try again later");
		 			return;
		 		}
				Intent intent=new Intent(context,RecommendActivity.class);
				intent.putExtra("tid",forum_threadlist.get(position).getTid());
				intent.putExtra("favrite", forum_threadlist.get(position).getSubject());
				intent.putExtra("Title", postInfo.getSubject());
				intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
				context.startActivity(intent);
				
			}
		});
        holder.CardContent.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				if(!NetUtil.isConnect(context)){
		 			ToastManager.showShort(context, "Data requests failed, please try again later");
		 			return;
		 		}
				Intent intent=new Intent(context,RecommendActivity.class);
				intent.putExtra("tid",forum_threadlist.get(position).getTid());
				intent.putExtra("favrite", forum_threadlist.get(position).getHas_favorite());
				intent.putExtra("Title", forum_threadlist.get(position).getSubject());
				intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
				context.startActivity(intent);
				
			}
		});
  		return contentView;
	}

	 class ViewHolder{
		private TextView name;
		private TextView CardContent;
		private TextView time;
		private TextView massage;
		private TextView Praise;
		private TextView title;
		private ImageView ivhead;
		private ImageView[] imageViews=new ImageView[3];
		private LinearLayout bottom;
		private LinearLayout layout_top;
		private LinearLayout layout_content;
		private TextView tvTitle_top;
	}

}
