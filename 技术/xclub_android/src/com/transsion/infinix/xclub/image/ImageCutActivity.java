package com.transsion.infinix.xclub.image;


import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;

import com.transsion.infinix.xclub.base.CurrentActivityContext;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.media.ExifInterface;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;

/**
 * 图片裁剪
 * 
 * @author chenqian
 */
public class ImageCutActivity extends Activity implements OnClickListener {

	private ProgressDialog progressDialog;
	public static final String PATH = "PATH";
	private String path;
	private ImageCutView imageCutView;
	private boolean success = false;
	private View rotateLeftBtn;
	private View rotateRightBtn;
	private View scaleLargeBtn;
	private View scaleSmallBtn;
	private View cutBtn;
	public static final String RESULT_PATH = "RESULT_PATH";
//	private FinalBitmap fb;
	private Bitmap bit;

	protected void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		//添加Activity到堆栈
        AppManager.getAppManager().addActivity(this);
        CurrentActivityContext.getInstance().setCurrentContext(this);
		setContentView(R.layout.image_cut);
//		fb = FinalBitmap.create(this);
		rotateLeftBtn = findViewById(R.id.rotate_left_btn);
		rotateRightBtn = findViewById(R.id.rotate_right_btn);
		scaleLargeBtn = findViewById(R.id.scale_large_btn);
		scaleSmallBtn = findViewById(R.id.scale_small_btn);
		cutBtn = findViewById(R.id.cut_btn);

		rotateLeftBtn.setOnClickListener(this);
		rotateRightBtn.setOnClickListener(this);
		scaleLargeBtn.setOnClickListener(this);
		scaleSmallBtn.setOnClickListener(this);
		findViewById(R.id.back_btn).setOnClickListener(this);
		cutBtn.setOnClickListener(this);

		path = getIntent().getStringExtra(PATH);

		imageCutView = (ImageCutView) findViewById(R.id.image_cut_view);

		File file = new File(path);

		if (file.exists()) {
			try {

			    // 以下代码 主要是解决 OOM 错误！
			    BitmapFactory.Options bfOptions=new BitmapFactory.Options();
			    bfOptions.inJustDecodeBounds = false;  
			    bfOptions.inPurgeable = true;  
			    bfOptions.inInputShareable = true;  
		        // Do not compress  
			    bfOptions.inSampleSize = 1;  
			    bfOptions.inPreferredConfig = Config.RGB_565;
                 FileInputStream fs=null;
                 try {
                    fs = new FileInputStream(file);
                } catch (FileNotFoundException e) {
                    e.printStackTrace();
                }
                 if(fs != null)
                    try {
                        bit = BitmapFactory.decodeFile(path, bfOptions);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }finally{
                        if(fs!=null) {
                            try {
                                fs.close();
                            } catch (IOException e) {
                                e.printStackTrace();
                            }
                        }
                    }
//				bit = BitmapFactory.decodeFile(path);
				
				if (bit != null) {
					imageCutView.setBitmap(bit);
//			    fb.clearCache();
//			    fb.display(imageCutView, path);
					success = true;
				}
				// loadImg(path);

			} catch (Exception e) {
				e.printStackTrace();
				ToastManager.showShort(this, "File loading failure");
			}

		} else {
			ToastManager.showShort(this, "Pictures do not exist");
		}

	}
	
    @Override
    protected void onDestroy() {
        super.onDestroy();
        
        //结束Activity&从堆栈中移除
        AppManager.getAppManager().finishActivity(this);
    }
    

	/**
	 * 结束
	 */
	public void animFinish() {
		finish();
		overridePendingTransition(0, R.anim.roll_down);
	}

	/**
	 * 上传图片 并显示
	 * 
	 * @param picUri
	 */
	public void loadImg(String picUri) {

		Bitmap photoViewBitmap;
		try {// 31961088
			
			BitmapFactory.Options bitmapOptions = new BitmapFactory.Options();

			File sizeFile = new File(picUri);
			long bmpSize = sizeFile.length();
			if (bmpSize <= 90000) {
				bitmapOptions.inSampleSize = 1;
			} else if (bmpSize >= 1000000) {
				bitmapOptions.inSampleSize = 5;
			}
			int angle = getExifOrientation(picUri);
			photoViewBitmap = BitmapFactory.decodeFile(picUri, bitmapOptions);
			if (angle != 0) { // 如果照片出现了 旋转 那么 就更改旋转度数
				Matrix matrix = new Matrix();
				matrix.postRotate(angle);
				photoViewBitmap = Bitmap.createBitmap(photoViewBitmap, 0, 0,
						photoViewBitmap.getWidth(),
						photoViewBitmap.getHeight(), matrix, true);
			}
			imageCutView.setBitmap(photoViewBitmap);
			// fb.display(imageCutView, picUri);
			// fb.configLoadingImage(R.drawable.ic_def_log);

		} catch (Exception e) {
			// // 防止用户上传一个不是图片的文件
			// System.out.println("出现异常");
			// e.printStackTrace();
			// Toast.makeText(this, "对不起，图片格式有误，请重新上传",
			// Toast.LENGTH_LONG).show();
			this.animFinish();
		}
	}

	/**
	 * 将 uri 转换为 String 路径
	 * 
	 * @param uri
	 * @return
	 */
	private String getUrl(Uri uri) {
		String[] proj = { MediaStore.Images.Media.DATA };
		Cursor actualimagecursor = managedQuery(uri, proj, null, null, null);
		int actual_image_column_index = actualimagecursor
				.getColumnIndexOrThrow(MediaStore.Images.Media.DATA);
		actualimagecursor.moveToFirst();
		String act = actualimagecursor.getString(actual_image_column_index);
		actualimagecursor.close();
		return act;
	}

	/**
	 * 得到 图片旋转 的角度
	 * 
	 * @param filepath
	 * @return
	 */
	private int getExifOrientation(String filepath) {
		int degree = 0;
		ExifInterface exif = null;
		try {
			exif = new ExifInterface(filepath);
		} catch (IOException ex) {
			Log.e("test", "cannot read exif", ex);
		}
		if (exif != null) {
			int orientation = exif.getAttributeInt(
					ExifInterface.TAG_ORIENTATION, -1);
			if (orientation != -1) {
				switch (orientation) {
				case ExifInterface.ORIENTATION_ROTATE_90:
					degree = 90;
					break;
				case ExifInterface.ORIENTATION_ROTATE_180:
					degree = 180;
					break;
				case ExifInterface.ORIENTATION_ROTATE_270:
					degree = 270;
					break;
				}
			}
		}
		return degree;
	}

	@Override
	public void onClick(View v) {

		if (success) {
			switch (v.getId()) {
			case R.id.rotate_left_btn:
//				animFinish();
				//逆时针旋转
				imageCutView.rotate(true);
				break;
			case R.id.rotate_right_btn:
				//顺时针旋转
				imageCutView.rotate(false);
				break;
			case R.id.scale_large_btn:
				imageCutView.scaleToLarge();
				break;
			case R.id.scale_small_btn:
				imageCutView.scaleToSmall();
				break;
			case R.id.cut_btn:
				new Thread() {
					public void run() {
						handler.sendEmptyMessage(2);
						String path = imageCutView.cutImage();
						if(!bit.isRecycled()){
						    bit.recycle();
						    System.gc();
						}
						Intent intent = new Intent();
						intent.putExtra(RESULT_PATH, path);
						setResult(RESULT_OK, intent);
						Message m = handler.obtainMessage(1, intent);
						m.sendToTarget();
					};
				}.start();
				//
				break;
			case R.id.back_btn:
				// Intent intent = new Intent(this, MoreMyInfoActivity.class);
				// animStartActivity(intent);
				animFinish();
				break;
			}
		}

	}

	/**
	 * 
	 * @param intent
	 */
	public void animStartActivity(Intent intent) {
		startActivity(intent);
		overridePendingTransition(R.anim.roll_up, R.anim.roll);
	}

	Handler handler = new Handler() {
		public void handleMessage(android.os.Message msg) {
			switch (msg.what) {
			case 1:
				progressDialog.dismiss();
				animFinish();
				break;
			case 2:
				progressDialog = new ProgressDialog(ImageCutActivity.this);
				progressDialog.setMessage("Save..");
				progressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
				progressDialog.setCancelable(false);
				progressDialog.show();
				break;
			}
		};
	};
}
