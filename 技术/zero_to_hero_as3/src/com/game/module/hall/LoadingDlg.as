package com.game.module.hall
{
	import com.game.lib.Debug;
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	
	public class LoadingDlg
	{
		private var _content:MovieClip = null;//元件
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		public function LoadingDlg(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_content.visible = false;
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			_content.gotoAndPlay(1);
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_content.visible = false;
			_content.gotoAndStop(1);
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
			}
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
