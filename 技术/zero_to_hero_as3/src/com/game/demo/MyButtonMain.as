package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	/**
	 * 按钮示例
	 * @author Shines
	 */
	public class MyButtonMain extends Sprite
	{
		private var _myButton:MyButton = null;
		
		public function MyButtonMain():void
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
			var myLoader:MyLoader = null;
			
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			myLoader = new MyLoader();
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteLoad);
			myLoader.addSwf("res_demo/mybutton.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = MovieClip(MyLoader.createObject("res_demo.mybutton.DemoMc"));
			stage.addChild(mc);
			_myButton = new MyButton(mc["myButton"]);
			_myButton.addEventListener(MouseEvent.CLICK, onClickButton);
			_myButton.addEventListener(MouseEvent.ROLL_OVER, onOverButton);
			_myButton.addEventListener(MouseEvent.ROLL_OUT, onOutButton);
			_myButton.addEventListener(MouseEvent.MOUSE_DOWN, onDownButton);
			_myButton.addEventListener(MouseEvent.MOUSE_UP, onUpButton);
			_myButton.label = "按钮";
			_myButton.setLabelColor(0xFFFF00, 0x00FF00, 0x00FFFF, 0x000000);
		}
		
		private function onClickButton(e:MouseEvent):void 
		{
			trace("onClickButton()");
			_myButton.enabled = false;
		}
		
		private function onOverButton(e:MouseEvent):void 
		{
			trace("onOverButton()");
		}
		
		private function onOutButton(e:MouseEvent):void 
		{
			trace("onOutButton()");
		}
		
		private function onDownButton(e:MouseEvent):void 
		{
			trace("onDownButton()");
		}
		
		private function onUpButton(e:MouseEvent):void 
		{
			trace("onUpButton()");
		}
	}
}
