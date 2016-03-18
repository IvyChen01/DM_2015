package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	
	/**
	 * 加载示例
	 * @author Shines
	 */
	public class MyLoaderMain extends Sprite
	{
		public function MyLoaderMain():void
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
			var myLoader:MyLoader = new MyLoader();
			
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			myLoader.addEventListener(LoadEvent.PROGRESS, onProgressLoader);
			myLoader.addEventListener(LoadEvent.ERROR, onErrorLoader);
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteLoader);
			myLoader.addXml("res_demo/config.xml");
			myLoader.addSwf("res_demo/myloader.swf");
			myLoader.load();
		}
		
		private function onProgressLoader(e:LoadEvent):void 
		{
			trace("onProgressLoader() e.rate" + int(e.rate * 100));
		}
		
		private function onErrorLoader(e:LoadEvent):void 
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			
			trace("onErrorLoader()");
			myLoader.removeEventListener(LoadEvent.PROGRESS, onProgressLoader);
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorLoader);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteLoader);
		}
		
		private function onCompleteLoader(e:LoadEvent):void 
		{
			var myLoader:MyLoader = MyLoader(e.currentTarget);
			var xml:XML = null;
			var resMc:MovieClip = null;
			var circleMc:MovieClip = null;
			
			trace("onCompleteLoader()");
			myLoader.removeEventListener(LoadEvent.PROGRESS, onProgressLoader);
			myLoader.removeEventListener(LoadEvent.ERROR, onErrorLoader);
			myLoader.removeEventListener(LoadEvent.COMPLETE, onCompleteLoader);
			
			xml = XML(MyLoader.getContent("res_demo/config.xml"));
			trace("xml: " + xml);
			trace("mainitem: " + xml.menu.item[0].mainitem);
			trace("subitem: " + xml.menu.item[0].subitem[0]);
			trace("flag: " + xml.menu.item[0].mainitem.@flag);
			trace("all mainitem: " + xml.menu..mainitem.text());
			trace("length: " + xml.menu..mainitem.length());
			for each (var value:XML in xml.menu..mainitem)
			{
				trace("value: " + value);
			}
			
			resMc = MyLoader.getContent("res_demo/myloader.swf");
			circleMc = MyLoader.createObject("res_demo.myloader.CircleLoaderMc");
			stage.addChild(resMc);
			stage.addChild(circleMc);
			MyLoader.releaseContent("res_demo/myloader.swf");
		}
	}
}
