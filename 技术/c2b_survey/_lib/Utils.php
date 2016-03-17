<?php
/**
 * 公共函数库
 * 静态类
 */
class Utils
{
	/**
	 * 生成静态页
	 * $file_name	生成文件名
	 * $url	所要生成HTML的页面的URL
	 */
	public static function make_html($file_name, $url)
	{
		self::create_dir(dirname($file_name));
		ob_start();
		echo file_get_contents($url);
		file_put_contents($file_name, ob_get_clean(), LOCK_EX);
	}
	
	/**
	 * 编译PHP文件
	 * $files	待编译的PHP文件
	 * $file_make	编译生成的PHP文件
	 */
	public static function make_php($files, $file_make)
	{
		$file_write = fopen($file_make, 'w');
		fwrite($file_write, "<?php");
		foreach ($files as $value)
		{
			$str = file_get_contents($value);
			$str = preg_replace('/^<\?php/', '', $str, 1);
			$str = preg_replace("/\?>\r\n$/", '', $str, 1);
			fwrite($file_write, $str);
		}
		fwrite($file_write, "?>\r\n");
		fclose($file_write);
	}
	
	/**
	 * 递归创建文件夹	Utils::create_dir('2012/02/10")
	 * $path	路径
	 */
	public static function create_dir($path)
	{
		if (!file_exists($path))
		{
			self::create_dir(dirname($path));
			mkdir($path, 0777);
		}
	}
	
	//遍历删除目录和目录下所有文件
	public static function del_dir($dir)
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
				is_dir("$dir/$file") ? self::del_dir("$dir/$file") : @unlink("$dir/$file");
			}
		}
		if (readdir($handle) == false)
		{
			closedir($handle);
			@rmdir($dir);
		}
	}
	
	// 获取客户端IP地址
	public static function get_client_ip(){
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
	
	//中文字符串截取
	public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
	{
		switch($charset)
		{
			case 'utf-8':$char_len=3;break;
			case 'UTF8':$char_len=3;break;
			default:$char_len=2;
		}
		//小于指定长度，直接返回
		if(strlen($str)<=($length*$char_len))
		{	
			return $str;
		}
		if(function_exists("mb_substr"))
		{   
			$slice= mb_substr($str, $start, $length, $charset);
		}
		else if(function_exists('iconv_substr'))
		{
			$slice=iconv_substr($str,$start,$length,$charset);
		}
		else
		{ 
		   $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		if($suffix) 
			return $slice."…";
		return $slice;
	}
	
	// 检查字符串是否是UTF8编码,是返回true,否则返回false
	public static function is_utf8($string)
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
	
	// 自动转换字符集 支持数组转换
	public static function auto_charset($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}elseif(function_exists('iconv')){
				return iconv($from,$to,$fContents);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key =     auto_charset($key,$from,$to);
				$fContents[$_key] = auto_charset($val,$from,$to);
				if($key != $_key )
					unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
	}
	
	// 浏览器友好的变量输出
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
	
	//生成唯一的值
	public static function gen_uniqid()
	{
		return md5(uniqid(rand(), true));
	}
	
	//显示弹框消息
	public static function show_message($value)
	{
		echo '<script type="text/javascript" language="javascript"> alert("' . $value . '"); </script>';
	}
	
	/**
	 * 获取两个日期相隔的天数
	 * return $day2 - $day1
	 */
	public static function rest_days($day1, $day2)
	{
		return ceil((strtotime($day2) - strtotime($day1)) / (3600 * 24));
	}
	
	/**
	 * 获取两个日期相隔的秒数
	 * return $day2 - $day1
	 */
	public static function rest_seconds($day1, $day2)
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
}
?>
