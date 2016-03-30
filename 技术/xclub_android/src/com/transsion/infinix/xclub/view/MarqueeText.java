package com.transsion.infinix.xclub.view;

import android.content.Context;
import android.graphics.Rect;
import android.util.AttributeSet;
import android.widget.TextView;

/**  
 * 创建时间�?013-11-21 下午3:48:06  
 * 项目名称：ColorOS  
 * @author lanyj  
 * @version 1.0   
 * @since   
 * 文件名称：MarqueeText.java  
 * 类说明：  标题文字跑马灯效�?
 */
public class MarqueeText extends TextView  { 
	public MarqueeText(Context con) {
		  super(con);
		}

		public MarqueeText(Context context, AttributeSet attrs) {
		  super(context, attrs);
		}
		public MarqueeText(Context context, AttributeSet attrs, int defStyle) {
		  super(context, attrs, defStyle);
		}
		@Override
		public boolean isFocused() {
		return true;//总是获得焦点
		}
		@Override
		protected void onFocusChanged(boolean focused, int direction,
		   Rect previouslyFocusedRect) {  
		}

}
