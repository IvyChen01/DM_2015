package com.transsion.infinix.xclub.adpter;



import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.bean.SearchHotInfo;
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
public class SearchHotAdapter extends BaseAdapter {
    
	private ArrayList<SearchHotInfo>hotsearch;
	private SearchHotInfo  hot;
	private Context context;
	public int getCount() {
		// TODO Auto-generated method stub
		return hotsearch.size();
	}

	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return hotsearch.get(position);
	}

	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	public SearchHotAdapter(Context context, ArrayList<SearchHotInfo>hotsearch) {
		this.context=context;
		if(hotsearch==null){
			hotsearch = new ArrayList<SearchHotInfo>();
		}else{
		     this.hotsearch=hotsearch;
		}
	}

	public View getView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder = null;
		if (convertView == null) {
			convertView = LayoutInflater.from(context).inflate(R.layout.search_item, null);
			holder = new ViewHolder();
			holder.tvName = (TextView) convertView
					.findViewById(R.id.tvName);
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}
		    hot=hotsearch.get(position);
			holder.tvName.setText(hot.getKeyword());	
	   
		return convertView;
	}

	class ViewHolder {
		TextView tvName;
	}
	
}
