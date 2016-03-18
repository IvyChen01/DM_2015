package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.Mover;
	import flash.display.MovieClip;
	import flash.display.SimpleButton;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	/**
	 * 缓动示例
	 * @author Shines
	 */
	public class MoverMain extends Sprite
	{
		private var _mover:Mover = null;
		private var _moverMc:MovieClip = null;
		private var _lineMc:MovieClip = null;
		private var _moveToRightBtn:SimpleButton = null;
		private var _moveToLeftBtn:SimpleButton = null;
		private var _upToRightBtn:SimpleButton = null;
		private var _upToLeftBtn:SimpleButton = null;
		private var _downToRightBtn:SimpleButton = null;
		private var _downToLeftBtn:SimpleButton = null;
		private var _changeToRightBtn:SimpleButton = null;
		private var _changeToLeftBtn:SimpleButton = null;
		
		public function MoverMain():void
		{
			if (stage)
			{
				init();
			}
			else
			{
				addEventListener(Event.ADDED_TO_STAGE, init);
			}
		}
		
		/**
		 * 初始化
		 * @param	e
		 */
		private function init(e:Event = null):void
		{
			var myLoader:MyLoader = null;
		
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			myLoader = new MyLoader();
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteLoad);
			myLoader.addSwf("res_demo/mover.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.mover.DemoMc"));
			stage.addChild(mc);
			_mover = new Mover();
			_mover.addEventListener(Event.CHANGE, onChangeMover);
			_moverMc = mc["moverMc"];
			_lineMc = mc["lineMc"];
			_moveToRightBtn = mc["moveToRightBtn"];
			_moveToLeftBtn = mc["moveToLeftBtn"];
			_upToRightBtn = mc["upToRightBtn"];
			_upToLeftBtn = mc["upToLeftBtn"];
			_downToRightBtn = mc["downToRightBtn"];
			_downToLeftBtn = mc["downToLeftBtn"];
			_changeToRightBtn = mc["changeToRightBtn"];
			_changeToLeftBtn = mc["changeToLeftBtn"];
			
			_moveToRightBtn.addEventListener(MouseEvent.CLICK, onClickMoveRigth);
			_moveToLeftBtn.addEventListener(MouseEvent.CLICK, onClickMoveLeft);
			_upToRightBtn.addEventListener(MouseEvent.CLICK, onClickUpRigth);
			_upToLeftBtn.addEventListener(MouseEvent.CLICK, onClickUpLeft);
			_downToRightBtn.addEventListener(MouseEvent.CLICK, onClickDownRigth);
			_downToLeftBtn.addEventListener(MouseEvent.CLICK, onClickDownLeft);
			_changeToRightBtn.addEventListener(MouseEvent.CLICK, onClickChangeRigth);
			_changeToLeftBtn.addEventListener(MouseEvent.CLICK, onClickChangeLeft);
		}
		
		private function onChangeMover(e:Event):void 
		{
			_moverMc.x = _lineMc.x + _mover.currentPlace;
		}
		
		private function onClickMoveRigth(e:MouseEvent):void 
		{
			_mover.moveTo(_lineMc.width - _moverMc.width);
		}
		
		private function onClickMoveLeft(e:MouseEvent):void 
		{
			_mover.moveTo(0);
		}
		
		private function onClickUpRigth(e:MouseEvent):void 
		{
			_mover.upTo(_lineMc.width - _moverMc.width);
		}
		
		private function onClickUpLeft(e:MouseEvent):void 
		{
			_mover.upTo(0);
		}
		
		private function onClickDownRigth(e:MouseEvent):void 
		{
			_mover.downTo(_lineMc.width - _moverMc.width);
		}
		
		private function onClickDownLeft(e:MouseEvent):void 
		{
			_mover.downTo(0);
		}
		
		private function onClickChangeRigth(e:MouseEvent):void 
		{
			_mover.changeTo((_lineMc.width - _moverMc.width) * 0.4, (_lineMc.width - _moverMc.width) * 0.8, _lineMc.width - _moverMc.width);
		}
		
		private function onClickChangeLeft(e:MouseEvent):void 
		{
			_mover.changeTo((_lineMc.width - _moverMc.width) * 0.8, (_lineMc.width - _moverMc.width) * 0.4, 0);
		}
	}
}
