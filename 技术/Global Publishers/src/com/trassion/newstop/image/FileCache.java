package com.trassion.newstop.image;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;

import org.apache.http.util.EncodingUtils;

import com.trassion.newstop.tool.Constants;

import android.content.Context;
import android.os.Environment;
import android.text.TextUtils;
import android.util.Log;


/**
 * 
* @ClassName: FileCache    
* @Description: TODO(sd卡缓存图片)    
* @author chen    
* @date 2016-1-13 上午9:32:07
 */
public class FileCache {
    
    private static final String TAG = FileCache.class.getSimpleName();
	public File cacheDir;
    
    public FileCache(Context context){
        //找到保存缓存的图片,目录
        if (android.os.Environment.getExternalStorageState().equals(android.os.Environment.MEDIA_MOUNTED))
            cacheDir=new File(Constants.APP_DIR+Constants.CACHE_DIR);
        else
            cacheDir=context.getCacheDir();
        if(!cacheDir.exists())
            cacheDir.mkdirs();
    }
    /**
     * 根据url得到图片存放本地目录
     */
    public File getFile(String url){
    	File f = null;
    	try {
    		//我确定图像的hashcode
    		String filename=String.valueOf(url.hashCode());
    		f = new File(cacheDir, filename);
		} catch (Exception e) {
			Log.e(TAG, e.getMessage());
			e.printStackTrace();
		}
        return f;
    }
    /**
     * 根据url移除本地sd卡存在的该图片 
     */
    public void DeleteFile(String url){
    	File f=getFile(url);
    	if(f.exists())
    		f.delete();
    }
    /**
     * 清空本地sd卡缓存的图片 
     */
    public void clear(){
        File[] files=cacheDir.listFiles();
        for(File f:files)
            f.delete();
    }
    public String getPath(String url){
    	File f=getFile(url);
    	if(f.exists()){
    		return f.getPath();
    	}
		return null;
    }
    
    /**
     * 删除所有缓存文件
     */
    public static void deleteAllCacheFiles(){
    	File file = new File(Constants.APP_DIR);
		if(file.exists()){
			deleteFile(file);
		}
    }
    
    /**
     * 删除文件
     * @param file
     */
    private static void deleteFile(File file){
		if(file.isDirectory()){
			File[] fileList = file.listFiles();
			for(File f : fileList){
				deleteFile(f);
			}
		}else{
			file.delete();
		}
	}
    
    /**
	 * 将缓存json数据缓存到sdcard
	 * @param data
	 * @param modelName
	 */
	public static void saveCachePostList(String data, String modelName) {
		try {
			if(isMounted()){
				File file = new File(Constants.POST_CACHE_DIR);
				File fileName = new File(Constants.POST_CACHE_DIR+"/"+modelName+".txt"); 
				if(!file.exists()){
					file.mkdir();
				}
				if(fileName.exists()){
					fileName.delete();
				}
				fileName.createNewFile();
				if(!TextUtils.isEmpty(data)){
					FileOutputStream out = new FileOutputStream(fileName); 
					out.write(data.getBytes());
					out.close(); 
				}
			}
		} catch (Exception e) {
			Log.i(TAG, e.getMessage());
		}
	}
    
    /**
     * 根据主版块名获取缓存在sdcard中的帖子列表
     * @param modelName
     * @return
     */
	public static String getCachePostList(String modelName) {
		String jsonStr = "";
		try {
			File file = new File(Constants.POST_CACHE_DIR+"/"+modelName+".txt");
			FileInputStream fis = new FileInputStream(file);
			byte[] btArr = new byte[fis.available()];
			fis.read(btArr);
			jsonStr = EncodingUtils.getString(btArr, "UTF-8");
			fis.close();
		} catch (Exception e) {
			Log.i(TAG, e.getMessage());
		}
		return jsonStr;
	}
    
    /**
     * 检查sdcard是否存在
     * @return
     */
    private static boolean isMounted(){
    	return Environment.getExternalStorageState().equals(Environment.MEDIA_MOUNTED);
    }
}