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

public class PostScoreDilog extends Dialog implements OnClickListener,OnItemClickListener{
	
	private LayoutInflater inflater;
	private ListView contentListView;
	private ImageButton btnless;
	private ImageButton btnAdd;
	private TextView tvScore;
	private int score=0;
	private EditText etReasons;
	private String[] data;
	private CheckBox checkBox;
	private Button btOK;
	private boolean isCheck=false;
	private Context context;
	

	public PostScoreDilog(Context context) {
		this(context,R.style.dialog);
		inflater=LayoutInflater.from(context);
		this.context=context;
		windowAttr();
	}
    public PostScoreDilog(Context context,int theme) {
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
    	this.setContentView(inflater.inflate(R.layout.post_score_dialog, null));
    	
    	btnless=(ImageButton)this.findViewById(R.id.btnless);
    	btnAdd=(ImageButton)this.findViewById(R.id.btnAdd);
    	tvScore=(TextView)this.findViewById(R.id.tvScore);
    	etReasons=(EditText)this.findViewById(R.id.etReasons);
    	checkBox=(CheckBox)this.findViewById(R.id.checkBox);
    	btOK=(Button)this.findViewById(R.id.btOK);
    	
    	data = new String[] { "powerfull!", "Usefull!", "Very nice!","The best!","interesting" };
    	contentListView = (ListView) this.findViewById(R.id.listView);
    	ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this.getContext(), R.layout.post_score_item,
				data);
    	
    	contentListView.setAdapter(arrayAdapter);
		contentListView.setOnItemClickListener(this);
		btnless.setOnClickListener(this);
		btnAdd.setOnClickListener(this);
		btOK.setOnClickListener(this);
		
		checkBox.setOnCheckedChangeListener(new OnCheckedChangeListener() {
			
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				isCheck=isChecked;
			}
		});
    	
    }
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.btnAdd:
			next();
			break;
		case R.id.btnless:
			Previous();
			break;
		case R.id.btOK:
			String score=tvScore.getText().toString();
			String reason=etReasons.getText().toString();
			Send(score,reason,isCheck);
			break;
		default:
			break;
		}
		
	}
	public void Send(String score, String reason, boolean isCheck) {
		// TODO Auto-generated method stub
		
	}
	private void Previous() {
		if(score<=-3){
			return;
		}
		score--;
		if(score>0){
			tvScore.setText("+"+score);
			}else{
				tvScore.setText(""+score);
			}
	}
	private void next() {
		if(score>=3){
			return;
		}else{
		score++;
		if(score>0){
		       tvScore.setText("+"+score);
		    }else{
			    tvScore.setText(""+score);	
		    }
		}
	}
	
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		etReasons.setText(data[position].trim());
	}
      
}
