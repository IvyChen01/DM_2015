package com.trassion.newstop.http;

import java.io.File;
import java.nio.charset.Charset;
import java.util.Map;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpRequestBase;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.CoreConnectionPNames;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;

import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.tool.LogUtil;
import com.trassion.newstop.tool.NetworkUtil;

import android.util.Log;


/**
 * ��������
 * 
 * @author liuy
 */
public class HttpConnet {

	private static final String TAG = HttpConnet.class.getSimpleName();
	private Request mrequest;
	private HttpRequestBase requestBase;
	private DefaultHttpClient defaultHttpClient;

	public HttpConnet(Request mrequest) {
		super();
		this.mrequest = mrequest;
	}

	/**
	 * ��������
	 */
	protected void netWork() {
		Response response = new Response();
		response.msgId = mrequest.getMsgId();
//		response.modelName = mrequest.getModelName();
		response.url = mrequest.getURL();

		if (((response.data == null || response.data.length() == 0) && NetworkUtil
				.isOnline(mrequest.getContext()))) {
			LogUtil.i(TAG, "The request url = " + mrequest.getURL());
			if (mrequest.isPost()) {
				requestBase = new HttpPost(mrequest.getURL());
			} else {
				requestBase = new HttpGet(mrequest.getURL());
			}
			// �ϴ�ͼƬ���ϴ�ͷ��
			if (mrequest.getMsgId() == NewsApplication.HTTP_UPLOAD_FILE_ID
					|| mrequest.getMsgId() == NewsApplication.HTTP_UPLOAD_PIC_ID
					|| mrequest.getMsgId() == NewsApplication.HTTP_MODFIY_AVATAR) {
				// �ϴ�ͼƬ���õ����ķ���
				try {
					defaultHttpClient = new DefaultHttpClient();
					HttpParams params = defaultHttpClient.getParams();
					HttpConnectionParams.setConnectionTimeout(params, 60000);
					HttpConnectionParams.setSoTimeout(params, 60000);
					HttpConnectionParams.setSocketBufferSize(params, 1024 * 20);

					MultipartEntity reqEntity = new MultipartEntity();
					Map<String, String> mapparams = mrequest.getParams();
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
					HttpPost post = new HttpPost(mrequest.getURL());
					post.setEntity(reqEntity);
					HttpResponse httpResponse = defaultHttpClient.execute(post);
					response.resultCode = httpResponse.getStatusLine()
							.getStatusCode();
					// ��ȡhttp��Ӧʵ������
					HttpEntity entity = httpResponse.getEntity();
					response.data = EntityUtils.toString(entity);
					Log.i("response", "reksponse.data = " + response.data
							+ " code: " + response.resultCode);

				} catch (Exception e) {
					LogUtil.e(TAG, e.getMessage());
					Log.i("Handle", "���糬ʱ");
					mrequest.getListener().httpClientError(response.resultCode,
							null, response.url);
				}
			} else {
				HttpResponse httpResponse = null;
				try {
					setHttpHeader();
					defaultHttpClient = new DefaultHttpClient();
					HttpParams params = defaultHttpClient.getParams();
					HttpConnectionParams.setConnectionTimeout(params, 30000);
					HttpConnectionParams.setSoTimeout(params, 30000);
					
					httpResponse = defaultHttpClient.execute(requestBase);
					// ��ȡ��������Ӧ��
					response.resultCode = httpResponse.getStatusLine()
							.getStatusCode();
					// ��ȡhttp��Ӧʵ������
					HttpEntity entity = httpResponse.getEntity();
					response.data = EntityUtils.toString(entity);
					Log.i("response", "response.data = " + response.data);
				} catch (Exception e) {
					LogUtil.e(TAG, e.getMessage());
					Log.i("Handle", "���糬ʱ");
					mrequest.getListener().httpClientError(response.resultCode,
							null, response.url);
				}
				// �ͷ�����ռ�õ���Դ
				defaultHttpClient.getConnectionManager().shutdown();
			}
		}
		if (mrequest.getListener() != null) {
			// http�ص�
			if (response.resultCode == 200 && response.data != null) {
				
				mrequest.getListener().httpClientCallBack(response);
			} else {
				mrequest.getListener().httpClientError(response.resultCode,
						null, response.url);
			}
		}
	}

	public DefaultHttpClient getDefaultHttpClient() {
		return defaultHttpClient;
	}

	/**
	 * ����HTTPЭ�������ĵ���������Ϣ�ͱ�ͷ��Ϣ
	 * 
	 * @throws Exception
	 */
	protected void setHttpHeader() throws Exception {
		if (requestBase != null) {
			requestBase.setHeader("Accept", "*/*");
			requestBase.setHeader("Pragma", "no-cache");
			requestBase.setHeader("Cache-Control", "no-cache");
			requestBase.setHeader("User-Agent", "android");
			// if (mrequest.getParam() != null) {
			// //String src = JSON.toJSONString(mrequest.getBean());
			// // Log.e("Httpconnect", "requst data-->"+src);
			// CustomContentProducer cp = new CustomContentProducer();
			// //cp.sendBody = src.getBytes("utf-8");
			// HttpEntity entity = new EntityTemplate(cp);
			// ((HttpPost) requestBase).setEntity(entity);
			// }
		}
	}

	/*
	 * // ���network public boolean isNetworkAvailable(Context context) {
	 * ConnectivityManager connectivity = (ConnectivityManager) context
	 * .getSystemService(Context.CONNECTIVITY_SERVICE); if (connectivity ==
	 * null) { Toast.makeText(context, R.string.common_cannot_connect,
	 * Toast.LENGTH_LONG).show(); } else { NetworkInfo[] info =
	 * connectivity.getAllNetworkInfo(); if (info != null) { for (int i = 0; i <
	 * info.length; i++) { if (info[i].getState() ==
	 * NetworkInfo.State.CONNECTED) { return true; } } } } return false; }
	 */

	public Request getMrequest() {
		return mrequest;
	}

	public void setMrequest(Request mrequest) {
		this.mrequest = mrequest;
	}
}
