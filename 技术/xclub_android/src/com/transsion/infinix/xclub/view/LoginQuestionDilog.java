package com.transsion.infinix.xclub.view;

import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.R.integer;
import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.WindowManager;
import android.view.WindowManager.LayoutParams;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class LoginQuestionDilog extends Dialog implements OnItemClickListener{
	
	private LayoutInflater inflater;
	private ListView contentListView;
	private String[] data;
	private boolean isCheck=false;
	private Context context;
	

	public LoginQuestionDilog(Context context) {
		this(context,R.style.dialog);
		inflater=LayoutInflater.from(context);
		this.context=context;
		windowAttr();
	}
    public LoginQuestionDilog(Context context,int theme) {
		super(context,theme);
//		inflater=LayoutInflater.from(context);
//		windowAttr();		
	}
    private void windowAttr(){
		Window win = this.getWindow();
		LayoutParams params = new LayoutParams();
		params.x = 0;//设置x坐标
		params.y = 0;//设置y坐标
		win.setAttributes(params);
		this.setCanceledOnTouchOutside(false);
		WindowManager.LayoutParams lp = win.getAttributes();
//        win.setWindowAnimations(R.style.dialog_anim);
    }   
    @Override
    protected void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	this.setContentView(inflater.inflate(R.layout.login_question_dialog, null));
    	
    	data = new String[] { "Security Question(Please ignore if not set)", 
    			"Your Mother's name?", 
    			"Your Grandpa's name?",
    			"Your Futher's Birth Place?",
    			"Your first teacher's name?",
    			"Your personal computer model?",
    			"Your favorite restaurant?",
    			"Last four digits of your driver's license?"};
    	contentListView = (ListView) this.findViewById(R.id.listView);
    	ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this.getContext(), R.layout.login_question_item,
				data);
    	
    	contentListView.setAdapter(arrayAdapter);
		
    	contentListView.setOnItemClickListener(this);
    }
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		   ItemClick(data[position].trim(), position);
	}
	public void ItemClick(String question,int position){
		
	}
      
}
