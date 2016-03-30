package com.trassion.newstop.adapter;

import java.util.ArrayList;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.adapter.NewsAdapter.ViewHolder;
import com.trassion.newstop.bean.Myfeed;
import com.trassion.newstop.bean.Problem;
import com.trassion.newstop.bean.QuestionInfo;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.TextView;

public class CommonProblemAdapter extends BaseAdapter {

	private LayoutInflater inflater;
	private ArrayList<QuestionInfo>data;
	private QuestionInfo problem;
	private Context context;

	public CommonProblemAdapter(Context context,ArrayList<QuestionInfo>data){
		
		inflater=LayoutInflater.from(context);
		if(data!=null){
			this.data=data;
		}else{
			data=new ArrayList<QuestionInfo>();
		}
	}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return data.size();
	}

	@Override
	public QuestionInfo getItem(int position) {
		// TODO Auto-generated method stub
		return data.get(position);
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
			view=inflater.inflate(R.layout.common_problem_item, null);
			mHolder=new ViewHolder();
			mHolder.tvTitle=(TextView)view.findViewById(R.id.tvTitle);
			mHolder.tvAnswer=(TextView)view.findViewById(R.id.tvAnswer);
			
			view.setTag(mHolder);
		}else{
			mHolder=(ViewHolder)view.getTag();
		}
		problem=data.get(position);
		mHolder.tvTitle.setText(problem.getQuestion());
		mHolder.tvAnswer.setText(problem.getAnswer());
		return view;
	}
	static class ViewHolder{
    	private TextView tvTitle;
    	private TextView tvAnswer;
    }
}

