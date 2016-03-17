package com.geyaa.lib.scrollbar
{
	import flash.display.DisplayObjectContainer;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.display.Stage;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	/**
	 * 滚动条滚动事件
	 * @eventType	flash.events.Event.CHANGE
	 */
	[Event(name = "change", type = "flash.events.Event")]
	
	/**
	 * 滚动条
	 * @author Shines
	 */
	public class MyScrollBar extends EventDispatcher
	{
		public static const HORIZONTAL:String = "horizontal"; //水平滚动条
		public static const VERTICAL:String = "vertical"; //垂直滚动条
		
		private var _style:String = "";//滚动条类型：水平滚动条、垂直滚动条
		private var _hScrollBar:HScrollBar = null;//水平滚动条
		private var _vScrollBar:VScrollBar = null;//垂直滚动条
		private var _isAddEvents:Boolean = false;//是否添加了事件
		
		/**
		 * 初始化创建相关对象
		 * @param	aContent	元件
		 * @param	aStage	场景
		 * @param	aStyle	滚动条类型：水平滚动条、垂直滚动条
		 * @param	aStep	点滚动条按钮时移动的步长
		 */
		public function MyScrollBar(aContent:MovieClip, aStage:Stage, aStyle:String, aStep:Number = 20):void
		{
			_style = aStyle;
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar = new HScrollBar(aContent, aStage, aStep);
					break;
				case VERTICAL:
					_vScrollBar = new VScrollBar(aContent, aStage, aStep);
					break;
				default:
			}
			addEvents();
		}
		
		/**
		 * 显示滚动条
		 */
		public function show():void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.show();
					break;
				case VERTICAL:
					_vScrollBar.show();
					break;
				default:
			}
			addEvents();
		}
		
		/**
		 * 隐藏滚动条
		 */
		public function hide():void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.hide();
					break;
				case VERTICAL:
					_vScrollBar.hide();
					break;
				default:
			}
			removeEvents();
		}
		
		/**
		 * 添加指定对象的滑轮事件
		 * @param	aListerner	侦听对象
		 */
		public function addWheelListener(aListerner:Sprite):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.addWheelListener(aListerner);
					break;
				case VERTICAL:
					_vScrollBar.addWheelListener(aListerner);
					break;
				default:
			}
		}
		
		/**
		 * 移除指定对象的滑轮事件
		 * @param	aListerner	侦听对象
		 */
		public function removeWheelListener(aListerner:Sprite):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.removeWheelListener(aListerner);
					break;
				case VERTICAL:
					_vScrollBar.removeWheelListener(aListerner);
					break;
				default:
			}
		}
		
		/**
		 * 发出更新事件
		 */
		public function notice():void
		{
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 添加滚动事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				switch (_style)
				{
					case HORIZONTAL:
						_hScrollBar.addEventListener(Event.CHANGE, onChangeScroll);
						break;
					case VERTICAL:
						_vScrollBar.addEventListener(Event.CHANGE, onChangeScroll);
						break;
					default:
				}
			}
		}
		
		/**
		 * 移除滚动事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				switch (_style)
				{
					case HORIZONTAL:
						_hScrollBar.removeEventListener(Event.CHANGE, onChangeScroll);
						break;
					case VERTICAL:
						_vScrollBar.removeEventListener(Event.CHANGE, onChangeScroll);
						break;
					default:
				}
			}
		}
		
		/**
		 * 发送滚动事件
		 * @param	e
		 */
		private function onChangeScroll(e:Event):void 
		{
			this.dispatchEvent(e);
		}
		
		/**
		 * 滚动对象显示区的长度
		 */
		public function get maskLen():Number
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.maskWidth;
					break;
				case VERTICAL:
					return _vScrollBar.maskHeight;
					break;
				default:
			}
			
			return 0;
		}
		
		/**
		 * 滚动对象显示区的长度
		 */
		public function set maskLen(value:Number):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.maskWidth = value;
					break;
				case VERTICAL:
					_vScrollBar.maskHeight = value;
					break;
				default:
			}
		}
		
		/**
		 * 滚动对象的长度
		 */
		public function get listLen():Number
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.listWidth;
					break;
				case VERTICAL:
					return _vScrollBar.listHeight;
					break;
				default:
			}
			
			return 0;
		}
		
		/**
		 * 滚动对象的长度
		 */
		public function set listLen(value:Number):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.listWidth = value;
					break;
				case VERTICAL:
					_vScrollBar.listHeight = value;
					break;
				default:
			}
		}
		
		/**
		 * 一次滚动的距离
		 */
		public function get step():Number
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.step;
					break;
				case VERTICAL:
					return _vScrollBar.step;
					break;
				default:
			}
			
			return 0;
		}
		
		/**
		 * 一次滚动的距离
		 */
		public function set step(value:Number):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.step = value;
					break;
				case VERTICAL:
					_vScrollBar.step = value;
					break;
				default:
			}
		}
		
		/**
		 * 滚动对象滚动的位置
		 */
		public function get currentPlace():Number
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.currentPlace;
					break;
				case VERTICAL:
					return _vScrollBar.currentPlace;
					break;
				default:
			}
			
			return 0;
		}
		
		/**
		 * 滚动对象滚动的位置
		 */
		public function set currentPlace(value:Number):void
		{
			switch (_style)
			{
				case HORIZONTAL:
					_hScrollBar.currentPlace = value;
					break;
				case VERTICAL:
					_vScrollBar.currentPlace = value;
					break;
				default:
			}
		}
		
		/**
		 * 滚动对象可滚动总长度
		 */
		public function get totalLen():Number
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.totalLen;
					break;
				case VERTICAL:
					return _vScrollBar.totalLen;
					break;
				default:
			}
			
			return 0;
		}
		
		/**
		 * 元件
		 */
		public function get content():MovieClip
		{
			switch (_style)
			{
				case HORIZONTAL:
					return _hScrollBar.content;
					break;
				case VERTICAL:
					return _vScrollBar.content;
					break;
				default:
			}
			
			return null;
		}
	}
}
