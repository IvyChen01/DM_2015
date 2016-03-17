package com.geyaa.lib
{
	import com.adobe.crypto.MD5;
	import flash.events.NetStatusEvent;
	import flash.net.NetConnection;
	import flash.net.ObjectEncoding;
	import flash.net.Responder;
	
	/**
	 * Web服务端
	 * @author Shines
	 */
	public class WebAmfServer
	{
		public static var gateway:String = ""; //主网关地址
		public static var mid:int = 0; //用户id
		public static var mtkey:String = ""; //唯一key
		public static var sid:int = 0; //站点id
		public static var skey:String = ""; //协议key
		public static var vmid:int = 0; //机器ID
		public static var vkey:String = ""; //机器key
		public static var vhash:String = ""; //随机key
		public static var unid:int = 1; //学校id
		public static var flashver:Object = {}; // flash版本
		public static var adtime:Number = 0; //时间校正
		public static var langtype:int = 0; //语言类型
		
		private static var _connection:NetConnection = null; //连接对象
		private static var _isInit:Boolean = false; //是否初始化
		
		/**
		 * 请求Web数据
		 * @param	command
		 * @param	param
		 * @param	result
		 */
		public static function call(command:String, param:Object = null, success:Function = null, fail:Function = null):void
		{
			var result:Function = success; //请求成功回调
			var status:Function = fail; //请求失败回调
			
			if (!_isInit)
			{
				_connection = new NetConnection();
				_connection.objectEncoding = ObjectEncoding.AMF3;
				_connection.addEventListener(NetStatusEvent.NET_STATUS, netStatusHandler);
				_connection.connect(gateway);
				_isInit = true;
			}
			
			if (result == null)
			{
				result = resultHandler;
			}
			if (status == null)
			{
				status = statusHandler;
			}
			_connection.call(command, new Responder(result, status), genParam(param));
		}
		
		/**
		 * 分离从服务器端返回的数据
		 * @param	value
		 */
		public static function getResult(value:Object):Object
		{
			if (typeof(value["sys"]) != "undefined")
			{
				flashver.xml = value["sys"][0];
			}
			
			//时间校准
			if (typeof(value["time"]) != "undefined")
			{
				adtime = int((new Date()).valueOf() / 1000) - int(value["time"]);
			}
			
			//服务器端标志
			if (typeof(value["flag"]) != "undefined")
			{
				//
			}
			
			if (typeof(value["ret"]) != "undefined")
			{
				return value["ret"];
			}
			else
			{
				return null;
			}
		}
		
		/**
		 * 生成完整的带签名的参数
		 * @param	param
		 * @return
		 */
		private static function genParam(param:Object):Object
		{
			var result:Object = {};
			
			result["param"] = param;
			result["mid"] = mid;
			result["mtkey"] = mtkey;
			result["sid"] = sid;
			result["vmid"] = vmid;
			result["vkey"] = vkey;
			result["vhash"] = vhash;
			result["unid"] = unid;
			result["langtype"] = langtype;
			result["time"] = int((new Date()).valueOf() / 1000 - int(adtime)).toString();
			result["sig"] = MD5.hash(Utils.joins(result, mtkey, skey));
			
			return result;
		}
		
		/**
		 * 连接状态
		 * @param	e
		 */
		private static function netStatusHandler(e:NetStatusEvent):void
		{
			for (var x:Object in e.info)
			{
				trace("[error] " + x + ": " + e.info[x]);
			}
		}
		
		/**
		 * 请求成功返回
		 * @param	value
		 */
		private static function resultHandler(value:Object):void
		{
			//
		}
		
		/**
		 * 服务器出错
		 * @param	value
		 */
		private static function statusHandler(value:Object):void
		{
			for (var x:Object in value)
			{
				trace("[error] " + x + ": " + value[x]);
			}
		}
	}
}
