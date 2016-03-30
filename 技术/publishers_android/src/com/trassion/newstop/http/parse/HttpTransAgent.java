package com.trassion.newstop.http.parse;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;

import org.json.JSONException;
import org.json.JSONObject;

import com.alibaba.fastjson.JSON;
import com.trassion.newstop.activity.R;
import com.trassion.newstop.application.NewsApplication;
import com.trassion.newstop.bean.BeanFactory;
import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.http.HttpListener;
import com.trassion.newstop.http.HttpNetService;
import com.trassion.newstop.http.Progress;
import com.trassion.newstop.http.Request;
import com.trassion.newstop.http.Response;
import com.trassion.newstop.image.FileCache;
import com.trassion.newstop.tool.LogUtil;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.Utils;

import android.content.Context;
import android.graphics.drawable.AnimationDrawable;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.TableLayout.LayoutParams;
import android.widget.Toast;



/**
 * ҵ���߼����ݴ���
 * 
 * @author Administrator
 */
public class HttpTransAgent implements HttpListener {

	private static final String TAG = HttpTransAgent.class.getSimpleName();
	private HashMap<String, Request> requestMap;
	private UICallBackInterface uicallback;
	private Progress progressDialog, uploadDialog;//����ģ�����ϴ�dialog;
	private Handler handler;
	private Context mContext;
	private Object obj = new Object();
	public boolean isShowProgress = true;
	//����ȡ�������б���������
	private boolean isBackCancel = false;
	public static Toast toast=null;
	public boolean hasShowProgress = false;
	/**
	 * �����ص�����
	 * 
	 * @param mcontext
	 * @param callback
	 */
	public HttpTransAgent(Context context, UICallBackInterface callback) {
		super();
		uicallback = callback;
		requestMap = new HashMap<String, Request>();
		mContext = context;
		handler = new Handler(new Handler.Callback() {
			
			@Override
			public boolean handleMessage(Message msg) {
				String errorMsg = "";
				switch (msg.what) {
				// ��������ɹ�
				case NewsApplication.MSG_REQUEST_SUCCESS:
					if (uicallback != null) {
						uicallback.RequestCallBack((JavaBean) msg.obj,
								msg.arg1, true);
					}
					break;
				// ����ʧ��
				case NewsApplication.MSG_REQUEST_ERROR:
					errorMsg = mContext.getString(R.string.common_request_error);
					if (uicallback != null)uicallback.RequestError(msg.what,errorMsg);
					break;
				case NewsApplication.MSG_PARA_ERROR:
					errorMsg = mContext.getString(R.string.common_param_error);
					if (uicallback != null)uicallback.RequestError(msg.what,errorMsg);
					break;
				case NewsApplication.MSG_NET_ERROR:
					errorMsg = mContext.getString(R.string.common_cannot_connect);
					if (uicallback != null)uicallback.RequestError(msg.what,errorMsg);
					break;
				case NewsApplication.MSG_CANCEL_REQUEST:
					if (uicallback != null)uicallback.RequestError(msg.what,errorMsg);
					break;
				default:
					break;
				}
				
				return true;
			}
		});
	}
	
	/**
	 * ����
	 * 
	 * @param url
	 *            �ӿڵ�ַ
	 * @param msgId
	 *            ��Ϣid�����־����ĸ��ӿ�
	 * @param ispost
	 *            �Ƿ���post���� trueΪPost falseΪget
	 * @param modelName ��������ƣ�������ʶ���������б���Ϣ��
	 */
	public void sendRequst(String url, int msgId, boolean ispost,String modelName) {
		if (Utils.isEmpty(url)) {
			handler.sendEmptyMessage(NewsApplication.MSG_PARA_ERROR);
		} else {
			if (NetworkUtil.isOnline(mContext)) {
				Request request = new Request(url, msgId, this, mContext,modelName);
				request.setPost(ispost);
				requestMap.put(url, request);
				if (isShowProgress){
					startprogress(null,msgId);
				}
				HttpNetService.getInstance().sendRequest(request);
			} else {
				handler.sendEmptyMessage(NewsApplication.MSG_NET_ERROR);
			}
		}
	}
	/**
	 * 
	* @Title: sendRequstMap 
	   
	* @Description: TODO(�ϴ��ļ���ͼƬ) 
	   
	* @param @param url
	* @param @param msgId
	* @param @param params
	* @param @param modelName    �趨�ļ� 
	   
	* @return void    �������� 
	   
	* @throws
	 */
	public void sendRequstMap(String url, int msgId,Map<String,String> params) {
		if (Utils.isEmpty(url)) {
			handler.sendEmptyMessage(NewsApplication.MSG_PARA_ERROR);
		} else {
			if (NetworkUtil.isOnline(mContext)) {
				Request request = new Request(url, msgId, this, mContext,params);
				request.setPost(true);
				requestMap.put(url, request);
				if (isShowProgress)
					startprogress(null,msgId);
				HttpNetService.getInstance().sendRequest(request);
			} else {
				handler.sendEmptyMessage(NewsApplication.MSG_NET_ERROR);
			}
		}
	}
	public void startprogress(String msg,int flag) {
		try {
			if (progressDialog == null || !progressDialog.isShowing()) {
				// Ĭ�����б����ļ��ؿ�
				int theme = R.style.CustomProgressDialog;
				progressDialog = new Progress(mContext, this, theme);
				if (msg == null) {
					msg = mContext.getString(R.string.common_handling);
				}
				progressDialog.show();
				View convertView = progressDialog.getLayoutInflater().inflate(
						R.layout.view_progresslayout, null);
				ImageView gifview = (ImageView) convertView.findViewById(R.id.gifView);
				AnimationDrawable anim = null;
				Object ob = gifview.getBackground();
				anim =(AnimationDrawable)ob;
				anim.stop();
				anim.start();
				progressDialog.setContentView(convertView, new LayoutParams());
			}
		} catch (Exception e) {
			e.printStackTrace();
		}

	}
	/**
	 * ��ʾ����ģ����dialog
	 * @param msg
	 * @param flag
	 */
	public void startUploadProgress(String msg,int flag) {
		try {
			if (uploadDialog == null || !uploadDialog.isShowing()) {
				// Ĭ�����б����ļ��ؿ�
				int theme = R.style.CustomDimProgressDialog;
				uploadDialog = new Progress(mContext, this, theme);
				if (msg == null) {
					msg = mContext.getString(R.string.common_handling);
				}
				uploadDialog.show();
				View convertView = uploadDialog.getLayoutInflater().inflate(
						R.layout.view_progresslayout, null);
				ImageView gifview = (ImageView) convertView.findViewById(R.id.gifView);
				AnimationDrawable anim = null;
				Object ob = gifview.getBackground();
				anim =(AnimationDrawable)ob;
				anim.stop();
				anim.start();
				uploadDialog.setContentView(convertView, new LayoutParams());
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}

	public void closeProgress() {
		if (progressDialog != null && progressDialog.isShowing()
				&& requestMap.size() == 0) {
			progressDialog.progressCancel(false);
			HttpNetService.getInstance().shutDownPool();
		}
	}
	
	public void closeUploadProgress() {
		if (uploadDialog != null && uploadDialog.isShowing()) {
			uploadDialog.progressCancel(false);
			HttpNetService.getInstance().shutDownPool();
		}
	}

	/**
	 * �������ݷ��أ��˷�����ȡ��response�����ݣ�ѡ����ʵ�ʵ����󣬽������ݽ���
	 */
	@Override
	public void httpClientCallBack(Response response) {
		synchronized (obj) {
			if (response.data != null) {
				JavaBean bean = BeanFactory.getInstance().productionBean(
						response.msgId);
				try {
					String modelName = NewsApplication.modelName;
					if(Utils.isNotEmpty(modelName)){
						saveCache(response.data,modelName);
					}
					bean = JSON.parseObject(response.data, bean.getClass());
				} catch (Exception e) {
					handler.sendEmptyMessage(NewsApplication.MSG_REQUEST_ERROR);
					LogUtil.e(TAG, e.getMessage());
				} finally {
					if (bean == null) {
						handler.sendEmptyMessage(NewsApplication.MSG_REQUEST_ERROR);
					} else {
						inintHandlerMessage(NewsApplication.MSG_REQUEST_SUCCESS,
								response.msgId, bean);
					}
					HttpNetService.getInstance().removeNet(
							requestMap.get(response.url), false);
					requestMap.remove(response.url);					
					closeProgress();
					// �������ͬʱ����ʱ,ȷ������ȫ������
					// if (requestMap.size() == 0) {
					// inintHandlerMessage(0, 100, null);
					// }
					// handler.obtainMessage(0);
				}
			}
		}
	}
	
	/**
	 * �����������Ͱ�������
	 * @param data
	 * @return
	 */
	/*private HashMap<String, ArrayList<ThreadType>> parseThreadTypesData(String data){
		HashMap<String, ArrayList<ThreadType>> map = new HashMap<String, ArrayList<ThreadType>>();
		try {
			JSONObject obj = new JSONObject(data);
			JSONObject varObj = obj.getJSONObject("Variables");
			JSONObject group = varObj.getJSONObject("threadtypes");
			Iterator<String> gIter = group.keys();
			while(gIter.hasNext()){
				ArrayList<ThreadType> valueList = new ArrayList<ThreadType>();
				String groupKey = gIter.next();
				if(!group.isNull(groupKey)){
					JSONObject child = group.getJSONObject(groupKey);
					Iterator<String> cIter = child.keys();
					while(cIter.hasNext()){
						ThreadType t = new ThreadType();
						t.id = cIter.next();
						t.name = child.getString(t.id);
						valueList.add(t);
					}
					map.put(groupKey, valueList);
				}
				
			}
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return map;
	}*/

	@Override
	public void httpClientError(int resultCode, String dec, String url) {
		synchronized (obj) {
			// requestMap.remove(url);
			HttpNetService.getInstance().removeNet(requestMap.get(url), false);
			requestMap.remove(url);
			closeProgress();
			if (dec == null && !isBackCancel) {
				Log.d(TAG, "���糬ʱ");
				handler.sendEmptyMessage(NewsApplication.MSG_NET_ERROR);
			}
		}
	}

	protected void inintHandlerMessage(int type, int msgId, JavaBean bean) {
		Message msg = new Message();
		msg.obj = bean;
		msg.what = type;
		msg.arg1 = msgId;
		handler.sendMessage(msg);
	}

	public void cancel(boolean isAuto) {
		isBackCancel = isAuto;
		Iterator<Entry<String, Request>> iter = requestMap.entrySet()
				.iterator();
		while (iter.hasNext()) {
			Entry<String, Request> entry = iter.next();
			Request val = entry.getValue();
			HttpNetService.getInstance().removeNet(val, true);

		}
		requestMap.clear();
		if(isAuto){
			Log.d(TAG, "������ȡ���������󡣡���");
			handler.sendEmptyMessage(NewsApplication.MSG_CANCEL_REQUEST);
		}
	}
	public void ShowToast(String msg){
		if (toast != null) {
			toast.cancel();
		}
		toast = Toast.makeText(mContext, msg, Toast.LENGTH_SHORT);		
		toast.show();
	}
	
	/**
	 * ��������Ϣ���浽����
	 * @param data
	 * @param modelName
	 */
	private void saveCache(String data,String modelName){
		FileCache.saveCachePostList(data, modelName);
	}
}
