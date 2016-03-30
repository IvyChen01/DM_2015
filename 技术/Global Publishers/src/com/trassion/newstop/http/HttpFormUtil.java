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
* @Description: TODO(HTTPЭ���ύ���ݵ�������,ʵ�ֱ��ύ������)
* @author zx
* @date 2014-1-18 ����4:14:53
*
 */
public class HttpFormUtil {
	
	private static DefaultHttpClient defaultHttpClient;

	/** 
	 * ֱ��ͨ��HTTPЭ���ύ���ݵ�������,ʵ�ֱ��ύ���� 
	 * @param actionUrl �ϴ�·�� 
	 * @param params ������� keyΪ������,valueΪ����ֵ 
	 * @param file �ϴ��ļ� 
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
				if (!"filePath".equals(entry.getKey())) {// filePath��������Ҫ����ֻ�������õ�
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
			Log.i("Handle", "���糬ʱ");
		}
		return null;
	}
	
}