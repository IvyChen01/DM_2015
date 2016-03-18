package com.game.demo
{
	import com.game.lib.events.LoadEvent;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.scrollbar.ScrollBar;
	import com.game.lib.Slider;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	
	/**
	 * 滚动条、滑动示例
	 * @author Shines
	 */
	public class ScrollBarSliderMain extends Sprite
	{
		private var _hScrollBar:ScrollBar = null;
		private var _vScrollBar:ScrollBar = null;
		private var _hSlider:Slider = null;
		private var _vSlider:Slider = null;
		private var _hScrollView:MovieClip = null;
		private var _vScrollView:MovieClip = null;
		
		public function ScrollBarSliderMain():void
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
			myLoader.addSwf("res_demo/scrollbar_slider.swf");
			myLoader.load();
		}
		
		private function onCompleteLoad(e:LoadEvent):void 
		{
			var mc:MovieClip = null;
			
			mc = MovieClip(MyLoader.createObject("res_demo.scrollbar_slider.DemoMc"));
			stage.addChild(mc);
			_hScrollView = mc["hScrollView"];
			_hScrollBar = new ScrollBar(mc["hScrollBar"], stage, ScrollBar.HORIZONTAL, 20);
			_hScrollBar.addEventListener(Event.CHANGE, onChangeHScroll);
			_hScrollBar.maskLen = _hScrollView["mask"].width;
			_hScrollBar.listLen = _hScrollView["bg"].width;
			_hScrollBar.addWheelListener(_hScrollView);
			
			_vScrollView = mc["vScrollView"];
			_vScrollBar = new ScrollBar(mc["vScrollBar"], stage, ScrollBar.VERTICAL, 20);
			_vScrollBar.addEventListener(Event.CHANGE, onChangeVScroll);
			_vScrollBar.maskLen = _vScrollView["mask"].height;
			_vScrollBar.listLen = _vScrollView["bg"].height;
			_vScrollBar.addWheelListener(_vScrollView);
			
			_hSlider = new Slider(_hScrollView, stage, Slider.HORIZONTAL);
			_hSlider.addEventListener(Event.CHANGE, onChangeHSlider);
			_hSlider.sliderLength = _hScrollView["bg"].width - _hScrollView["mask"].width;
			
			_vSlider = new Slider(_vScrollView, stage, Slider.VERTICAL);
			_vSlider.addEventListener(Event.CHANGE, onChangeVSlider);
			_vSlider.sliderLength = _vScrollView["bg"].height - _vScrollView["mask"].height;
		}
		
		private function onChangeHScroll(e:Event):void 
		{
			_hScrollView["bg"].x = -_hScrollBar.currentPlace;
			_hSlider.reset();
			_hSlider.currentPlace = -_hScrollBar.currentPlace;
		}
		
		private function onChangeVScroll(e:Event):void 
		{
			_vScrollView["bg"].y = -_vScrollBar.currentPlace;
			_vSlider.reset();
			_vSlider.currentPlace = -_vScrollBar.currentPlace;
		}
		
		private function onChangeHSlider(e:Event):void 
		{
			_hScrollView["bg"].x = _hSlider.currentPlace;
			_hScrollBar.currentPlace = -_hSlider.currentPlace;
		}
		
		private function onChangeVSlider(e:Event):void 
		{
			_vScrollView["bg"].y = _vSlider.currentPlace;
			_vScrollBar.currentPlace = -_vSlider.currentPlace;
		}
	}
}
