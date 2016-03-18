package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.SimpleTip;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	
	/**
	 * 提示示例
	 * @author Shines
	 */
	public class SimpleTipMain extends Sprite
	{
		private var _mc1:MovieClip = null;
		private var _mc2:MovieClip = null;
		private var _tip:SimpleTip = null;
		
		public function SimpleTipMain():void
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
			myLoader.addSwf("res_demo/simpletip.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.simpletip.DemoMc"));
			stage.addChild(mc);
			_mc1 = mc["mc1"];
			_mc2 = mc["mc2"];
			_tip = new SimpleTip(mc["tip"], stage, 910, 550);
			_tip.addTip(_mc1, "1AS3游戏开发 AS3游戏开发 AS3游戏开发 AS3游戏开发" + Math.random().toString());
			_tip.addTip(_mc2, "2AS3游戏开发 AS3游戏开发 AS3游戏开发 AS3游戏开发 AS3游戏开发 AS3游戏开发" + Math.random().toString());
		}
	}
}
