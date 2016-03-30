package com.transsion.infinix.xclub.data;

/**
 * ��������ص��ӿ�, 
 * @TODO 
 * @author Master
 * @date 2015-6-18 ����3:07:42
 * @version 1.0
 * @param <T>
 */
public interface RequestListener<T> {
	/**
	 * ��ʼ��ȡ����
	 */
	public abstract void onBegin();

	/**
	 * ��ȡ�������
	 * @param result �������ݽ��
	 */
	public abstract void onComplete(T result);
	
	/**
	 * ����������
	 */
	public abstract void onNetworkNotConnection();
}

