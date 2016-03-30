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
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Toast;
import android.widget.LinearLayout.LayoutParams;

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
import com.transsion.infinix.xclub.view.ModifyAvatarDialog;
import com.transsion.infinix.xclub.view.UploadPreviewImageView;
import com.trassion.infinix.xclub.R;

public class ContactActivity extends BaseActivity implements OnClickListener,ImageUploadStateListener,RequestListener<BaseEntity>{
         
	private LinearLayout tvback;
	private ImageView addImageButton;
	private static final int FLAG_CHOOSE_IMG = 1;
	private static final int FLAG_CHOOSE_PHONE = 2;
	private static String localTempImageFileName = "";
	File cacheFilePath = new File(Constant.TMP_PATH);
	public final int RESULT_FOR_DELETE = 101;
	private File file;
	private Map<String, String> mFile;
    ArrayList<Uri> imageUris = new ArrayList<Uri>();
	private LinearLayout imagesUploadView;
	private Button btPublish;
	private EditText etContact;
	private String message;
	private EditText etContactInformation;
	private String contact;
	private String[] emailReciver;
	private String emailSuject;
	private EditText etTitle;
	private String title;
	private String auth;
	private String uid;
	private String saltkey;
	private ArrayList<BasicNameValuePair> mParams; 
	private LoginInfo logininfo;
	private String picPath;
	private String currentUploadPath = "";// 当前正在上传的图片路径
	private BaseDao dao;
	private String messages;
	
	
	private void Logion() {
		Intent intent=new Intent(this,LoginActivity.class);
		animStartActivity(intent);
		ToastManager.showShort(this, "Please login");
		
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.tvback:
			animFinish();
			break;
		case R.id.addImageButton:
			showChooiceDialog();
			break;
		case R.id.btPublish:
			title=etTitle.getText().toString();
			message=etContact.getText().toString();
			contact=etContactInformation.getText().toString();
			uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
			auth=PreferenceUtils.getPrefString(this, "auth", "");
		    saltkey=PreferenceUtils.getPrefString(this, "saltkey","");
			messages=message+contact;
			if(TextUtils.isEmpty(title)){
				   ToastManager.showShort(this, "Please enter the title");
				   return;
			   }
			if(TextUtils.isEmpty(message)){
				   ToastManager.showShort(this, "Your questions or suggestions");
				   return;
			   }
			if(TextUtils.isEmpty(contact)){
				   ToastManager.showShort(this, "Please leave your contact");
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
			sendMessage();
			break;
		default:
			break;
		}
		
	}
	private void sendMessage() {
		 MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		 mParams.clear();
		   if (mFile.size()> 0)
			   uploadFile();// 先上传图片
			else
				sendNewBlog(false);// 发送纯文本帖子
			
	}
	private void uploadFile() {
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
				// 赋值当前正在上传的图片路径
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
					String fileid = "[attach]" + logininfo.getVariables().getCode() + "[/attach]";// 图文排版
					message = message.replace(picPath, fileid);
					String fkey = "attachnew[" + logininfo.getVariables().getCode()
							+ "][decription]";// 参数
					Log.i("info","code:"+fkey);
					 mParams.add(new BasicNameValuePair(fkey,""));
					if (mFile.size() > 0) {// 如果还有附件继续上传
						uploadFile();
					}else{
						// 发送帖子
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
						tips = ContactActivity.this.getString(R.string.upload_pic_tips1);
						break;
					case -2:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips2);
						break;
					case -3:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips3);
						break;
					case -5:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips4);
						break;
					case -6:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips5);
						break;
					case -8:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips6);
						break;
					case -9:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips7);
						break;
					case -10:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips8);
						break;
					case -11:
						tips = ContactActivity.this.getString(R.string.upload_pic_tips9);
						break;
					default:
						break;
					}
					ToastManager.showShort(ContactActivity.this, tips);
				}
			}else{
			   MasterApplication.getInstanse().closeLoadDataDialogUtil();
			  ToastManager.showShort(ContactActivity.this, getString(R.string.upload_photo_error));
			}
		}
	};
	private void sendNewBlog(boolean uploadFile) {
		mParams.add(new BasicNameValuePair("version","5"));
        mParams.add(new BasicNameValuePair("module","newthread"));
        mParams.add(new BasicNameValuePair("fid","41"));
        mParams.add(new BasicNameValuePair("subject",title));
        mParams.add(new BasicNameValuePair("message",messages));
        mParams.add(new BasicNameValuePair("typeid","19"));
        mParams.add(new BasicNameValuePair("auth", auth));
        mParams.add(new BasicNameValuePair("saltkey", saltkey));
    if (uploadFile) {
		 mParams.add(new BasicNameValuePair("uploadalbum", "2"));// 附加参数名为uploadalbum的参数值为2
	     mParams.add(new BasicNameValuePair("replycredit_times", "1"));// 附加参数名为replycredit_times的参数值为1
	     mParams.add(new BasicNameValuePair("replycredit_membertimes", "1"));// 附加参数名为replycredit_membertimes的参数值为1
        }
        dao = new BaseDao(this, mParams, this, null);
        dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
               Constant.BASE_URL, "get", "false");
		
	}

	private void showChooiceDialog() {
		//调用选择那种方式的dialog
				ModifyAvatarDialog modifyAvatarDialog = new ModifyAvatarDialog(this){
					//选择本地相册
					@Override
					public void doGoToImg() {
						this.dismiss();
						Intent intent = new Intent();
						intent.setAction(Intent.ACTION_PICK);
						intent.setType("image/png,image/jpeg");
						startActivityForResult(intent, FLAG_CHOOSE_IMG);
					}
					//选择相机拍照
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
	/**
	 * 删除上传图片
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
		 * 处理获取的图片
		 * 0表示相册选择的 1表示从相机拍的
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
			 imageUris.add(Uri.parse(path));
			 
			 
			
		}
		/**
		 * 生成预览视图
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
				Intent intent=new Intent(ContactActivity.this,PostImagePreviewActivity.class);
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
		 * 回收上传图片中的资源
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
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		
	}
	
	public void onBegin() {
		// TODO Auto-generated method stub
		
	}


	@Override
	public void uploadSuccess() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void uploadFail() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onComplete(BaseEntity result) {
		MasterApplication.getInstanse().closeLoadDataDialogUtil();
		if(result!=null){
			 logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
			 if(logininfo.getMessage().getMessageval().equals("post_newthread_succeed")){
				 Log.i("info","uid"+logininfo.getVariables().getMember_uid());
				 ToastManager.showLong(this, "Success!");
				 animFinish();
			 }else{
				 //发帖失败
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
	public void setContentView() {
		setContentView(R.layout.activity_contact);
	}

	@Override
	public void initWidget() {
		tvback=(LinearLayout)findViewById(R.id.tvback);
		addImageButton = (ImageView) findViewById(R.id.addImageButton);
		btPublish=(Button)findViewById(R.id.btPublish);
		etTitle=(EditText)findViewById(R.id.etTitle);
        etContact=(EditText)findViewById(R.id.etContact);
        etContactInformation=(EditText)findViewById(R.id.etContactInformation);
		imagesUploadView = (LinearLayout) findViewById(R.id.imagesUploadView);

		mFile = new LinkedHashMap<String, String>();// 存放上传图片地址
		uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
		auth=PreferenceUtils.getPrefString(this, "auth", "");
	    saltkey=PreferenceUtils.getPrefString(this, "saltkey","");
	    mParams=new ArrayList<BasicNameValuePair>();
	    
	    if(uid.equals("0")){
			Logion();
		}
	    
		tvback.setOnClickListener(this);
		addImageButton.setOnClickListener(this);
		btPublish.setOnClickListener(this);
	}

	@Override
	public void getData() {
		// TODO Auto-generated method stub
		
	}
}
