package com.geyaa.lib.effect
{
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.DisplayObject;
	import flash.display.DisplayObjectContainer;
	import flash.display.MovieClip;
	import flash.events.TimerEvent;
	import flash.utils.Timer;
	
	/**
	 * 拖尾效果
	 * @author Shines
	 */
	public class MyDragEffect
	{
		private var _content:MovieClip = null;//元件
		private var _container:DisplayObjectContainer = null;//元件容器
		private var _timer:Timer = null;//动画计时器
		private var _bmpArr:Array = null;//Bitmap，拖尾图片
		private var _destX:Number = 0;//目标X坐标
		private var _destY:Number = 0;//目标Y坐标
		private var _runTime:int = 0;//运动动画计数
		private var _mcSpacing:int = 2;//拖尾间间隔数，移动几次后下个图片开始移动
		private var _easing:Number = 0.3;//缓动系数
		private var _minDistance:Number = 10;//距离目标点的最小距离，在最小距离范围内则移至目标点
		
		public function MyDragEffect(aContent:MovieClip, aContainer:DisplayObjectContainer):void 
		{
			_content = aContent;
			_container = aContainer;
			_timer = new Timer(30);
			_timer.addEventListener(TimerEvent.TIMER, onTimer);
		}
		
		/**
		 * 移动到指定位置
		 */
		public function moveTo(aX:Number, aY:Number):void
		{
			var bmp:Bitmap = null;
			var bmpData:BitmapData = null;
			
			if (_content != null)
			{
				clearMovie();
				_destX = aX;
				_destY = aY;
				_bmpArr = [];
				for (var i:int = 0; i < 10; i++)
				{
					bmpData = new BitmapData(_content.width, _content.height, true, 0x000000);
					bmpData.draw(_content);
					bmp = new Bitmap(bmpData);
					_container.addChild(bmp);
					bmp.x = _content.x;
					bmp.y = _content.y;
					bmp.alpha = 1 - i * 0.1;
					_bmpArr.push(bmp);
				}
				_content.visible = false;
				_content.x = _destX;
				_content.y = _destY;
				_runTime = 0;
				_timer.start();
			}
		}
		
		/**
		 * 销毁
		 */
		public function destroy():void
		{
			clearMovie();
			if (_timer != null)
			{
				_timer.reset();
				_timer.removeEventListener(TimerEvent.TIMER, onTimer);
				_timer = null;
			}
			_content = null;
			_container = null;
		}
		
		/**
		 * 清除拖尾图片
		 */
		private function clearMovie():void
		{
			var bmp:Bitmap = null;
			
			if (_bmpArr != null)
			{
				for (var i:int = 0; i < _bmpArr.length; i++)
				{
					bmp = _bmpArr[i];
					if (bmp.parent != null)
					{
						bmp.parent.removeChild(bmp);
					}
					bmp.bitmapData.dispose();
				}
				_bmpArr = null;
			}
		}
		
		/**
		 * 移动图片
		 * @param	e
		 */
		private function onTimer(e:TimerEvent):void 
		{
			var bmp:Bitmap = null;
			var isArrive:Boolean = false;
			var isEnd:Boolean = false;
			
			if (_bmpArr != null)
			{
				for (var i:int = 0; i < _bmpArr.length; i++)
				{
					bmp = _bmpArr[i];
					if (i <= _runTime * _mcSpacing)
					{
						isArrive = moveMc(bmp);
						if ((i == 0) && isArrive)
						{
							isEnd = true;
							break;
						}
					}
				}
			}
			else
			{
				_timer.reset();
			}
			
			if (isEnd)
			{
				clearMovie();
				_content.visible = true;
				_timer.reset();
			}
			_runTime++;
		}
		
		/**
		 * 移动图片
		 * @param	mc
		 * @return
		 */
		private function moveMc(mc:DisplayObject):Boolean
		{
			var mcX:Number = mc.x;
			var mcY:Number = mc.y;
			
			mcX += (_destX - mcX) * _easing;
			mcY += (_destY - mcY) * _easing;
			
			if (Math.abs(_destX - mcX) < _minDistance)
			{
				mcX = _destX;
			}
			if (Math.abs(_destY - mcY) < _minDistance)
			{
				mcY = _destY;
			}
			
			mc.x = mcX;
			mc.y = mcY;
			
			if (mcX == _destX && mcY == _destY)
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
