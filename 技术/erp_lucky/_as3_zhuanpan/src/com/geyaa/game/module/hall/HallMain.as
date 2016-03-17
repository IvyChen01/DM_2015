package com.geyaa.game.module.hall
{
	import com.geyaa.game.core.Config;
	import com.geyaa.game.core.MyLayer;
	import com.geyaa.lib.events.HttpEvent;
	import com.geyaa.lib.loading.MyLoader;
	import com.geyaa.lib.MyDebug;
	import com.geyaa.lib.MyMover;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	import flash.events.MouseEvent;
	import flash.external.ExternalInterface;
	
	/**
	 * 大厅模块
	 * @author Shines
	 */
	public class HallMain
	{
		private var _content:MovieClip = null;//元件
		private var _circleMc:MovieClip = null;
		private var _isAddEvents:Boolean = false;//是否已添加事件
		private var _myMover:MyMover = null;
		private var _luckyCode:int = 0;
		
		public function HallMain():void
		{
			_content = MovieClip(MyLoader.createObject("res.hall.CircleMc"));
			_content.gotoAndStop(1);
			_circleMc = _content["circleMc"];
			_myMover = new MyMover();
			show();
			
			try
			{
				if (ExternalInterface.available)
				{
					ExternalInterface.addCallback("runTo", runTo);
				}
				else
				{
					MyDebug.echo("External interface is not available for this container.");
				}
			}
			catch (e:Error)
			{
				MyDebug.echo("error: " + e.message);
			}
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			if (null == _content.parent)
			{
				MyLayer.ui.addChild(_content);
			}
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_content.visible = false;
			if (_content.parent != null)
			{
				_content.parent.removeChild(_content);
			}
			removeEvents();
		}
		
		public function runTo(num:int):void
		{
			MyDebug.echo("num: " + num);
			var fixPlace:Array = [1, 4, 8, 6, 2, 3, 7];
			var frameCount:int = 8;
			var frameAngle:Number = 360 / frameCount;
			var offset:Number = 0;
			var destPlace:int = 0;
			
			if (num >= 0 && num <= 6)
			{
				_luckyCode = num;
				num = fixPlace[num];
			}
			else
			{
				num = 0;
			}
			destPlace = 360 * 15 - frameAngle * num + frameAngle / 2 + offset;
			_myMover.currentPlace = _myMover.currentPlace % 360;
			_myMover.changeTo(destPlace * 0.2, destPlace * 0.8, destPlace, 1, 0.1);
		}
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_myMover.addEventListener(Event.CHANGE, onChangeMover);
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
				_myMover.removeEventListener(Event.CHANGE, onChangeMover);
			}
		}
		
		private function onChangeMover(e:Event):void 
		{
			_circleMc.rotation = _myMover.currentPlace;
			
			if (!_myMover.moving)
			{
				try
				{
					if (ExternalInterface.available)
					{
						ExternalInterface.call("showTip", _luckyCode);
					}
					else
					{
						MyDebug.echo("External interface is not available for this container.");
					}
				}
				catch (e:Error)
				{
					MyDebug.echo("error: " + e.message);
				}
			}
		}
	}
}
