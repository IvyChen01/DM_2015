package com.transsion.infinix.xclub.util;

import com.trassion.infinix.xclub.R;

import android.annotation.SuppressLint;
import android.content.Context;
import android.view.View;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class LevelUtil {
	  public LevelUtil(Context context){
		  
	  }
       
	@SuppressLint("ResourceAsColor")
	public void getLevel(ImageView imageView,String level,TextView textView){
		 if(level.equals("Jade Star ")){
			 textView.setTextColor(0xFF009B7A);
			 imageView.setBackgroundResource(R.drawable.level_jade);
		    }else if(level.equals("Sapphire Star ")){
		    	 textView.setTextColor(0xFF2B749F);
		    	imageView.setBackgroundResource(R.drawable.level_sapphire);
		    }else if(level.equals("Golden Star ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_golden);
		    }else if(level.equals("Jade Diamond ")){
		    	 textView.setTextColor(0xFF009B7A);
		    	imageView.setBackgroundResource(R.drawable.level_jade_diamond);
		    }else if(level.equals("Sapphire Diamond ")){
		    	textView.setTextColor(0xFF2B749F);
		    	imageView.setBackgroundResource(R.drawable.level_sapphire_diamond);
		    }else if(level.equals("Golden Diamond ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_golden_diamond);
		    }else if(level.equals("Crown ")){
		    	textView.setTextColor(0xFFE5A134);
		    	imageView.setBackgroundResource(R.drawable.level_crown);
		    }
	}
	public void SetLevel(RelativeLayout relativeLayout,TextView textView,String level,ImageView imageView,TextView tvLevel){
			 if(!level.contains("LV")){
				 textView.setText(level);
				 textView.setVisibility(View.VISIBLE);
				 relativeLayout.setVisibility(View.GONE);
		     }else{
			 relativeLayout.setVisibility(View.VISIBLE);
			 textView.setVisibility(View.GONE);
			 String currentLevel=level.substring(0,level.indexOf("L") );
			 String levelnumber=level.substring(level.indexOf("L"));
			 getLevel(imageView, currentLevel,tvLevel);
			 tvLevel.setText(levelnumber);
		 }
	}
}
