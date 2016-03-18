package com.game.module.hall
{
	import com.game.core.Config;
	import com.game.lib.MyButton;
	import com.greensock.TweenLite;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	
	public class BgSelector extends EventDispatcher
	{
		private var _content:MovieClip = null;//元件
		private var _upBtn:MyButton = null;
		private var _downBtn:MyButton = null;
		private var _list:MovieClip = null;
		private var _p1:MovieClip = null;
		private var _p2:MovieClip = null;
		private var _p3:MovieClip = null;
		private var _p4:MovieClip = null;
		private var _p5:MovieClip = null;
		private var _p6:MovieClip = null;
		private var _p7:MovieClip = null;
		private var _p8:MovieClip = null;
		private var _currentPic:int = 1;
		
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		public function BgSelector(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_upBtn = new MyButton(_content["upBtn"]);
			_downBtn = new MyButton(_content["downBtn"]);
			_list = _content["list"];
			_p1 = _list["p1"];
			_p2 = _list["p2"];
			_p3 = _list["p3"];
			_p4 = _list["p4"];
			_p5 = _list["p5"];
			_p6 = _list["p6"];
			_p7 = _list["p7"];
			_p8 = _list["p8"];
			_p1.buttonMode = true;
			_p2.buttonMode = true;
			_p3.buttonMode = true;
			_p4.buttonMode = true;
			_p5.buttonMode = true;
			_p6.buttonMode = true;
			_p7.buttonMode = true;
			_p8.buttonMode = true;
			_content.x = Config.STAGE_WIDTH;
			_upBtn.enabled = false;
			_downBtn.enabled = true;
			addEvents();
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			TweenLite.to(_content, 0.5, { x: Config.STAGE_WIDTH - 103 } );
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			TweenLite.to(_content, 0.5, { x: Config.STAGE_WIDTH } );
		}
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_upBtn.addEventListener(MouseEvent.CLICK, onClickUp);
				_downBtn.addEventListener(MouseEvent.CLICK, onClickDown);
				_p1.addEventListener(MouseEvent.CLICK, onClickP1);
				_p2.addEventListener(MouseEvent.CLICK, onClickP2);
				_p3.addEventListener(MouseEvent.CLICK, onClickP3);
				_p4.addEventListener(MouseEvent.CLICK, onClickP4);
				_p5.addEventListener(MouseEvent.CLICK, onClickP5);
				_p6.addEventListener(MouseEvent.CLICK, onClickP6);
				_p7.addEventListener(MouseEvent.CLICK, onClickP7);
				_p8.addEventListener(MouseEvent.CLICK, onClickP8);
			}
		}
		
		private function onClickUp(e:MouseEvent):void 
		{
			_upBtn.enabled = false;
			_downBtn.enabled = true;
			TweenLite.to(_list, 1, { y: 129.55 } );
		}
		
		private function onClickDown(e:MouseEvent):void 
		{
			_upBtn.enabled = true;
			_downBtn.enabled = false;
			TweenLite.to(_list, 1, { y: 129.55 - 440 } );
		}
		
		private function onClickP1(e:MouseEvent):void 
		{
			_currentPic = 1;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP2(e:MouseEvent):void 
		{
			_currentPic = 2;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP3(e:MouseEvent):void 
		{
			_currentPic = 3;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP4(e:MouseEvent):void 
		{
			_currentPic = 4;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP5(e:MouseEvent):void 
		{
			_currentPic = 5;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP6(e:MouseEvent):void 
		{
			_currentPic = 6;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP7(e:MouseEvent):void 
		{
			_currentPic = 7;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		private function onClickP8(e:MouseEvent):void 
		{
			_currentPic = 8;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		public function get currentPic():int 
		{
			return _currentPic;
		}
	}
}
