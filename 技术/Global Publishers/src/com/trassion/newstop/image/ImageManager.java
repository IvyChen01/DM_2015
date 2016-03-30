package com.trassion.newstop.image;

import java.util.Collections;
import java.util.LinkedList;
import java.util.List;

import android.content.Context;
import android.graphics.Bitmap;
import android.view.View;
import android.widget.ImageView;

import com.nostra13.universalimageloader.cache.disc.naming.Md5FileNameGenerator;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;
import com.nostra13.universalimageloader.core.display.FadeInBitmapDisplayer;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.nostra13.universalimageloader.core.listener.ImageLoadingListener;
import com.nostra13.universalimageloader.core.listener.SimpleImageLoadingListener;
import com.trassion.newstop.activity.R;

/**
 * 
 * @author 
 *
 */
public class ImageManager{
    
    public DisplayImageOptions options;
    public DisplayImageOptions option,imageOption;
    public ImageLoadingListener animateFirstListener = (ImageLoadingListener) new AnimateFirstDisplayListener();
    int defaultImageId = R.drawable.account_undefine_avatar;
    int defaultImage=R.drawable.picture;
	public DisplayImageOptions mDisplayImageOptions;
	public DisplayImageOptions mDisplayImageOption;
    public ImageManager(){
        super();
        if(options==null){
            options= new DisplayImageOptions.Builder()
            .showImageOnLoading(R.drawable.me_undefine_avatar)
            .showImageForEmptyUri(R.drawable.me_undefine_avatar)
            .showImageOnFail(R.drawable.me_undefine_avatar)
            .showStubImage(R.drawable.me_undefine_avatar)
            .cacheInMemory(true)
            .cacheOnDisc(true)
            .displayer(new RoundedBitmapDisplayer(10))
            .build();
        }
        if(option==null){
            option= new DisplayImageOptions.Builder()
            .showImageOnLoading(R.drawable.account_undefine_avatar)
            .showImageForEmptyUri(R.drawable.account_undefine_avatar)
            .showImageOnFail(R.drawable.account_undefine_avatar)
            .showStubImage(R.drawable.account_undefine_avatar)
            .cacheInMemory(true)
            .cacheOnDisc(true)
            .displayer(new RoundedBitmapDisplayer(70))
            .build();
        }
        if(imageOption==null){
        	imageOption= new DisplayImageOptions.Builder()
            .showImageOnLoading(R.drawable.account_undefine_avatar)
            .showImageForEmptyUri(R.drawable.account_undefine_avatar)
            .showImageOnFail(R.drawable.account_undefine_avatar)
            .showStubImage(R.drawable.account_undefine_avatar)
            .cacheInMemory(true)
            .cacheOnDisc(true)
            .displayer(new RoundedBitmapDisplayer(80))
            .build();
        }
        mDisplayImageOptions = new DisplayImageOptions.Builder()
        .showStubImage(defaultImageId)
        .showImageForEmptyUri(defaultImageId)
        .showImageOnFail(defaultImageId)
        .cacheInMemory(true)
        .cacheOnDisc(true)
        .resetViewBeforeLoading()
        .build();
        mDisplayImageOption = new DisplayImageOptions.Builder()
        .showStubImage(defaultImage)
        .showImageForEmptyUri(defaultImage)
        .showImageOnFail(defaultImage)
        .cacheInMemory(true)
        .cacheOnDisc(true)
        .resetViewBeforeLoading()
        .build();
    }
    //取消 图片圆角
    public ImageManager(int i)
    {
        super();
        if(options==null){
            options= new DisplayImageOptions.Builder()
            .showImageOnLoading(R.drawable.picture)
            .showImageForEmptyUri(R.drawable.picture)
            .showImageOnFail(R.drawable.picture)
            .showStubImage(R.drawable.picture)
            .cacheInMemory(true)
            .cacheOnDisc(true)
            .displayer(new RoundedBitmapDisplayer(40))
            .build();
        }
    }
    

    public class AnimateFirstDisplayListener extends SimpleImageLoadingListener {

         final List<String> displayedImages = Collections.synchronizedList(new LinkedList<String>());

        @Override
        public void onLoadingComplete(String imageUri, View view, Bitmap loadedImage) {
            if (loadedImage != null) {
                ImageView imageView = (ImageView) view;
                boolean firstDisplay = !displayedImages.contains(imageUri);
                if (firstDisplay) {
                    FadeInBitmapDisplayer.animate(imageView, 500);
                    displayedImages.add(imageUri);
                }
            }
        }
    }
    public void initImageLoader(Context context) {
		ImageLoaderConfiguration config = new ImageLoaderConfiguration
                .Builder(context)
                    .threadPriority(Thread.NORM_PRIORITY - 2)
                .denyCacheImageMultipleSizesInMemory()
                .discCacheFileNameGenerator(new Md5FileNameGenerator())
                .tasksProcessingOrder(QueueProcessingType.LIFO)
                .build();
           ImageLoader.getInstance().init(config);

	}

}
