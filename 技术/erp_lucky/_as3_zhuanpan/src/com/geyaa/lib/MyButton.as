package com.geyaa.lib
{
	import flash.display.MovieClip;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	import flash.text.TextFormat;
	
	/**
	 * 点击事件
	 * @eventType	flash.events.MouseEvent.CLICK
	 */
	[Event(name="click",type="flash.events.MouseEvent")]
	
	/**
	 * 移入事件
	 * @eventType	flash.events.MouseEvent.ROLL_OVER
	 */
	[Event(name="rollOver",type="flash.events.MouseEvent")]
	
	/**
	 * 移出事件
	 * @eventType	flash.events.MouseEvent.ROLL_OUT
	 */
	[Event(name="rollOut",type="flash.events.MouseEvent")]
	
	/**
	 * 按下事件
	 * @eventType	flash.events.MouseEvent.MOUSE_DOWN
	 */
	[Event(name="mouseDown",type="flash.events.MouseEvent")]
	
	/**
	 * 弹起事件
	 * @eventType	flash.events.MouseEvent.MOUSE_UP
	 */
	[Event(name="mouseUp",type="flash.events.MouseEvent")]
	
	/**
	 * 自定义按钮
	 * @author Shines
	 */
	public class MyButton extends EventDispatcher
	{
		private var _content:MovieClip = null; //元件
		private var _label:TextField = null; //按钮上的文本
		private var _format:TextFormat = null; //文本格式
		private var _outColor:int = 0; //移出颜色
		private var _overColor:int = 0; //移入颜色
		private var _downColor:int = 0; //按下颜色
		private var _disabledColor:int = 0; //不可用颜色
		private var _isSetColor:Boolean = false; //是否设置颜色
		private var _enabled:Boolean = true; //按钮是否可用
		private var _isAddEvents:Boolean = false; //是否已添加了事件
		
		/**
		 * 初始化对象
		 * @param	aContent	元件
		 */
		public function MyButton(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_content.mouseChildren = false;
			_content.buttonMode = true;
			if (typeof(_content["label"]) != "undefined")
			{
				_label = _content["label"];
			}
			_format = new TextFormat();
			addEvents();
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_content.visible = true;
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_content.visible = false;
			removeEvents();
		}
		
		/**
		 * 按钮上的文本颜色
		 * @param	outColor
		 * @param	overColor
		 * @param	downColor
		 * @param	disabledColor
		 */
		public function setLabelColor(aOutColor:int = 0, aOverColor:int = 0, aDownColor:int = 0, aDisabledColor:int = 0):void
		{
			_outColor = aOutColor;
			_overColor = aOverColor;
			_downColor = aDownColor;
			_disabledColor = aDisabledColor;
			_isSetColor = true;
		}
		
		/**
		 * 添加元件的“单击”、“移入”、“移出”、“按下”、“弹起”事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_content.addEventListener(MouseEvent.CLICK, onClickView);
				_content.addEventListener(MouseEvent.ROLL_OVER, onOverView);
				_content.addEventListener(MouseEvent.ROLL_OUT, onOutView);
				_content.addEventListener(MouseEvent.MOUSE_DOWN, onDownView);
				_content.addEventListener(MouseEvent.MOUSE_UP, onUpView);
			}
		}
		
		/**
		 * 移除元件的“单击”、“移入”、“移出”、“按下”、“弹起”事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				_content.removeEventListener(MouseEvent.CLICK, onClickView);
				_content.removeEventListener(MouseEvent.ROLL_OVER, onOverView);
				_content.removeEventListener(MouseEvent.ROLL_OUT, onOutView);
				_content.removeEventListener(MouseEvent.MOUSE_DOWN, onDownView);
				_content.removeEventListener(MouseEvent.MOUSE_UP, onUpView);
			}
		}
		
		/**
		 * 元件的“单击”事件处理
		 * @param	e
		 */
		private function onClickView(e:MouseEvent):void
		{
			if (_enabled)
			{
				this.dispatchEvent(e);
			}
		}
		
		/**
		 * 元件的“移入”事件处理
		 * @param	e
		 */
		private function onOverView(e:MouseEvent):void
		{
			if (_enabled)
			{
				if (_label != null && _isSetColor)
				{
					_format.color = _overColor;
					_label.setTextFormat(_format);
				}
				_content.gotoAndStop(2);
				this.dispatchEvent(e);
			}
		}
		
		/**
		 * 元件的“移出”事件处理
		 * @param	e
		 */
		private function onOutView(e:MouseEvent):void
		{
			if (_enabled)
			{
				if (_label != null && _isSetColor)
				{
					_format.color = _outColor;
					_label.setTextFormat(_format);
				}
				_content.gotoAndStop(1);
				this.dispatchEvent(e);
			}
		}
		
		/**
		 * 元件的“按下”事件处理
		 * @param	e
		 */
		private function onDownView(e:MouseEvent):void
		{
			if (_enabled)
			{
				if (_label != null && _isSetColor)
				{
					_format.color = _downColor;
					_label.setTextFormat(_format);
				}
				_content.gotoAndStop(3);
				this.dispatchEvent(e);
			}
		}
		
		/**
		 * 元件的“弹起”事件处理
		 * @param	e
		 */
		private function onUpView(e:MouseEvent):void
		{
			if (_enabled)
			{
				if (_label != null && _isSetColor)
				{
					_format.color = _overColor;
					_label.setTextFormat(_format);
				}
				_content.gotoAndStop(2);
				this.dispatchEvent(e);
			}
		}
		
		/**
		 * 按钮上的文本内容
		 */
		public function get label():String
		{
			if (_label != null)
			{
				return _label.text;
			}
			else
			{
				return "";
			}
		}
		
		/**
		 * 按钮上的文本内容
		 */
		public function set label(value:String):void
		{
			if (_label != null)
			{
				_label.text = value;
			}
		}
		
		/**
		 * 按钮是否可用
		 */
		public function get enabled():Boolean 
		{
			return _enabled;
		}
		
		/**
		 * 按钮是否可用
		 */
		public function set enabled(value:Boolean):void 
		{
			_enabled = value;
			if (_enabled)
			{
				//设置鼠标手形，侦听事件
				_content.gotoAndStop(1);
				_content.buttonMode = true;
				if (_label != null && _isSetColor)
				{
					_format.color = _outColor;
					_label.setTextFormat(_format);
				}
				addEvents();
			}
			else
			{
				//取消鼠标手形，取消侦听事件
				_content.gotoAndStop(4);
				_content.buttonMode = false;
				if (_label != null && _isSetColor)
				{
					_format.color = _disabledColor;
					_label.setTextFormat(_format);
				}
				removeEvents();
			}
		}
		
		/**
		 * 元件
		 */
		public function get content():MovieClip 
		{
			return _content;
		}
	}
}
