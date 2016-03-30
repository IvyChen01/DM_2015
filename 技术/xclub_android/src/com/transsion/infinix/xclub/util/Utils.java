package com.transsion.infinix.xclub.util;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.bean.FaceBean;


import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.TextUtils;
import android.text.style.ForegroundColorSpan;
import android.text.style.ImageSpan;
import android.util.DisplayMetrics;
import android.util.Log;
import android.util.SparseArray;
import android.view.View;
import android.view.WindowManager;
import android.widget.TextView;



@SuppressLint("SimpleDateFormat")
public class Utils {//\\{:\\d{1}_\\d{2}:\\}	
	private static final String regx=":[(|)|$|@|D|P|L|Q|o]|\\{:\\d{1}_\\d{2}:\\}|;P|:lol|:loveliness:|:funk:|:curse:|:dizzy:|:shutup:|:sleepy:|:hug:|:victory:|:time:|:kiss:|:handshake|:call:|:\\\'[(]";
	public static final Pattern EMOTION_URL = Pattern.compile(regx);
	public static Utils util=null;
	public static Utils getUtils(){
		if(util==null){
			util=new Utils();
		}
		return util;
	}
	private static final String TAG = "Utils";

	public static void warnDeprecation(String depreacted, String replacement) {
		Log.w(TAG, "You're using the deprecated " + depreacted + " attr, please switch over to " + replacement);
	}
	@SuppressLint("SimpleDateFormat")
	public static String getTime(long time) {
		SimpleDateFormat format = new SimpleDateFormat("yyyy/MM/dd HH:mm");
		return format.format(new Date(time));
	}
	@SuppressLint("SimpleDateFormat")
	public static String getDate(String date) {
		SimpleDateFormat format = new SimpleDateFormat("yyyy/MM/dd HH:mm");
		String time = "2013/11/11 00:01";
		try {
			Date d = format.parse(date);
			time=format.format(d);
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}	
		return time;
	}
	public static String getHourAndMin(long time) {
		SimpleDateFormat format = new SimpleDateFormat("HH:mm");
		return format.format(new Date(time));
	}
	public static String toString(String str){
		try {
			if(!TextUtils.isEmpty(str))
			return new String(str.getBytes(),"UTF-8");
		} catch (UnsupportedEncodingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return str;
	}
	
	/**
	* @Title: getParamUrl 
	* @Description: TODO(组装url参数，并编码) 	   
	* @param @param params 参数集合
	* @param @return    设定文件 
	* @return String    返回类型 
	 */
	public String getParamUrl(Map<String,String> params){
		String purl="";
		for(Map.Entry<String, String> entry:params.entrySet()){
			String value="";
			try {
				value=URLEncoder.encode(entry.getValue(), "UTF-8");
			} catch (UnsupportedEncodingException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				value=entry.getValue();
			}
			purl+="&"+entry.getKey()+"="+value;
		}
		return purl;
	}
	/**
	 * 
	   
	* @Title: addLinks 
	   
	* @Description: TODO(在文本框中识别http地址、表情) 
	   
	* @param @param name 用户回复列表对用户名变颜色，不存在name时传入""即可
	* @param @param view    文本控件 
	   
	* @return void    返回类型 
	   
	* @throws
	 */
	public  void addLinks(String name,TextView view) {
	        MyLinkify.TransformFilter mentionFilter = new MyLinkify.TransformFilter() {
	            public final String transformUrl(final Matcher match, String url) {
	                return match.group(1);
	            }
	        };
	        // 匹配@用户和捕获的用户名部分文字
//	        Pattern pattern = Pattern.compile("@([a-zA-Z0-9_\\-\\u4e00-\\u9fa5]+)");
//	        String scheme = "com.coloros.bbs://";
//	        MyLinkify.addLinks(view, pattern, scheme, null, mentionFilter);
//	        pattern = Pattern.compile("#([a-zA-Z0-9_\\-\\u4e00-\\u9fa5]+)#");
//	        scheme = "com.coloros.bbs:topic://";
//	        MyLinkify.addLinks(view, pattern, scheme, null, mentionFilter);

	        MyLinkify.addLinks(view, MyLinkify.WEB_URLS);
	        CharSequence content = view.getText();
	        CharSequence value= convertNormalCharSequenceToSpannableStr(name, content);	
	        view.setText(value);
	 }
	/**
	 * 获取屏幕的宽度
	 * @return
	 */
	public static int getScreenWidth(Context context){
		DisplayMetrics dm = new DisplayMetrics();
		WindowManager wm = (WindowManager) context.getSystemService(Context.WINDOW_SERVICE);
		wm.getDefaultDisplay().getMetrics(dm);
		return dm.widthPixels;
	}
	
	public static String getChatTime(long timesamp) {
		String result = "";
		SimpleDateFormat sdf = new SimpleDateFormat("dd");
		Date today = new Date(System.currentTimeMillis());
		Date otherDay = new Date(timesamp);
		int temp = Integer.parseInt(sdf.format(today))
				- Integer.parseInt(sdf.format(otherDay));

		switch (temp) {
		case 0:
			result = "今天 " + getHourAndMin(timesamp);
			break;
		case 1:
			result = "昨天 " + getHourAndMin(timesamp);
			break;
		case 2:
			result = "前天 " + getHourAndMin(timesamp);
			break;

		default:
			// result = temp + "天前 ";
			result = getTime(timesamp);
			break;
		}

		return result;
	}
	
	/**
	 * 解析表情方法
	 * @param name 用户回复列表对用户名变颜色，不存在name时传入""即可
	 * @param message 传入的需要处理的String
	 * @return
	 */
	public CharSequence convertNormalCharSequenceToSpannableStr(String name,CharSequence message) {
		// TODO Auto-generated method stub
		int ncolor=MasterApplication.getInstanse().getColor();
		SpannableString value = SpannableString.valueOf(message);
		Matcher localMatcher = EMOTION_URL.matcher(value);
		if(!TextUtils.isEmpty(name)){
			int end=name.length();
			value.setSpan(new ForegroundColorSpan(ncolor), 0, end,
					Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
		}
		while (localMatcher.find()) {
			String str2 = localMatcher.group(0);
			int k = localMatcher.start();
			int m = localMatcher.end();
			if (m - k < 15) {
				int face=0;
				if (MasterApplication.getInstanse().getFaceMap()
						.containsKey(str2)) {
					face = MasterApplication.getInstanse().getFaceMap()
							.get(str2);
				}
				if(face==0&&MasterApplication.getInstanse().getFaceMonkey()
						.containsKey(str2)) {
					face = MasterApplication.getInstanse().getFaceMonkey()
							.get(str2);					
				}
				if(face==0&&MasterApplication.getInstanse().getFaceDaidai()
						.containsKey(str2)) {
					face = MasterApplication.getInstanse().getFaceDaidai()
							.get(str2);					
				}
				if(face!=0){
					Bitmap bitmap = BitmapFactory.decodeResource(
							MasterApplication.getInstanse().getResources(), face);
					if (bitmap != null) {
						int rawHeigh = bitmap.getHeight();
						int rawWidth = bitmap.getHeight();
						int newHeight = 50;
						int newWidth = 50;
						// 计算缩放因子
						float heightScale = ((float) newHeight) / rawHeigh;
						float widthScale = ((float) newWidth) / rawWidth;
						// 新建立矩阵
						Matrix matrix = new Matrix();
						matrix.postScale(heightScale, widthScale);
						Bitmap newBitmap = Bitmap.createBitmap(bitmap, 0, 0,
								rawWidth, rawHeigh, matrix, true);						
						ImageSpan localImageSpan = new ImageSpan(MasterApplication.getInstanse(),
								newBitmap, ImageSpan.ALIGN_BASELINE);
						value.setSpan(localImageSpan, k, m,
								Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
					}
				}
				
			}
		}
		
		return value;
	}
	/**
	 * 
	   
	* @Title: deleteFace 
	   
	* @Description: TODO(判断要删除表情开始和结束位置) 
	   
	* @param @param message
	* @param @return    设定文件 
	   
	* @return FaceBean    返回类型 
	   
	* @throws
	 */
	public FaceBean deleteFace(String message){
		String str2=null;
		int i=0;
		FaceBean face=new FaceBean();
		SpannableString value = SpannableString.valueOf(message);
		Matcher localMatcher = EMOTION_URL.matcher(value);
		while (localMatcher.find()) {
			str2 = localMatcher.group(0);
			int s = localMatcher.start();
			int e = localMatcher.end();
			face.setMsg(str2);
			face.setStart(s);
			face.setEnd(message.length());
			i++;
		}
		if(face.getEnd()<=face.getStart()){
			face.setEnd(face.getStart()+1);
		}
		return face;
	}
	
	/**
	 * 读取手机信息（系统版本）
	 */
	public static String getMobileInfoByKey(String key) {
		Properties prop = null;
		FileInputStream fis = null;
		try {
			fis = new FileInputStream("/system/build.prop");
			prop = new Properties();
			prop.load(fis);
		} catch (Exception e) {
			Log.e(TAG, e.getMessage());
		} finally {
			if (fis != null) {
				try {
					fis.close();
				} catch (IOException e) {
					Log.e(TAG, e.getMessage());
				}
			}
		}
		return prop.getProperty(key);
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
     * @brief 存储大小格式化为可阅读的字串
     */
    public static String readableFileSize(long size) {
        if (size <= 0)
            return "0";
        final String[] units = new String[] { "B", "KB", "MB", "GB", "TB" };
        int digitGroups = (int) (Math.log10(size) / Math.log10(1024));
        return new DecimalFormat("#,##0.#").format(size / Math.pow(1024, digitGroups)) + " "
                + units[digitGroups];
    }
    /**
     * 取得文件夹大小
     * @param f
     * @return
     * @throws Exception
     */
    public static long getFileSize(File f){
		long size = 0;
		try {
			File flist[] = f.listFiles();
			for (int i = 0; i < flist.length; i++) {
				if (flist[i].isDirectory()) {
					size = size + getFileSize(flist[i]);
				} else {
					size = size + flist[i].length();
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
			Log.e(TAG, e.getMessage());
		}
		return size;
    }
    
	/**
	 * 删除指定目录下的文件（删除缓存）
	 * 
	 * @param path
	 * @return
	 */
	public static boolean delAllFile(String path) {
		boolean flag = false;
		File file = new File(path);
		if (!file.exists()) {
			return flag;
		}
		if (!file.isDirectory()) {
			return flag;
		}
		String[] tempList = file.list();
		File temp = null;
		for (int i = 0; i < tempList.length; i++) {
			if (path.endsWith(File.separator)) {
				temp = new File(path + tempList[i]);
			} else {
				temp = new File(path + File.separator + tempList[i]);
			}
			if (temp.isFile()) {
				temp.delete();
			}
			if (temp.isDirectory()) {
				delAllFile(path + "/" + tempList[i]);// 先删除文件夹里面的文件
				flag = true;
			}
		}
		return flag;
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
			Log.e(TAG, e.getMessage());
		}
     
        return size;
    }
	
	public static boolean isPicture(String pInput, String pImgeFlag)
			throws Exception {
		// 文件名称为空的场合
		if (TextUtils.isEmpty(pInput)) {
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
			if (!TextUtils.isEmpty(pImgeFlag)
					&& imgeArray[i][0].equals(tmpName.toLowerCase())
					&& imgeArray[i][1].equals(pImgeFlag)) {
				return true;
			}
			// 判断符合全部类型的场合
			if (TextUtils.isEmpty(pImgeFlag)
					&& imgeArray[i][0].equals(tmpName.toLowerCase())) {
				return true;
			}
		}
		return false;
	}
	
	public static String createCommaString(ArrayList<String> strList){
		StringBuilder sb = new StringBuilder();
		for(String str : strList){
			sb.append(str);
			sb.append(",");
		}
		String s = sb.substring(0, sb.length()-1);
		return s;
	}
	
}
