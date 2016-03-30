package com.transsion.infinix.xclub.image;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.lang.ref.SoftReference;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Collections;
import java.util.Map;
import java.util.Stack;
import java.util.WeakHashMap;

import com.transsion.infinix.xclub.constact.Constant;


import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Matrix;
import android.graphics.Paint;
import android.graphics.PorterDuffXfermode;
import android.graphics.RectF;
import android.util.Log;
import android.util.LruCache;
import android.widget.ImageView;


/**
 * 
* @ClassName: ImageLoader    
* @Description: TODO(图片加载类)    
* @author chen  
* @date 2015-11-13 上午9:31:29
 */
@SuppressLint("UseSparseArrays")
public class ImageLoader {
    
    private static final String TAG = ImageLoader.class.getSimpleName();
    private static ImageLoader instance;
	public LruCache<String, Bitmap> memoryCache;
    public FileCache fileCache;
    private Map<ImageView, String> imageViews=Collections.synchronizedMap(new WeakHashMap<ImageView, String>());
    private float mRadius=50;//默认圆角大小
    @SuppressLint("NewApi")
	private ImageLoader(Context context){
        //使背景thead低优先级。这样就不会影响到用户界面的性能
        photoLoaderThread.setPriority(Thread.NORM_PRIORITY-1);        
        fileCache=new FileCache(context);
        int maxMemory = (int)Runtime.getRuntime().maxMemory();
        int cacheSize = maxMemory/8;
        memoryCache = new LruCache<String, Bitmap>(cacheSize){
        	
        	@Override
        	protected int sizeOf(String key, Bitmap value) {
        		// TODO Auto-generated method stub
        		return value.getRowBytes()*value.getHeight();
        	}
        };
    }
    
    public static ImageLoader getInstance(Context context){
    	if(instance == null){
    		instance = new ImageLoader(context);
    	}
    	
    	return instance;
    }

	/**
	 * 异步显示图片
	 * @Title: DisplayImage
	 * @Description: TODO(显示图片)
	 * @param @param url 图片地址
	 * @param @param imageView
	 * @param @param isDecode 是否按比例压缩图片
	 * @param @param mBusy
	 * @param @param position 图片bitmap的key,回收图片时候根据key回收
	 * @param @param radius 圆角大小，0为没有
	 * @param @param stub_id 默认图片
	 * @return void 返回类型
	 * @throws
	 */
    @SuppressLint("NewApi")
	public void DisplayImage(String url, ImageView imageView,int isDecode,int position,float radius,int stub_id)
    {
    	imageViews.put(imageView, url);
    	Bitmap bitmap=memoryCache.get(url);
    	if(bitmap!=null&&!bitmap.isRecycled()){        	
    		imageView.setImageBitmap(bitmap);
    	}else { //if(!mBusy)      	
    		imageView.setImageResource(stub_id);  
    		queuePhoto(url, imageView,isDecode,position,radius,stub_id);
    	}  
       
    }


    public void DisplayImage(String url, ImageView imageView,int isdecode,int position) {  
    	DisplayImage(url, imageView,isdecode,position,mRadius,0);
    }  
    
    public void DisplayImage(String url, ImageView imageView) {  
    	DisplayImage(url, imageView,0,-1,mRadius,0);
    }
    
    /**
     * 通过当前缓存url删除图片
     * @param url
     */
    public void removeCacheImage(String url){
    	  fileCache.DeleteFile(url); 
    }
    public String getCachePath(String url){
    	return fileCache.getPath(url);
    }
    
    /**
     * 开启网络线程加载图片 
     */
    private void queuePhoto(String url, ImageView imageView,int isDecode,int position,float radius,int defId)
    {
        //这ImageView可能被用于其它图像之前。所以可能会有一些旧的任务队列。我们需要丢弃它们。 
        photosQueue.Clean(imageView);
        PhotoToLoad p=new PhotoToLoad(url, imageView,isDecode,position,radius,defId);
        synchronized(photosQueue.photosToLoad){
            photosQueue.photosToLoad.push(p);
            photosQueue.photosToLoad.notifyAll();
        }

        if(photoLoaderThread.getState()==Thread.State.NEW)
            photoLoaderThread.start();
    }
 
    /**
     * 图片圆角处理   
     * source 原始位图
     * radius 要显示的圆角大小        
     * @throws oom
     */
    public static Bitmap roundCorners(Bitmap source, final float radius) {
    	int width = source.getWidth();
    	int height = source.getHeight();
    	//定义预转换成的图片的宽度和高度
        int newWidth = 100;
        int newHeight = 100; 
        //正方形位图
        Bitmap scaleBitmap;
        /*由于头像图片大小不一，所以加载头像，先将图片缩放为正方形，这样在圆角处理的时候就能保证每张图片圆角大小一样*/
        //计算缩放率，新尺寸除原始尺寸
        float scaleWidth = ((float) newWidth) / width;
        float scaleHeight = ((float) newHeight) / height;        	
        // 创建操作图片用的matrix对象
        Matrix matrix = new Matrix();        	
        // 缩放图片动作
        matrix.postScale(scaleWidth, scaleHeight);        	
        // 创建新的图片
        scaleBitmap = Bitmap.createBitmap(source, 0, 0,
        		width, height, matrix, true);
        width = newWidth;
        height = newHeight;
        source=scaleBitmap;  
        /*圆角处理代码*/
        Paint paint = new Paint();
        paint.setAntiAlias(true);
        paint.setColor(android.graphics.Color.WHITE);
        Bitmap clipped = Bitmap.createBitmap(width, height, Bitmap.Config.ARGB_8888);
        Canvas canvas = new Canvas(clipped);
        canvas.drawRoundRect(new RectF(0, 0, width, height), radius, radius,
        		paint);
        paint.setXfermode(new PorterDuffXfermode(android.graphics.PorterDuff.Mode.SRC_IN));
        canvas.drawBitmap(source, 0, 0, paint);    	
        source.recycle();  
        return clipped;
    }
    /**
     * 
       
    * @Title: getBitmap 
       
    * @Description: TODO(得到网络图片) 
       
    * @param @param url 下载图片的url
    * @param @param isdecode 是否对图片按比例缩放，1是，0否
    * @param @return    设定文件 
       
    * @return Bitmap    返回类型 
       
    * @throws
     */
    private Bitmap getBitmap(String url,int isdecode) 
    {
        File f=fileCache.getFile(url);   
        //从sd卡获取      
        //Bitmap b = decodeFile(f,isdecode);
        Bitmap b = createBitmap(f,isdecode);
        if(b!=null&&!b.isRecycled())
            return b;     
        //从网络下载
        try {
            Bitmap bitmap=null;
            URL imageUrl = new URL(url);
            HttpURLConnection conn = (HttpURLConnection)imageUrl.openConnection();
            conn.setConnectTimeout(30000);
            conn.setReadTimeout(30000);
            if(conn.getResponseCode()==404)return null;
            InputStream is=conn.getInputStream();
            OutputStream os = new FileOutputStream(f);
            CopyStream(is, os);
            os.close();
            //bitmap = decodeFile(f,isdecode);
            bitmap = createBitmap(f,isdecode);
            return bitmap;
        } catch (Exception ex){
           ex.printStackTrace();
           return null;
        }
    }
    
    /**
     * 
       
     * @Title: getBitmap 
       
     * @Description: TODO(获取欢迎页闪屏图片) 
       
     * @param @param url 下载图片的url
     * @param @param width 屏幕宽度
     * @param @return    设定文件 
       
     * @return Bitmap    返回类型 
       
     * @throws
     */
    public Bitmap getWelcomeBitmap(final String url,int width) 
    {
    	final File f=fileCache.getFile(url);   
    	//从sd卡获取      
    	Bitmap b = createWelcomeBitmap(f,width);
    	if(b == null || b.isRecycled()){
    		new Thread(new Runnable() {
				
				public void run() {
					//从网络下载
			    	try {
			    		URL imageUrl = new URL(url);
			    		HttpURLConnection conn = (HttpURLConnection)imageUrl.openConnection();
			    		conn.setConnectTimeout(30000);
			    		conn.setReadTimeout(30000);
			    		conn.connect();
			    		InputStream is=conn.getInputStream();
			    		OutputStream os = new FileOutputStream(f);
			    		CopyStream(is, os);
			    		os.close();
			    	} catch (Exception ex){
			    		ex.printStackTrace();
			    	}
				}
			}).start();
    	}
    	
    	return b;
    }

	/**
	 * @Title: CopyStream
	 * @Description: TODO(读取图片字节流保存到本地)
	 * @param @param is
	 * @param @param os 设定文件
	 * @return void 返回类型
	 * @throws
	 */
    public static void CopyStream(InputStream is, OutputStream os)
    {
        final int buffer_size=1024;
        try
        {
            byte[] bytes=new byte[buffer_size];
            for(;;)
            {
              int count=is.read(bytes, 0, buffer_size);
              if(count==-1)
                  break;
              os.write(bytes, 0, count);
            }
        }
        catch(Exception ex){}
    }
    
    
    /**
	 * 
	 * @param urlString
	 * @return
	 */
	public static Bitmap createBitmap(File f,int isDecode){
//		Bitmap bitmap = null;
		try{
			
			 BitmapFactory.Options newOpts = new BitmapFactory.Options();  
		        //开始读入图片，此时把options.inJustDecodeBounds 设回true了  
		        newOpts.inJustDecodeBounds = true;  
		        Bitmap bitmap = BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);//此时返回bm为空  
		          
		        newOpts.inJustDecodeBounds = false;  
		        int w = newOpts.outWidth;  
		        int h = newOpts.outHeight;  
		        //现在主流手机比较多是800*480分辨率，所以高和宽我们设置为  
		        float hh = 800f;//这里设置高度为800f  
		        float ww = 480f;//这里设置宽度为480f  
		        //缩放比。由于是固定比例缩放，只用高或者宽其中一个数据进行计算即可  
		        int be = 1;//be=1表示不缩放  
		        if (w > h && w > ww) {//如果宽度大的话根据宽度固定大小缩放  
		            be = (int) (newOpts.outWidth / ww);  
		        } else if (w < h && h > hh) {//如果高度高的话根据宽度固定大小缩放  
		            be = (int) (newOpts.outHeight / hh);  
		        }  
		        if (be <= 0)  
		            be = 1;
		        newOpts.inSampleSize = be;//设置缩放比例  
		        //重新读入图片，注意此时已经把options.inJustDecodeBounds 设回false了  
		        if(f!=null){
		        bitmap =BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);  
		        }
		        return bitmap;//压缩好比例大小后再进行质量压缩  
		}catch(Exception e){
			Log.e(TAG, e.getMessage());
		}
		return null;
	}
	/**
	 * 
	 * @param width 屏幕宽度
	 * @return
	 */
	public static Bitmap createWelcomeBitmap(File f,int width){
		Bitmap bitmap = null;
		try{
			BitmapFactory.Options opts = new BitmapFactory.Options();
			opts.inJustDecodeBounds = false;
			opts.inSampleSize = computeWelcomeSampleSize(width);
			bitmap = BitmapFactory.decodeStream(new FileInputStream(f), null, opts);
		}catch(Exception e){
			Log.e(TAG, e.getMessage());
		}
		return bitmap;
	}
	
	/**
	 * 计算欢迎页图片压缩比例
	 * @param width 屏幕宽度
	 * @return
	 */
	private static int computeWelcomeSampleSize(int width){
		int sampleSize = 4;
		if(width >= 720){
			sampleSize = 1;
		}else if(width >= 480){
			sampleSize = 2;
		}
		return sampleSize;
	}
    
	/**
	 * 
	 * @param options
	 * @param minSideLength
	 * @param maxNumOfPixels
	 * @return
	 */
	public static int computeSampleSize(BitmapFactory.Options options,
			int minSideLength, int maxNumOfPixels) {
		/*if(maxNumOfPixels == 0){
			return 1;
		}
		int initialSize = computeInitialSampleSize(options, minSideLength,
				maxNumOfPixels);

		int roundedSize = 1;

		roundedSize = (int)Math.ceil(Math.sqrt(initialSize));*/

		return 1;
	}
	
	/**
	 * 
	 * @param options
	 * @param minSideLength
	 * @param maxNumOfPixels
	 * @return
	 */
	private static int computeInitialSampleSize(BitmapFactory.Options options,
			int minSideLength, int maxNumOfPixels) {
		double w = options.outWidth;
		double h = options.outHeight;

		int lowerBound = (maxNumOfPixels == -1) ? 1 : (int) Math.ceil(Math
				.sqrt(w * h / maxNumOfPixels));
		int upperBound = (minSideLength == -1) ? Constant.HD_PIC_WIDTH_POSTLIST : (int) Math.min(
				Math.floor(w / minSideLength), Math.floor(h / minSideLength));
		
		if (upperBound < lowerBound) {
			// return the larger one when there is no overlapping zone.
			return lowerBound;
		}

		if ((maxNumOfPixels == -1) && (minSideLength == -1)) {
			return 1;
		} else if (minSideLength == -1) {
			return lowerBound;
		} else {
			return upperBound;
		}
	}
	
    /**
     * 解码图片，  
     * f 为图片文件
     * isDecode  1为对图片缩放     
     * @throws oom
     */
    //解码图片，isDecode=1为对图片缩放
    public Bitmap decodeFile(File f,int isDecode){
        try {
        	if(!f.exists())return null;
        	BitmapFactory.Options newOpts = new BitmapFactory.Options();  
	        //开始读入图片，此时把options.inJustDecodeBounds 设回true了  
	        newOpts.inJustDecodeBounds = true;  
	        Bitmap bitmap = BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);//此时返回bm为空  
	          
	        newOpts.inJustDecodeBounds = false;  
	        int w = newOpts.outWidth;  
	        int h = newOpts.outHeight;  
	        //现在主流手机比较多是800*480分辨率，所以高和宽我们设置为  
	        float hh = 800f;//这里设置高度为800f  
	        float ww = 480f;//这里设置宽度为480f  
	        //缩放比。由于是固定比例缩放，只用高或者宽其中一个数据进行计算即可  
	        int be = 1;//be=1表示不缩放  
	        if (w > h && w > ww) {//如果宽度大的话根据宽度固定大小缩放  
	            be = (int) (newOpts.outWidth / ww);  
	        } else if (w < h && h > hh) {//如果高度高的话根据宽度固定大小缩放  
	            be = (int) (newOpts.outHeight / hh);  
	        }  
	        if (be <= 0)  
	            be = 1;  
	        newOpts.inSampleSize = be;//设置缩放比例  
	        //重新读入图片，注意此时已经把options.inJustDecodeBounds 设回false了  
	        bitmap =BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);  
	        return bitmap;//压缩好比例大小后再进行质量压缩  
        } catch (FileNotFoundException e) {
        	e.printStackTrace();
        } catch (OutOfMemoryError e){
        	e.printStackTrace();
        }
        return null;
    }
    
    /**
	 * 保存压缩后图片到临时文件夹
	 * @param path
	 * @param picName
	 * @param bm
	 */
	public void saveBitmap(String path,String picName,Bitmap bm) {
		File f = new File(path, picName);
		if (f.exists()) {
			f.delete();
		}
		try {
//			ByteArrayOutputStream baos = new ByteArrayOutputStream();
//			// 质量压缩方法，这里100表示不压缩，把压缩后的数据存放到baos中
//			bm.compress(Bitmap.CompressFormat.JPEG, 100, baos);
//			int options = 100;
//			// 循环判断如果压缩后图片是否大于100kb,大于继续压缩
//			while (baos.toByteArray().length / 1024 > 100) { 
//				// 每次都减少10
//				options -= 10;
//				// 重置baos即清空baos
//				baos.reset();
//				// 这里压缩options%，把压缩后的数据存放到baos中
//				bm.compress(Bitmap.CompressFormat.JPEG, options, baos);
//			}
			
			FileOutputStream out = new FileOutputStream(f);
			bm.compress(Bitmap.CompressFormat.JPEG, Constant.IMG_QUALITY, out);
			out.flush();
			out.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
    
	
	/**
	 * 删除临时文件
	 */
	public void delTemp(String path) {
		File file = new File(path);
		if (file.exists()) {
			file.delete();
		}
	}
	
    //线程任务队列
    private class PhotoToLoad
    {
        public String url;
        public ImageView imageView;
        public int position;
        public int isDecode;
        public float radius;
        public int defId;
        public PhotoToLoad(String u, ImageView i,int isdecode,int p,float radius,int defId){
            url=u; 
            imageView=i;
            this.position=p;
            this.isDecode=isdecode;
            this.radius=radius;
            this.defId=defId;
        }
    }
    
    PhotosQueue photosQueue=new PhotosQueue();
    
    public void stopThread()
    {
        photoLoaderThread.interrupt();
    }
    
    //存储图片列表下载
    class PhotosQueue
    {
        private Stack<PhotoToLoad> photosToLoad=new Stack<PhotoToLoad>();
        
        //删除的所有实例ImageView
        public void Clean(ImageView image)
        {
        	if(photosToLoad.size()>0){
        		try {//确保图片不会出现错乱现象
        			for(int j=0 ;j<photosToLoad.size();){
        				if(j<photosToLoad.size()){
        				if(photosToLoad.get(j).imageView==image)
        					photosToLoad.remove(j);
        				else
        					++j;
        				}
        			}				
				} catch (Exception e) {
					// TODO: handle exception
					e.printStackTrace();
				}
        	}
        }
    }
    /** 
     * 添加Bitmap到内存缓存 
     * @param key 
     * @param bitmap 
     */  
    public void addBitmapToMemoryCache(String key, Bitmap bitmap) {    
        if (getBitmapFromMemCache(key) == null && bitmap != null) {    
        	memoryCache.put(key, bitmap);    
        }    
    }
    /** 
     * 从内存缓存中获取一个Bitmap 
     * @param key 
     * @return 
     */  
    public Bitmap getBitmapFromMemCache(String key) {    
        return memoryCache.get(key);    
    }
    
    class PhotosLoader extends Thread {
        @SuppressLint("NewApi")
		public void run() {
            try {
                while(true)
                {
                    //线程等待直到有任何图片加载在队列中
                    if(photosQueue.photosToLoad.size()==0)
                        synchronized(photosQueue.photosToLoad){
                            photosQueue.photosToLoad.wait();
                        }
                    if(photosQueue.photosToLoad.size()!=0)
                    {
                        PhotoToLoad photoToLoad;
                        synchronized(photosQueue.photosToLoad){
                            photoToLoad=photosQueue.photosToLoad.pop();
                        }
                        final Bitmap bmp=getBitmap(photoToLoad.url,photoToLoad.isDecode);
                        if(bmp != null){
                        	if(photoToLoad.radius<=0){
                            	//显示图片，并存入位图到集合
//                            	memoryCache.put(photoToLoad.url, bmp);
                            	addBitmapToMemoryCache(photoToLoad.url, bmp); 
                            }
                            String tag=imageViews.get(photoToLoad.imageView);
                            if(tag!=null && tag.equals(photoToLoad.url)){
                            	BitmapDisplayer bd=new BitmapDisplayer(bmp, photoToLoad.imageView,photoToLoad.radius,photoToLoad.url,photoToLoad.position,photoToLoad.defId);
                            	Activity a=(Activity)photoToLoad.imageView.getContext();
                            	a.runOnUiThread(bd);
                            }   
                        }
                       
                    }
                    if(Thread.interrupted())
                        break;
                }
            } catch (InterruptedException e) {
                //允许线程退出
            	e.printStackTrace();
            }
        }
    }
    
    PhotosLoader photoLoaderThread=new PhotosLoader();
    
    //用来显示位图在UI线程
    class BitmapDisplayer implements Runnable
    {
        Bitmap bitmap;
        ImageView imageView;
        float radius;
        String photourl;
        int position;
        int defId;
        public BitmapDisplayer(Bitmap b, ImageView i,float rad,String url,int pos,int id){
        	bitmap=b;imageView=i;radius=rad;photourl=url;position=pos;defId=id;
        }
        public void run()
        {
            if(bitmap!=null){
                if(radius>0){
                	//显示圆角图片，并存入位图到集合
                	final Bitmap roundBitmap=roundCorners(bitmap, radius);  
                	imageView.setImageBitmap(roundBitmap);
                }else{
                	 imageView.setImageBitmap(bitmap);
            
                }
            }else
                imageView.setImageResource(defId);
        }
    }
    /**
     * 同时清空内存和本地sd卡的缓存                  
     * @throws
     */
    @SuppressLint("NewApi")
	public void clearCache() {
        fileCache.clear();
    }

}
