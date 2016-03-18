package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MyButton;
	import com.game.lib.MyVideo;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	/**
	 * 视频播放示例
	 * @author Shines
	 */
	public class MyVideoMain extends Sprite
	{
		private var _myVideo:MyVideo = null;
		private var _playBtn:MyButton = null;
		private var _pauseBtn:MyButton = null;
		private var _backBtn:MyButton = null;
		private var _forwardBtn:MyButton = null;
		
		public function MyVideoMain():void
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
			myLoader.addSwf("res_demo/myvideo.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.myvideo.DemoMc"));
			stage.addChild(mc);
			_myVideo = new MyVideo(mc["container"], 910, 550);
			_playBtn = new MyButton(mc["playBtn"]);
			_pauseBtn = new MyButton(mc["pauseBtn"]);
			_backBtn = new MyButton(mc["backBtn"]);
			_forwardBtn = new MyButton(mc["forwardBtn"]);
			
			_playBtn.addEventListener(MouseEvent.CLICK, onClickPlay);
			_pauseBtn.addEventListener(MouseEvent.CLICK, onClickPause);
			_backBtn.addEventListener(MouseEvent.CLICK, onClickBack);
			_forwardBtn.addEventListener(MouseEvent.CLICK, onClickForward);
			stage.addEventListener(Event.ENTER_FRAME, onEnterFrameStage);
			_myVideo.playVideo("res_demo/video.mp4");
		}
		
		private function onClickPlay(e:MouseEvent):void 
		{
			_myVideo.resume();
		}
		
		private function onClickPause(e:MouseEvent):void 
		{
			_myVideo.pause();
		}
		
		private function onClickBack(e:MouseEvent):void 
		{
			if (_myVideo.currentTime - 2 > 0)
			{
				_myVideo.seek(_myVideo.currentTime - 2);
			}
			else
			{
				_myVideo.seek(0);
			}
		}
		
		private function onClickForward(e:MouseEvent):void 
		{
			if (_myVideo.currentTime + 2 < _myVideo.videoLength)
			{
				_myVideo.seek(_myVideo.currentTime + 2);
			}
			else
			{
				_myVideo.seek(_myVideo.videoLength - 1);
			}
		}
		
		private function onEnterFrameStage(e:Event):void 
		{
			if (_myVideo.videoLength > 0 && _myVideo.currentTime >= _myVideo.videoLength - 1)
			{
				_myVideo.seek(0);
			}
		}
	}
}
