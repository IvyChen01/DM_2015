package com.game.module.hall
{
	import com.game.lib.Debug;
	import flash.display.DisplayObject;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.FocusEvent;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	import flash.text.TextFormat;
	
	/**
	 * 大厅模块
	 * @author Shines
	 */
	public class Photo
	{
		private const DEFAULT_TXT:String = "say something about the picture...";
		private const FORMAT_LEFT_SRC:Number = 0x666666;
		private const FORMAT_LEFT_NEW:Number = 0x000000;
		private const FORMAT_RIGHT_SRC:Number = 0x999999;
		private const FORMAT_RIGHT_NEW:Number = 0x000000;
		
		private var _content:MovieClip = null;//元件
		private var _photoBg:MovieClip = null;
		private var _photo1:MovieClip = null;
		private var _photo2:MovieClip = null;
		private var _leftTxt:TextField = null;
		private var _rightTxt:TextField = null;
		private var _format:TextFormat = null;
		
		public function Photo(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_photoBg = _content["photoBg"];
			_photo1 = _content["photo1"];
			_photo2 = _content["photo2"];
			_photoBg.gotoAndStop(1);
			_photo1.gotoAndStop(1);
			_photo2.gotoAndStop(1);
			_leftTxt = _content["leftTxt"];
			_rightTxt = _content["rightTxt"];
			
			_format = new TextFormat();
			_format.color = FORMAT_LEFT_SRC;
			_leftTxt.defaultTextFormat = _format;
			_leftTxt.setTextFormat(_format);
			_format.color = FORMAT_RIGHT_SRC;
			_rightTxt.defaultTextFormat = _format;
			_rightTxt.setTextFormat(_format);
			
			_leftTxt.addEventListener(FocusEvent.FOCUS_IN, onInLeft);
			_leftTxt.addEventListener(FocusEvent.FOCUS_OUT, onOutLeft);
			_rightTxt.addEventListener(FocusEvent.FOCUS_IN, onInRight);
			_rightTxt.addEventListener(FocusEvent.FOCUS_OUT, onOutRight);
		}
		
		public function fixText():void
		{
			if (DEFAULT_TXT == _leftTxt.text)
			{
				_leftTxt.visible = false;
			}
			if (DEFAULT_TXT == _rightTxt.text)
			{
				_rightTxt.visible = false;
			}
		}
		
		public function showText():void
		{
			_leftTxt.visible = true;
			_rightTxt.visible = true;
		}
		
		private function onInLeft(e:FocusEvent):void 
		{
			if (DEFAULT_TXT == _leftTxt.text)
			{
				_leftTxt.text = "";
				_format.color = FORMAT_LEFT_NEW;
				_leftTxt.defaultTextFormat = _format;
				_leftTxt.setTextFormat(_format);
			}
		}
		
		private function onOutLeft(e:FocusEvent):void 
		{
			if ("" == _leftTxt.text)
			{
				_leftTxt.text = DEFAULT_TXT;
				_format.color = FORMAT_LEFT_SRC;
				_leftTxt.defaultTextFormat = _format;
				_leftTxt.setTextFormat(_format);
			}
		}
		
		private function onInRight(e:FocusEvent):void 
		{
			if (DEFAULT_TXT == _rightTxt.text)
			{
				_rightTxt.text = "";
				_format.color = FORMAT_RIGHT_NEW;
				_rightTxt.defaultTextFormat = _format;
				_rightTxt.setTextFormat(_format);
			}
		}
		
		private function onOutRight(e:FocusEvent):void 
		{
			if ("" == _rightTxt.text)
			{
				_rightTxt.text = DEFAULT_TXT;
				_format.color = FORMAT_RIGHT_SRC;
				_rightTxt.defaultTextFormat = _format;
				_rightTxt.setTextFormat(_format);
			}
		}
		
		public function setBg(index:int):void
		{
			_photoBg.gotoAndStop(index);
		}
		
		public function setPhoto1(mc:DisplayObject):void
		{
			var maxWidth:Number = 283;
			var maxHeight:Number = 283;
			var newWidth:Number = 0;
			var newHeight:Number = 0;
			
			while (_photo1.numChildren > 0)
			{
				_photo1.removeChildAt(0);
			}
			_photo1.addChild(mc);
			mc.width = maxWidth;
			mc.height = maxHeight;
			mc.rotation = 4.5;
		}
		
		public function setPhoto2(mc:DisplayObject):void
		{
			var maxWidth:Number = 309;
			var maxHeight:Number = 309;
			var newWidth:Number = 0;
			var newHeight:Number = 0;
			
			while (_photo2.numChildren > 0)
			{
				_photo2.removeChildAt(0);
			}
			_photo2.addChild(mc);
			mc.width = maxWidth;
			mc.height = maxHeight;
			mc.rotation = -0.5;
		}
		
		public function clearPhoto():void
		{
			while (_photo1.numChildren > 0)
			{
				_photo1.removeChildAt(0);
			}
			while (_photo2.numChildren > 0)
			{
				_photo2.removeChildAt(0);
			}
			
			_leftTxt.text = DEFAULT_TXT;
			_format.color = FORMAT_LEFT_SRC;
			_leftTxt.defaultTextFormat = _format;
			_leftTxt.setTextFormat(_format);
			
			_rightTxt.text = DEFAULT_TXT;
			_format.color = FORMAT_RIGHT_SRC;
			_rightTxt.defaultTextFormat = _format;
			_rightTxt.setTextFormat(_format);
		}
		
		public function get content():MovieClip 
		{
			return _content;
		}
	}
}
