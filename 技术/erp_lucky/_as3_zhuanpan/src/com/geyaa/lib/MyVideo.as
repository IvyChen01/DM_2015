package com.geyaa.lib
{
	import flash.display.DisplayObjectContainer;
	import flash.events.AsyncErrorEvent;
	import flash.events.Event;
	import flash.events.NetStatusEvent;
	import flash.media.Video;
	import flash.net.NetConnection;
	import flash.net.NetStream;
	
	/**
	 * 视频播放
	 * @author Shines
	 */
	public class MyVideo
	{
		private var _container:DisplayObjectContainer = null; //视频容器
		private var _maxTime:Number = 0; //视频时长
		private var _videoWidth:Number = 0; //视频宽
		private var _videoHeight:Number = 0; //视频高
		private var _netConnection:NetConnection = null;
		private var _netStream:NetStream = null;
		private var _video:Video = null;
		
		/**
		 * 构造
		 * @param	aContainer	视频容器
		 * @param	aVideoWidth	视频宽
		 * @param	aVideoHeight	视频高
		 */
		public function MyVideo(aContainer:DisplayObjectContainer, aVideoWidth:Number = 550, aVideoHeight:Number = 400):void
		{
			_container = aContainer;
			_videoWidth = aVideoWidth;
			_videoHeight = aVideoHeight;
			init();
		}
		
		/**
		 * 创建相关对象
		 */
		private function init():void
		{
			_netConnection = new NetConnection();
			_netConnection.connect(null);
			//_netConnection.connect("http://localhost/test2");
			_netStream = new NetStream(_netConnection);
			_netStream.client = this;
			_netStream.addEventListener(NetStatusEvent.NET_STATUS, onNetstatus);
			_netStream.addEventListener(AsyncErrorEvent.ASYNC_ERROR, onAsyncerror);
			
			_video = new Video();
			_video.attachNetStream(_netStream);
			_video.width = _videoWidth;
			_video.height = _videoHeight;
			_container.addChild(_video);
		}
		
		/**
		 * 播放视频文件
		 * @param	videoName
		 */
		public function playVideo(videoName:String):void
		{
			_netStream.play(videoName);
		}
		
		/**
		 * 视频跳转到指定时间
		 * @param	value
		 */
		public function seek(value:Number):void
		{
			_netStream.seek(value);
		}
		
		/**
		 * 暂停
		 */
		public function pause():void
		{
			_netStream.pause();
		}
		
		/**
		 * 继续播放
		 */
		public function resume():void
		{
			_netStream.resume();
		}
		
		/**
		 * 视频当前播放时间
		 */
		public function get currentTime():Number
		{
			return _netStream.time;
		}
		
		/**
		 * 视频总长度
		 */
		public function get videoLength():Number
		{
			return _maxTime;
		}
		
		/**
		 * 设置视频尺寸
		 * @param	aVideoWidth
		 * @param	aVideoHeight
		 */
		public function setSize(aVideoWidth:Number, aVideoHeight:Number):void
		{
			_videoWidth = aVideoWidth;
			_videoHeight = aVideoHeight;
			_video.width = _videoWidth;
			_video.height = _videoHeight;
		}
		
		/**
		 * 获取视频时长
		 * @param	infoObject
		 */
		public function onMetaData(infoObject:Object):void
		{
			_maxTime = infoObject.duration;
		}
		
		private function onNetstatus(e:NetStatusEvent):void
		{
			switch (e.info.code)
			{
				case "NetStream.Play.Start": 
					//trace("Start [" + _netStream.time.toFixed(3) + " seconds]");
					break;
				case "NetStream.Play.Stop": 
					//trace("Stop [" + _netStream.time.toFixed(3) + " seconds]");
					break;
				default: 
			}
		}
		
		private function onAsyncerror(e:AsyncErrorEvent):void
		{
			trace("onAsyncerror: " + e.text);
		}
	}
}
