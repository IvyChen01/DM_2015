package com.trassion.newstop.http.parse;

import com.trassion.newstop.bean.JavaBean;


public interface UICallBackInterface {

	/**
	 * ���������ص�����
	 * @param bean ���󷵻صĽ����װ����
	 * @param msgId ����id
	 * @param success �����Ƿ�ɹ���ʾ
	 */
	void RequestCallBack(JavaBean bean,int msgId,boolean success);
	
	void RequestError(int errorFlag, String errorMsg);
}
