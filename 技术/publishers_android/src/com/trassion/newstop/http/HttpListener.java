package com.trassion.newstop.http;

/**
 * @Title ����ص�����
 * @Description
 * @author chen
 * @since 2015-10-7
 * @version
 */
public interface HttpListener{
	
    /**
     * �������ݷ��أ��˷�����ȡ��response�����ݣ�ѡ����ʵ�ʵ����󣬽������ݽ���
     * 
     * @param response
     */
    void httpClientCallBack(Response response);

    /**
     * �����������ʾ
     */
    void httpClientError(int resultCode,String dec,String url);
}