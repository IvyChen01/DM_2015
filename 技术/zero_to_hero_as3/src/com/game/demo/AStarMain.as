package com.game.demo
{
	import com.game.lib.AStar;
	import flash.display.Sprite;
	import flash.events.Event;
	
	/**
	 * 寻路示例
	 * @author Shines
	 */
	public class AStarMain extends Sprite
	{
		public function AStarMain():void
		{
			if (stage)
			{
				init();
			}
			else
			{
				addEventListener(Event.ADDED_TO_STAGE, init);
			}
		}
		
		/**
		 * 初始化
		 * @param	e
		 */
		private function init(e:Event = null):void
		{
			if (e != null)
			{
				removeEventListener(Event.ADDED_TO_STAGE, init);
			}
			
			var map:Array = [
				[0, 0, 0, 0, 0],
				[0, 0, -1, 0, 0],
				[0, -1, -1, 0, 0],
				[0, 0, 0, 0, 0],
				[0, 0, 0, 0, 0]
			];
			
			var way:Array = AStar.findWay(map, 0, 0, 3, 3, 1, 1);
			
			trace("map:");
			echoArray2(map);
			trace("way:");
			if (way != null)
			{
				echoArray2(way);
			}
		}
		
		private function echoArray2(value:Array):void
		{
			var str:String = "";
			
			for (var row:int = 0; row < value.length; row++)
			{
				for (var col:int = 0; col < value[0].length; col++)
				{
					str += strNum(value[row][col], 4);
				}
				str += "\n";
			}
			trace(str);
		}
		
		private function strNum(value:Number, len:int):String
		{
			var str:String = value.toString();
			
			return replicate(" ", len - str.length) + str;
		}
		
		private function replicate(char:String, count:int):String
		{
			var res:String = "";
			
			for (var i:int = 0; i < count; i++)
			{
				res += char;
			}
			
			return res;
		}
	}
}
