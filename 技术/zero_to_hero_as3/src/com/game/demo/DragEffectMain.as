package com.game.demo
{
	import com.game.lib.effect.DragEffect;
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	/**
	 * 拖尾效果示例
	 * @author Shines
	 */
	public class DragEffectMain extends Sprite
	{
		private var _dragEffect:DragEffect = null;
		private var _mc:MovieClip = null;
		
		public function DragEffectMain():void
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
			myLoader.addSwf("res_demo/drageffect.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			_mc = MovieClip(MyLoader.createObject("res_demo.drageffect.DemoMc"));
			stage.addChild(_mc);
			_dragEffect = new DragEffect(_mc, stage);
			stage.addEventListener(MouseEvent.CLICK, onClickStage);
		}
		
		private function onClickStage(e:MouseEvent):void 
		{
			_dragEffect.moveTo(stage.mouseX - _mc.width / 2, stage.mouseY - _mc.height / 2);
		}
	}
}
