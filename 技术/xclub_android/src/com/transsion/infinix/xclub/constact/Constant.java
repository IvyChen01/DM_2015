package com.transsion.infinix.xclub.constact;

import java.io.File;

import android.os.Environment;


public class Constant {

	/** �������ӳ�ʱ */
    public static final int  CONNECTTIMEOUT= 20000;

	public static final String AUTOLOGIN = "AUTOLOGIN";
	
	 public static final int LESSNUM=-1;//�����б�ͼƬpositionϵ��
	/**
	 * �ϴ�ͼƬĬ������ѹ������������ֵ��1~100
	 */
	public static final int IMG_QUALITY = 50;
	//Wifi�ͷ�wifi���绷��������ҳ����ͼƬ�ı��� 
    public static final int DEFAULT_PIC_WIDTH=200;
    public static final int HD_PIC_WIDTH=600;
	//�����б�ͼƬ�ı��� 
    public static final int DEFAULT_PIC_WIDTH_POSTLIST=60;
    public static final int HD_PIC_WIDTH_POSTLIST=300;
	// -----------------URL----------------
	public static final String BASE_URL="http://bbs.infinixmobility.com/api/mobile/index.php";
    public static final String FORUM_URL="http://bbs.infinixmobility.com/forum.php?";
    //���Է�����
//    public static final String BASE_URL="http://172.16.6.73/infinix/api/mobile/index.php";
//    public static final String FORUM_URL="http://172.16.6.73/infinix/forum.php?";
	public static final String BASE_PICTRUE_URL=BASE_URL+"?mobile=no&version=5&module=forumupload";//�ϴ�ͼƬ�ӿ�
	public static final String BASE_IMGHEAD_URL=BASE_URL+"?mobile=no&version=5&module=uploadavatar";//�ϴ�ͷ��ӿ�
	public static final String BASE_INFORMATION_URL=BASE_URL+"?version=5&mobile=no&module=changeprofile";//������Ϣ�ӿ�
	
	public static final String ACTION_CHOOSECOUNTRY_SUCCESS = "com.example.xclub.activity.ProvinceCountryActivity";
	public static final String ACTION_NICKNAME_SUCCESS = "com.example.xclub.activity.NickNameActivity";
	public static final String ACTION_PHONE_SUCCESS = "com.example.xclub.activity.PhoneActivity";
	public static final String ACTION_CHOOSEWORK_SUCCESS = "com.example.xclub.activity.ProvinceProfessionActivity";
	public static final String ACTION_LOGIN_SUCCESS = "com.example.xclub.activity.LoginActivity";
	public static final String ACTION_SIGONOUT_SUCCESS = "com.example.xclub.activity.PersonalCenterActivity";
	public static String KEY_IS_SUCCESS="KEY_IS_SUCCESS";

	public static final int UPLOAD_SIZE=5;//����ϴ�ͼƬ��
	public static final int PIC_RESULT = 1;// ͼƬ�ص�
	public static final String UPLOAD_PIC_ORIGINAL = "upload_pic_original";// ʹ��ԭͼ
	
	public static String BASE_PATH = Environment.getExternalStorageDirectory()
			+ File.separator + ".xclub_infinix" + File.separator;
	/**
	 * ��ʱ�ļ���
	 */
	public static String TMP_PATH = BASE_PATH + "picture";
	public static String TEXT_PATH = BASE_PATH + "text";
	
	public static final int GO_TO_ISLOGIN=1001;//�Ƿ��ѵ�¼

	public static final int GO_TO_CHOOSENAME=1003;//�ǳ�

	public static final int GO_TO_CHOOSEWORK = 1002; //ѡ��ְҵ

	public static final int GO_TO_CHOOSECOUNTRY = 1000;// ѡ�����
	
	
	/***** �汾 ******/
	public static final String VERSION = "VERSION";
	
	public static final int NOTIFICATION_DOWNLOADING = 121905204;
	
	public static boolean isDownloading = false;
	public static boolean isDownServer = false;
	/**    �汾���º� ���� handler ��  */
	public  static final int RETURNWEHLCOME = 10000001;
	public  static final int RETURNNOWEHLCOME = 10000000;
	
    
	public static String PHOTO_PATH = BASE_PATH + "photo"+File.separator;
    /**
	 * ͼƬ�����ļ�Ŀ¼����
	 */
	public static String CACHE_DIR =PHOTO_PATH+ ".LazyPhoto";
	
    /**
	 * SD��·��
	 */
	public static String SD_CARD_PATH = BASE_PATH;
	/**
	 * Ӧ���ļ���
	 */
    public static String APP_DIR_NAME = "/xclub/";
    
    /**
     * Ӧ���ļ�·��
     */
    public static String APP_DIR = SD_CARD_PATH + APP_DIR_NAME;
    
    /**
   	 * ������Ϣ����Ŀ¼����
   	 */
   	public static final String POST_CACHE_DIRNAME = ".postcache";
    /**
	 * ������Ϣ����Ŀ¼
	 */
	public static final String POST_CACHE_DIR = APP_DIR+POST_CACHE_DIRNAME;
	
	public static final String FILE_SAVE_PATH = Environment.getExternalStorageDirectory()
			+ File.separator + "infinix";

	
}
