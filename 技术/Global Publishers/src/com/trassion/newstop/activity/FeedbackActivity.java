package com.trassion.newstop.activity;

import com.trassion.newstop.activity.view.CommonProblemMainLayout;
import com.trassion.newstop.activity.view.MineMainLayout;
import com.trassion.newstop.activity.view.SuggestionMainLayout;
import com.trassion.newstop.myinterface.IAppLayout;
import com.trassion.newstop.tool.PreferenceUtils;

import android.content.Intent;
import android.graphics.Typeface;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class FeedbackActivity extends BaseActivity implements OnClickListener{
	
	private RelativeLayout mySuggestion;
	private RelativeLayout mCommonProblem;
	
	private TextView tvMySuggestion;
	private TextView tvCommon;
	private ImageView oneTab;
	private ImageView twoTab;
	
	private TextView title;
	
	public final static int ACCOUNTREQUEST=1;
	
	CommonProblemMainLayout commonMainLayout;
    SuggestionMainLayout suggestionMainLayout;
    
    LinearLayout llManagerMainLayout;
    
    IAppLayout nowLayout;


	@Override
	public void setContentView() {
		// TODO Auto-generated method stub
        setContentView(R.layout.activity_feedback);
	}

	@Override
	public void initWidget() {
		title=(TextView)findViewById(R.id.title);
		llManagerMainLayout = (LinearLayout) findViewById(R.id.manager_main_layout);
		mySuggestion=(RelativeLayout)findViewById(R.id.mySuggestion);
		mCommonProblem=(RelativeLayout)findViewById(R.id.mCommonProblem);
		tvMySuggestion=(TextView)findViewById(R.id.tvMySuggestion);
		tvCommon=(TextView)findViewById(R.id.tvCommon);
		oneTab=(ImageView)findViewById(R.id.oneTab);
		twoTab=(ImageView)findViewById(R.id.twoTab);
		
		Typeface face = Typeface.createFromAsset(getAssets(),"fonts/Roboto-Medium.ttf");
		title.setTypeface(face);
		title.setText("Feedback");
		
		mySuggestion.setOnClickListener(this);
		mCommonProblem.setOnClickListener(this);

	}

	@Override
	public void initData() {
		initSuggestView();

	}
	private void initSuggestView() {
		
		// ��ͨ����¼Ĭ��װ�����ǵ���������
		nowLayout = new SuggestionMainLayout(this);
		// ɾ�����е��Ӳ���
		llManagerMainLayout.removeAllViews();
		// ����µĲ���
		llManagerMainLayout.addView((View) nowLayout);
	}

	@Override
	public void onBackPressed() {
			Intent intent = new Intent(getApplicationContext(), MainActivity.class);
			setResult(MainActivity.CHANNELRESULT, intent);
			finish();
			super.onBackPressed();
		overridePendingTransition(R.anim.slide_in_left, R.anim.slide_out_right);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.mySuggestion:
			setSuggestionView();
			
			break;
        case R.id.mCommonProblem:
        	setCommonProblemView();
			break;

		default:
			break;
		}
		
	}
	private void setSuggestionView() {
		
		tvMySuggestion.setTextColor(0xffcc0000);
		tvCommon.setTextColor(0xff333333);
		oneTab.setVisibility(View.VISIBLE);
		twoTab.setVisibility(View.GONE);
		
		   if (null != suggestionMainLayout) {
				nowLayout = suggestionMainLayout;
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);
				nowLayout.initData();
			} else {
				// ��ͨ����¼Ĭ��װ�����ǵ���������
				nowLayout = new SuggestionMainLayout(this);
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);

			}
	}
	private void setCommonProblemView() {
		
		 tvMySuggestion.setTextColor(0xff333333);
		 tvCommon.setTextColor(0xffcc0000);
		 oneTab.setVisibility(View.GONE);
		 twoTab.setVisibility(View.VISIBLE);
		 
		   if (null != commonMainLayout) {
				nowLayout = commonMainLayout;
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);
				nowLayout.initData();
			} else {
				// ��ͨ����¼Ĭ��װ�����ǵ���������
				nowLayout = new CommonProblemMainLayout(this);
				// ɾ�����е��Ӳ���
				llManagerMainLayout.removeAllViews();
				// ����µĲ���
				llManagerMainLayout.addView((View) nowLayout);

			}
	}
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    	switch (requestCode) {
    	case ACCOUNTREQUEST:
    		initSuggestView();
            break;
    	case MainActivity.ACCOUNTREQUEST:
    		initSuggestView();
    		break;
		default:
			break;
		}
    	super.onActivityResult(requestCode, resultCode, data);
    }
}
