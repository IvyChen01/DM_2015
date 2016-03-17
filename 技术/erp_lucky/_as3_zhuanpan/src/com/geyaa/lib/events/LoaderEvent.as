package com.geyaa.lib.events
{
	import flash.events.Event;
	
	/**
	 * 加载事件
	 * @author Shines
	 */
	public class LoaderEvent extends Event
	{
		public static const ALL_COMPLETE:String = "LoaderEvent_ALL_COMPLETE"; //全部文件加载完成
		public static const CURRENT_COMPLETE:String = "LoaderEvent_CURRENT_COMPLETE"; //当前文件加载完成
		public static const LOAD_PROGRESS:String = "LoaderEvent_LOAD_PROGRESS"; //加载进度
		public static const LOAD_ERROR:String = "LoaderEvent_LOAD_ERROR"; //加载出错
		
		public var currentFile:String = ""; //当前文件名
		public var loaderIndex:int = 0; //当前加载位置
		public var totalLoader:int = 0; //总加载文件个数
		public var currentRate:Number = 0; //当前文件加载进度
		public var totalRate:Number = 0; //全部文件加载总进度
		
		/**
		 * 构造事件
		 * @param	aType	事件名称
		 * @param	aCurrentFile	当前文件名
		 * @param	aLoaderIndex	当前加载位置
		 * @param	aTotalLoader	总加载文件个数
		 * @param	aCurrentRate	当前文件加载进度
		 * @param	aTotalRate	全部文件加载总进度
		 */
		public function LoaderEvent(aType:String, aCurrentFile:String = "", aLoaderIndex:int = 0, aTotalLoader:int = 0, aCurrentRate:Number = 0, aTotalRate:Number = 0):void
		{
			super(aType);
			currentFile = aCurrentFile;
			loaderIndex = aLoaderIndex;
			totalLoader = aTotalLoader;
			currentRate = aCurrentRate;
			totalRate = aTotalRate;
		}
		
		override public function clone():Event
		{
			return new LoaderEvent(this.type, currentFile, loaderIndex, totalLoader, currentRate, totalRate);
		}
	}
}
