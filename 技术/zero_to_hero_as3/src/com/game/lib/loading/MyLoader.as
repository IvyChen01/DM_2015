package com.game.lib.loading
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.data.LoadData;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.system.ApplicationDomain;
	
	/**
	 * 文件加载完成事件
	 * @eventType	com.game.lib.events.LoadEvent.COMPLETE
	 */
	[Event(name = "LoadEvent_COMPLETE", type = "com.game.lib.events.LoadEvent")]
	
	/**
	 * 加载进度事件
	 * @eventType	com.game.lib.events.LoadEvent.PROGRESS
	 */
	[Event(name = "LoadEvent_PROGRESS", type = "com.game.lib.events.LoadEvent")]
	
	/**
	 * 加载出错事件
	 * @eventType	com.game.lib.events.LoadEvent.ERROR
	 */
	[Event(name = "LoadEvent_ERROR", type = "com.game.lib.events.LoadEvent")]
	
	/**
	 * 资源加载器
	 * 可加载显示对象文件：swf文件、图片文件等
	 * 可加载数据文件：xml文件、文本文件等
	 * @author Shines
	 */
	public class MyLoader extends EventDispatcher
	{
		private static const DISPLAY_OBJECT:String = "DISPLAY_OBJECT"; //显示对象
		private static const DATA:String = "DATA"; //数据对象
		
		private static var _contentList:Object = { }; //DisplayObject, *  所有已加载的内容
		private static var _addList:Object = { }; //添加列表
		
		private var _loaderList:Array = []; //LoadData, 加载列表
		private var _loaderIndex:int = 0; //当前加载位置
		private var _isLoading:Boolean = false; //是否正在加载
		private var _currentLoadData:LoadData = null; //当前加载对象
		
		public function MyLoader():void
		{
		}
		
		/**
		 * 创建当前域中指定的对象
		 * @param	name	类名
		 * @return
		 */
		public static function createObject(name:String):*
		{
			var objectClass:Class = null;
			
			if (ApplicationDomain.currentDomain.hasDefinition(name))
			{
				objectClass = ApplicationDomain.currentDomain.getDefinition(name) as Class;
				return new objectClass();
			}
			else
			{
				return null;
			}
		}
		
		/**
		 * 获取加载内容
		 * @param	url	文件名
		 * @return
		 */
		public static function getContent(url:String):*
		{
			if (hasLoaded(url))
			{
				return _contentList[url];
			}
			else
			{
				return null;
			}
		}
		
		/**
		 * 释放加载内容
		 * @param	url	文件名
		 * @return
		 */
		public static function releaseContent(url:String):void
		{
			if (hasLoaded(url))
			{
				delete _contentList[url];
			}
		}
		
		/**
		 * 是否已加载指定文件
		 * @param	url	文件名
		 * @return
		 */
		public static function hasLoaded(url:String):Boolean
		{
			if (typeof(_contentList[url]) != "undefined" && _contentList[url] != null)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * 是否已添加指定文件
		 * @param	url
		 * @return
		 */
		public static function hasAdded(url:String):Boolean
		{
			if (typeof(_addList[url]) != "undefined" && _addList[url] != null)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * 添加swf文件
		 * @param	url	文件名
		 */
		public function addSwf(url:String):void
		{
			_loaderList.push(new LoadData(url, DISPLAY_OBJECT));
			_addList[url] = url;
		}
		
		/**
		 * 添加图片文件
		 * @param	url	文件名
		 */
		public function addImage(url:String):void
		{
			_loaderList.push(new LoadData(url, DISPLAY_OBJECT));
			_addList[url] = url;
		}
		
		/**
		 * 添加xml文件
		 * @param	url	文件名
		 */
		public function addXml(url:String):void
		{
			_loaderList.push(new LoadData(url, DATA));
			_addList[url] = url;
		}
		
		/**
		 * 添加文本文件
		 * @param	url	文件名
		 */
		public function addText(url:String):void
		{
			_loaderList.push(new LoadData(url, DATA));
			_addList[url] = url;
		}
		
		/**
		 * 开始加载
		 */
		public function load():void
		{
			if (!_isLoading)
			{
				loadNext();
			}
		}
		
		/**
		 * 加载下一个文件
		 */
		private function loadNext():void
		{
			if (_loaderIndex < _loaderList.length)
			{
				_isLoading = true;
				_currentLoadData = _loaderList[_loaderIndex];
				_loaderIndex++;
				loadCurrent();
			}
		}
		
		/**
		 * 加载当前文件
		 */
		private function loadCurrent():void
		{
			var loader:* = null;
			
			switch (_currentLoadData.type)
			{
				case DISPLAY_OBJECT: 
					loader = new DisplayObjectLoader();
					break;
				case DATA: 
					loader = new DataLoader();
					break;
				default: 
			}
			loader.addEventListener(Event.COMPLETE, onComplete);
			loader.addEventListener(ProgressEvent.PROGRESS, onProgress);
			loader.addEventListener(IOErrorEvent.IO_ERROR, onError);
			loader.load(_currentLoadData.url);
		}
		
		/**
		 * 加载完成
		 * @param	e
		 */
		private function onComplete(e:Event):void
		{
			var loader:* = e.currentTarget;
			
			_contentList[_currentLoadData.url] = loader.content;
			loader.removeEventListener(Event.COMPLETE, onComplete);
			loader.removeEventListener(ProgressEvent.PROGRESS, onProgress);
			loader.removeEventListener(IOErrorEvent.IO_ERROR, onError);
			
			if (_loaderIndex >= _loaderList.length)
			{
				_isLoading = false;
				_loaderList = [];
				_loaderIndex = 0;
				this.dispatchEvent(new LoadEvent(LoadEvent.COMPLETE));
			}
			else
			{
				loadNext();
			}
		}
		
		/**
		 * 加载进度
		 * @param	e
		 */
		private function onProgress(e:ProgressEvent):void
		{
			var singlePercent:Number = 0;
			var currentRate:Number = 0;
			var totalRate:Number = 0;
			
			if (_loaderList.length != 0)
			{
				singlePercent = 1 / _loaderList.length;
			}
			if (e.bytesTotal != 0)
			{
				currentRate = e.bytesLoaded / e.bytesTotal;
			}
			totalRate = currentRate * singlePercent + (_loaderIndex - 1) * singlePercent;
			this.dispatchEvent(new LoadEvent(LoadEvent.PROGRESS, totalRate));
		}
		
		/**
		 * 加载出错
		 * @param	e
		 */
		private function onError(e:IOErrorEvent):void
		{
			var loader:* = e.currentTarget;
			
			loader.removeEventListener(Event.COMPLETE, onComplete);
			loader.removeEventListener(ProgressEvent.PROGRESS, onProgress);
			loader.removeEventListener(IOErrorEvent.IO_ERROR, onError);
			this.dispatchEvent(new LoadEvent(LoadEvent.ERROR));
		}
	}
}
