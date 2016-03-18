package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MySound;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	
	/**
	 * 声音控制示例
	 * @author Shines
	 */
	public class MySoundMain extends Sprite
	{
		private var _sound1:MySound = null;
		private var _sound2:MySound = null;
		
		public function MySoundMain():void
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
			_sound1 = new MySound("res_demo/croatian.mp3", true);
			_sound1.addEventListener(Event.COMPLETE, onCompleteSound);
			_sound1.load();
			
			myLoader = new MyLoader();
			myLoader.addEventListener(LoadEvent.COMPLETE, onCompleteLoad);
			myLoader.addSwf("res_demo/mysound.swf");
			myLoader.load();
			
			stage.addEventListener(KeyboardEvent.KEY_DOWN, onKeydownStage);
		}
		
		private function onCompleteSound(e:Event):void 
		{
			trace("onCompleteSound()");
			_sound1.play();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			trace("onCompleteLoad()");
			_sound2 = new MySound("res_demo.mysound.DemoSnd");
		}
		
		private function onKeydownStage(e:KeyboardEvent):void 
		{
			switch (e.keyCode)
			{
				case 49:
					//1
					_sound1.play();
					break;
				case 50:
					//2
					_sound1.pause();
					break;
				case 51:
					//3
					_sound1.resume();
					break;
				case 52:
					//4
					_sound1.stop();
					break;
				case 53:
					//5
					_sound1.volume = 0.2;
					trace("_sound1.volume: " + _sound1.volume);
					break;
				case 54:
					//6
					_sound1.volume = 1;
					trace("_sound1.volume: " + _sound1.volume);
					break;
				case 55:
					//7
					MySound.globalVolume = 0.2;
					trace("MySound.globalVolume: " + MySound.globalVolume);
					break;
				case 56:
					//8
					MySound.globalVolume = 1;
					trace("MySound.globalVolume: " + MySound.globalVolume);
					break;
				case 57:
					//9
					break;
				case 65:
					//a
					_sound2.play();
					break;
				case 66:
					//b
					_sound2.pause();
					break;
				case 67:
					//c
					_sound2.resume();
					break;
				case 68:
					//d
					_sound2.stop();
					break;
				case 69:
					//e
					_sound2.volume = 0.2;
					trace("_sound2.volume: " + _sound2.volume);
					break;
				case 70:
					//f
					_sound2.volume = 1;
					trace("_sound2.volume: " + _sound2.volume);
					break;
				case 71:
					//g
					break;
				case 72:
					//h
					break;
				default:
			}
		}
	}
}
