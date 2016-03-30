package com.transsion.infinix.xclub.view;


import com.transsion.infinix.xclub.listener.ImageUploadStateListener;

import android.content.Context;
import android.database.Observable;
import android.util.AttributeSet;
import android.widget.ImageView;


public class UploadPreviewImageView extends ImageView {

	UPLOAD_STATE uploadStat = UPLOAD_STATE.NORMAL;
	public enum  UPLOAD_STATE{
		NORMAL, UPLOADING, UPLOAD_SUCCESS, UPLOAD_FAIL 
	}
	
	ImageUploadStateListener imageUploadStateListener;
	//存储缩略图路径,便与操作完成后清除
	public String previewImagePath;
	//图片缓存所在的本地路径
	public String imagePath;
	//0表示相册选择的 1表示从相机拍的
	public int fileType = 0;
	
	public String getImagePath() {
		return imagePath;
	}

	public void setImagePath(String imagePath, int type) {
		this.imagePath = imagePath;
		fileType = type;
	}

	public String getPreviewImagePath() {
		return previewImagePath;
	}

	public void setPreviewImagePath(String previewImagePath) {
		this.previewImagePath = previewImagePath;
	}
	
	public UploadPreviewImageView(Context context) {
		super(context);
		
	}

	public UploadPreviewImageView(Context context, AttributeSet attrs) {
		super(context, attrs);
		
	}
	
	public void setUploadListener(ImageUploadStateListener imageUploadStateListener){
		  this.imageUploadStateListener = imageUploadStateListener;
	}
	
	
//	public void update(Observable o, BaseResponse response) {
//		if (response != null && response.errorCode == BaseResponse.RESPONSE_SUCC) {
//			 if(response instanceof ImageUploadResponse){
//				 ImageUploadResponse r = (ImageUploadResponse)response;
//				 if(r.imagesUrl != null && !"".equals(r.imagesUrl)){
//					 uploadStat = UPLOAD_STATE.UPLOAD_SUCCESS;
//					 this.setTag(r.imagesUrl);
//					 imageUploadStateListener.uploadSuccess();
//				 }else{
//				     uploadStat = UPLOAD_STATE.UPLOAD_FAIL;
//				     imageUploadStateListener.uploadFail();
//				  
//				 }
//			 }
//		}else{
//			uploadStat = UPLOAD_STATE.UPLOAD_FAIL;
//			 imageUploadStateListener.uploadFail();
//		}
		
//	}
	

}

