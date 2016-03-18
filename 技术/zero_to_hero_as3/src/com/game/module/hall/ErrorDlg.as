package com.game.module.hall
{
	import com.game.lib.Debug;
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	
	public class ErrorDlg
	{
		private var _content:MovieClip = null;//元件
		private var _label:TextField = null;
		private var _downBtn:MyButton = null;
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		public function ErrorDlg(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_content.visible = false;
			_label = _content["label"];
			_downBtn = new MyButton(_content["downBtn"]);
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_content.visible = false;
			removeEvents();
		}
		
		public function setLabel(value:String):void
		{
			_label.text = value;
		}
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_downBtn.addEventListener(MouseEvent.CLICK, onClickClose);
			}
		}
		
		private function onClickClose(e:MouseEvent):void 
		{
			hide();
		}
		
		/**
		 * 移除事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
			}
		}
	}
}
