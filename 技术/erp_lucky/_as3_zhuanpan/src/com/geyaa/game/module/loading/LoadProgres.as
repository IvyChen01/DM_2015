package com.geyaa.game.module.loading
{
	import com.geyaa.game.core.MyLayer;
	import com.geyaa.lib.loading.MyLoader;
	import flash.display.MovieClip;
	
	/**
	 * 加载进度
	 * @author Shines
	 */
	public class LoadProgres
	{
		private var _content:MovieClip = null;//元件
		
		public function LoadProgres():void
		{
			var mc:MovieClip = MyLoader.createObject("res.loading.LoadingMc");
			
			_content = mc["content"];
			_content.gotoAndStop(1);
		}
		
		/**
		 * 显示进度条
		 */
		public function show():void
		{
			_content.visible = true;
			if (null == _content.parent)
			{
				MyLayer.loading.addChild(_content);
			}
		}
		
		/**
		 * 隐藏进度条
		 */
		public function hide():void
		{
			_content.visible = false;
			if (_content.parent != null)
			{
				_content.parent.removeChild(_content);
			}
		}
		
		/**
		 * 设置进度
		 * @param	aProgress	[0, 100]
		 */
		public function setProgress(aProgress:int):void
		{
			if (aProgress > 100)
			{
				aProgress = 100;
			}
			if (aProgress < 0)
			{
				aProgress = 0;
			}
			_content.gotoAndStop(aProgress + 1);
		}
	}
}
