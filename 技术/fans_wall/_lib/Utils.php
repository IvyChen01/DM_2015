<?php
/**
 * 公共函数库
 * 静态类
 */
class Utils
{
	/**
	 * 获取日期时间
	 */
	public static function mdate($format, $dateStr = '')
	{
		if (empty($dateStr))
		{
			$date = new DateTime();
		}
		else
		{
			try
			{
				$date = new DateTime($dateStr);
			}
			catch (Exception $e)
			{
				$date = new DateTime('1970-01-01 08:00:00');
			}
		}
		
		return $date->format($format);
	}
	
	/**
	 * 获取客户端IP地址
	 */
	public static function getClientIp()
	{
	   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		   $ip = getenv("HTTP_CLIENT_IP");
	   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		   $ip = getenv("HTTP_X_FORWARDED_FOR");
	   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		   $ip = getenv("REMOTE_ADDR");
	   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		   $ip = $_SERVER['REMOTE_ADDR'];
	   else
		   $ip = "unknown";
		
	   return $ip;
	}
	
	/**
	 * 递归创建文件夹	Utils::createDir('2012/02/10")
	 * $path	路径
	 */
	public static function createDir($path)
	{
		if (!file_exists($path))
		{
			self::createDir(dirname($path));
			mkdir($path, 0777);
		}
	}
	
	/**
	 * 遍历删除目录和目录下所有文件
	 */
	public static function delDir($dir)
	{
		if (!is_dir($dir))
		{
			return false;
		}
		$handle = opendir($dir);
		while (($file = readdir($handle)) !== false)
		{
			if ($file != "." && $file != "..")
			{
				is_dir("$dir/$file") ? self::delDir("$dir/$file") : @unlink("$dir/$file");
			}
		}
		if (readdir($handle) == false)
		{
			closedir($handle);
			@rmdir($dir);
		}
	}
	
	/**
	 * 中文字符串截取，有多余字符末尾自动加“...”
	 */
	public static function msubstr($str, $start, $length, $autoExtend = true, $charset='utf-8')
	{
		$srcLen = mb_strlen($str, $charset);
		$newStr = mb_substr($str, $start, $length, $charset);
		$newLen = mb_strlen($newStr, $charset);
		if ($autoExtend && $srcLen > $newLen)
		{
			$newStr .= '...';
		}
		
		return $newStr;
	}
	
	/**
	 * 检查字符串是否是UTF8编码,是返回true,否则返回false
	 */
	public static function isUtf8($string)
	{
		return preg_match('%^(?:
			 [\x09\x0A\x0D\x20-\x7E]            # ASCII
		   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	   )*$%xs', $string);
	}
	
	/**
	 * 浏览器友好的变量输出
	 */
	public static function dump($var, $exit=false)
	{
		ob_start();
		var_dump($var);
		$output = ob_get_clean();
		if(!extension_loaded('xdebug'))
		{
				$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
				$output = '<pre>'. htmlspecialchars($output, ENT_QUOTES). '</pre>';
		}
		echo $output;
		
		if ($exit)
		{
			exit;//终止程序
		}
		else
		{
			return;
		}
	}
	
	/**
	 * 生成唯一的值
	 */
	public static function genUniqid()
	{
		return md5(uniqid(rand(), true));
	}
	
	/**
	 * 获取两个日期相隔的天数
	 * return $day2 - $day1
	 */
	public static function restDays($day1, $day2)
	{
		return ceil((strtotime($day2) - strtotime($day1)) / (3600 * 24));
	}
	
	/**
	 * 获取两个日期相隔的秒数
	 * return $day2 - $day1
	 */
	public static function restSeconds($day1, $day2)
	{
		return strtotime($day2) - strtotime($day1);
	}
	
	/**
	 * 生成$n个字符串
	 */
	public static function replicate($str, $n)
	{
		$res = '';
		for ($i = 0; $i < $n; $i++)
		{
			$res .= $str;
		}
		
		return $res;
	}
	
	/**
	 * 获取指定格式日期
	 */
	public static function formatDate($date)
	{
		$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$month = (int)self::mdate('m', $date);
		
		return $monthEn[$month - 1] . self::mdate(' j, Y', $date);
	}
	
	/**
	 * 判断是否用移动设备打开网站
	 */
	public static function checkMobile()
	{
		$touchBrowserList = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
					'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
					'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
					'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
					'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
					'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
					'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone');
		$wmlBrowserList = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
				'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
				'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte', 'linux');
		$padList = array('ipad');
		$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		if(self::dstrpos($useragent, $padList)) {
			return false;
		}
		
		$v = self::dstrpos($useragent, $touchBrowserList, true);
		if($v) {
			return $v;
		}
		
		if(self::dstrpos($useragent, $wmlBrowserList)) {
			return true;
		}
		
		if(self::dstrpos($useragent, $brower)) {
			return false;
		}
		
		return false;
		
		/*
		if (strpos(strtolower($_SERVER['REQUEST_URI']), 'wap'))
		{
			return true;
		}
		else
		{
			return false;
		}
		*/
	}
	
	/**
	 * 判断数组里是否包含指定字符串
	 */
	public static function dstrpos($string, $arr, $returnvalue = false) {
		if (empty($string)) return false;
		foreach ((array)$arr as $v) {
			if(strpos($string, $v) !== false) {
				$return = $returnvalue ? $v : true;
				return $return;
			}
		}
		
		return false;
	}
	
	/**
	 * 生成惟一文件名
	 */
	public static function genFilename($extend = '')
	{
		return time() . rand(100000, 999999) . $extend;
	}
	
	/**
	 * 编译PHP文件
	 * $files	待编译的PHP文件
	 * $fileMake	编译生成的PHP文件
	 */
	public static function makePhp($files, $fileMake, $extendsCode)
	{
		$fileWrite = fopen($fileMake, 'w');
		fwrite($fileWrite, "<?php");
		foreach ($files as $value)
		{
			$str = file_get_contents($value);
			$str = preg_replace('/^<\?php/', '', $str, 1);
			$str = preg_replace("/\?>\r\n$/", '', $str, 1);
			fwrite($fileWrite, $str);
		}
		if (!empty($extendsCode))
		{
			fwrite($fileWrite, $extendsCode . "\r\n");
		}
		fwrite($fileWrite, "?>\r\n");
		fclose($fileWrite);
	}
}
?>
