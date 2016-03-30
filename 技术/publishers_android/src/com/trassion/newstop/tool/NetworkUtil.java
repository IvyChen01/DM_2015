package com.trassion.newstop.tool;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.NetworkInfo.State;

public class NetworkUtil {
	
    /**
     * �����Ƿ�ɹ�����
     * @param context ������
     * @return boolean
     * @see [lei����#��������#��Ա]
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
     * �Ƿ�Ϊwifi����
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
