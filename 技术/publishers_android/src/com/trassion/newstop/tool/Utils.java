package com.trassion.newstop.tool;



import com.trassion.newstop.activity.R;

import android.app.Activity;
import android.content.Context;
import android.os.Build;
import android.telephony.TelephonyManager;
import android.util.DisplayMetrics;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ListAdapter;
import android.widget.ListView;

public class Utils {
	
	/**
	 * �ж��ַ��Ƿ�Ϊ��
	 */
	public static boolean isEmpty(String str) {
		return (str == null|| str.equals("null") ||str.equals("")|| str
				.equals("null null"));//
	}
	
	public static final boolean isNotEmpty(String text) {
		if (null != text && !"".equals(text.trim())) {
			return true;
		} else {
			return false;
		}
	}
     /**��ȡ��Ļ�Ŀ��  */
	 public final static int getWindowsWidth(Activity activity){
		 DisplayMetrics dm=new DisplayMetrics();
		 activity.getWindowManager().getDefaultDisplay().getMetrics(dm);
		 return dm.widthPixels;
	 }
	 /**
		 * ��̬���� ListView�ĸ߶�
		 * 
		 * @param listView
		 */
	 public static void setListViewHeightBasedOnChildren(ListView listView) {   
	        // ��ȡListView��Ӧ��Adapter   
	        ListAdapter listAdapter = listView.getAdapter();   
	        if (listAdapter == null) {   
	            return;   
	        }   
	   
	        int totalHeight = 0;   
	        for (int i = 0, len = listAdapter.getCount(); i < len; i++) {   
	            // listAdapter.getCount()������������Ŀ   
	            View listItem = listAdapter.getView(i, null, listView);   
	            // ��������View �Ŀ��   
	            listItem.measure(0, 0);    
	            // ͳ������������ܸ߶�   
	            totalHeight += listItem.getMeasuredHeight();    
	        }   
	   
	        ViewGroup.LayoutParams params = listView.getLayoutParams();   
	        params.height = totalHeight+ (listView.getDividerHeight() * (listAdapter.getCount() - 1));   
	        // listView.getDividerHeight()��ȡ�����ָ���ռ�õĸ߶�   
	        // params.height���õ����ListView������ʾ��Ҫ�ĸ߶�   
	        listView.setLayoutParams(params);   
	    }
	 /**
		 * ȥ���ı������е������ַ�
		 * @param message
		 * @return
		 */
		public static String replaceChart(String message) {
			String newMessage = "";
			if(!Utils.isEmpty(message)){
				String rex = "\\s|&.*?;";
				String res="//us";
//				newMessage = message.replace("&nbsp;", "").replace(" &nbsp;", "").replace("&quot;", "").replace("&quot;", "").replace(" &gt;","")
//			       .replace("&lt;", "").replace("&amp;", "").replace("&nbsp", "").replace("\n", "").replace("&rsaquo", "")
//				 .replace("&nbs ...", "").replace("&nbsp...", "");
				 String mMessage=message.replaceAll("\\s+",res);
				String newmessage = mMessage.replaceAll(rex, "");
				newMessage = newmessage.replaceAll(res, " ");
			}
			return newMessage;
		}
		
		/**
		 * ��ȡ�ֻ�imei��
		 * @param context
		 * @return
		 */
		public static String getPhoneIMEI(Context context){
			TelephonyManager tm = (TelephonyManager)context.getSystemService(Context.TELEPHONY_SERVICE);
	        return tm.getDeviceId();
			
		}
		
		
}
