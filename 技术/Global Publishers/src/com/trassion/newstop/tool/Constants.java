package com.trassion.newstop.tool;

import java.io.File;
import java.util.ArrayList;
import java.util.List;

import android.os.Environment;

import com.trassion.newstop.bean.CityEntity;
import com.trassion.newstop.bean.NewsEntity;

//import com.topnews.bean.NewsClassify;

public class Constants {
	
	//���Է�����
//	public static final String HOT="http://172.17.2.73/svn/publishers/";
	//��ʽ������
	public static final String HOT="http://159.8.94.68/publishers/";
	
	public static final String ACTION_LOGIN_SUCCESS = "com.trassion.newstop.activity";
	public static String KEY_IS_SUCCESS="KEY_IS_SUCCESS";
	
	/**
     * ��ȡ������Ŀ
     */
    public final static int HTTP_GET_CHANNEL_ID = 1;
    
    /**
     * ��ȡģ����ݵ�����Message Id
     */
    public final static int HTTP_GET_MODEL_ID = 2;
    /**
     * ������Ż�ȡ����
     */
    public final static int HTTP_GET_COMMENT = 3;
    /**
     * ע��
     */
    public final static int HTTP_GET_REGISTER = 4;
    /**
     * ��¼
     */
    public final static int HTTP_GET_LOGIN = 5;
    /**
     * �޸��ǳ�
     */
    public final static int HTTP_CHANGE_NICK = 6;
    /**
     * �޸�ǩ��
     */
    public final static int HTTP_CHANGE_SIGNATURE = 7;
    /**
     * �޸�����
     */
    public final static int HTTP_CHANGE_EMAIL = 8;
    /**
     * �޸��ֻ�
     */
    public final static int HTTP_CHANGE_PHONE = 9;
    /**
     * �˳�
     */
    public final static int HTTP_LOGIN_OUT = 10;
    /**
     * ��������
     */
    public final static int HTTP_SEND_COMMENT = 100;
    /**
     * ����
     */
    public final static int HTTP_ADD_LIKE = 101;
    /**
     * �ղ�
     */
    public final static int HTTP_COLLECT_NEWS = 102;
    /**
     * ��ȡ�ղ�����
     */
    public final static int HTTP_GET_COLLECT_NEWS = 103;
    /**
     * ��ȡ���۹������
     */
    public final static int HTTP_GET_MYCOMMENT_NEWS = 104;
    /**
     * ȡ���ղ�
     */
    public final static int HTTP_CANCAL_COLLECT_NEWS = 105;
    /**
     * �޸�����
     */
    public final static int HTTP_CANCAL_CHANGE_PASSWORD = 106;
    /**
     * �һ�����
     */
    public final static int HTTP_CANCAL_FIND_PASSWORD = 107;
    /**
     * ��ȡϵͳ��Ϣ
     */
    public final static int HTTP_GET_SYSTEM_MESSAGE = 108;
    /**
     * ����
     */
    public final static int HTTP_GET_SEARCH = 109;
    /**
     * ��ȡFAQ
     */
    public final static int HTTP_GET_FAQ = 110;
    /**
     * ��ȡ����
     */
    public final static int HTTP_GET_FEEDBACK = 111;
    /**
     * �ύ����
     */
    public final static int HTTP_ADD_FEEDBACK = 112;
    /**
     * ��������
     * ��ȡģ����ݵĸ������Message Id
     */
    public final static int HTTP_GET_MORE_MODEL_ID = 113;
    /**
     * ����ˢ��
     * ��ȡģ����ݵ�����Message Id
     */
    public final static int HTTP_GET_NEW_MODEL_ID = 114;
    /**
     * ����ˢ��
     * ������Ż�ȡ����
     */
    public final static int HTTP_GET_MORE_COMMENT = 115;
    /**
     * ��ȡ�汾��
     */
    public final static int HTTP_GET_VERSION = 116;
    /**
     * �ϴ�ͼƬ
     */
    public final static int HTTP_UPLOAD_IMAGE = 11;
    /**
     * 登录facebook twitter
     */
    public final static int HTTP_GET_LOGIN_TYPE = 117;
    
    
    public static final int NOTIFICATION_DOWNLOADING = 121905204;
    
    public static boolean isDownloading = false;
	public static boolean isDownServer = false;
    /**    �汾���º� ���� handler ��  */
	public  static final int RETURNWEHLCOME = 10000001;
	public  static final int RETURNNOWEHLCOME = 10000000;
	
	/***** �汾 ******/
	public static final String VERSION = "VERSION";
    
	/**
	 * �ϴ�ͼƬĬ������ѹ����������ֵ��1~100
	 */
	public static final int IMG_QUALITY = 50;
	
	public static final int HD_PIC_WIDTH_POSTLIST=300;
	
	public static String BASE_PATH = Environment.getExternalStorageDirectory()
			+ File.separator ;
	
	
	/**
	 * SD��·��
	 */
	public static String SD_CARD_PATH = BASE_PATH;
	/**
	 * Ӧ���ļ���
	 */
    public static String APP_DIR_NAME = "NewsTop/";
    
    /**
     * Ӧ���ļ�·��
     */
    public static String APP_DIR = SD_CARD_PATH + APP_DIR_NAME;

    public static String PHOTO_PATH = BASE_PATH + APP_DIR_NAME+File.separator;
    
    public static String TMP_PATH = PHOTO_PATH + "picture";
    /**
	 * ͼƬ�����ļ�Ŀ¼����
	 */
	public static String CACHE_DIR =PHOTO_PATH+ ".LazyPhoto";
	
	/**
   	 * ������Ϣ����Ŀ¼���
   	 */
   	public static final String POST_CACHE_DIRNAME = ".postcache";
    /**
	 * ������Ϣ����Ŀ¼
	 */
	public static final String POST_CACHE_DIR = APP_DIR+POST_CACHE_DIRNAME;
	
	
	/*
	 * ��ȡ�����б�
	 */
	public static ArrayList<CityEntity> getCityList(){
		ArrayList<CityEntity> cityList =new ArrayList<CityEntity>();
		CityEntity city1 = new CityEntity(1, "����", 'A');
		CityEntity city2 = new CityEntity(2, "����", 'B');
		CityEntity city3 = new CityEntity(3, "����", 'C');
		CityEntity city4 = new CityEntity(4, "��ɳ", 'C');
		CityEntity city5 = new CityEntity(5, "����", 'D');
		CityEntity city6 = new CityEntity(6, "�����", 'H');
		CityEntity city7 = new CityEntity(7, "����", 'H');
		CityEntity city8 = new CityEntity(8, "��ɳ��", 'J');
		CityEntity city9 = new CityEntity(9, "����", 'J');
		CityEntity city10 = new CityEntity(10, "ɽ��", 'S');
		CityEntity city11 = new CityEntity(11, "����", 'S');
		CityEntity city12 = new CityEntity(12, "����", 'Y');
		CityEntity city13 = new CityEntity(13, "��ɽ", 'Z');
		cityList.add(city1);
		cityList.add(city2);
		cityList.add(city3);
		cityList.add(city4);
		cityList.add(city5);
		cityList.add(city6);
		cityList.add(city7);
		cityList.add(city8);
		cityList.add(city9);
		cityList.add(city10);
		cityList.add(city11);
		cityList.add(city12);
		cityList.add(city13);
		return cityList;
	}
	/* Ƶ�������� �纼�� ��Ӧ����ĿID */
	public final static int CHANNEL_CITY = 3;
}
