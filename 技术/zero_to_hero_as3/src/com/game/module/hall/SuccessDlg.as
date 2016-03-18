package com.game.module.hall
{
	import com.game.lib.Debug;
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	
	public class SuccessDlg extends EventDispatcher
	{
		private var _content:MovieClip = null;//元件
		private var _closeBtn:MyButton = null;
		private var _shareBtn:MyButton = null;
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		public function SuccessDlg(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_content.visible = false;
			_closeBtn = new MyButton(_content["closeBtn"]);
			_shareBtn = new MyButton(_content["shareBtn"]);
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
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_shareBtn.addEventListener(MouseEvent.CLICK, onClickShare);
				_closeBtn.addEventListener(MouseEvent.CLICK, onClickClose);
			}
		}
		
		private function onClickShare(e:MouseEvent):void 
		{
			hide();
			this.dispatchEvent(e);
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
