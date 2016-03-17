package com.geyaa.game
{
	import com.geyaa.game.core.Config;
	import com.geyaa.game.core.MySystem;
	import com.geyaa.lib.events.LoaderEvent;
	import com.geyaa.lib.loading.MyLoader;
	import com.geyaa.lib.MyDebug;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	
	/**
	 * 主入口
	 * @author Shines
	 */
	public class Main extends Sprite
	{
		private var _mySystem:MySystem = null;//系统管理
		
		public function Main():void
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
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			Config.init(stage);
			Config.initLoaderInfo(root.loaderInfo.parameters);
			loading();
		}
		
		/**
		 * 加载进度条资源
		 */
		private function loading():void
		{
			var myLoader:MyLoader = new MyLoader();
			
			myLoader.addEventListener(LoaderEvent.LOAD_ERROR, onLoadError);
			myLoader.addEventListener(LoaderEvent.ALL_COMPLETE, onAllComplete);
			myLoader.addSwf("swf/hall.swf");
			myLoader.load();
		}
		
		/**
		 * 加载进度条出错
		 * @param	e
		 */
		private function onLoadError(e:LoaderEvent):void 
		{
			var myLoader:MyLoader = null;
			
			myLoader = MyLoader(e.currentTarget);
			myLoader.removeEventListener(LoaderEvent.LOAD_ERROR, onLoadError);
			myLoader.removeEventListener(LoaderEvent.ALL_COMPLETE, onAllComplete);
			MyDebug.echo("Main: onLoadError()");
		}
		
		/**
		 * 加载完进度条资源
		 * 加载配置文件、主界面资源
		 * @param	e
		 */
		private function onAllComplete(e:LoaderEvent):void
		{
			var myLoader:MyLoader = null;
			
			myLoader = MyLoader(e.currentTarget);
			myLoader.removeEventListener(LoaderEvent.LOAD_ERROR, onLoadError);
			myLoader.removeEventListener(LoaderEvent.ALL_COMPLETE, onAllComplete);
			_mySystem = new MySystem();
		}
	}
}
