<?php
/**
 * 调试
 * 静态类
 */
class Debug
{
	public static $log_enabled = false;//日志开关，true:打开，false:关闭
	public static $log_file = 'log.php';//日志文件
	public static $src_time = 0;//开始时间
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		if (self::$log_enabled)
		{
			if (file_exists(self::$log_file))
			{
				$file = fopen(self::$log_file, 'a+');
				fwrite($file, '[' . date('H:i:s') . ' ' . Utils::get_client_ip() . '] ' . $str . "<br />\r\n");
			}
			else
			{
				$file = fopen(self::$log_file, 'a+');
				fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n" . '[' . date('H:i:s') . ' ' . Utils::get_client_ip() . '] ' . $str . "<br />\r\n");
			}
			fclose($file);
		}
	}
	
	/**
	 * 程序执行时间
	 */
	public static function runtime()
	{
		return microtime(true) - self::$src_time;
	}
}
?>
