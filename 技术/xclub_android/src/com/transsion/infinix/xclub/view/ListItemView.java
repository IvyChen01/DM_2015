package com.transsion.infinix.xclub.view;


import android.content.Context;  
import android.graphics.PointF;
import android.util.AttributeSet;  
import android.util.Log;  
import android.view.MotionEvent;  
import android.view.View;  
import android.view.ViewGroup;
import android.widget.LinearLayout;  
import android.widget.Scroller;  
   
public class ListItemView extends LinearLayout {  
  
     private Scroller mScroller;// ��������  
     private float mLastMotionX;// ��ס�ϴδ�������λ��  
     private int deltaX;  
     private int back_width;  
     private float downX;
     private PointF pressPoint = new PointF();
	private OnSingleTouchListener singleTouchListener;
   
     public ListItemView(Context context) {  
         this(context, null);  
     }  
   
    public ListItemView(Context context, AttributeSet attrs) {  
         super(context, attrs);  
         
         init(context);  
     }  
   
     private void init(Context context) {  
         mScroller = new Scroller(context);  
     }  
   
     @Override  
     public void computeScroll() {  
         if (mScroller.computeScrollOffset()) {// �����Scroller�еĵ�ǰx,yλ��  
             scrollTo(mScroller.getCurrX(), mScroller.getCurrY());  
             postInvalidate();  
         }  
     }  
   
     @Override  
     protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {  
         super.onMeasure(widthMeasureSpec, heightMeasureSpec);  
         int count = getChildCount();  
         for (int i = 0; i < count; i++) {  
             measureChild(getChildAt(i), widthMeasureSpec, heightMeasureSpec);  
             if (i == 1) {  
                 back_width = getChildAt(i).getMeasuredWidth();  
             }  
         }  
   
     }  
   
     @Override  
     public boolean onTouchEvent(MotionEvent event) {  
         int action = event.getAction();  
         float x = event.getX();  
         switch (action) {  
         case MotionEvent.ACTION_DOWN:  
             Log.e("test", "item  ACTION_DOWN"); 
             pressPoint.x = event.getX();
 			 pressPoint.y = event.getY();
             mLastMotionX = x;  
             downX = x;  
             break;  
         case MotionEvent.ACTION_MOVE:  
             Log.e("test", back_width + "  item  ACTION_MOVE  " + getScrollX());  
             deltaX = (int) (mLastMotionX - x);  
             mLastMotionX = x;  
             int scrollx = getScrollX() + deltaX;  
             if (scrollx > 0 && scrollx < back_width) {  
                 scrollBy(deltaX, 0);  
             } else if (scrollx > back_width) {  
                 scrollTo(back_width, 0);  
             } else if (scrollx < 0) {  
                scrollTo(0, 0);  
             }  
             break;  
         case MotionEvent.ACTION_UP:
             Log.e("test", "item  ACTION_UP");  
             int scroll = getScrollX();  
             if (scroll > back_width / 2) {  
                 scrollTo(back_width, 0);  
             } else {  
                 scrollTo(0, 0);  
             }  
             if (Math.abs(x - downX) < 5) {// ������ݵ���������ж��Ƿ���itemClick  
                 return false;  
             }  
             break;  
         case MotionEvent.ACTION_CANCEL:  
             scrollTo(0, 0);  
             break;  
         }  
         return true;  
     }  
     public interface OnSingleTouchListener{
 		public void onSingleTouch(View v);
 	}
 	
 	public void addOnSingleTouchListener(OnSingleTouchListener singleTouchListener) {
 		this.singleTouchListener = singleTouchListener;
 	}
     
 
     @Override  
     protected void onLayout(boolean changed, int l, int t, int r, int b) {  
         int margeLeft = 0;  
         int size = getChildCount();  
         for (int i = 0; i < size; i++) {  
             View view = getChildAt(i);  
             if (view.getVisibility() != View.GONE) {  
                 int childWidth = view.getMeasuredWidth();  
                 // ���ڲ��Ӻ��Ӻ�������  
                 view.layout(margeLeft, 0, margeLeft + childWidth,  
                         view.getMeasuredHeight());  
                 margeLeft += childWidth;  
             }  
         }  
     } 
     @Override
    public boolean onInterceptHoverEvent(MotionEvent event) {
    	// TODO Auto-generated method stub
    	return super.onInterceptHoverEvent(event);
    }
   }  

