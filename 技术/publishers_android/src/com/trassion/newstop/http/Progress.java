package com.trassion.newstop.http;


import com.trassion.newstop.http.parse.HttpTransAgent;

import android.app.ProgressDialog;
import android.content.Context;

public class Progress extends ProgressDialog {

	private HttpTransAgent handle;
	private boolean auto = true;

	public Progress(Context context) {
		super(context);
		this.setCanceledOnTouchOutside(false);
	}

	public Progress(Context context, HttpTransAgent handle) {
		super(context);
		this.handle = handle;
		this.setCanceledOnTouchOutside(false);
	}

	public Progress(Context context, HttpTransAgent handle, int theme) {
		super(context, theme);
		this.handle = handle;
		this.setCanceledOnTouchOutside(false);
	}

	public Progress(Context context, int theme) {
		super(context, theme);
		this.setCanceledOnTouchOutside(false);
	}

	public void progressCancel(boolean auto) {
		this.auto = auto;
		super.cancel();
	}

	public void setHandle(HttpTransAgent handle) {
		this.handle = handle;
	}

	/**
	 * �ߴ˷���˵��progress��ͨ�����ؼ������õģ� ��ʱ��Ҫ�ж�http�����Ƿ���Ҫ�Լ�ȡ������ʱ���ص����ݶ���
	 */
	@Override
	public void cancel() {
		if (auto) {
			handle.cancel(auto);
		}
		// ȡ������
		super.cancel();
	}

}
