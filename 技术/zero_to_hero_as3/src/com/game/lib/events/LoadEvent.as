package com.game.lib.events
{
	import flash.events.Event;
	
	/**
	 * 加载事件
	 * @author Shines
	 */
	public class LoadEvent extends Event
	{
		public static const COMPLETE:String = "LoadEvent_COMPLETE"; //文件加载完成
		public static const PROGRESS:String = "LoadEvent_PROGRESS"; //加载进度
		public static const ERROR:String = "LoadEvent_ERROR"; //加载出错
		
		public var rate:Number = 0; //全部文件加载总进度
		
		/**
		 * 构造事件
		 * @param	aType	事件名称
		 * @param	aRate	全部文件加载总进度
		 */
		public function LoadEvent(aType:String, aRate:Number = 0):void
		{
			super(aType);
			rate = aRate;
		}
		
		override public function clone():Event
		{
			return new LoadEvent(this.type, rate);
		}
	}
}
