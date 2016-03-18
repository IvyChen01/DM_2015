package com.game.lib.events
{
	import flash.events.Event;
	
	/**
	 * Http事件
	 * @author Shines
	 */
	public class HttpEvent extends Event
	{
		public static const COMPLETE:String = "HttpEvent_COMPLETE"; //调用成功
		
		public var param:Object = null; //传递参数
		
		/**
		 * 构造事件
		 * @param	aType	事件名称
		 * @param	aParam	传递参数
		 */
		public function HttpEvent(aType:String, aParam:Object = null):void
		{
			super(aType);
			param = aParam;
		}
		
		override public function clone():Event
		{
			return new HttpEvent(this.type, param);
		}
	}
}
