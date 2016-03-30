package com.transsion.infinix.xclub.view;


import com.trassion.infinix.xclub.R;

import android.app.ProgressDialog;
import android.content.Context;
import android.view.Gravity;
import android.view.Window;
import android.view.WindowManager.LayoutParams;


public class XclubProgressDialog extends ProgressDialog {

	String msg = "";
	public XclubProgressDialog(Context context) {
		//this(context, R.style.doov_progress_dialog);
		super(context);
		//windowAttr();
	}

	public XclubProgressDialog(Context context, int theme) {
		super(context, theme);
		//windowAttr();
	}
	
	public void setText(String msg){
		this.msg = msg;
		
	}

	private void windowAttr() {
		Window win = this.getWindow();
		LayoutParams params = new LayoutParams();
		params.x = 0;// 设置x坐标
		params.y = 0;// 设置y坐标
		params.horizontalMargin = 0;
		win.setAttributes(params);
		this.setCanceledOnTouchOutside(false);
		win.setGravity(Gravity.TOP);
		win.setWindowAnimations(R.style.dialog_anim);
	}
	
/*	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		this.setContentView(R.layout.doov_progress_dialog);
		LinearLayout contentLL = (LinearLayout) findViewById(R.id.contentLL);
		LinearLayout.LayoutParams lp = (LinearLayout.LayoutParams) contentLL.getLayoutParams();
		lp.width = this.getWindow().getWindowManager().getDefaultDisplay().getWidth();
		
		TextView msgTextView = ((TextView)findViewById(R.id.msg));
		msgTextView.setText(msg);
	}*/

}
