package com.game.demo
{
	import com.game.lib.Debug;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	
	/**
	 * 调试输出示例
	 * @author Shines
	 */
	public class DebugMain extends Sprite
	{
		public function DebugMain():void
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
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			Debug.init(stage, stage);
			Debug.log("ok");
		}
	}
}
