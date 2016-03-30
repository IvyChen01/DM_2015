package com.transsion.infinix.xclub.activity;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.util.LevelUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.trassion.infinix.xclub.R;

public class IntegraiActivity extends BaseActivity implements OnClickListener{
     
	private LinearLayout tvback;
	private TextView tvLevel;
	private ImageView imgLevel;
	private TextView tvpoints;
	private RelativeLayout relativelayout_level;
	private TextView tvAdmin;
	private TextView tvCurrentLevel;
	private TextView tvCurrentAdmin;
	private ImageView imgCurrentLevel;
	private ImageView imgMaxLevel;
	private RelativeLayout layout_level;
	private TextView tvCurrentPoint;
	private String credits;
	private int point;
	private ProgressBar progress;
	private int points;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		tvLevel=(TextView)findViewById(R.id.tvLevel);
		imgLevel=(ImageView)findViewById(R.id.imgLevel);
		tvpoints=(TextView)findViewById(R.id.tvpoints);
		relativelayout_level=(RelativeLayout)findViewById(R.id.relativelayout_level);
		tvAdmin=(TextView)findViewById(R.id.tvAdmin);
		tvCurrentLevel=(TextView)findViewById(R.id.tvCurrentLevel);
		imgCurrentLevel=(ImageView)findViewById(R.id.imgCurrentLevel);
		layout_level=(RelativeLayout)findViewById(R.id.layout_level);
		tvCurrentAdmin=(TextView)findViewById(R.id.tvCurrentAdmin);
		imgMaxLevel=(ImageView)findViewById(R.id.imgMaxLevel);
		tvCurrentPoint=(TextView)findViewById(R.id.tvCurrentPoint);
		progress=(ProgressBar)findViewById(R.id.progress);
		
		tvback.setOnClickListener(this);
		
	}
	private void setData() {
		// TODO Auto-generated method stub
		 credits=PreferenceUtils.getPrefString(this, "Credits", "");
		 String currentlevel=PreferenceUtils.getPrefString(this, "Level", "");
		 
		 new LevelUtil(this).SetLevel(relativelayout_level, tvAdmin, currentlevel, imgLevel, tvLevel);
		 tvpoints.setText(credits+" points");
		 
		 if(!currentlevel.contains("LV")){
			 tvCurrentAdmin.setText(currentlevel);
			 tvCurrentAdmin.setVisibility(View.VISIBLE);
			 layout_level.setVisibility(View.GONE);
	     }else{
	    	 layout_level.setVisibility(View.VISIBLE);
	    	 tvCurrentAdmin.setVisibility(View.GONE);
		 String currentLevel=currentlevel.substring(0,currentlevel.indexOf("L") );
		 String levelnumber=currentlevel.substring(currentlevel.indexOf("L"));
		 setLevel(imgCurrentLevel, currentLevel,tvCurrentLevel,imgMaxLevel,tvCurrentPoint);
		 tvCurrentLevel.setText(levelnumber);
	 }
	}

	private void setLevel(ImageView imageView,String level,TextView textView, ImageView imgMaxLevel,TextView tvPoint) {
		if(level.equals("Jade Star ")){
			 textView.setTextColor(0xFF009B7A);
			 imageView.setBackgroundResource(R.drawable.level_jade);
			 imgMaxLevel.setBackgroundResource(R.drawable.level_sapphire);
			 point=4500-Integer.parseInt(credits);
			 points=Integer.parseInt(credits)*100/4500;
			 progress.setProgress(points);
			 tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Sapphire Star ")){
		    	 textView.setTextColor(0xFF2B749F);
		    	imageView.setBackgroundResource(R.drawable.level_sapphire);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_golden);
		    	point=10000-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/10000;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Golden Star ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_golden);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_jade_diamond);
		    	point=21000-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/21000;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Jade Diamond ")){
		    	 textView.setTextColor(0xFF009B7A);
		    	imageView.setBackgroundResource(R.drawable.level_jade_diamond);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_sapphire_diamond);
		    	point=55000-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/55000;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Sapphire Diamond ")){
		    	textView.setTextColor(0xFF2B749F);
		    	imageView.setBackgroundResource(R.drawable.level_sapphire_diamond);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_golden_diamond);
		    	point=120000-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/120000;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Golden Diamond ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_golden_diamond);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_crown);
		    	point=550000-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/550000;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }else if(level.equals("Crown ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_crown);
		    	imgMaxLevel.setBackgroundResource(R.drawable.level_crown);
		    	point=999999999-Integer.parseInt(credits);
		    	points=Integer.parseInt(credits)*100/999999999;
				progress.setProgress(points);
		    	tvPoint.setText("There are "+point+" points from the next level.");
		    }
		
	}


	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;

		default:
			break;
		}
		
	}


	@Override
	public void setContentView() {
		setContentView(R.layout.activity_integral);
		initView();
		setData();
		
	}


	@Override
	public void initWidget() {
		// TODO Auto-generated method stub
		
	}


	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
}
