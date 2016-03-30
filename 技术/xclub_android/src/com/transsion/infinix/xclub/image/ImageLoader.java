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
* @Description: TODO(ͼƬ������)    
* @author chen  
* @date 2015-11-13 ����9:31:29
 */
@SuppressLint("UseSparseArrays")
public class ImageLoader {
    
    private static final String TAG = ImageLoader.class.getSimpleName();
    private static ImageLoader instance;
	public LruCache<String, Bitmap> memoryCache;
    public FileCache fileCache;
    private Map<ImageView, String> imageViews=Collections.synchronizedMap(new WeakHashMap<ImageView, String>());
    private float mRadius=50;//Ĭ��Բ�Ǵ�С
    @SuppressLint("NewApi")
	private ImageLoader(Context context){
        //ʹ����thead�����ȼ��������Ͳ���Ӱ�쵽�û����������
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
	 * �첽��ʾͼƬ
	 * @Title: DisplayImage
	 * @Description: TODO(��ʾͼƬ)
	 * @param @param url ͼƬ��ַ
	 * @param @param imageView
	 * @param @param isDecode �Ƿ񰴱���ѹ��ͼƬ
	 * @param @param mBusy
	 * @param @param position ͼƬbitmap��key,����ͼƬʱ�����key����
	 * @param @param radius Բ�Ǵ�С��0Ϊû��
	 * @param @param stub_id Ĭ��ͼƬ
	 * @return void ��������
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
     * ͨ����ǰ����urlɾ��ͼƬ
     * @param url
     */
    public void removeCacheImage(String url){
    	  fileCache.DeleteFile(url); 
    }
    public String getCachePath(String url){
    	return fileCache.getPath(url);
    }
    
    /**
     * ���������̼߳���ͼƬ 
     */
    private void queuePhoto(String url, ImageView imageView,int isDecode,int position,float radius,int defId)
    {
        //��ImageView���ܱ���������ͼ��֮ǰ�����Կ��ܻ���һЩ�ɵ�������С�������Ҫ�������ǡ� 
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
     * ͼƬԲ�Ǵ���   
     * source ԭʼλͼ
     * radius Ҫ��ʾ��Բ�Ǵ�С        
     * @throws oom
     */
    public static Bitmap roundCorners(Bitmap source, final float radius) {
    	int width = source.getWidth();
    	int height = source.getHeight();
    	//����Ԥת���ɵ�ͼƬ�Ŀ�Ⱥ͸߶�
        int newWidth = 100;
        int newHeight = 100; 
        //������λͼ
        Bitmap scaleBitmap;
        /*����ͷ��ͼƬ��С��һ�����Լ���ͷ���Ƚ�ͼƬ����Ϊ�����Σ�������Բ�Ǵ����ʱ����ܱ�֤ÿ��ͼƬԲ�Ǵ�Сһ��*/
        //���������ʣ��³ߴ��ԭʼ�ߴ�
        float scaleWidth = ((float) newWidth) / width;
        float scaleHeight = ((float) newHeight) / height;        	
        // ��������ͼƬ�õ�matrix����
        Matrix matrix = new Matrix();        	
        // ����ͼƬ����
        matrix.postScale(scaleWidth, scaleHeight);        	
        // �����µ�ͼƬ
        scaleBitmap = Bitmap.createBitmap(source, 0, 0,
        		width, height, matrix, true);
        width = newWidth;
        height = newHeight;
        source=scaleBitmap;  
        /*Բ�Ǵ������*/
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
       
    * @Description: TODO(�õ�����ͼƬ) 
       
    * @param @param url ����ͼƬ��url
    * @param @param isdecode �Ƿ��ͼƬ���������ţ�1�ǣ�0��
    * @param @return    �趨�ļ� 
       
    * @return Bitmap    �������� 
       
    * @throws
     */
    private Bitmap getBitmap(String url,int isdecode) 
    {
        File f=fileCache.getFile(url);   
        //��sd����ȡ      
        //Bitmap b = decodeFile(f,isdecode);
        Bitmap b = createBitmap(f,isdecode);
        if(b!=null&&!b.isRecycled())
            return b;     
        //����������
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
       
     * @Description: TODO(��ȡ��ӭҳ����ͼƬ) 
       
     * @param @param url ����ͼƬ��url
     * @param @param width ��Ļ���
     * @param @return    �趨�ļ� 
       
     * @return Bitmap    �������� 
       
     * @throws
     */
    public Bitmap getWelcomeBitmap(final String url,int width) 
    {
    	final File f=fileCache.getFile(url);   
    	//��sd����ȡ      
    	Bitmap b = createWelcomeBitmap(f,width);
    	if(b == null || b.isRecycled()){
    		new Thread(new Runnable() {
				
				public void run() {
					//����������
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
	 * @Description: TODO(��ȡͼƬ�ֽ������浽����)
	 * @param @param is
	 * @param @param os �趨�ļ�
	 * @return void ��������
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
		        //��ʼ����ͼƬ����ʱ��options.inJustDecodeBounds ���true��  
		        newOpts.inJustDecodeBounds = true;  
		        Bitmap bitmap = BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);//��ʱ����bmΪ��  
		          
		        newOpts.inJustDecodeBounds = false;  
		        int w = newOpts.outWidth;  
		        int h = newOpts.outHeight;  
		        //���������ֻ��Ƚ϶���800*480�ֱ��ʣ����ԸߺͿ���������Ϊ  
		        float hh = 800f;//�������ø߶�Ϊ800f  
		        float ww = 480f;//�������ÿ��Ϊ480f  
		        //���űȡ������ǹ̶��������ţ�ֻ�ø߻��߿�����һ�����ݽ��м��㼴��  
		        int be = 1;//be=1��ʾ������  
		        if (w > h && w > ww) {//�����ȴ�Ļ����ݿ�ȹ̶���С����  
		            be = (int) (newOpts.outWidth / ww);  
		        } else if (w < h && h > hh) {//����߶ȸߵĻ����ݿ�ȹ̶���С����  
		            be = (int) (newOpts.outHeight / hh);  
		        }  
		        if (be <= 0)  
		            be = 1;
		        newOpts.inSampleSize = be;//�������ű���  
		        //���¶���ͼƬ��ע���ʱ�Ѿ���options.inJustDecodeBounds ���false��  
		        if(f!=null){
		        bitmap =BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);  
		        }
		        return bitmap;//ѹ���ñ�����С���ٽ�������ѹ��  
		}catch(Exception e){
			Log.e(TAG, e.getMessage());
		}
		return null;
	}
	/**
	 * 
	 * @param width ��Ļ���
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
	 * ���㻶ӭҳͼƬѹ������
	 * @param width ��Ļ���
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
     * ����ͼƬ��  
     * f ΪͼƬ�ļ�
     * isDecode  1Ϊ��ͼƬ����     
     * @throws oom
     */
    //����ͼƬ��isDecode=1Ϊ��ͼƬ����
    public Bitmap decodeFile(File f,int isDecode){
        try {
        	if(!f.exists())return null;
        	BitmapFactory.Options newOpts = new BitmapFactory.Options();  
	        //��ʼ����ͼƬ����ʱ��options.inJustDecodeBounds ���true��  
	        newOpts.inJustDecodeBounds = true;  
	        Bitmap bitmap = BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);//��ʱ����bmΪ��  
	          
	        newOpts.inJustDecodeBounds = false;  
	        int w = newOpts.outWidth;  
	        int h = newOpts.outHeight;  
	        //���������ֻ��Ƚ϶���800*480�ֱ��ʣ����ԸߺͿ���������Ϊ  
	        float hh = 800f;//�������ø߶�Ϊ800f  
	        float ww = 480f;//�������ÿ��Ϊ480f  
	        //���űȡ������ǹ̶��������ţ�ֻ�ø߻��߿�����һ�����ݽ��м��㼴��  
	        int be = 1;//be=1��ʾ������  
	        if (w > h && w > ww) {//�����ȴ�Ļ����ݿ�ȹ̶���С����  
	            be = (int) (newOpts.outWidth / ww);  
	        } else if (w < h && h > hh) {//����߶ȸߵĻ����ݿ�ȹ̶���С����  
	            be = (int) (newOpts.outHeight / hh);  
	        }  
	        if (be <= 0)  
	            be = 1;  
	        newOpts.inSampleSize = be;//�������ű���  
	        //���¶���ͼƬ��ע���ʱ�Ѿ���options.inJustDecodeBounds ���false��  
	        bitmap =BitmapFactory.decodeStream(new FileInputStream(f), null, newOpts);  
	        return bitmap;//ѹ���ñ�����С���ٽ�������ѹ��  
        } catch (FileNotFoundException e) {
        	e.printStackTrace();
        } catch (OutOfMemoryError e){
        	e.printStackTrace();
        }
        return null;
    }
    
    /**
	 * ����ѹ����ͼƬ����ʱ�ļ���
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
//			// ����ѹ������������100��ʾ��ѹ������ѹ��������ݴ�ŵ�baos��
//			bm.compress(Bitmap.CompressFormat.JPEG, 100, baos);
//			int options = 100;
//			// ѭ���ж����ѹ����ͼƬ�Ƿ����100kb,���ڼ���ѹ��
//			while (baos.toByteArray().length / 1024 > 100) { 
//				// ÿ�ζ�����10
//				options -= 10;
//				// ����baos�����baos
//				baos.reset();
//				// ����ѹ��options%����ѹ��������ݴ�ŵ�baos��
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
	 * ɾ����ʱ�ļ�
	 */
	public void delTemp(String path) {
		File file = new File(path);
		if (file.exists()) {
			file.delete();
		}
	}
	
    //�߳��������
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
    
    //�洢ͼƬ�б�����
    class PhotosQueue
    {
        private Stack<PhotoToLoad> photosToLoad=new Stack<PhotoToLoad>();
        
        //ɾ��������ʵ��ImageView
        public void Clean(ImageView image)
        {
        	if(photosToLoad.size()>0){
        		try {//ȷ��ͼƬ������ִ�������
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
     * ���Bitmap���ڴ滺�� 
     * @param key 
     * @param bitmap 
     */  
    public void addBitmapToMemoryCache(String key, Bitmap bitmap) {    
        if (getBitmapFromMemCache(key) == null && bitmap != null) {    
        	memoryCache.put(key, bitmap);    
        }    
    }
    /** 
     * ���ڴ滺���л�ȡһ��Bitmap 
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
                    //�̵߳ȴ�ֱ�����κ�ͼƬ�����ڶ�����
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
                            	//��ʾͼƬ��������λͼ������
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
                //�����߳��˳�
            	e.printStackTrace();
            }
        }
    }
    
    PhotosLoader photoLoaderThread=new PhotosLoader();
    
    //������ʾλͼ��UI�߳�
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
                	//��ʾԲ��ͼƬ��������λͼ������
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
     * ͬʱ����ڴ�ͱ���sd���Ļ���                  
     * @throws
     */
    @SuppressLint("NewApi")
	public void clearCache() {
        fileCache.clear();
    }

}
