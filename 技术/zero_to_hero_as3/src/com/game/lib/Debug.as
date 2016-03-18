package com.game.lib
{
	import flash.display.DisplayObjectContainer;
	import flash.display.Stage;
	import flash.events.KeyboardEvent;
	import flash.text.TextField;
	import flash.text.TextFormat;
	
	/**
	 * 调试输出
	 * @author Shines
	 */
	public class Debug
	{
		private static var _container:DisplayObjectContainer = null;//显示容器
		private static var _stage:Stage = null;//场景
		private static var _enabled:Boolean = true;//是否开启调试
		private static var _debugKey:uint = 192;//调试键，~键
		private static var _debugTxt:TextField = null;//输出文本
		private static var _id:int = 0;//编号
		
		/**
		 * 创建输出文本
		 * @param	aContainer	显示容器
		 * @param	aStage	场景
		 * @param	aEnabled	是否开启调试
		 * @param	aDebugKey	调试按键，显示/隐藏
		 * @param	aTextSize	显示字体大小
		 * @param	aTextColor	显示字体颜色
		 * @param	aWidth	调试文本框宽高
		 * @param	aHeight	调试文本框高度
		 */
		public static function init(aContainer:DisplayObjectContainer, aStage:Stage, aEnabled:Boolean = true, aDebugKey:uint = 192, aTextSize:int = 18, aTextColor:int = 0x00FF00, aWidth:Number = 500, aHeight:Number = 500):void
		{
			var format:TextFormat = null;
			
			_enabled = aEnabled;
			if (_enabled && null == _stage)
			{
				_container = aContainer;
				_stage = aStage;
				_debugKey = aDebugKey;
				_debugTxt = new TextField();
				_debugTxt.width = aWidth;
				_debugTxt.height = aHeight;
				_debugTxt.wordWrap = true;
				format = new TextFormat();
				format.size = aTextSize;
				format.color = aTextColor;
				_debugTxt.defaultTextFormat = format;
				_debugTxt.text = "";
				_debugTxt.visible = false;
				_container.addChild(_debugTxt);
				_stage.addEventListener(KeyboardEvent.KEY_DOWN, onKeydownStage);
			}
		}
		
		/**
		 * 调试输出
		 * @param	value
		 */
		public static function log(value:String):void
		{
			if (_enabled)
			{
				_id++;
				value = "[" + _id.toString() + "] " + value;
				_debugTxt.appendText(value + "\n");
				_debugTxt.scrollV = _debugTxt.maxScrollV;
				trace(value);
			}
		}
		
		/**
		 * 按调试键显示/隐藏调试文本
		 * @param	e
		 */
		private static function onKeydownStage(e:KeyboardEvent):void
		{
			switch (e.keyCode)
			{
				case _debugKey: 
					_debugTxt.visible = !_debugTxt.visible;
					break;
				default: 
			}
		}
	}
}
