package com.transsion.infinix.xclub.data;

/**
 * 数据请求回调接口, 
 * @TODO 
 * @author Master
 * @date 2015-6-18 下午3:07:42
 * @version 1.0
 * @param <T>
 */
public interface RequestListener<T> {
	/**
	 * 开始获取数据
	 */
	public abstract void onBegin();

	/**
	 * 获取数据完成
	 * @param result 返回数据结果
	 */
	public abstract void onComplete(T result);
	
	/**
	 * 无网络连接
	 */
	public abstract void onNetworkNotConnection();
}

