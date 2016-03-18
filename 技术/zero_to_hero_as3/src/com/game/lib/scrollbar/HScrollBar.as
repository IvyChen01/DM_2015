package com.game.lib.scrollbar
{
	import com.game.lib.MyButton;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.display.Stage;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.events.TimerEvent;
	import flash.utils.Timer;
	
	/**
	 * 滚动条滚动事件
	 * @eventType	flash.events.Event.CHANGE
	 */
	[Event(name = "change", type = "flash.events.Event")]
	
	/**
	 * 水平滚动条
	 * @author Shines
	 */
	public class HScrollBar extends EventDispatcher
	{
		private const LEFT:String = "left"; //向左
		private const RIGHT:String = "right"; //向右
		private const NONE:String = "none"; //无
		
		private var _content:MovieClip = null;//元件
		private var _stage:Stage = null; //场景
		private var _maskWidth:Number = 0; //滚动对象显示区的长度
		private var _listWidth:Number = 0; //滚动对象的长度
		private var _step:Number = 0; //一次滚动的距离
		
		private var _currentPlace:Number = 0; //滚动对象滚动的位置
		private var _totalLen:Number = 0; //滚动对象可滚动总长度
		private var _scrollPlace:Number = 0; //滚动条滚动的位置
		private var _scrollLen:Number = 0; //滚动条可滚动总长度
		
		private var _leftBtn:MyButton = null; //向左按钮
		private var _rightBtn:MyButton = null; //向右按钮
		private var _barBtn:MyButton = null; //滚动滑块
		private var _bgMc:MovieClip = null; //滚动条背景
		
		private var _isAddEvents:Boolean = false; //是否添加了事件
		private var _isDownBar:Boolean = false; //是否按下了滚动滑块
		private var _downX:Number = 0; //按下鼠标时鼠标的x坐标
		private var _downScrollPlace:Number = 0; //按下鼠标时滚动滑块的x坐标
		private var _timer:Timer = null; //连续滑动计时器
		private var _moveDirection:String = NONE; //滑动方向
		
		/**
		 * 初始化创建相关对象
		 * @param	aContent	元件
		 * @param	aStage	场景
		 * @param	aStep	点滚动条按钮时移动的步长
		 */
		public function HScrollBar(aContent:MovieClip, aStage:Stage, aStep:Number = 20):void
		{
			_content = aContent;
			_stage = aStage;
			_step = aStep;
			if (typeof(_content["left"]) != "undefined" && typeof(_content["right"]) != "undefined")
			{
				_leftBtn = new MyButton(_content["left"]);
				_rightBtn = new MyButton(_content["right"]);
			}
			_barBtn = new MyButton(_content["bar"]);
			_bgMc = _content["bg"];
			_timer = new Timer(400);
			init();
			addEvents();
		}
		
		/**
		 * 初始化相关属性
		 * 设置滚动滑块的长度
		 * 设置滚动条的可滚动长度，滚动对象的可滚动长度
		 */
		private function init():void
		{
			if (_listWidth > _maskWidth && _listWidth != 0)
			{
				_barBtn.content.width = _bgMc.width * _maskWidth / _listWidth;
				_totalLen = _listWidth - _maskWidth;
				_scrollLen = _bgMc.width - _barBtn.content.width;
			}
			else
			{
				_barBtn.content.width = 0;
				_totalLen = 0;
				_scrollLen = 0;
			}
			currentPlace = _currentPlace;
		}
		
		/**
		 * 显示滚动条
		 */
		public function show():void
		{
			_content.visible = true;
			addEvents();
		}
		
		/**
		 * 隐藏滚动条
		 */
		public function hide():void
		{
			_content.visible = false;
			removeEvents();
		}
		
		/**
		 * 添加指定对象的滑轮事件
		 * @param	aListerner	侦听对象
		 */
		public function addWheelListener(aListerner:Sprite):void
		{
			aListerner.addEventListener(MouseEvent.MOUSE_WHEEL, onWheelListerner);
		}
		
		/**
		 * 移除指定对象的滑轮事件
		 * @param	aListerner	侦听对象
		 */
		public function removeWheelListener(aListerner:Sprite):void
		{
			aListerner.removeEventListener(MouseEvent.MOUSE_WHEEL, onWheelListerner);
		}
		
		/**
		 * 鼠标滚轮滚动
		 * @param	e
		 */
		private function onWheelListerner(e:MouseEvent):void
		{
			currentPlace = _currentPlace - e.delta;
			notice();
		}
		
		/**
		 * 发出更新事件
		 */
		public function notice():void
		{
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 添加滚动条的相关事件
		 * 按下向左按钮，按下向右按钮，按下滚动滑块，按下滚动条背景，场景鼠标弹起，连续滑动计时
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				if (_leftBtn != null)
				{
					_leftBtn.addEventListener(MouseEvent.MOUSE_DOWN, onDownLeft);
				}
				if (_rightBtn != null)
				{
					_rightBtn.addEventListener(MouseEvent.MOUSE_DOWN, onDownRight);
				}
				if (_barBtn != null)
				{
					_barBtn.addEventListener(MouseEvent.MOUSE_DOWN, onDownBar);
				}
				if (_stage != null)
				{
					_stage.addEventListener(MouseEvent.MOUSE_UP, onUpStage);
				}
				if (_bgMc != null)
				{
					_bgMc.addEventListener(MouseEvent.MOUSE_DOWN, onDownBg);
				}
				_timer.addEventListener(TimerEvent.TIMER, onTimer);
				_content.addEventListener(MouseEvent.MOUSE_WHEEL, onWheelListerner);
			}
		}
		
		/**
		 * 移除滚动条的相关事件
		 * 按下向左按钮，按下向右按钮，按下滚动滑块，按下滚动条背景，场景鼠标弹起，连续滑动计时
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				if (_leftBtn != null)
				{
					_leftBtn.removeEventListener(MouseEvent.MOUSE_DOWN, onDownLeft);
				}
				if (_rightBtn != null)
				{
					_rightBtn.removeEventListener(MouseEvent.MOUSE_DOWN, onDownRight);
				}
				if (_barBtn != null)
				{
					_barBtn.removeEventListener(MouseEvent.MOUSE_DOWN, onDownBar);
				}
				if (_stage != null)
				{
					_stage.removeEventListener(MouseEvent.MOUSE_UP, onUpStage);
				}
				if (_bgMc != null)
				{
					_bgMc.removeEventListener(MouseEvent.MOUSE_DOWN, onDownBg);
				}
				_timer.removeEventListener(TimerEvent.TIMER, onTimer);
				_content.removeEventListener(MouseEvent.MOUSE_WHEEL, onWheelListerner);
			}
		}
		
		/**
		 * 按下向左按钮
		 * @param	e
		 */
		private function onDownLeft(e:MouseEvent):void
		{
			_moveDirection = LEFT;
			currentPlace = _currentPlace - _step;
			_timer.start();
			notice();
		}
		
		/**
		 * 按下向右按钮
		 * @param	e
		 */
		private function onDownRight(e:MouseEvent):void
		{
			_moveDirection = RIGHT;
			currentPlace = _currentPlace + _step;
			_timer.start();
			notice();
		}
		
		/**
		 * 按下滚动滑块
		 * @param	e
		 */
		private function onDownBar(e:MouseEvent):void
		{
			if (_stage != null)
			{
				_downX = _stage.mouseX;
				_downScrollPlace = _scrollPlace;
				_isDownBar = true;
				_stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
			}
		}
		
		/**
		 * 按下滚动滑块拖动
		 * @param	e
		 */
		private function onMoveStage(e:MouseEvent):void
		{
			var moveX:Number = 0;
			
			moveX = _stage.mouseX - _downX;
			scrollPlace = _downScrollPlace + moveX;
			notice();
		}
		
		/**
		 * 场景鼠标弹起
		 * @param	e
		 */
		private function onUpStage(e:MouseEvent):void
		{
			if (_isDownBar)
			{
				if (_stage != null)
				{
					_stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
				}
				_isDownBar = false;
			}
			
			if (_moveDirection != NONE)
			{
				_timer.reset();
				_timer.delay = 400;
				_moveDirection = NONE;
			}
		}
		
		/**
		 * 按下滚动条背景
		 * @param	e
		 */
		private function onDownBg(e:MouseEvent):void
		{
			scrollPlace = _content.mouseX - _bgMc.x - _barBtn.content.width / 2;
			notice();
		}
		
		/**
		 * 连续滑动计时
		 * @param	e
		 */
		private function onTimer(e:TimerEvent):void
		{
			switch (_moveDirection)
			{
				case LEFT: 
					currentPlace = _currentPlace - _step;
					notice();
					break;
				case RIGHT: 
					currentPlace = _currentPlace + _step;
					notice();
					break;
				default: 
			}
			_timer.delay = 50;
		}
		
		/**
		 * 滚动对象显示区的长度
		 */
		public function get maskWidth():Number
		{
			return _maskWidth;
		}
		
		/**
		 * 滚动对象显示区的长度
		 */
		public function set maskWidth(value:Number):void
		{
			if (value < 0)
			{
				value = 0;
			}
			_maskWidth = value;
			init();
		}
		
		/**
		 * 滚动对象的长度
		 */
		public function get listWidth():Number
		{
			return _listWidth;
		}
		
		/**
		 * 滚动对象的长度
		 */
		public function set listWidth(value:Number):void
		{
			if (value < 0)
			{
				value = 0;
			}
			_listWidth = value;
			init();
		}
		
		/**
		 * 一次滚动的距离
		 */
		public function get step():Number
		{
			return _step;
		}
		
		/**
		 * 一次滚动的距离
		 */
		public function set step(value:Number):void
		{
			if (value < 0)
			{
				value = 0;
			}
			_step = value;
		}
		
		/**
		 * 滚动条滚动的位置
		 */
		private function set scrollPlace(value:Number):void
		{
			_scrollPlace = value;
			if (_scrollPlace > _scrollLen)
			{
				_scrollPlace = _scrollLen;
			}
			if (_scrollPlace < 0)
			{
				_scrollPlace = 0;
			}
			if (_scrollLen != 0)
			{
				_currentPlace = (_scrollPlace / _scrollLen) * _totalLen;
				_barBtn.content.x = _bgMc.x + _scrollPlace;
			}
		}
		
		/**
		 * 滚动对象滚动的位置
		 */
		public function get currentPlace():Number
		{
			return _currentPlace;
		}
		
		/**
		 * 滚动对象滚动的位置
		 */
		public function set currentPlace(value:Number):void
		{
			_currentPlace = value;
			if (_currentPlace > _totalLen)
			{
				_currentPlace = _totalLen;
			}
			if (_currentPlace < 0)
			{
				_currentPlace = 0;
			}
			if (_totalLen != 0)
			{
				_scrollPlace = (_currentPlace / _totalLen) * _scrollLen;
				_barBtn.content.x = _bgMc.x + _scrollPlace;
			}
		}
		
		/**
		 * 滚动对象可滚动总长度
		 */
		public function get totalLen():Number
		{
			return _totalLen;
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
