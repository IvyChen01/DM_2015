package com.transsion.infinix.xclub.activity;

import java.io.File;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import com.transsion.infinix.xclub.MasterApplication;
import com.transsion.infinix.xclub.base.BaseActivity;
import com.transsion.infinix.xclub.bean.LoginInfo;
import com.transsion.infinix.xclub.constact.Constant;
import com.transsion.infinix.xclub.data.BaseDao;
import com.transsion.infinix.xclub.data.RequestListener;
import com.transsion.infinix.xclub.entity.BaseEntity;
import com.transsion.infinix.xclub.httputil.MyAsyncTask;
import com.transsion.infinix.xclub.image.ImageCutActivity;
import com.transsion.infinix.xclub.json.GetJsonData;
import com.transsion.infinix.xclub.util.DateTimeUtils;
import com.transsion.infinix.xclub.util.NetUtil;
import com.transsion.infinix.xclub.util.PreferenceUtils;
import com.transsion.infinix.xclub.util.ToastManager;
import com.trassion.infinix.xclub.R;

import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

public class UpdatePersonalInformationActivy extends BaseActivity implements OnClickListener,RequestListener<BaseEntity>{
	   private static final int REQUEST_IMG_CUT = 13;
	   private static final int REQUEST_CAMERA = 8;
	   private PopupWindow pop;
	   private LinearLayout tvback;
	   private RelativeLayout imghead;//头像
	   private LinearLayout  layout_name;//昵称
	   private ImageView imageview_touxiang;
	   private LinearLayout more_info_sex;//性别
	   private LinearLayout more_info_party;//生日
	   private LinearLayout signature;//个性签名
	   private TextView tvparty;
	   private Dialog dia;
		/** 0:女 1：男 */
	   private int sextype;
	   private ImageView imgsex;
	   /** 照相 地址 */
		private String mImageFilePath;
		private String path;
		
		
		private DatePicker DatePicker;
		private Calendar pickCal;
		private LinearLayout layout_country;
		private LinearLayout layout_job;
		private String values;
		private TextView tvCountry;
		private TextView tvWork;
		private CountryReceiver countryReceiver;
		private Button btComplete;
		private TextView tvName;
		private String uid;
		private String auth;
		private String saltkey;
		private BaseDao dao;
		private LoginInfo logininfo;
		private LinearLayout layout_phone;
		private TextView tvPhone;
		
		private int year=Calendar.YEAR;
		private int month=Calendar.MONTH;
		private int day=Calendar.DAY_OF_MONTH;
		private MasterApplication masterAppcation;
		private TextView tvEmail;
		private String phone;
		private String country;
		private String prefession;
		private String name;
		private static final SimpleDateFormat SDF= new SimpleDateFormat("yyyy-MM-dd");
		
	   @Override
	    protected void onCreate(Bundle savedInstanceState) {
	    	// TODO Auto-generated method stub
	    	super.onCreate(savedInstanceState);
	    	setContentView(R.layout.activity_more_myinfo);
	    	initView();
			setListener();
			setData();
			countryReceiver=new CountryReceiver();
			IntentFilter filter=new IntentFilter(Constant.ACTION_CHOOSECOUNTRY_SUCCESS);
			IntentFilter filterWork=new IntentFilter(Constant.ACTION_CHOOSEWORK_SUCCESS);
			IntentFilter filterName=new IntentFilter(Constant.ACTION_NICKNAME_SUCCESS);
			IntentFilter filterPhone=new IntentFilter(Constant.ACTION_PHONE_SUCCESS);
			registerReceiver(countryReceiver, filter);
			registerReceiver(countryReceiver, filterName);
			registerReceiver(countryReceiver, filterWork);
			registerReceiver(countryReceiver, filterPhone);
	    }
	@Override
	   protected void onDestroy() {
		// TODO Auto-generated method stub
		   unregisterReceiver(countryReceiver);
		 super.onDestroy();
	    }

		private void setListener() {
			tvback.setOnClickListener(this);
			layout_name.setOnClickListener(this);
			more_info_sex.setOnClickListener(this);
			more_info_party.setOnClickListener(this);
			layout_country.setOnClickListener(this);
			layout_job.setOnClickListener(this);
			btComplete.setOnClickListener(this);
			layout_phone.setOnClickListener(this);
		}

		private void initView() {
			tvback=(LinearLayout)findViewById(R.id.tvback);
			layout_name=(LinearLayout)findViewById(R.id.layout_name);
			tvName=(TextView)findViewById(R.id.tvName);
			btComplete=(Button)findViewById(R.id.btComplete);
			more_info_sex=(LinearLayout)findViewById(R.id.layout_sex);
			imgsex=(ImageView)findViewById(R.id.imgSex);
			more_info_party=(LinearLayout)findViewById(R.id.layout_party);
			layout_country=(LinearLayout)findViewById(R.id.layout_country);
			layout_phone=(LinearLayout)findViewById(R.id.layout_phone);
			layout_job=(LinearLayout)findViewById(R.id.layout_job);
			tvparty=(TextView)findViewById(R.id.tvParty);
			tvCountry=(TextView)findViewById(R.id.tvCountry);
			tvWork=(TextView)findViewById(R.id.tvWork);
			tvEmail=(TextView)findViewById(R.id.tvEmail);
			tvPhone=(TextView)findViewById(R.id.tvPhone);
			//实例化PopupWindow
			LayoutInflater inflater = LayoutInflater.from(this);
			View popView = inflater.inflate(R.layout.pop_set_head, null);
			
            masterAppcation=MasterApplication.getInstanse();		
			pickCal = Calendar.getInstance();
			
			
			
		}
		 private void setData() {
				uid=PreferenceUtils.getPrefInt(this,"uid", 0)+"";
				auth=PreferenceUtils.getPrefString(this, "auth", "");
			    saltkey=PreferenceUtils.getPrefString(this, "saltkey", "");
			    
			    String tid=PreferenceUtils.getPrefString(this, "UID", "");
			    String realname=PreferenceUtils.getPrefString(this, "Realname", "");
			    String currentYear=PreferenceUtils.getPrefString(this, "Year", "");
			    String currentMonth=PreferenceUtils.getPrefString(this, "Month", "");
			    String currentDay=PreferenceUtils.getPrefString(this, "Day", "");
			    String nationality=PreferenceUtils.getPrefString(this, "Nationality", "");
			    String occupation=PreferenceUtils.getPrefString(this, "Occupation", "");
			    String mobile=PreferenceUtils.getPrefString(this, "Mobile", "");
			    String gender=PreferenceUtils.getPrefString(this, "Gender", "");
			    String email=PreferenceUtils.getPrefString(this, "Email", "");
			    	
			    	if(tid.equals(uid)){
			    		tvName.setText(realname);
			    		tvCountry.setText(nationality);
			    		tvWork.setText(occupation);
			    		tvPhone.setText(mobile);
			    		tvEmail.setText(email);
			    		if(!TextUtils.isEmpty(currentYear)){
			    		year=Integer.parseInt(currentYear);
			    		month=Integer.parseInt(currentMonth);
			    		day=Integer.parseInt(currentDay);
			    		tvparty.setText(currentYear+"-"+currentMonth+"-"+currentDay);
			    		}else{
			    		tvparty.setText("");
			    		}
			    		sextype=Integer.parseInt(gender);
			    		if(gender.equals("1")){
			    			imgsex.setImageResource(R.drawable.man);
			    		}else if(gender.equals("2")){
			    			imgsex.setImageResource(R.drawable.woman);
			    		}
			    	}else if(masterAppcation.logininfo!=null){
			    		if(masterAppcation.logininfo.getVariables().getRealname()!=null){
						tvName.setText(masterAppcation.logininfo.getVariables().getRealname());
			    		}
			    		if(masterAppcation.logininfo.getVariables().getGender()!=null){
						sextype=Integer.parseInt(masterAppcation.logininfo.getVariables().getGender());
						if(masterAppcation.logininfo.getVariables().getGender().equals("1")){
							imgsex.setImageResource(R.drawable.man);
						}else if(masterAppcation.logininfo.getVariables().getGender().equals("2")){
							imgsex.setImageResource(R.drawable.woman);
						}
			    		}
			    		if(masterAppcation.logininfo.getVariables().getBirthyear()!=null){
						if(!masterAppcation.logininfo.getVariables().getBirthyear().equals("0")){
							tvparty.setText(masterAppcation.logininfo.getVariables().getBirthyear()+"-"+masterAppcation.logininfo.getVariables().getBirthmonth()+"-"+masterAppcation.logininfo.getVariables().getBirthday());
							year=Integer.parseInt(masterAppcation.logininfo.getVariables().getBirthyear());
						    month=Integer.parseInt(masterAppcation.logininfo.getVariables().getBirthmonth());
						    day=Integer.parseInt(masterAppcation.logininfo.getVariables().getBirthday());
						}
			    		}
			    		if(masterAppcation.logininfo.getVariables().getNationality()!=null){
					       tvCountry.setText(masterAppcation.logininfo.getVariables().getNationality());
			    		}
			    		if(masterAppcation.logininfo.getVariables().getOccupation()!=null){
					    tvWork.setText(masterAppcation.logininfo.getVariables().getOccupation());
			    		}
			    		if(masterAppcation.logininfo.getVariables().getMobile()!=null){
					    tvPhone.setText(masterAppcation.logininfo.getVariables().getMobile());
			    		}
			    		if(masterAppcation.logininfo.getVariables().getEmail()!=null){
					    tvEmail.setText(masterAppcation.logininfo.getVariables().getEmail());
			    		}
					}
			    	
				
			}

		@Override
		public void onClick(View v) {
			Intent intent=new Intent();
			Bundle bundle = new Bundle();
			switch (v.getId()) {
			case R.id.tvback://返回
				animFinish();
				break;
			case R.id.layout_name://昵称
				intent.setClass(UpdatePersonalInformationActivy.this, NickNameActivity.class);
				animStartActivity(intent);
				break;
			case R.id.layout_country:
				intent.setClass(UpdatePersonalInformationActivy.this, ProvinceCountryProfessionActivity.class);
				bundle.putString("type", "1");
				intent.putExtras(bundle);
				animStartActivity(intent);
				break;
			case R.id.layout_job:
				intent.setClass(UpdatePersonalInformationActivy.this, ProvinceCountryProfessionActivity.class);
				bundle.putString("type", "2");
				intent.putExtras(bundle);
				animStartActivity(intent);
				break;
			case R.id.layout_sex://性别
				showDialog();
				break;
			case R.id.se_man:// 男
				if (dia != null) {
					dia.dismiss();
				}
				sextype = 1;
				imgsex.setImageResource(R.drawable.man);

				break;
			case R.id.se_wuman: // 女

				if (dia != null) {
					dia.dismiss();
				}
				sextype = 2;
				imgsex.setImageResource(R.drawable.woman);

				break;
			case R.id.layout_party://生日
				DateTimePicker(tvparty);
				break;
			case R.id.btComplete:
				sendInformation();
				break;
			case R.id.layout_phone:
				intent.setClass(UpdatePersonalInformationActivy.this, NickNameActivity.class);
				intent.putExtra("type", 1);
				animStartActivity(intent);
				break;
			default:
				break;
			}
			
		}
		private void sendInformation() {
			 if(!NetUtil.isConnect(this)){
		 			ToastManager.showShort(this, "Unable to connect to the network, please check your network");
		 			return;
		 		}
			   name =tvName.getText().toString();
			   country=tvCountry.getText().toString();
			   prefession=tvWork.getText().toString();
			   phone=tvPhone.getText().toString();
			   
			   ArrayList<BasicNameValuePair> mParams=new ArrayList<BasicNameValuePair>();
		         mParams.add(new BasicNameValuePair("realname", name));
		         mParams.add(new BasicNameValuePair("gender", sextype+""));
		         mParams.add(new BasicNameValuePair("birthyear", year+""));
		         mParams.add(new BasicNameValuePair("birthmonth", month+""));
		         mParams.add(new BasicNameValuePair("birthday", day+""));
		         mParams.add(new BasicNameValuePair("nationality", country));
		         mParams.add(new BasicNameValuePair("occupation", prefession));
		         mParams.add(new BasicNameValuePair("mobile", phone));
		         mParams.add(new BasicNameValuePair("saltkey", saltkey));
		         mParams.add(new BasicNameValuePair("auth", auth));
		         mParams.add(new BasicNameValuePair("uid", uid));
		         
		         dao = new BaseDao(this, mParams, this, null);
		         dao.executeOnExecutor(MyAsyncTask.THREAD_POOL_EXECUTOR,
		                 Constant.BASE_INFORMATION_URL, "post", "false");
		         MasterApplication.getInstanse().showLoadDataDialogUtil(this,dao);
		}
		// 弹出 性别选择框
		private void showDialog() {

			dia = new Dialog(this, R.style.MDialog);

			LayoutInflater inflater = LayoutInflater.from(this);
			final View view = inflater.inflate(R.layout.dialog_select_sex, null);
			dia.addContentView(view, new LayoutParams(LayoutParams.MATCH_PARENT,
					LayoutParams.WRAP_CONTENT));
			view.findViewById(R.id.se_man).setOnClickListener(this);
			view.findViewById(R.id.se_wuman).setOnClickListener(this);
			dia.show();
		}
		//弹出 生日选择框
		public void DateTimePicker(final TextView showText) {
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			LayoutInflater factory = LayoutInflater.from(this);
			final View textEntryView = factory.inflate(R.layout.datatiem_dialog,
					null);
			DatePicker = (DatePicker) textEntryView
					.findViewById(R.id.adddaysheet_datapick);
			DatePicker.init(pickCal.get(Calendar.YEAR),pickCal.get(Calendar.MONTH),
					pickCal.get(Calendar.DAY_OF_MONTH),
					new DatePicker.OnDateChangedListener() {
						public void onDateChanged(DatePicker view, int year,
								int monthOfYear, int dayOfMonth) {
							pickCal.set(year, monthOfYear, dayOfMonth);
						}
					});
			builder.setTitle(R.string.time_choice);
			builder.setView(textEntryView);
			builder.setPositiveButton(R.string.sure, new DialogInterface.OnClickListener() {

				public void onClick(DialogInterface dialog, int whichButton) {
					DatePicker.clearFocus();
					Date mDate = pickCal.getTime();
					if (DateTimeUtils.compareDate(mDate) == -1) {
						Toast.makeText(UpdatePersonalInformationActivy.this, "Time error", Toast.LENGTH_SHORT).show();
					}
					else {
						try
						{
//							ageTextView.setText(ToolUtils.getAge(mDate)+"");
						} catch (Exception e)
						{
							e.printStackTrace();
						}
						showText.setText(SDF.format(pickCal.getTime()));
						year=pickCal.get(Calendar.YEAR);
						month=pickCal.get(Calendar.MONTH)+1;
						day=pickCal.get(Calendar.DAY_OF_MONTH);
					}
					
				}
			});
			builder.setNegativeButton(R.string.cancel, new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int whichButton) {

				}
			});
			builder.create().show();
		}
		
		
		class CountryReceiver extends BroadcastReceiver{

			@Override
			public void onReceive(Context context, Intent intent) {
				String action = intent.getAction();
				if(action.equals(Constant.ACTION_CHOOSECOUNTRY_SUCCESS)){
				boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
				  if(isSuccess){
					  Bundle extras = intent.getExtras();
					  values=extras.getString("Values");
					  tvCountry.setText(values);
				  }
				}
				if(action.equals(Constant.ACTION_CHOOSEWORK_SUCCESS)){
					boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
					  if(isSuccess){
						  Bundle extras = intent.getExtras();
						  values=extras.getString("Values");
						  tvWork.setText(values);
					  }
					}
				if(action.equals(Constant.ACTION_NICKNAME_SUCCESS)){
					boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
					if(isSuccess){
						Bundle extras = intent.getExtras();
						  values=extras.getString("Values");
						  tvName.setText(values);
					}
				}
				if(action.equals(Constant.ACTION_PHONE_SUCCESS)){
					boolean isSuccess=intent.getBooleanExtra(Constant.KEY_IS_SUCCESS, false);
					if(isSuccess){
						Bundle extras = intent.getExtras();
						  values=extras.getString("Values");
						  tvPhone.setText(values);
					}
				}
				}
			}


		@Override
		public void onBegin() {
			// TODO Auto-generated method stub
			
		}
		@Override
		public void onComplete(BaseEntity result) {
			MasterApplication.getInstanse().closeLoadDataDialogUtil();
			if(result!=null){
				logininfo=GetJsonData.get(result.toString(), LoginInfo.class);
				if(logininfo.getMessage().getMessageval().equals("edit_success")){
					ToastManager.showShort(this, "Success!");
					PreferenceUtils.setPrefString(this, "Realname", name);
					PreferenceUtils.setPrefString(this, "Gender", sextype+"");
					PreferenceUtils.setPrefString(this, "Year", year+"");
					PreferenceUtils.setPrefString(this, "Month", month+"");
					PreferenceUtils.setPrefString(this, "Day", day+"");
					PreferenceUtils.setPrefString(this, "Nationality", country);
					PreferenceUtils.setPrefString(this, "Occupation", prefession);
					PreferenceUtils.setPrefString(this, "Mobile", phone);
				}else{
					ToastManager.showShort(this, logininfo.getMessage().getMessagestr());
				}
			}else{
				ToastManager.showShort(this, "Data requests failed, please try again later");
			}
		}
		@Override
		public void onNetworkNotConnection() {
			// TODO Auto-generated method stub
			
		}
		@Override
		public void setContentView() {
			setContentView(R.layout.activity_more_myinfo);
			countryReceiver=new CountryReceiver();
			IntentFilter filter=new IntentFilter(Constant.ACTION_CHOOSECOUNTRY_SUCCESS);
			IntentFilter filterWork=new IntentFilter(Constant.ACTION_CHOOSEWORK_SUCCESS);
			IntentFilter filterName=new IntentFilter(Constant.ACTION_NICKNAME_SUCCESS);
			IntentFilter filterPhone=new IntentFilter(Constant.ACTION_PHONE_SUCCESS);
			registerReceiver(countryReceiver, filter);
			registerReceiver(countryReceiver, filterName);
			registerReceiver(countryReceiver, filterWork);
			registerReceiver(countryReceiver, filterPhone);
			
		}
		@Override
		public void initWidget() {
			initView();
			setListener();
			setData();
			
		}
		@Override
		public void getData() {
			// TODO Auto-generated method stub
			
		}
}
