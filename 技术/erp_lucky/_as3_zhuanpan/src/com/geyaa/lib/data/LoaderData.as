package com.geyaa.lib.data
{
	/**
	 * 加载数据
	 * @author Shines
	 */
	public class LoaderData
	{
		public var url:String = ""; //加载文件名
		public var type:String = ""; //加载类型
		
		/**
		 * 加载类型数据
		 * @param	aUrl	文件名
		 * @param	aType	类型
		 */
		public function LoaderData(aUrl:String = "", aType:String = ""):void
		{
			url = aUrl;
			type = aType;
		}
	}
}
