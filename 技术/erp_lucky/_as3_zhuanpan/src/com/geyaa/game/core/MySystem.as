package com.geyaa.game.core
{
	import com.geyaa.game.module.hall.HallMain;
	import com.geyaa.game.module.loading.LoadProgres;
	import com.geyaa.lib.events.LoaderEvent;
	import com.geyaa.lib.loading.MyLoader;
	import com.geyaa.lib.MyDebug;
	
	/**
	 * 系统管理
	 * @author Shines
	 */
	public class MySystem
	{
		public function MySystem():void
		{
			init();
		}
		
		/**
		 * 初始化
		 * 加载配置文件、主界面资源
		 */
		private function init():void
		{
			MyModule.hall = new HallMain();
		}
	}
}
