package com.trassion.newstop.tool;

import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

/**
 * 
* @ClassName: Md5Util
* @Description: TODO(MD5加密工具类)
* @author zx
* @date 2014-2-28 下午2:32:01
*
 */
public class Md5Util {
	
	/**
	 * 
	* @Title: MD5 
	* @Description: TODO(MD5加密方法) 
	* @param @param s
	* @param @return    设定文件 
	* @return String    返回类型 
	* @throws
	 */
	public final static String MD5(String s) {
		 try
		  {
		    MessageDigest md5 = MessageDigest.getInstance("MD5");
		    md5.update(s.getBytes("UTF-8"));
		    byte[] encryption = md5.digest();
		      
		    StringBuffer strBuf = new StringBuffer();
		    for (int i = 0; i < encryption.length; i++)
		    {
		      if (Integer.toHexString(0xff & encryption[i]).length() == 1)
		      {
		        strBuf.append("0").append(Integer.toHexString(0xff & encryption[i]));
		      }
		      else
		      {
		        strBuf.append(Integer.toHexString(0xff & encryption[i]));
		      }
		    }
		      
		    return strBuf.toString();
		  }
		  catch (NoSuchAlgorithmException e)
		  {
		    return "";
		  }
		  catch (UnsupportedEncodingException e)
		  {
		    return "";
		  }
	}
}
