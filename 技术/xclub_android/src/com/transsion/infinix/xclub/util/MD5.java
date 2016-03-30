package com.transsion.infinix.xclub.util;
import java.security.MessageDigest;   
/**  
 * <pre>
 * MD5���㷨��RFC1321 �ж���
 * ��RFC 1321�У�������Test suite���������ʵ���Ƿ���ȷ��   
 * MD5 ("") = d41d8cd98f00b204e9800998ecf8427e   
 * MD5 ("a") = 0cc175b9c0f1b6a831c399e269772661   
 * MD5 ("abc") = 900150983cd24fb0d6963f7d28e17f72   
 * MD5 ("message digest") = f96b697d7cb7938d525a2f31aaf161d0   
 * MD5 ("abcdefghijklmnopqrstuvwxyz") = c3fcd3d76192e4007dfb496cca67e13b   
 *   </pre>
 * @author ok
 *  
 * ���������һ���ֽ����� 
 * �����������ֽ������ MD5 ����ַ�  
 */  
public final class MD5 {  
	 /**
	  * ��ȡmd5�����ַ���
	  * @param str
	  * @return
	  */
    public static String getMD5(String str) {  
        String reStr = null;  
        try {  
            MessageDigest md = MessageDigest.getInstance("MD5");//��������ָ���㷨���Ƶ���ϢժҪ   
            md.update(str.getBytes("utf-8"));//ʹ��ָ�����ֽڸ���ժҪ��   
            byte ss[] = md.digest();//ͨ��ִ���������֮������ղ�����ɹ�ϣ����   
            reStr = bytes2String(ss);  
        } catch (Exception e) {  
          
        }  
        return reStr;  
    }  
      
    private static String bytes2String(byte[] aa) {//���ֽ�����ת��Ϊ�ַ���   
        String hash = "";  
        for (int i = 0; i < aa.length; i++) {//ѭ������   
            int temp;  
            if (aa[i] < 0)       //���С���㣬�����Ϊ����   
                temp = 256 + aa[i];  
            else  
                temp = aa[i];  
            if (temp < 16)  
                hash += "0";  
            hash += Integer.toString(temp, 16);//ת��Ϊ16����   
        }  
        hash = hash.toLowerCase();//ȫ��ת��ΪСд   
        return hash;  
    }  
}  

