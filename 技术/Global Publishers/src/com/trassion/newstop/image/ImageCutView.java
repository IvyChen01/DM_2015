package com.trassion.newstop.image;



import java.io.File;
import java.io.IOException;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Matrix;
import android.graphics.Paint;
import android.graphics.PointF;
import android.graphics.Rect;
import android.graphics.RectF;
import android.graphics.Region.Op;
import android.util.AttributeSet;
import android.util.FloatMath;
import android.view.MotionEvent;
import android.view.SurfaceHolder;
import android.view.SurfaceHolder.Callback;
import android.view.SurfaceView;


public class ImageCutView extends SurfaceView implements Callback {

	private SurfaceHolder holder;

	public ImageCutView(Context context) {
		super(context);
		init();
	}

	public ImageCutView(Context context, AttributeSet attrs) {
		super(context, attrs);
		init();
	}

	public ImageCutView(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
		init();
	}

	private Paint paint;

	private void init() {

		holder = getHolder();
		holder.addCallback(this);

		paint = new Paint();
		paint.setColor(Color.BLACK);
		paint.setAntiAlias(true);
	}

	public void surfaceChanged(SurfaceHolder holder, int format, int width,
			int height) {

		this.width = width;
		this.height = height;

	}

	private boolean startDrag = false;
	private float lastX;
	private float lastY;

	private void scaleToFitCenter() {

		float offsetX = (getWidth() - bitmap.getWidth()) / 2;
		
		float offsetY = (getHeight() - bitmap.getHeight()) / 2;
		
		matrix.postTranslate(offsetX, offsetY);
		

	}

	public boolean onTouchEvent(MotionEvent event) {

		int count = event.getPointerCount();

		int action = event.getAction();

		float x = event.getX();

		float y = event.getY();

		if (count == 1) {

			switch (action) {

			case MotionEvent.ACTION_DOWN:

				if (!startDrag) {
					startDrag = true;
					lastX = x;
					lastY = y;

				}

				break;
			case MotionEvent.ACTION_MOVE:

				if (startDrag) {

					float offsetX = x - lastX;

					float offsetY = y - lastY;

					copyMatrix(matrix, oldMatrix);

					matrix.postTranslate(offsetX, offsetY);

					fitCenter();

					lastX = x;

					lastY = y;

				}

				break;

			case MotionEvent.ACTION_UP:

				startDrag = false;

				break;

			}

		} else {

			switch (action & MotionEvent.ACTION_MASK) {

			case MotionEvent.ACTION_DOWN:
			case MotionEvent.ACTION_POINTER_DOWN:

				oldDistance = distance(event);

				if (!startScale) {
					startScale = true;
					scaleMid = getScaleMid(event);
				}

				break;

			case MotionEvent.ACTION_UP:
			case MotionEvent.ACTION_POINTER_UP:

				startDrag = false;
				break;
			case MotionEvent.ACTION_MOVE:

				if (startScale) {

					float distance = distance(event);

					if (distance > 10f) {

						float scale = distance / oldDistance;

						copyMatrix(matrix, oldMatrix);

						matrix.postScale(scale, scale, scaleMid.x, scaleMid.y);

						fitCenter();

						oldDistance = distance;

					}
				}

				break;

			}

		}

		requestPaint();

		return true;
	}

	protected void onLayout(boolean changed, int left, int top, int right,
			int bottom) {

		super.onLayout(changed, left, top, right, bottom);

	}

	private float oldDistance = 1;

	private float distance(MotionEvent event) {

		float x = event.getX(0) - event.getX(1);

		float y = event.getY(0) - event.getY(1);

		return FloatMath.sqrt(x * x + y * y);

	}

	public PointF getScaleMid(MotionEvent event) {

		float x = event.getX(0) + event.getX(1);

		float y = event.getY(0) + event.getY(1);

		return new PointF(x / 2, y / 2);
	}

	private PointF scaleMid;

	private boolean startScale = false;

	private int width;
	private int height;
	private Matrix oldMatrix;

	private int borderColor = Color.argb(0xf0, 0x2d, 0x9f, 0xe0);
	private int maskColor = Color.argb(0x99, 0x00, 0x00, 0x00);

	private void requestPaint() {

		Canvas canvas = holder.lockCanvas();

		if (canvas != null) {
			paint.setColor(Color.BLACK);
			canvas.drawRect(new Rect(0, 0, width, height), paint);
			if (bitmap != null) {
				canvas.drawBitmap(bitmap, matrix, paint);
				canvas.save();
				canvas.clipRect(inRect, Op.XOR);
				paint.setColor(maskColor);
				canvas.drawRect(new Rect(0, 0, width, height), paint);
				paint.setColor(borderColor);
				canvas.drawRect(outRect, paint);
				canvas.restore();

			}

			holder.unlockCanvasAndPost(canvas);

		}

	}

	public void surfaceCreated(SurfaceHolder holder) {

		scaleToFitCenter();
		requestPaint();

	}

	public void surfaceDestroyed(SurfaceHolder holder) {

	}

	private Matrix matrix;
	private Bitmap bitmap;

	public void setBitmap(Bitmap bitmap) {

		this.matrix = new Matrix();

		this.oldMatrix = new Matrix();

		this.bitmap = bitmap;

	}

	@Override
	protected void onSizeChanged(int w, int h, int oldw, int oldh) {
		// TODO Auto-generated method stub

		super.onSizeChanged(w, h, oldw, oldh);

		if (w > 0 && h > 0) {

			this.width = w;

			this.height = h;

			this.outBoxSize = ((height < width) ? height : width) * 0.8f;
			this.inBoxSize = outBoxSize - 5;

			float outOffsetX = (getWidth() - outBoxSize) / 2;
			float outOffsetY = (getHeight() - outBoxSize) / 2;

			float inOffsetX = (getWidth() - inBoxSize) / 2;
			float inOffsetY = (getHeight() - inBoxSize) / 2;

			outRect = new RectF(outOffsetX, outOffsetY,
					outOffsetX + outBoxSize, outOffsetY + outBoxSize);

			inRect = new RectF(inOffsetX, inOffsetY, inOffsetX + inBoxSize,
					inOffsetY + inBoxSize);

	

		}

	}
 
	private float outBoxSize = 0;
	private float inBoxSize = 0;
	private RectF inRect;
	private RectF outRect;
	private boolean running = false;

	private float currentDegrees = 0f;

	public void rotate(boolean left) {

		if (currentDegrees % 90 == 0) {

			running = true;

			currentDegrees = 0f;

			long lastTime = System.currentTimeMillis();

			int dir = left ? 1 : -1;

			while (running) {

				long nowTime = System.currentTimeMillis();

				long delay = nowTime - lastTime;

				lastTime = nowTime;

				float d = (delay * 0.03f + delay * 0.4f) * dir;

				float nextDegrees = d + currentDegrees;

				if (left) {
					d = nextDegrees > 90 ? 90 - currentDegrees : d;
				} else {
					d = nextDegrees < -90 ? -90 - currentDegrees : d;
				}
				currentDegrees += d;

				matrix.postRotate(d, getWidth() / 2, getHeight() / 2);

				requestPaint();

				if (currentDegrees == 90 * dir) {
					running = false;
				}

				try {
					Thread.sleep(1);
				} catch (InterruptedException e) {
					e.printStackTrace();
				}

			}
		}

	}

	public float getCenterX() {

		return getWidth() / 2;
	}

	public float getCenterY() {

		return getHeight() / 2;
	}

	public void scaleToLarge() {

		copyMatrix(matrix, oldMatrix);
		matrix.postScale(1.05f, 1.05f, getCenterX(), getCenterY());
		requestPaint();
		fitCenter();
	}

	public void scaleToSmall() {
		copyMatrix(matrix, oldMatrix);
		matrix.postScale(0.95f, 0.95f, getCenterX(), getCenterY());
		requestPaint();
		fitCenter();

	}

	public String cutImage() {

		Bitmap bg = Bitmap.createBitmap(getWidth(), getHeight(),
				Config.ARGB_8888);
//	    Bitmap bg = Bitmap.createBitmap(DensityUtil.px2dip(MasterApplication.c, 120),
//	            DensityUtil.px2dip(MasterApplication.c, 120),
//                Config.ARGB_8888);
		
		Canvas canvas = new Canvas(bg);

		canvas.save();

		canvas.clipRect(inRect);

		canvas.drawBitmap(bitmap, matrix, paint);

		canvas.restore();
		// 控制图片大小云电话手机版必须570,否则图片会显示不完
//		Bitmap result = Bitmap.createBitmap((int) DensityUtil.px2dip(MasterApplication.c, 570),
//                (int) DensityUtil.px2dip(MasterApplication.c, 570), Config.ARGB_8888);
		Bitmap result = Bitmap.createBitmap((int) inRect.width(),
				(int) inRect.height(), Config.ARGB_8888);

		canvas = new Canvas(result);

		float offsetX = (getWidth() - inRect.width()) / 2;

		float offsetY = (getHeight() - inRect.height()) / 2;

		canvas.drawBitmap(bg, -offsetX, -offsetY, paint);

		String path = getContext().getCacheDir() + File.separator + "temp.png";

		try {
			BitmapProvider.saveImageToSDPNG(path, result, 100);
		} catch (IOException e) {

			e.printStackTrace();
		}

		return path;

	}

	private void copyMatrix(Matrix src, Matrix des) {
		des.set(src);
	}

	public RectF getOldBitmapRect() {

		float[] values = new float[9];

		oldMatrix.getValues(values);

		float tx = values[2];
		float ty = values[5];
		float sx = values[0];
		float sy = values[4];

		int w = bitmap.getWidth();

		int h = bitmap.getHeight();

		float left = tx;
		float top = ty;
		float right = left + (w * sx);
		float bottom = top + (h * sy);

		RectF rectF = new RectF(left, top, right, bottom);

		return rectF;
	}

	public RectF getBitmapRect() {

		if (true) {

			RectF rect = new RectF(0, 0, bitmap.getWidth(), bitmap.getHeight());

			matrix.mapRect(rect);

			return rect;
		}

		float[] values = new float[9];

		matrix.getValues(values);

		float tx = values[2];
		float ty = values[5];
		float sx = values[0];
		float sy = values[4];

		int w = bitmap.getWidth();

		int h = bitmap.getHeight();

		float left = tx;
		float top = ty;
		float right = left + (w * sx);
		float bottom = top + (h * sy);

		RectF rectF = new RectF(left, top, right, bottom);

		return rectF;
	}

	public void drawRect(RectF rect) {

		Canvas c = holder.lockCanvas();

		if (c != null) {

			Paint p = new Paint();
			p.setColor(Color.argb(0x99, 0x77, 0x77, 0x77));
			c.drawRect(rect, p);

			holder.unlockCanvasAndPost(c);
		}

	}

	private void fitCenter() {

	}
}
