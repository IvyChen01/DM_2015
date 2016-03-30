package com.trassion.newstop.adapter;

import java.util.ArrayList;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.app.FragmentTransaction;
import android.view.ViewGroup;

public class NewsFragmentpagerAdapter extends FragmentPagerAdapter {
	private ArrayList<Fragment>fragments;
	private FragmentManager fm;

	public NewsFragmentpagerAdapter(FragmentManager fm) {
		super(fm);
		this.fm=fm;
	}
	public  NewsFragmentpagerAdapter(FragmentManager fm,ArrayList<Fragment>fragments){
		super(fm);
		this.fm=fm;
		this.fragments=fragments;
	}
	

	@Override
	public Fragment getItem(int position) {
		// TODO Auto-generated method stub
		return fragments.get(position);
	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return fragments.size();
	}
    public void setFragments(ArrayList<Fragment>fragments){
    	if(this.fragments!=null){
    		FragmentTransaction ft=fm.beginTransaction();
    		for(Fragment f:this.fragments){
    			ft.remove(f);
    		}
    		ft.commit();
    		ft=null;
    		fm.executePendingTransactions();
    	}
    	this.fragments=fragments;
    	notifyDataSetChanged();
    }
    @Override
    public Object instantiateItem(ViewGroup container, int position) {
    	Object obj=super.instantiateItem(container, position);
    	return obj;
    }
}
