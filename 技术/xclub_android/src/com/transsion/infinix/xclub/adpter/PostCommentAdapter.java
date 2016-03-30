package com.transsion.infinix.xclub.adpter;

import java.util.ArrayList;

import org.apache.http.message.BasicNameValuePair;



import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.PictureViewActivity;
import com.transsion.infinix.xclub.activity.RecommendActivity;
import com.transsion.infinix.xclub.activity.ReportActivity;
import com.transsion.infinix.xclub.bean.DiscussListInfo;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.LevelUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.util.Utils;
import com.transsion.infinix.xclub.view.PostScoreDilog;
import com.trassion.infinix.xclub.R;

import android.content.Context;
import android.content.Intent;
import android.graphics.Point;
import android.media.Image;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.view.animation.Animation;
import android.view.animation.TranslateAnimation;
import android.view.animation.Animation.AnimationListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class PostCommentAdapter extends BaseAdapter implements RequestListener<BaseEntity>,OnClickListener{
	private Context context;
	private LayoutInflater inflater;
	private ArrayList<DiscussListInfo> postlist;
	private DiscussListInfo discussListInfo;
	private ImageManager imageManager;
	private TranslateAnimation animation;
	private PostScoreDilog dialog;
	private String tid;
	private String saltkey;
	private String auth;
	private LoginInfo logininfo;
	private LevelUtil levelUtil;
	private ImageLoader mImgLoader;
	private BaseDao dao;
	private String message;
	private String from;
	private String number;
	private int currentIndex;
	private String[] url;
	private String[] description;
	private String postUrl;
    
	
	  public void setInvitations(ArrayList<DiscussListInfo> postlist){
    	  if(postlist!=null)
    		  this.postlist=postlist;
    	 else
    		  this.postlist=new ArrayList<DiscussListInfo>();
       }
	  public PostCommentAdapter(Context context,ArrayList<DiscussListInfo> postlist,String postUrl){
	    	this.context=context;
	    	this.postUrl=postUrl;
//	    	postlist.remove(0);
	    	this.setInvitations(postlist);
	    	inflater=LayoutInflater.from(context);
	    	mImgLoader = ImageLoader.getInstance(context);
	    	tid=PreferenceUtils.getPrefString(context, "tid", "");
	    	saltkey=PreferenceUtils.getPrefString(context, "saltkey", "");
	 	    auth=PreferenceUtils.getPrefString(context, "auth", "");
	 	    levelUtil=new LevelUtil(context);
	    	
	    }
	  public void notifyChanged(ArrayList<DiscussListInfo> postlist){
		  String type=PreferenceUtils.getPrefString(context, "ChangeType", "");
		  if(type.equals("1")){
//			  postlist.remove(0);
			  this.postlist=postlist;
		  }else if(type.equals("2")){
		    for(int i=0;i<postlist.size();i++){
			    discussListInfo=postlist.get(i);
	    	    this.postlist.add(discussListInfo);
	    	 }
	    	this.setInvitations(this.postlist);
		  }else if(type.equals("3")){
			  discussListInfo=postlist.get(0);
			  this.postlist.add(discussListInfo);
		  }
	    	notifyDataSetChanged();
	    }
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return postlist.size();
	}

	@Override
	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return postlist.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}
	public View getView(final int position, View convertView, ViewGroup parent) {
		final ViewHolder holder;
		if(convertView==null){
			convertView=inflater.inflate(R.layout.post_item, null);
			holder=new ViewHolder();
			holder.name=(TextView)convertView.findViewById(R.id.tvName);
			holder.time=(TextView)convertView.findViewById(R.id.tvTime);
		    holder.imgPost=(ImageView)convertView.findViewById(R.id.imgPost);
			holder.layout_level=(RelativeLayout)convertView.findViewById(R.id.layout_level);
			holder.tvLevel=(TextView)convertView.findViewById(R.id.tvLevel);
			holder.tvAdmin=(TextView)convertView.findViewById(R.id.tvAdmin);
			holder.imgLevel=(ImageView)convertView.findViewById(R.id.imgLevel);
			holder.tvFrom=(TextView)convertView.findViewById(R.id.tvFrom);
			holder.quote=(TextView)convertView.findViewById(R.id.tvQuote);
			holder.tvSubject=(TextView)convertView.findViewById(R.id.tvSubject);
			holder.massage=(TextView)convertView.findViewById(R.id.tvContent);
			holder.tvId=(TextView)convertView.findViewById(R.id.tvNumber);
			holder.ivhead=(ImageView)convertView.findViewById(R.id.imgHead);
			holder.gender=(ImageView)convertView.findViewById(R.id.imgSex);
			holder.imgThread=(ImageView)convertView.findViewById(R.id.imgThread);
			holder.tvLike=(TextView)convertView.findViewById(R.id.tvLike);
			holder.line=(ImageView)convertView.findViewById(R.id.line);
			holder.bottom=(LinearLayout)convertView.findViewById(R.id.layout_bottom);
			holder.layout_image=(LinearLayout)convertView.findViewById(R.id.layout_image);
			holder.layout_buttom=(RelativeLayout)convertView.findViewById(R.id.layout_buttom);
			holder.layout_post=(LinearLayout)convertView.findViewById(R.id.layout_post);
			holder.imageViews[0]=(ImageView)convertView.findViewById(R.id.imgpicture1);
			holder.imageViews[1]=(ImageView)convertView.findViewById(R.id.imgpicture2);
			holder.imageViews[2]=(ImageView)convertView.findViewById(R.id.imgpicture3);
			holder.images[0]=(ImageView)convertView.findViewById(R.id.imgpicture4);
			holder.images[1]=(ImageView)convertView.findViewById(R.id.imgpicture5);
			holder.images[2]=(ImageView)convertView.findViewById(R.id.imgpicture6);
			holder.images[3]=(ImageView)convertView.findViewById(R.id.imgpicture7);
			holder.images[4]=(ImageView)convertView.findViewById(R.id.imgpicture8);
			holder.images[5]=(ImageView)convertView.findViewById(R.id.imgpicture9);
			holder.images[6]=(ImageView)convertView.findViewById(R.id.imgpicture10);
			holder.images[7]=(ImageView)convertView.findViewById(R.id.imgpicture11);
			holder.images[8]=(ImageView)convertView.findViewById(R.id.imgpicture12);
			holder.images[9]=(ImageView)convertView.findViewById(R.id.imgpicture13);
			holder.images[10]=(ImageView)convertView.findViewById(R.id.imgpicture14);
			holder.images[11]=(ImageView)convertView.findViewById(R.id.imgpicture15);
			holder.images[12]=(ImageView)convertView.findViewById(R.id.imgpicture16);
			holder.images[13]=(ImageView)convertView.findViewById(R.id.imgpicture17);
			holder.images[14]=(ImageView)convertView.findViewById(R.id.imgpicture18);
			holder.images[15]=(ImageView)convertView.findViewById(R.id.imgpicture19);
			holder.images[16]=(ImageView)convertView.findViewById(R.id.imgpicture20);
			holder.images[17]=(ImageView)convertView.findViewById(R.id.imgpicture21);
			holder.images[18]=(ImageView)convertView.findViewById(R.id.imgpicture22);
			holder.images[19]=(ImageView)convertView.findViewById(R.id.imgpicture23);
			
			for (ImageView image : holder.images) {
				image.setOnClickListener(this);
			}
			
			
			convertView.setTag(holder);
		}else{
			holder=(ViewHolder)convertView.getTag();
		}
		    discussListInfo=postlist.get(position);
		    
		    message = TextUtils.replaceChart(discussListInfo.getMessage().toString());
		    holder.name.setText(discussListInfo.getAuthor());
		    holder.time.setText(discussListInfo.getDateline());
		    holder.massage.setText(discussListInfo.getMessage());
		    if(discussListInfo.getFrom()!=null){
		    from=TextUtils.replaceChart(discussListInfo.getFrom().toString());
		    holder.tvFrom.setText(from);
		    }
		    //链接样式, 显示表情
			Utils.getUtils().addLinks("",holder.massage);
		    holder.tvId.setText("#"+discussListInfo.getPosition());
		    
		    Log.i("info", "level:"+discussListInfo.getLevel());
		    
		    levelUtil.SetLevel(holder.layout_level, holder.tvAdmin, discussListInfo.getLevel(), holder.imgLevel, holder.tvLevel);
		    
		    if(discussListInfo.getGender()!=null&&discussListInfo.getGender().equals("1")){
		    	holder.gender.setBackgroundResource(R.drawable.man);
		    }else if(discussListInfo.getGender()!=null&&discussListInfo.getGender().equals("2")){
		    	holder.gender.setBackgroundResource(R.drawable.woman);
		    }
		    if(TextUtils.isEmpty(discussListInfo.getQuote())){
		    	holder.quote.setVisibility(View.GONE);
		    }else{
		    	holder.quote.setText(postlist.get(position).getQuote());
		    	holder.quote.setVisibility(View.VISIBLE);
		    }
            
		    if(discussListInfo.getImgage().size()>0){
				holder.bottom.setVisibility(View.VISIBLE);
				for(int i=0;i<discussListInfo.getImgage().size();i++){
					try {
						mImgLoader.DisplayImage(discussListInfo.getImgage().get(i).getUrl(), holder.imageViews[i], 1, Constant.LESSNUM-position, 0, R.drawable.picture);  
					} catch (Exception e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
				}
				if(discussListInfo.getImgage().size()>=3){
					holder.imageViews[0].setVisibility(View.VISIBLE);
					holder.imageViews[1].setVisibility(View.VISIBLE);
					holder.imageViews[2].setVisibility(View.VISIBLE);
				}else if(discussListInfo.getImgage().size()>=2){
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
		    if(position==0){
		    	int size=postlist.get(position).getImgage().size();
		    	url=new String[size];
		    	description=new String[size];
		    	for(int i=0;i<size;i++){
		    		url[i]=postlist.get(position).getImgage().get(i).getUrl();
		    		description[i]=postlist.get(position).getImgage().get(i).getDescription();
		    	}
		    	holder.imgThread.setVisibility(View.VISIBLE);
		    	holder.tvId.setVisibility(View.GONE);
		    	holder.layout_buttom.setVisibility(View.GONE);
		    	holder.line.setVisibility(View.GONE);
		    	holder.tvSubject.setVisibility(View.VISIBLE);
		    	holder.tvSubject.setText(discussListInfo.getSubject());
		    	holder.tvLike.setVisibility(View.VISIBLE);
		    	if(discussListInfo.getViews().equals("")){
		    		 number="0";
		    	}else{
		    		number=discussListInfo.getViews();
		    	}
		    	
		    	holder.tvLike.setText("Rita Silvas,Peggy Wells,et "+ number+" people like this");
		    	holder.layout_image.setVisibility(View.VISIBLE);
		    	holder.bottom.setVisibility(View.GONE);
		    	
		    	if(discussListInfo.getImgage().size()>0){
					for(int i=0;i<discussListInfo.getImgage().size();i++){
						try {
							if(i<=20){
							mImgLoader.DisplayImage(discussListInfo.getImgage().get(i).getUrl(), holder.images[i], 1, Constant.LESSNUM-position, 0, R.drawable.picture);  
							}
							} catch (Exception e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
					}
		    	}

		    }else{
		    	holder.imgThread.setVisibility(View.GONE);
		    	holder.tvId.setVisibility(View.VISIBLE);
		    	holder.layout_buttom.setVisibility(View.VISIBLE);
		    	holder.tvSubject.setVisibility(View.GONE);
		    	holder.tvLike.setVisibility(View.GONE);
		    	holder.line.setVisibility(View.VISIBLE);
		    	holder.layout_image.setVisibility(View.GONE);
		    	if(discussListInfo.getImgage().size()>0){
		    		holder.bottom.setVisibility(View.VISIBLE);
		    	}else{
		    	    holder.bottom.setVisibility(View.GONE);
		    	}
		    }
		    
		    if(holder.ivhead!=null){
				try{
					mImgLoader.DisplayImage(discussListInfo.getBigavatar(), holder.ivhead, 1, Constant.LESSNUM-position, 10, R.drawable.img_head_bg);
				}catch(Exception e){
					e.printStackTrace();
				}
		}
		    holder.imgPost.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					Clicked(v,postlist.get(position).getPid());
				}

			});
		    holder.imageViews[0].setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					int size=postlist.get(position).getImgage().size();
			    	url=new String[size];
			    	description=new String[size];
			    	for(int i=0;i<size;i++){
			    		url[i]=postlist.get(position).getImgage().get(i).getUrl();
			    		description[i]=postlist.get(position).getImgage().get(i).getDescription();
			    	}
			    	currentIndex=0;
			    	StartPictureActivity();
				}
			});
            holder.imageViews[1].setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					int size=postlist.get(position).getImgage().size();
			    	url=new String[size];
			    	description=new String[size];
			    	for(int i=0;i<size;i++){
			    		url[i]=postlist.get(position).getImgage().get(i).getUrl();
			    		description[i]=postlist.get(position).getImgage().get(i).getDescription();
			    	}
			    	currentIndex=1;
			    	StartPictureActivity();
				}
			});
             holder.imageViews[2].setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					int size=postlist.get(position).getImgage().size();
			    	url=new String[size];
			    	description=new String[size];
			    	for(int i=0;i<size;i++){
			    		url[i]=postlist.get(position).getImgage().get(i).getUrl();
			    		description[i]=postlist.get(position).getImgage().get(i).getDescription();
			    	}
			    	currentIndex=2;
			    	StartPictureActivity();
				}
			});
		return convertView;
	}
	
	public void Clicked(View v,String pid) {
		// TODO Auto-generated method stub
		
	}
	
	class ViewHolder{
			private TextView name;
			private TextView time;
			private TextView massage;
			private TextView tvId;
			private ImageView imgPost;
			private TextView tvFrom;
			private TextView quote;
			private ImageView ivhead;
			private ImageView gender;
			private LinearLayout bottom;
			private LinearLayout layout_post;
			private RelativeLayout layout_buttom;
			private RelativeLayout layout_level;
			private ImageView imgLevel;
			private ImageView imgThread;
			private TextView tvLevel;
			private TextView tvAdmin;
			private TextView tvSubject;
			private TextView tvLike;
			private ImageView line;
			private LinearLayout layout_image;
			private ImageView[] imageViews=new ImageView[3];
			private ImageView[] images=new ImageView[20];
			private boolean isShow=false;
		}
	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			 logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			 if(logininfo.getMessage().getMessageval().equals("thread_rate_succeed")){
  			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
  			   ToastManager.showShort(context, "Score success");
  			   dialog.dismiss();
			 }else{
				 ToastManager.showShort(context,logininfo.getMessage().getMessagestr());
			 }
		}
		
	}
	
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.imgpicture4:
			currentIndex=0;
			StartPictureActivity();
			break;
		case R.id.imgpicture5:
			currentIndex=1;
			StartPictureActivity();
			break;
		case R.id.imgpicture6:
			currentIndex=2;
			StartPictureActivity();
			break;
		case R.id.imgpicture7:
			currentIndex=3;
			StartPictureActivity();
			break;
		case R.id.imgpicture8:
			currentIndex=4;
			StartPictureActivity();
			break;
		case R.id.imgpicture9:
			currentIndex=5;
			StartPictureActivity();
			break;
		case R.id.imgpicture10:
			currentIndex=6;
			break;
		case R.id.imgpicture11:
			currentIndex=7;
			StartPictureActivity();
			break;
		case R.id.imgpicture12:
			currentIndex=8;
			StartPictureActivity();
			break;
		case R.id.imgpicture13:
			currentIndex=9;
			StartPictureActivity();
			break;
		case R.id.imgpicture14:
			currentIndex=10;
			StartPictureActivity();
			break;
		case R.id.imgpicture15:
			currentIndex=11;
			StartPictureActivity();
			break;
		case R.id.imgpicture16:
			currentIndex=12;
			StartPictureActivity();
			break;
		case R.id.imgpicture17:
			currentIndex=13;
			StartPictureActivity();
			break;
		case R.id.imgpicture18:
			currentIndex=14;
			StartPictureActivity();
			break;
		case R.id.imgpicture19:
			currentIndex=15;
			StartPictureActivity();
			break;
		case R.id.imgpicture20:
			currentIndex=16;
			StartPictureActivity();
			break;
		case R.id.imgpicture21:
			currentIndex=17;
			StartPictureActivity();
			break;
		case R.id.imgpicture22:
			currentIndex=18;
			StartPictureActivity();
			break;
		case R.id.imgpicture23:
			currentIndex=19;
			StartPictureActivity();
			break;
		default:
			break;
		}
		
	}
	private void StartPictureActivity() {
		Intent intent=new Intent(context,PictureViewActivity.class);
		Bundle mBundle = new Bundle();    
        mBundle.putStringArray("picUrl", url);
        mBundle.putStringArray("Description", description);
        mBundle.putString("PostUrl", postUrl);
        mBundle.putInt("initIndex", currentIndex);
        intent.putExtras(mBundle);
        intent.setFlags(intent.FLAG_ACTIVITY_NEW_TASK);
		context.startActivity(intent);
	}
}
