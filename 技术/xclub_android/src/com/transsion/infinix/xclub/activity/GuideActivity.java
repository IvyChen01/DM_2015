package com.transsion.infinix.xclub.activity;

import java.util.ArrayList;
import java.util.List;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.util.DepthPageTransformer;
import com.trassion.infinix.xclub.R;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;




public class GuideActivity extends BaseActivity implements OnPageChangeListener,OnClickListener {

  private ViewPager vp;
  private List<View> views;
  private ViewPagerAdapter vpAdapter;
  private LayoutInflater inflater;
  private Button btnnext;
  private Button btnLogin;
  
  private void initViews() {
	  btnnext=(Button)findViewById(R.id.guide_button);
	  btnLogin=(Button)findViewById(R.id.login_button);
	  btnnext.setOnClickListener(this);
	  btnLogin.setOnClickListener(this);
	  
    views = new ArrayList<View>();
    
    views.add(inflater.inflate(R.layout.views_one, null));
    views.add(inflater.inflate(R.layout.views_two, null));
    views.add(inflater.inflate(R.layout.views_three, null));
    
    vpAdapter = new ViewPagerAdapter(views, this);
    
    vp = (ViewPager)findViewById(R.id.viewpager);
    vp.setPageTransformer(true, new DepthPageTransformer());
    vp.setAdapter(vpAdapter);
    vp.setOnPageChangeListener(this);
  }


	
  public class ViewPagerAdapter extends PagerAdapter{

    private List<View> views;
    private Activity activity;
    
    public ViewPagerAdapter(List<View> views, Activity activity){
      this.views = views;
      this.activity = activity;
    }
    
    @Override
    public void destroyItem(View arg0, int arg1, Object arg2) {
      ((ViewPager) arg0).removeView(views.get(arg1));
    }
    
    @Override
    public int getCount() {
      
      if(views != null){
        return views.size();
      }
      
    return 0;
  }
    @Override
    public Object instantiateItem(View arg0, int arg1) {
      ((ViewPager) arg0).addView(views.get(arg1),0);
      
       return views.get(arg1);
    }
    
    @Override
    public boolean isViewFromObject(View arg0, Object arg1) {
      return (arg0 == arg1);
    }

   
  }
  
  @Override
    public void onPageScrollStateChanged(int arg0) {
    
  }

  @Override
  public void onPageScrolled(int arg0, float arg1, int arg2) {

  }

  @Override
  public void onPageSelected(int arg0) {
	//  setCurrentDot(arg0);
	  if(arg0==2){
			btnLogin.setVisibility(View.VISIBLE);
			btnnext.setVisibility(View.VISIBLE);
	  }else{
		    btnLogin.setVisibility(View.GONE);
			btnnext.setVisibility(View.GONE);
	  }
  }

@Override
public void onClick(View v) {
	switch (v.getId()) {
	case R.id.guide_button:
		setGuided();
        goHome();
		break;
    case R.id.login_button:
    	setGuided();
		Intent intent=new Intent(this,SlidingActivity.class);
		intent.putExtra("type", 1);
		animStartActivity(intent);
		finish();
		break;
	default:
		break;
	}

}
public void goHome() {
    Intent intent = new Intent(GuideActivity.this, SlidingActivity.class);
    startActivity(intent);
    overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
    finish();
  }

  public void setGuided() {
    SharedPreferences preferences = getSharedPreferences("first_pref", Context.MODE_PRIVATE);
    Editor editor = preferences.edit();
    editor.putBoolean("isFirst", false);
    editor.commit();
  }


@Override
public void setContentView() {
	setContentView(R.layout.activity_guide);
    inflater = LayoutInflater.from(this);
    initViews();
	
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
