package com.trassion.newstop.application;

import android.content.Context;

/**
 * 获取当前Context
 * @author chenqian
 *
 */
public class CurrentActivityContext {

	public static CurrentActivityContext instance;

	public static CurrentActivityContext getInstance() {
		if (instance == null) {
			instance = new CurrentActivityContext();
		}
		return instance;
	}

	Context currentContext = null;

	public Context getCurrentContext() {
		return currentContext;
	}

	public void setCurrentContext(Context currentContext) {
		this.currentContext = currentContext;
	}

}
