package com.trassion.newstop.activity;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import com.trassion.newstop.bean.JavaBean;
import com.trassion.newstop.bean.response.NewsTopRegisterBeanresponse;
import com.trassion.newstop.controller.NewsTopInfoListRequest;
import com.trassion.newstop.http.parse.HttpTransAgent;
import com.trassion.newstop.http.parse.UICallBackInterface;
import com.trassion.newstop.image.IMageUtil;
import com.trassion.newstop.tool.Constants;
import com.trassion.newstop.tool.FileUtils;
import com.trassion.newstop.tool.NetworkUtil;
import com.trassion.newstop.tool.PreferenceUtils;
import com.trassion.newstop.tool.ToastManager;
import com.trassion.newstop.tool.Utils;
import com.trassion.newstop.view.SelectDialog;

import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Typeface;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;


public class PostMessageActivity extends BaseActivity implements OnClickListener,UICallBackInterface,DialogInterface.OnClickListener{

	private TextView title;
	private TextView tvfinish;
	private LinearLayout llAddImage;
	private EditText editContent;
	private ImageView addImageButton;
	private static String localTempImageFileName = "";
	File cacheFilePath = new File(Constants.TMP_PATH);
	private File file;
	private String imgUrl="";
	private NewsTopInfoListRequest request;
	private HttpTransAgent mHttpAgent;
	private String auth;
	private String saltkey;
	private NewsTopRegisterBeanresponse response;
	private String imageUrl="";
	private InputMethodManager imm;
	
	private static final int FLAG_CHOOSE_IMG = 1;
	private static final int FLAG_CHOOSE_PHONE = 2;
	@Override
	public void setContentView() {
		requestWindowFeature(Window.FEATURE_NO_TITLE); 
		setContentView(R.layout.activity_post_message);
		
		request = new NewsTopInfoListRequest(this);
		mHttpAgent = new HttpTransAgent(this,this);
		
		auth=PreferenceUtils.getPrefString(this, "auth", "");
		saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");

	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		tvfinish=(TextView)findViewById(R.id.tvfinish);
		addImageButton=(ImageView)findViewById(R.id.addImageButton);
		editContent=(EditText)findViewById(R.id.editContent);
		
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		
		title.setText("Feedback");
		tvfinish.setVisibility(View.VISIBLE);
		tvfinish.setText("DONE");
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Bold.ttf");
		tvfinish.setTypeface(type);
		
		   editContent.setFocusable(true);  
		   editContent.setFocusableInTouchMode(true);  
		   editContent.requestFocus();  
		   InputMethodManager inputManager =  
		               (InputMethodManager)editContent.getContext().getSystemService(Context.INPUT_METHOD_SERVICE);  
		           inputManager.showSoftInput(editContent, 0);
		
		 addImageButton.setOnClickListener(this);
		 tvfinish.setOnClickListener(this);

	}

	@Override
	public void initData() {
		// TODO Auto-generated method stub

	}
	public void onBackPressed() {
		finish();
		super.onBackPressed();
	overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.addImageButton:
			new SelectDialog(this).choosePicDialog().show();
			break;
		case R.id.tvfinish:
			if(!imgUrl.equals("")){
			   uploadFile();
			}else{
				requestAddFeedback();
			}
			break;

		default:
			break;
		}
		
	}

	private void uploadFile() {
		String content=editContent.getText().toString();
		
		if(TextUtils.isEmpty(content)){
			ToastManager.showShort(this, "Please input the content of the feedback");
			return;
		}
		
		Map<String, String> params = new HashMap<String, String>();
         params.put("auth", auth);
         params.put("saltkey", saltkey);
         params.put("filePath", imgUrl);
         
		if (NetworkUtil.isOnline(this)) {
			mHttpAgent.isShowProgress = true;
			request.getNewsTopListUpLoadmageRequest(mHttpAgent,Utils.getPhoneIMEI(this), params, Constants.HTTP_UPLOAD_IMAGE);
		} else {
			Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
		}
		
	}

	@Override
	public void onClick(DialogInterface dialog, int which) {
		switch (which) {
		case 0:
			Intent intent = new Intent();
			intent.setAction(Intent.ACTION_PICK);
			intent.setType("image/png,image/jpeg");
			startActivityForResult(intent, FLAG_CHOOSE_IMG);
			break;
        case 1:
        	String status = Environment.getExternalStorageState();
			if (status.equals(Environment.MEDIA_MOUNTED)) {
				try {
					localTempImageFileName = "";
					localTempImageFileName = String.valueOf((new Date())
							.getTime()) + ".png";
					
					if (!cacheFilePath.exists()) {
						cacheFilePath.mkdirs();
					}
					Intent it= new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
					File f = new File(cacheFilePath, localTempImageFileName);
					Uri u = Uri.fromFile(f);
					it.putExtra(MediaStore.EXTRA_OUTPUT, u);
					it.putExtra(MediaStore.Images.Media.MIME_TYPE,  "image/jpeg");
					startActivityForResult(it, FLAG_CHOOSE_PHONE);
				} catch (ActivityNotFoundException e) {
					e.printStackTrace();
				}
			}

			break;

		default:
			break;
		}
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == FLAG_CHOOSE_IMG && resultCode == RESULT_OK) {
			if (data != null) {
				Uri uri = data.getData();
				if (!Utils.isEmpty(uri.getAuthority())) {
					Cursor cursor = getContentResolver().query(uri,
							new String[] { MediaStore.Images.Media.DATA },
							null, null, null);
					if (null == cursor) {
						Toast.makeText(this, "The picture was not found", 0).show();
						return;
					}
					cursor.moveToFirst();
					String path = cursor.getString(cursor.getColumnIndex(MediaStore.Images.Media.DATA));
					 File f = new File(path);
					 File dest = new File(cacheFilePath, f.getName());
					 try{
						 FileUtils.copy(f, dest);
						 comprassBitmap(dest.getAbsolutePath(), 1);
						 handlerImage(dest.getAbsolutePath(), 0);
					 }catch (Exception e) {
					 }
				}
			}
			
	     }else if (requestCode == FLAG_CHOOSE_PHONE && resultCode == RESULT_OK) {
		     File f = new File(cacheFilePath, localTempImageFileName);
			   if(!f.exists()){
				Toast.makeText(this, "Get a picture of failure", 0).show();
				return;
			}
			
			comprassBitmap(f.getAbsolutePath(), 1);
			handlerImage(f.getAbsolutePath(), 1);
			
	  }
	}
	 private void comprassBitmap(String path, int type){
			Bitmap tmpbitmap = IMageUtil.getBitmap(path);
			if(tmpbitmap.getWidth() < 720 && tmpbitmap.getHeight() < 1280){
				tmpbitmap.recycle(); 
				return;
			}
			 file = new File(path);  
			BitmapFactory.Options options = new BitmapFactory.Options();  
	        options.inJustDecodeBounds = true; 
			Bitmap bitmap = IMageUtil.zoomBitmap(path, 720, 1028);
			try {  
				FileOutputStream out = new FileOutputStream(file);
	            if (type == 0) {  
	            	bitmap.compress(Bitmap.CompressFormat.PNG, 100, out);
				} else{
					bitmap.compress(Bitmap.CompressFormat.JPEG, 80, out);
				}
	            
				  out.flush();  
				  out.close();  
				
			} catch (FileNotFoundException e) {  
			   e.printStackTrace();  
			} catch (IOException e) {  
			   e.printStackTrace();  
			}  

		}
	 /**
		 * �����ȡ��ͼƬ
		 * 0��ʾ���ѡ��� 1��ʾ������ĵ�
		 */
		private void handlerImage(String path, int type){
			 //File src = new File(path);
			 //String target = Constants.TMP_PATH + File.separator + src.getName() + "temp" ;
			 try {
				 //FileUtils.copy(path, target);
				 Bitmap b = IMageUtil.createPreviewBitmap(path, 125, 125);
				 genUploadImageView(path, null, b, type);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		private void genUploadImageView(String path, String previewImagePath, Bitmap b, int type){
			 addImageButton.setImageBitmap(b);
			 imgUrl=path;
		}
		private void requestAddFeedback() {
			String content=editContent.getText().toString();
			
			if(TextUtils.isEmpty(content)){
				ToastManager.showShort(this, "Please input the content of the feedback");
				return;
			}
			
			if (NetworkUtil.isOnline(this)) {
				mHttpAgent.isShowProgress = true;
				request.getNewsTopListByAddFeedbackNewsTopRequest(mHttpAgent, Utils.getPhoneIMEI(this), auth, saltkey,content,imageUrl,Constants.HTTP_ADD_FEEDBACK );
			} else {
				Toast.makeText(this, R.string.common_cannot_connect, Toast.LENGTH_SHORT).show();
			}
			
		}

		@Override
		public void RequestCallBack(JavaBean bean, int msgId, boolean success) {
			if(bean!=null){
			 response=(NewsTopRegisterBeanresponse)bean;
			 if(msgId==Constants.HTTP_UPLOAD_IMAGE){
				if(response.getCode().equals("0")){
					imageUrl=response.getImage();
					requestAddFeedback();
				}else{
					ToastManager.showShort(this, response.getMsg());
				}
			 }else if(msgId==Constants.HTTP_ADD_FEEDBACK){
				 mHttpAgent.isShowProgress=false;
				 imm.hideSoftInputFromWindow(editContent.getWindowToken(), 0);
				 if(response.getCode().equals("0")){
					 onBackPressed();
					}else{
						ToastManager.showShort(this, response.getMsg());
					}
			 }
			}
			
		}

		@Override
		public void RequestError(int errorFlag, String errorMsg) {
			// TODO Auto-generated method stub
			
		}
}
