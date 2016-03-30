package com.transsion.infinix.xclub.activity;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.transsion.infinix.xclub.base.BaseActivity;
import com.trassion.infinix.xclub.R;

public class PostImagePreviewActivity extends BaseActivity implements OnClickListener{

	private ImageView previewImageView;
	private String path;
	private int imageViewIndex;
	private Bitmap previewBitmap;
	private TextView deleteButton;
	private LinearLayout tvback;

	@Override
	public void setContentView() {
		setContentView(R.layout.sw_imagepreview_activity);

	}

	@Override
	public void initWidget() {
		previewImageView = (ImageView) findViewById(R.id.previewImageView);
		path = this.getIntent().getStringExtra("path");
		imageViewIndex = this.getIntent().getIntExtra("imageViewIndex", -1);
		
		if(path != null){
			previewBitmap = BitmapFactory.decodeFile(path);
			previewImageView.setImageBitmap(previewBitmap);
		}
		deleteButton = (TextView) findViewById(R.id.deleteButton);
		tvback=(LinearLayout)findViewById(R.id.tvback);
		
		deleteButton.setOnClickListener(this);
		tvback.setOnClickListener(this);
		
	}
	@Override
	public void finish() {
		super.finish();
		if(previewBitmap != null && !previewBitmap.isRecycled()){
			previewBitmap.recycle();
		}
	}
	@Override
	public void getData() {
		// TODO Auto-generated method stub

	}

	@Override
	public void onClick(View v) {
		if(v == deleteButton && path != null){
			   Intent i = new Intent();
			   i.putExtra("path", path);
			   i.putExtra("imageViewIndex", imageViewIndex);
			   this.setResult(RESULT_OK, i);
			   this.finish();
		 
		 }else if(v == tvback){
			 animFinish();
		 }
		
	}

}
