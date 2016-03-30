package com.transsion.infinix.xclub.data;


import java.util.ArrayList;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.HttpUtil;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.JSON_Parse;


import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;

/**
 * 数据操作
 * @TODO
 * @author chenqian
 * @date 2015-6-18 下午2:42:52
 * @version 1.0
 */
public class BaseDao extends MyAsyncTask<String, Void, BaseEntity>
{

    //
    public static final String NOT_CONNECTION = "no_connection";

    private ConnectivityManager cm = null;

    // 是否有网络连接
    private boolean hasConn = false;

    // 数据状态监听
    private RequestListener<BaseEntity> listener;

    // 参数列表集
    private ArrayList<BasicNameValuePair> mParams;

    private Context mContext;
    private JSONObject json;

    /**
     * @param listener
     * @param params 此参数为空是用Get方式访问, 否则Post访问
     * @param context
     */
    public BaseDao(RequestListener<BaseEntity> listener,
             ArrayList<BasicNameValuePair> params, Context context,
            JSONObject json)
    {
        this.listener = listener;
        // if (null != params) {
        // if (null != com.itel.androidclient.MasterApplication.userInfo) {
        // BasicNameValuePair par = new BasicNameValuePair("sessiontoken",
        // Constant.getSESSIONTOKEN());
        // params.add(par);
        // }
        // }
        this.mParams = params;
        this.mContext = context;
        this.json = json;
    }

    /**
     * 是否有网络连接
     * @return
     */
    public boolean hasConnection()
    {
        return !getConnectionType().equalsIgnoreCase(NOT_CONNECTION);
    }

    /**
     * 获取连接类型
     * @return
     */
    public String getConnectionType()
    {
        if (cm == null)
            cm = (ConnectivityManager) mContext
                    .getSystemService("connectivity");
        NetworkInfo info = cm.getActiveNetworkInfo();
        if (info != null)
        {
            return info.getTypeName().toLowerCase();
        } else
        {
            return NOT_CONNECTION;
        }
    }

    @Override
    protected void onPreExecute()
    {
        // TODO Auto-generated method stub
        super.onPreExecute();

        listener.onBegin();

        if (!hasConnection())
        {
            hasConn = false;
        } else
        {
            hasConn = true;
        }
        //
    }

    @Override
    protected BaseEntity doInBackground(String... params)
    {
        // TODO Auto-generated method stub
    	
//    	
        if (hasConn)
        {
            
            // 获取数据
            String result;
			if (hasConn) {
				result = "";
			}
            if (params[2] == null)
            {
                result = HttpUtil.getString(params[0], params[1], mParams);
                Log.i("info","结果=："+result);
            } else
            {
                    if (params[2].toString().equals("true"))
                    {
                        result = HttpUtil.getString4Post(params[0], json);
                        Log.i("info","结果=："+result);
                    } else
                    {
                        result = HttpUtil.getString(params[0], params[1], mParams);
                    }
                
            }
            if (result != null)
            {
                try
                {
                	Log.i("info","结果=："+result);
                    JSONObject obj = new JSONObject(result);
                    if (obj.isNull("message") == false)
                    {
                        String message = obj.getString("message");
                        return JSON_Parse.parse(message);
                    } else
                    {
                        return JSON_Parse.parse(result);
                    }

				} catch (JSONException e) {
					e.printStackTrace();
				}
			} else {
			    return null;
			}

		} else {
			return null;
		}
		return null;
	}

    @Override
    protected void onPostExecute(BaseEntity result)
    {
        // TODO Auto-generated method stub
        if (hasConn)
        {
            listener.onComplete(result);
        } else
        {
            listener.onNetworkNotConnection();
        }

        super.onPostExecute(result);
    }

}
