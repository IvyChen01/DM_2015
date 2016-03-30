package com.trassion.newstop.http;

/**
 * @Title 网络回调监听
 * @Description
 * @author chen
 * @since 2015-10-7
 * @version
 */
public interface HttpListener{
	
    /**
     * 网络数据返回，此方法提取出response中数据，选择合适的实体对象，进行数据解析
     * 
     * @param response
     */
    void httpClientCallBack(Response response);

    /**
     * 网络错误码提示
     */
    void httpClientError(int resultCode,String dec,String url);
}