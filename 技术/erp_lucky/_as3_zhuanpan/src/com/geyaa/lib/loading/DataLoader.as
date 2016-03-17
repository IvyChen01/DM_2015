package com.geyaa.lib.loading
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	
	/**
	 * 加载完成事件
	 * @eventType	flash.events.Event.COMPLETE
	 */
	[Event(name = "complete", type = "flash.events.Event")]
	
	/**
	 * 加载进度事件
	 * @eventType	flash.events.ProgressEvent.PROGRESS
	 */
	[Event(name = "progress", type = "flash.events.ProgressEvent")]
	
	/**
	 * 加载出错事件
	 * @eventType	flash.events.IOErrorEvent.IO_ERROR
	 */
	[Event(name = "ioError", type = "flash.events.IOErrorEvent")]
	
	/**
	 * 数据对象加载器
	 * @author Shines
	 */
	public class DataLoader extends EventDispatcher
	{
		private var _content:* = null; //加载内容
		
		/**
		 * 指定当前域
		 */
		public function DataLoader():void
		{
		}
		
		/**
		 * 加载
		 * @param	url	加载文件名
		 */
		public function load(url:String):void
		{
			var urlLoader:URLLoader = new URLLoader();
			
			urlLoader.addEventListener(Event.COMPLETE, onComplete);
			urlLoader.addEventListener(ProgressEvent.PROGRESS, onProgress);
			urlLoader.addEventListener(IOErrorEvent.IO_ERROR, onError);
			urlLoader.load(new URLRequest(url));
		}
		
		/**
		 * 加载完成
		 * @param	e
		 */
		private function onComplete(e:Event):void
		{
			_content = URLLoader(e.currentTarget).data;
			URLLoader(e.currentTarget).removeEventListener(Event.COMPLETE, onComplete);
			URLLoader(e.currentTarget).removeEventListener(ProgressEvent.PROGRESS, onProgress);
			URLLoader(e.currentTarget).removeEventListener(IOErrorEvent.IO_ERROR, onError);
			this.dispatchEvent(e);
		}
		
		/**
		 * 加载进度
		 * @param	e
		 */
		private function onProgress(e:ProgressEvent):void
		{
			this.dispatchEvent(e);
		}
		
		/**
		 * 加载出错
		 * @param	e
		 */
		private function onError(e:IOErrorEvent):void
		{
			URLLoader(e.currentTarget).removeEventListener(Event.COMPLETE, onComplete);
			URLLoader(e.currentTarget).removeEventListener(ProgressEvent.PROGRESS, onProgress);
			URLLoader(e.currentTarget).removeEventListener(IOErrorEvent.IO_ERROR, onError);
			this.dispatchEvent(e);
		}
		
		/**
		 * 获取加载内容
		 */
		public function get content():*
		{
			return _content;
		}
	}
}
