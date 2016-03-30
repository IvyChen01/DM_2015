package com.trassion.newstop.tool;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.NetworkInfo.State;

public class NetworkUtil {
	
    /**
     * 网络是否成功连接
     * @param context 上下文
     * @return boolean
     * @see [lei、类#方法、类#成员]
     */
	public static boolean isOnline(Context context){
		boolean isOnline=false;
		ConnectivityManager manager=(ConnectivityManager)context.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo networkInfo=manager.getActiveNetworkInfo();
		if(networkInfo!=null){
			if(networkInfo.isConnected()){
				
				isOnline=true;
			}
		}
		return isOnline;
	}
	 /**
     * 是否为wifi网络
     * @param context
     * @return
     */
	public static boolean isWifi(Context context) {
		boolean ret = false; 
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		State wifi = manager.getNetworkInfo(ConnectivityManager.TYPE_WIFI)
				.getState();
		if (wifi == State.CONNECTED || wifi == State.CONNECTING) {
			ret = true;
		}
		return ret;
	}
}
