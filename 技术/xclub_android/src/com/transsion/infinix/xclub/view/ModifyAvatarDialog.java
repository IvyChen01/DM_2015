package com.transsion.infinix.xclub.view;


import com.trassion.infinix.xclub.R;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager.LayoutParams;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;


public class ModifyAvatarDialog extends Dialog implements OnItemClickListener {

	private LayoutInflater factory;
	private ListView contentListView;
	private Button mImg;

	private Button mPhone;

	private Button mCancel;

	public ModifyAvatarDialog(Context context) {
		this(context, R.style.xclub_dialog_style_with_title);
		factory = LayoutInflater.from(context);
		windowAttr();
	}

	public ModifyAvatarDialog(Context context, int theme) {
		super(context, theme);
//		factory = LayoutInflater.from(context);
//		windowAttr();
	}
	
	private void windowAttr(){
		Window win = this.getWindow();
		LayoutParams params = new LayoutParams();
		params.x = 0;//设置x坐标
		params.y = 0;//设置y坐标
		win.setAttributes(params);
		this.setCanceledOnTouchOutside(false);
        win.setGravity(Gravity.TOP);
        win.setWindowAnimations(R.style.dialog_anim);
        
      
	}
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		this.setContentView(factory.inflate(R.layout.gl_modify_avatar_choose_dialog, null));
		LinearLayout linearLayout = (LinearLayout) findViewById(R.id.contentLL);
		android.view.ViewGroup.LayoutParams lp = linearLayout.getLayoutParams();
		lp.width = this.getWindow().getWindowManager().getDefaultDisplay().getWidth();

		String[] data = new String[] { "Photo", "Gallery", "Cancel" };
		contentListView = (ListView) this.findViewById(R.id.chooseItemListView);
		ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this.getContext(), R.layout.simple_list_item_1,
				data);

		contentListView.setAdapter(arrayAdapter);
		contentListView.setOnItemClickListener(this);
		/*mImg = (Button) this.findViewById(R.id.gl_choose_img);
		mPhone = (Button) this.findViewById(R.id.gl_choose_phone);
		mCancel = (Button) this.findViewById(R.id.gl_choose_cancel);
		mImg.setOnClickListener(this);
		mPhone.setOnClickListener(this);
		mCancel.setOnClickListener(this);
		
	    LinearLayout.LayoutParams lp = (LinearLayout.LayoutParams) (findViewById(R.id.contentLL).getLayoutParams());
		lp.width = this.getWindow().getWindowManager().getDefaultDisplay().getWidth();*/
	}

	/*@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.gl_choose_img:
			doGoToImg();
			break;
		case R.id.gl_choose_phone:
			doGoToPhone();
			break;
		case R.id.gl_choose_cancel:
			dismiss();
			break;
		}
	}*/
	
	public void doGoToImg(){
	}
	public void doGoToPhone(){
	}

	@Override
	public void onItemClick(AdapterView<?> arg0, View arg1, int position, long arg3) {
		if (position == 0) {
			doGoToPhone();
		} else if (position == 1) {
			doGoToImg();
		}  
			
		dismiss();
	}
}
