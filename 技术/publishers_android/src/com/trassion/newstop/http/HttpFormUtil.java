package com.trassion.newstop.http;



import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.File;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.Charset;
import java.util.Map;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;

import android.util.Log;


/**
 * 
* @ClassName: HttpFormUtil
* @Description: TODO(HTTP协议提交数据到服务器,实现表单提交功能类)
* @author zx
* @date 2014-1-18 下午4:14:53
*
 */
public class HttpFormUtil {
	
	private static DefaultHttpClient defaultHttpClient;

	/** 
	 * 直接通过HTTP协议提交数据到服务器,实现表单提交功能 
	 * @param actionUrl 上传路径 
	 * @param params 请求参数 key为参数名,value为参数值 
	 * @param file 上传文件 
	 */  
	public static String post(String url, Map<String, String> mParams) { 
		try {
			defaultHttpClient = new DefaultHttpClient();
			HttpParams params = defaultHttpClient.getParams();
			HttpConnectionParams.setConnectionTimeout(params, 60000*3);
			HttpConnectionParams.setSoTimeout(params, 60000*3);
			HttpConnectionParams.setSocketBufferSize(params, 1024 * 20);

			MultipartEntity reqEntity = new MultipartEntity();
			Map<String, String> mapparams = mParams;
			for (Map.Entry<String, String> entry : mapparams.entrySet()) {
				if (!"filePath".equals(entry.getKey())) {// filePath参数不需要传，只是下面用到
					Log.i("String.valueOf(entry.getValue())",
							String.valueOf(entry.getValue()));
					reqEntity.addPart(entry.getKey(), new StringBody(
							String.valueOf(entry.getValue())));
				}
			}
			File file = new File(mapparams.get("filePath"));
			reqEntity.addPart("name", new StringBody(file.getName(), Charset.forName("UTF-8")));
			reqEntity.addPart("Filedata", new FileBody(file,"application/octet-stream"));
			HttpPost post = new HttpPost(url);
			post.setEntity(reqEntity);
			HttpResponse httpResponse = defaultHttpClient.execute(post);
			
			 if (httpResponse.getStatusLine().getStatusCode() == 200) {

	                HttpEntity httpEntity = httpResponse.getEntity();

	                InputStream is = httpEntity.getContent();

	                StringBuffer sb = new StringBuffer();

	                BufferedReader br = new BufferedReader(
	                        new InputStreamReader(is));
	                String line = null;
	                while ((line = br.readLine()) != null)
	                {
	                    sb.append(line);
	                }
	                //
	                return sb.toString();
	            } else
	            {
	                return null;
	            }
			

		} catch (Exception e) {
			e.printStackTrace();
//			Log.e("info", e.getMessage());
			Log.i("Handle", "网络超时");
		}
		return null;
	}
	
}