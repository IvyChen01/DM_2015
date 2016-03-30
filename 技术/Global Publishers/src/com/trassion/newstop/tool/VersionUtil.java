package com.trassion.newstop.tool;



import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.util.UUID;

import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.activity.WelcomeActivity;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopVersionBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.download.DownloadService;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.view.SelectDialog;

import android.app.AlertDialog;
import android.app.Dialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.graphics.Color;
import android.net.Uri;
import android.os.Environment;
import android.os.Handler;
import android.os.Looper;
import android.provider.Settings.Secure;
import android.telephony.TelephonyManager;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.widget.CheckBox;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.RemoteViews;


/**
 * 
 * @ClassName: VersionUtil
 * @Description: TODO(�汾������)
 * @author zx
 * @date 2014-2-20 ����3:40:33
 * 
 */
public class VersionUtil implements UICallBackInterface,DialogInterface.OnClickListener {

	private Context context;

	// private Handler handler;

	/**** ���ĸ�ҳ���������� ***/
	private String pageName;

	/*** �汾�� ****/
	private String version;

	private String isIgnoreSpf;
	private Handler handler;


	private String url;

	private NewsTopInfoListRequest request;

	private HttpTransAgent mHttpAgent;

	private NewsTopVersionBeanresponse response;


	public VersionUtil(Context context,Handler handler) {
		this.context = context;
		this.version = getVersionNo();
		this.handler=handler;
		
		request = new NewsTopInfoListRequest(context);
		mHttpAgent = new HttpTransAgent(context,VersionUtil.this);
	}

//	public VersionUtil(Context context, String pageName) {
//		this.context = context;
//		this.version = getVersionNo();
//		this.pageName = pageName;
//	}

	public VersionUtil() {
		this.version = getVersionNo();
	}

	/**
	 * @throws IOException
	 * @throws MalformedURLException
	 * 
	 * @Title: checkVersionNo
	 * @Description: TODO(���汾���Ƿ���Ҫ����,�������°�,����ʾ;����֮;)
	 * @param �趨�ļ�
	 * @return void ��������
	 * @throws ioe
	 */
	public void checkVersionNo(String pageName) throws IOException {
	    
	    this.pageName=pageName;
	    
		/**** �����������ֻ�ر�����Ϣ.ͨ�����VERSION����𱣴��ֵ,key=value ��ʽ���� ****/
//		SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
//				context.MODE_WORLD_READABLE);
//		isIgnoreSpf = spf.getString("isIgnore", "");

		// if(�û�����Ĺ���ҳ���ֶ����汾����)
	    if (NetworkUtil.isOnline(context)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListByGetVersionRequest(mHttpAgent, Utils.getPhoneIMEI(context),Constants.HTTP_GET_VERSION);
		} else {
			Toast.makeText(context, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
	}

	/**
	 * ��ȡ�汾��
	 * 
	 * @return ��ǰӦ�õİ汾��
	 */
	public String getVersionNo() {
		// ��ȡpackagemanager��ʵ��
		PackageManager packageManager = context.getPackageManager();
		// getPackageName()���㵱ǰ��İ���0����ǻ�ȡ�汾��Ϣ
		PackageInfo packInfo;
		String version = null;
		try {
			packInfo = packageManager.getPackageInfo(context.getPackageName(),
					0);
			version = packInfo.versionName;
		} catch (NameNotFoundException e) {
			e.printStackTrace();
		}

		return version;
	}

	/**
	 * @Title: getMachineCode
	 * @Description: TODO(��ȡ������)
	 * @param @return �趨�ļ�
	 * @return String ��������
	 */
	public String getMachineCode() {
		Secure.getString(context.getContentResolver(), Secure.ANDROID_ID);

		TelephonyManager tm = (TelephonyManager) context
				.getSystemService(Context.TELEPHONY_SERVICE);

		String tmDevice, tmSerial, androidId, uniqueId = null;
		try {
			tmDevice = "" + tm.getDeviceId();

			tmSerial = "" + tm.getSimSerialNumber();

			androidId = ""
					+ android.provider.Settings.Secure.getString(
							context.getContentResolver(),
							android.provider.Settings.Secure.ANDROID_ID);

			UUID deviceUuid = new UUID(androidId.hashCode(),
					((long) tmDevice.hashCode() << 32) | tmSerial.hashCode());

			uniqueId = deviceUuid.toString();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return uniqueId;
	}

	/****** ��װapk�ļ� ******/
	private void installApk(String filename) {
		File file = new File(filename);
		Intent intent = new Intent();
		intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
		intent.setAction(Intent.ACTION_VIEW); // �����ҳ��Action(����)
		String type = "application/vnd.android.package-archive";
		intent.setDataAndType(Uri.fromFile(file), type); // �����������
		context.startActivity(intent);
		clearNotification();

	}

	/***** ��Ļ������Ϣ��ʾ ****/
	public void titlePrompt(int downLoadSize, int fileLength) {
		// ����һ��NotificationManager������
		NotificationManager notificationManager = (NotificationManager) context
				.getSystemService(context.NOTIFICATION_SERVICE);

		// ����Notification�ĸ�������
		@SuppressWarnings("deprecation")
		Notification notification = new Notification(
				R.drawable.ic_launcher, "update Global Publishers", System.currentTimeMillis());
		notification.contentView = new RemoteViews(context.getPackageName(),
				R.layout.notification);

		// ʹ��notification.xml�ļ���VIEW
		notification.contentView.setProgressBar(R.id.pb, 100, 0, true);

		// FLAG_AUTO_CANCEL ��֪ͨ�ܱ�״̬�������ť������
		// FLAG_NO_CLEAR ��֪ͨ���ܱ�״̬�������ť������
		// FLAG_ONGOING_EVENT ֪ͨ��������������
		// FLAG_INSISTENT �Ƿ�һֱ���У���������һֱ���ţ�֪���û���Ӧ
		notification.flags |= Notification.FLAG_AUTO_CANCEL;
		notification.flags |= Notification.FLAG_NO_CLEAR;
		// notification.flags |= Notification.FLAG_ONGOING_EVENT; //
		// ����֪ͨ�ŵ�֪ͨ����"Ongoing"��"��������"����
		// notification.flags |= Notification.FLAG_NO_CLEAR; //
		// �����ڵ����֪ͨ���е�"���֪ͨ"�󣬴�֪ͨ��������FLAG_ONGOING_EVENTһ��ʹ��
		// notification.flags |= Notification.FLAG_SHOW_LIGHTS;
		// DEFAULT_ALL ʹ������Ĭ��ֵ�������������𶯣������ȵ�
		// DEFAULT_LIGHTS ʹ��Ĭ��������ʾ
		// DEFAULT_SOUNDS ʹ��Ĭ����ʾ����
		// DEFAULT_VIBRATE ʹ��Ĭ���ֻ��𶯣������<uses-permission
		// android:name="android.permission.VIBRATE" />Ȩ��
		notification.defaults = Notification.DEFAULT_LIGHTS;
		// ����Ч����
		// notification.defaults=Notification.DEFAULT_LIGHTS|Notification.DEFAULT_SOUND;
		notification.ledARGB = Color.BLUE;
		notification.ledOnMS = 5000; // ����ʱ�䣬����

		int result = downLoadSize * 100 / fileLength;
		// ����֪ͨ���¼���Ϣ
		CharSequence contentTitle = "update Global Publishers"; // ֪ͨ������
		notification.contentView.setImageViewResource(R.id.ivTitle,
				R.drawable.ic_launcher);
		notification.contentView.setTextViewText(R.id.down_tv, "progress" + result
				+ "%");
		// CharSequence contentText = result + "%"; // ֪ͨ������
		Intent notificationIntent = new Intent(context, WelcomeActivity.class); // �����֪ͨ��Ҫ��ת��Activity
		PendingIntent contentItent = PendingIntent.getActivity(context, 0,
				notificationIntent, 0);
		// notification.setLatestEventInfo(context, contentTitle, null,
		// contentItent);
		notification.contentIntent = contentItent;

		// ��Notification���ݸ�NotificationManager
		notificationManager.notify(0, notification);

	}

	/**** ɾ����Ļ����֪ͨ ****/
	private void clearNotification() {
		// ������ɾ��֮ǰ���Ƕ����֪ͨ
		NotificationManager notificationManager = (NotificationManager) context
				.getSystemService(context.NOTIFICATION_SERVICE);
		notificationManager.cancel(0);
		/**** �����������ֻ�ر�����Ϣ.ͨ�����VERSION����𱣴��ֵ,key=value ��ʽ���� ****/
//		SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
//				context.MODE_WORLD_READABLE);
//		Editor editor = spf.edit();
//		editor.putString("isIgnore", "0");
//		editor.commit();

	}

	/**** ��ʾ������ʾ�� (�Ѿ����µ���ʾ����,�������) **/
	@Deprecated
	public void showDailog(final String updateUrl, final String apkName,
			final String update_description) {
//		new SelectDialog(context).VersionChangeDialog().show();
		if(false){
			ToastManager.showShort(context, "Is being updated ");
		}else{
	    final Dialog dia = new Dialog(context, R.style.MDialog_load);
	    LayoutInflater factory = LayoutInflater.from(context);
	    View view = factory.inflate(R.layout.update_dialog, null);
	    dia.addContentView(view, new LayoutParams(LayoutParams.MATCH_PARENT,
                LayoutParams.MATCH_PARENT));
	    url=updateUrl;
	    try {
			dia.show();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	    
//		final Runnable downloadRun = downloadAPKFile(updateUrl, apkName,
//				update_description);

		TextView tvupdate_content = (TextView) view
				.findViewById(R.id.tvUpdate_content);
		tvupdate_content.setText(update_description);

		/********* �Ƿ���Ըð汾 **********/
		final CheckBox cbUpdate_id_check = (CheckBox) view
				.findViewById(R.id.cbUpdate_id_check);
		
		
		
		//              �ж��Ƿ�ѡ��
		
		SharedPreferences spf = context.getSharedPreferences(Constants.VERSION,
				context.MODE_WORLD_READABLE);
		String versionnumber = spf.getString("versionnumber", "");
		if(!TextUtils.isEmpty(versionnumber)){
		    if(NewsApplication.NEWVERSIONNUMBER.equals(versionnumber)){// ���ǰ�汾�� ��������°汾��ͬ ���ʾ ѡ��
		        cbUpdate_id_check.setChecked(true);
		    }
		}

		/******* �Ժ���˵ *******/
		view.findViewById(R.id.update_id_cancel).setOnClickListener(
				new OnClickListener() {

					@Override
					public void onClick(View v) {
					    //    �ж��Ƿ�ѡ�У���� ѡ�� �򱣴� ����˷��ص� �汾��
					    
//					    SharedPreferences spf = context.getSharedPreferences(
//                                Constant.VERSION, context.MODE_WORLD_READABLE+context.MODE_WORLD_WRITEABLE);
//					    Editor editor = spf.edit();
//					    
//					    if(cbUpdate_id_check.isChecked()){
//					        editor.putString("versionnumber",MasterApplication.getInstanse().NEWVERSIONNUMBER);
//					    }else{
//					        editor.putString("versionnumber",null);
//					    }
//						
//						editor.commit();
						// ���ط����°汾�Ĵ���
                        dia.dismiss();
					}
				});

		/****** �û�ѡ���������� ******/
		view.findViewById(R.id.update_id_ok).setOnClickListener(
				new OnClickListener() {

					@Override
					public void onClick(View v) {
						// �������̷߳��ʷ����������°汾��apk
						// new Thread(downloadRun).start();
						Log.e("<<<<<<<<<<<<<<<<<<<<", "��ʼ����.........");
						// �������̷߳��ʷ����������°汾��apk
//						new Thread(downloadRun).start();
						// ���ط����°汾�Ĵ���
						dia.dismiss();
						PreferenceUtils.setPrefBoolean(context, "isDownloadName", false);
						Intent intent = new Intent(context, DownloadService.class);
		                //�������ص�ַ
		                intent.putExtra("url", url);
		                intent.putExtra("downloadName", "New update");
		                context.startService(intent);
						
					}
				});
		}
	}

	/**
	 * 
	 * @Title: downloadAPKFile
	 * @Description: TODO(����APK)
	 * @param @param updateUrl
	 * @param @param apkName
	 * @param @param update_description �趨�ļ�
	 * @return void ��������
	 * @throws null
	 */
	public Runnable downloadAPKFile(final String updateUrl,
			final String apkName, final String update_description) {
		final Runnable downloadRun = new Runnable() {
			@Override
			public void run() {
				// �����ļ� ���Ŀ�ĵ�
				String downloadPath = Environment.getExternalStorageDirectory()
						.getPath() + "/itel";
				File file = new File(downloadPath);
				if (!file.exists()) {
					file.mkdir();
				}
				String url =updateUrl.trim();
				HttpGet httpGet = new HttpGet(url);
				try {
					HttpResponse httpResponse = new DefaultHttpClient()
							.execute(httpGet);
					if (httpResponse.getStatusLine().getStatusCode() == 200) {
						InputStream is = httpResponse.getEntity().getContent();
						int fileLength = (int) httpResponse.getEntity()
								.getContentLength();
						int downLoadFileSize = 0;

						// Log.e("�ļ���С", "======" + fileLength);

						// ��ʼ����apk�ļ�,�����Ҫ���
						FileOutputStream fos = new FileOutputStream(
								downloadPath + "/" + apkName + ".apk");
						byte[] buffer = new byte[8192];
						int count = 0;
						while ((count = is.read(buffer)) != -1) {
							downLoadFileSize += count;
							fos.write(buffer, 0, count);
							// ��Ļ������ʾ���ؽ����Ϣ
							titlePrompt(downLoadFileSize, fileLength);
						}
						fos.close();
						is.close();
						// ��װ apk �ļ�
						installApk(downloadPath + "/" + apkName + ".apk");
					} else {
						/****
						 * ��������һ����ͨ�����߳���,����ʵ��ui����,Ҫ������ʾ�����Looper.prepare();
						 * ��Looper.loop();
						 ****/
						Looper.prepare();
						ToastManager.showShort(context, "Server update address error!");
						Looper.loop();
					}
					// �Ƿ�����Ļ������ʾ

				} catch (Exception e) {
				}

			}
		};
		return downloadRun;
	}

	public void onBegin() {
	}
	/**
	 * 
	 * @Title: updateDailog
	 * @Description: TODO(�ڶ��ְ汾������ʾ��)
	 * @param �趨�ļ�
	 * @return void ��������
	 * @throws null
	 */
//	public void updateDailog(final String updateUrl, final String apkName,
//			final String update_description) {
//	     new SelectDialog(context).VersionChangeDialog().show();
//	    DialogUtil dialog = new DialogUtil.Builder(context)
//				.setMessage(update_description)
//				.setTitle("Found a new version")
//				.setNegativeButton("Let's talk it later",
//						new DialogInterface.OnClickListener() {
//
//							@Override
//							public void onClick(DialogInterface dialog,
//									int which) {
//								dialog.dismiss();
//								/****
//								 * �����������ֻ�ر�����Ϣ.ͨ�����VERSION����𱣴��ֵ,key=value
//								 * ��ʽ����
//								 ****/
//								SharedPreferences spf = context
//										.getSharedPreferences(Constant.VERSION,
//												context.MODE_WORLD_READABLE);
//								Editor editor = spf.edit();
//								// Log.e("@@@@@@@@@@@@", "==" + isChecked +
//								// "===");
//								editor.putString("isIgnore", "1");
//								// Log.e("@@@@@@@@@@@@",
//								// "=="+isChecked+"==="+usernameSpf+"===");
//								editor.commit();
//								
//								
//							}
//						})
//				.setPositiveButton("update now",
//						new DialogInterface.OnClickListener() {
//
//							@Override
//							public void onClick(DialogInterface dialog,
//									int which) {
//								// TODO Auto-generated method stub
//								Runnable downloadRun = downloadAPKFile(
//										updateUrl, apkName, update_description);
//								// �������̷߳��ʷ����������°汾��apk
//								new Thread(downloadRun).start();
//
//								/****
//								 * �����������ֻ�ر�����Ϣ.ͨ�����VERSION����𱣴��ֵ,key=value
//								 * ��ʽ����
//								 ****/
//								SharedPreferences spf = context
//										.getSharedPreferences(Constant.VERSION,
//												context.MODE_WORLD_READABLE);
//								Editor editor = spf.edit();
//								// Log.e("@@@@@@@@@@@@", "==" + isChecked +
//								// "===");
//								editor.putString("isIgnore", "0");
//								// Log.e("@@@@@@@@@@@@",
//								// "=="+isChecked+"==="+usernameSpf+"===");
//								editor.commit();
//							}
//						}).create();
//		dialog.setCancelable(false);
//		dialog.show();
//	}

	/**
	 * 
	 * @Title: compulsoryUpdateDailog
	 * @Description: TODO(��ʾ�û������°汾,��ǿ���û�����)
	 * @param @param updateUrl
	 * @param @param apkName
	 * @param @param update_description �趨�ļ�
	 * @return void ��������
	 * @throws null
	 */
//	@SuppressWarnings("unused")
//	private void compulsoryUpdateDailog(final String updateUrl,
//			final String apkName, final String update_description) {
//	    DialogUtil dialog = new DialogUtil.Builder(context)
//				.setMessage(update_description)
//				.setTitle("Found a new version")
//				.setPositiveButton("update now",
//						new DialogInterface.OnClickListener() {
//
//							@Override
//							public void onClick(DialogInterface dialog,
//									int which) {
//							    
//							    Intent intent = new Intent(context, DownloadService.class);
//		                        //�������ص�ַ
//		                        intent.putExtra("url", updateUrl);
//		                        intent.putExtra("downloadName", "new update");
//		                        context.startService(intent);
//		                        handler.sendEmptyMessage(Constant.RETURNWEHLCOME);
		                        
								// TODO Auto-generated method stub
//								Runnable downloadRun = downloadAPKFile(
//										updateUrl, apkName, update_description);
								// �������̷߳��ʷ����������°汾��apk
//								new Thread(downloadRun).start();

								/****
								 * �����������ֻ�ر�����Ϣ.ͨ�����VERSION����𱣴��ֵ,key=value
								 * ��ʽ����
								 ****/
//								SharedPreferences spf = context
//										.getSharedPreferences(Constant.VERSION,
//												context.MODE_WORLD_READABLE);
//								Editor editor = spf.edit();
//								// Log.e("@@@@@@@@@@@@", "==" + isChecked +
//								// "===");
//								editor.putString("isIgnore", "0");
//								// Log.e("@@@@@@@@@@@@",
//								// "=="+isChecked+"==="+usernameSpf+"===");
//								editor.commit();
//								// ��ʾ�û����ڸ���,�������û�����
//								ProgressDialog progressDialog = new ProgressDialog(
//										context);
//								progressDialog.setMessage("���ڸ��£����Ե�...");
//								progressDialog
//										.setProgressStyle(ProgressDialog.STYLE_SPINNER);
//								progressDialog.setCancelable(false);
//								progressDialog.show();
//							}
//						}).create();
//		dialog.setCancelable(false);
//		dialog.show();
//	}

	public void onNetworkNotConnection() {
	    handler.sendEmptyMessage(Constants.RETURNWEHLCOME);

	}

	@Override
	public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
		    response=(NewsTopVersionBeanresponse)bean;
		    String versionstr = response.getVersion();
			NewsApplication.NEWVERSIONNUMBER = versionstr;
			NewsApplication.versionUrl=response.getApkUrl();
			NewsApplication.versionLog=response.getLog();
			if (!version.equals(versionstr)) {
				String updateUrl = response.getApkUrl();
//				String update_level = jo.getString("update_level");
				// if(null==pageName){
//				if ("true".equals(update_level)) {
//					// ǿ�Ƹ���
//					compulsoryUpdateDailog(updateUrl, apkName,
//							update_description);
//					return;
//				} else {
					    
//					    MasterApplication.versionBean = versionBean;
					    
					   String versionnumber=PreferenceUtils.getPrefString(context, "versionnumber", "");
					    
					    if(pageName.equals(WelcomeActivity.class.getSimpleName())){
					        
					        if(!TextUtils.isEmpty(versionnumber)){
                                if(NewsApplication.NEWVERSIONNUMBER.equals(versionnumber)){
//                                    MasterApplication.versionBean=null;
                                }
                            }
					        
					        // ����Ǵ� ��ӭ�������������Ҫ���� �Զ�������ʾ��
					        handler.sendEmptyMessage(Constants.RETURNWEHLCOME);
					        return;
					    }else if(pageName.equals(WelcomeActivity.class.getSimpleName())){
					        
					        if(!TextUtils.isEmpty(versionnumber)){
                                if(!NewsApplication.NEWVERSIONNUMBER.equals(versionnumber)){
                                    new VersionUtil(context, null).showDailog(response.getApkUrl(), 
                                            "Global Publishers", "");
                                }
                            }
					        
					    }else{
					        handler.sendEmptyMessage(Constants.RETURNWEHLCOME);
					        
//					        if(!TextUtils.isEmpty(versionnumber)){
//                                if(!getVersionNo().equals(versionnumber)){
//                                    new VersionUtil(context, null).showDailog(versionBean.getUpdateUrl(), 
//                                            versionBean.getApkName(), versionBean.getUpdate_description());
//                                }
//                            }
                            return;
					    }
					    return;
//					}
//				}
				 }
			handler.sendEmptyMessage(Constants.RETURNNOWEHLCOME);
				// ��ʾ�û������°汾
				// showDailog(updateUrl, apkName,
				// update_description);
			return;
		} 

	@Override
	public void RequestError(int errorFlag, String errorMsg) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onClick(DialogInterface dialog, int which) {
		switch (which) {
		case 0:
			PreferenceUtils.setPrefString(context,"isIgnore", "1");
			break;
		case 1:
			PreferenceUtils.setPrefBoolean(context, "isDownloadName", false);
			Intent intent = new Intent(context, DownloadService.class);
            //�������ص�ַ
            intent.putExtra("url", url);
            intent.putExtra("downloadName", "New update");
            context.startService(intent);
		default:
			break;
		}
		
	}

}
