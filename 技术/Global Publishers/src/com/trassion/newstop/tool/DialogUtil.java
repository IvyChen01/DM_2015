package com.trassion.newstop.tool;


import com.trassion.newstop.activity.R;
import com.trassion.newstop.application.CurrentActivityContext;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

/**
 * 自定义窗口
 * <p>使用示例：</p>
 * <pre>
 * MasterDialog dialog = new MasterDialog.Builder(CalloutNewActivity.this)
 *	.setTitle("title")
 *	.setMessage("消息")
 *	.setNegativeButton("取消", null) //不设置文字， cancel按钮不显示
 *	.setPositiveButton("确定", new DialogInterface.OnClickListener() {
 *@Override
 *public void onClick(DialogInterface dialog, int which) {
 *			 
 * //your code
 *			
 *}
 *}).create();
 *	
 *dialog.show();
 *	</pre>
 */
public class DialogUtil extends Dialog {
	
	public DialogUtil(Context context, int theme) {
        super(context, theme);
    }
    public DialogUtil(Context context) {
        super(context);
    }
    
    /**
     * Helper class for creating a custom dialog
     */
    public static class Builder {
    	
        private Context context;
        private String title;
        private String message;
        
        
        private String positiveButtonText = null;
        private String negativeButtonText = null;
        
        private DialogInterface.OnClickListener positiveButtonClickListener, negativeButtonClickListener;
        
        //
        public void setPositiveButtonClickListener(
				DialogInterface.OnClickListener positiveButtonClickListener) {
			this.positiveButtonClickListener = positiveButtonClickListener;
		}

        //
		public void setNegativeButtonClickListener(
				DialogInterface.OnClickListener negativeButtonClickListener) {
			this.negativeButtonClickListener = negativeButtonClickListener;
		}

		//
		public Builder(Context context) {
            this.context = context;
        }
        
        /**
         * Set the Dialog message from String
         * @param title
         * @return
         */
        public Builder setMessage(String message) {
            this.message = message;
            return this;
        }
        
        /**
         * Set the Dialog message from resource
         * @param title
         * @return
         */
        public Builder setMessage(int message) {
            this.message = (String) context.getText(message);
            return this;
        }
        
        /**
         * Set the Dialog title from resource
         * @param title
         * @return
         */
        public Builder setTitle(int title) {
            this.title = (String) context.getText(title);
            return this;
        }
        
        /**
         * Set the Dialog title from String
         * @param title
         * @return
         */
        public Builder setTitle(String title) {
            this.title = title;
            return this;
        }

        /**
         * Set the positive button text and it's listener
         * @param positiveButtonText
         * @param listener
         * @return
         */
        public Builder setPositiveButton(String positiveButtonText, DialogInterface.OnClickListener listener) {
            this.positiveButtonText = positiveButtonText;
            this.positiveButtonClickListener = listener;
            return this;
        }
        
        
        /**
         * Set the negative button resource and it's listener
         * @param negativeButtonText
         * @param listener
         * @return
         */
        public Builder setNegativeButton(String negativeButtonText, DialogInterface.OnClickListener listener) {
            this.negativeButtonText = negativeButtonText;
            this.negativeButtonClickListener = listener;
            return this;
        }
        
        
        
        //---------------------------------------------------------
        // Create the custom dialog
        //---------------------------------------------------------
        public DialogUtil create() {
        	//
        	 LayoutInflater inflater = LayoutInflater.from(CurrentActivityContext.getInstance().getCurrentContext());
            
            // instantiate the dialog with the custom Theme
            final DialogUtil dialog = new DialogUtil(context, R.style.Dialog);
            
            View layout = inflater.inflate(R.layout.dialog_layout, null);
           
            // set the content and title message
            ((TextView) layout.findViewById(R.id.dialog_title_txt)).setText(title);
            ((TextView) layout.findViewById(R.id.dialog_message_txt)).setText(message);
            
            //set the button text
            if(negativeButtonText != null) {
            	((TextView) layout.findViewById(R.id.dialog_cancel_txt)).setText(negativeButtonText);
            	if(negativeButtonClickListener == null){
                	negativeButtonClickListener = new OnClickListener() {
    					
    					@Override
    					public void onClick(DialogInterface dialog, int which) {
    						// TODO Auto-generated method stub
    						dialog.dismiss();
    						dialog = null;
    					}
    				};
    				
    				//
    				layout.findViewById(R.id.dialog_cancel_txt).setOnClickListener(new View.OnClickListener(){

         				@Override
         				public void onClick(View v) {
         					// TODO Auto-generated method stub
         					negativeButtonClickListener.onClick(dialog, DialogInterface.BUTTON_NEGATIVE);
         				}
                     	
                     });
                }else{
                	 layout.findViewById(R.id.dialog_cancel_txt).setOnClickListener(new View.OnClickListener(){

         				@Override
         				public void onClick(View v) {
         					// TODO Auto-generated method stub
         					negativeButtonClickListener.onClick(dialog, DialogInterface.BUTTON_NEGATIVE);
         				}
                     	
                     });
                	 
                	 //
                	 if(dialog != null) dialog.dismiss();
                }
            }else{
            	layout.findViewById(R.id.dialog_cancel_txt).setVisibility(View.GONE);
//            	layout.findViewById(R.id.dialog_confirm_txt).setBackgroundResource(R.drawable.dialog_single_gray_btn_bg);
            }
            
            //
            if(positiveButtonText != null) ((TextView) layout.findViewById(R.id.dialog_confirm_txt)).setText(positiveButtonText);
            
            
            //cancel button
           
            
            //confirm button
            layout.findViewById(R.id.dialog_confirm_txt).setOnClickListener(new View.OnClickListener(){

				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					positiveButtonClickListener.onClick(dialog, DialogInterface.BUTTON_POSITIVE);
					
					if(dialog != null)	dialog.dismiss();
				}
            	
            });
            
            dialog.setContentView(layout);
            return dialog;
        }
        
    }
   
}
