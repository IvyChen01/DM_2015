package com.trassion.newstop.download;



import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.RandomAccessFile;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.text.DecimalFormat;
import java.util.Timer;
import java.util.TimerTask;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import com.trassion.newstop.activity.R;
import com.trassion.newstop.application.CurrentActivityContext;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.DialogUtil;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.TrafficStats;
import android.net.Uri;
import android.os.Environment;
import android.os.Handler;
import android.os.IBinder;
import android.os.Message;
import android.widget.Toast;
import com.trassion.newstop.tool.PreferenceUtils;

public class DownloadService extends Service {
	private final int DOWNLOAD_COMPLETE = 200;
	private final int DOWNLOAD_FAIL = 201;
	private final int CHANGE_SHOW_PERCENT = 202;
	private final int SCHEDULE_BEGIN = 203;
	private int titleId = 0;
	private long totalSize = 0;
	//
	public Context c;
	//文件存储
	private File updateDir = null;
	private File updateFile = null;
	 
	//通知栏
	private NotificationManager updateNotificationManager = null;
	private Notification updateNotification = null;
	//通知栏跳转Intent
	private Intent updateIntent = null;
	private PendingIntent updatePendingIntent = null;
	//统计流量
	private Timer timer;
	private TimerTask task;
	private long tempL = -1l;
	private String kbs = "0";
	private int showPercent = 0;
	//下载的各种状态
	private final int DOWNLOADING = 2000;
	private final int PAUSE       = 2001;
	private int state = PAUSE;
	private int fileSize = 0;
	private int compeletesize = 0;
	//
	private static DownloadService instance;
	private String downloadUrl = "";
	private String localStrFile = null;
	private String downloadName;
	//-----------------------------------------------------------------------------------------
	//获取句柄, 方便暂停
	public static DownloadService getInstance(){
		return instance;
	}
	
	//暂停下载
	private void pause(){
		state = PAUSE;
		
		// 取消 noti
	}
	
	@Override
	public IBinder onBind(Intent intent) {
		// TODO Auto-generated method stub
		return null;
	}
	
	@Override
	public void onCreate() {
		// TODO Auto-generated method stub
		super.onCreate();
	}
	
	@Override
	public void onStart(Intent intent, int startId) {
		super.onStart(intent, startId);
		c = CurrentActivityContext.getInstance().getCurrentContext();
		//
		Constants.isDownServer = true;
		
		if(intent!=null){
		    downloadName = intent.getStringExtra("downloadName");
		}
		
		localStrFile = Environment.getExternalStorageDirectory().getAbsoluteFile() + "/"+ getResources().getString(R.string.app_name) + ".apk";
		//
		instance = this;
		//初始创建文件
		if (android.os.Environment.MEDIA_MOUNTED.equals(android.os.Environment.getExternalStorageState())) {
			updateDir = new File(Environment.getExternalStorageDirectory().toString());
			updateFile = new File(updateDir.getPath(), getResources().getString(R.string.app_name) + ".apk");
			if(!updateFile.exists()){
				try {
					updateFile.createNewFile();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
		}else {
			updateDir = new File("/data/apk");
			if(!updateDir.exists()) {
				updateDir.mkdir();
			}
			updateFile = new File(updateDir.getAbsolutePath(), getResources().getString(R.string.app_name) + ".apk");
			if(!updateFile.exists()){
				try {
					updateFile.createNewFile();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
		 //初始notifi
		this.updateNotificationManager = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
		this.updateNotification = new Notification();
		
		 //
		 //设置下载过程中，点击通知栏，回到主界面
	    updateIntent = new Intent();
	    updatePendingIntent = PendingIntent.getActivity(this, 0, updateIntent, 0);
	    //设置通知栏显示内容
	    updateNotification.flags |= Notification.FLAG_AUTO_CANCEL;
	    updateNotification.icon = R.drawable.icon_notification;
	    updateNotification.tickerText = "Start downloading";
		updateNotification.setLatestEventInfo(this, downloadName+"  Downloading..", "Download 0%  Current speed[0 kb/s]", updatePendingIntent);
	    //发出通知
	    updateNotificationManager.notify(Constants.NOTIFICATION_DOWNLOADING, updateNotification);
	    //计时器统计流量
	    if(task!=null){
	    	task.cancel();
	    }
	    timer = new Timer();
	    task = new TimerTask() {
			@Override
			public void run() {
				if(TrafficStats.getTotalRxBytes() == TrafficStats.UNSUPPORTED){
					kbs = "0";
				}else {
					long temp = TrafficStats.getTotalRxBytes();
					if(tempL == -1){
						kbs = "0";
					}else {
						kbs = (new DecimalFormat("#.00").format(((double)(temp - tempL) / 2048))) + "";
					}
					tempL = temp;
				}
			}
		};
	    //开启一个新的线程下载，如果使用Service同步下载，会导致ANR问题，Service本身也会阻塞
	    if(intent != null){
	    	downloadUrl = intent.getStringExtra("url");
//	    	download();//新的下载方法
	    	
	    	downloadApk(downloadUrl);//这个是下载的重点，是下载的过程
	    }
	}
	
	@Override
	public void onDestroy() {
		pause();
		if(updateNotificationManager!=null){
            updateNotificationManager.cancelAll();
        }
        Constants.isDownServer = false;
		super.onDestroy();
	}

	@Override
	public int onStartCommand(Intent intent, int flags, int startId) {
		
		return super.onStartCommand(intent, flags, startId);
	}
	
	/**
	 * 原始下载方法
	 * @param url
	 */
	private void downloadApk(final String url){
		showPercent=0;
		new Thread(){
			public void run() {
//				handler.sendEmptyMessage(ConstData.SHOW_PROGRESS);
				Constants.isDownloading = true;
				HttpClient client = new DefaultHttpClient();
				HttpGet get = new HttpGet(url);
				HttpResponse response;
				try {
					response = client.execute(get);
					HttpEntity entity = response.getEntity();
					long length = entity.getContentLength();
					InputStream is = entity.getContent();
					FileOutputStream fos = null;
					if(is == null){
						throw new RuntimeException("InputStream is null");
					}
					fos = new FileOutputStream(updateFile);
					totalSize = length;//要循环多少次
					byte [] buffer = new byte[4096];
					int ch = -1;
					updateHandler.sendEmptyMessage(SCHEDULE_BEGIN);
					do{
						ch = is.read(buffer);
						if(ch <= 0) break;
						fos.write(buffer, 0, ch);
						showPercent += ch;
						// 用消息将下载信息传给进度条，对进度条进行更新
						Message message = Message.obtain();
						message.what = CHANGE_SHOW_PERCENT;
						message.arg1 = showPercent;
						updateHandler.sendMessage(message);
					}while(true);
					is.close();
					fos.close();
					Constants.isDownloading = false;
					updateHandler.sendEmptyMessage(DOWNLOAD_COMPLETE);
				} catch (ClientProtocolException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			};
		}.start();
	}
	
	
	private Handler updateHandler = new  Handler(){
	    @Override
	    public void handleMessage(Message msg) {
	        switch(msg.what){
	            case DOWNLOAD_COMPLETE:
	            	Constants.isDownloading = false;
	            	showPercent = 0;
	                timer.cancel();//停止计算网速
	                //停止服务
	                stopService(updateIntent);
	                stopService(new Intent(c,DownloadService.class));
	                DialogUtil dialog = new DialogUtil.Builder(CurrentActivityContext.getInstance().getCurrentContext())
	                .setTitle("Is installed")
	                .setMessage("A new update has been downloaded,install now?")
	                .setNegativeButton("", new DialogInterface.OnClickListener() {
                        
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            // TODO Auto-generated method stub
                            dialog.dismiss();
//                            stopService(new Intent(c,DownloadService.class));
                        }})
	                .setPositiveButton("", new DialogInterface.OnClickListener() {
	                    
	                    @Override
	                    public void onClick(DialogInterface dialog, int which) {
	                        // TODO Auto-generated method stub
	                        dialog.dismiss();
//	                        stopService(new Intent(c,DownloadService.class));
	                        
	                      Uri uri = Uri.fromFile(updateFile);
	                      Intent installIntent = new Intent(Intent.ACTION_VIEW);
	                      installIntent.setDataAndType(uri, "application/vnd.android.package-archive");
	                      CurrentActivityContext.getInstance().getCurrentContext().startActivity(installIntent);
	                    }
	                }).create();
	                dialog.setCancelable(false);            
	                dialog.show();
	                PreferenceUtils.setPrefBoolean(c, "isDownloadName", true);
	                
	                break;
	            case DOWNLOAD_FAIL:
	                //下载失败
	                updateNotification.setLatestEventInfo(DownloadService.this, downloadName, "下载完成,点击安装。", updatePendingIntent);
	                updateNotificationManager.notify(0, updateNotification);
	                break;
	            case CHANGE_SHOW_PERCENT:
	            	updateNotification.setLatestEventInfo(DownloadService.this, 
	            	        downloadName+" Downloading", 
	            			"Download "+(msg.arg1 * 100 / totalSize)+"%   Current speed["+kbs+" kb/s]", 
	            			updatePendingIntent);
                    updateNotificationManager.notify(Constants.NOTIFICATION_DOWNLOADING, updateNotification);
	            	break;
	            case SCHEDULE_BEGIN:
	            	timer.schedule(task, 0, 2000);//开始计算网速， 两秒计算一回
	            	Constants.isDownloading = true;
	            	break;
	            default:
	                stopService(updateIntent);
	                break;
	        }
	    }
	};
	
	//初始化本地文件， 设置大小
	public void init(){
		try {
			URL url = new URL(downloadUrl);
			HttpURLConnection connection = (HttpURLConnection) url.openConnection();
			connection.setConnectTimeout(5 * 1000);
//			connection.setRequestMethod("GET");
			fileSize = connection.getContentLength();
			File file = new File(localStrFile);
			if(!file.exists()){
				file.createNewFile();
			}
			//生成本地文件， 设置大小 
			RandomAccessFile accessFile = new RandomAccessFile(file, "rwd");
			if(fileSize > 0){
				accessFile.setLength(fileSize);
			}else {
				Toast.makeText(c, "Temporarily unable to obtain a file", 2000).show();
				return;
			}
			accessFile.close();
			connection.disconnect();
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
}
