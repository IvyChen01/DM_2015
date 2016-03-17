package com.geyaa.lib.events
{
	import flash.events.Event;
	
	/**
	 * Socket事件
	 * @author Shines
	 */
	public class SocketEvent extends Event
	{
		public static const CONNECT:String = "SocketEvent_CONNECT"; //连接成功
		public static const SOCKET_DATA:String = "SocketEvent_SOCKET_DATA"; //收到数据
		public static const CLOSE:String = "SocketEvent_CLOSE"; //连接关闭
		public static const ERROR:String = "SocketEvent_ERROR"; //Socket出错
		
		public var param:Object = null; //传递参数
		
		/**
		 * 构造事件
		 * @param	aType	事件名称
		 * @param	aParam	传递参数
		 */
		public function SocketEvent(aType:String, aParam:Object = null):void
		{
			super(aType);
			param = aParam;
		}
		
		override public function clone():Event
		{
			return new SocketEvent(this.type, param);
		}
	}
}
