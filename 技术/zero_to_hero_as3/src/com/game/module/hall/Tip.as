package com.game.module.hall
{
	import com.greensock.TweenLite;
	import flash.display.MovieClip;
	import flash.text.TextField;
	
	public class Tip
	{
		private var _content:MovieClip = null;//元件
		private var _label:TextField = null;
		
		public function Tip(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_label = _content["label"];
			_content.visible = false;
		}
		
		public function show(value:String):void
		{
			_label.text = value;
			_content.visible = true;
			_content.alpha = 0.6;
			TweenLite.to(_content, 2, { alpha: 1, onComplete: delayHide} );
		}
		
		public function delayHide():void
		{
			TweenLite.to(_content, 1, { alpha: 0, onComplete: hide} );
		}
		
		public function hide():void
		{
			_content.visible = false;
		}
	}
}
