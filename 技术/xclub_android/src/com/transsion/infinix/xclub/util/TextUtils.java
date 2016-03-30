package com.transsion.infinix.xclub.util;

import java.io.File;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.os.Build;
import android.telephony.TelephonyManager;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.style.ForegroundColorSpan;
import android.util.Log;
import android.util.SparseArray;
import android.view.View;

public class TextUtils {

	/**
	 * 判断字符串是否为空
	 */
	public static boolean isEmpty(String str) {
		return (str == null|| str.equals("null") ||str.equals("")|| str
				.equals("null null"));//
	}
    /**
     * 判断字符串是否为空
     * @param str
     * @return
     */
	public static boolean isNotEmpty(String str) {
		return !isEmpty(str);
	}
	/**
	 * 公用的ViewHolder
	 * @param view
	 * @param id
	 * @return
	 */
	@SuppressWarnings("unchecked")
	public static <T extends View> T get(View view, int id) {
		SparseArray<View> viewHolder = (SparseArray<View>) view.getTag();
		if (viewHolder == null) {
			viewHolder = new SparseArray<View>();
			view.setTag(viewHolder);
		}
		View childView = viewHolder.get(id);
		if (childView == null) {
			childView = view.findViewById(id);
			viewHolder.put(id, childView);
		}
		return (T) childView;
	}
	/**
	 * 获取目录文件个数
	 * @param f
	 * @return
	 */
	public static long getFileNum(File f){
        long size = 0;
		try {
			File flist[] = f.listFiles();
			size = flist.length;
			for (int i = 0; i < flist.length; i++) {
				if (!isPicture(flist[i].getPath(), "")) {
					size--;
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
			Log.e("info", e.getMessage());
		}
     
        return size;
    }
	public static boolean isPicture(String pInput, String pImgeFlag)
			throws Exception {
		// 文件名称为空的场合
		if (isEmpty(pInput)) {
			// 返回不和合法
			return false;
		}
		// 获得文件后缀名
		String tmpName = pInput.substring(pInput.lastIndexOf(".") + 1,
				pInput.length());
		// 声明图片后缀名数组
		String imgeArray[][] = { { "bmp", "0" }, { "dib", "1" },
				{ "gif", "2" }, { "jfif", "3" }, { "jpe", "4" },
				{ "jpeg", "5" }, { "jpg", "6" }, { "png", "7" },
				{ "tif", "8" }, { "tiff", "9" }, { "ico", "10" } };
		// 遍历名称数组
		for (int i = 0; i < imgeArray.length; i++) {
			// 判断单个类型文件的场合
			if (!isEmpty(pImgeFlag)
					&& imgeArray[i][0].equals(tmpName.toLowerCase())
					&& imgeArray[i][1].equals(pImgeFlag)) {
				return true;
			}
			// 判断符合全部类型的场合
			if (isEmpty(pImgeFlag)
					&& imgeArray[i][0].equals(tmpName.toLowerCase())) {
				return true;
			}
		}
		return false;
	}
	/**
	 * 获取手机型号
	 * @param context
	 * @return
	 */
	public static String getPhoneModel(Context context)
	{
		String model = "";
		TelephonyManager phoneMgr=(TelephonyManager)context.getSystemService(Context.TELEPHONY_SERVICE);
		return Build.MODEL;//手机型号
		
	}
	public static float getScreenDensity(Context context) {
		return context.getResources().getDisplayMetrics().density;
	}

	public static int dip2px(Context context, float px) {
		final float scale = getScreenDensity(context);
		return (int) (px * scale + 0.5);
	}
	/**
	 * 搜索关键字标红
	 * @param title
	 * @param keyword
	 * @return
	 */
	public static String matcherSearchTitle(String title,String keyword){
		String content = title;  
		String wordReg = "(?i)"+keyword;//用(?i)来忽略大小写  
		StringBuffer sb = new StringBuffer();  
		Matcher matcher = Pattern.compile(wordReg).matcher(content);  
		while(matcher.find()){  
			
			//这样保证了原文的大小写没有发生变化
			matcher.appendReplacement(sb, matcher.group());
		}  
		matcher.appendTail(sb);  
		content = sb.toString(); 
		//如果匹配和替换都忽略大小写,则可以用以下方法
//		content = content.replaceAll(wordReg,"<font color=\"#ff0014\">"+keyword+"</font>"); 
		Log.i("info", "content:"+content);
		return content;
	}
	/**
	 * 搜索关键字标绿
	 * @param txt
	 * @param keyword
	 * @return
	 */
	@SuppressWarnings("unused")
	public static SpannableString getString(String txt, String keyword) {
//		keyword = "[" + keyword + "]";
        SpannableString s = new SpannableString(txt);
        Pattern p = Pattern.compile(keyword, Pattern.CASE_INSENSITIVE);
        Matcher m = p.matcher(s);
        while (m.find()) {
            int start = m.start();
            int end = m.end();
            s.setSpan(new ForegroundColorSpan(Color.parseColor("#91C347")), start, end, Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        }
        return s;
	}

	/**
	 * 去掉文本内容中的特殊字符
	 * @param message
	 * @return
	 */
	public static String replaceChart(String message) {
		String newMessage = "";
		if(!TextUtils.isEmpty(message)){
			String rex = "\\s|&.*?;";
			String res="//us";
//			newMessage = message.replace("&nbsp;", "").replace(" &nbsp;", "").replace("&quot;", "").replace("&quot;", "").replace(" &gt;","")
//		       .replace("&lt;", "").replace("&amp;", "").replace("&nbsp", "").replace("\n", "").replace("&rsaquo", "")
//			 .replace("&nbs ...", "").replace("&nbsp...", "");
			 String mMessage=message.replaceAll("\\s+",res);
			String newmessage = mMessage.replaceAll(rex, "");
			newMessage = newmessage.replaceAll(res, " ");
		}
		return newMessage;
	}
	public static Bitmap getBitmap(String imgPath) {  
        // Get bitmap through image path  
        BitmapFactory.Options newOpts = new BitmapFactory.Options();  
        newOpts.inJustDecodeBounds = false;  
        newOpts.inPurgeable = true;  
        newOpts.inInputShareable = true;  
        // Do not compress  
        newOpts.inSampleSize = 1;  
        newOpts.inPreferredConfig = Config.RGB_565;  
        return BitmapFactory.decodeFile(imgPath, newOpts);  
    }
}
