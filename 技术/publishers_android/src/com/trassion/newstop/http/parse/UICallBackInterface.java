package com.trassion.newstop.http.parse;

import com.trassion.newstop.bean.JavaBean;


public interface UICallBackInterface {

	/**
	 * 界面端请求回调函数
	 * @param bean 请求返回的结果封装数据
	 * @param msgId 请求id
	 * @param success 请求是否成功标示
	 */
	void RequestCallBack(JavaBean bean,int msgId,boolean success);
	
	void RequestError(int errorFlag, String errorMsg);
}
