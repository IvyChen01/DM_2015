package com.game.lib
{
	import com.game.lib.events.HttpEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.net.URLLoader;
	import flash.net.URLLoaderDataFormat;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	import flash.utils.ByteArray;
	
	/**
	 * 调用成功事件
	 * @eventType	com.game.lib.events.HttpEvent.COMPLETE
	 */
	[Event(name = "HttpEvent_COMPLETE", type = "com.game.lib.events.HttpEvent")]
	
	/**
	 * Web服务端
	 * @author Shines
	 */
	public class Http extends EventDispatcher
	{
		/**
		 * 请求Web数据，用POST方式
		 * @param	aUrl
		 * @param	aUrlVar
		 */
		public function call(aUrl:String, aUrlVar:URLVariables = null):void
		{
			var loader:URLLoader = new URLLoader();
			var request:URLRequest = new URLRequest();
			
			request.url = aUrl;
			request.method = URLRequestMethod.POST;
			if (aUrlVar != null)
			{
				request.data = aUrlVar;
			}
			loader.addEventListener(Event.COMPLETE, onComplete);
			try
			{
				loader.load(request);
			}
			catch (err:Error)
			{
				trace("[error] " + err);
				this.dispatchEvent(new HttpEvent(HttpEvent.COMPLETE));
			}
		}
		
		/**
		 * 上传图片
		 * @param	aUrl
		 * @param	aParam
		 */
		public function upload(aUrl:String, aBytes:ByteArray):void
		{
			var loader:URLLoader = new URLLoader();
			var request:URLRequest = new URLRequest();
			
			request.url = aUrl;
			request.method = URLRequestMethod.POST;
			loader.dataFormat = URLLoaderDataFormat.BINARY;
			if (aBytes != null)
			{
				request.data = aBytes;
			}
			loader.addEventListener(Event.COMPLETE, onComplete);
			try
			{
				loader.load(request);
			}
			catch (err:Error)
			{
				trace("[error] " + err);
				this.dispatchEvent(new HttpEvent(HttpEvent.COMPLETE));
			}
		}
		
		/**
		 * 调用成功，获得返回数据
		 */
		private function onComplete(e:Event):void
		{
			var loader:URLLoader = URLLoader(e.currentTarget);
			var result:Object = null;
			
			if (loader.data != null && loader.data != "")
			{
				try
				{
					result = JSON.parse(loader.data);
				}
				catch (err:Error)
				{
					trace("[error] " + err);
				}
			}
			loader.removeEventListener(Event.COMPLETE, onComplete);
			this.dispatchEvent(new HttpEvent(HttpEvent.COMPLETE, result));
		}
	}
}
