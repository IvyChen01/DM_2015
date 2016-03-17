package com.geyaa.lib
{
	import com.greensock.TweenLite;
	import flash.display.DisplayObject;
	import flash.display.MovieClip;
	import flash.display.Stage;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	import flash.utils.Dictionary;
	
	/**
	 * 提示框
	 * @author Shines
	 */
	public class MySimpleTip
	{
		private var _content:MovieClip = null; //元件
		private var _stage:Stage = null; //场景
		private var _stageWidth:Number = 0; //场景宽度
		private var _stageHeight:Number = 0; // 场景高度
		private var _maxLabelWidth:Number = 0; //提示框的最大宽度
		private var _hMargin:Number = 0; //文本水平边距
		private var _vMargin:Number = 0; //文本垂直边距
		private var _offsetX:Number = 0; //提示框水平偏移量
		private var _offsetY:Number = 0; //提示框垂直偏移量
		private var _label:TextField = null; //提示文本
		private var _bg:MovieClip = null; //提示背景
		private var _listenerDict:Dictionary = null; //DisplayObject，各侦听对象
		private var _tipDict:Dictionary = null; //String，各侦听对象的提示内容
		
		/**
		 * 构造
		 * @param	aContent	元件
		 * @param	aStage	场景
		 * @param	aStageWidth	场景宽度
		 * @param	aStageHeight	场景高度
		 * @param	aMaxLabelWidth	提示框的最大宽度
		 * @param	aHMargin	文本水平边距
		 * @param	aVMargin	文本垂直边距
		 * @param	aOffsetX	提示框水平偏移量
		 * @param	aOffsetY	提示框垂直偏移量
		 */
		public function MySimpleTip(aContent:MovieClip, aStage:Stage, aStageWidth:Number, aStageHeight:Number, aMaxLabelWidth:Number = 300, aHMargin:Number = 5, aVMargin:Number = 5, aOffsetX:Number = 20, aOffsetY:Number = 10):void
		{
			_content = aContent;
			_content.mouseEnabled = false;
			_content.mouseChildren = false;
			_stage = aStage;
			_stageWidth = aStageWidth;
			_stageHeight = aStageHeight;
			_maxLabelWidth = aMaxLabelWidth;
			_hMargin = aHMargin;
			_vMargin = aVMargin;
			_offsetX = aOffsetX;
			_offsetY = aOffsetY;
			_label = _content["label"];
			_label.wordWrap = true;
			_bg = _content["bg"];
			_listenerDict = new Dictionary();
			_tipDict = new Dictionary();
			hideContent();
		}
		
		/**
		 * 添加事件对象
		 * @param	aListener	提示对象
		 * @param	aTip	提示文本
		 */
		public function addTip(aListener:DisplayObject, aTip:String):void
		{
			_listenerDict[aListener] = aListener;
			_tipDict[aListener] = aTip;
			aListener.addEventListener(MouseEvent.ROLL_OVER, onOverListener);
			aListener.addEventListener(MouseEvent.ROLL_OUT, onOutListener);
		}
		
		/**
		 * 移入提示对象，弹出提示框
		 * @param	e
		 */
		private function onOverListener(e:MouseEvent):void
		{
			var listener:DisplayObject = DisplayObject(e.currentTarget);
			
			setTip(_tipDict[listener]);
			showTip();
			setTipPlace();
			listener.addEventListener(MouseEvent.MOUSE_MOVE, onMoveListener);
		}
		
		/**
		 * 移出提示对象，隐藏提示框
		 * @param	e
		 */
		private function onOutListener(e:MouseEvent):void
		{
			var listener:DisplayObject = DisplayObject(e.currentTarget);
			
			listener.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveListener);
			hideTip();
		}
		
		/**
		 * 在提示对象上移动，跟随移动提示框
		 * @param	e
		 */
		private function onMoveListener(e:MouseEvent):void
		{
			setTipPlace();
		}
		
		/**
		 * 设置提示框位置为鼠标位置
		 */
		private function setTipPlace():void
		{
			var tipX:Number = 0;
			var tipY:Number = 0;
			
			tipX = _stage.mouseX + _offsetX;
			tipY = _stage.mouseY + _offsetY;
			if (tipX + _bg.width > _stageWidth)
			{
				tipX = _stageWidth - _bg.width;
			}
			if (tipY + _bg.height > _stageHeight)
			{
				tipY = _stageHeight - _bg.height;
			}
			
			if (tipX < 0)
			{
				tipX = 0;
			}
			if (tipY < 0)
			{
				tipY = 0;
			}
			_content.x = tipX;
			_content.y = tipY;
		}
		
		/**
		 * 移除指定提示对象
		 * @param	aListener	提示对象
		 */
		public function removeTip(aListener:DisplayObject):void
		{
			hideContent();
			aListener.removeEventListener(MouseEvent.ROLL_OVER, onOverListener);
			aListener.removeEventListener(MouseEvent.ROLL_OUT, onOutListener);
			aListener.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveListener);
			delete _listenerDict[aListener];
			delete _tipDict[aListener];
		}
		
		/**
		 * 移除所有提示对象
		 */
		public function removeAllTips():void
		{
			hideContent();
			for each (var listener:DisplayObject in _listenerDict)
			{
				listener.removeEventListener(MouseEvent.ROLL_OVER, onOverListener);
				listener.removeEventListener(MouseEvent.ROLL_OUT, onOutListener);
				listener.removeEventListener(MouseEvent.MOUSE_MOVE, onMoveListener);
			}
			_listenerDict = new Dictionary();
			_tipDict = new Dictionary();
		}
		
		/**
		 * 设置提示对象的提示文本
		 * @param	aListener	提示对象
		 * @param	aTip	提示文本
		 */
		public function setTipData(aListener:DisplayObject, aTip:String):void
		{
			_tipDict[aListener] = aTip;
		}
		
		/**
		 * 设置提示文本框内容，及宽高等
		 * 设置提示框背景宽高
		 */
		private function setTip(value:String):void
		{
			_bg.width = _maxLabelWidth;
			_label.x = _bg.x + _hMargin;
			_label.y = _bg.y + _vMargin;
			_label.width = _maxLabelWidth - _hMargin * 2;
			_label.text = value;
			if (_label.numLines <= 1)
			{
				_bg.width = _label.textWidth + _hMargin * 2 + 3;
			}
			_label.height = _label.textHeight + 10;
			_bg.height = _label.textHeight + _vMargin * 2;
		}
		
		/**
		 * 显示提示
		 */
		private function showTip():void
		{
			showContent();
			_content.alpha = 0;
			TweenLite.to(_content, 0.5, {alpha: 1});
		}
		
		/**
		 * 隐藏提示
		 */
		private function hideTip():void
		{
			TweenLite.to(_content, 0.5, {alpha: 0, onComplete: hideContent});
		}
		
		/**
		 * 显示元件
		 */
		private function showContent():void
		{
			_content.visible = true;
			if (null == _content.parent)
			{
				_stage.addChild(_content);
			}
		}
		
		/**
		 * 隐藏元件
		 */
		private function hideContent():void
		{
			_content.visible = false;
			if (_content.parent != null)
			{
				_content.parent.removeChild(_content);
			}
		}
	}
}
