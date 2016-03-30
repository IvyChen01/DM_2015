package com.transsion.infinix.xclub.bean;



import java.io.Serializable;
/**
 * °æ±¾¸üÐÂ
 * @author zgc
 *
 */
public class VersionBean implements Serializable
{

    /**
     * 
     */
    private static final long serialVersionUID = 1L;

    private String updateUrl;
    private String apkName;
    private String update_description;
    public VersionBean(String updateUrl, String apkName,
            String update_description)
    {
        super();
        this.updateUrl = updateUrl;
        this.apkName = apkName;
        this.update_description = update_description;
    }
    public VersionBean()
    {
        super();
        // TODO Auto-generated constructor stub
    }
    public String getUpdateUrl()
    {
        return updateUrl;
    }
    public void setUpdateUrl(String updateUrl)
    {
        this.updateUrl = updateUrl;
    }
    public String getApkName()
    {
        return apkName;
    }
    public void setApkName(String apkName)
    {
        this.apkName = apkName;
    }
    public String getUpdate_description()
    {
        return update_description;
    }
    public void setUpdate_description(String update_description)
    {
        this.update_description = update_description;
    }
    
    
}
