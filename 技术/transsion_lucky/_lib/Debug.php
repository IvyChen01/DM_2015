<?php
/**
 * 调试
 * 静态类
 */
class Debug
{
	public static $log_file = 'log.php';//日志文件
	public static $src_time = 0;//开始时间
	
	/**
	 * 程序执行时间
	 */
	public static function runtime()
	{
		$time = microtime(true) - self::$src_time;
		if ($time < 0.001)
		{
			return 0;
		}
		
		return $time;
	}
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		$file_exists = file_exists(self::$log_file);
		$file = fopen(self::$log_file, 'a+');
		if (!$file_exists)
		{
			fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::get_client_ip() . ']	' . $str . "<br />\r\n");
		fclose($file);
	}
	
	/**
	 * 清空当天日志
	 */
	public static function clear_log()
	{
		$file_exists = file_exists(self::$log_file);
		$file = fopen(self::$log_file, 'w');
		fwrite($file, '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>' . "\r\n");
		fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		fclose($file);
	}
}
?>
