package
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundTransform;
	import flash.net.URLRequest;
	import flash.system.ApplicationDomain;
	
	/**
	 * 加载完成事件
	 * @eventType	flash.events.Event.COMPLETE
	 */
	[Event(name = "complete", type = "flash.events.Event")]
	
	/**
	 * 声音管理
	 * @author Shines
	 */
	public class SoundManager extends EventDispatcher
	{
		private static var _volume:Number = 1; //音量
		private static var _soundList:Object = new Object(); //声音列表
		private static var _soundChannel:Object = new Object(); //声音控制
		private static var _soundPosition:Object = new Object(); //声音进度
		
		/**
		 * 加载声音文件
		 * @param	soundName  声音文件名
		 */
		public function load(soundName:String):void
		{
			var sound:SoundInfo = null;
			
			if (!_soundList.hasOwnProperty(soundName))
			{
				sound = new SoundInfo();
				sound.soundPath = soundName;
				sound.addEventListener(Event.COMPLETE, onCompleteSound);
				try
				{
					sound.load(new URLRequest(soundName));
				}
				catch (err:Error)
				{
					trace("[error] " + err);
				}
			}
		}
		
		/**
		 * 加载声音完成
		 * @param	event  事件
		 */
		protected function onCompleteSound(event:Event):void
		{
			var sound:SoundInfo = SoundInfo(event.currentTarget);
			
			_soundList[sound.soundPath] = sound;
			dispatchEvent(event);
		}
		
		/**
		 * 播放声音
		 * @param	soundName  声音文件名
		 * @param	isLoop  是否循环
		 * @param	loopCount  循环次数
		 */
		public static function playSound(soundName:String, isLoop:Boolean = false, loopCount:int = 0):void
		{
			var sound:SoundInfo = null; //声音
			var channel:SoundChannel = null; //控制播放/停止声音
			var soundTransform:SoundTransform = new SoundTransform(_volume); //音量控制
			
			if (_soundList.hasOwnProperty(soundName))
			{
				sound = _soundList[soundName];
				if (_soundChannel.hasOwnProperty(soundName))
				{
					channel = _soundChannel[soundName];
				}
				else
				{
					channel = new SoundChannel();
					_soundChannel[soundName] = channel;
				}
				
				if (isLoop)
				{
					if (loopCount <= 0)
					{
						if (_soundPosition.hasOwnProperty(soundName))
						{
							channel = sound.play(_soundPosition[soundName], 1000000, soundTransform);
						}
						else
						{
							channel = sound.play(0, 1000000, soundTransform);
						}
					}
					else
					{
						if (_soundPosition.hasOwnProperty(soundName))
						{
							channel = sound.play(_soundPosition[soundName], loopCount, soundTransform);
						}
						else
						{
							channel = sound.play(0, loopCount, soundTransform);
						}
					}
				}
				else
				{
					if (_soundPosition.hasOwnProperty(soundName))
					{
						channel = sound.play(_soundPosition[soundName], 1, soundTransform);
					}
					else
					{
						channel = sound.play(0, 1, soundTransform);
					}
				}
			}
		}
		
		/**
		 * 播放声音
		 * @param	soundName  声音文件名
		 * @param	isLoop  是否循环
		 * @param	loopCount  循环次数
		 */
		public static function play(soundName:String, isLoop:Boolean = false, loopCount:int = 0):void
		{
			var sound:Sound = getSound(soundName);
			var channel:SoundChannel; //控制播放/停止声音
			var soundTransform:SoundTransform = new SoundTransform(_volume); //音量控制
			
			if (_soundChannel.hasOwnProperty(soundName))
			{
				channel = _soundChannel[soundName];
			}
			else
			{
				channel = new SoundChannel();
				_soundChannel[soundName] = channel;
			}
			
			if (isLoop)
			{
				if (loopCount <= 0)
				{
					channel = sound.play(0, 1000000, soundTransform);
				}
				else
				{
					channel = sound.play(0, loopCount, soundTransform);
				}
			}
			else
			{
				channel = sound.play(0, 1, soundTransform);
			}
		}
		
		/**
		 * 暂停播放声音
		 * @param	soundName	声音文件名
		 */
		public static function pauseSound(soundName:String):void
		{
			if (_soundChannel.hasOwnProperty(soundName))
			{
				_soundPosition[soundName] = (_soundChannel[soundName] as SoundChannel).position;
				(_soundChannel[soundName] as SoundChannel).stop();
			}
		}
		
		/**
		 * 停止播放声音
		 * @param	soundName	声音文件名
		 */
		public static function stopSound(soundName:String):void
		{
			if (_soundChannel.hasOwnProperty(soundName))
			{
				(_soundChannel[soundName] as SoundChannel).stop();
				_soundPosition[soundName] = 0;
			}
		}
		
		/**
		 * 停止播放所有声音
		 */
		public static function stopAllSounds():void
		{
			for (var soundName:String in _soundChannel)
			{
				(_soundChannel[soundName] as SoundChannel).stop();
				_soundPosition[soundName] = 0;
			}
		}
		
		/**
		 * 获取声音
		 * @param	soundName	声音文件名
		 * @return
		 */
		private static function getSound(soundName:String):Sound
		{
			var sound:Sound = null; //声音
			
			try
			{
				//声音是否在缓存区
				if (_soundList.hasOwnProperty(soundName))
				{
					sound = _soundList[soundName];
				}
				else
				{
					sound = new (ApplicationDomain.currentDomain.getDefinition(soundName) as Class)();
					_soundList[soundName] = sound;
				}
			}
			catch (e:ReferenceError)
			{
				return null;
			}
			
			return sound;
		}
		
		/**
		 * 设置音量
		 * @param	value	音量大小 [0-1]
		 */
		public static function setVolume(value:Number):void
		{
			if (value >= 0 && value <= 1)
			{
				_volume = value;
				for (var i:String in _soundChannel)
				{
					var newSoundTransform:SoundTransform = (_soundChannel[i] as SoundChannel).soundTransform;
					
					newSoundTransform.volume = _volume;
					(_soundChannel[i] as SoundChannel).soundTransform = newSoundTransform;
				}
			}
		}
		
		/**
		 * 获取音量大小
		 */
		public static function getVolume():Number
		{
			return _volume;
		}
	}
}
