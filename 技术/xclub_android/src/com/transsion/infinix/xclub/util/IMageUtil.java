package com.transsion.infinix.xclub.util;

import java.io.File;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.regex.PatternSyntaxException;

import android.app.Activity;
import android.app.AlertDialog;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.PorterDuff.Mode;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.graphics.RectF;



public class IMageUtil{

	/**
	 * ����ͼƬ
	 * 
	 * @param path
	 * @param w
	 * @param h
	 * @return
	 */
	public static Bitmap createPreviewBitmap(String path, int w, int h) {
		try {
			BitmapFactory.Options opts = new BitmapFactory.Options();
			opts.inJustDecodeBounds = true;
			BitmapFactory.decodeFile(path, opts);
			int srcWidth = opts.outWidth;
			int srcHeight = opts.outHeight;
			int destWidth = 0;
			int destHeight = 0;

			double ratio = 0.0;
			if (srcWidth < w || srcHeight < h) {
				ratio = 0.0;
				destWidth = srcWidth;
				destHeight = srcHeight;
			} else if (srcWidth < srcHeight) {
				ratio = (double) srcWidth / w;
				destWidth = w;
				destHeight = (int) (srcHeight / ratio);
			} else {
				ratio = (double) srcHeight / h;
				destHeight = h;
				destWidth = (int) (srcWidth / ratio);
			}
			BitmapFactory.Options newOpts = new BitmapFactory.Options();
			// ���ŵı����������Ǻ��Ѱ�׼���ı����������ŵģ�Ŀǰ��ֻ����ֻ��ͨ��inSampleSize���������ţ���ֵ�������ŵı�����SDK�н�����ֵ��2��ָ��ֵ
			newOpts.inSampleSize = (int) ratio + 1;
			// inJustDecodeBounds��Ϊfalse��ʾ��ͼƬ�����ڴ���
			newOpts.inJustDecodeBounds = false;
			// ���ô�С�����һ���ǲ�׼ȷ�ģ�����inSampleSize��Ϊ׼���������������ȴ��������
			newOpts.outHeight = destHeight;
			newOpts.outWidth = destWidth;
			// ��ȡ���ź�ͼƬ
			Bitmap tmpBitmap = BitmapFactory.decodeFile(path, newOpts);
			Bitmap b;
			if (ratio != 0.0) {
				b = ImageCrop(tmpBitmap);
			} else {
				b = Bitmap.createBitmap(tmpBitmap);
			}

			// tmpBitmap.recycle();
			return b;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
	/**
	 * �������β���ͼƬ
	 */

	public static Bitmap ImageCrop(Bitmap bitmap) {
		int w = bitmap.getWidth(); // �õ�ͼƬ�Ŀ���
		int h = bitmap.getHeight();
		int wh = w > h ? h : w;// ���к���ȡ������������߳�
		int retX = w > h ? (w - h) / 2 : 0;// ����ԭͼ��ȡ���������Ͻ�x����
		int retY = w > h ? 0 : (h - w) / 2;
		// ��������ǹؼ�
		return Bitmap.createBitmap(bitmap, retX, retY, wh, wh, null, false);

	}
	/**
	 * ����ͼƬ
	 * 
	 * @param path
	 * @param w
	 * @param h
	 * @return
	 */
	public static Bitmap zoomBitmap(String path, int w, int h) {
		try {
			BitmapFactory.Options opts = new BitmapFactory.Options();
			opts.inJustDecodeBounds = true;
			BitmapFactory.decodeFile(path, opts);
			int srcWidth = opts.outWidth;
			int srcHeight = opts.outHeight;
			int destWidth = 0;
			int destHeight = 0;

			double ratio = 0.0;
			if (srcWidth < w || srcHeight < h) {
				ratio = 0.0;
				destWidth = srcWidth;
				destHeight = srcHeight;
			} else if (srcWidth > srcHeight) {
				ratio = (double) srcWidth / w;
				destWidth = w;
				destHeight = (int) (srcHeight / ratio);
			} else {
				ratio = (double) srcHeight / h;
				destHeight = h;
				destWidth = (int) (srcWidth / ratio);
			}
			BitmapFactory.Options newOpts = new BitmapFactory.Options();
			// ���ŵı����������Ǻ��Ѱ�׼���ı����������ŵģ�Ŀǰ��ֻ����ֻ��ͨ��inSampleSize���������ţ���ֵ�������ŵı�����SDK�н�����ֵ��2��ָ��ֵ
			newOpts.inSampleSize = (int) ratio + 1;
			// inJustDecodeBounds��Ϊfalse��ʾ��ͼƬ�����ڴ���
			newOpts.inJustDecodeBounds = false;
			// ���ô�С�����һ���ǲ�׼ȷ�ģ�����inSampleSize��Ϊ׼���������������ȴ��������
			newOpts.outHeight = destHeight;
			newOpts.outWidth = destWidth;
			// ��ȡ���ź�ͼƬ
			return BitmapFactory.decodeFile(path, newOpts);
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}
	/**
	 * ת��ͼƬ��Բ��
	 * 
	 * @param bitmap
	 *            ����Bitmap����
	 * @return
	 */
	public static Bitmap toRoundBitmap(Bitmap bitmap) {
	int width = bitmap.getWidth();
	int height = bitmap.getHeight();
	float roundPx;
	float left, top, right, bottom, dst_left, dst_top, dst_right, dst_bottom;
	if (width <= height) {
	roundPx = width / 2;

	left = 0;
	top = 0;
	right = width;
	bottom = width;

	height = width;

	dst_left = 0;
	dst_top = 0;
	dst_right = width;
	dst_bottom = width;
	} else {
	roundPx = height / 2;

	float clip = (width - height) / 2;

	left = clip;
	right = width - clip;
	top = 0;
	bottom = height;
	width = height;

	dst_left = 0;
	dst_top = 0;
	dst_right = height;
	dst_bottom = height;
	}

	Bitmap output = Bitmap.createBitmap(width, height, Config.ARGB_8888);
	Canvas canvas = new Canvas(output);

	final Paint paint = new Paint();
	final Rect src = new Rect((int) left, (int) top, (int) right, (int) bottom);
	final Rect dst = new Rect((int) dst_left, (int) dst_top, (int) dst_right, (int) dst_bottom);
	final RectF rectF = new RectF(dst);

	paint.setAntiAlias(true);// ���û����޾��

	canvas.drawARGB(0, 0, 0, 0); // �������Canvas

	// ���������ַ�����Բ,drawRounRect��drawCircle
	canvas.drawRoundRect(rectF, roundPx, roundPx, paint);// ��Բ�Ǿ��Σ���һ������Ϊͼ����ʾ���򣬵ڶ��������͵����������ֱ���ˮƽԲ�ǰ뾶�ʹ�ֱԲ�ǰ뾶��
	// canvas.drawCircle(roundPx, roundPx, roundPx, paint);

	paint.setXfermode(new PorterDuffXfermode(Mode.SRC_IN));// ��������ͼƬ�ཻʱ��ģʽ,�ο�http://trylovecatch.iteye.com/blog/1189452
	canvas.drawBitmap(bitmap, src, dst, paint); // ��Mode.SRC_INģʽ�ϲ�bitmap���Ѿ�draw�˵�Circle

	return output;
	}
}
