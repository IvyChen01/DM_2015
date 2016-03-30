package com.transsion.infinix.xclub.constact;

import java.io.File;

import android.os.Environment;


public class Constant {

	/** 网络连接超时 */
    public static final int  CONNECTTIMEOUT= 20000;

	public static final String AUTOLOGIN = "AUTOLOGIN";
	
	 public static final int LESSNUM=-1;//主贴列表图片position系数
	/**
	 * 上传图片默认质量压缩比例，质量值：1~100
	 */
	public static final int IMG_QUALITY = 50;
	//Wifi和非wifi网络环境下内容页加载图片的比例 
    public static final int DEFAULT_PIC_WIDTH=200;
    public static final int HD_PIC_WIDTH=600;
	//帖子列表图片的比例 
    public static final int DEFAULT_PIC_WIDTH_POSTLIST=60;
    public static final int HD_PIC_WIDTH_POSTLIST=300;
	// -----------------URL----------------
	public static final String BASE_URL="http://bbs.infinixmobility.com/api/mobile/index.php";
    public static final String FORUM_URL="http://bbs.infinixmobility.com/forum.php?";
    //测试服务器
//    public static final String BASE_URL="http://172.16.6.73/infinix/api/mobile/index.php";
//    public static final String FORUM_URL="http://172.16.6.73/infinix/forum.php?";
	public static final String BASE_PICTRUE_URL=BASE_URL+"?mobile=no&version=5&module=forumupload";//上传图片接口
	public static final String BASE_IMGHEAD_URL=BASE_URL+"?mobile=no&version=5&module=uploadavatar";//上传头像接口
	public static final String BASE_INFORMATION_URL=BASE_URL+"?version=5&mobile=no&module=changeprofile";//个人信息接口
	
	public static final String ACTION_CHOOSECOUNTRY_SUCCESS = "com.example.xclub.activity.ProvinceCountryActivity";
	public static final String ACTION_NICKNAME_SUCCESS = "com.example.xclub.activity.NickNameActivity";
	public static final String ACTION_PHONE_SUCCESS = "com.example.xclub.activity.PhoneActivity";
	public static final String ACTION_CHOOSEWORK_SUCCESS = "com.example.xclub.activity.ProvinceProfessionActivity";
	public static final String ACTION_LOGIN_SUCCESS = "com.example.xclub.activity.LoginActivity";
	public static final String ACTION_SIGONOUT_SUCCESS = "com.example.xclub.activity.PersonalCenterActivity";
	public static String KEY_IS_SUCCESS="KEY_IS_SUCCESS";

	public static final int UPLOAD_SIZE=5;//最多上传图片数
	public static final int PIC_RESULT = 1;// 图片回调
	public static final String UPLOAD_PIC_ORIGINAL = "upload_pic_original";// 使用原图
	
	public static String BASE_PATH = Environment.getExternalStorageDirectory()
			+ File.separator + ".xclub_infinix" + File.separator;
	/**
	 * 临时文件夹
	 */
	public static String TMP_PATH = BASE_PATH + "picture";
	public static String TEXT_PATH = BASE_PATH + "text";
	
	public static final int GO_TO_ISLOGIN=1001;//是否已登录

	public static final int GO_TO_CHOOSENAME=1003;//昵称

	public static final int GO_TO_CHOOSEWORK = 1002; //选择职业

	public static final int GO_TO_CHOOSECOUNTRY = 1000;// 选择国家
	
	
	/***** 版本 ******/
	public static final String VERSION = "VERSION";
	
	public static final int NOTIFICATION_DOWNLOADING = 121905204;
	
	public static boolean isDownloading = false;
	public static boolean isDownServer = false;
	/**    版本更新后 发送 handler 码  */
	public  static final int RETURNWEHLCOME = 10000001;
	public  static final int RETURNNOWEHLCOME = 10000000;
	
    
	public static String PHOTO_PATH = BASE_PATH + "photo"+File.separator;
    /**
	 * 图片缓存文件目录名字
	 */
	public static String CACHE_DIR =PHOTO_PATH+ ".LazyPhoto";
	
    /**
	 * SD卡路径
	 */
	public static String SD_CARD_PATH = BASE_PATH;
	/**
	 * 应用文件名
	 */
    public static String APP_DIR_NAME = "/xclub/";
    
    /**
     * 应用文件路径
     */
    public static String APP_DIR = SD_CARD_PATH + APP_DIR_NAME;
    
    /**
   	 * 帖子信息缓存目录名称
   	 */
   	public static final String POST_CACHE_DIRNAME = ".postcache";
    /**
	 * 帖子信息缓存目录
	 */
	public static final String POST_CACHE_DIR = APP_DIR+POST_CACHE_DIRNAME;
	
	public static final String FILE_SAVE_PATH = Environment.getExternalStorageDirectory()
			+ File.separator + "infinix";

	
}
