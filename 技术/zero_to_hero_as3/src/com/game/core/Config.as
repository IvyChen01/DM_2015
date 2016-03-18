package com.game.core
{
	import com.game.lib.loading.MyLoader;
	import com.game.lib.Debug;
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
		public static const STAGE_WIDTH:int = 810;//舞台宽
		public static const STAGE_HEIGHT:int = 654;//舞台高
		
		public static var configType:int = 0;//配置方案
		public static var debugEnabled:Boolean = false;//调试开关
		public static var version:String = "2015.7.6_11.04";//版本号
		public static var dispatcher:EventDispatcher = new EventDispatcher();//事件发生器
		public static var progressUrl:String = "";//加载资源文件
		public static var hallUrl:String = "";//大厅资源文件
		public static var uploadUrl:String = "";
		
		/**
		 * 初始化配置
		 * @param	aStage
		 */
		public static function init(aStage:Stage):void
		{
			Layer.init(aStage);
			Debug.init(Layer.debug, Layer.stage, debugEnabled);
			Security.allowDomain("*");
			Security.allowInsecureDomain("*");
			//Layer.stage.displayState = StageDisplayState.FULL_SCREEN;
			//Layer.stage.scaleMode = StageScaleMode.SHOW_ALL;
			initLoaderInfo();
			switch (configType)
			{
				case 0:
					//default
					progressUrl = "progress.swf" + "?v=" + version;
					hallUrl = "hall.swf" + "?v=" + version;
					uploadUrl = "http://localhost:8008/?m=fbzero&a=upload";
					break;
				case 1:
					//localhost
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://localhost:8008/?m=fbzero&a=upload";
					break;
				case 2:
					//qumuwu
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://zero.infinixmobility.qumuwu.com/?m=fbzero&a=upload";
					break;
				case 3:
					//infinixmobility
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/zerotohero/?m=fbzero&a=upload";
					break;
				case 4:
					//infinixzero
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/infinixzero/?m=fbzero&a=upload";
					break;
				case 5:
					//尼日利亚
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/ngzero/?m=fbzero&a=upload";
					break;
				case 6:
					//肯尼亚
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/kezero/?m=fbzero&a=upload";
					break;
				case 7:
					//埃及
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/egzero/?m=fbzero&a=upload";
					break;
				case 8:
					//沙特
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/sazero/?m=fbzero&a=upload";
					break;
				case 9:
					//巴基斯坦
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/pkzero/?m=fbzero&a=upload";
					break;
				case 10:
					//巴基斯坦
					progressUrl = "swf/progress.swf" + "?v=" + version;
					hallUrl = "swf/hall.swf" + "?v=" + version;
					uploadUrl = "http://www.infinixmobility.com/fb/idzero/?m=fbzero&a=upload";
					break;
				default:
			}
			
			Debug.log("Config: version: " + version);
			Debug.log("Config: progressUrl: " + progressUrl);
			Debug.log("Config: hallUrl: " + hallUrl);
			Debug.log("Config: uploadUrl: " + uploadUrl);
		}
		
		/**
		 * 存储网页参数
		 */
		private static function initLoaderInfo():void
		{
			var loaderInfo:Object = Layer.stage.loaderInfo.parameters;
			
			configType = typeof(loaderInfo["type"]) != "undefined" ? loaderInfo["type"] : 0;
			Debug.log("Config: configType: " + configType);
		}
	}
}
