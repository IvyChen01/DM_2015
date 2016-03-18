package com.game.core
{
	import com.game.lib.Debug;
	import flash.external.ExternalInterface;
	
	/**
	 * JS调用
	 * @author Shines
	 */
	public class MyJs
	{
		/**
		 * 发facebook feed
		 */
		public static function feed(link:String, picture:String):void
		{
			try
			{
				if (ExternalInterface.available)
				{
					ExternalInterface.call("feed", link, picture);
				}
			}
			catch (e:Error)
			{
				Debug.log("feed error");
			}
		}
		
		/**
		 * 发facebook邀请
		 */
		public static function invite():void
		{
			try
			{
				if (ExternalInterface.available)
				{
					ExternalInterface.call("invite");
				}
			}
			catch (e:Error)
			{
				Debug.log("invite error");
			}
		}
		
		public static function rank():void
		{
			try
			{
				if (ExternalInterface.available)
				{
					ExternalInterface.call("rank");
				}
			}
			catch (e:Error)
			{
				Debug.log("rank error");
			}
		}
	}
}
