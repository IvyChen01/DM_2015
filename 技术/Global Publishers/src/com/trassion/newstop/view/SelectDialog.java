package com.trassion.newstop.view;

import java.util.List;

import com.trassion.newstop.activity.R;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;


/**
 * 创建时间：2016-1-20 上午11:47:49 项目名称：NewsTop
 * 
 * @author chen
 * @version 1.0
 * @since 文件名称：SelectPictureDialog.java 类说明：
 */
public class SelectDialog {

	private Context context;
	private String pid;
	private Dialog dialog = null;
	private Dialog settingTypeDialog;
	private LayoutInflater inflater;

	public String getPid() {
		return pid;
	}

	public void setPid(String pid) {
		this.pid = pid;
	}

	public interface OnAlertSelectId {
		void onClick(int position);
	}

	public SelectDialog(Context context) {
		this.context = context;
		inflater=LayoutInflater.from(context);
	}

	public interface OnReplyClickListener {
		void onSaveClickListener(String id, String message);
	}

	/**
	 * @Title: CreateDialog
	 * @Description: TODO(选择自拍或图库)
	 * @param @return 设定文件
	 * @return Dialog 返回类型
	 * @param flag 1: 选择头像，2:修改头像
	 * @throws
	 */
	public Dialog choosePicDialog() {
		String[] items = {context.getString(R.string.select_pic),
				  context.getString(R.string.take_camera)};
		String title = context.getString(R.string.select);
		AlertDialog.Builder builder = new AlertDialog.Builder(context)
				.setTitle(title).setItems(items,
						(DialogInterface.OnClickListener) context);
		return builder.create();
	}
	/**
	 * 清除缓存提示
	 * 
	 * @Title: SaveTextDialog
	 * @Description: TODO(保存编辑状态)
	 * @param @return 设定文件
	 * @return Dialog 返回类型
	 */
	public Dialog ClearCacheDialog() {
		AlertDialog.Builder builder = new AlertDialog.Builder(context);
		builder.setTitle(context.getString(R.string.clear_cache_title))
				.setMessage(context.getString(R.string.clear_cache_message))
				.setPositiveButton(context.getString(R.string.news_blog_yes),
						(DialogInterface.OnClickListener) context)
				.setNegativeButton(
						context.getString(R.string.news_blog_cancel),
						(DialogInterface.OnClickListener) context);
		return builder.create();
	}
	/**
	 * 版本更新提示
	 * 
	 * @Title: SaveTextDialog
	 * @Description: TODO(保存编辑状态)
	 * @param @return 设定文件
	 * @return Dialog 返回类型
	 */
	public Dialog VersionChangeDialog() {
		AlertDialog.Builder builder = new AlertDialog.Builder(context);
		builder.setTitle(context.getString(R.string.version_change_title))
				.setMessage(context.getString(R.string.version_change_message))
				.setPositiveButton(context.getString(R.string.version_change_upgrade),
						(DialogInterface.OnClickListener) context)
				.setNegativeButton(
						context.getString(R.string.news_blog_cancel),
						(DialogInterface.OnClickListener) context);
		return builder.create();
	}
	public void chooseShareDialog() {
	    settingTypeDialog = new Dialog(context, R.style.ActionSheet01);
		LinearLayout layout = (LinearLayout) inflater.inflate(R.layout.share_palt_dialog, null);
		
		
		Window w = settingTypeDialog.getWindow();
		WindowManager.LayoutParams lp = w.getAttributes();

		final int cFullFillWidth = 10000;
		layout.setMinimumWidth(cFullFillWidth);
		/*
		 * lp.x = 0; final int cMakeBottom = -1000; lp.y = cMakeBottom;
		 */
		lp.gravity = Gravity.BOTTOM;
		settingTypeDialog.onWindowAttributesChanged(lp);
//		dlg.setCanceledOnTouchOutside(false);

		settingTypeDialog.setContentView(layout);
		settingTypeDialog.show();
	
}

}
