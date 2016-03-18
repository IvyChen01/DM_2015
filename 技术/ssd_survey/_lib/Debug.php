<?php
/**
 * 调试
 * 静态类
 * @author Shines
 */
class Debug
{
	public static $logFile = 'log.php';//日志文件
	public static $timeFile = 'time_log.php';//日志文件
	public static $srcTime = 0;//开始时间
	public static $maxTime = 0.01;//最大时间，超过最大时间则加粗显示
	
	/**
	 * 程序执行时间
	 */
	public static function runtime()
	{
		$time = microtime(true) - self::$srcTime;
		$time = round($time, 3);
		return $time;
	}
	
	/**
	 * 添加日志记录
	 * $str	记录内容
	 */
	public static function log($str)
	{
		$fileExists = file_exists(self::$logFile);
		$file = fopen(self::$logFile, 'a+');
		if (!$fileExists)
		{
			fwrite($file, '<?php if (!defined(\'VIEW\')) exit; ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . "<br />\r\n");
		fclose($file);
	}
	
	/**
	 * 添加执行时间日志记录
	 * $str	记录内容
	 */
	public static function logTime($str)
	{
		$fileExists = file_exists(self::$timeFile);
		$file = fopen(self::$timeFile, 'a+');
		if (!$fileExists)
		{
			fwrite($file, '<?php if (!defined(\'VIEW\')) exit; ?>' . "\r\n");
			fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
		}
		$time = self::runtime();
		if ($time >= self::$maxTime)
		{
			fwrite($file, '<b>[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . ' time: ' . $time . "</b><br />\r\n");
		}
		else
		{
			fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . ' time: ' . $time . "<br />\r\n");
		}
		fclose($file);
	}
	
	/**
	 * 添加执行时间日志记录，超出最大时间才记录
	 * $str	记录内容
	 */
	public static function logMaxTime($str)
	{
		$time = self::runtime();
		if ($time >= self::$maxTime)
		{
			$fileExists = file_exists(self::$timeFile);
			$file = fopen(self::$timeFile, 'a+');
			if (!$fileExists)
			{
				fwrite($file, '<?php if (!defined(\'VIEW\')) exit; ?>' . "\r\n");
				fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n");
			}
			fwrite($file, '[' . Utils::mdate('H:i:s') . ' ' . Utils::getClientIp() . ']	' . $str . ' time: ' . $time . "<br />\r\n");
			fclose($file);
		}
	}
}
?>
