package com.transsion.infinix.xclub.adpter;



import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import com.transsion.infinix.xclub.MasterApplication;
import com.trassion.infinix.xclub.R;


import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;


/**
 * 
* @ClassName: EmoteAdapter    
* @Description: TODO(±Ì«È  ≈‰∆˜)    
* @author chenqian   
* @date 2013-11-28 œ¬ŒÁ2:17:53
 */
public class EmoteAdapter extends BaseAdapter {

	private Map<String, Integer> mFaceMap=null;
	private Context context;
	private List<Integer> faceList = new ArrayList<Integer>();
	public int getCount() {
		// TODO Auto-generated method stub
		return mFaceMap.size();
	}

	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return faceList.get(position);
	}

	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	public EmoteAdapter(Context context, Map<String, Integer> mFaceMap) {
		this.mFaceMap=mFaceMap;
		this.context=context;
		if(mFaceMap==null){
			mFaceMap = MasterApplication.getInstanse().getFaceMap();
		}
		initData();
	}
	private void initData() {
		for(Map.Entry<String, Integer> entry:mFaceMap.entrySet()){
			faceList.add(entry.getValue());
		}
	}

	public View getView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder = null;
		if (convertView == null) {
			convertView = LayoutInflater.from(context).inflate(R.layout.singleexpression, null);
			holder = new ViewHolder();
			holder.mIvImage = (ImageView) convertView
					.findViewById(R.id.image);
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}
		try {			
			holder.mIvImage.setImageResource(faceList.get(position));			
		} catch (Exception e) {
			// TODO: handle exception
		}
		return convertView;
	}

	class ViewHolder {
		ImageView mIvImage;
	}
	
}
