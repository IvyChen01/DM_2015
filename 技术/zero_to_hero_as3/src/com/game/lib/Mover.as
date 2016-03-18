package com.game.lib
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.TimerEvent;
	import flash.utils.Timer;
	
	/**
	 * 移动事件
	 * @eventType	flash.events.Event.CHANGE
	 */
	[Event(name = "change", type = "flash.events.Event")]
	
	/**
	 * 移动引擎
	 * 包含功能：匀速移动、加速移动、减速移动、先加速后减速
	 * @author Shines
	 */
	public class Mover extends EventDispatcher
	{
		//常量，移动状态标记
		private static const SPEED_KEEP:String = "speed_keep"; //匀速
		private static const SPEED_UP:String = "speed_up"; //加速
		private static const SPEED_DOWN:String = "speed_down"; //减速
		private static const SPEED_CHANGE:String = "speed_change"; //变速(加速匀速减速)
		private static const LEFT:String = "left"; //向左
		private static const RIGHT:String = "right"; //向右
		private static const CONSTANT_SPEED:Number = 5; //默认匀速速度
		private static const SPEED_UP_ADD:Number = 1; //默认加速递增量
		private static const EASING:Number = 0.1; //默认减速缓系数
		private static const MIN_SPEED:Number = 1; //最小速度
		
		//可供设置的参数
		private var _currentPlace:Number = 0; //当前位置
		
		//变速(加速匀速减速)相关参数
		private var _speedUpTo:Number = 0; //加速终止位置
		private var _constantTo:Number = 0; //减速开始位置
		private var _changeFlag:String = SPEED_UP; //变速(加速匀速减速)标记
		
		//移动相关参数
		private var _destPlace:Number = 0; //目标位置
		private var _speed:Number = 0; //速度
		private var _speedUpAdd:Number = 1; //加速递增量
		private var _easing:Number = 0.1; //减速缓动系数
		private var _moveDirection:String = LEFT; //移动方向
		private var _moving:Boolean = false; //是否正在移动
		private var _timerFlag:String = SPEED_KEEP; //移动标记
		private var _timer:Timer = new Timer(20); //移动计时器
		
		/**
		 * 构造
		 * 添加移动计时器计时事件
		 */
		public function Mover():void
		{
			_timer.addEventListener(TimerEvent.TIMER, moveTimerHandler);
		}
		
		/**
		 * 匀速移动
		 * 若目标位置不是当前位置，则移动，否则不移动
		 * @param	value	目标位置
		 * @param	speed	移动速度
		 */
		public function moveTo(value:Number, speed:Number = CONSTANT_SPEED):void
		{
			if (value != _currentPlace)
			{
				//设置目标位置，设置速度，标记匀速移动
				_destPlace = value;
				_speed = speed;
				_timerFlag = SPEED_KEEP;
				//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
				if (_destPlace < _currentPlace)
				{
					_moveDirection = LEFT;
				}
				else
				{
					_moveDirection = RIGHT;
				}
				//标记开始移动，开始移动
				_moving = true;
				_timer.start();
			}
		}
		
		/**
		 * 加速移动
		 * 若目标位置不是当前位置，则移动，否则不移动
		 * @param	value	目标位置
		 * @param	speedUpAdd	加速递增量
		 */
		public function upTo(value:Number, speedUpAdd:Number = SPEED_UP_ADD):void
		{
			if (value != _currentPlace)
			{
				//设置目标位置，设置速度，设置加速递增量，标记加速移动
				_destPlace = value;
				_speedUpAdd = speedUpAdd;
				_speed = MIN_SPEED;
				_timerFlag = SPEED_UP;
				//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
				if (_destPlace < _currentPlace)
				{
					_moveDirection = LEFT;
				}
				else
				{
					_moveDirection = RIGHT;
				}
				//标记开始移动，开始移动
				_moving = true;
				_timer.start();
			}
		}
		
		/**
		 * 减速移动
		 * 设置目标位置
		 * 设置减速缓动系数
		 * 标记减速移动
		 * 标记开始移动
		 * 若目标位置不是当前位置，则开始移动，否则不移动
		 * @param	value	目标位置
		 * @param	easing	减速缓动系数
		 */
		public function downTo(value:Number, easing:Number = EASING):void
		{
			if (value != _currentPlace)
			{
				_destPlace = value;
				_easing = easing;
				_timerFlag = SPEED_DOWN;
				_moving = true;
				_timer.start();
			}
		}
		
		/**
		 * 变速(加速匀速减速)移动
		 * @param	speedUpTo	加速终止位置
		 * @param	constantTo	匀速终止位置
		 * @param	destPlace	目标位置
		 * @param	speedUpAdd	加速递增量
		 * @param	easing	减速缓动系数
		 */
		public function changeTo(speedUpTo:Number, constantTo:Number, destPlace:Number, speedUpAdd:Number = SPEED_UP_ADD, easing:Number = EASING):void
		{
			//设置加速终止位置、匀速终止位置、目标位置、加速递增量、减速缓动系数、初始速度、移动标记、变速(加速匀速减速)标记
			_speedUpTo = speedUpTo;
			_constantTo = constantTo;
			_destPlace = destPlace;
			_speedUpAdd = speedUpAdd;
			_easing = easing;
			_speed = MIN_SPEED;
			_timerFlag = SPEED_CHANGE;
			_changeFlag = SPEED_UP;
			//设置移动方向，若目标位置在当前位置的左边，则移动方向为左，否则为右
			if (_speedUpTo < _currentPlace)
			{
				_moveDirection = LEFT;
			}
			else if (_speedUpTo > _currentPlace)
			{
				_moveDirection = RIGHT;
			}
			else
			{
				//若当前位置和加速终止位置相同，则判断当前位置和减速开始位置，设置速度，设置变速(加速匀速减速)标记为匀速
				_speed = CONSTANT_SPEED;
				_changeFlag = SPEED_KEEP;
				if (_constantTo < _currentPlace)
				{
					_moveDirection = LEFT;
				}
				else if (_constantTo > _currentPlace)
				{
					_moveDirection = RIGHT;
				}
				else
				{
					//若当前位置和减速开始位置相同，则判断当前位置和目标位置，设置速度、变速(加速匀速减速)标记为减速
					_changeFlag = SPEED_DOWN;
					if (_destPlace < _currentPlace)
					{
						_moveDirection = LEFT;
					}
					else if (_destPlace > _currentPlace)
					{
						_moveDirection = RIGHT;
					}
					else
					{
						//若当前位置和目标位置相同，则不移动
						return;
					}
				}
			}
			//标记开始移动，开始移动
			_moving = true;
			_timer.start();
		}
		
		/**
		 * 重置状态
		 * 标记未移动，停止移动
		 */
		public function reset():void
		{
			_moving = false;
			_timer.reset();
		}
		
		/**
		 * 移动计时器计时事件处理
		 * 根据移动状态移动
		 * @param	e
		 */
		private function moveTimerHandler(e:TimerEvent):void
		{
			switch (_timerFlag)
			{
				case SPEED_KEEP: 
					//匀速移动
					moveConstant();
					break;
				case SPEED_UP: 
					//加速移动
					moveSpeedUp();
					break;
				case SPEED_DOWN: 
					//减速移动
					moveSpeedDown();
					break;
				case SPEED_CHANGE: 
					//变速(加速匀速减速)移动
					moveChange();
					break;
				default: 
			}
		}
		
		/**
		 * 计时器控制匀速移动
		 * 根据移动方向移动
		 */
		private function moveConstant():void
		{
			switch (_moveDirection)
			{
				case LEFT: 
					_currentPlace -= _speed;
					//若到达目标位置，则停止移动
					if (_currentPlace <= _destPlace)
					{
						_currentPlace = _destPlace;
						_moving = false;
						_timer.reset();
					}
					break;
				case RIGHT: 
					_currentPlace += _speed;
					//若到达目标位置，则停止移动
					if (_currentPlace >= _destPlace)
					{
						_currentPlace = _destPlace;
						_moving = false;
						_timer.reset();
					}
					break;
				default: 
			}
			//发送移动事件
			dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 计时器控制加速移动
		 * 根据移动方向移动
		 */
		private function moveSpeedUp():void
		{
			_speed += _speedUpAdd;
			switch (_moveDirection)
			{
				case LEFT: 
					_currentPlace -= _speed;
					//若到达目标位置，则停止移动
					if (_currentPlace <= _destPlace)
					{
						_currentPlace = _destPlace;
						_moving = false;
						_timer.reset();
					}
					break;
				case RIGHT: 
					_currentPlace += _speed;
					//若到达目标位置，则停止移动
					if (_currentPlace >= _destPlace)
					{
						_currentPlace = _destPlace;
						_moving = false;
						_timer.reset();
					}
					break;
				default: 
			}
			//发送移动事件
			dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 计时器控制减速移动
		 */
		private function moveSpeedDown():void
		{
			//减少速度，移动位置
			_speed = (_destPlace - _currentPlace) * _easing;
			_currentPlace += _speed;
			//若到达目标位置，则停止移动
			if (Math.abs(_currentPlace - _destPlace) < MIN_SPEED)
			{
				//_currentPlace = _destPlace;
				_moving = false;
				_timer.reset();
			}
			//发送移动事件
			dispatchEvent(new Event(Event.CHANGE));
		}
		
		/**
		 * 计时器控制变速(加速匀速减速)移动
		 * 根据变速(加速匀速减速)标记移动
		 */
		private function moveChange():void
		{
			switch (_changeFlag)
			{
				case SPEED_UP: 
					//加速移动
					_speed += _speedUpAdd;
					//根据移动方向移动
					switch (_moveDirection)
					{
						case LEFT: 
							_currentPlace -= _speed;
							//若到达加速终止位置，则将变速(加速匀速减速)标记设为匀速
							if (_currentPlace <= _speedUpTo)
							{
								_currentPlace = _speedUpTo;
								_changeFlag = SPEED_KEEP;
							}
							break;
						case RIGHT: 
							_currentPlace += _speed;
							//若到达加速终止位置，则将变速(加速匀速减速)标记设为匀速
							if (_currentPlace >= _speedUpTo)
							{
								_currentPlace = _speedUpTo;
								_changeFlag = SPEED_KEEP;
							}
							break;
						default: 
					}
					//发送移动事件
					dispatchEvent(new Event(Event.CHANGE));
					break;
				case SPEED_KEEP: 
					//匀速移动
					//根据移动方向移动
					switch (_moveDirection)
					{
						case LEFT: 
							_currentPlace -= _speed;
							//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
							if (_currentPlace <= _constantTo)
							{
								_currentPlace = _constantTo;
								_changeFlag = SPEED_DOWN;
							}
							break;
						case RIGHT: 
							_currentPlace += _speed;
							//若到达减速开始位置，则将变速(加速匀速减速)标记设为减速
							if (_currentPlace >= _constantTo)
							{
								_currentPlace = _constantTo;
								_changeFlag = SPEED_DOWN;
							}
							break;
						default: 
					}
					//发送移动事件
					dispatchEvent(new Event(Event.CHANGE));
					break;
				case SPEED_DOWN: 
					//减速移动
					_speed = (_destPlace - _currentPlace) * _easing;
					_currentPlace += _speed;
					//若到达目标位置，则停止移动
					if (Math.abs(_currentPlace - _destPlace) < MIN_SPEED)
					{
						//_currentPlace = _destPlace;
						_moving = false;
						_timer.reset();
					}
					//发送移动事件
					dispatchEvent(new Event(Event.CHANGE));
					break;
				default: 
			}
		}
		
		/**
		 * 获取、设置当前位置
		 */
		public function get currentPlace():Number
		{
			return _currentPlace;
		}
		
		public function set currentPlace(value:Number):void
		{
			_currentPlace = value;
		}
		
		/**
		 * 获取是否正在移动
		 */
		public function get moving():Boolean
		{
			return _moving;
		}
	}
}
