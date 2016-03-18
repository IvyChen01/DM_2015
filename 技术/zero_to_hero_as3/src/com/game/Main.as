package com.game
{
	import com.game.core.Config;
	import com.game.core.Module;
	import com.game.lib.Debug;
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.module.hall.HallMain;
	import com.game.module.loading.LoadProgress;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	
	/**
	 * 主入口
	 * @author Shines
	 */
	public class Main extends Sprite
	{
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
			loadProgressRes();
		}
		
		/**
		 * 加载进度条资源文件
		 */
		private function loadProgressRes():void
		{
			var myLoader:MyLoader = new MyLoader();
			
			myLoader.addEventListener(LoadEvent.ERROR, onErrorProgressRes);
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteProgressRes);
			myLoader.addSwf(Config.progressUrl);
			myLoader.load();
		}
		
		/**
		 * 加载进度条资源文件出错
		 * @param	e
		 */
		private function onErrorProgressRes(e:LoadEvent):void 
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorProgressRes);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteProgressRes);
			Debug.log("Main: onErrorProgressRes()");
		}
		
		/**
		 * 加载完进度条资源文件
		 * 加载大厅等相关资源文件
		 * @param	e
		 */
		private function onCompleteProgressRes(e:LoadEvent):void 
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorProgressRes);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteProgressRes);
			Module.progress = new LoadProgress();
			Module.progress.setProgress(0);
			Module.progress.show();
			loadMain();
		}
		
		/**
		 * 加载大厅等相关资源文件
		 */
		private function loadMain():void
		{
			var myLoader:MyLoader = new MyLoader();
			
			myLoader.addEventListener(LoadEvent.PROGRESS, onProgressMain);
			myLoader.addEventListener(LoadEvent.ERROR, onErrorMain);
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteMain);
			myLoader.addSwf(Config.hallUrl);
			myLoader.load();
		}
		
		/**
		 * 加载大厅等相关资源文件进度
		 * @param	e
		 */
		private function onProgressMain(e:LoadEvent):void 
		{
			Debug.log("Main: e.rate: " + int(e.rate * 100));
			Module.progress.setProgress(int(e.rate * 100));
		}
		
		/**
		 * 加载大厅等相关资源文件出错
		 * @param	e
		 */
		private function onErrorMain(e:LoadEvent):void 
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			
			myLoader.removeEventListener(LoadEvent.PROGRESS, onProgressMain);
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorMain);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteMain);
			Debug.log("Main: onErrorMain()");
		}
		
		/**
		 * 加载完大厅等相关资源文件
		 * 进入主程序
		 * @param	e
		 */
		private function onCompleteMain(e:LoadEvent):void
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			
			myLoader.removeEventListener(LoadEvent.PROGRESS, onProgressMain);
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorMain);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteMain);
			Module.progress.hide();
			Module.hall = new HallMain();
			Module.hall.show();
		}
	}
}
