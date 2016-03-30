package com.transsion.infinix.xclub.fragment;

import java.util.ArrayList;

import com.transsion.infinix.xclub.activity.SlidingActivity;
import com.transsion.infinix.xclub.activity.WritePostActivity;
import com.trassion.infinix.xclub.R;



import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class ViewPageFragment extends Fragment implements OnClickListener{
   private ImageView ivRight;
   private ViewPager mPager;
   private MyAdapter mAdapter;
	private ArrayList<Fragment> pagerItemList = new ArrayList<Fragment>();
//	private LinearLayout tvCountry;
	private LinearLayout linearlayout1;
	private Context context;
	Button[] btnArray = new Button[4];
	private int currentFragmentIndex;
	@Override
		public View onCreateView(LayoutInflater inflater, ViewGroup container,
				Bundle savedInstanceState) {
			// TODO Auto-generated method stub
		    View mView = inflater.inflate(R.layout.view_pager, null);
		    ivRight=(ImageView)mView.findViewById(R.id.ivRright);
		    mPager = (ViewPager) mView.findViewById(R.id.pager);
//		    tvCountry=(LinearLayout)mView.findViewById(R.id.tvCountry);
			linearlayout1=(LinearLayout)mView.findViewById(R.id.linearlayout1);
			context=mView.getContext();
			btnArray[0] = (Button)mView.findViewById(R.id.bt1);
			btnArray[1] = (Button)mView.findViewById(R.id.bt2);
			btnArray[2] = (Button)mView.findViewById(R.id.bt3);
			btnArray[3] = (Button)mView.findViewById(R.id.bt4);
			for (Button btn : btnArray) {
				btn.setOnClickListener(this);
			}
//			tvCountry.setOnClickListener(this);
		    MainFragment page1 = new MainFragment();
//		    PageFragment2 page2 = new PageFragment2();
//		    PageFragment3 page3 = new PageFragment3();
//		    PageFragment4 page4 = new PageFragment4();
		    pagerItemList.add(page1);
//		    pagerItemList.add(page2);
//		    pagerItemList.add(page3);
//		    pagerItemList.add(page4);
		    mAdapter = new MyAdapter(getFragmentManager());
			mPager.setAdapter(mAdapter);
			mPager.setOnPageChangeListener(new ViewPager.OnPageChangeListener() {

				@Override
				public void onPageSelected(int position) {
					currentFragmentIndex = position;
					updateButtonTextColor();
					if (myPageChangeListener != null)
						myPageChangeListener.onPageSelected(position);
					
				}
				

				@Override
				public void onPageScrolled(int arg0, float arg1, int arg2) {
					

				}

				@Override
				public void onPageScrollStateChanged(int position) {

					

				}
			});
			return mView;
		}
	public void onActivityCreated(Bundle savedInstanceState) {

		super.onActivityCreated(savedInstanceState);

		ivRight.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				((SlidingActivity) getActivity()).showRight();
			}
		});
	}
	public boolean isFirst() {
		if (mPager.getCurrentItem() == 0)
			return true;
		else
			return false;
	}
	public boolean isEnd() {
		if (mPager.getCurrentItem() == pagerItemList.size() - 1)
			return true;
		else
			return false;
	}
   
   public class MyAdapter extends FragmentPagerAdapter {
		public MyAdapter(FragmentManager fm) {
			super(fm);
		}

		@Override
		public int getCount() {
			return pagerItemList.size();
		}

		@Override
		public Fragment getItem(int position) {

			Fragment fragment = null;
			if (position < pagerItemList.size())
				fragment = pagerItemList.get(position);
			else
				fragment = pagerItemList.get(0);

			return fragment;

		}
	}

	private MyPageChangeListener myPageChangeListener;

	public void setMyPageChangeListener(MyPageChangeListener l) {

		myPageChangeListener = l;

	}

	public interface MyPageChangeListener {
		public void onPageSelected(int position);
	}

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
//		case R.id.tvCountry:
//			if(linearlayout1.isShown()){
//				 keyboardHideAnim = AnimationUtils.loadAnimation(
//							context, R.anim.keyboard_out);
//				linearlayout1.setAnimation(keyboardHideAnim);
//				linearlayout1.setVisibility(View.GONE);
//			}else{
//				 keyboardShowAnim = AnimationUtils
//							.loadAnimation(context,
//									R.anim.keyboard_in);
//			linearlayout1.setAnimation(keyboardShowAnim);
//			linearlayout1.setVisibility(View.VISIBLE);
//			}
//			break;
		case R.id.bt1:
			currentFragmentIndex=0;
			break;
		case R.id.bt2:
			currentFragmentIndex=1;
			break;
		case R.id.bt3:
			currentFragmentIndex=2;
			break;
		case R.id.bt4:
			currentFragmentIndex=3;
			break;
		default:
			break;
		}
		mPager.setCurrentItem(currentFragmentIndex);
		updateButtonTextColor();
	}
	private void updateButtonTextColor() {
		// TODO Auto-generated method stub
//		for (int i = 0; i < btnArray.length; i++) {
//			if (i == currentFragmentIndex) {
//				btnArray[i].setTextColor(0x7f0075);
//			} else {
//				btnArray[i].setTextColor(0xFFFFFF);
//
//			}
//		}
	}
}
