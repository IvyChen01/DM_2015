package com.transsion.infinix.xclub.util;



import android.content.Context;

public class DisplayUtil {
	/**
	 * ��pxֵת��Ϊdip��dpֵ����֤�ߴ��С����
	 * 
	 * @param pxValue
	 * @param scale
	 *            ��DisplayMetrics��������density��
	 * @return
	 */
	public static int px2dip(Context context, float pxValue) {
		final float scale = context.getResources().getDisplayMetrics().density;
		return (int) (pxValue / scale + 0.5f);
	}

	/**
	 * ��dip��dpֵת��Ϊpxֵ����֤�ߴ��С����
	 * 
	 * @param dipValue
	 * @param scale
	 *            ��DisplayMetrics��������density��
	 * @return
	 */
	public static int dip2px(Context context, float dipValue) {
		final float scale = context.getResources().getDisplayMetrics().density;
		return (int) (dipValue * scale + 0.5f);
	}

	/**
	 * ��pxֵת��Ϊspֵ����֤���ִ�С����
	 * 
	 * @param pxValue
	 * @param fontScale
	 *            ��DisplayMetrics��������scaledDensity��
	 * @return
	 */
	public static int px2sp(Context context, float pxValue) {
		final float fontScale = context.getResources().getDisplayMetrics().scaledDensity;
		return (int) (pxValue / fontScale + 0.5f);
	}

	/**
	 * ��spֵת��Ϊpxֵ����֤���ִ�С����
	 * 
	 * @param spValue
	 * @param fontScale
	 *            ��DisplayMetrics��������scaledDensity��
	 * @return
	 */
	public static int sp2px(Context context, float spValue) {
		final float fontScale = context.getResources().getDisplayMetrics().scaledDensity;
		return (int) (spValue * fontScale + 0.5f);
	}
	/** sp2dp 
	  TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_SP, value, metric);
	  applyDimension����ԭ�����£�
	  float android.util.TypedValue.applyDimension(int unit, float value, DisplayMetrics metric)
	       ����ͨ��һ�·�����ȡmetric
	  DisplayMetrics metric = new DisplayMetrics();	          
	  getWindowManager().getDefaultDisplay().getMetrics(metric);
	  dp2sp
	  getResources().getDimensionPixelSize(R.dimen.min_header_height);
	  *
	  */
}
