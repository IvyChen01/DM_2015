package com.geyaa.game.core
{
	import com.geyaa.lib.MyDebug;
	import flash.display.Stage;
	import flash.display.StageDisplayState;
	import flash.display.StageScaleMode;
	import flash.events.EventDispatcher;
	import flash.system.Security;
	
	/**
	 * 配置数据，公共数据
	 * 静态类
	 * @author Shines
	 */
	public class Config
	{
		public static const STAGE_WIDTH:int = 450;//舞台宽
		public static const STAGE_HEIGHT:int = 450;//舞台高
		
		public static var debugEnabled:Boolean = false;//调试开关
		public static var version:String = "zhaunpan_2014.7.9";//版本号
		public static var gateway:String = "";
		public static var restTimes:int = 0;
		public static var ckey:String = "";
		
		/**
		 * 初始化配置
		 * @param	aStage
		 */
		public static function init(aStage:Stage):void
		{
			MyLayer.init(aStage);
			MyDebug.init(MyLayer.debug, MyLayer.stage, debugEnabled);
			Security.allowDomain("*");
			Security.allowInsecureDomain("*");
			//MyDebug.echo("version: " + version);
			
			//MyLayer.stage.displayState = StageDisplayState.FULL_SCREEN;
			//MyLayer.stage.scaleMode = StageScaleMode.SHOW_ALL;
		}
		
		/**
		 * 存储网页参数
		 */
		public static function initLoaderInfo(aLoaderInfo:Object):void
		{
			var str:String = '';
			var flashvars:Object = null;
			
			//version = typeof(aLoaderInfo["ver"]) != "undefined" ? aLoaderInfo["ver"] : "";
			//gateway = typeof(aLoaderInfo["gateway"]) != "undefined" ? aLoaderInfo["gateway"] : "";
			//restTimes = typeof(aLoaderInfo["lottery_count"]) != "undefined" ? int(aLoaderInfo["lottery_count"]) : 0;
			//ckey = typeof(aLoaderInfo["ckey"]) != "undefined" ? aLoaderInfo["ckey"] : "";
			//
			//MyDebug.echo("gateway: " + gateway);
			//MyDebug.echo("restTimes: " + restTimes);
			//MyDebug.echo("ckey: " + ckey);
		}
	}
}
