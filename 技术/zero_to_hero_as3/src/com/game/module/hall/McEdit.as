package com.game.module.hall
{
	import com.game.core.Config;
	import com.game.core.Layer;
	import com.game.lib.loading.MyLoader;
	import flash.display.DisplayObjectContainer;
	import flash.display.MovieClip;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	
	/**
	 * 图形编辑器
	 * @author Shines
	 */
	public class McEdit extends EventDispatcher
	{
		public static const MIN_WIDTH:Number = 300;
		public static const MIN_HEIGHT:Number = 300;
		public static const MAX_WIDTH:Number = 310;
		public static const MAX_HEIGHT:Number = 310;
		
		private var _container:DisplayObjectContainer = null;//剪辑主容器
		private var _leftTop:MovieClip = null;
		private var _leftBottom:MovieClip = null;
		private var _rightTop:MovieClip = null;
		private var _rightBottom:MovieClip = null;
		private var _isAddEvents:Boolean = false;//是否已添加相关事件
		
		private var _leftLimit:Number = 0;
		private var _rightLimit:Number = 0;
		private var _topLimit:Number = 0;
		private var _bottomLimit:Number = 0;
		
		private var _mouseSrcX:Number = 0;
		private var _mouseSrcY:Number = 0;
		private var _leftTopSrcX:Number = 0;
		private var _leftTopSrcY:Number = 0;
		private var _leftBottomSrcX:Number = 0;
		private var _leftBottomSrcY:Number = 0;
		private var _rightTopSrcX:Number = 0;
		private var _rightTopSrcY:Number = 0;
		private var _rightBottomSrcX:Number = 0;
		private var _rightBottomSrcY:Number = 0;
		
		private var _isMove:Boolean = true;
		
		private var _leftMask:MovieClip = null;
		private var _rightMask:MovieClip = null;
		private var _topMask:MovieClip = null;
		private var _bottomMask:MovieClip = null;
		
		public function McEdit(aContainer:DisplayObjectContainer, aLeftMask:MovieClip, aRightMask:MovieClip, aTopMask:MovieClip, aBottomMask:MovieClip):void
		{
			_container = aContainer;
			_leftMask = aLeftMask;
			_rightMask = aRightMask;
			_topMask = aTopMask;
			_bottomMask = aBottomMask;
			_leftTop = MovieClip(MyLoader.createObject("ControlMc"));
			_leftBottom = MovieClip(MyLoader.createObject("ControlMc"));
			_rightTop = MovieClip(MyLoader.createObject("ControlMc"));
			_rightBottom = MovieClip(MyLoader.createObject("ControlMc"));
			_leftTop.buttonMode = true;
			_leftBottom.buttonMode = true;
			_rightTop.buttonMode = true;
			_rightBottom.buttonMode = true;
			_container.addChild(_leftTop);
			_container.addChild(_leftBottom);
			_container.addChild(_rightTop);
			_container.addChild(_rightBottom);
			show();
		}
		
		public function setLimit(aLeftLimit:Number, aTopLimit:Number, aRightLimit:Number, aBottomLimit:Number):void
		{
			_leftLimit = aLeftLimit;
			_rightLimit = aRightLimit;
			_topLimit = aTopLimit;
			_bottomLimit = aBottomLimit;
		}
		
		public function setPlace(aX:Number, aY:Number, aWidth:Number, aHeight:Number):void
		{
			_leftTop.x = aX;
			_leftTop.y = aY;
			_leftBottom.x = aX;
			_leftBottom.y = aY + aHeight;
			_rightTop.x = aX + aWidth;
			_rightTop.y = aY;
			_rightBottom.x = aX + aWidth;
			_rightBottom.y = aY + aHeight;
			fixMask();
		}
		
		public function getRect():Object
		{
			var obj:Object = new Object();
			
			obj.x = _leftTop.x;
			obj.y = _leftTop.y;
			obj.width = _rightBottom.x - _leftTop.x;
			obj.height = _rightBottom.y - _leftTop.y;
			
			return obj;
		}
		
		/**
		 * 显示
		 */
		public function show():void
		{
			_container.visible = true;
			addEvents();
		}
		
		/**
		 * 隐藏
		 */
		public function hide():void
		{
			_container.visible = false;
			removeEvents();
		}
		
		/**
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_leftTop.addEventListener(MouseEvent.MOUSE_DOWN, onDownLeftTop);
				_leftBottom.addEventListener(MouseEvent.MOUSE_DOWN, onDownLeftBottom);
				_rightTop.addEventListener(MouseEvent.MOUSE_DOWN, onDownRightTop);
				_rightBottom.addEventListener(MouseEvent.MOUSE_DOWN, onDownRightBottom);
				Layer.stage.addEventListener(MouseEvent.MOUSE_DOWN, onDownStage);
			}
		}
		
		/**
		 * 移除事件
		 */
		private function removeEvents():void
		{
			if (_isAddEvents)
			{
				_isAddEvents = false;
				_leftTop.removeEventListener(MouseEvent.MOUSE_DOWN, onDownLeftTop);
				_leftBottom.removeEventListener(MouseEvent.MOUSE_DOWN, onDownLeftBottom);
				_rightTop.removeEventListener(MouseEvent.MOUSE_DOWN, onDownRightTop);
				_rightBottom.removeEventListener(MouseEvent.MOUSE_DOWN, onDownRightBottom);
				Layer.stage.removeEventListener(MouseEvent.MOUSE_DOWN, onDownStage);
			}
		}
		
		private function onDownStage(e:MouseEvent):void 
		{
			setDownPlace();
			Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
			Layer.stage.addEventListener(MouseEvent.MOUSE_UP, onUpStage);
		}
		
		private function onMoveStage(e:MouseEvent):void 
		{
			var moveX:Number = Layer.stage.mouseX - _mouseSrcX;
			var moveY:Number = Layer.stage.mouseY - _mouseSrcY;
			
			if (_isMove)
			{
				if (checkX(_leftTopSrcX + moveX) && checkX(_leftBottomSrcX + moveX) && checkX(_rightTopSrcX + moveX) && checkX(_rightBottomSrcX + moveX))
				{
					_leftTop.x = _leftTopSrcX + moveX;
					_leftBottom.x = _leftBottomSrcX + moveX;
					_rightTop.x = _rightTopSrcX + moveX;
					_rightBottom.x = _rightBottomSrcX + moveX;
				}
				
				if (checkY(_leftTopSrcY + moveY) && checkY(_leftBottomSrcY + moveY) && checkY(_rightTopSrcY + moveY) && checkY(_rightBottomSrcY + moveY))
				{
					_leftTop.y = _leftTopSrcY + moveY;
					_leftBottom.y = _leftBottomSrcY + moveY;
					_rightTop.y = _rightTopSrcY + moveY;
					_rightBottom.y = _rightBottomSrcY + moveY;
				}
				fixMask();
			}
		}
		
		private function onUpStage(e:MouseEvent):void 
		{
			Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveStage);
			Layer.stage.removeEventListener(MouseEvent.MOUSE_UP, onUpStage);
		}
		
		private function onDownLeftTop(e:MouseEvent):void 
		{
			_isMove = false;
			setDownPlace();
			Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveLeftTop);
			Layer.stage.addEventListener(MouseEvent.MOUSE_UP, onUpLeftTop);
		}
		
		private function onMoveLeftTop(e:MouseEvent):void 
		{
			var moveX:Number = Layer.stage.mouseX - _mouseSrcX;
			var moveY:Number = Layer.stage.mouseY - _mouseSrcY;
			var newX:Number = 0;
			var newY:Number = 0;
			
			newX = _leftTopSrcX + moveX;
			//(x2 - x1) / (y2 - y1) = MAX_WIDTH / MAX_HEIGHT
			newY = _rightBottom.y - (_rightBottom.x - newX) / (MAX_WIDTH / MAX_HEIGHT);
			if (checkPlace(newX, newY) && (_rightBottom.x - newX >= MIN_WIDTH) && (_rightBottom.y - newY >= MIN_HEIGHT))
			{
				_leftTop.x = newX;
				_leftTop.y = newY;
				_leftBottom.x = _leftTop.x;
				_rightTop.y = _leftTop.y;
				fixMask();
			}
		}
		
		private function onUpLeftTop(e:MouseEvent):void 
		{
			_isMove = true;
			Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveLeftTop);
			Layer.stage.removeEventListener(MouseEvent.MOUSE_UP, onUpLeftTop);
		}
		
		private function onDownLeftBottom(e:MouseEvent):void 
		{
			_isMove = false;
			setDownPlace();
			Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveLeftBottom);
			Layer.stage.addEventListener(MouseEvent.MOUSE_UP, onUpLeftBottom);
		}
		
		private function onMoveLeftBottom(e:MouseEvent):void 
		{
			var moveX:Number = Layer.stage.mouseX - _mouseSrcX;
			var moveY:Number = Layer.stage.mouseY - _mouseSrcY;
			var newX:Number = 0;
			var newY:Number = 0;
			
			newX = _leftBottomSrcX + moveX;
			//(x2 - x1) / (y2 - y1) = MAX_WIDTH / MAX_HEIGHT
			newY = _rightTop.y + (_rightTop.x - newX) / (MAX_WIDTH / MAX_HEIGHT);
			if (checkPlace(newX, newY) && (_rightTop.x - newX >= MIN_WIDTH) && (newY - _rightTop.y >= MIN_HEIGHT))
			{
				_leftBottom.x = newX;
				_leftBottom.y = newY;
				_leftTop.x = _leftBottom.x;
				_rightBottom.y = _leftBottom.y;
				fixMask();
			}
		}
		
		private function onUpLeftBottom(e:MouseEvent):void 
		{
			_isMove = true;
			Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveLeftBottom);
			Layer.stage.removeEventListener(MouseEvent.MOUSE_UP, onUpLeftBottom);
		}
		
		private function onDownRightTop(e:MouseEvent):void 
		{
			_isMove = false;
			setDownPlace();
			Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveRightTop);
			Layer.stage.addEventListener(MouseEvent.MOUSE_UP, onUpRightTop);
		}
		
		private function onMoveRightTop(e:MouseEvent):void 
		{
			var moveX:Number = Layer.stage.mouseX - _mouseSrcX;
			var moveY:Number = Layer.stage.mouseY - _mouseSrcY;
			var newX:Number = 0;
			var newY:Number = 0;
			
			newX = _rightTopSrcX + moveX;
			//(x2 - x1) / (y2 - y1) = MAX_WIDTH / MAX_HEIGHT
			newY = _leftBottom.y - (newX - _leftBottom.x) / (MAX_WIDTH / MAX_HEIGHT);
			if (checkPlace(newX, newY) && (newX - _leftBottom.x >= MIN_WIDTH) && (_leftBottom.y - newY >= MIN_HEIGHT))
			{
				_rightTop.x = newX;
				_rightTop.y = newY;
				_rightBottom.x = _rightTop.x;
				_leftTop.y = _rightTop.y;
				fixMask();
			}
		}
		
		private function onUpRightTop(e:MouseEvent):void 
		{
			_isMove = true;
			Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveRightTop);
			Layer.stage.removeEventListener(MouseEvent.MOUSE_UP, onUpRightTop);
		}
		
		private function onDownRightBottom(e:MouseEvent):void 
		{
			_isMove = false;
			setDownPlace();
			Layer.stage.addEventListener(MouseEvent.MOUSE_MOVE, onMoveRightBottom);
			Layer.stage.addEventListener(MouseEvent.MOUSE_UP, onUpRightBottom);
		}
		
		private function onMoveRightBottom(e:MouseEvent):void 
		{
			var moveX:Number = Layer.stage.mouseX - _mouseSrcX;
			var moveY:Number = Layer.stage.mouseY - _mouseSrcY;
			var newX:Number = 0;
			var newY:Number = 0;
			
			newX = _rightBottomSrcX + moveX;
			//(x2 - x1) / (y2 - y1) = MAX_WIDTH / MAX_HEIGHT
			newY = _leftTop.y + (newX - _leftTop.x) / (MAX_WIDTH / MAX_HEIGHT);
			if (checkPlace(newX, newY) && (newX - _leftTop.x >= MIN_WIDTH) && (newY - _leftTop.y >= MIN_HEIGHT))
			{
				_rightBottom.x = newX;
				_rightBottom.y = newY;
				_rightTop.x = _rightBottom.x;
				_leftBottom.y = _rightBottom.y;
				fixMask();
			}
		}
		
		private function onUpRightBottom(e:MouseEvent):void 
		{
			_isMove = true;
			Layer.stage.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveRightBottom);
			Layer.stage.removeEventListener(MouseEvent.MOUSE_UP, onUpRightBottom);
		}
		
		private function checkPlace(aX:Number, aY:Number):Boolean
		{
			if (aX >= _leftLimit && aX <= _rightLimit && aY >= _topLimit && aY <= _bottomLimit)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		private function checkX(aX:Number):Boolean
		{
			if (aX >= _leftLimit && aX <= _rightLimit)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		private function checkY(aY:Number):Boolean
		{
			if (aY >= _topLimit && aY <= _bottomLimit)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		private function setDownPlace():void
		{
			_mouseSrcX = Layer.stage.mouseX;
			_mouseSrcY = Layer.stage.mouseY;
			_leftTopSrcX = _leftTop.x;
			_leftTopSrcY = _leftTop.y;
			_leftBottomSrcX = _leftBottom.x;
			_leftBottomSrcY = _leftBottom.y;
			_rightTopSrcX = _rightTop.x;
			_rightTopSrcY = _rightTop.y;
			_rightBottomSrcX = _rightBottom.x;
			_rightBottomSrcY = _rightBottom.y;
		}
		
		private function fixMask():void
		{
			_leftMask.x = 0;
			_leftMask.width = _leftTop.x;
			_rightMask.x = _rightBottom.x;
			_rightMask.width = Config.STAGE_WIDTH;
			_topMask.y = 0;
			_topMask.height = _leftTop.y;
			_bottomMask.y = _rightBottom.y;
			_bottomMask.height = Config.STAGE_HEIGHT;
		}
	}
}
