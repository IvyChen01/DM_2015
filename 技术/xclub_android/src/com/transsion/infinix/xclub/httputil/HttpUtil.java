package com.transsion.infinix.xclub.httputil;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.Charset;
import java.util.ArrayList;
import java.util.Map;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.CoreConnectionPNames;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import com.transsion.infinix.xclub.constact.Constant;


import android.annotation.SuppressLint;
import android.os.StrictMode;
import android.util.Log;

/**
 * 访问网络
 * @TODO
 * @author chenqian
 * @date 2015-6-18 下午2:57:07
 * @version 1.0
 */
public class HttpUtil
{
    // 超时时间
    private static final int CONNECT_TIMEOUT = 60 * 1000;

    /**
     * 获取数据
     * @param url 全地址
     * @param param 参数
     * @return
     */

    public static String getString(String url, String type,
            ArrayList<BasicNameValuePair> param)
    {
        //
        if (type.equals("get"))
        {
            return getString4Get(url, param);
        } else
        {
            return getString4Post(url, param);
        }
    }

    /**
     * Get方式提交数据
     * @param url
     * @return
     */
    public static String getString4Get(String url,
            ArrayList<BasicNameValuePair> param)
    {
        //
        //
        DefaultHttpClient httpClient = new DefaultHttpClient();
        // 设置超时
        httpClient.getParams().setParameter(
                CoreConnectionPNames.CONNECTION_TIMEOUT, CONNECT_TIMEOUT);
        httpClient.getParams().setParameter(CoreConnectionPNames.SO_TIMEOUT,
                CONNECT_TIMEOUT);

        // HttpConnectionParams.setConnectionTimeout(param, 60000);
        // HttpConnectionParams.setSoTimeout(param, 60000);

        StringBuilder URL = new StringBuilder();

        //
        try
        {
            URL.append(url);
            
            String parmas = "";
            if (param == null)
            {
                param = new ArrayList<BasicNameValuePair>();
            } else
            {
//                if (MasterApplication.sessiontoken != null)
//                {
//                    param.add(new BasicNameValuePair("sessiontoken",
//                            MasterApplication.sessiontoken));
//                }

            }
            for (NameValuePair pair : param)
            {
//                 parmas += (pair.getName() + "=" + URLEncoder.encode(
//                 URLEncoder.encode(pair.getValue().toString(), "UTF-8"),
//                 "utf-8")) + "&";
                parmas += (pair.getName() + "=" + URLEncoder.encode(pair
                        .getValue().toString(), "utf-8"))
                        + "&";
            }

            if (parmas.length() > 0)
            {
                parmas = parmas.substring(0, parmas.length() - 1);
            }

            URL = URL.append("?").append(parmas);
            
            Log.i("info", "url----:"+URL.toString());

            HttpGet get = new HttpGet(URL.toString());

            HttpResponse response = httpClient.execute(get);
            //

            if (response.getStatusLine().getStatusCode() == 200)
            {
                //
                HttpEntity httpEntity = response.getEntity();
                // httpEntity.
                InputStream is = httpEntity.getContent();

                StringBuffer sb = new StringBuffer();
                BufferedReader br = new BufferedReader(
                        new InputStreamReader(is));
                String line = "";
                while ((line = br.readLine()) != null)
                {
                    sb.append(line);
                }
                return sb.toString();
            } else
            {
                return null;
            }
        } catch (ClientProtocolException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IllegalStateException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IOException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        return null;
    }

    @SuppressLint("NewApi")
    public static void getSecurity()
    {
        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder()
                .detectDiskReads().detectDiskWrites().detectNetwork() // or
                                                                      // .detectAll()
                                                                      // for all
                                                                      // detectable
                                                                      // problems
                .penaltyLog().build());
        StrictMode.setVmPolicy(new StrictMode.VmPolicy.Builder()
                .detectLeakedSqlLiteObjects().penaltyLog().penaltyDeath()
                .build());
    }

    /**
     * Post方式提交数据
     * @param url
     * @param param
     * @return
     */
    @SuppressWarnings("deprecation")
    public static String getString4Post(String url,
            ArrayList<BasicNameValuePair> param)
    {
        //
        //
        // getSecurity();
        try
        {
            //
            DefaultHttpClient httpClient = new DefaultHttpClient();

            httpClient.getParams().setParameter(
                    CoreConnectionPNames.CONNECTION_TIMEOUT,
                    CONNECT_TIMEOUT);
            HttpPost post = new HttpPost(url);
            
            Log.i("info","url:"+url);
            //
            if (param != null)
            {
                UrlEncodedFormEntity entity = new UrlEncodedFormEntity(param,
                        HTTP.UTF_8);
                post.setEntity(entity);
            }
            post.addHeader("Content-Type", "application/x-www-form-urlencoded");

            HttpResponse response = httpClient.execute(post);

            if (response.getStatusLine().getStatusCode() == 200)
            {

                HttpEntity httpEntity = response.getEntity();

                InputStream is = httpEntity.getContent();

                StringBuffer sb = new StringBuffer();

                BufferedReader br = new BufferedReader(
                        new InputStreamReader(is));
                String line = null;
                while ((line = br.readLine()) != null)
                {
                    sb.append(line);
                }
                //
                return sb.toString();
            } else
            {
                return null;
            }

        } catch (UnsupportedEncodingException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
            return null;
        } catch (ClientProtocolException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
            return null;
        } catch (IllegalStateException e)
        {
            // TODO Auto-generated catch block
            e.printStackTrace();
            return null;
        } catch (IOException e)
        {
            // // TODO Auto-generated catch block
            e.printStackTrace();
            return null;
        }
    }


    public static String getString4Post(String path, JSONObject json)
    {
        
        URL url;
        try
        {
//            if (MasterApplication.sessiontoken != null)
//            {
//
//                path += "?sessiontoken=" + MasterApplication.sessiontoken;
//            }

            url = new URL(path);
            String content = String.valueOf(json);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setConnectTimeout(Constant.CONNECTTIMEOUT);
            conn.setReadTimeout(Constant.CONNECTTIMEOUT);
            conn.setDoOutput(true);
            conn.setRequestMethod("POST");
            conn.setRequestProperty("ser-Agent", "Fiddler");
            conn.setRequestProperty("Content-Type",
                    "application/json;charset=utf-8");
            DataOutputStream out = null;
            conn.connect();
            out = new DataOutputStream(conn.getOutputStream());
            out.write(content.getBytes());
            out.close();

            if (conn.getResponseCode() == 200)
            {
                // 读取响应
                BufferedReader reader = new BufferedReader(
                        new InputStreamReader(conn.getInputStream()));
                String lines;
                StringBuffer sb = new StringBuffer("");
                while ((lines = reader.readLine()) != null)
                {
                    lines = new String(lines.getBytes(), "utf-8");
                    sb.append(lines);
                }
                return sb.toString();
            } else
            {
                return null;
            }

        } catch (MalformedURLException e1)
        {
            e1.printStackTrace();
            return null;
        } catch (ProtocolException e)
        {
            e.printStackTrace();
            return null;
        } catch (IOException e)
        {
            e.printStackTrace();
            return null;
        }

    }

}
