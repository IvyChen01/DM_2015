package com.game.lib.loading
{
	import flash.display.DisplayObject;
	import flash.display.Loader;
	import flash.display.LoaderInfo;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.net.URLRequest;
	import flash.system.ApplicationDomain;
	import flash.system.LoaderContext;
	
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
	 * 显示对象加载器
	 * @author Shines
	 */
	public class DisplayObjectLoader extends EventDispatcher
	{
		private var _content:DisplayObject = null; //加载内容
		
		/**
		 * 指定当前域
		 */
		public function DisplayObjectLoader():void
		{
		}
		
		/**
		 * 加载
		 * @param	url	加载文件名
		 */
		public function load(url:String):void
		{
			var loader:Loader = new Loader();
			var context:LoaderContext = new LoaderContext(false, ApplicationDomain.currentDomain);
			
			loader.contentLoaderInfo.addEventListener(Event.COMPLETE, onComplete);
			loader.contentLoaderInfo.addEventListener(ProgressEvent.PROGRESS, onProgress);
			loader.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, onError);
			loader.load(new URLRequest(url), context);
		}
		
		/**
		 * 加载完成
		 * @param	e
		 */
		private function onComplete(e:Event):void
		{
			_content = LoaderInfo(e.currentTarget).content;
			LoaderInfo(e.currentTarget).removeEventListener(Event.COMPLETE, onComplete);
			LoaderInfo(e.currentTarget).removeEventListener(ProgressEvent.PROGRESS, onProgress);
			LoaderInfo(e.currentTarget).removeEventListener(IOErrorEvent.IO_ERROR, onError);
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
			LoaderInfo(e.currentTarget).removeEventListener(Event.COMPLETE, onComplete);
			LoaderInfo(e.currentTarget).removeEventListener(ProgressEvent.PROGRESS, onProgress);
			LoaderInfo(e.currentTarget).removeEventListener(IOErrorEvent.IO_ERROR, onError);
			this.dispatchEvent(e);
		}
		
		/**
		 * 获取加载内容
		 */
		public function get content():DisplayObject
		{
			return _content;
		}
	}
}
