package com.game.module.hall
{
	import com.game.core.Config;
	import com.game.core.Layer;
	import com.game.lib.Debug;
	import com.game.lib.loading.MyLoader;
	import com.game.lib.MyButton;
	import com.greensock.motionPaths.RectanglePath2D;
	import com.greensock.TweenLite;
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.geom.Matrix;
	import flash.geom.Point;
	import flash.geom.Rectangle;
	
	public class EditPanel extends EventDispatcher
	{
		private var _content:MovieClip = null;
		private var _pic:MovieClip = null;//元件
		private var _mcEdit:McEdit = null;
		private var _okBtn:MyButton = null;
		private var _isAddEvents:Boolean = false;//是否已添加事件
		
		private var _picX:Number = 0;
		private var _picY:Number = 0;
		private var _picWidth:Number = 0;
		private var _picHeight:Number = 0;
		
		public function EditPanel(aContent:MovieClip):void
		{
			_content = aContent;
			_content.gotoAndStop(1);
			_pic = MovieClip(_content["pic"]);
			_mcEdit = new McEdit(_content["edit"], _content["leftMask"], _content["rightMask"], _content["topMask"], _content["bottomMask"]);
			_okBtn = new MyButton(_content["okBtn"]);
			_content.visible = false;
		}
		
		public function setPic(aPic:Bitmap):void
		{
			var rate:Number = 0;
			
			while (_pic.numChildren > 0)
			{
				_pic.removeChildAt(0);
			}
			_pic.addChild(aPic);
			rate = aPic.width / aPic.height;
			if (rate > Config.STAGE_WIDTH / Config.STAGE_HEIGHT)
			{
				//横向图片
				aPic.width = Config.STAGE_WIDTH;
				aPic.height = aPic.width / rate;
				aPic.y = (Config.STAGE_HEIGHT - aPic.height) / 2;
				_mcEdit.setPlace(aPic.x + (aPic.width - aPic.height) / 2, aPic.y, aPic.height, aPic.height);
			}
			else
			{
				//竖向图片
				aPic.height = Config.STAGE_HEIGHT;
				aPic.width = rate * aPic.height;
				aPic.x = (Config.STAGE_WIDTH - aPic.width) / 2;
				_mcEdit.setPlace(aPic.x, aPic.y + (aPic.height - aPic.width) / 2, aPic.width, aPic.width);
			}
			_mcEdit.setLimit(aPic.x, aPic.y, aPic.x + aPic.width, aPic.y + aPic.height);
		}
		
		public function getPic():Bitmap
		{
			var bmp:Bitmap = null;
			var bmpData:BitmapData = null;
			var obj:Object = null;
			var mat:Matrix = null;
			var rect:Rectangle = null;
			
			obj = _mcEdit.getRect();
			mat = new Matrix();
			mat.translate(-obj.x, -obj.y);
			rect = new Rectangle(0, 0, obj.width, obj.height);
			bmpData = new BitmapData(obj.width, obj.height);
			bmpData.draw(_pic, mat, null, null, rect);
			bmp = new Bitmap(bmpData);
			
			return bmp;
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
		 * 添加事件
		 */
		private function addEvents():void
		{
			if (!_isAddEvents)
			{
				_isAddEvents = true;
				_okBtn.addEventListener(MouseEvent.CLICK, onClickOk);
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
				_okBtn.removeEventListener(MouseEvent.CLICK, onClickOk);
			}
		}
		
		private function onClickOk(e:MouseEvent):void 
		{
			this.dispatchEvent(e);
		}
	}
}
