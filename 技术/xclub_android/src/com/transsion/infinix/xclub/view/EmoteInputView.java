package com.transsion.infinix.xclub.view;



import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.Set;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.adpter.EmoteAdapter;
import com.transsion.infinix.xclub.bean.FaceBean;
import com.transsion.infinix.xclub.util.Utils;
import com.trassion.infinix.xclub.R;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.text.Spannable;
import android.text.SpannableString;
import android.text.style.ImageSpan;
import android.util.AttributeSet;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;


/**
 * 
* @ClassName: EmoteInputView    
* @Description: TODO(�Զ������ؼ�)    
* @author lanyj    
* @date 2013-11-28 ����2:12:41
 */
public class EmoteInputView extends LinearLayout implements OnClickListener,
		OnCheckedChangeListener, OnItemClickListener {

	public GridView mGvDisplay;
	public ImageView mIvDelete;
	public RadioButton mRgDef,mRgMon,mRgDai;
	private RadioGroup mRgInner;
	private EmoteAdapter mDefaultAdapter,mMonAdapter,mDaiAdapter;
	private EditText mEEtView;
	private List<String> keys;
	//private boolean mIsSelectedDefault;

	public EmoteInputView(Context context) {
		super(context);
		init();
	}

	@SuppressLint("NewApi")
	public EmoteInputView(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
		init();
	}

	public EmoteInputView(Context context, AttributeSet attrs) {
		super(context, attrs);
		init();
	}

	public void init() {
		inflate(getContext(), R.layout.common_emotionbar, this);
		mGvDisplay = (GridView) findViewById(R.id.emotionbar_gv_display);
		mIvDelete = (ImageView) findViewById(R.id.emotionbar_iv_delete);
		mRgInner = (RadioGroup) findViewById(R.id.emotionbar_rg_inner);
		mRgDef=(RadioButton)findViewById(R.id.emotionbar_rb_default);
		mRgMon=(RadioButton)findViewById(R.id.emotionbar_rb_emoji);
		mRgDai=(RadioButton)findViewById(R.id.emotionbar_rb_daidai);
		mGvDisplay.setOnItemClickListener(this);
		mRgInner.setOnCheckedChangeListener(this);
		mIvDelete.setOnClickListener(this);	
		//��ʼ��Ĭ�ϱ���
		mDefaultAdapter = new EmoteAdapter(getContext(),
				MasterApplication.getInstanse().getFaceMap());
		//��ʼ��������
		mMonAdapter = new EmoteAdapter(getContext(),
				MasterApplication.getInstanse().getFaceMonkey());
		//��ʼ�������б���
		mDaiAdapter = new EmoteAdapter(getContext(),
				MasterApplication.getInstanse().getFaceDaidai());
		mGvDisplay.setAdapter(mDefaultAdapter);
	}

	
	public void onCheckedChanged(RadioGroup group, int checkedId) {
		switch (checkedId) {
		case R.id.emotionbar_rb_default:
			mGvDisplay.setAdapter(mDefaultAdapter);
			break;
		case R.id.emotionbar_rb_emoji:
			mGvDisplay.setAdapter(mMonAdapter);
			break;
		case R.id.emotionbar_rb_daidai:
			mGvDisplay.setAdapter(mDaiAdapter);
			break;
		}
	}
	/**
	 * ɾ������
	 */
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.emotionbar_iv_delete:
			if (mEEtView != null) {
				try {
					int selection = mEEtView.getSelectionStart();
					String text = mEEtView.getText().toString();
					if (selection > 0) {
						if(mRgDef.isChecked()){
							if(text.endsWith(":)")||text.endsWith(":(")||text.endsWith(":@")||text.endsWith(":o")||text.endsWith(":P")||text.endsWith(":$")
									||text.endsWith(";P")||text.endsWith(":L")||text.endsWith(":Q")||text.endsWith(":lol")||text.endsWith(":")){
								FaceBean face=Utils.getUtils().deleteFace(text);
								mEEtView.getText().delete(face.getStart(), face.getEnd());								
								return;
							}
						}else{
							if(text.endsWith("}")){
								FaceBean face=Utils.getUtils().deleteFace(text);
								mEEtView.getText().delete(face.getStart(), face.getEnd());
								return;
							}
						}
						mEEtView.getText().delete(selection - 1, selection);
					}				
				} catch (Exception e) {
					// TODO: handle exception
					e.printStackTrace();
				}
			}
			break;
		}
	}	
	/**
	 * ѡ�б���
	 */
	public void onItemClick(AdapterView<?> arg0, View arg1, int position, long arg3) {
		// �����ⲿ�֣���EditText����ʾ����
		Map<String,Integer> FaceMap=MasterApplication.getInstanse().getFaceMap();
		if(mRgDef.isChecked()){
			FaceMap=MasterApplication.getInstanse().getFaceMap();
		}else if(mRgMon.isChecked()){
			FaceMap=MasterApplication.getInstanse().getFaceMonkey();
		}else if(mRgDai.isChecked()){
			FaceMap=MasterApplication.getInstanse().getFaceDaidai();
		}
		Set<String> keySet = FaceMap.keySet();
		keys = new ArrayList<String>();
		keys.addAll(keySet);
		Bitmap bitmap = BitmapFactory.decodeResource(
				getResources(), (Integer) FaceMap.values()
				.toArray()[position]);
		if (bitmap != null) {
			int rawHeigh = bitmap.getHeight();
			int rawWidth = bitmap.getHeight();
			int newHeight = 50;
			int newWidth = 50;
			// ������������
			float heightScale = ((float) newHeight) / rawHeigh;
			float widthScale = ((float) newWidth) / rawWidth;
			// �½�������
			Matrix matrix = new Matrix();
			matrix.postScale(heightScale, widthScale);
			// ��ͼƬ��Сѹ��
			// ѹ����ͼƬ�Ŀ�͸��Լ�kB��С����仯
			Bitmap newBitmap = Bitmap.createBitmap(bitmap, 0, 0,
					rawWidth, rawHeigh, matrix, true);
			ImageSpan imageSpan = new ImageSpan(getContext(),
					newBitmap);
			String emojiStr = keys.get(position);
			SpannableString spannableString = new SpannableString(
					emojiStr);
			spannableString.setSpan(imageSpan,0,
					emojiStr.length() ,
					Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
			mEEtView.append(spannableString);
		} else {
			String ori = mEEtView.getText().toString();
			int index = mEEtView.getSelectionStart();
			StringBuilder stringBuilder = new StringBuilder(ori);
			stringBuilder.insert(index, keys.get(position));
			mEEtView.setText(stringBuilder.toString());
			mEEtView.setSelection(index + keys.get(position).length());
		}
	}
	/**
	 * 
	   
	* @Title: setBitmapText 
	   
	* @Description: TODO(�ϴ�ͼƬʱ��ͼƬ��ʾ) 
	   
	* @param @param fileStr
	* @param @param bitmap    �趨�ļ� 
	   
	* @return void    �������� 
	   
	* @throws
	 */
	public void setBitmapText(String fileStr,Bitmap bitmap){
		if (bitmap != null) {
			ImageSpan imageSpan = new ImageSpan(getContext(),
					bitmap);
			SpannableString spannableString = new SpannableString(
					fileStr);
			spannableString.setSpan(imageSpan,0,
					fileStr.length() ,
					Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
//			mEEtView.append("\n");
			mEEtView.append(spannableString);
//			mEEtView.append("\n");
		} else {
			String ori = mEEtView.getText().toString();
			int index = mEEtView.getSelectionStart();
			StringBuilder stringBuilder = new StringBuilder(ori);
			stringBuilder.insert(index,fileStr);
			mEEtView.setText(stringBuilder.toString());
			mEEtView.setSelection(index + fileStr.length());
		}
	}
	
	public void setEditText(EditText editText) {
		mEEtView = editText;
	}
}
