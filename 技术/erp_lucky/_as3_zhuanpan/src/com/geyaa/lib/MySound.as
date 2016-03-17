package com.geyaa.lib
{
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundMixer;
	import flash.media.SoundTransform;
	import flash.system.ApplicationDomain;
	
	/**
	 * 声音播放
	 * 示例：MySound.play("BgSound");
	 *
	 * 待调试
	 *
	 * @author Shines
	 */
	public class MySound
	{
		private static var _volume:Number = 1; //音量
		private static var _soundList:Object = new Object(); //声音列表
		private static var _soundChannel:Object = new Object();
		
		/**
		 * 播放声音
		 * @param	soundName  声音类型
		 * @param	isLoop  是否循环
		 * @param	loopCount  循环次数
		 */
		public static function play(soundName:String, isLoop:Boolean = false, loopCount:int = 0):void
		{
			var sound:Sound = getSound(soundName);
			var channel:SoundChannel; //控制播放/停止声音
			var soundTransform:SoundTransform = new SoundTransform(_volume); //音量控制
			
			//if (_soundChannel.hasOwnProperty(soundName))
			//{
			//channel = _soundChannel[soundName];
			//}
			//else
			//{
			//channel = new SoundChannel();
			//_soundChannel[soundName] = channel;
			//}
			
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
			
			_soundChannel[soundName] = channel;
		}
		
		/**
		 * 停止播放声音
		 * @param	soundName
		 */
		public static function stop(soundName:String):void
		{
			if (_soundChannel.hasOwnProperty(soundName))
			{
				(_soundChannel[soundName] as SoundChannel).stop();
			}
		}
		
		/**
		 * 获取声音
		 * @param	soundClass
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
			catch (err:Error)
			{
				trace("[error] " + err);
				return null;
			}
			return sound;
		}
		
		/**
		 * 设置音量
		 * @param	value
		 */
		public static function setVolume(soundName:String, volume:Number):void
		{
			//////////// 待调试
			//////////// 是否要改为 (_soundChannel[i] as SoundChannel).soundTransform = newSoundTransform 的形式
			if (_soundChannel.hasOwnProperty(soundName))
			{
				(_soundChannel[soundName] as SoundChannel).soundTransform.volume = volume;
			}
		
			//var newSoundTransform:SoundTransform = (_soundChannel[i] as SoundChannel).soundTransform;
			//newSoundTransform.volume = _volume;
			//(_soundChannel[i] as SoundChannel).soundTransform = newSoundTransform;
		}
		
		/**
		 * 设置音量
		 * @param	value
		 */
		public static function getVolume(soundName:String):void
		{
			//////////// 待调试
			if (_soundChannel.hasOwnProperty(soundName))
			{
				return (_soundChannel[soundName] as SoundChannel).soundTransform.volume;
			}
		}
		
		/**
		 * 设置全局音量
		 * @param	value
		 */
		public static function setGlobalVolume(value:Number):void
		{
			//SoundMixer.soundTransform = new SoundTransform(value);
			
			/////////////////// 待调试
			SoundMixer.soundTransform.volume = value;
		}
		
		/**
		 * 设置全局音量
		 * @param	value
		 */
		public static function getGlobalVolume():void
		{
			/////////////////// 待调试
			return SoundMixer.soundTransform.volume;
		}
		
		/////////////////////// 以下待调试
		
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
		 * 加载声音文件
		 * @param	soundName
		 */
		public function load(soundName:String):void
		{
			//
		}
	}
}
