package com.trassion.newstop.application;

import java.io.File;



import com.nostra13.universalimageloader.cache.disc.impl.UnlimitedDiscCache;
import com.nostra13.universalimageloader.cache.disc.naming.Md5FileNameGenerator;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;
import com.nostra13.universalimageloader.utils.StorageUtils;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.db.SQLHelper;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.type.CalligraphyConfig;
import com.trassion.newstop.type.view.CustomViewWithTypefaceSupport;
import com.trassion.newstop.type.view.TextField;

import android.app.Application;
import android.content.Context;
import android.os.Environment;
import android.util.Log;

public class NewsApplication extends Application{
	
	/**
     * ��������
     * handler��Ϣ����whatֵ��1:����ɹ� 2:������� 
     * 3:������� 4:����ʧ�� 5:������ȡ������
     */
  	public static final int MSG_REQUEST_SUCCESS = 1;
  	public static final int MSG_NET_ERROR = 2;
  	public static final int MSG_PARA_ERROR = 3;
  	public static final int MSG_REQUEST_ERROR = 4;
  	public static final int MSG_CANCEL_REQUEST = 5;
  	
  	 /**
     * �ϴ�������ͼƬ
     */
    public final static int HTTP_UPLOAD_FILE_ID = 11;
    /**
     * �ϴ�������ͼƬ
     */
    public final static int HTTP_UPLOAD_PIC_ID = 12;
    /**
     * �޸�ͷ��
     */
    public final static int HTTP_MODFIY_AVATAR = 27;  	
  	/**
	 * ͼƬ�����ļ�Ŀ¼����
	 */
	public static String CACHE_DIR = ".LazyPhoto";
	
	/**
	 * SD��·��
	 */
	public static String SD_CARD_PATH = Environment.getExternalStorageDirectory().getAbsolutePath();
	/**
	 * Ӧ���ļ���
	 */
    public static String APP_DIR_NAME = "/NewsTop/";
	 /**
     * Ӧ���ļ�·��
     */
    public static String APP_DIR = SD_CARD_PATH + APP_DIR_NAME;
    /**
   	 * ������Ϣ����Ŀ¼���
   	 */
   	public static final String POST_CACHE_DIRNAME = ".postcache";
       
   	/**
   	 * ������Ϣ����Ŀ¼
   	 */
   	public static final String POST_CACHE_DIR = APP_DIR+POST_CACHE_DIRNAME;
	
	 /**
     * Ӧ����־Ŀ¼�ļ�
     */
    public static String APP_LOG_PATH = APP_DIR + "log/";

	/** 
	 * ��־�ļ�·�� 
	 */
    public static String LOGFILE = APP_LOG_PATH + "log.txt";
    
    public static String modelName;
    
    /** ��������°汾��  */
	 public static String NEWVERSIONNUMBER;
	 /** ��������°汾��  */
	 public static String versionUrl;
	 public static String versionLog;
	 /**  VersionBean ���� �Ƿ��а汾����   */
  	
    private static NewsApplication mNewsApplication;
    private SQLHelper sqlHelper;
   
   @Override
	public void onCreate() {
		// TODO Auto-generated method stub
		super.onCreate();
		CalligraphyConfig.initDefault(new CalligraphyConfig.Builder().setDefaultFontPath("fonts/Roboto-Regular.ttf")
				.setFontAttrId(R.attr.fontPath).addCustomViewWithSetTypeface(CustomViewWithTypefaceSupport.class)
				.addCustomStyle(TextField.class, R.attr.textFieldStyle).build());
		initImageLoader(getApplicationContext());
		mNewsApplication=this;
	}
   /** ��ȡApplication */
	public static NewsApplication getApp() {
		return mNewsApplication;
	}
	
	/** ��ȡ��ݿ�Helper */
	public SQLHelper getSQLHelper() {
		if (sqlHelper == null)
			sqlHelper = new SQLHelper(mNewsApplication);
		return sqlHelper;
	}
	/** ��ʼ��ImageLoader */
	public static void initImageLoader(Context context) {
		File cacheDir = StorageUtils.getOwnCacheDirectory(context, Constants.APP_DIR);//��ȡ�������Ŀ¼��ַ
		Log.d("cacheDir", cacheDir.getPath());
		//��������ImageLoader(���е�ѡ��ǿ�ѡ��,ֻʹ����Щ������붨��)����������趨��APPLACATION���棬����Ϊȫ�ֵ����ò���
		ImageLoaderConfiguration config = new ImageLoaderConfiguration
				.Builder(context)
				//.memoryCacheExtraOptions(480, 800) // max width, max height���������ÿ�������ļ�����󳤿�
				//.discCacheExtraOptions(480, 800, CompressFormat.JPEG, 75, null) // Can slow ImageLoader, use it carefully (Better don't use it)���û������ϸ��Ϣ����ò�Ҫ�������
				.threadPoolSize(3)//�̳߳��ڼ��ص�����
				.threadPriority(Thread.NORM_PRIORITY - 2)
				.denyCacheImageMultipleSizesInMemory()
				//.memoryCache(new UsingFreqLimitedMemoryCache(2 * 1024 * 1024)) // You can pass your own memory cache implementation�����ͨ���Լ����ڴ滺��ʵ��
				//.memoryCacheSize(2 * 1024 * 1024)  
				///.discCacheSize(50 * 1024 * 1024)  
				.discCacheFileNameGenerator(new Md5FileNameGenerator())//�������ʱ���URI�����MD5 ����
				//.discCacheFileNameGenerator(new HashCodeFileNameGenerator())//�������ʱ���URI�����HASHCODE����
				.tasksProcessingOrder(QueueProcessingType.LIFO)
				//.discCacheFileCount(100) //�����File����
				.discCache(new UnlimitedDiscCache(cacheDir))//�Զ��建��·��
				//.defaultDisplayImageOptions(DisplayImageOptions.createSimple())
				//.imageDownloader(new BaseImageDownloader(context, 5 * 1000, 30 * 1000)) // connectTimeout (5 s), readTimeout (30 s)��ʱʱ��
				.writeDebugLogs() // Remove for release app
				.build();
		// Initialize ImageLoader with configuration.
		ImageLoader.getInstance().init(config);//ȫ�ֳ�ʼ��������
	}
}
