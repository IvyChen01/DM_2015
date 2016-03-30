package com.trassion.newstop.view;

import android.content.Context;
import android.util.AttributeSet;
import android.view.View;
import android.widget.ScrollView;

/**   
* 去掉了滑到边界出现阴影
*
* 详细描述   
* @author   chen  
*/
public class XwScrollView extends ScrollView {
	
    public interface OnScrollChangedListener {
        void onScrollChanged(ScrollView who, int l, int t, int oldl, int oldt);
    }

    private OnScrollChangedListener mOnScrollChangedListener;

    public XwScrollView(Context context) {
        super(context);
        this.setOverScrollMode(View.OVER_SCROLL_NEVER);
    }

    public XwScrollView(Context context, AttributeSet attrs) {
        super(context, attrs);
        this.setOverScrollMode(View.OVER_SCROLL_NEVER);
    }

    public XwScrollView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
        this.setOverScrollMode(View.OVER_SCROLL_NEVER);
    }

    @Override
    protected void onScrollChanged(int l, int t, int oldl, int oldt) {
        super.onScrollChanged(l, t, oldl, oldt);
        if (mOnScrollChangedListener != null) {
            mOnScrollChangedListener.onScrollChanged(this, l, t, oldl, oldt);
        }
    }

    public void setOnScrollChangedListener(OnScrollChangedListener listener) {
        mOnScrollChangedListener = listener;
    }

}
