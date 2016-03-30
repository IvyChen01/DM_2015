package com.transsion.infinix.xclub.util;

import java.net.Inet4Address;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.util.Enumeration;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.telephony.TelephonyManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;

/**
 * ������
 * 
 * @author ok
 * 
 */
public class SystemTool {
	/**
	 * ��ȡImei��
	 * 
	 * @return
	 */
	public static String getImei(Activity context) {
		String imei = "";
		TelephonyManager telMgr = (TelephonyManager) context
				.getSystemService(Activity.TELEPHONY_SERVICE);
		imei = telMgr.getDeviceId();
		return imei;
	}

	/**
	 * ��ȡImei��
	 * 
	 * @return
	 */
	public static String getImei(Context context) {
		String imei = "";
		TelephonyManager telMgr = (TelephonyManager) context
				.getSystemService(Activity.TELEPHONY_SERVICE);
		imei = telMgr.getDeviceId();
		return imei;
	}

	/**
	 * �ж��Ƿ���wap���磬�����wap���磬����Ҫ������Agreement.proxy=true
	 * 
	 * @return
	 */

	/**
	 * ��ȡImei��
	 * 
	 * @return
	 */

	public static boolean IsWapNet(Activity context) {
		ConnectivityManager connectivityManager;
		connectivityManager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		boolean flag = false;
		try {
			String wapinfo = connectivityManager.getActiveNetworkInfo()
					.getExtraInfo();
			wapinfo = wapinfo.toLowerCase();
			int i = wapinfo.indexOf(":");
			if (i > 1) {
				wapinfo = wapinfo.substring(0, i);
			}
			if (wapinfo.endsWith("wap")) {
				flag = true;
			}
		} catch (Exception e) {
			// TODO: handle exception
		}
		return flag;

	}

	public boolean checkNetworkType(Context context) {

		ConnectivityManager mConnectivity = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		TelephonyManager mTelephony = (TelephonyManager) context
				.getSystemService(context.TELEPHONY_SERVICE);
		// ����������ӣ������������ã��Ͳ���Ҫ��������������
		NetworkInfo info = mConnectivity.getActiveNetworkInfo();

		if (info == null || !mConnectivity.getBackgroundDataSetting()) {
			return false;
		}

		// �ж������������ͣ�ֻ����3G��wifi�����һЩ���ݸ��¡�
		int netType = info.getType();
		int netSubtype = info.getSubtype();

		if (netType == ConnectivityManager.TYPE_WIFI) {
			return info.isConnected();
		} else if (netType == ConnectivityManager.TYPE_MOBILE
				&& netSubtype == TelephonyManager.NETWORK_TYPE_UMTS
				&& !mTelephony.isNetworkRoaming()) {
			return info.isConnected();
		} else {
			return false;
		}
	}

	/**
	 * ��ȡ�ֻ�ip <br/>
	 * 
	 * @description Wang Anshu 2014��9��25�� ����9:40:52
	 * @since 1.1.0
	 * @return
	 */
	private String getPhoneIp() {
		try {
			for (Enumeration<NetworkInterface> en = NetworkInterface
					.getNetworkInterfaces(); en.hasMoreElements();) {
				NetworkInterface intf = en.nextElement();
				for (Enumeration<InetAddress> enumIpAddr = intf
						.getInetAddresses(); enumIpAddr.hasMoreElements();) {
					InetAddress inetAddress = enumIpAddr.nextElement();
					if (!inetAddress.isLoopbackAddress()
							&& inetAddress instanceof Inet4Address) {
						// if (!inetAddress.isLoopbackAddress() && inetAddress
						// instanceof Inet6Address) {
						return inetAddress.getHostAddress().toString();
					}
				}
			}
		} catch (Exception e) {
		}
		return "";
	}

	/**
	 * ��������� <br/>
	 * 
	 * @description Wang Anshu 2014��9��25�� ����10:49:02
	 * @since 1.1.0
	 * @param e
	 */
	public static void hideKeyboard(EditText e) {
		InputMethodManager imm = (InputMethodManager) e.getContext()
				.getSystemService(e.getContext().INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(e.getWindowToken(), 0);
	}

}
