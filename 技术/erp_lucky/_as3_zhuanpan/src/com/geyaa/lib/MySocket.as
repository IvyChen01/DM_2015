package com.geyaa.lib
{
	import com.geyaa.lib.events.SocketEvent;
	import com.msgpack.MessagePack;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.Socket;
	import flash.utils.ByteArray;
	import flash.utils.Endian;
	
	/**
	 * 连接Socket事件
	 * @eventType	com.geyaa.lib.events.SocketEvent.CONNECT
	 */
	[Event(name = "SocketEvent_CONNECT", type = "com.geyaa.lib.events.SocketEvent")]
	
	/**
	 * 接收Socket数据事件
	 * @eventType	com.geyaa.lib.events.SocketEvent.SOCKET_DATA
	 */
	[Event(name = "SocketEvent_SOCKET_DATA", type = "com.geyaa.lib.events.SocketEvent")]
	
	/**
	 * 关闭Socket事件
	 * @eventType	com.geyaa.lib.events.SocketEvent.CLOSE
	 */
	[Event(name = "SocketEvent_CLOSE", type = "com.geyaa.lib.events.SocketEvent")]
	
	/**
	 * Socket出错事件
	 * @eventType	com.geyaa.lib.events.SocketEvent.ERROR
	 */
	[Event(name = "SocketEvent_ERROR", type = "com.geyaa.lib.events.SocketEvent")]
	
	/**
	 * Socket通信
	 * @author Shines
	 */
	public class MySocket extends EventDispatcher
	{
		private var _socket:Socket = null; //Socket
		private var _readComplete:Boolean = true; //包是否读完
		private var _bodyLength:int = 0; //包体长度
		private var _isAddEvents:Boolean = false; //是否已添加了事件
		
		public function MySocket():void
		{
			_socket = new Socket();
			_socket.timeout = 5000;//连接超时5秒
			_socket.endian = Endian.BIG_ENDIAN;
		}
		
		/**
		 * 连接服务器
		 * @param	aIp	服务器IP
		 * @param	aPort	服务器端口
		 */
		public function connect(aIp:String, aPort:int):void
		{
			addEvents();
			if (!_socket.connected)
			{
				_socket.connect(aIp, aPort);
			}
		}
		
		/**
		 * 发送数据
		 * @param	param
		 */
		public function send(param:Object):void
		{
			var msgData:ByteArray = null;
			
			if (_socket.connected)
			{
				try
				{
					msgData = MessagePack.encode(param);
					_socket.writeUnsignedInt(msgData.length);
					_socket.writeBytes(msgData);
					_socket.flush();
					msgData.clear();
					msgData = null;
				}
				catch (err:Error)
				{
					trace("[error] " + err);
				}
			}
		}
		
		/**
		 * 关闭
		 */
		public function close():void
		{
			if (_socket.connected)
			{
				_socket.close();
			}
			removeEvents();
		}
		
		/**
		 * 添加事件
		 * 侦听Socket 连接、收到数据、关闭、出错事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_socket.addEventListener(Event.CONNECT, onConnectSocket);
				_socket.addEventListener(ProgressEvent.SOCKET_DATA, onSocketData);
				_socket.addEventListener(Event.CLOSE, onCloseSocket);
				_socket.addEventListener(IOErrorEvent.IO_ERROR, onIOErrorSocket);
				_socket.addEventListener(SecurityErrorEvent.SECURITY_ERROR, onSecurityErrorSocket);
			}
		}
		
		/**
		 * 移除事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				_socket.removeEventListener(Event.CONNECT, onConnectSocket);
				_socket.removeEventListener(ProgressEvent.SOCKET_DATA, onSocketData);
				_socket.removeEventListener(Event.CLOSE, onCloseSocket);
				_socket.removeEventListener(IOErrorEvent.IO_ERROR, onIOErrorSocket);
				_socket.removeEventListener(SecurityErrorEvent.SECURITY_ERROR, onSecurityErrorSocket);
			}
		}
		
		/**
		 * 连接成功
		 * @param	e
		 */
		private function onConnectSocket(e:Event):void
		{
			this.dispatchEvent(new SocketEvent(SocketEvent.CONNECT));
		}
		
		/**
		 * 收到数据
		 * @param	e
		 */
		private function onSocketData(e:ProgressEvent):void
		{
			var receiveBytes:ByteArray = null;
			var receiveObj:Object = null;
			
			while(true)
			{
				if(_readComplete)
				{
					//读取包长度
					if(_socket.bytesAvailable >= 4)
					{
						_bodyLength = _socket.readUnsignedInt();
						_readComplete = false;
					}
					else
					{
						break;
					}
				}
				else
				{
					//读取包体
					if(_socket.bytesAvailable >= _bodyLength)
					{
						receiveBytes = new ByteArray();
						receiveBytes.endian = Endian.BIG_ENDIAN;
						_socket.readBytes(receiveBytes, 0, _bodyLength);
						try
						{
							receiveObj = Object(MessagePack.decode(receiveBytes));
						}
						catch (err:Error)
						{
							trace("[error] " + err);
						}
						this.dispatchEvent(new SocketEvent(SocketEvent.SOCKET_DATA, receiveObj));
						receiveBytes.clear();
						receiveBytes = null;
						_readComplete = true;
					}
					else
					{
						break;
					}
				}
			}
		}
		
		/**
		 * 连接关闭
		 * @param	e
		 */
		private function onCloseSocket(e:Event):void
		{
			removeEvents();
			this.dispatchEvent(new SocketEvent(SocketEvent.CLOSE));
		}
		
		/**
		 * IO错误
		 * @param	e
		 */
		private function onIOErrorSocket(e:IOErrorEvent):void 
		{
			close();
			this.dispatchEvent(new SocketEvent(SocketEvent.ERROR));
		}
		
		/**
		 * 安全沙箱错误
		 * @param	e
		 */
		private function onSecurityErrorSocket(e:SecurityErrorEvent):void 
		{
			close();
			this.dispatchEvent(new SocketEvent(SocketEvent.ERROR));
		}
		
		/**
		 * Socket是否连接
		 */
		public function get connected():Boolean
		{
			return _socket.connected;
		}
	}
}
