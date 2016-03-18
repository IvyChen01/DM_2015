package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.events.SocketEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MySocket;
	import flash.display.MovieClip;
	import flash.display.SimpleButton;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	/**
	 * Socket通信示例
	 * @author Shines
	 */
	public class MySocketMain extends Sprite
	{
		private var _mySocket:MySocket = null;
		private var _testBtn:SimpleButton = null;
		
		public function MySocketMain():void
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
			myLoader.addSwf("res_demo/mysocket.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.mysocket.DemoMc"));
			stage.addChild(mc);
			_mySocket = new MySocket();
			_mySocket.addEventListener(SocketEvent.CONNECT, onConnectSocket);
			_mySocket.addEventListener(SocketEvent.SOCKET_DATA, onSocketData);
			_mySocket.addEventListener(SocketEvent.CLOSE, onCloseSocket);
			_mySocket.addEventListener(SocketEvent.ERROR, onErrorSocket);
			_mySocket.connect("192.168.0.1", 8000);
			_testBtn = mc["testBtn"];
			_testBtn.addEventListener(MouseEvent.CLICK, onClickTest);
		}
		
		private function onConnectSocket(e:SocketEvent):void 
		{
			trace("onConnectSocket()");
		}
		
		private function onSocketData(e:SocketEvent):void 
		{
			trace("onSocketData()");
			if (e.param != null)
			{
				trace("e.param: " + e.param["cmd"]);
			}
		}
		
		private function onCloseSocket(e:SocketEvent):void 
		{
			trace("onCloseSocket()");
		}
		
		private function onErrorSocket(e:SocketEvent):void 
		{
			trace("onErrorSocket()");
		}
		
		private function onClickTest(e:MouseEvent):void 
		{
			_mySocket.send( { cmd: "test" } );
		}
	}
}
