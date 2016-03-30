package com.transsion.infinix.xclub.view;

import android.content.Context;
import android.util.AttributeSet;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ListView;

public class ScrollListView extends ListView {  

       private float minDis = 10;  
       private float mLastMotionX;// ��ס�ϴ�X��������λ��  
       private float mLastMotionY;// ��ס�ϴ�Y��������λ��  
       private boolean isLock = false;  
  
       public ScrollListView(Context context, AttributeSet attrs) {  
           super(context, attrs);  
       }  
    
        /** 
        * ���һ��ViewGroup��onInterceptTouchEvent()��������true��˵��Touch�¼����ػ� 
        * ��View���ٽ��յ�Touch�¼�������ת��ViewGroup�� 
        * onTouchEvent()����������Down��ʼ��֮���Move��Up����ֱ����onTouchEvent()�����д��� 
        * ��ǰ���ڴ���touch event��child view������յ�һ�� ACTION_CANCEL�� 
        * ���onInterceptTouchEvent()����false�����¼��ύ��child view���� 
        */  
       @Override  
       public boolean onInterceptTouchEvent(MotionEvent ev) {  
          if (!isIntercept(ev)) {  
              return false;  
          }  
            return super.onInterceptTouchEvent(ev);  
       }  
    
      @Override  
      public boolean dispatchTouchEvent(MotionEvent event) {  
         boolean dte = super.dispatchTouchEvent(event); 
         View view=null;
           if (MotionEvent.ACTION_UP == event.getAction() && !dte) {//onItemClick  
               int position = pointToPosition((int)event.getX(), (int)event.getY());
               if(position==0){
            	   view = getChildAt(position);
               }else{
                   view = getChildAt(position-1);
               }
               if(view!=null)
               super.performItemClick(view, position, view.getId());  
           }  
           return dte;  
       }  
  
       @Override  
       // �������¼�����������Ƶ��¼���������¼� ��ͨView  
       public boolean performClick() {  
           return super.performClick();  
       }  
  
       @Override  
       // �������¼�����������Ƶ��¼���������¼� ListView  
       public boolean performItemClick(View view, int position, long id) {  
           return super.performItemClick(view, position, id);  
       }  
  
       /** 
        * �����ListView��������item���� isLock һ���ж���item����������up֮ǰ���Ƿ���false 
        */  
       private boolean isIntercept(MotionEvent ev) {  
           float x = ev.getX();  
           float y = ev.getY();  
           int action = ev.getAction();  
           switch (action) {  
           case MotionEvent.ACTION_DOWN:  
               Log.e("test", "isIntercept  ACTION_DOWN  "+isLock);  
               mLastMotionX = x;  
               mLastMotionY = y;  
               break;  
           case MotionEvent.ACTION_MOVE:  
               Log.e("test", "isIntercept  ACTION_MOVE  "+isLock);  
               if (!isLock) {  
                   float deltaX = Math.abs(mLastMotionX - x);  
                   float deltay = Math.abs(mLastMotionY - y);  
                   mLastMotionX = x;  
                   mLastMotionY = y;  
                   if (deltaX > deltay && deltaX > minDis) {  
                       isLock = true;  
                       return false;  
                   }  
               } else {  
                   return false;  
             }  
               break;  
           case MotionEvent.ACTION_UP:  
               Log.e("test", "isIntercept  ACTION_UP  "+isLock);  
               isLock = false;  
               break;  
           case MotionEvent.ACTION_CANCEL:  
               Log.e("test", "isIntercept  ACTION_CANCEL  "+isLock);  
              isLock = false;  
               break;  
          }  
            return true;  
        }  
  
   }  

