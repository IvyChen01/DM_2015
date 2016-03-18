package com.game.lib
{
	import com.game.lib.data.AlignImage;
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.DisplayObject;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.geom.Point;
	import flash.geom.Rectangle;
	import flash.utils.ByteArray;
	
	/**
	 * 公共函数
	 * @author Shines
	 */
	public class Utils
	{
		/**
		 * 画扇形
		 * @param	mc
		 * @param	x
		 * @param	y
		 * @param	radius
		 * @param	angle
		 * @param	startFrom
		 * @param	color
		 * @param	alpha
		 * @param	angleIncrease
		 */
		public static function drawSector(mc:Sprite, x:Number, y:Number, radius:Number, angle:Number, startFrom:Number, color:uint = 0x000000, alpha:Number = 1, angleIncrease:Number = 1):void
		{
			var ax:Number = 0;
			var ay:Number = 0;
			
			if (angle <= 0)
			{
				return;
			}
			if (angle > 360)
			{
				angle = 360;
			}
			if (angleIncrease > angle)
			{
				angleIncrease = angle;
			}
			mc.graphics.moveTo(x, y);
			mc.graphics.beginFill(color, alpha);
			for (var i:Number = 0; i <= angle; i += angleIncrease)
			{
				ax = x + radius * Math.cos((startFrom + i) * Math.PI / 180);
				ay = y + radius * Math.sin((startFrom + i) * Math.PI / 180);
				mc.graphics.lineTo(ax, ay);
			}
			mc.graphics.endFill();
		}
		
		/**
		 * 调整图片大小，使其在指定范围，并保留原尺寸比例
		 * @param	image
		 * @param	maxWidth
		 * @param	maxHeight
		 * @param	isResize
		 * @return
		 */
		public static function zoomImage(image:DisplayObject, maxWidth:Number, maxHeight:Number, isResize:Boolean = true):Array
		{
			var newWidth:Number = image.width;
			var newHeight:Number = image.height;
			
			if (newWidth > maxWidth)
			{
				newWidth = maxWidth;
				if (image.width != 0)
				{
					newHeight = newWidth * image.height / image.width;
				}
			}
			if (newHeight > maxHeight)
			{
				newHeight = maxHeight;
				if (image.height != 0)
				{
					newWidth = newHeight * image.width / image.height;
				}
			}
			
			if (isResize)
			{
				image.width = newWidth;
				image.height = newHeight;
			}
			
			return [newWidth, newHeight];
		}
		
		/**
		 * 分割图片
		 * @param	image
		 * @param	row
		 * @param	col
		 * @return
		 */
		public static function splitImage(image:DisplayObject, row:int, col:int):Array
		{
			var srcBmpData:BitmapData = new BitmapData(image.width, image.height);
			var width:Number = 0;
			var height:Number = 0;
			var rect:Rectangle = null;
			var point:Point = new Point(0, 0);
			var bmpData:BitmapData = null;
			var bmp:Bitmap = null;
			var res:Array = [];
			
			if (col != 0)
			{
				width = image.width / col;
			}
			if (row != 0)
			{
				height = image.height / row;
			}
			
			srcBmpData.draw(image);
			for (var rowIndex:int = 0; rowIndex < row; rowIndex++)
			{
				for (var colIndex:int = 0; colIndex < col; colIndex++)
				{
					rect = new Rectangle(colIndex * width, rowIndex * height, width, height);
					bmpData = new BitmapData(width, height);
					bmpData.copyPixels(srcBmpData, rect, point);
					bmp = new Bitmap(bmpData);
					res.push(bmp);
				}
			}
			
			return res;
		}
		
		/**
		 * 对齐图片
		 * @param	image
		 * @param	maxWidth
		 * @param	maxHeight
		 * @param	align
		 * @param	isMove
		 * @return
		 */
		public static function alignImage(image:DisplayObject, maxWidth:Number, maxHeight:Number, align:String = "center", isMove:Boolean = true):Array
		{
			var x:Number = (maxWidth - image.width) / 2;
			var y:Number = (maxHeight - image.height) / 2;
			
			switch (align)
			{
				case AlignImage.LEFT_CENTER: 
					//左中
					x = 0;
					y = (maxHeight - image.height) / 2;
					break;
				case AlignImage.RIGHT_CENTER: 
					//右中
					x = (maxWidth - image.width);
					y = (maxHeight - image.height) / 2;
					break;
				case AlignImage.TOP_CENTER: 
					//上中
					x = (maxWidth - image.width) / 2;
					y = 0;
					break;
				case AlignImage.BOTTOM_CENTER: 
					//下中
					x = (maxWidth - image.width) / 2;
					y = (maxHeight - image.height);
					break;
				case AlignImage.LEFT_TOP: 
					//左上
					x = 0;
					y = 0;
					break;
				case AlignImage.RIGHT_TOP: 
					//右上
					x = (maxWidth - image.width);
					y = 0;
					break;
				case AlignImage.LEFT_BOTTOM: 
					//左下
					x = 0;
					y = (maxHeight - image.height);
					break;
				case AlignImage.RIGHT_BOTTOM: 
					//右下
					x = (maxWidth - image.width);
					y = (maxHeight - image.height);
					break;
				case AlignImage.CENTER: 
					//正中
					x = (maxWidth - image.width) / 2;
					y = (maxHeight - image.height) / 2;
					break;
				default: 
			}
			
			if (isMove)
			{
				image.x = x;
				image.y = y;
			}
			
			return [x, y];
		}
		
		/**
		 * 复制数据
		 * @param	value
		 * @return
		 */
		public static function copyData(value:*):*
		{
			var bytes:ByteArray = new ByteArray();
			var res:* = null;
			
			bytes.writeObject(value);
			bytes.position = 0;
			res = bytes.readObject();
			bytes.clear();
			bytes = null;
			
			return res;
		}
	}
}
