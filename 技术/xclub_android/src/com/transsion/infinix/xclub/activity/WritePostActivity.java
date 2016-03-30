package com.transsion.infinix.xclub.activity;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.CheckBox;
import android.widget.LinearLayout.LayoutParams;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.HttpFormUtil;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.listener.ImageUploadStateListener;
import com.transsion.infinix.xclub.util.FileUtils;
import com.transsion.infinix.xclub.util.IMageUtil;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.TextUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.transsion.infinix.xclub.view.EmoteInputView;
import com.transsion.infinix.xclub.view.ModifyAvatarDialog;
import com.transsion.infinix.xclub.view.UploadPreviewImageView;
import com.trassion.infinix.xclub.R;

public class WritePostActivity extends BaseActivity implements OnClickListener,ImageUploadStateListener,OnItemClickListener,RequestListener<BaseEntity>{

	private LinearLayout tvback;
	private ImageView imgFace;
	private ImageView imgPicture;
	private Map<String, String> mFile; 
	private Uri imageFileUri=null; //��ǰͼƬ;
	private Bitmap bitmap = null;// ��ʾ��������ͼƬ����
	private String currentUploadPath = "";// ��ǰ�����ϴ���ͼƬ·��
	private ImageView addImageButton;
	private String picPath;
	private EditText editPostContent;
	final int LIMIT_WIDTH = 50;
	final int LIMIT_HEIGHT = 75;
	private EditText etPostTitle;
	private Button btPublish;
	private String message;//��������
	private String title;
	private ArrayList<BasicNameValuePair> mParams;
	private BaseDao dao;
	private static final int FLAG_CHOOSE_IMG = 1;
	private static final int FLAG_CHOOSE_PHONE = 2;
	private static String localTempImageFileName = "";
	File cacheFilePath = new File(Constant.TMP_PATH);
	public final int RESULT_FOR_DELETE = 0;
	private LinearLayout imagesUploadView;
	private LinearLayout layout_country;
	private InputMethodManager imm = null;// ����̹���
	private EmoteInputView mInputView;// �Զ������ؼ�
	private LoginInfo logininfo;
	private View view;
	private String typeid="";
	private TextView tvCountry;
	private String uid;
	private String auth;
	private String saltkey;
	private long exitTime;
	private LinearLayout layout_post;
	private CheckBox checkBox;
	private boolean isCheck=false;
	private RelativeLayout layout_share_button;

	private void initView() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		imgFace=(ImageView)findViewById(R.id.imgFace);
		btPublish=(Button)findViewById(R.id.btPublish);
		etPostTitle=(EditText)findViewById(R.id.etPostTitle);
		editPostContent=(EditText)findViewById(R.id.editPostContent);
		imagesUploadView = (LinearLayout) findViewById(R.id.imagesUploadView);
		layout_country=(LinearLayout)findViewById(R.id.layout_country);
		layout_post=(LinearLayout)findViewById(R.id.layout_post);
		layout_share_button=(RelativeLayout)findViewById(R.id.layout_share_button);
		layout_share_button.setVisibility(View.GONE);
		checkBox=(CheckBox)findViewById(R.id.checkBox);
		addImageButton = (ImageView) findViewById(R.id.addImageButton);
		imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		tvCountry=(TextView)findViewById(R.id.tvCountry);
		mInputView = (EmoteInputView) findViewById(R.id.chat_eiv_inputview);
		mInputView.setEditText(editPostContent);
		
		mFile = new LinkedHashMap<String, String>();// ����ϴ�ͼƬ��ַ
		uid=PreferenceUtils.getPrefInt(WritePostActivity.this,"uid", 0)+"";
		auth=PreferenceUtils.getPrefString(this, "auth", "");
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey","");
	    mParams=new ArrayList<BasicNameValuePair>();
		
	}

	private void setListener() {
		tvback.setOnClickListener(this);
		imgFace.setOnClickListener(this);
		btPublish.setOnClickListener(this);
		addImageButton.setOnClickListener(this);
		layout_country.setOnClickListener(this);
		
        checkBox.setOnCheckedChangeListener(new OnCheckedChangeListener() {
			

			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				isCheck=isChecked;
			}
		});
		
		layout_post.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {
				if (mInputView.isShown()) {
					mInputView.setVisibility(View.GONE);
				}
				mInputView.setVisibility(View.GONE);
				return false;
			}
		});
		etPostTitle.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {
				if (mInputView.isShown()) {
					mInputView.setVisibility(View.GONE);
					imm.showSoftInput(editPostContent, 0);
					editPostContent.requestFocus();
					editPostContent.setFocusable(true);
				}
				mInputView.setVisibility(View.GONE);
				return false;
			}
		});
		editPostContent.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {
				if (mInputView.isShown()) {
					mInputView.setVisibility(View.GONE);
					imm.showSoftInput(editPostContent, 0);
					editPostContent.requestFocus();
					editPostContent.setFocusable(true);
				}
				mInputView.setVisibility(View.GONE);
				return false;
			}
		});
		
	}
	private void setData() {
		if(uid.equals("0")){
			Logion();
		}
	}
	
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
				animFinish();
			break;
		case R.id.btPublish:
			// ����
		title=etPostTitle.getText().toString();
		   message = editPostContent.getText().toString();
		   if(TextUtils.isEmpty(title)){
			   ToastManager.showShort(this, "Please wrote down the title");
			   return;
		   }
		   if(TextUtils.isEmpty(message)){
			   ToastManager.showShort(this, "Please post content");
			   return;
		   }
		   if(tvCountry.getText().equals("Select a country")){
			   ToastManager.showShort(this, "Choose the country");
			   return;
		   }
		   if(!NetUtil.isConnect(this)){
	 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
	 			return;
	 		}
		   if(uid.equals("0")){
			   Logion();
			   return;
		   }
		  
		   MasterApplication.getInstanse().showLoadDataDialogUtil(WritePostActivity.this,dao);
		   mParams.clear();
		   if (mFile.size()> 0)
				uploadFile();// ���ϴ�ͼƬ
			else
				sendNewBlog(false);// ���ʹ��ı�����
			break;
		case R.id.imgFace:
			// ����
			if(mInputView.isShown()){
			imm.hideSoftInputFromWindow(editPostContent.getWindowToken(), 0);
		    mInputView.setVisibility(View.GONE);
			}else{
				imm.hideSoftInputFromWindow(editPostContent.getWindowToken(), 0);
			    mInputView.setVisibility(View.VISIBLE);
			}
			break;
		case R.id.addImageButton:
			showChooiceDialog();
			break;
		case R.id.layout_country:
			Intent intent = new Intent(getApplicationContext(),SelectCountryActivity.class);
			startActivityForResult(intent, Constant.GO_TO_CHOOSECOUNTRY);
			break;
		default:
			break;
		}		
	}
	private void Logion() {
		Intent intent=new Intent(this,LoginActivity.class);
		animStartActivity(intent);
		ToastManager.showShort(this, "Please login");
		
	}
	private void showChooiceDialog() {
		//����ѡ�����ַ�ʽ��dialog
				ModifyAvatarDialog modifyAvatarDialog = new ModifyAvatarDialog(this){
					//ѡ�񱾵����
					@Override
					public void doGoToImg() {
						this.dismiss();
						Intent intent = new Intent();
						intent.setAction(Intent.ACTION_PICK);
						intent.setType("image/png,image/jpeg");
						startActivityForResult(intent, FLAG_CHOOSE_IMG);
					}
					//ѡ���������
					@Override
					public void doGoToPhone() {
						this.dismiss();
						String status = Environment.getExternalStorageState();
						if (status.equals(Environment.MEDIA_MOUNTED)) {
							try {
								localTempImageFileName = "";
								localTempImageFileName = String.valueOf((new Date())
										.getTime()) + ".png";
								
								if (!cacheFilePath.exists()) {
									cacheFilePath.mkdirs();
								}
								Intent intent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
								File f = new File(cacheFilePath, localTempImageFileName);
								Uri u = Uri.fromFile(f);
								intent.putExtra(MediaStore.EXTRA_OUTPUT, u);
								intent.putExtra(MediaStore.Images.Media.MIME_TYPE,  "image/jpeg");
								startActivityForResult(intent, FLAG_CHOOSE_PHONE);
							} catch (ActivityNotFoundException e) {
								e.printStackTrace();
							}
						}
					}
				};
				modifyAvatarDialog.show();
		
	}
	
	private void uploadFile() {
		if (mFile.size()> 0) {
			String sys_authkey=PreferenceUtils.getPrefString(this, "sys_authkey", "");
			
	         final Map<String, String> params = new HashMap<String, String>();
	         params.put("uid", uid);
	         params.put("type", "image");
	         params.put("fid", "41");
	         params.put("auth", auth);
	         params.put("saltkey", saltkey);
	         params.put("hash", sys_authkey);
			for (Map.Entry<String, String> entry : mFile.entrySet()) {
				picPath = entry.getValue();
				// ��ֵ��ǰ�����ϴ���ͼƬ·��
				currentUploadPath = picPath;
				break;
			}
			 params.put("filePath", currentUploadPath);
			 Runnable runnable=new Runnable() {
				
				@Override
				public void run() {
					Message msg=new Message();
					Bundle data=new Bundle();
					String result = HttpFormUtil.post(Constant.BASE_PICTRUE_URL, params);
					data.putString("value", result);
					msg.setData(data);
					handler.sendMessage(msg);
				}
			};
			new Thread(runnable).start();
			
		}
	}
	Handler handler=new Handler(){
		

		@SuppressWarnings("null")
		public void handleMessage(Message msg) {
			Bundle data=msg.getData();
			String result=data.getString("value");
			Log.i("info","result:"+result);
			if(result!=null ||!result.equals("")){
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
				int code=Integer.parseInt(logininfo.getVariables().getCode());
				if(code>0){
//					if(file!=null&&file.exists()){
//						file.delete();
//					}
					mFile.remove(currentUploadPath);
					String fileid = "[attach]" + logininfo.getVariables().getCode() + "[/attach]";// ͼ���Ű�
					message = message.replace(picPath, fileid);
					String fkey = "attachnew[" + logininfo.getVariables().getCode()
							+ "][decription]";// ����
					Log.i("info","code:"+fkey);
					 mParams.add(new BasicNameValuePair(fkey,""));
					if (mFile.size() > 0) {// ������и��������ϴ�
						uploadFile();
					}else{
						// ��������
						sendNewBlog(true);
						currentUploadPath = "";
					}
				} else {
					 MasterApplication.getInstanse().closeLoadDataDialogUtil();
					String tips = "";
					switch (code) {
					case -1:
					case -4:
					case -7:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips1);
						break;
					case -2:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips2);
						break;
					case -3:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips3);
						break;
					case -5:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips4);
						break;
					case -6:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips5);
						break;
					case -8:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips6);
						break;
					case -9:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips7);
						break;
					case -10:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips8);
						break;
					case -11:
						tips = WritePostActivity.this.getString(R.string.upload_pic_tips9);
						break;
					default:
						break;
					}
					ToastManager.showShort(WritePostActivity.this, tips);
				}
			}else{
			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
			  ToastManager.showShort(WritePostActivity.this, getString(R.string.upload_photo_error));
			}
		}
	};
	
	private File file;
	private void sendNewBlog(boolean uploadFile) {
		 mParams.add(new BasicNameValuePair("version","5"));
         mParams.add(new BasicNameValuePair("module","newthread"));
         mParams.add(new BasicNameValuePair("fid","41"));
         mParams.add(new BasicNameValuePair("subject",title));
         mParams.add(new BasicNameValuePair("message",message));
         mParams.add(new BasicNameValuePair("typeid",typeid));
         mParams.add(new BasicNameValuePair("auth", auth));
         mParams.add(new BasicNameValuePair("saltkey", saltkey));
     if (uploadFile) {
 		 mParams.add(new BasicNameValuePair("uploadalbum", "2"));// ���Ӳ�����Ϊuploadalbum�Ĳ���ֵΪ2
 	     mParams.add(new BasicNameValuePair("replycredit_times", "1"));// ���Ӳ�����Ϊreplycredit_times�Ĳ���ֵΪ1
 	     mParams.add(new BasicNameValuePair("replycredit_membertimes", "1"));// ���Ӳ�����Ϊreplycredit_membertimes�Ĳ���ֵΪ1
         }
         dao = new BaseDao(WritePostActivity.this, mParams, this, null);
         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
                Constant.BASE_URL, "get", "false");
	}
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == FLAG_CHOOSE_IMG && resultCode == RESULT_OK) {
			if (data != null) {
				Uri uri = data.getData();
				if (!TextUtils.isEmpty(uri.getAuthority())) {
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
			
	  }else if (Constant.GO_TO_CHOOSECOUNTRY== requestCode && RESULT_OK == resultCode)
		{
			Bundle extras = data.getExtras();
			if (extras != null) {
			   typeid=extras.getString("typeid");
			   tvCountry.setText(extras.getString("name"));
			}
		}else if(requestCode == RESULT_FOR_DELETE && resultCode == RESULT_OK){
			 if(data != null){
				  int imageViewIndex = data.getIntExtra("imageViewIndex", -1);
				  deleteImage(imageViewIndex);
				  if (addImageButton.getVisibility() != View.VISIBLE){
					  addImageButton.setVisibility(View.VISIBLE);
				  }
				  
			  }
		}
	}
	
	 private void comprassBitmap(String path, int type){
			Bitmap tmpbitmap = TextUtils.getBitmap(path);
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
			 UploadPreviewImageView iv = createUploadPreviewImageView();
			 iv.setImageBitmap(b);
			 iv.setUploadListener(this);
			 iv.setPreviewImagePath(previewImagePath);
			 iv.setImagePath(path, type);
			 mFile.put(path, path);
			 
			 
			
		}
		/**
		 * ����Ԥ����ͼ
		 * @return
		 */
		private UploadPreviewImageView createUploadPreviewImageView(){
			UploadPreviewImageView iv = new UploadPreviewImageView(this);
			LayoutParams lp = new LayoutParams(125, 125);
			lp.setMargins(5, 0, 0, 0);
			iv.setOnClickListener(new ImageThumbnailClick(iv));
		
			 imagesUploadView.addView(iv, imagesUploadView.getChildCount() - 1, lp);
			 if(imagesUploadView.getChildCount() > 9){
				 addImageButton.setVisibility(View.GONE);
			 }
			return iv;
		}
		class ImageThumbnailClick implements OnClickListener{
			UploadPreviewImageView iv;
			ImageThumbnailClick(UploadPreviewImageView iv){
				this.iv = iv;
			}
			@Override
			public void onClick(View v) {
				if(iv.imagePath == null) return;
				Intent intent=new Intent(WritePostActivity.this,PostImagePreviewActivity.class);
				Bundle data = new Bundle();
				data.putString("path", iv.imagePath);
				data.putInt("imageViewIndex", getImageViewIndexInPreview(iv));
				intent.putExtras(data);
				animStartActivityForResult(intent,RESULT_FOR_DELETE);
			}
		}
		public int getImageViewIndexInPreview(UploadPreviewImageView iv){
			for(int i = 0; i < imagesUploadView.getChildCount(); i++){
				 if(imagesUploadView.getChildAt(i) == iv){
					 return i;
				 }
			}
			
			return -1;
		}
		/**
		 * �����ϴ�ͼƬ�е���Դ
		 * @param iv
		 */
		private void recyleUploadViewBitmap(UploadPreviewImageView iv){
			if( iv.getDrawable() != null){
				  iv.getDrawable().setCallback(null);
				  if(((BitmapDrawable)iv.getDrawable()).getBitmap() != null && !((BitmapDrawable)iv.getDrawable()).getBitmap().isRecycled()){
				       Bitmap b = ((BitmapDrawable)iv.getDrawable()).getBitmap();
				       b.recycle();
				       b = null;
				  }
			  }
			  if(iv.getPreviewImagePath() != null){
				  FileUtils.delete(iv.getPreviewImagePath());
			  }
		}
		/**
		 * ɾ���ϴ�ͼƬ
		 */
		private void deleteImage(int imageViewIndex){
			if(imageViewIndex == -1) return;
			
			View view = imagesUploadView.getChildAt(imageViewIndex);
			if(view instanceof UploadPreviewImageView){
				 UploadPreviewImageView iv = (UploadPreviewImageView)view;
				 recyleUploadViewBitmap(iv);
				 imagesUploadView.removeView(iv);
			}
			
			if(imagesUploadView.getChildCount() < 9 && addImageButton.getVisibility() != View.VISIBLE){
				 addImageButton.setVisibility(View.VISIBLE);
			 }
		}
	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		
	}
	
	@Override
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			 logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			 if(logininfo.getMessage().getMessageval().equals("post_newthread_succeed")){
				 Intent intent=new Intent(this,RecommendActivity.class);
				 intent.putExtra("tid", logininfo.getVariables().getTid());
				 intent.putExtra("isCheck", isCheck);
				 animStartActivity(intent);
				 finish();
			 }else{
				 //����ʧ��
				 ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
			 }
		}else{
			ToastManager.showShort(this, "Data requests failed, please try again later");
		}
		
	}
	@Override
	public void onNetworkNotConnection() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void uploadFail() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void uploadSuccess() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void setContentView() {
		setContentView(R.layout.activity_write_post);
		initView();
		setListener();
		setData();
		
	}
	@Override
	public void initWidget() {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
}
