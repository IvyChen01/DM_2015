package com.game.lib
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundMixer;
	import flash.media.SoundTransform;
	import flash.net.URLRequest;
	import flash.system.ApplicationDomain;
	
	/**
	 * 加载完成事件
	 * @eventType	flash.events.Event.COMPLETE
	 */
	[Event(name="complete",type="flash.events.Event")]
	
	/**
	 * 声音控制
	 *
	 * @author Shines
	 */
	public class MySound extends EventDispatcher
	{
		private var _soundName:String = "";//声音名
		private var _sound:Sound = null;//声音
		private var _channel:SoundChannel = null;//控制播放/停止声音
		private var _soundTransform:SoundTransform = null;//音量控制
		private var _isLoop:Boolean = false;//是否循环播放
		private var _position:Number = 0;//播放位置
		private var _isFile:Boolean = false;//是否为声音文件(声音文件、库中导出的声音)
		private var _isLoaded:Boolean = false;//声音是否已加载
		
		/**
		 * 初始化对象
		 * @param	aSoundName	声音名
		 * @param	aIsFile	是否声音文件
		 */
		public function MySound(aSoundName:String, aIsFile:Boolean = false):void
		{
			_soundName = aSoundName;
			_isFile = aIsFile;
			if (!_isFile)
			{
				_isLoaded = true;
				_sound = Sound(createObject(_soundName));
			}
			_soundTransform = new SoundTransform();
		}
		
		/**
		 * 加载声音文件
		 */
		public function load():void
		{
			if (_isFile && !_isLoaded)
			{
				_sound = new Sound();
				_sound.addEventListener(Event.COMPLETE, onCompleteLoad);
				_sound.load(new URLRequest(_soundName));
			}
		}
		
		/**
		 * 加载声音文件完成
		 * @param	e
		 */
		private function onCompleteLoad(e:Event):void 
		{
			var sound:Sound = Sound(e.currentTarget);
			
			sound.removeEventListener(Event.COMPLETE, onCompleteLoad);
			_isLoaded = true;
			this.dispatchEvent(e);
		}
		
		/**
		 * 播放声音
		 * @param	aIsLoop
		 */
		public function play(aIsLoop:Boolean = false):void
		{
			_isLoop = aIsLoop;
			if (_isLoaded)
			{
				if (_channel != null)
				{
					_channel.stop();
				}
				if (_isLoop)
				{
					_channel = _sound.play(0, 1000000000, _soundTransform);
				}
				else
				{
					_channel = _sound.play(0, 0, _soundTransform);
				}
			}
		}
		
		/**
		 * 暂停声音
		 */
		public function pause():void
		{
			if (_isLoaded && _channel != null)
			{
				_position = _channel.position;
				_channel.stop();
			}
		}
		
		/**
		 * 继续播放声音
		 */
		public function resume():void
		{
			if (_isLoaded)
			{
				if (_channel != null)
				{
					_channel.stop();
				}
				if (_isLoop)
				{
					_channel = _sound.play(_position, 1000000000, _soundTransform);
				}
				else
				{
					_channel = _sound.play(_position, 0, _soundTransform);
				}
			}
		}
		
		/**
		 * 停止声音
		 */
		public function stop():void
		{
			if (_isLoaded && _channel != null)
			{
				_channel.stop();
				_position = 0;
			}
		}
		
		/**
		 * 创建当前域中指定的对象
		 * @param	name	类名
		 * @return
		 */
		private function createObject(name:String):*
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
		 * 当前音量
		 */
		public function get volume():Number 
		{
			if (_isLoaded && _channel != null)
			{
				return _soundTransform.volume;
			}
			
			return 0;
		}
		
		/**
		 * 当前音量
		 */
		public function set volume(value:Number):void 
		{
			if (_isLoaded && _channel != null)
			{
				_soundTransform.volume = value;
				_channel.soundTransform = _soundTransform;
			}
		}
		
		/**
		 * 全局音量
		 */
		public static function get globalVolume():Number 
		{
			return SoundMixer.soundTransform.volume;
		}
		
		/**
		 * 全局音量
		 */
		public static function set globalVolume(value:Number):void 
		{
			SoundMixer.soundTransform = new SoundTransform(value);
		}
	}
}
