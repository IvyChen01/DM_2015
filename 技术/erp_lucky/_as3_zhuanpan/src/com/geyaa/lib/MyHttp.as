package com.geyaa.lib
{
	import com.geyaa.lib.events.HttpEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	/**
	 * 调用成功事件
	 * @eventType	com.geyaa.lib.events.HttpEvent.COMPLETE
	 */
	[Event(name = "HttpEvent_COMPLETE", type = "com.geyaa.lib.events.HttpEvent")]
	
	/**
	 * Web服务端
	 * @author Shines
	 */
	public class MyHttp extends EventDispatcher
	{
		/**
		 * 请求Web数据，用POST方式
		 * @param	aUrl
		 * @param	aParam
		 */
		public function call(aUrl:String, aParam:Object = null):void
		{
			var loader:URLLoader = new URLLoader();
			var request:URLRequest = new URLRequest();
			var variable:URLVariables = new URLVariables();
			
			request.url = aUrl;
			request.method = URLRequestMethod.POST;
			if (aParam != null)
			{
				variable.param = JSON.stringify(aParam);
				request.data = variable;
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
			loader = null;
			request = null;
			variable = null;
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
			loader = null;
			this.dispatchEvent(new HttpEvent(HttpEvent.COMPLETE, result));
		}
	}
}
