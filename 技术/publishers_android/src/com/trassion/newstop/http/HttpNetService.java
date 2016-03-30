package com.trassion.newstop.http;


import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
/**
 * 联网入口
 * @author liuy
 */
public class HttpNetService {
	Object obj = new Object();
	private static HttpNetService netService;

	private List<HttpConnet> netActVec;

	private ExecutorService pool;

	private HttpNetService() {
		pool = Executors.newFixedThreadPool(5);
		netActVec = new ArrayList<HttpConnet>();
	}

	public static HttpNetService getInstance() {
		if (netService == null) {
			netService = new HttpNetService();
		}
		return netService;
	}

	public void netClose() {

		if (netActVec != null) {
			netActVec.clear();
		}
	}

	public void shutDownPool() {
		if (pool != null && !pool.isShutdown()) {
			pool.shutdown();
		}
	}

	public void removeNet(Request request, boolean iscancel) {
		for (HttpConnet con : netActVec) {
			if (con.getMrequest().equals(request)) {
				if (iscancel && con.getDefaultHttpClient() != null && iscancel) {
					con.getDefaultHttpClient().getConnectionManager()
							.shutdown();
				}
				netActVec.remove(con);
				break;
			}
		}

	}
	/**
	 * 启动网络连接线程
	 * @param request
	 */
	public void sendRequest(final Request request) {
		if (request != null) {
			if (pool.isShutdown()) {
				pool = Executors.newFixedThreadPool(5);
			}
			HttpConnet currentNetAct = new HttpConnet(request);
			netActVec.add(currentNetAct);
			pool.execute(new task(currentNetAct));
		}
	}
	/**
	 * 网络链接线程 
	 * @author liuy
	 *
	 */
	class task extends Thread {

		HttpConnet connet;

		public task(HttpConnet connet) {
			super();
			this.connet = connet;
		}

		@Override
		public void run() {
//			synchronized (obj) {
				if (netActVec.contains(connet)) {
					connet.netWork();
				}
				super.run();
//			}
		}

	}
}
