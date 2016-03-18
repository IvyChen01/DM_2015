package com.game.module.loading
{
	import com.game.core.Layer;
	import com.game.lib.loading.MyLoader;
	import flash.display.MovieClip;
	import flash.text.TextField;
	
	/**
	 * 加载进度
	 * @author Shines
	 */
	public class LoadProgress
	{
		private var _content:MovieClip = null;//元件
		private var _progressMc:MovieClip = null;//进度条
		private var _rateTxt:TextField = null;
		
		public function LoadProgress():void
		{
			_content = MovieClip(MyLoader.createObject("progress.ProgressMc"));
			_content.gotoAndStop(1);
			_progressMc = _content["progressMc"];
			_progressMc.gotoAndStop(1);
			_rateTxt = _content["rateTxt"];
			_rateTxt.text = "0%";
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			if (null == _content.parent)
			{
				Layer.loading.addChild(_content);
			}
		}
		
		/**
		 * 隐藏
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
			_progressMc.gotoAndStop(aProgress + 1);
			_rateTxt.text = aProgress.toString() + "%";
		}
	}
}
