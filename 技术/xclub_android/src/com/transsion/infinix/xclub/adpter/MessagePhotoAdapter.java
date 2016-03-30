package com.transsion.infinix.xclub.adpter;



import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.bean.ImageInfo;
import com.transsion.infinix.xclub.bean.SearchHotInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.image.ImageLoader;
import com.transsion.infinix.xclub.image.ImageManager;
import com.trassion.infinix.xclub.R;


import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;


/**
 * 
* @ClassName: EmoteAdapter    
* @Description: TODO(±Ì«È  ≈‰∆˜)    
* @author chenqian   
* @date 2013-11-28 œ¬ŒÁ2:17:53
 */
public class MessagePhotoAdapter extends BaseAdapter {
    
	private ArrayList<ImageInfo> message_imgsrc;
	private ImageInfo  imageInfo;
	private Context context;
	private ImageManager imageManager;
	private ImageLoader mImageLoader;
	
	public MessagePhotoAdapter(Context context, ArrayList<ImageInfo> message_imgsrc,ImageLoader imageLoader) {
		this.context=context;
		if(message_imgsrc==null){
			message_imgsrc = new ArrayList<ImageInfo>();
		}else{
		     this.message_imgsrc=message_imgsrc;
		}
		imageManager=new ImageManager();
		this.mImageLoader = imageLoader;
	}

	public int getCount() {
		// TODO Auto-generated method stub
		return message_imgsrc.size();
	}

	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return message_imgsrc.get(position);
	}

	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}


	public View getView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder = null;
		if (convertView == null) {
			convertView = LayoutInflater.from(context).inflate(R.layout.message_photo_item, null);
			holder = new ViewHolder();
			holder.imageView = (ImageView) convertView
					.findViewById(R.id.imgPhoto);
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}
		imageInfo=message_imgsrc.get(position);
		
		mImageLoader.DisplayImage(imageInfo.getUrl(),holder.imageView, 1, Constant.LESSNUM-position, 0, R.drawable.picture);
		return convertView;
	}

	class ViewHolder {
		ImageView imageView;
	}
	
}
