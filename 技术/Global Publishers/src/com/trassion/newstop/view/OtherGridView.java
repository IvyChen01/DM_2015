package com.trassion.newstop.view;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.GridView;

public class OtherGridView extends GridView {

	public OtherGridView(Context context, AttributeSet attrs) {
		super(context, attrs);
		// TODO Auto-generated constructor stub
	}
     @Override
    public void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
    	 int expandSpec = MeasureSpec.makeMeasureSpec(Integer.MAX_VALUE >> 2,
 				MeasureSpec.AT_MOST);
    	super.onMeasure(widthMeasureSpec, expandSpec);
    }
}
