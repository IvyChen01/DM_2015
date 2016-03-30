package com.trassion.newstop.http;

import org.apache.http.Header;

/**
 * 请求响应
 * @author chen
 *@see [相关类/方法]
 *@since [产品/模块版本]
 */
public class Response {

	    public int msgId;
	    public String url;
	    public int resultCode;
	    public String modelName;
	    public String data;
	    public Header[] receiveHeaders;
	
}
