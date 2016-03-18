package com.game.lib
{
	/**
	 * 历史记录
	 * @author Shines
	 */
	public class History
	{
		private var _res:Array = null; //*, 操作记录
		private var _maxStep:int = 100; //最大步数
		private var _currentIndex:int = 0; //当前位置
		private var _stepCount:int = 0; //总步数
		
		public function History(aMaxStep:int = 100):void
		{
			_res = [null];
			_maxStep = aMaxStep;
			_currentIndex = 0;
			_stepCount = 0;
		}
		
		/**
		 * 添加记录
		 * @param	value
		 */
		public function add(value:*):void
		{
			_res[_currentIndex + 1] = value;
			if (_currentIndex + 1 < _maxStep)
			{
				_currentIndex++;
				_stepCount = _currentIndex;
			}
			else
			{
				_res.splice(0, 1);
			}
		}
		
		/**
		 * 后退一步
		 * 到最前时返回null
		 * @return
		 */
		public function back():*
		{
			if (_currentIndex > 0)
			{
				_currentIndex--;
				return _res[_currentIndex];
			}
			else
			{
				return _res[0];
			}
		}
		
		/**
		 * 前进一步
		 * 到最后一步，再向后时返回null
		 * @return
		 */
		public function forward():*
		{
			if (_currentIndex < _stepCount)
			{
				_currentIndex++;
				return _res[_currentIndex];
			}
			else
			{
				return _res[_stepCount];
			}
		}
		
		/**
		 * 清除历史记录
		 */
		public function clear():void
		{
			_res = [null];
			_currentIndex = 0;
			_stepCount = 0;
		}
		
		/**
		 * 是否最前
		 * @return
		 */
		public function get isFront():Boolean
		{
			if (_currentIndex <= 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * 是否最后
		 * @return
		 */
		public function get isRear():Boolean
		{
			if (_currentIndex >= _stepCount)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * 是否记录为空
		 */
		public function get isEmpty():Boolean
		{
			if (_stepCount <= 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}
