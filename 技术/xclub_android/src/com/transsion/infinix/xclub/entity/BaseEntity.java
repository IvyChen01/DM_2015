package com.transsion.infinix.xclub.entity;

import java.io.Serializable;
import org.json.JSONObject;

/**
 * 基类实体
 * @TODO
 * @author chenqian
 * @date 2015-6-18 上午10:47:55
 * @version 1.0
 */
public class BaseEntity implements Serializable
{

    /**
	 * 
	 */
    private static final long serialVersionUID = 2863949855414539253L;

    private int ret;
    private String code;
    private String msg;
    private String message;

    public BaseEntity()
    {
        super();
        // TODO Auto-generated constructor stub
    }

    public BaseEntity(int ret, String code, String msg, String message)
    {
        super();
        this.ret = ret;
        this.code = code;
        this.msg = msg;
        this.message = message;
    }

    public int getRet()
    {
        return ret;
    }

    public void setRet(int ret)
    {
        this.ret = ret;
    }

    public String getCode()
    {
        return code;
    }

    public void setCode(String code)
    {
        this.code = code;
    }

    public String getMsg()
    {
        return msg;
    }

    public void setMsg(String msg)
    {
        this.msg = msg;
    }

    public String getMessage()
    {
        return message;
    }

    public void setMessage(String message)
    {
        this.message = message;
    }

    @Override
    public String toString()
    {
        return message;
    }

   
   
}
