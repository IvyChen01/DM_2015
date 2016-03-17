package com.geyaa.game.core
{
	import flash.display.Sprite;
	import flash.display.Stage;
	
	/**
	 * 层管理
	 * 主场景上分为背景层、UI层、对话框层、调试层
	 * 静态类
	 * @author Shines
	 */
	public class MyLayer
	{
		public static var stage:Stage = null;//场景
		public static var bg:Sprite = null;//背景层
		public static var ui:Sprite = null;//UI层
		public static var dialog:Sprite = null;//对话框层
		public static var loading:Sprite = null;//加载进度层
		public static var debug:Sprite  = null;//调试层
		
		/**
		 * 初始化，创建相关层对象
		 * @param	aStage
		 */
		public static function init(aStage:Stage):void
		{
			stage = aStage;
			bg = new Sprite();
			ui = new Sprite();
			dialog = new Sprite();
			loading = new Sprite();
			debug = new Sprite();
			stage.addChild(bg);
			stage.addChild(ui);
			stage.addChild(dialog);
			stage.addChild(loading);
			stage.addChild(debug);
		}
	}
}
