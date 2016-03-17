package com.geyaa.lib
{
	import flash.display.MovieClip;
	import flash.display.Stage;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.events.TimerEvent;
	import flash.geom.Point;
	import flash.utils.getTimer;
	import flash.utils.Timer;
	
	/**
	 * 滑动事件
	 * @eventType	flash.events.Event.CHANGE
	 */
	[Event(name = "change", type = "flash.events.Event")]
	
	/**
	 * 滑动器
	 * @author Shines
	 */
	public class MySlider extends EventDispatcher
	{
		//常量
		public static const HORIZONTAL:String = "horizontal"; //横向
		public static const VERTICAL:String = "vertical"; //纵向
		
		private const LEFT:String = "left"; //左
		private const RIGHT:String = "right"; //右
		private const UP:String = "up"; //上
		private const DOWN:String = "down"; //下
		private const OUT_TOP:String = "out_top"; //上越界
		private const OUT_BOTTOM:String = "out_bottom"; //下越界
		private const INSIDE:String = "inside"; //内部
		private const MOVE_NORMAL:String = "move_normal"; //正常移动
		private const MOVE_BACK:String = "move_back"; //回移
		private const COUNT_STAY:String = "count_stay"; //停留计时
		
		//构造需传递的参数
		private var _stage:Stage = null; //场景
		private var _content:MovieClip = null; //元件
		private var _sliderDirection:String = VERTICAL; //滑动方向
		
		//可供设置的参数
		private var _sliderLength:Number = 0; //可滑动长度
		private var _currentPlace:Number = 0; //当前指针位置
		private var _easing:Number = 0.92; //缓动系数
		private var _maxSpeed:Number = 50; //最大速度
		private var _minSpeed:Number = 1; //最小速度
		private var _speedAdjustRate:int = 50; //调速系数，调节松开鼠标后的移动速度
		private var _maxStayTime:int = 3; //最大停留时间(计时器执行次数)
		
		//触摸板相关
		private var _topPlace:Number = 0; //上边界
		private var _bottomPlace:Number = 0; //下边界
		private var _outFlag:String = INSIDE; //越界标识
		
		//移动相关
		private var _srcPlace:Number = 0; //指针初始位置(鼠标按下时的指针位置)
		private var _moveDirection:String = LEFT; //移动方向
		private var _speed:Number = 0; //速度
		
		//鼠标状态改变相关
		private var _srcMousePoint:Point = new Point(0, 0); //原鼠标坐标
		private var _destMousePoint:Point = new Point(0, 0); //目标鼠标坐标
		private var _dragDistance:Number = 0; //鼠标拖动剪辑的距离
		private var _srcTime:int = 0; //鼠标按下时的计时器时间(计时器执行次数)
		private var _destTime:int = 0; //鼠标弹起时的计时器时间(计时器执行次数)
		private var _dragTime:int = 0; //鼠标拖动剪辑的时间
		private var _stayPlace:Number = 0; //停留位置
		private var _stayTime:int = 0; //停留时间
		private var _isDrag:Boolean = false; //是否拖动
		
		//计时器相关
		private var _timerFlag:String = MOVE_NORMAL; //计时器标记
		private var _timer:Timer = new Timer(20); //计时器
		
		private var _isAddEvents:Boolean = false;//是否已添加了事件
		
		/**
		 * 构造
		 * 初始化场景、剪辑、滑动方向
		 * 重置状态，添加事件
		 * @param	aContent	元件
		 * @param	aStage	场景
		 * @param	aSliderDirection	滑动方向 （横向、纵向）
		 */
		public function MySlider(aContent:MovieClip, aStage:Stage, aSliderDirection:String):void
		{
			_content = aContent;
			_stage = aStage;
			_sliderDirection = aSliderDirection;
			addEvents();
		}
		
		/**
		 * 重置状态
		 * 标记停止拖动
		 * 重置计时器
		 */
		public function reset():void
		{
			_isDrag = false;
			_timer.reset();
		}
		
		/**
		 * 发生滑动事件
		 */
		public function notice():void
		{
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 销毁
		 */
		public function destroy():void
		{
			reset();
			removeEvents();
		}
		
		/**
		 * 添加事件
		 * 添加剪辑鼠标按下事件
		 * 添加场景鼠标移动事件
		 * 添加场景鼠标弹起事件
		 * 添加计时器计时事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_content.addEventListener(MouseEvent.MOUSE_DOWN, downHandler);
				_stage.addEventListener(MouseEvent.MOUSE_MOVE, moveHandler);
				_stage.addEventListener(MouseEvent.MOUSE_UP, upHandler);
				_timer.addEventListener(TimerEvent.TIMER, timerHandler);
			}
		}
		
		/**
		 * 移除所有事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				_content.removeEventListener(MouseEvent.MOUSE_DOWN, downHandler);
				_stage.removeEventListener(MouseEvent.MOUSE_MOVE, moveHandler);
				_stage.removeEventListener(MouseEvent.MOUSE_UP, upHandler);
				_timer.removeEventListener(TimerEvent.TIMER, timerHandler);
			}
		}
		
		/**
		 * 鼠标按下事件处理
		 * 初始化滑动状态
		 * @param	e
		 */
		private function downHandler(e:MouseEvent):void
		{
			//停止滑动，标记开始拖动
			_timer.reset();
			_isDrag = true;
			
			//记录移动时鼠标初始坐标
			_srcMousePoint.x = _stage.mouseX;
			_srcMousePoint.y = _stage.mouseY;
			//记录移动初始时间、设置指针初始位置
			_srcTime = getTimer();
			_srcPlace = _currentPlace;
			
			//开始累计停留时间
			_stayPlace = _stage.mouseX;
			_stayTime = 0;
			_timerFlag = COUNT_STAY;
			_timer.start();
		}
		
		/**
		 * 鼠标移动事件处理
		 * 使剪辑跟随鼠标移动
		 * @param	e
		 */
		private function moveHandler(e:MouseEvent):void
		{
			//若是拖动状态，则可以拖动
			if (_isDrag)
			{
				//记录目标鼠标位置
				_destMousePoint.x = _stage.mouseX;
				_destMousePoint.y = _stage.mouseY;
				//根据移动方向，记录位置
				switch (_sliderDirection)
				{
					case HORIZONTAL: 
						_currentPlace = _srcPlace + _destMousePoint.x - _srcMousePoint.x;
						break;
					case VERTICAL: 
						_currentPlace = _srcPlace + _destMousePoint.y - _srcMousePoint.y;
						break;
					default: 
				}
				//检测越界，若越界，则减速
				checkOut();
				switch (_outFlag)
				{
					case INSIDE: 
						break;
					case OUT_TOP: 
						_currentPlace = _topPlace - (_topPlace - _currentPlace) * 0.06;
						break;
					case OUT_BOTTOM: 
						_currentPlace = _bottomPlace + (_currentPlace - _bottomPlace) * 0.06;
						break;
					default: 
				}
				//发生滑动事件
				notice();
			}
		}
		
		/**
		 * 鼠标弹起事件处理
		 * 开始滑动
		 * @param	e
		 */
		private function upHandler(e:MouseEvent):void
		{
			if (_isDrag)
			{
				//标记停止拖动，停止停留计时
				_isDrag = false;
				_timer.reset();
				
				//记录鼠标移动终点坐标，记录移动终点时间
				_destMousePoint.x = _stage.mouseX;
				_destMousePoint.y = _stage.mouseY;
				_destTime = getTimer();
				//计算拖动时间
				_dragTime = (_destTime - _srcTime);
				if (_dragTime <= 0)
				{
					_dragTime = 1;
				}
				
				//根据移动方向，计算速度
				switch (_sliderDirection)
				{
					case HORIZONTAL: 
						//水平方向，计算拖动距离，拖动距离为当前位置减去原位置。计算速度，速度为拖动距离除以拖动时间再乘以调速系数
						_dragDistance = _destMousePoint.x - _srcMousePoint.x;
						if (_dragTime != 0)
						{
							_speed = _dragDistance / _dragTime * _speedAdjustRate;
						}
						else
						{
							_speed = 0;
						}
						//标记移动方向，速度小于0时，为左，速度转为正数；速度大于0时，为右
						if (_speed < 0)
						{
							_moveDirection = LEFT;
							_speed = -_speed;
						}
						else
						{
							_moveDirection = RIGHT;
						}
						break;
					case VERTICAL: 
						//垂直方向，计算拖动距离，拖动距离为当前位置减去原位置。计算速度，速度为拖动距离除以拖动时间再乘以调速系数
						_dragDistance = _destMousePoint.y - _srcMousePoint.y;
						if (_dragTime != 0)
						{
							_speed = _dragDistance / _dragTime * _speedAdjustRate;
						}
						else
						{
							_speed = 0;
						}
						//标记移动方向，速度小于0时，为上，速度转为正数；速度大于0时，为下
						if (_speed < 0)
						{
							_moveDirection = UP;
							_speed = -_speed;
						}
						else
						{
							_moveDirection = DOWN;
						}
						break;
					default: 
				}
				
				//检测越界
				checkOut();
				//若越界，则启动回移
				if (_outFlag != INSIDE)
				{
					startBack();
				}
				else
				{
					//若停留时间小于最大停留时间，且速度不为0，则检测调整速度，开始滑动，否则不滑动
					if (_stayTime < _maxStayTime && _speed != 0)
					{
						fixSpeed();
						_timerFlag = MOVE_NORMAL;
						_timer.start();
					}
				}
			}
		}
		
		/**
		 * 滑动计时器计时事件处理
		 * 根据计时器标记执行相应操作
		 * @param	e
		 */
		private function timerHandler(e:TimerEvent):void
		{
			switch (_timerFlag)
			{
				case MOVE_NORMAL: 
					//正常移动
					moveNormal();
					break;
				case MOVE_BACK: 
					//回移
					moveBack();
					break;
				case COUNT_STAY: 
					//统计停留计时
					countStay();
					break;
				default: 
			}
		}
		
		/**
		 * 正常移动
		 */
		private function moveNormal():void
		{
			//改变位置，检测越界
			changePlace();
			checkOut();
			//若越界，则速度下降
			if (_outFlag != INSIDE)
			{
				_speed *= 0.4;
			}
			//发生滑动事件
			notice();
			//若达到最小速度，则停止继续移动，否则减速移动
			if (_speed <= _minSpeed)
			{
				_timer.reset();
				//若出界，则启动回移
				if (_outFlag != INSIDE)
				{
					startBack();
				}
			}
			else
			{
				slowDown();
			}
		}
		
		/**
		 * 回移
		 * 根据越界状态进行回移
		 */
		private function moveBack():void
		{
			switch (_outFlag)
			{
				case INSIDE: 
					_timer.reset();
					break;
				case OUT_TOP: 
					//上越界，改变位置，若已移到边界，则停止移动
					backPlace();
					if (_currentPlace >= _topPlace)
					{
						_currentPlace = _topPlace;
						_timer.reset();
					}
					//发生滑动事件，减速
					notice();
					slowDown();
					break;
				case OUT_BOTTOM: 
					//下越界，改变位置，若已移到边界，则停止移动
					backPlace();
					if (_currentPlace <= _bottomPlace)
					{
						_currentPlace = _bottomPlace;
						_timer.reset();
					}
					//发生滑动事件，减速
					notice();
					slowDown();
					break;
				default: 
			}
		}
		
		/**
		 * 统计停留时间
		 * 根据移动方向，累计停留时间
		 */
		private function countStay():void
		{
			switch (_sliderDirection)
			{
				case HORIZONTAL: 
					//水平方向，若初始位置和剪辑位置为同一位置，则增加停留时间，否则，将初始位置设为剪辑位置
					if (_stayPlace == _stage.mouseX)
					{
						_stayTime++;
					}
					else
					{
						_stayPlace = _stage.mouseX;
					}
					break;
				case VERTICAL: 
					//垂直方向，若初始位置和剪辑位置为同一位置，则增加停留时间，否则，将初始位置设为剪辑位置
					if (_stayPlace == _stage.mouseY)
					{
						_stayTime++;
					}
					else
					{
						_stayPlace = _stage.mouseY;
					}
					break;
				default: 
			}
		}
		
		/**
		 * 检测越界
		 */
		private function checkOut():void
		{
			if (_currentPlace < _topPlace)
			{
				_outFlag = OUT_TOP;
			}
			else if (_currentPlace > _bottomPlace)
			{
				_outFlag = OUT_BOTTOM;
			}
			else
			{
				_outFlag = INSIDE;
			}
		}
		
		/**
		 * 启动回移
		 * 根据滑动方向和越界标识，设置回移速度，标记移动方向
		 */
		private function startBack():void
		{
			switch (_sliderDirection)
			{
				case HORIZONTAL: 
					//水平方向，设置回移速度，标记移动方向
					switch (_outFlag)
				{
					case INSIDE: 
						break;
					case OUT_TOP: 
						_speed = (_topPlace - _currentPlace) / 8;
						_moveDirection = LEFT;
						break;
					case OUT_BOTTOM: 
						_speed = (_currentPlace - _bottomPlace) / 8;
						_moveDirection = RIGHT;
						break;
					default: 
				}
					break;
				case VERTICAL: 
					//垂直方向，设置回移速度，标记移动方向
					switch (_outFlag)
				{
					case INSIDE: 
						break;
					case OUT_TOP: 
						_speed = (_topPlace - _currentPlace) / 8;
						_moveDirection = UP;
						break;
					case OUT_BOTTOM: 
						_speed = (_currentPlace - _bottomPlace) / 8;
						_moveDirection = DOWN;
						break;
					default: 
				}
					break;
				default: 
			}
			//启动回移
			_timerFlag = MOVE_BACK;
			_timer.start();
		}
		
		/**
		 * 修正速度
		 * 使速度在指定的范围之内
		 */
		private function fixSpeed():void
		{
			if (_speed < _minSpeed)
			{
				_speed = _minSpeed;
			}
			else if (_speed > _maxSpeed)
			{
				_speed = _maxSpeed;
			}
		}
		
		/**
		 * 修正当前位置
		 * 使当前位置在有效范围之内
		 */
		private function fixCurrentPlace():void
		{
			if (_currentPlace < _topPlace)
			{
				_currentPlace = _topPlace;
			}
			else if (_currentPlace > _bottomPlace)
			{
				_currentPlace = _bottomPlace;
			}
		}
		
		/**
		 * 改变位置
		 * 根据移动方向，改变位置
		 */
		private function changePlace():void
		{
			switch (_moveDirection)
			{
				case LEFT: 
					_currentPlace -= _speed;
					break;
				case RIGHT: 
					_currentPlace += _speed;
					break;
				case UP: 
					_currentPlace -= _speed;
					break;
				case DOWN: 
					_currentPlace += _speed;
					break;
				default: 
			}
		}
		
		/**
		 * 回移改变位置
		 * 根据移动方向，改变位置
		 */
		private function backPlace():void
		{
			switch (_moveDirection)
			{
				case LEFT: 
					_currentPlace += _speed;
					break;
				case RIGHT: 
					_currentPlace -= _speed;
					break;
				case UP: 
					_currentPlace += _speed;
					break;
				case DOWN: 
					_currentPlace -= _speed;
					break;
				default: 
			}
		}
		
		/**
		 * 减速
		 * 根据缓动系数进行减速
		 */
		private function slowDown():void
		{
			if (_speed * _easing > _minSpeed)
			{
				_speed *= _easing;
			}
			else
			{
				_speed = _minSpeed;
			}
		}
		
		/**
		 * 可滑动长度
		 */
		public function get sliderLength():Number
		{
			return _sliderLength;
		}
		
		/**
		 * 可滑动长度
		 */
		public function set sliderLength(value:Number):void
		{
			//设置可滑动长度，设置上边界，检测修正当前位置
			if (value < 0)
			{
				value = 0;
			}
			_sliderLength = value;
			_topPlace = -_sliderLength;
			fixCurrentPlace();
		}
		
		/**
		 * 当前指针位置
		 */
		public function get currentPlace():Number
		{
			return _currentPlace;
		}
		
		/**
		 * 当前指针位置
		 */
		public function set currentPlace(value:Number):void
		{
			//设置当前指针位置，检测修正当前位置
			_currentPlace = value;
			fixCurrentPlace();
		}
		
		/**
		 * 缓动系数
		 */
		public function get easing():Number
		{
			return _easing;
		}
		
		/**
		 * 缓动系数
		 */
		public function set easing(value:Number):void
		{
			_easing = value;
		}
		
		/**
		 * 最大速度
		 */
		public function get maxSpeed():Number
		{
			return _maxSpeed;
		}
		
		/**
		 * 最大速度
		 */
		public function set maxSpeed(value:Number):void
		{
			_maxSpeed = value;
		}
		
		/**
		 * 最小速度
		 */
		public function get minSpeed():Number
		{
			return _minSpeed;
		}
		
		/**
		 * 最小速度
		 */
		public function set minSpeed(value:Number):void
		{
			_minSpeed = value;
		}
		
		/**
		 * 调速比率
		 */
		public function get speedAdjustRate():int
		{
			return _speedAdjustRate;
		}
		
		/**
		 * 调速比率
		 */
		public function set speedAdjustRate(value:int):void
		{
			_speedAdjustRate = value;
		}
		
		/**
		 * 最大停留时间
		 */
		public function get maxStayTime():int
		{
			return _maxStayTime;
		}
		
		/**
		 * 最大停留时间
		 */
		public function set maxStayTime(value:int):void
		{
			_maxStayTime = value;
		}
	}
}
