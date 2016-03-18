package com.game.core
{
	import com.game.module.hall.HallMain;
	import com.game.module.loading.LoadProgress;
	
	/**
	 * 模块管理器
	 * @author Shines
	 */
	public class Module
	{
		public static var progress:LoadProgress = null;//加载进度模块
		public static var hall:HallMain = null;//大厅模块
	}
}
