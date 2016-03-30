package com.transsion.infinix.xclub.view;


import android.content.Context;
import android.graphics.PointF;
import android.support.v4.view.ViewPager;
import android.util.AttributeSet;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;

public class BannerPager extends ViewPager {

	 /** ����ʱ���µĵ� **/  
    PointF downP = new PointF();  
    /** ����ʱ��ǰ�ĵ� **/  
    PointF curP = new PointF();  
    OnSingleTouchListener onSingleTouchListener;  
    float pointY;
    float pointX;
    private int abc = 1;
    private float mLastMotionX;
    private float firstDownX;

    private float firstDownY;

   
    public BannerPager(Context context, AttributeSet attrs) {  
        super(context, attrs);  
        // TODO Auto-generated constructor stub  
    }  
   
    public BannerPager(Context context) {  
        super(context);  
        // TODO Auto-generated constructor stub  
    }  
   
//    @Override  
//    public boolean onInterceptTouchEvent(MotionEvent arg0) {  
//        // TODO Auto-generated method stub  
//        //�����ش����¼������λ�õ�ʱ�򣬷���true��  
//        //˵����onTouch�����ڴ˿ؼ�������ִ�д˿ؼ���onTouchEvent  
//        return true;  
//    }  
   
    @Override  
    public boolean onTouchEvent(MotionEvent arg0) {  
        // TODO Auto-generated method stub  
        //ÿ�ν���onTouch�¼�����¼��ǰ�İ��µ�����  
        curP.x = arg0.getX();  
        curP.y = arg0.getY();  
   
        if(arg0.getAction() == MotionEvent.ACTION_DOWN){  
            //��¼����ʱ�������  
            //�мǲ����� downP = curP �������ڸı�curP��ʱ��downPҲ��ı�  
            downP.x = arg0.getX();  
            downP.y = arg0.getY();  
            //�˾������Ϊ��֪ͨ���ĸ�ViewPager���ڽ��е��Ǳ��ؼ��Ĳ�������Ҫ���ҵĲ������и���  
//            getParent().requestDisallowInterceptTouchEvent(true);  
        }  
   
        if(arg0.getAction() == MotionEvent.ACTION_MOVE){  
        	pointY=arg0.getY();
        	pointX=arg0.getX();
        	if(Math.abs(pointY-downP.y)>5 && Math.abs(pointX-downP.x)<5){
        		getParent().requestDisallowInterceptTouchEvent(false); 
        	}else{
            //�˾������Ϊ��֪ͨ���ĸ�ViewPager���ڽ��е��Ǳ��ؼ��Ĳ�������Ҫ���ҵĲ������и���  
            getParent().requestDisallowInterceptTouchEvent(true); 
        	}
           
        }  
   
        if(arg0.getAction() == MotionEvent.ACTION_UP){  
            //��upʱ�ж��Ƿ��º����ֵ�����Ϊһ����  
            //�����һ���㣬��ִ�е���¼����������Լ�д�ĵ���¼���������onclick  
            if(downP.x==curP.x && downP.y==curP.y){  
                onSingleTouch();  
                return true;  
            }  
        }  
   
        return super.onTouchEvent(arg0);  
    }  
   
        /** 
     * ���� 
     */  
    public void onSingleTouch() {  
        if (onSingleTouchListener!= null) {  
   
            onSingleTouchListener.onSingleTouch();  
        }  
    }  
   
    /** 
     * ��������¼��ӿ� 
     * @author wanpg 
     * 
     */  
    public interface OnSingleTouchListener {  
        public void onSingleTouch();  
    }  
   
    public void setOnSingleTouchListener(OnSingleTouchListener onSingleTouchListener) {  
        this.onSingleTouchListener = onSingleTouchListener;  
    }  
    @Override
    public boolean dispatchTouchEvent(MotionEvent ev) {
    	 final float x = ev.getX();

    	    switch (ev.getAction()) {

    	    case MotionEvent.ACTION_DOWN:

    	    getParent().requestDisallowInterceptTouchEvent(true);

    	    abc=1;

    	    mLastMotionX=x;

    	    break;

    	    case MotionEvent.ACTION_MOVE:
    	    if (abc == 1) {

    	    if (Math.abs(pointY-downP.y)>5&&x - mLastMotionX > 5 && getCurrentItem() == 0) {

    	    abc = 0;

    	    getParent().requestDisallowInterceptTouchEvent(false);

    	    }

    	    if (Math.abs(pointY-downP.y)>5&&x - mLastMotionX < -5 && getCurrentItem() == getAdapter().getCount()-1) {

    	    abc = 0;

    	    getParent().requestDisallowInterceptTouchEvent(false);

    	    }
    	    if(Math.abs(pointY-downP.y)>5 && Math.abs(pointX-downP.x)<5){
        		getParent().requestDisallowInterceptTouchEvent(false); 
        	}

    	    }

    	    break;

    	    case MotionEvent.ACTION_UP:

    	    case MotionEvent.ACTION_CANCEL:

    	    getParent().requestDisallowInterceptTouchEvent(false);

    	    break;

    	    }

    	    return super.dispatchTouchEvent(ev);

    }
   
}  