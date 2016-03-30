package com.transsion.infinix.xclub.util;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

import android.annotation.SuppressLint;


/**
 * 日期时间工具�?
 */
public final class DateTimeUtils {

	public static final String LOG_DATE_STAMP = "yyyy-MM-dd";
	public static final String LOG_DATE_TIME_STAMP = "yyyy-MM-dd HH:mm:ss";
	public static final String LOG_TIME_STAMP = "HH:mm:ss";
	
	/**
	 * 日志时间格式化，格式�?yyyy-MM-dd HH:mm
	 */
	public static String formateDateTime(Date date){
		return null != date ? new SimpleDateFormat(LOG_DATE_TIME_STAMP,
				Locale.getDefault()).format(date) : new SimpleDateFormat(
						LOG_DATE_TIME_STAMP, Locale.getDefault()).format(new Date());
	}
	
	 /**
     * 根据指定格式返回当前时间
     */
    public static String getTime(String format) {
        String time = "";
        try {
            SimpleDateFormat sdf = new SimpleDateFormat(format, Locale.CHINA);
            time = sdf.format(new Date());
        } catch (Exception e) {
            // ...
        }

        return time;
    }
    
    /**
     * 将yyyy-MM-dd 格式日期转换�?yyyyMMdd格式
     */
    public static String getFormatTime(String date) {
        String time = "";
        try {
            SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd", Locale.CHINA);
            SimpleDateFormat sdf2 = new SimpleDateFormat("yyyyMMdd", Locale.CHINA);
            Date mData = sdf1.parse(date);
            time = sdf2.format(mData);
        } catch (Exception e) {
            // ...
        }

        return time;
    }
    
    /**
     * 将long 格式日期转换�?yyyyMMdd格式
     */
    public static String getFormatDate(long date) {
        String time = "";
        if (date == 0)
		{
			return "0";
		}
        try {
            SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd", Locale.CHINA);
            Date mData = new Date(date * 1000);
            time = sdf1.format(mData);
        } catch (Exception e) {
            // ...
        }

        return time;
    }
    
    /**
     * 将long 格式日期转换�?yyyyMMdd格式
     */
    public static String getFormatTime(long date) {
        String time = "";
        try {
            SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd hh:mm", Locale.CHINA);
            Date mData = new Date(date * 1000);
            time = sdf1.format(mData);
        } catch (Exception e) {
            // ...
        }

        return time;
    }
    public static String getCurrentTime(long date){
    	SimpleDateFormat formatter = new SimpleDateFormat ("yyyy-MM-dd HH:mm:ss ");
		Date curDate = new Date(System.currentTimeMillis());//��ȡ��ǰʱ��
		String str = formatter.format(curDate);
		
		return str;
    }
    
    /**
     * 时间对比
     * @param DATE1
     * @param DATE2
     * @return 0�?1�?2 均满�?
     */
    @SuppressLint("SimpleDateFormat")
	public static int compareDate(Date DATE1, long DATE2,long DATE3) 
    {
    	DateFormat df = new SimpleDateFormat("yyyy-MM-dd hh:mm");
    	try {
		    	Date dt1 = DATE1;
		    	Date dt2 = new Date(DATE2);
		    	Date dt3 = new Date(DATE3);
//		    	System.out.println("dt1.getTime()="+dt1.getTime() + "dt2.getTime()=" + dt2.getTime() + "dt3.getTime()=" + dt3.getTime());
		    	if (dt1.getTime() > dt2.getTime()) {
		    		if (dt1.getTime() < dt3.getTime())
					{
						return 2; //当前时间大于�?��时间且小于结束时�?
					}
			    	else if (dt1.getTime() == dt3.getTime()) {
						return 3; //当前时间大于�?��时间且等于结束时�?
					}
			    	else {
			    		return -1;
					}
		    		
		    	}
		    	else if (dt1.getTime() < dt2.getTime())
		    	{
			    	return 1; //当前时间小于�?��时间
		    	} 
		    	else  //当前时间等于�?��时间
		    	{
		    		return 0;
		    	}
    		}
    	catch (Exception exception)
    	{
    		exception.printStackTrace();
    	}
    	return 0;
    }
    
    /**
     * 与当前系统时间对�?
     * @param DATE1
     * @param DATE2
     * @return -1 1 0
     */
    @SuppressLint("SimpleDateFormat")
	public static int compareDate(Date DATE1) 
    {
    	DateFormat df = new SimpleDateFormat("yyyy-MM-dd hh:mm");
    	try {
		    	Date dt1 = DATE1;
		    	Date dt2 = new Date();
//		    	System.out.println("dt1.getTime()="+dt1.getTime() + "dt2.getTime()=" + dt2.getTime());
		    	if (dt1.getTime() > dt2.getTime()) {
		    		return -1;
		    		
		    	}
		    	else if (dt1.getTime() < dt2.getTime())
		    	{
			    	return 1;
		    	} 
		    	else 
		    	{
		    		return 0;
		    	}
    		}
    	catch (Exception exception)
    	{
    		exception.printStackTrace();
    	}
    	return 0;
    }
    
    /**
     * 时间�?
     * @param DATE1
     * @param DATE2
     * @return
     */
    @SuppressLint("SimpleDateFormat")
	public static int differTime(String DATE1, String DATE2) 
    {
    	DateFormat df = new SimpleDateFormat("yyyy-MM-dd hh:mm");
    	try {
		    	Date dt1 = df.parse(DATE1);
		    	Date dt2 = df.parse(DATE2);
		    	return (int) ((dt1.getTime() - dt2.getTime())/ (60 * 1000));
    		}
    	catch (Exception exception)
    	{
    		exception.printStackTrace();
    	}
    	return 0;
    }
}
