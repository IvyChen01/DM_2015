package com.transsion.infinix.xclub;


import java.util.LinkedHashMap;
import java.util.Map;

import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.data.BaseDao;
import com.trassion.infinix.xclub.R;


import android.app.Application;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnKeyListener;
import android.graphics.drawable.AnimationDrawable;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.widget.ImageView;
import android.widget.TextView;

public class MasterApplication extends Application{

	 private static MasterApplication instanse;
     private Dialog dialog;
     private Map<String, Integer> mFaceMap = new LinkedHashMap<String, Integer>();
 	 private Map<String, Integer> mFaceMonkey = new LinkedHashMap<String, Integer>();
 	 private Map<String, Integer> mFaceDaidai = new LinkedHashMap<String, Integer>();
	 private String faceStr=null;//表情字符
	 private String[] faceText;
	 public LoginInfo logininfo;
	 /** 服务端最新版本号  */
	 public String NEWVERSIONNUMBER;
	 /**  VersionBean 缓冲 是否有版本更新   */
	  
 	 
 	 
 	 @Override
 	public void onCreate() {
 		 instanse=this;
 		faceStr=getResources().getString(R.string.emote_face_str);
        faceText=faceStr.split(",");
		initFaceMap();
 		super.onCreate();
 	}
 	 public int getColor(){
     	return getResources().getColor(R.color.grenn); 
     }
	 /**
		 * 获取Application实例
		 * @return
		 */
		public static MasterApplication getInstanse(){
			if(instanse == null)
				instanse = new MasterApplication();
			return instanse;
		}

	/**  显示 加载数据 提示框  */
    public void showLoadDataDialogUtil(Context context,final BaseDao dao){
        
        if(dialog!=null){
            if(dialog.isShowing()){
                return;
            }
        }
        dialog=null;
        dialog=new Dialog(context, R.style.MDialog_loading);
        dialog.setCancelable(false);
        dialog.setOnKeyListener(new OnKeyListener()
        {
            
            @Override
            public boolean onKey(DialogInterface dialog, int keyCode, KeyEvent event)
            {
                if(keyCode==KeyEvent.KEYCODE_BACK){
                    
                    if (dao != null)
                    {
                        if (!dao.isCancelled())
                        {
                            dao.cancel(true);
                        }
                    }
                    
                    dialog.cancel();
                }
                
                return false;
            }
        });
        
        LayoutInflater factory = LayoutInflater.from(context);
        final View view = factory.inflate(R.layout.view_progresslayout, null);
        dialog.addContentView(view, new LayoutParams(LayoutParams.WRAP_CONTENT,LayoutParams.WRAP_CONTENT));
        AnimationDrawable anim = null;
        ImageView gifview = (ImageView) view.findViewById(R.id.gifView);
		Object ob = gifview.getBackground();
		anim =(AnimationDrawable)ob;
		anim.stop();
		anim.start();
        try {
			dialog.show();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    }
    /**  关闭 加载数据 提示框  */
    public void closeLoadDataDialogUtil(){
        
        if(dialog!=null){
            if(dialog.isShowing()){
                dialog.dismiss();
            }
        }
    }
    /**
     * 表情数据
     * 默认表情
     */
    public Map<String, Integer> getFaceMap() {
		if (!mFaceMap.isEmpty())
			return mFaceMap;
		return null;
	}
    /**
     * 表情数据
     * 酷猴
     */
	public Map<String, Integer> getFaceMonkey() {
		if (!mFaceMonkey.isEmpty())
			return mFaceMonkey;
		return null;
	}
	/**
     * 表情数据
     * 呆呆男
     */
	public Map<String, Integer> getFaceDaidai() {
		if (!mFaceDaidai.isEmpty())
			return mFaceDaidai;
		return null;
	}
		//初始化表情数据
    private void initFaceMap() {
			// TODO Auto-generated method stub	
			//默认
			mFaceMap.put(faceText[0], R.drawable.f000);
			mFaceMap.put(faceText[1], R.drawable.f001);
			mFaceMap.put(faceText[2], R.drawable.f002);
			mFaceMap.put(faceText[3], R.drawable.f003);
			mFaceMap.put(faceText[4], R.drawable.f004);
			mFaceMap.put(faceText[5], R.drawable.f005);
			mFaceMap.put(faceText[6], R.drawable.f007);
			mFaceMap.put(faceText[7], R.drawable.f008);
			mFaceMap.put(faceText[8], R.drawable.f009);
			mFaceMap.put(faceText[9], R.drawable.f010);
			mFaceMap.put(faceText[10], R.drawable.f011);
			mFaceMap.put(faceText[11], R.drawable.f012);
			mFaceMap.put(faceText[12], R.drawable.f013);
			mFaceMap.put(faceText[13], R.drawable.f014);
			mFaceMap.put(faceText[14], R.drawable.f015);
			mFaceMap.put(faceText[15], R.drawable.f016);
			mFaceMap.put(faceText[16], R.drawable.f017);
			mFaceMap.put(faceText[17], R.drawable.f018);
			mFaceMap.put(faceText[18], R.drawable.f019);
			mFaceMap.put(faceText[19], R.drawable.f020);
			mFaceMap.put(faceText[20], R.drawable.f021);
			mFaceMap.put(faceText[21], R.drawable.f022);
			mFaceMap.put(faceText[22], R.drawable.f023);
			mFaceMap.put(faceText[23], R.drawable.f024);
			//酷猴
			mFaceMonkey.put(faceText[24], R.drawable.f025);
			mFaceMonkey.put(faceText[25], R.drawable.f026);
			mFaceMonkey.put(faceText[26], R.drawable.f027);
			mFaceMonkey.put(faceText[27], R.drawable.f028);
			mFaceMonkey.put(faceText[28], R.drawable.f029);
			mFaceMonkey.put(faceText[29], R.drawable.f030);
			mFaceMonkey.put(faceText[30], R.drawable.f031);
			mFaceMonkey.put(faceText[31], R.drawable.f032);
			mFaceMonkey.put(faceText[32], R.drawable.f033);
			mFaceMonkey.put(faceText[33], R.drawable.f034);
			mFaceMonkey.put(faceText[34], R.drawable.f035);
			mFaceMonkey.put(faceText[35], R.drawable.f036);
			mFaceMonkey.put(faceText[36], R.drawable.f037);
			mFaceMonkey.put(faceText[37], R.drawable.f038);
			mFaceMonkey.put(faceText[38], R.drawable.f039);
			mFaceMonkey.put(faceText[39], R.drawable.f040);
			//呆呆男
			mFaceDaidai.put(faceText[40], R.drawable.f041);
			mFaceDaidai.put(faceText[41], R.drawable.f042);
			mFaceDaidai.put(faceText[42], R.drawable.f043);
			mFaceDaidai.put(faceText[43], R.drawable.f044);
			mFaceDaidai.put(faceText[44], R.drawable.f045);
			mFaceDaidai.put(faceText[45], R.drawable.f046);
			mFaceDaidai.put(faceText[46], R.drawable.f047);
			mFaceDaidai.put(faceText[47], R.drawable.f048);
			mFaceDaidai.put(faceText[48], R.drawable.f049);
			mFaceDaidai.put(faceText[49], R.drawable.f050);
			mFaceDaidai.put(faceText[50], R.drawable.f051);
			mFaceDaidai.put(faceText[51], R.drawable.f052);
			mFaceDaidai.put(faceText[52], R.drawable.f053);
			mFaceDaidai.put(faceText[53], R.drawable.f054);
			mFaceDaidai.put(faceText[54], R.drawable.f055);
			mFaceDaidai.put(faceText[55], R.drawable.f056);
			mFaceDaidai.put(faceText[56], R.drawable.f057);
			mFaceDaidai.put(faceText[57], R.drawable.f058);
			mFaceDaidai.put(faceText[58], R.drawable.f059);
			mFaceDaidai.put(faceText[59], R.drawable.f060);
			mFaceDaidai.put(faceText[60], R.drawable.f061);
			mFaceDaidai.put(faceText[61], R.drawable.f062);
			mFaceDaidai.put(faceText[62], R.drawable.f063);
			mFaceDaidai.put(faceText[63], R.drawable.f064);
		}
}
