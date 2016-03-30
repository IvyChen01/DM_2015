package com.transsion.infinix.xclub.util;



import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.util.ArrayList;
import java.util.UUID;

import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

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
import android.content.SharedPreferences.Editor;
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
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.RemoteViews;
import android.widget.TextView;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.activity.SlidingActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.bean.VersionBean;
import com.transsion.infinix.xclub.bean.VersionInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.download.DownloadService;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.trassion.infinix.xclub.R;

/**
 * 
 * @ClassName: VersionUtil
 * @Description: TODO(版本检测更新)
 * @author zx
 * @date 2014-2-20 下午3:40:33
 * 
 */
public class VersionUtil implements RequestListener<BaseEntity> {

	private Context context;

	// private Handler handler;

	/**** 从哪个页面进来的名称 ***/
	private String pageName;

	/*** 版本号 ****/
	private String version;

	private String isIgnoreSpf;
	private Handler handler;

	private MasterApplication masterApplication;

	private String url;


	public VersionUtil(Context context,Handler handler) {
		this.context = context;
		this.version = getVersionNo();
		this.handler=handler;
		masterApplication=MasterApplication.getInstanse();
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
	 * @Description: TODO(检查版本号是否需要更新,不是最新版,则提示;否则反之;)
	 * @param 设定文件
	 * @return void 返回类型
	 * @throws ioe
	 */
	public void checkVersionNo(String pageName) throws IOException {
	    
	    this.pageName=pageName;
	    
		/**** 这个组件是在手机本地保存信息.通过这个VERSION来区别保存的值,key=value 形式保存 ****/
		SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
				context.MODE_WORLD_READABLE);
		isIgnoreSpf = spf.getString("isIgnore", "");

		// if(用户点击的关于页面手动检查版本更新)
		ArrayList<BasicNameValuePair> params = new ArrayList<BasicNameValuePair>();
		params.add(new BasicNameValuePair("version", "5"));
		params.add(new BasicNameValuePair("mobile", "no"));
		params.add(new BasicNameValuePair("module", "ad"));
		BaseDao dao = new BaseDao(this, params, context, null);
		dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
				Constant.BASE_URL, "get", "false");

	}

	/**
	 * 获取版本号
	 * 
	 * @return 当前应用的版本号
	 */
	public String getVersionNo() {
		// 获取packagemanager的实例
		PackageManager packageManager = context.getPackageManager();
		// getPackageName()是你当前类的包名，0代表是获取版本信息
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
	 * @Description: TODO(获取机器码)
	 * @param @return 设定文件
	 * @return String 返回类型
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

	/****** 安装apk文件 ******/
	private void installApk(String filename) {
		File file = new File(filename);
		Intent intent = new Intent();
		intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
		intent.setAction(Intent.ACTION_VIEW); // 浏览网页的Action(动作)
		String type = "application/vnd.android.package-archive";
		intent.setDataAndType(Uri.fromFile(file), type); // 设置数据类型
		context.startActivity(intent);
		clearNotification();

	}

	/***** 屏幕顶端消息提示 ****/
	public void titlePrompt(int downLoadSize, int fileLength) {
		// 创建一个NotificationManager的引用
		NotificationManager notificationManager = (NotificationManager) context
				.getSystemService(context.NOTIFICATION_SERVICE);

		// 定义Notification的各种属性
		@SuppressWarnings("deprecation")
		Notification notification = new Notification(
				R.drawable.icon_notification, "update Xclub", System.currentTimeMillis());
		notification.contentView = new RemoteViews(context.getPackageName(),
				R.layout.notification);

		// 使用notification.xml文件作VIEW
		notification.contentView.setProgressBar(R.id.pb, 100, 0, true);

		// FLAG_AUTO_CANCEL 该通知能被状态栏的清除按钮给清除掉
		// FLAG_NO_CLEAR 该通知不能被状态栏的清除按钮给清除掉
		// FLAG_ONGOING_EVENT 通知放置在正在运行
		// FLAG_INSISTENT 是否一直进行，比如音乐一直播放，知道用户响应
		notification.flags |= Notification.FLAG_AUTO_CANCEL;
		notification.flags |= Notification.FLAG_NO_CLEAR;
		// notification.flags |= Notification.FLAG_ONGOING_EVENT; //
		// 将此通知放到通知栏的"Ongoing"即"正在运行"组中
		// notification.flags |= Notification.FLAG_NO_CLEAR; //
		// 表明在点击了通知栏中的"清除通知"后，此通知不清除，经常与FLAG_ONGOING_EVENT一起使用
		// notification.flags |= Notification.FLAG_SHOW_LIGHTS;
		// DEFAULT_ALL 使用所有默认值，比如声音，震动，闪屏等等
		// DEFAULT_LIGHTS 使用默认闪光提示
		// DEFAULT_SOUNDS 使用默认提示声音
		// DEFAULT_VIBRATE 使用默认手机震动，需加上<uses-permission
		// android:name="android.permission.VIBRATE" />权限
		notification.defaults = Notification.DEFAULT_LIGHTS;
		// 叠加效果常量
		// notification.defaults=Notification.DEFAULT_LIGHTS|Notification.DEFAULT_SOUND;
		notification.ledARGB = Color.BLUE;
		notification.ledOnMS = 5000; // 闪光时间，毫秒

		int result = downLoadSize * 100 / fileLength;
		// 设置通知的事件消息
		CharSequence contentTitle = "update Xclub"; // 通知栏标题
		notification.contentView.setImageViewResource(R.id.ivTitle,
				R.drawable.icon_notification);
		notification.contentView.setTextViewText(R.id.down_tv, "progress" + result
				+ "%");
		// CharSequence contentText = result + "%"; // 通知栏内容
		Intent notificationIntent = new Intent(context, SlidingActivity.class); // 点击该通知后要跳转的Activity
		PendingIntent contentItent = PendingIntent.getActivity(context, 0,
				notificationIntent, 0);
		// notification.setLatestEventInfo(context, contentTitle, null,
		// contentItent);
		notification.contentIntent = contentItent;

		// 把Notification传递给NotificationManager
		notificationManager.notify(0, notification);

	}

	/**** 删除屏幕顶部通知 ****/
	private void clearNotification() {
		// 启动后删除之前我们定义的通知
		NotificationManager notificationManager = (NotificationManager) context
				.getSystemService(context.NOTIFICATION_SERVICE);
		notificationManager.cancel(0);
		/**** 这个组件是在手机本地保存信息.通过这个VERSION来区别保存的值,key=value 形式保存 ****/
		SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
				context.MODE_WORLD_READABLE);
		Editor editor = spf.edit();
		editor.putString("isIgnore", "0");
		editor.commit();

	}

	/**** 显示更新提示框 (已经有新的提示框了,这个过期) **/
	@Deprecated
	public void showDailog(final String updateUrl, final String apkName,
			final String update_description) {
		if(!PreferenceUtils.getPrefBoolean(context, "isDownloadName", false)){
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

		/********* 是否忽略该版本 **********/
		final CheckBox cbUpdate_id_check = (CheckBox) view
				.findViewById(R.id.cbUpdate_id_check);
		
		
		
		//              判断是否被选中
		
		SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
				context.MODE_WORLD_READABLE);
		String versionnumber = spf.getString("versionnumber", "");
		if(!TextUtils.isEmpty(versionnumber)){
		    if(MasterApplication.getInstanse().NEWVERSIONNUMBER.equals(versionnumber)){// 如果当前版本和 服务端最新版本相同 则表示 选中
		        cbUpdate_id_check.setChecked(true);
		    }
		}

		/******* 以后再说 *******/
		view.findViewById(R.id.update_id_cancel).setOnClickListener(
				new OnClickListener() {

					@Override
					public void onClick(View v) {
					    //    判断是否选中，如果 选中 则保存 服务端返回的 版本号
					    
					    SharedPreferences spf = context.getSharedPreferences(
                                Constant.VERSION, context.MODE_WORLD_READABLE+context.MODE_WORLD_WRITEABLE);
					    Editor editor = spf.edit();
					    
					    if(cbUpdate_id_check.isChecked()){
					        editor.putString("versionnumber",MasterApplication.getInstanse().NEWVERSIONNUMBER);
					    }else{
					        editor.putString("versionnumber",null);
					    }
						
						editor.commit();
						// 隐藏发现新版本的窗口
                        dia.dismiss();
					}
				});

		/****** 用户选择立即更新 ******/
		view.findViewById(R.id.update_id_ok).setOnClickListener(
				new OnClickListener() {

					@Override
					public void onClick(View v) {
						// 开启新线程访问服务器下载新版本的apk
						// new Thread(downloadRun).start();
						Log.e("<<<<<<<<<<<<<<<<<<<<", "开始下载.........");
						// 开启新线程访问服务器下载新版本的apk
//						new Thread(downloadRun).start();
						// 隐藏发现新版本的窗口
						dia.dismiss();
						PreferenceUtils.setPrefBoolean(context, "isDownloadName", false);
						Intent intent = new Intent(context, DownloadService.class);
		                //设置下载地址
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
	 * @Description: TODO(下载APK)
	 * @param @param updateUrl
	 * @param @param apkName
	 * @param @param update_description 设定文件
	 * @return void 返回类型
	 * @throws null
	 */
	public Runnable downloadAPKFile(final String updateUrl,
			final String apkName, final String update_description) {
		final Runnable downloadRun = new Runnable() {
			@Override
			public void run() {
				// 下载文件 存放目的地
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

						// Log.e("文件大小", "======" + fileLength);

						// 开始下载apk文件,名称需要更改
						FileOutputStream fos = new FileOutputStream(
								downloadPath + "/" + apkName + ".apk");
						byte[] buffer = new byte[8192];
						int count = 0;
						while ((count = is.read(buffer)) != -1) {
							downLoadFileSize += count;
							fos.write(buffer, 0, count);
							// 屏幕顶端提示下载进度消息
							titlePrompt(downLoadFileSize, fileLength);
						}
						fos.close();
						is.close();
						// 安装 apk 文件
						installApk(downloadPath + "/" + apkName + ".apk");
					} else {
						/****
						 * 这里是在一个普通的子线程中,不能实现ui更新,要弹出提示框必须Looper.prepare();
						 * 和Looper.loop();
						 ****/
						Looper.prepare();
						ToastManager.showShort(context, "Server update address error!");
						Looper.loop();
					}
					// 是否在屏幕顶部显示

				} catch (Exception e) {
				}

			}
		};
		return downloadRun;
	}

	@Override
	public void onBegin() {
	}

	@Override
	public void onComplete(BaseEntity result) {
//	    MasterApplication.versionBean=null;
		if (null != result) {
			masterApplication.logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
						String versionstr = masterApplication.logininfo.getVariables().getApp_version().getVersion();
						MasterApplication.getInstanse().NEWVERSIONNUMBER = versionstr;
						
						if (!version.equals(versionstr)) {
							String updateUrl = masterApplication.logininfo.getVariables().getApp_version().getLink();
//							String update_level = jo.getString("update_level");
							// if(null==pageName){
//							if ("true".equals(update_level)) {
//								// 强制更新
//								compulsoryUpdateDailog(updateUrl, apkName,
//										update_description);
//								return;
//							} else {
								    
								    VersionInfo versionBean=new VersionInfo();
								    
//								    MasterApplication.versionBean = versionBean;
								    
								    SharedPreferences spf = context.getSharedPreferences(Constant.VERSION,
							                context.MODE_WORLD_READABLE);
							        String versionnumber = spf.getString("versionnumber", "");
								    
								    if(pageName.equals(SlidingActivity.class.getSimpleName())){
								        
								        if(!TextUtils.isEmpty(versionnumber)){
                                            if(MasterApplication.getInstanse().NEWVERSIONNUMBER.equals(versionnumber)){
//                                                MasterApplication.versionBean=null;
                                            }
                                        }
								        
								        // 如果是从 欢迎界面过来，不需要弹出 自动更新提示框
								        handler.sendEmptyMessage(Constant.RETURNWEHLCOME);
								        return;
								    }else if(pageName.equals(SlidingActivity.class.getSimpleName())){
								        
								        if(!TextUtils.isEmpty(versionnumber)){
	                                        if(!MasterApplication.getInstanse().NEWVERSIONNUMBER.equals(versionnumber)){
	                                            new VersionUtil(context, null).showDailog(versionBean.getLink(), 
	                                                    "Xclub", "");
	                                        }
	                                    }
								        
								    }else{
								        handler.sendEmptyMessage(Constant.RETURNWEHLCOME);
								        
//								        if(!TextUtils.isEmpty(versionnumber)){
//                                            if(!getVersionNo().equals(versionnumber)){
//                                                new VersionUtil(context, null).showDailog(versionBean.getUpdateUrl(), 
//                                                        versionBean.getApkName(), versionBean.getUpdate_description());
//                                            }
//                                        }
                                        return;
								    }
								    return;
//								}
//							}
							 }
						handler.sendEmptyMessage(Constant.RETURNNOWEHLCOME);
							// 提示用户发现新版本
							// showDailog(updateUrl, apkName,
							// update_description);
						return;
						} else {
//						    handler.sendEmptyMessage(Constant.RETURNWEHLCOME);
							// 从关于页面过来则需要向用户提示
//							if ("about".equals(pageName)) {
//								Looper.prepare();
//								T.s(context, "已是最新版本");
//								Looper.loop();
//							}
//						}
						    return;
					}
	}

	/**
	 * 
	 * @Title: updateDailog
	 * @Description: TODO(第二种版本更新提示框)
	 * @param 设定文件
	 * @return void 返回类型
	 * @throws null
	 */
	public void updateDailog(final String updateUrl, final String apkName,
			final String update_description) {
	    DialogUtil dialog = new DialogUtil.Builder(context)
				.setMessage(update_description)
				.setTitle("Found a new version")
				.setNegativeButton("Let's talk it later",
						new DialogInterface.OnClickListener() {

							@Override
							public void onClick(DialogInterface dialog,
									int which) {
								dialog.dismiss();
								/****
								 * 这个组件是在手机本地保存信息.通过这个VERSION来区别保存的值,key=value
								 * 形式保存
								 ****/
								SharedPreferences spf = context
										.getSharedPreferences(Constant.VERSION,
												context.MODE_WORLD_READABLE);
								Editor editor = spf.edit();
								// Log.e("@@@@@@@@@@@@", "==" + isChecked +
								// "===");
								editor.putString("isIgnore", "1");
								// Log.e("@@@@@@@@@@@@",
								// "=="+isChecked+"==="+usernameSpf+"===");
								editor.commit();
								
								
							}
						})
				.setPositiveButton("update now",
						new DialogInterface.OnClickListener() {

							@Override
							public void onClick(DialogInterface dialog,
									int which) {
								// TODO Auto-generated method stub
								Runnable downloadRun = downloadAPKFile(
										updateUrl, apkName, update_description);
								// 开启新线程访问服务器下载新版本的apk
								new Thread(downloadRun).start();

								/****
								 * 这个组件是在手机本地保存信息.通过这个VERSION来区别保存的值,key=value
								 * 形式保存
								 ****/
								SharedPreferences spf = context
										.getSharedPreferences(Constant.VERSION,
												context.MODE_WORLD_READABLE);
								Editor editor = spf.edit();
								// Log.e("@@@@@@@@@@@@", "==" + isChecked +
								// "===");
								editor.putString("isIgnore", "0");
								// Log.e("@@@@@@@@@@@@",
								// "=="+isChecked+"==="+usernameSpf+"===");
								editor.commit();
							}
						}).create();
		dialog.setCancelable(false);
		dialog.show();
	}

	/**
	 * 
	 * @Title: compulsoryUpdateDailog
	 * @Description: TODO(提示用户发现新版本,并强制用户更新)
	 * @param @param updateUrl
	 * @param @param apkName
	 * @param @param update_description 设定文件
	 * @return void 返回类型
	 * @throws null
	 */
	@SuppressWarnings("unused")
	private void compulsoryUpdateDailog(final String updateUrl,
			final String apkName, final String update_description) {
	    DialogUtil dialog = new DialogUtil.Builder(context)
				.setMessage(update_description)
				.setTitle("Found a new version")
				.setPositiveButton("update now",
						new DialogInterface.OnClickListener() {

							@Override
							public void onClick(DialogInterface dialog,
									int which) {
							    
							    Intent intent = new Intent(context, DownloadService.class);
		                        //设置下载地址
		                        intent.putExtra("url", updateUrl);
		                        intent.putExtra("downloadName", "new update");
		                        context.startService(intent);
		                        handler.sendEmptyMessage(Constant.RETURNWEHLCOME);
		                        
								// TODO Auto-generated method stub
//								Runnable downloadRun = downloadAPKFile(
//										updateUrl, apkName, update_description);
								// 开启新线程访问服务器下载新版本的apk
//								new Thread(downloadRun).start();

								/****
								 * 这个组件是在手机本地保存信息.通过这个VERSION来区别保存的值,key=value
								 * 形式保存
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
//								// 提示用户正在更新,不允许用户操作
//								ProgressDialog progressDialog = new ProgressDialog(
//										context);
//								progressDialog.setMessage("正在更新，请稍等...");
//								progressDialog
//										.setProgressStyle(ProgressDialog.STYLE_SPINNER);
//								progressDialog.setCancelable(false);
//								progressDialog.show();
							}
						}).create();
		dialog.setCancelable(false);
		dialog.show();
	}

	@Override
	public void onNetworkNotConnection() {
	    handler.sendEmptyMessage(Constant.RETURNWEHLCOME);

	}

}
