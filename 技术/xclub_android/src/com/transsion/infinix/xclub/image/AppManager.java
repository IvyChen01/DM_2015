package com.transsion.infinix.xclub.image;

import java.util.Stack;

import android.app.Activity;
import android.app.ActivityManager;
import android.content.Context;

/**
 * 应用程序Activity管理类：用于Activity管理和应用程序�?�?
 * @author liux (http://my.oschina.net/liux)
 * @version 1.0
 * @created 2012-3-21
 */
public class AppManager {
	
	private static Stack<Activity> activityStack;
	private static AppManager instance;
	
	private AppManager(){}
	/**
	 * 单一实例
	 */
	public static AppManager getAppManager(){
		if(instance==null){
			instance=new AppManager();
		}
		return instance;
	}
	/**
	 * 添加Activity到堆�?
	 */
	public void addActivity(Activity activity){
		if(activityStack==null){
			activityStack=new Stack<Activity>();
		}
		activityStack.add(activity);
	}
	/**
	 * 获取当前Activity（堆栈中�?���?��压入的）
	 */
	public Activity currentActivity(){
		Activity activity=activityStack.lastElement();
		return activity;
	}
	/**
	 * 结束当前Activity（堆栈中�?���?��压入的）
	 */
	public void finishActivity(){
		Activity activity=activityStack.lastElement();
		finishActivity(activity);
	}
	/**
	 * 结束指定的Activity
	 */
	public void finishActivity(Activity activity){
		if(activity!=null){
			activityStack.remove(activity);
			activity.finish();
			activity=null;
		}
	}
	/**
	 * 结束指定类名的Activity
	 */
	public void finishActivity(Class<?> cls){
		for (Activity activity : activityStack) {
			if(activity.getClass().equals(cls) ){
				finishActivity(activity);
			}
		}
	}
	/**
	 * 结束�?��Activity
	 */
	public void finishAllActivity(){
		if(activityStack != null && activityStack.size() > 0){
			for (int i = 0, size = activityStack.size(); i < size; i++){
	            if (null != activityStack.get(i)){
	            	activityStack.get(i).finish();
	            }
		    }
			activityStack.clear();
		}
		
	}
	/**
     * 结束除了制定Activity以外的Activity
     */
    public void finishOneActivity(String name){
        for (int i = 0, size = activityStack.size(); i < size; i++){
            if (null != activityStack.get(i)){
                
                if(!activityStack.get(i).getClass().getSimpleName().equals(name)){
                    activityStack.get(i).finish();
                }
            }
        }
        activityStack.clear();
    }
    
	/**
	 * �?��应用程序
	 */
	public void AppExit(Context context) {
		try {
			finishAllActivity();	
			ActivityManager activityMgr= (ActivityManager) context.getSystemService(Context.ACTIVITY_SERVICE);
			activityMgr.restartPackage(context.getPackageName());
			android.os.Process.killProcess(android.os.Process.myPid());  
			System.exit(0);
			
		} catch (Exception e) {	
			e.printStackTrace();
			
		}
	}
}