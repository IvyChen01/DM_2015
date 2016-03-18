package com.game.demo
{
	import com.game.lib.events.HttpEvent;
	import com.game.lib.Http;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.net.URLVariables;
	
	/**
	 * Http通信示例
	 * @author Shines
	 */
	public class HttpMain extends Sprite
	{
		private var _http:Http = null;
		
		public function HttpMain():void
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
			var urlVar:URLVariables = new URLVariables();
			
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			urlVar["username"] = "abc";
			urlVar["password"] = "abc";
			_http = new Http();
			_http.addEventListener(HttpEvent.COMPLETE, onComplete);
			_http.call("http://localhost/p1_qumuwu/?m=admin&a=login", urlVar);
			
			//_http.upload("", bytes);上传图片
		}
		
		private function onComplete(e:HttpEvent):void
		{
			if (e.param != null)
			{
				for (var key:String in e.param)
				{
					trace("key: " + key);
					trace("value: " + e.param[key]);
				}
			}
		}
	}
}
