package com.transsion.infinix.xclub.image;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStream;
import java.util.Arrays;
import java.util.Comparator;
import java.util.Iterator;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

import com.transsion.infinix.xclub.constact.Constant;


import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Environment;
import android.os.StatFs;
import android.util.Log;


public class ImageCache {

	private static final String WHOLESALE_CONV = ".cach";
	private static final int MB = 1024 * 1024;
	private static final int CACHE_SIZE = 30;
	private static final int FREE_SD_SPACE_NEEDED_TO_CACHE = 30;
	private static final String TAG = ImageCache.class.getSimpleName();
	private ConcurrentHashMap<String, Bitmap> cacheTable = null;

	public ImageCache() {
		cacheTable = new ConcurrentHashMap<String, Bitmap>();
		// 清理文件缓存
		removeCache(getDirectory());
	} 
	
	//�?��时显式调用，如果没有调用，可能会有内存泄�?
	@SuppressWarnings("rawtypes")
	public void release() {
		Iterator iter = cacheTable.entrySet().iterator(); 
		while (iter.hasNext()) { 
			Map.Entry entry = (Map.Entry) iter.next(); 
		    Bitmap bitmap = (Bitmap) entry.getValue();
		    if (bitmap != null && !bitmap.isRecycled()) {
		    	Log.i(TAG, entry.getKey() + "will be recycle!");
		    	bitmap.recycle();
		    }
		}  
	}
	
	/** 从缓存中获取图片 **/
	public Bitmap getImage(final String url) {
		try{
			final String path = getDirectory() + "/" + convertUrlToFileName(url);
			if (cacheTable.containsKey(path)) {
				Log.i(TAG, "cacheTable has record! path  "+path);
				return cacheTable.get(path);
			}
			File file = new File(path);
			
			if (file.exists()) {
				//Bitmap bmp = BitmapFactory.decodeFile(path);
				FileInputStream fis = new FileInputStream(file);
				Bitmap bmp = BitmapFactory.decodeStream(fis);
				if (bmp == null) {
					file.delete();
				} else {
					updateFileTime(path);
					cacheTable.put(path, bmp);
					return bmp;
				}
			}
		}catch(Exception e){
			e.printStackTrace();
		}
		
		return null;
	} 
	
	/** 将图片存入文件缓�?**/
	public void saveBitmap(Bitmap bm, String url) {
		if (bm == null) {
			return;
		}
		// 判断sdcard上的空间
		if (FREE_SD_SPACE_NEEDED_TO_CACHE > freeSpaceOnSd()) {
			// SD空间不足
			return;
		}
		
		String filename = convertUrlToFileName(url);
		String dir = getDirectory();
		File dirFile = new File(dir);
		if (!dirFile.exists())
			dirFile.mkdirs();
		File file = new File(dir + "/" + filename);
		try {
			file.createNewFile();
			OutputStream outStream = new FileOutputStream(file);
			bm.compress(Bitmap.CompressFormat.JPEG, 100, outStream);
			outStream.flush();
			outStream.close();
			cacheTable.put(file.getAbsolutePath(), bm);
		} catch (FileNotFoundException e) {
			Log.w("ImageFileCache", "FileNotFoundException");
		} catch (IOException e) {
			Log.w("ImageFileCache", "IOException");
		}
	}

	/**
	 * 计算存储目录下的文件大小�? 
	 * 当文件�?大小大于规定的CACHE_SIZE或�?sdcard剩余空间小于FREE_SD_SPACE_NEEDED_TO_CACHE的规�? *
	 * 那么删除40%�?��没有被使用的文件  
	 */
	private boolean removeCache(String dirPath) {
		 
		File dir = new File(dirPath);
		File[] files = dir.listFiles();
		if (files == null) {
			return true;
		}
		if (!android.os.Environment.getExternalStorageState().equals(
				android.os.Environment.MEDIA_MOUNTED)) {
			return false;
		}
		int dirSize = 0;
		for (int i = 0; i < files.length; i++) {
			if (files[i].getName().contains(WHOLESALE_CONV)) {
				dirSize += files[i].length();
			}
		}
		if (dirSize > CACHE_SIZE * MB
				|| FREE_SD_SPACE_NEEDED_TO_CACHE > freeSpaceOnSd()) {
			int removeFactor = (int) ((0.4 * files.length) + 1);
			Arrays.sort(files, new FileLastModifSort());
			for (int i = 0; i < removeFactor; i++) {
				if (files[i].getName().contains(WHOLESALE_CONV)) {
					files[i].delete();
				}
			}
		}
		if (freeSpaceOnSd() <= CACHE_SIZE) {
			return false;
		}
		return true;
	}

	/** 修改文件的最后修改时�?**/
	public void updateFileTime(String path) {
		File file = new File(path);
		long newModifiedTime = System.currentTimeMillis();
		file.setLastModified(newModifiedTime);
	}

	/** 计算sdcard上的剩余空间 **/
	private int freeSpaceOnSd() {
		StatFs stat = new StatFs(Environment.getExternalStorageDirectory()
				.getPath());
		double sdFreeMB = ((double) stat.getAvailableBlocks() * (double) stat
				.getBlockSize()) / MB;
		return (int) sdFreeMB;
	}

	/** 将url转成文件�?**/
	private String convertUrlToFileName(String url) {
		String[] strs = url.split("/");
		return strs[strs.length - 1] + WHOLESALE_CONV;
	}

	/** 获得缓存目录 **/
	private String getDirectory() {
		String dir = Constant.APP_DIR + Constant.CACHE_DIR;
		return dir;
	}

	/**
	 *  * 根据文件的最后修改时间进行排�? 
	 */
	private class FileLastModifSort implements Comparator<File> {
		public int compare(File arg0, File arg1) {
			if (arg0.lastModified() > arg1.lastModified()) {
				return 1;
			} else if (arg0.lastModified() == arg1.lastModified()) {
				return 0;
			} else {
				return -1;
			}
		}
	}

}
	