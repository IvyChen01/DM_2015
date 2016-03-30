package com.trassion.newstop.view.PullToRefresh;


import android.os.Handler;
import android.os.Message;
import android.util.Log;

/**
 * Created by Administrator on 2015/6/8.
 */
public class OrderRefreshListener implements PullToRefreshLayout.OnRefreshListener{
	
	public void onRefresh(final PullToRefreshLayout pullToRefreshLayout) {
		// ����ˢ�²���
				new Handler() {
					@Override
					public void handleMessage(Message msg) {
						// ǧ������˸��߿ؼ�ˢ�������Ŷ��
						pullToRefreshLayout.refreshFinish(PullToRefreshLayout.SUCCEED);
						Log.i("INFO","onRefresh");
					}
				}.sendEmptyMessageDelayed(0, 5000);
			}

			public void onLoadMore(final PullToRefreshLayout pullToRefreshLayout) {
				// ���ز���
				new Handler() {
					@Override
					public void handleMessage(Message msg) {
						// ǧ������˸��߿ؼ����������Ŷ��
						pullToRefreshLayout.loadmoreFinish(PullToRefreshLayout.SUCCEED);
						Log.i("INFO","onLoadMore");
					}
				}.sendEmptyMessageDelayed(0, 5000);
			}
	
}
