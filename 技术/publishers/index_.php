<?php
//表单验证类
//静态类
class Check
{
	//执行验证规则
	/*
		用法：
		Check::rule(
					array(验证函数1，'错误返回值1'),
					array(验证函数2，'错误返回值2'),
					);
		若有一个验证函数返回false,则返回对应的错误返回值，若全部通过验证，则返回true。
		验证函数，可以是自定义的函数或类方法，返回true表示通过，返回false，表示没有通过
	*/
	public static function rule($array=array())
	{
		//可以采用数组传参，也可以采用无限个参数方式传参
		if(!isset($array[0][0]))
			$array=func_get_args();
			
		if(is_array($array))
		{
			foreach($array as $vo)
			{
				if(is_array($vo)&&isset($vo[0])&&isset($vo[1]))
				{
					if(!$vo[0])
						return $vo[1];
				}
			}
		}
		return true;
	}
	
	//检查字符串长度
    public static function len($str,$min=0,$max=255)
   {
		$str=trim($str);
		if(empty($str))
			return true;
		$len=strlen($str);
		if(($len>=$min)&&($len<=$max))
			return true;		
		else
			return false;	  
	}
	
	//检查字符串是否为空
	public static function must($str)
	{
		$str=trim($str);
		return !empty($str);
	}  
	
	//检查两次输入的值是否相同
    public static function same($str1,$str2)
    {
   		return $str1==$str2;
    }
	
	//检查用户名
	public static function userName($str,$len_min=0,$len_max=255,$type='ALL')
	{
		if(empty($str))
			return true;
		if(self::len($str,$len_min,$len_max)==false)
		{
			return false;
		}
		
		switch($type)
		{
			//纯英文
			case "EN":$pattern="/^[a-zA-Z]+$/";break;
				//英文数字
			case "ENNUM":$pattern="/^[a-zA-Z0-9]+$/"; break;
			  //允许的符号(|-_字母数字)
			case "ALL":$pattern="/^[\-\_a-zA-Z0-9]+$/"; break;
			//用户自定义正则
			default:$pattern=$type;break;
		}
		
		if(preg_match($pattern,$str))
			 return true;
		else
			 return false;
	}
	
	//验证邮箱
	public static function email($str)
	{
		if(empty($str))
			return false;
		$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
		if (strpos($str, '@') !== false && strpos($str, '.') !== false){
			if (preg_match($chars, $str)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	//验证手机号码
	public  static function mobile($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $str);
	}
	
	//验证固定电话
	public  static function tel($str)
	{
		if (empty($str)) {
			return true;
		}
		return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/', trim($str));
	}

	//验证qq号码
	public  static function qq($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('/^[1-9]\d{4,12}$/', trim($str));
	}
	
	//验证邮政编码
	public  static function zipCode($str)
	{
		if (empty($str)) {
			return true;
		}
		
		return preg_match('/^[1-9]\d{5}$/', trim($str));
	}
	
	//验证ip
	public static function ip($str)
	{
		if(empty($str))
			return true;	
		
		if (!preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str)) {
			return false;			
		}
		
		$ip_array = explode('.', $str);
		
		//真实的ip地址每个数字不能大于255（0-255）		
		return ($ip_array[0]<=255 && $ip_array[1]<=255 && $ip_array[2]<=255 && $ip_array[3]<=255) ? true : false;
	}	
	
    //验证身份证(中国)
    public  static function idCard($str)
    {
		$str=trim($str);
		if(empty($str))
			return true;	
			
		if(preg_match("/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i",$str))
			 return true;
		else
			 return false;
     }

	//验证网址
	public  static function url($str) 
	{
		if(empty($str))
			return true;	
		
		return preg_match('#(http|https|ftp|ftps)://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?#i', $str) ? true : false;
	}
}

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

/**
 * 文件缓存
 * 静态类
 * @author Shines
 */
class FileCache
{
	private static $header = '<?php exit;//file cache rnd:jfs@#$%$%gieu89v7kfnkf^*^*%^&n34805f ?>';//缓存头部，防止单独打开文件
	
	/**
	 * 写入文件缓存
	 */
	public static function write($filename, $str)
	{
		$file = fopen($filename, 'w');
		fwrite($file, self::$header . $str);
		fclose($file);
	}
	
	/**
	 * 读取文件缓存
	 */
	public static function read($filename)
	{
		if (file_exists($filename))
		{
			return str_replace(self::$header, '', file_get_contents($filename));
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 删除文件缓存
	 */
	public static function clear($filename)
	{
		if (file_exists($filename))
		{
			@unlink($filename);
		}
	}
}

//数据采集，doGET,doPOST,文件下载，
//静态类
class Http
{
	static public $way=0;
	//手动设置访问方式
	static public function setWay($way)
	{
		self::$way=intval($way);
	}
	static public function getSupport()
	{
		//如果指定访问方式，则按指定的方式去访问
		if (isset(self::$way) && in_array(self::$way, array(1, 2, 3)))
		{
			return self::$way;
		}
		
		//自动获取最佳访问方式	
		if (function_exists('curl_init'))//curl方式
		{
			return 1;
		}
		else if (function_exists('fsockopen'))//socket
		{
			return 2;
		}
		else if (function_exists('file_get_contents'))//php系统函数file_get_contents
		{
			return 3;
		}
		else
		{
			return 0;
		}	
	}
	
	//通过get方式获取数据
	static public function doGet($url,$timeout=5,$header="") 
	{	
		if(empty($url)||empty($timeout))
			return false;
		if(!preg_match('/^(http|https)/is',$url))
			$url="http://".$url;
		$code=self::getSupport();
		switch($code)
		{
			case 1:return self::curlGet($url,$timeout,$header);break;
			case 2:return self::socketGet($url,$timeout,$header);break;
			case 3:return self::phpGet($url,$timeout,$header);break;
			default:return false;	
		}
	}
	
	//通过POST方式发送数据
	static public function doPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		if(empty($url)||empty($post_data)||empty($timeout))
			return false;
		if(!preg_match('/^(http|https)/is',$url))
			$url="http://".$url;
		$code=self::getSupport();
		switch($code)
		{
			case 1:return self::curlPost($url,$post_data,$timeout,$header);break;
			case 2:return self::socketPost($url,$post_data,$timeout,$header);break;
			case 3:return self::phpPost($url,$post_data,$timeout,$header);break;
			default:return false;	
		}
	}
	
	//通过curl get数据
	static public function curlGet($url,$timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));//模拟的header头
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
	//通过curl post数据
	static public function curlPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		$header=empty($header)?'':$header;
		$post_string = http_build_query($post_data);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));//模拟的header头
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
	//通过socket get数据
	static public function socketGet($url,$timeout=5,$header="")
	{
		$header=empty($header)?self::defaultHeader():$header;
		$url2 = parse_url($url);
		$url2["path"] = isset($url2["path"])? $url2["path"]: "/" ;
		$url2["port"] = isset($url2["port"])? $url2["port"] : 80;
		$url2["query"] = isset($url2["query"])? "?".$url2["query"] : "";
		$host_ip = @gethostbyname($url2["host"]);

		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $timeout)) < 0){
			return false;
		}
		$request =  $url2["path"] .$url2["query"];
		$in  = "GET " . $request . " HTTP/1.0\r\n";
		if(false===strpos($header, "Host:"))
		{	
			 $in .= "Host: " . $url2["host"] . "\r\n";
		}
		$in .= $header;
		$in .= "Connection: Close\r\n\r\n";
		
		if(!@fwrite($fsock, $in, strlen($in))){
			@fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}
	
	//通过socket post数据
	static public function socketPost($url, $post_data=array(), $timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$post_string = http_build_query($post_data);  
		
		
		$url2 = parse_url($url);
		$url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
		$url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
		$host_ip = @gethostbyname($url2["host"]);
		$fsock_timeout = $timeout; //超时时间
		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
			return false;
		}
		$request =  $url2["path"].($url2["query"] ? "?" . $url2["query"] : "");
		$in  = "POST " . $request . " HTTP/1.0\r\n";
		$in .= "Host: " . $url2["host"] . "\r\n";
		$in .= $header;
		$in .= "Content-type: application/x-www-form-urlencoded\r\n";
		$in .= "Content-Length: " . strlen($post_string) . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$in .= $post_string . "\r\n\r\n";
		unset($post_string);
		if(!@fwrite($fsock, $in, strlen($in))){
			@fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}
	
	//通过file_get_contents函数get数据
	static public function phpGet($url,$timeout=5,$header="") 
	{
		$header=empty($header)?self::defaultHeader():$header;
		$opts = array( 
				'http'=>array(
							'protocol_version'=>'1.0', //http协议版本(若不指定php5.2系默认为http1.0)
							'method'=>"GET",//获取方式
							'timeout' => $timeout ,//超时时间
							'header'=> $header)
				  ); 
		$context = stream_context_create($opts);
		return  @file_get_contents($url,false,$context);
	}
	
	//通过file_get_contents 函数post数据
	static public function phpPost($url, $post_data = array(), $timeout = 5, $header = "")
	{
		$header=empty($header)?self::defaultHeader():$header;
		$post_string = http_build_query($post_data);
		$header.="Content-length: ".strlen($post_string);
		$opts = array(
				'http'=>array(
							'protocol_version'=>'1.0',//http协议版本(若不指定php5.2系默认为http1.0)
							'method'=>"POST",//获取方式
							'timeout' => $timeout ,//超时时间
							'header'=> $header,
							'content'=> $post_string)
				  );
		$context = stream_context_create($opts);
		return  @file_get_contents($url,false,$context);
	}
	
	//默认模拟的header头
	static private function defaultHeader()
	{
		$header="User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12\r\n";
		$header.="Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n";
		$header.="Accept-language: zh-cn,zh;q=0.5\r\n";
		$header.="Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n";
		return $header;
	}
	
	//获取通过socket方式get和post页面的返回数据
	static private function GetHttpContent($fsock=null)
	{
		$out = null;
		while($buff = @fgets($fsock, 2048)){
			 $out .= $buff;
		}
		fclose($fsock);
		$pos = strpos($out, "\r\n\r\n");
		$head = substr($out, 0, $pos);//http head
		$status = substr($head, 0, strpos($head, "\r\n"));//http status line
		$body = substr($out, $pos + 4, strlen($out) - ($pos + 4));//page body
		if(preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches))
		{
			if(intval($matches[1]) / 100 == 2)
			{
				return $body;  
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/*
     功能： 下载文件
     参数:$filename 下载文件路径
     $showname 下载显示的文件名
     $expire  下载内容浏览器缓存时间
	*/
    static public function download($filename, $showname='',$expire=1800) 
	{
        if(file_exists($filename)&&is_file($filename)) 
		{
            $length = filesize($filename);
        }
		else 
		{
          die('下载文件不存在！');
        }

	    $type = mime_content_type($filename);

        //发送Http Header信息 开始下载
        header("Pragma: public");
        header("Cache-control: max-age=".$expire);
        //header('Cache-Control: no-store, no-cache, must-revalidate');
        header("Expires: " . gmdate("D, d M Y H:i:s",time()+$expire) . "GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()) . "GMT");
        header("Content-Disposition: attachment; filename=".$showname);
        header("Content-Length: ".$length);
        header("Content-type: ".$type);
        header('Content-Encoding: none');
        header("Content-Transfer-Encoding: binary" );
        readfile($filename);
        return true;
    }
}

if( !function_exists ('mime_content_type')) {
    /**
     +----------------------------------------------------------
     * 获取文件的mime_content类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    function mime_content_type($filename)
    {
       static $contentType = array(
			'ai'	=> 'application/postscript',
				'aif'	=> 'audio/x-aiff',
				'aifc'	=> 'audio/x-aiff',
				'aiff'	=> 'audio/x-aiff',
				'asc'	=> 'application/pgp', //changed by skwashd - was text/plain
				'asf'	=> 'video/x-ms-asf',
				'asx'	=> 'video/x-ms-asf',
				'au'	=> 'audio/basic',
				'avi'	=> 'video/x-msvideo',
				'bcpio'	=> 'application/x-bcpio',
				'bin'	=> 'application/octet-stream',
				'bmp'	=> 'image/bmp',
				'c'	=> 'text/plain', // or 'text/x-csrc', //added by skwashd
				'cc'	=> 'text/plain', // or 'text/x-c++src', //added by skwashd
				'cs'	=> 'text/plain', //added by skwashd - for C# src
				'cpp'	=> 'text/x-c++src', //added by skwashd
				'cxx'	=> 'text/x-c++src', //added by skwashd
				'cdf'	=> 'application/x-netcdf',
				'class'	=> 'application/octet-stream',//secure but application/java-class is correct
				'com'	=> 'application/octet-stream',//added by skwashd
				'cpio'	=> 'application/x-cpio',
				'cpt'	=> 'application/mac-compactpro',
				'csh'	=> 'application/x-csh',
				'css'	=> 'text/css',
				'csv'	=> 'text/comma-separated-values',//added by skwashd
				'dcr'	=> 'application/x-director',
				'diff'	=> 'text/diff',
				'dir'	=> 'application/x-director',
				'dll'	=> 'application/octet-stream',
				'dms'	=> 'application/octet-stream',
				'doc'	=> 'application/msword',
				'dot'	=> 'application/msword',//added by skwashd
				'dvi'	=> 'application/x-dvi',
				'dxr'	=> 'application/x-director',
				'eps'	=> 'application/postscript',
				'etx'	=> 'text/x-setext',
				'exe'	=> 'application/octet-stream',
				'ez'	=> 'application/andrew-inset',
				'gif'	=> 'image/gif',
				'gtar'	=> 'application/x-gtar',
				'gz'	=> 'application/x-gzip',
				'h'	=> 'text/plain', // or 'text/x-chdr',//added by skwashd
				'h++'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hh'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hpp'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hxx'	=> 'text/plain', // or 'text/x-c++hdr', //added by skwashd
				'hdf'	=> 'application/x-hdf',
				'hqx'	=> 'application/mac-binhex40',
				'htm'	=> 'text/html',
				'html'	=> 'text/html',
				'ice'	=> 'x-conference/x-cooltalk',
				'ics'	=> 'text/calendar',
				'ief'	=> 'image/ief',
				'ifb'	=> 'text/calendar',
				'iges'	=> 'model/iges',
				'igs'	=> 'model/iges',
				'jar'	=> 'application/x-jar', //added by skwashd - alternative mime type
				'java'	=> 'text/x-java-source', //added by skwashd
				'jpe'	=> 'image/jpeg',
				'jpeg'	=> 'image/jpeg',
				'jpg'	=> 'image/jpeg',
				'js'	=> 'application/x-javascript',
				'kar'	=> 'audio/midi',
				'latex'	=> 'application/x-latex',
				'lha'	=> 'application/octet-stream',
				'log'	=> 'text/plain',
				'lzh'	=> 'application/octet-stream',
				'm3u'	=> 'audio/x-mpegurl',
				'man'	=> 'application/x-troff-man',
				'me'	=> 'application/x-troff-me',
				'mesh'	=> 'model/mesh',
				'mid'	=> 'audio/midi',
				'midi'	=> 'audio/midi',
				'mif'	=> 'application/vnd.mif',
				'mov'	=> 'video/quicktime',
				'movie'	=> 'video/x-sgi-movie',
				'mp2'	=> 'audio/mpeg',
				'mp3'	=> 'audio/mpeg',
				'mpe'	=> 'video/mpeg',
				'mpeg'	=> 'video/mpeg',
				'mpg'	=> 'video/mpeg',
				'mpga'	=> 'audio/mpeg',
				'ms'	=> 'application/x-troff-ms',
				'msh'	=> 'model/mesh',
				'mxu'	=> 'video/vnd.mpegurl',
				'nc'	=> 'application/x-netcdf',
				'oda'	=> 'application/oda',
				'patch'	=> 'text/diff',
				'pbm'	=> 'image/x-portable-bitmap',
				'pdb'	=> 'chemical/x-pdb',
				'pdf'	=> 'application/pdf',
				'pgm'	=> 'image/x-portable-graymap',
				'pgn'	=> 'application/x-chess-pgn',
				'pgp'	=> 'application/pgp',//added by skwashd
				'php'	=> 'application/x-httpd-php',
				'php3'	=> 'application/x-httpd-php3',
				'pl'	=> 'application/x-perl',
				'pm'	=> 'application/x-perl',
				'png'	=> 'image/png',
				'pnm'	=> 'image/x-portable-anymap',
				'po'	=> 'text/plain',
				'ppm'	=> 'image/x-portable-pixmap',
				'ppt'	=> 'application/vnd.ms-powerpoint',
				'ps'	=> 'application/postscript',
				'qt'	=> 'video/quicktime',
				'ra'	=> 'audio/x-realaudio',
				'rar'=>'application/octet-stream',
				'ram'	=> 'audio/x-pn-realaudio',
				'ras'	=> 'image/x-cmu-raster',
				'rgb'	=> 'image/x-rgb',
				'rm'	=> 'audio/x-pn-realaudio',
				'roff'	=> 'application/x-troff',
				'rpm'	=> 'audio/x-pn-realaudio-plugin',
				'rtf'	=> 'text/rtf',
				'rtx'	=> 'text/richtext',
				'sgm'	=> 'text/sgml',
				'sgml'	=> 'text/sgml',
				'sh'	=> 'application/x-sh',
				'shar'	=> 'application/x-shar',
				'shtml'	=> 'text/html',
				'silo'	=> 'model/mesh',
				'sit'	=> 'application/x-stuffit',
				'skd'	=> 'application/x-koan',
				'skm'	=> 'application/x-koan',
				'skp'	=> 'application/x-koan',
				'skt'	=> 'application/x-koan',
				'smi'	=> 'application/smil',
				'smil'	=> 'application/smil',
				'snd'	=> 'audio/basic',
				'so'	=> 'application/octet-stream',
				'spl'	=> 'application/x-futuresplash',
				'src'	=> 'application/x-wais-source',
				'stc'	=> 'application/vnd.sun.xml.calc.template',
				'std'	=> 'application/vnd.sun.xml.draw.template',
				'sti'	=> 'application/vnd.sun.xml.impress.template',
				'stw'	=> 'application/vnd.sun.xml.writer.template',
				'sv4cpio'	=> 'application/x-sv4cpio',
				'sv4crc'	=> 'application/x-sv4crc',
				'swf'	=> 'application/x-shockwave-flash',
				'sxc'	=> 'application/vnd.sun.xml.calc',
				'sxd'	=> 'application/vnd.sun.xml.draw',
				'sxg'	=> 'application/vnd.sun.xml.writer.global',
				'sxi'	=> 'application/vnd.sun.xml.impress',
				'sxm'	=> 'application/vnd.sun.xml.math',
				'sxw'	=> 'application/vnd.sun.xml.writer',
				't'	=> 'application/x-troff',
				'tar'	=> 'application/x-tar',
				'tcl'	=> 'application/x-tcl',
				'tex'	=> 'application/x-tex',
				'texi'	=> 'application/x-texinfo',
				'texinfo'	=> 'application/x-texinfo',
				'tgz'	=> 'application/x-gtar',
				'tif'	=> 'image/tiff',
				'tiff'	=> 'image/tiff',
				'tr'	=> 'application/x-troff',
				'tsv'	=> 'text/tab-separated-values',
				'txt'	=> 'text/plain',
				'ustar'	=> 'application/x-ustar',
				'vbs'	=> 'text/plain', //added by skwashd - for obvious reasons
				'vcd'	=> 'application/x-cdlink',
				'vcf'	=> 'text/x-vcard',
				'vcs'	=> 'text/calendar',
				'vfb'	=> 'text/calendar',
				'vrml'	=> 'model/vrml',
				'vsd'	=> 'application/vnd.visio',
				'wav'	=> 'audio/x-wav',
				'wax'	=> 'audio/x-ms-wax',
				'wbmp'	=> 'image/vnd.wap.wbmp',
				'wbxml'	=> 'application/vnd.wap.wbxml',
				'wm'	=> 'video/x-ms-wm',
				'wma'	=> 'audio/x-ms-wma',
				'wmd'	=> 'application/x-ms-wmd',
				'wml'	=> 'text/vnd.wap.wml',
				'wmlc'	=> 'application/vnd.wap.wmlc',
				'wmls'	=> 'text/vnd.wap.wmlscript',
				'wmlsc'	=> 'application/vnd.wap.wmlscriptc',
				'wmv'	=> 'video/x-ms-wmv',
				'wmx'	=> 'video/x-ms-wmx',
				'wmz'	=> 'application/x-ms-wmz',
				'wrl'	=> 'model/vrml',
				'wvx'	=> 'video/x-ms-wvx',
				'xbm'	=> 'image/x-xbitmap',
				'xht'	=> 'application/xhtml+xml',
				'xhtml'	=> 'application/xhtml+xml',
				'xls'	=> 'application/vnd.ms-excel',
				'xlt'	=> 'application/vnd.ms-excel',
				'xml'	=> 'application/xml',
				'xpm'	=> 'image/x-xpixmap',
				'xsl'	=> 'text/xml',
				'xwd'	=> 'image/x-xwindowdump',
				'xyz'	=> 'chemical/x-xyz',
				'z'	=> 'application/x-compress',
				'zip'	=> 'application/zip',
       );
       $type = strtolower(substr(strrchr($filename, '.'),1));
       if(isset($contentType[$type])) {
            $mime = $contentType[$type];
       }else {
       	    $mime = 'application/octet-stream';
       }
       return $mime;
    }
}

if(!function_exists('image_type_to_extension'))
{
   function image_type_to_extension($imagetype)
   {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case IMAGETYPE_GIF    : return '.gif';
           case IMAGETYPE_JPEG    : return '.jpg';
           case IMAGETYPE_PNG    : return '.png';
           case IMAGETYPE_SWF    : return '.swf';
           case IMAGETYPE_PSD    : return '.psd';
           case IMAGETYPE_BMP    : return '.bmp';
           case IMAGETYPE_TIFF_II : return '.tiff';
           case IMAGETYPE_TIFF_MM : return '.tiff';
           case IMAGETYPE_JPC    : return '.jpc';
           case IMAGETYPE_JP2    : return '.jp2';
           case IMAGETYPE_JPX    : return '.jpf';
           case IMAGETYPE_JB2    : return '.jb2';
           case IMAGETYPE_SWC    : return '.swc';
           case IMAGETYPE_IFF    : return '.aiff';
           case IMAGETYPE_WBMP    : return '.wbmp';
           case IMAGETYPE_XBM    : return '.xbm';
           default                : return false;
       }
   }
}

//生成图像缩略图和生成验证码
//静态类
class Image
{//类定义开始

    /**
     +----------------------------------------------------------
     * 取得图像信息
     *
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image 图像文件名
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    static function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false)
		 {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"=>$imageInfo[0],
                "height"=>$imageInfo[1],
                "type"=>$imageType,
                "size"=>$imageSize,
                "mime"=>$imageInfo['mime']
            );
            return $info;
        }else {
            return false;
        }
    }



    /**
     +----------------------------------------------------------
     * 生成缩略图
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static function thumb($image,$thumbname,$type='',$maxWidth=200,$maxHeight=50,$interlace=true)
    {
        // 获取原图信息
        $info  = Image::getImageInfo($image);
         if($info !== false)
		  {
            $srcWidth  = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
			$type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            $scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
            if($scale>=1) 
			{
                // 超过原图大小不再缩略
                $width   =  $srcWidth;
                $height  =  $srcHeight;
            }
			else
			{
                // 缩略图尺寸
                $width  = (int)($srcWidth*$scale);
                $height = (int)($srcHeight*$scale);
            }

            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            $srcImg     = $createFun($image);

            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if(function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
				
            if('gif'==$type || 'png'==$type) 
			{
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
				imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }

            // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	
			     imageinterlace($thumbImg,$interlace);

            // 生成图片
            $imageFun = 'image'.($type=='jpg'?'jpeg':$type);
            $imageFun($thumbImg,$thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
         }
         return false;
    }


    /**
     +----------------------------------------------------------
     * 生成图像验证码
     +----------------------------------------------------------
     * @static
     * @access public
     * @param string $width  宽度
     * @param string $height  高度
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static function buildImageVerify($width=48,$height=22,$randval=NULL,$verifyName='verify')
    {
        if(!isset($_SESSION))
	    {
	   		session_start();//如果没有开启，session，则开启session
	    }
		
		$randval =empty($randval) ? ("".rand(1000,9999)): (string)$randval;
		
        $_SESSION[$verifyName]= $randval;
		$length=4;
        $width = ($length*10+10)>$width?$length*10+10:$width;

        $im = imagecreate($width,$height);
  
        $r = array(225,255,255,223);
        $g = array(225,236,237,255);
        $b = array(225,236,166,125);
        $key = mt_rand(0,3);

        $backColor = imagecolorallocate($im, $r[$key],$g[$key],$b[$key]);    //背景色（随机）
		$borderColor = imagecolorallocate($im, 100, 100, 100);                    //边框色
        $pointColor = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));                 //点颜色

        @imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        @imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor);
        $stringColor = imagecolorallocate($im,mt_rand(0,200),mt_rand(0,120),mt_rand(0,120));
		// 干扰
		for($i=0;$i<10;$i++){
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagearc($im,mt_rand(-10,$width),mt_rand(-10,$height),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
		}
		for($i=0;$i<25;$i++){
			$fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pointColor);
		}
		for($i=0;$i<$length;$i++) {
			imagestring($im,5,$i*10+5,mt_rand(1,8),$randval{$i}, $stringColor);
		}
        Image::output($im,'png');
    }

    static function output($im,$type='png',$filename='')
    {
        header("Content-type: image/".$type);
        $ImageFun='image'.$type;
		if(empty($filename)) {
	        $ImageFun($im);
		}else{
	        $ImageFun($im,$filename);
		}
        imagedestroy($im);
		exit;
    }
	
     /**
     * +----------------------------------------------------------
     * 图片水印
     * +----------------------------------------------------------
     * @$image  原图
     * @$water 水印图片
     * @$$waterPos 水印位置(0-9) 0为随机，其他代表上中下9个部分位置
     * +----------------------------------------------------------
     */

    static function water($image, $water, $waterPos =9)
    {
	    //检查图片是否存在
        if (!file_exists($image) || !file_exists($water))
            return false;
	   //读取原图像文件
        $imageInfo = self::getImageInfo($image);
        $image_w = $imageInfo['width']; //取得水印图片的宽
        $image_h = $imageInfo['height']; //取得水印图片的高
        $imageFun = "imagecreatefrom" . $imageInfo['type'];
        $image_im = $imageFun($image);
        
        //读取水印文件
        $waterInfo = self::getImageInfo($water);
        $w = $water_w = $waterInfo['width']; //取得水印图片的宽
        $h = $water_h = $waterInfo['height']; //取得水印图片的高
        $waterFun = "imagecreatefrom" . $waterInfo['type'];
        $water_im = $waterFun($water);

        switch ($waterPos) {
            case 0: //随机
                $posX = rand(0, ($image_w - $w));
                $posY = rand(0, ($image_h - $h));
                break;
            case 1: //1为顶端居左
                $posX = 0;
                $posY = 0;
                break;
            case 2: //2为顶端居中
                $posX = ($image_w - $w) / 2;
                $posY = 0;
                break;
            case 3: //3为顶端居右
                $posX = $image_w - $w;
                $posY = 0;
                break;
            case 4: //4为中部居左
                $posX = 0;
                $posY = ($image_h - $h) / 2;
                break;
            case 5: //5为中部居中
                $posX = ($image_w - $w) / 2;
                $posY = ($image_h - $h) / 2;
                break;
            case 6: //6为中部居右
                $posX = $image_w - $w;
                $posY = ($image_h - $h) / 2;
                break;
            case 7: //7为底端居左
                $posX = 0;
                $posY = $image_h - $h;
                break;
            case 8: //8为底端居中
                $posX = ($image_w - $w) / 2;
                $posY = $image_h - $h;
                break;
            case 9: //9为底端居右
                $posX = $image_w - $w;
                $posY = $image_h - $h;
                break;
            default: //随机
                $posX = rand(0, ($image_w - $w));
                $posY = rand(0, ($image_h - $h));
                break;
        }

        //设定图像的混色模式
        
        imagealphablending($image_im, true);

        imagecopy($image_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h); //拷贝水印到目标文件

        //生成水印后的图片
        $bulitImg = "image" . $imageInfo['type'];
        $bulitImg($image_im, $image);
        //释放内存
        $waterInfo = $imageInfo = null;
        imagedestroy($image_im);
    }

}//类定义结束

/**
获取ip地址的地理位置信息
需要ip数据库的支持，ip数据库请自行到cp官网http://www.canphp.com下载
 */
class IpArea
{
    /**
     * QQWry.Dat文件指针
     *
     * @var resource
     */
    private $fp;

    /**
     * 第一条IP记录的偏移地址
     *
     * @var int
     */
    private $firstip;

    /**
     * 最后一条IP记录的偏移地址
     *
     * @var int
     */
    private $lastip;

    /**
     * IP记录的总条数（不包含版本信息记录）
     *
     * @var int
     */
    private $totalip;

    /**
     * 构造函数，打开 QQWry.Dat 文件并初始化类中的信息
     *
     * @param string $filename
     * @return IpLocation
     */
    public function __construct($filename = "qqwry.dat") {
        $this->fp = 0;
        if (($this->fp = fopen(dirname(__FILE__).'/'.$filename, 'rb')) !== false) {
            $this->firstip = $this->getlong();
            $this->lastip = $this->getlong();
            $this->totalip = ($this->lastip - $this->firstip) / 7;
        }
    }
	    /**
     * 根据所给 IP 地址或域名返回所在地区信息
     *
     * @access public
     * @param string $ip
     * @return array
     */
    public function get($ip='',$all=false, $charset='utf-8') {
        if (!$this->fp) return null;            // 如果数据文件没有被正确打开，则直接返回空
		if(empty($ip)) $ip = $this->getIp();
        $location['ip'] = gethostbyname($ip);   // 将输入的域名转化为IP地址
        $ip = $this->packip($location['ip']);   // 将输入的IP地址转化为可比较的IP地址
                                                // 不合法的IP地址会被转化为255.255.255.255
        // 对分搜索
        $l = 0;                         // 搜索的下边界
        $u = $this->totalip;            // 搜索的上边界
        $findip = $this->lastip;        // 如果没有找到就返回最后一条IP记录（QQWry.Dat的版本信息）
        while ($l <= $u) {              // 当上边界小于下边界时，查找失败
            $i = floor(($l + $u) / 2);  // 计算近似中间记录
            fseek($this->fp, $this->firstip + $i * 7);
            $beginip = strrev(fread($this->fp, 4));     // 获取中间记录的开始IP地址
            // strrev函数在这里的作用是将little-endian的压缩IP地址转化为big-endian的格式
            // 以便用于比较，后面相同。
            if ($ip < $beginip) {       // 用户的IP小于中间记录的开始IP地址时
                $u = $i - 1;            // 将搜索的上边界修改为中间记录减一
            }
            else {
                fseek($this->fp, $this->getlong3());
                $endip = strrev(fread($this->fp, 4));   // 获取中间记录的结束IP地址
                if ($ip > $endip) {     // 用户的IP大于中间记录的结束IP地址时
                    $l = $i + 1;        // 将搜索的下边界修改为中间记录加一
                }
                else {                  // 用户的IP在中间记录的IP范围内时
                    $findip = $this->firstip + $i * 7;
                    break;              // 则表示找到结果，退出循环
                }
            }
        }

        //获取查找到的IP地理位置信息
        fseek($this->fp, $findip);
        $location['beginip'] = long2ip($this->getlong());   // 用户IP所在范围的开始地址
        $offset = $this->getlong3();
        fseek($this->fp, $offset);
        $location['endip'] = long2ip($this->getlong());     // 用户IP所在范围的结束地址
        $byte = fread($this->fp, 1);    // 标志字节
        switch (ord($byte)) {
            case 1:                     // 标志字节为1，表示国家和区域信息都被同时重定向
                $countryOffset = $this->getlong3();         // 重定向地址
                fseek($this->fp, $countryOffset);
                $byte = fread($this->fp, 1);    // 标志字节
                switch (ord($byte)) {
                    case 2:             // 标志字节为2，表示国家信息又被重定向
                        fseek($this->fp, $this->getlong3());
                        $location['country'] = $this->getstring();
                        fseek($this->fp, $countryOffset + 4);
                        $location['area'] = $this->getarea();
                        break;
                    default:            // 否则，表示国家信息没有被重定向
                        $location['country'] = $this->getstring($byte);
                        $location['area'] = $this->getarea();
                        break;
                }
                break;
            case 2:                     // 标志字节为2，表示国家信息被重定向
                fseek($this->fp, $this->getlong3());
                $location['country'] = $this->getstring();
                fseek($this->fp, $offset + 8);
                $location['area'] = $this->getarea();
                break;
            default:                    // 否则，表示国家信息没有被重定向
                $location['country'] = $this->getstring($byte);
                $location['area'] = $this->getarea();
                break;
        }
        if ($location['country'] == " CZ88.NET") {  // CZ88.NET表示没有有效信息
            $location['country'] = "未知";
        }
        if ($location['area'] == " CZ88.NET") {
            $location['area'] = "";
        }
		//编码转换
		$location=auto_charset($location,'gbk',$charset);
		
		if($all)
			return $location;
		else
			return $location['country'].$location['area'];       
    }
	
    /**
     * 返回读取的长整型数
     *
     * @access private
     * @return int
     */
    private function getlong() {
        //将读取的little-endian编码的4个字节转化为长整型数
        $result = unpack('Vlong', fread($this->fp, 4));
        return $result['long'];
    }

    /**
     * 返回读取的3个字节的长整型数
     *
     * @access private
     * @return int
     */
    private function getlong3() {
        //将读取的little-endian编码的3个字节转化为长整型数
        $result = unpack('Vlong', fread($this->fp, 3).chr(0));
        return $result['long'];
    }

    /**
     * 返回压缩后可进行比较的IP地址
     *
     * @access private
     * @param string $ip
     * @return string
     */
    private function packip($ip) {
        // 将IP地址转化为长整型数，如果在PHP5中，IP地址错误，则返回False，
        // 这时intval将Flase转化为整数-1，之后压缩成big-endian编码的字符串
        return pack('N', intval(ip2long($ip)));
    }

    /**
     * 返回读取的字符串
     *
     * @access private
     * @param string $data
     * @return string
     */
    private function getstring($data = "") {
        $char = fread($this->fp, 1);
        while (ord($char) > 0) {        // 字符串按照C格式保存，以\0结束
            $data .= $char;             // 将读取的字符连接到给定字符串之后
            $char = fread($this->fp, 1);
        }
        return $data;
    }

    /**
     * 返回地区信息
     *
     * @access private
     * @return string
     */
    private function getarea() {
        $byte = fread($this->fp, 1);    // 标志字节
        switch (ord($byte)) {
            case 0:                     // 没有区域信息
                $area = "";
                break;
            case 1:
            case 2:                     // 标志字节为1或2，表示区域信息被重定向
                fseek($this->fp, $this->getlong3());
                $area = $this->getstring();
                break;
            default:                    // 否则，表示区域信息没有被重定向
                $area = $this->getstring($byte);
                break;
        }
        return $area;
    }
	//获取ip地址
	public function getIp()
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
	   return($ip);
	}
	 /**
     * 析构函数，用于在页面执行结束后自动关闭打开的文件。
     *
     */
    public function __destruct() {
        if ($this->fp) {
            fclose($this->fp);
        }
        $this->fp = 0;
    }
}

if (!function_exists('auto_charset')) 
{
	// 自动转换字符集 支持数组转换
	function auto_charset($fContents,$from='gbk',$to='utf-8'){
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
}

/**
 * 分页
 * @author Shines
 */
class Page
{
	public $format = '{first}{preve}{pages}{next}{last} ({current}/{total})';//分页显示格式
	public $urlBase = 'index.php?page=';//链接前缀
	public $urlExtend = '';//链接后缀
	public $maxItems = 10;//最多显示的页码个数
	public $totalPage = 0;//总页数
	public $preveText = '上一页';//上一页显示文本
	public $nextText = '下一页';//下一页显示文本
	public $firstText = '首页';//第一页显示文本
	public $lastText = '尾页';//最后一页显示文本
	public $leftDelimiter = '[';//页码前缀
	public $rightDelimiter = ']';//页码后缀
	public $spacingStr = ' &nbsp;';//各页码间的空格符，上一页、下一页、第一页、最后一页后也会加入该空格符
	
	public function __construct()
	{
		//
	}
	
	/**
	 * 获取分页文本
	 * $currentPage	当前页
	 */
	public function getPages($currentPage)
	{
		//总页数大于1时才返回分页文本，否则返回空字符
		if ($this->totalPage > 1)
		{
			//过滤非法的当前页码
			$currentPage = (int)$currentPage;
			if ($currentPage > $this->totalPage)
			{
				$currentPage = $this->totalPage;
			}
			if ($currentPage < 1)
			{
				$currentPage = 1;
			}
			
			//上一页文本，下一页文本，第一页文本，最后一页文本
			$prevPageStr = ($currentPage > 1) ? ('<a href="' . $this->urlBase . ($currentPage - 1) . $this->urlExtend . '">' . $this->preveText . '</a>' . $this->spacingStr) : '';
			$nextPageStr = ($currentPage < $this->totalPage) ? ('<a href="' . $this->urlBase . ($currentPage + 1) . $this->urlExtend . '">' . $this->nextText . '</a>' . $this->spacingStr) : '';
			$firstPageStr = ($currentPage > 1) ? ('<a href="' . $this->urlBase . '1' . $this->urlExtend . '">'. $this->firstText . '</a>' . $this->spacingStr) : '';
			$lastPageStr = ($currentPage < $this->totalPage) ? ('<a href="' . $this->urlBase . $this->totalPage . $this->urlExtend . '">' . $this->lastText . '</a>' . $this->spacingStr) : '';
			
			//将当前页放在所有页码的中间位置
			$pageStart = $currentPage - (int)($this->maxItems / 2);
			if ($pageStart > $this->totalPage - $this->maxItems + 1)
			{
				$pageStart = $this->totalPage - $this->maxItems + 1;
			}
			if ($pageStart < 1)
			{
				$pageStart = 1;
			}
			
			//从开始页起，记录各页码，当前页不加链接
			$pagesStr = '';
			for ($pageOffset = 0; $pageOffset < $this->maxItems; $pageOffset++)
			{
				$pageIndex = $pageStart + $pageOffset;
				if ($pageIndex > $this->totalPage)
				{
					break;
				}
				if ($pageIndex == $currentPage)
				{
					$pagesStr .= $currentPage . $this->spacingStr;
				}
				else
				{
					$pagesStr .= '<a href="' . $this->urlBase . $pageIndex . $this->urlExtend . '">' . $this->leftDelimiter . $pageIndex . $this->rightDelimiter . '</a>' . $this->spacingStr;
				}
			}
			
			//将各分页信息替换到格式文本中
			$res = str_replace(array('{first}', '{preve}', '{pages}', '{next}', '{last}', '{current}', '{total}'), array($firstPageStr, $prevPageStr, $pagesStr, $nextPageStr, $lastPageStr, $currentPage, $this->totalPage), $this->format);
			
			return $res;
		}
		else
		{
			return '';
		}
	}
}

/*
汉字转化为拼音类
 */
class Pinyin{
	
	/**
	 * 汉字ASCII码库
	 * 
	 * @var array
	 */
	protected $lib;
	
	
	/**
	 * 构造函数
	 * 
	 * @return void
	 */
	public function __construct(){
		
	}
	/**
	 * 汉字转化并输出拼音
	 * 
	 * @param string $str		所要转化拼音的汉字
	 * @param boolean $utf8 	汉字编码是否为utf8
	 * @return string
	 */
	public function output($str, $utf8 = true)
	{		
		//参数分析
		if (!$str) {
			return false;
		}
		
		//编码转换.
		$str = ($utf8==true) ? $this->iconvStr('utf-8', 'gbk', $str) : $str;
		$num = strlen($str);
		
		$pinyin = '';
		for ($i=0; $i<$num; $i++) {
			$temp = ord(substr($str, $i, 1));
			if ($temp>160) {				
				$temp2=ord(substr($str,++$i,1));
				$temp=$temp*256+$temp2-65536;
			}
			$pinyin .= $this->num2str($temp);
		}
				
		//输出的拼音编码转换.
		return ($utf8==true) ? $this->iconvStr('gbk', 'utf-8', $pinyin) : $pinyin;
	}
	/**
	 * 将ASCII编码转化为字符串.
	 * 
	 * @param integer $num
	 * @return string
	 */
	protected function num2str($num) {		
		
		if (!$this->lib) {			
			$this->parse_lib();
		}
				
		if ($num>0&&$num<160) {	
			
   			return chr($num);
		} elseif($num<-20319||$num>-10247) {
			
			return '';
		} else{
			$total =sizeof($this->lib)-1;
			for($i=$total; $i>=0; $i--) {
				if($this->lib[$i][1]<=$num) {					
					break;
				}
			}
			
			return $this->lib[$i][0];
		}
	}

	/**
	 * 返回汉字编码库
	 * 
	 * @return array
	 */
	protected function parse_lib() {
		
		return $this->lib = array(
			array("a",-20319),
			array("ai",-20317),
			array("an",-20304),
			array("ang",-20295),
			array("ao",-20292),
			array("ba",-20283),
			array("bai",-20265),
			array("ban",-20257),
			array("bang",-20242),
			array("bao",-20230),
			array("bei",-20051),
			array("ben",-20036),
			array("beng",-20032),
			array("bi",-20026),
			array("bian",-20002),
			array("biao",-19990),
			array("bie",-19986),
			array("bin",-19982),
			array("bing",-19976),
			array("bo",-19805),
			array("bu",-19784),
			array("ca",-19775),
			array("cai",-19774),
			array("can",-19763),
			array("cang",-19756),
			array("cao",-19751),
			array("ce",-19746),
			array("ceng",-19741),
			array("cha",-19739),
			array("chai",-19728),
			array("chan",-19725),
			array("chang",-19715),
			array("chao",-19540),
			array("che",-19531),
			array("chen",-19525),
			array("cheng",-19515),
			array("chi",-19500),
			array("chong",-19484),
			array("chou",-19479),
			array("chu",-19467),
			array("chuai",-19289),
			array("chuan",-19288),
			array("chuang",-19281),
			array("chui",-19275),
			array("chun",-19270),
			array("chuo",-19263),
			array("ci",-19261),
			array("cong",-19249),
			array("cou",-19243),
			array("cu",-19242),
			array("cuan",-19238),
			array("cui",-19235),
			array("cun",-19227),
			array("cuo",-19224),
            array("da",-19218),
            array("dai",-19212),
            array("dan",-19038),
            array("dang",-19023),
            array("dao",-19018),
            array("de",-19006),
            array("deng",-19003),
            array("di",-18996),
            array("dian",-18977),
            array("diao",-18961),
            array("die",-18952),
            array("ding",-18783),
            array("diu",-18774),
            array("dong",-18773),
            array("dou",-18763),
            array("du",-18756),
            array("duan",-18741),
            array("dui",-18735),
            array("dun",-18731),
            array("duo",-18722),
            array("e",-18710),
            array("en",-18697),
            array("er",-18696),
            array("fa",-18526),
            array("fan",-18518),
            array("fang",-18501),
            array("fei",-18490),
            array("fen",-18478),
            array("feng",-18463),
            array("fo",-18448),
            array("fou",-18447),
            array("fu",-18446),
            array("ga",-18239),
            array("gai",-18237),
            array("gan",-18231),
            array("gang",-18220),
            array("gao",-18211),
            array("ge",-18201),
            array("gei",-18184),
            array("gen",-18183),
            array("geng",-18181),
            array("gong",-18012),
            array("gou",-17997),
            array("gu",-17988),
            array("gua",-17970),
            array("guai",-17964),
            array("guan",-17961),
            array("guang",-17950),
            array("gui",-17947),
            array("gun",-17931),
            array("guo",-17928),
            array("ha",-17922),
            array("hai",-17759),
            array("han",-17752),
            array("hang",-17733),
            array("hao",-17730),
            array("he",-17721),
            array("hei",-17703),
            array("hen",-17701),
            array("heng",-17697),
            array("hong",-17692),
            array("hou",-17683),
            array("hu",-17676),
            array("hua",-17496),
            array("huai",-17487),
            array("huan",-17482),
            array("huang",-17468),
            array("hui",-17454),
            array("hun",-17433),
            array("huo",-17427),
            array("ji",-17417),
            array("jia",-17202),
            array("jian",-17185),
            array("jiang",-16983),
            array("jiao",-16970),
            array("jie",-16942),
            array("jin",-16915),
            array("jing",-16733),
            array("jiong",-16708),
            array("jiu",-16706),
            array("ju",-16689),
            array("juan",-16664),
            array("jue",-16657),
            array("jun",-16647),
            array("ka",-16474),
            array("kai",-16470),
            array("kan",-16465),
            array("kang",-16459),
            array("kao",-16452),
            array("ke",-16448),
            array("ken",-16433),
            array("keng",-16429),
            array("kong",-16427),
            array("kou",-16423),
            array("ku",-16419),
            array("kua",-16412),
            array("kuai",-16407),
            array("kuan",-16403),
            array("kuang",-16401),
            array("kui",-16393),
            array("kun",-16220),
            array("kuo",-16216),
            array("la",-16212),
            array("lai",-16205),
            array("lan",-16202),
            array("lang",-16187),
            array("lao",-16180),
            array("le",-16171),
            array("lei",-16169),
            array("leng",-16158),
            array("li",-16155),
            array("lia",-15959),
            array("lian",-15958),
            array("liang",-15944),
            array("liao",-15933),
            array("lie",-15920),
            array("lin",-15915),
            array("ling",-15903),
            array("liu",-15889),
            array("long",-15878),
            array("lou",-15707),
            array("lu",-15701),
            array("lv",-15681),
            array("luan",-15667),
            array("lue",-15661),
            array("lun",-15659),
            array("luo",-15652),
            array("ma",-15640),
            array("mai",-15631),
            array("man",-15625),
            array("mang",-15454),
            array("mao",-15448),
            array("me",-15436),
            array("mei",-15435),
            array("men",-15419),
            array("meng",-15416),
            array("mi",-15408),
            array("mian",-15394),
            array("miao",-15385),
            array("mie",-15377),
            array("min",-15375),
            array("ming",-15369),
            array("miu",-15363),
            array("mo",-15362),
            array("mou",-15183),
            array("mu",-15180),
            array("na",-15165),
            array("nai",-15158),
            array("nan",-15153),
            array("nang",-15150),
            array("nao",-15149),
            array("ne",-15144),
            array("nei",-15143),
            array("nen",-15141),
            array("neng",-15140),
            array("ni",-15139),
            array("nian",-15128),
            array("niang",-15121),
            array("niao",-15119),
            array("nie",-15117),
            array("nin",-15110),
            array("ning",-15109),
            array("niu",-14941),
            array("nong",-14937),
            array("nu",-14933),
            array("nv",-14930),
            array("nuan",-14929),
            array("nue",-14928),
            array("nuo",-14926),
            array("o",-14922),
            array("ou",-14921),
            array("pa",-14914),
            array("pai",-14908),
            array("pan",-14902),
            array("pang",-14894),
            array("pao",-14889),
            array("pei",-14882),
            array("pen",-14873),
            array("peng",-14871),
            array("pi",-14857),
            array("pian",-14678),
            array("piao",-14674),
            array("pie",-14670),
            array("pin",-14668),
            array("ping",-14663),
            array("po",-14654),
            array("pu",-14645),
            array("qi",-14630),
            array("qia",-14594),
            array("qian",-14429),
            array("qiang",-14407),
            array("qiao",-14399),
            array("qie",-14384),
            array("qin",-14379),
            array("qing",-14368),
            array("qiong",-14355),
            array("qiu",-14353),
            array("qu",-14345),
            array("quan",-14170),
            array("que",-14159),
            array("qun",-14151),
            array("ran",-14149),
            array("rang",-14145),
            array("rao",-14140),
            array("re",-14137),
            array("ren",-14135),
            array("reng",-14125),
            array("ri",-14123),
            array("rong",-14122),
            array("rou",-14112),
            array("ru",-14109),
            array("ruan",-14099),
            array("rui",-14097),
            array("run",-14094),
            array("ruo",-14092),
            array("sa",-14090),
            array("sai",-14087),
            array("san",-14083),
            array("sang",-13917),
            array("sao",-13914),
            array("se",-13910),
            array("sen",-13907),
            array("seng",-13906),
            array("sha",-13905),
            array("shai",-13896),
            array("shan",-13894),
            array("shang",-13878),
            array("shao",-13870),
            array("she",-13859),
            array("shen",-13847),
            array("sheng",-13831),
            array("shi",-13658),
            array("shou",-13611),
            array("shu",-13601),
            array("shua",-13406),
            array("shuai",-13404),
            array("shuan",-13400),
            array("shuang",-13398),
            array("shui",-13395),
            array("shun",-13391),
            array("shuo",-13387),
            array("si",-13383),
            array("song",-13367),
            array("sou",-13359),
            array("su",-13356),
            array("suan",-13343),
            array("sui",-13340),
            array("sun",-13329),
            array("suo",-13326),
            array("ta",-13318),
            array("tai",-13147),
            array("tan",-13138),
            array("tang",-13120),
            array("tao",-13107),
            array("te",-13096),
            array("teng",-13095),
            array("ti",-13091),
            array("tian",-13076),
            array("tiao",-13068),
            array("tie",-13063),
            array("ting",-13060),
            array("tong",-12888),
            array("tou",-12875),
            array("tu",-12871),
            array("tuan",-12860),
            array("tui",-12858),
            array("tun",-12852),
            array("tuo",-12849),
            array("wa",-12838),
            array("wai",-12831),
            array("wan",-12829),
            array("wang",-12812),
            array("wei",-12802),
            array("wen",-12607),
            array("weng",-12597),
            array("wo",-12594),
            array("wu",-12585),
            array("xi",-12556),
            array("xia",-12359),
            array("xian",-12346),
            array("xiang",-12320),
            array("xiao",-12300),
            array("xie",-12120),
            array("xin",-12099),
            array("xing",-12089),
            array("xiong",-12074),
            array("xiu",-12067),
            array("xu",-12058),
            array("xuan",-12039),
            array("xue",-11867),
            array("xun",-11861),
            array("ya",-11847),
            array("yan",-11831),
            array("yang",-11798),
            array("yao",-11781),
            array("ye",-11604),
            array("yi",-11589),
            array("yin",-11536),			
			array("ying",-11358),
            array("yo",-11340),	
            array("yo",-11340),
            array("yong",-11339),
            array("you",-11324),
            array("yu",-11303),
            array("yuan",-11097),
            array("yue",-11077),
            array("yun",-11067),
            array("za",-11055),
            array("zai",-11052),
            array("zan",-11045),
            array("zang",-11041),
            array("zao",-11038),
            array("ze",-11024),
            array("zei",-11020),
            array("zen",-11019),
            array("zeng",-11018),
            array("zha",-11014),
            array("zhai",-10838),
            array("zhan",-10832),
            array("zhang",-10815),
            array("zhao",-10800),
            array("zhe",-10790),
            array("zhen",-10780),
            array("zheng",-10764),
            array("zhi",-10587),
            array("zhong",-10544),
            array("zhou",-10533),
            array("zhu",-10519),
            array("zhua",-10331),
            array("zhuai",-10329),
            array("zhuan",-10328),
            array("zhuang",-10322),
            array("zhui",-10315),
            array("zhun",-10309),
            array("zhuo",-10307),
            array("zi",-10296),
            array("zong",-10281),
            array("zou",-10274),
            array("zu",-10270),
            array("zuan",-10262),                        		
			array("zui",-10260),
			array("zun",-10256),
			array("zuo",-10254),
		);
	}
	
	//编码转换
	protected function iconvStr($from,$to,$fContents)
	{
			if(is_string($fContents) ) 
			{
				if(function_exists('mb_convert_encoding'))
				{
					return mb_convert_encoding ($fContents, $to, $from);
				}
				else if(function_exists('iconv'))
				{
					return iconv($from,$to,$fContents);
				}
				else
				{
					return $fContents;
				}
		}
	}
	/**
	 * 析构函数
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{		
		if (isset($this->lib)) {
			unset($this->lib);
		}
	}
}

/**
 * 安全
 * des加密
 * 静态类
 */
class Security
{
	/**
	 * GET变量去除斜杠
	 */
	public static function varGet($value)
	{
		$res = isset($_GET[$value]) ? $_GET[$value] : '';
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$res = stripslashes($res);
		}
		
		return $res;
	}
	
	/**
	 * POST变量去除斜杠
	 */
	public static function varPost($value)
	{
		$res = isset($_POST[$value]) ? $_POST[$value] : '';
		
		/////////////// debug
		if (empty($res))
		{
			$res = isset($_GET[$value]) ? $_GET[$value] : '';
		}
		
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$res = stripslashes($res);
		}
		
		return $res;
	}
	
	/**
	 * SQL安全变量
	 */
	public static function varSql($value)
	{
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		$value = "'" . @mysql_real_escape_string($value) . "'";
		
		return $value;
	}
	
	/**
	 * 多次md5加密
	 * $id: 原文
	 * $key: 密钥
	 */
	public static function multiMd5($id, $key)
	{
		$idKey = $key . $id;
		$str1 = md5(substr(md5($idKey), 3, 16) . substr(md5($key), 5, 11) . $idKey);
		$str2 = md5($idKey);
		$code = '';
		for ($i = 0; $i < 32; $i++)
		{
			$t = substr($str2, $i, 1);
			$tCode = ord($t);
			if ($tCode >= 48 && $tCode <= 57)
			{
				$t = chr(97 + $tCode - 48);
			}
			$code .= $t;
		}
		
		return substr($code, 0, 13) . $str1 . substr($code, 13, 19);
	}
	
	//加密函数，可用decrypt()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
	public static function encrypt($data, $key = '', $expire = 0)
	{
		$string=serialize($data);
		$ckeyLength = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr(md5(microtime()), -$ckeyLength);
	
		$cryptkey = $keya.md5($keya.$keyc);
		$keyLength = strlen($cryptkey);
		
		$string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$stringLength = strlen($string);
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $stringLength; $i++) 
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		return $keyc.str_replace('=', '', base64_encode($result));
	}
	
	//encrypt之后的解密函数，$string待解密的字符串，$key，密钥
	public static function decrypt($string, $key = '')
	{
		$ckeyLength = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr($string, 0, $ckeyLength);
		
		$cryptkey = $keya.md5($keya.$keyc);
		$keyLength = strlen($cryptkey);
		
		$string =  base64_decode(substr($string, $ckeyLength));
		$stringLength = strlen($string);
		
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $stringLength; $i++) 
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return unserialize(substr($result, 26));
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * 功能：用来过滤字符串和字符串数组，防止被挂马和sql注入
	 * 参数$data，待过滤的字符串或字符串数组，
	 * $force为true，忽略get_magic_quotes_gpc
	 */
	public static function in($data, $force = false)
	{
		if (is_string($data))
		{
			$data = trim(htmlspecialchars($data));//防止被挂马，跨站攻击
			if (($force == true) || (!get_magic_quotes_gpc()))
			{
				$data = addslashes($data);//防止sql注入
			}
			return  $data;
		}
		else if (is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key => $value)
			{
				$data[$key]=self::in($value,$force);
			}
			return $data;
		}
		else
		{
			return $data;
		}
	}
	
	//用来还原字符串和字符串数组，把已经转义的字符还原回来
	public static function out($data)
	{
		if (is_string($data))
		{
			return $data = stripslashes($data);
		}
		else if (is_array($data))//如果是数组采用递归过滤
		{
			foreach ($data as $key => $value)
			{
				 $data[$key]=self::out($value);
			}
			return $data;
		}
		else
		{
			return $data;
		}
	}
	
	//文本输入
	public static function textIn($str)
	{
		$str=strip_tags($str,'<br>');
		$str = str_replace(" ", "&nbsp;", $str);
		$str = str_replace("\n", "<br>", $str);
		if (!get_magic_quotes_gpc())
		{
			$str = addslashes($str);
		}
		return $str;
	}
	
	//文本输出
	public static function textOut($str)
	{
		$str = str_replace("&nbsp;", " ", $str);
		$str = str_replace("<br>", "\n", $str);
		$str = stripslashes($str);
		return $str;
	}
	
	//html代码输出
	public static function htmlOut($str)
	{
		if (function_exists('htmlspecialchars_decode'))
		{
			$str = htmlspecialchars_decode($str);
		}
		else
		{
			$str = html_entity_decode($str);
		}
		$str = stripslashes($str);
		return $str;
	}
	
	/**
	 * html转换输出
	 */
	public static function htmlspecialcharsArray($arr)
	{
		if (is_array($arr))
		{
			$res = array();
			foreach ($arr as $key => $value)
			{
				$res[$key] = self::htmlspecialcharsArray($value);
			}
			
			return $res;
		}
		else
		{
			return htmlspecialchars($arr, ENT_QUOTES);
		}
	}
	
	//html代码输入
	public static function htmlIn($str)
	{
		$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
						 "'<iframe[^>]*?>.*?</iframe>'si", // 去掉iframe
						);
		$replace = array ("",
						  "",
						);
		$str = @preg_replace($search, $replace, $str);
		$str = htmlspecialchars($str);
		if (!get_magic_quotes_gpc())
		{
			$str = addslashes($str);
		}
		return $str;
	}
}

//文件和图片上传类
class Upload
{//类定义开始

    // 上传文件的最大值
    public $maxSize = -1;

    // 是否支持多文件上传
    public $supportMulti = true;

    // 允许上传的文件后缀
    //  留空不作后缀检查
    public $allowExts = array();

    // 允许上传的文件类型
    // 留空不做检查
    public $allowTypes = array();

    // 使用对上传图片进行缩略图处理
    public $thumb   =  false;
    // 缩略图最大宽度
    public $thumbMaxWidth;
    // 缩略图最大高度
    public $thumbMaxHeight;
    // 缩略图前缀
    public $thumbPrefix   =  'thumb_';
    public $thumbSuffix  =  '';
    // 缩略图保存路径
    public $thumbPath = '';
    // 缩略图文件名
    public $thumbFile		=	'';
    // 是否移除原图
    public $thumbRemoveOrigin = false;
    // 压缩图片文件上传
    public $zipImages = false;
    // 启用子目录保存文件
    public $autoSub   =  false;
    // 子目录创建方式 可以使用hash date
    public $subType   = 'hash';
    public $dateFormat = 'Ymd';
    public $hashLevel =  1; // hash的目录层次
    // 上传文件保存路径
    public $savePath = '';
    public $autoCheck = true; // 是否自动检查附件
    // 存在同名是否覆盖
    public $uploadReplace = false;

    // 上传文件命名规则
    // 例如可以是 time uniqid com_create_guid 等
    // 必须是一个无需任何参数的函数名 可以使用自定义函数
    public $saveRule = '';

    // 上传文件Hash规则函数名
    // 例如可以是 md5_file sha1_file 等
    public $hashType = 'md5_file';

    // 错误信息
    private $error = '';

    // 上传成功的文件信息
    private $uploadFileInfo ;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function __construct($maxSize='',$allowExts='',$allowTypes='',$savePath='',$saveRule='')
    {
        if(!empty($maxSize) && is_numeric($maxSize)) {
            $this->maxSize = $maxSize;
        }
        if(!empty($allowExts)) {
            if(is_array($allowExts)) {
                $this->allowExts = array_map('strtolower',$allowExts);
            }else {
                $this->allowExts = explode(',',strtolower($allowExts));
            }
        }
        if(!empty($allowTypes)) {
            if(is_array($allowTypes)) {
                $this->allowTypes = array_map('strtolower',$allowTypes);
            }else {
                $this->allowTypes = explode(',',strtolower($allowTypes));
            }
        }
	   if(!empty($savePath)) {
            $this->savePath = $savePath;
        }	
        if(!empty($saveRule)) {
            $this->saveRule = $saveRule;
        }
	
        
    }

    private function save($file)
    {
        $filename = $file['savepath'].$file['savename'];
        if(!$this->uploadReplace && is_file($filename)) {
            // 不覆盖同名文件
            $this->error	=	'文件已经存在！'.$filename;
            return false;
        }
        // 如果是图像文件 检测文件格式
        if( in_array(strtolower($file['extension']),array('gif','jpg','jpeg','bmp','png','swf')) && false === getimagesize($file['tmp_name'])) {
            $this->error = '非法图像文件';
            return false;
        }
        if(!move_uploaded_file($file['tmp_name'], iconv('utf-8','gbk',$filename))) {
            $this->error = '文件上传保存错误！';
            return false;
        }
        if($this->thumb && in_array(strtolower($file['extension']),array('gif','jpg','jpeg','bmp','png'))) {
            $image =  getimagesize($filename);
            if(false !== $image) {
                //是图像文件生成缩略图
                $thumbWidth		=	explode(',',$this->thumbMaxWidth);
                $thumbHeight		=	explode(',',$this->thumbMaxHeight);
                $thumbPrefix		=	explode(',',$this->thumbPrefix);
                $thumbSuffix = explode(',',$this->thumbSuffix);
                $thumbFile			=	explode(',',$this->thumbFile);
                $thumbPath    =  $this->thumbPath?$this->thumbPath:$file['savepath'];
                // 生成图像缩略图
				if(file_exists(dirname(__FILE__).'/Image.php'))
				{
					$realFilename  =  $this->autoSub?basename($file['savename']):$file['savename'];
					for($i=0,$len=count($thumbWidth); $i<$len; $i++) {
						$thumbname	=	$thumbPath.$thumbPrefix[$i].substr($realFilename,0,strrpos($realFilename, '.')).$thumbSuffix[$i].'.'.$file['extension'];
						Image::thumb($filename,$thumbname,'',$thumbWidth[$i],$thumbHeight[$i],true);
					}
					if($this->thumbRemoveOrigin) {
						// 生成缩略图之后删除原图
						unlink($filename);
					}
				}
            }
        }
        if($this->zipImages) {
            // TODO 对图片压缩包在线解压

        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 上传文件
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $savePath  上传文件保存路径
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function upload($savePath ='')
    {
        //如果不指定保存文件名，则由系统默认
        if(empty($savePath))
            $savePath = $this->savePath;
        // 检查上传目录
        if(!is_dir($savePath)) {
            // 检查目录是否编码后的
            if(is_dir(base64_decode($savePath))) {
                $savePath	=	base64_decode($savePath);
            }else{
                // 尝试创建目录
                if(!mkdir($savePath)){
                    $this->error  =  '上传目录'.$savePath.'不存在';
                    return false;
                }
            }
        }else {
            if(!is_writeable($savePath)) {
                $this->error  =  '上传目录'.$savePath.'不可写';
                return false;
            }
        }
        $fileInfo = array();
        $isUpload   = false;

        // 获取上传的文件信息
        // 对$_FILES数组信息处理
        $files	 =	 $this->dealFiles($_FILES);
        foreach($files as $key => $file) {
            //过滤无效的上传
            if(!empty($file['name'])) {
                //登记上传文件的扩展信息
                $file['key']          =  $key;
                $file['extension']  = $this->getExt($file['name']);
                $file['savepath']   = $savePath;
                $file['savename']   = $this->getSaveName($file);

                // 自动检查附件
                if($this->autoCheck) {
                    if(!$this->check($file))
                        return false;
                }

                //保存上传文件
                if(!$this->save($file)) return false;
				/*
                if(function_exists($this->hashType)) {
                    $fun =  $this->hashType;
                    $file['hash']   =  $fun(auto_charset($file['savepath'].$file['savename'],'utf-8','gbk'));
                }
				*/
                //上传成功后保存文件信息，供其他地方调用
                unset($file['tmp_name'],$file['error']);
                $fileInfo[] = $file;
                $isUpload   = true;
            }
        }
        if($isUpload) {
            $this->uploadFileInfo = $fileInfo;
            return true;
        }else {
            $this->error  =  '没有选择上传文件';
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 转换上传文件数组变量为正确的方式
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $files  上传的文件变量
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    private function dealFiles($files) {
       $fileArray = array();
       foreach ($files as $file){
           if(is_array($file['name'])) {
               $keys = array_keys($file);
               $count	 =	 count($file['name']);
               for ($i=0; $i<$count; $i++) {
                   foreach ($keys as $key)
                       $fileArray[$i][$key] = $file[$key][$i];
               }
           }else{
               $fileArray	=	$files;
           }
           break;
       }
       return $fileArray;
    }

    /**
     +----------------------------------------------------------
     * 获取错误代码信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $errorNo  错误号码
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    protected function error($errorNo)
    {
         switch($errorNo) {
            case 1:
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                break;
            case 2:
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
            default:
                $this->error = '未知上传错误！';
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 根据上传文件命名规则取得保存文件名
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 数据
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSaveName($filename)
    {
        $rule = $this->saveRule;
        if(empty($rule)) {//没有定义命名规则，则保持文件名不变
            $saveName = $filename['name'];
        }else {
			//使用给定的文件名作为标识号
			$saveName = $rule.".".$filename['extension'];
			/*
            if(function_exists($rule)) {
                //使用函数生成一个唯一文件标识号
                $saveName = $rule().".".$filename['extension'];
            }else {
                //使用给定的文件名作为标识号
                $saveName = $rule.".".$filename['extension'];
            }
			*/
        }
        if($this->autoSub) {
            // 使用子目录保存文件
            $saveName   =  $this->getSubName($filename).'/'.$saveName;
        }
        return $saveName;
    }

    /**
     +----------------------------------------------------------
     * 获取子目录的名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file  上传的文件信息
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSubName($file)
    {
        switch($this->subType) {
            case 'date':
                $dir   =  date($this->dateFormat,time());
                break;
            case 'hash':
            default:
                $name = md5($file['savename']);
                $dir   =  '';
                for($i=0;$i<$this->hashLevel;$i++) {
                    $dir   .=  $name{0}.'/';
                }
                break;
        }
        if(!is_dir($file['savepath'].$dir)) {
            mkdir($file['savepath'].$dir);
        }
        return $dir;
    }

    /**
     +----------------------------------------------------------
     * 检查上传的文件
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file 文件信息
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function check($file) {
        if($file['error']!== 0) {
            //文件上传失败
            //捕获错误代码
            $this->error($file['error']);
            return false;
        }

        //检查文件Mime类型
        if(!$this->checkType($file['type'])) {
            $this->error = '上传文件MIME类型不允许！';
            return false;
        }
        //检查文件类型
        if(!$this->checkExt($file['extension'])) {
            $this->error ='上传文件类型不允许';
            return false;
        }
        //文件上传成功，进行自定义规则检查
        //检查文件大小
        if(!$this->checkSize($file['size'])) {
            $this->error = '上传文件大小超出限制！';
            return false;
        }

        //检查是否合法上传
        if(!$this->checkUpload($file['tmp_name'])) {
            $this->error = '非法上传文件！';
            return false;
        }
        return true;
    }

    /**
     +----------------------------------------------------------
     * 检查上传的文件类型是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $type 数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkType($type)
    {
        if(!empty($this->allowTypes))
            return in_array(strtolower($type),$this->allowTypes);
        return true;
    }


    /**
     +----------------------------------------------------------
     * 检查上传的文件后缀是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $ext 后缀名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkExt($ext)
    {
        if(!empty($this->allowExts))
            return in_array(strtolower($ext),$this->allowExts,true);
        return true;
    }

    /**
     +----------------------------------------------------------
     * 检查文件大小是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param integer $size 数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkSize($size)
    {
        return !($size > $this->maxSize) || (-1 == $this->maxSize);
    }

    /**
     +----------------------------------------------------------
     * 检查文件是否非法提交
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkUpload($filename)
    {
        return is_uploaded_file($filename);
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的后缀
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function getExt($filename)
    {
        $pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function getUploadFileInfo()
    {
        return $this->uploadFileInfo;
    }

    /**
     +----------------------------------------------------------
     * 取得最后一次错误信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getErrorMsg()
    {
        return $this->error;
    }

}//类定义结束

/**
 * 公共函数库
 * 静态类
 * @author Shines
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
	 * 获取指定目录下的所有文件和目录名，遍历子目录
	 */
	public static function getFiles($path)
	{
		$res = array();
		foreach (scandir($path) as $item)
		{
			if ($item == '.' || $item == '..')
			{
				continue;
			}
			$currentPath = $path . '/' . $item;
			$res[] = $currentPath;
			if (is_dir($currentPath))
			{
				$res = array_merge($res, self::getFiles($currentPath));
			}
		}
		return $res;
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
	 * 格式化输出数组
	 */
	public static function dumpArr($arr, $str = 'array', $depth = 0)
	{
		if (is_array($arr))
		{
			echo self::replicate('&nbsp;', 4 * $depth) . $str . '[]:<br />';
			echo self::replicate('&nbsp;', 4 * $depth) . '{<br />';
			foreach ($arr as $key => $value)
			{
				self::dumpArr($value, $key, $depth + 1);
			}
			echo self::replicate('&nbsp;', 4 * $depth) . '}<br />';
		}
		else
		{
			echo self::replicate('&nbsp;', 4 * $depth) . $str . ': ' . $arr . '<br />';
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
	public static function makePhp($files, $fileMake, $extendsCode = '')
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

//xml解析成数组
//静态类
class Xml
{
	public static function decode($xml)
	{
		$values = array();
		$index  = array();
		$array  = array();
		$parser = xml_parser_create('utf-8');
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($parser, $xml, $values, $index);
		xml_parser_free($parser);
		$i = 0;
		$name = $values[$i]['tag'];
		$array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		$array[$name] = self::structToArray($values, $i);
		return $array;
	}
	
	private static function structToArray($values, &$i)
	{
		$child = array();
		if (isset($values[$i]['value'])) 
		array_push($child, $values[$i]['value']);
		
		while ($i++ < count($values))
		 {
			switch ($values[$i]['type']) 
			{
				case 'cdata':
					array_push($child, $values[$i]['value']);
					break;
				
				case 'complete':
					$name = $values[$i]['tag'];
					if(!empty($name))
					{
						$child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
						if(isset($values[$i]['attributes'])) 
						{                   
							$child[$name] = $values[$i]['attributes'];
						}
					}
				break;
				
				case 'open':
					$name = $values[$i]['tag'];
					$size = isset($child[$name]) ? sizeof($child[$name]) : 0;
					$child[$name][$size] = self::structToArray($values, $i);
					break;
				
				case 'close':
					return $child;
					break;
			}
		}
		return $child;
	}
}

/**
 * 数据库操作
 * @author Shines
 */
class Database
{
	private $dbDriver = '';//数据库驱动类型
	private $db = null;//指定驱动的数据库对象
	
	/**
	 * 创建指定驱动的数据库对象
	 * $dbConfig	配置数据
	 */
	public function __construct($dbConfig)
	{
		$this->dbDriver = $dbConfig['dbDriver'];
		switch ($this->dbDriver)
		{
			case 'mysql':
				$this->db = new Mysql($dbConfig);
				break;
			case 'mysqli':
				break;
			case 'oracle':
				break;
			default:
		}
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		$this->db->connect();
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		$this->db->query($sql);
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		return $this->db->getRow($acctype);
	}
	
	/**
	 * 返回当前的所有记录并把游标移向表尾
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		return $this->db->getAllRows($acctype);
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		return $this->db->getNumRows();
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		return $this->db->getAllFields($tbName);
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		$this->db->close();
	}
	
	/**
	 * 获取连接id
	 */
	public function getLinkId()
	{
		return $this->db->linkId;
	}
	
	/**
	 * 获取查询结果
	 */
	public function getResult()
	{
		return $this->db->result;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		return $this->db->getAllTables();
	}
}

 /**
  * 内置MYSQL连接，只需要简单配置数据连接
 使用方法如下
 

$db = new Dbbak('localhost','root','','guestbook','utf8','data/dbbak/');

//查找数据库内所有数据表
$tableArry = $db->getTables();

//备份并生成sql文件
if(!$db->exportSql($tableArry))
{
	echo '备份失败';
}
else
{
	echo '备份成功';
}

//恢复导入sql文件夹
if($db->importSql())
{
	echo '恢复成功';
}
else
{
	echo '恢复失败';
}
 */
class Dbbak {
	public $dbhost;//数据库主机
	public $dbuser;//数据库用户名
	public $dbpw;//数据库密码
	public $dbname;//数据库名称
	public $dataDir;	//备份文件存放的路径
	protected   $transfer 	   ="";			//临时存放sql[切勿不要对该属性赋值，否则会生成错误的sql语句]
	
	public function __construct($dbhost,$dbuser,$dbpw,$dbname,$charset='utf8',$dir='data/dbbak/')
	{		
		$this->connect($dbhost,$dbuser,$dbpw,$dbname,$charset);//连接数据
		$this->dataDir=$dir;
	}

/**
 *数据库连接
 *@param string $host 数据库主机名
 *@param string $user 用户名
 *@param string $pwd  密码
 *@param string $db   选择数据库名
 *@param string $charset 编码方式
 */
	public function connect($dbhost,$dbuser,$dbpw,$dbname,$charset='utf8')
	{
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpw = $dbpw;
		$this->dbname = $dbname;
		if(!$conn = @mysql_connect($dbhost,$dbuser,$dbpw))
		{
			$this->error('无法连接数据库服务器');
			return false;
		}
		@mysql_select_db($this->dbname) or $this->error('选择数据库失败');
		@mysql_query("set names $charset");
		return true;
	}

/**
 *列表数据库中的表
 *@param  database $database 要操作的数据库名
 *@return array    $dbArray  所列表的数据库表
 */
	public function getTables($database='')
	{
		$database=empty($database)?$this->dbname:$database;
		$result=@mysql_query("SHOW TABLES FROM `$database`") or die(@mysql_error());
	//	$result = @mysql_list_tables($database);//mysql_list_tables函数不建议使用
		while($tmpArry = @mysql_fetch_row($result)){
			 $dbArry[]  = $tmpArry[0];
		}
		return $dbArry;
	}

/**
 *生成sql文件，导出数据库
 *@param string $sql sql    语句
 *@param number $subsection 分卷大小，以KB为单位，为0表示不分卷
 */
     public function exportSql($table='',$subsection=0)
	 {
		$table=empty($table)?$this->getTables():$table;
     	if(!$this->_checkDir($this->dataDir))
		{
			$this->error('您没有权限操作目录,备份失败');
			return false;
		}
		
     	if($subsection == 0)
		{
     		if(!is_array($table))
			{
				$this->_setSql($table,0,$this->transfer);
			}
			else
			{
				for($i=0;$i<count($table);$i++)
				{
					$this->_setSql($table[$i],0,$this->transfer);
				}
			}
     		$fileName = $this->dataDir.date("Ymd",time()).'_all.sql.php';
     		if(!$this->_writeSql($fileName,$this->transfer))
			{
				return false;
			}
     	}
		else
		{
     		if(!is_array($table))
			{
				$sqlArry = $this->_setSql($table,$subsection,$this->transfer);
				$sqlArry[] = $this->transfer;
			}
			else
			{
				$sqlArry = array();
				for($i=0;$i<count($table);$i++){
					$tmpArry = $this->_setSql($table[$i],$subsection,$this->transfer);
					$sqlArry = array_merge($sqlArry,$tmpArry);
				}
				$sqlArry[] = $this->transfer;
			}
     		for($i=0;$i<count($sqlArry);$i++)
			{
     			$fileName = $this->dataDir.date("Ymd",time()).'_part'.$i.'.sql.php';
     			if(!$this->_writeSql($fileName,$sqlArry[$i]))
				{
					return false;
				}
     		}
     	}
     	return true;
    }
	
/*
 *载入sql文件，恢复数据库
 *@param diretory $dir
 *@return booln
 *注意:请不在目录下面存放其它文件和目录，以节省恢复时间
*/
    public function importSql($dir=''){
		
		if(is_file($dir))
		{
			return $this->_importSqlFile($dir);
		}
		$dir=empty($dir)?$this->dataDir:$dir;
		if($link = opendir($dir))
		{
			$fileArry = scandir($dir);
			$pattern = "/_part[0-9]+.sql.php$|_all.sql.php$/";
			$num=count($fileArry);
			for($i=0;$i<$num;$i++)
			{
				if(preg_match($pattern,$fileArry[$i]))
				{
					if(false==$this->_importSqlFile($dir.$fileArry[$i]))
					{
						return false;
					}
				}
			}
			return true;
		}
    }
	
//执行sql文件，恢复数据库
    protected function _importSqlFile($filename='')
	{
		$sqls=file_get_contents($filename);
		$sqls=substr($sqls,13);
		$sqls=explode("\n",$sqls);
		if(empty($sqls))
			return false;
			
		foreach($sqls as $sql)
		{
			if(empty($sql))
				continue;
			if(!@mysql_query(trim($sql))) 
			{
				$this->error('恢复失败：'.@mysql_error());
				return false;
			}
		}
		return true;
    }
	
/**
 * 生成sql语句
 * @param   $table     要备份的表
 * @return  $tabledump 生成的sql语句
 */
	protected function _setSql($table,$subsection=0,&$tableDom=''){
		$tableDom .= "DROP TABLE IF EXISTS $table\n";
		$createtable = @mysql_query("SHOW CREATE TABLE $table");
		$create = @mysql_fetch_row($createtable);
		$create[1] = str_replace("\n","",$create[1]);
		$create[1] = str_replace("\t","",$create[1]);

		$tableDom  .= $create[1].";\n";

		$rows = @mysql_query("SELECT * FROM $table");
		$numfields = @mysql_num_fields($rows);
		$numrows = @mysql_num_rows($rows);
		$n = 1;
		$sqlArry = array();
		while ($row = @mysql_fetch_row($rows))
		{
		   $comma = "";
		   $tableDom  .= "INSERT INTO $table VALUES(";
		   for($i = 0; $i < $numfields; $i++)
		   {
				$tableDom  .= $comma."'".@mysql_real_escape_string($row[$i])."'";
				$comma = ",";
		   }
		  $tableDom  .= ")\n";
		   if($subsection != 0 && strlen($this->transfer )>=$subsection*1000){
		   		$sqlArry[$n]= $tableDom;
		   		$tableDom = ''; $n++;
		   }
		}
		return $sqlArry;
   }
   
/**
 *验证目录是否有效，同时删除该目录下的所有文件
 *@param diretory $dir
 *@return booln
 */
	protected function _checkDir($dir){
		if(!is_dir($dir)) {@mkdir($dir, 0777);}
		if(is_dir($dir)){
			if($link = opendir($dir)){
				$fileArry = scandir($dir);
				for($i=0;$i<count($fileArry);$i++){
					if($fileArry[$i]!='.' || $fileArry != '..'){
						@unlink($dir.$fileArry[$i]);
					}
				}
			}
		}
		return true;
	}
	
/**
 *将数据写入到文件中
 *@param file $fileName 文件名
 *@param string $str   要写入的信息
 *@return booln 写入成功则返回true,否则false
 */
	protected function _writeSql($fileName,$str){
		$re= true;
		if(!$fp=@fopen($fileName,"w+"))
		{
			$re=false; $this->error("在打开文件时遇到错误，备份失败!");
		}
		if(!@fwrite($fp,'<?php exit;?>'.$str)) 
		{
			$re=false; $this->error("在写入信息时遇到错误，备份失败!");
		}
		if(!@fclose($fp)) 
		{
			$re=false; $this->error("在关闭文件 时遇到错误，备份失败!");
		}
		return $re;
	}
	public function error($str)
	{
		cpError::show($str);
	}

}


/**
 * Mysql数据库操作
 * @author Shines
 */
class Mysql
{
	public $linkId = 0;//连接id
	public $result = 0;//查询结果
	
	//数据库配置信息	
	private $hostname = '';//数据库主机
	private $username = '';//用户名
	private $password = '';//密码
	private $dbName = '';//数据库名
	private $dbCharset = '';//数据库字符集
	private $dbCollat = '';//排序规则
	private $dbPconnect = false;//是否长连接
	private $isConnected = false;//是否已连接
	
	/**
	 * 存储配置信息并连接数据库
	 * $dbConfig	配置信息
	 */
	public function __construct($dbConfig)
	{
		$this->hostname = $dbConfig['hostname'];
		$this->username = $dbConfig['username'];
		$this->password = $dbConfig['password'];
		$this->dbName = $dbConfig['dbName'];
		$this->dbCharset = $dbConfig['dbCharset'];
		$this->dbCollat = $dbConfig['dbCollat'];
		$this->dbPconnect = $dbConfig['dbPconnect'];
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		if ( ! $this->isConnected)
		{
			if ($this->dbPconnect)
			{
				$this->linkId = @mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->linkId = @mysql_connect($this->hostname, $this->username, $this->password);
			}
			
			//成功连接则选择数据库，否则处理错误
			if ($this->linkId)
			{
				@mysql_select_db($this->dbName);
				@mysql_query("SET NAMES '{$this->dbCharset}', character_set_client=binary, sql_mode='', interactive_timeout=3600;", $this->linkId);
				//标记已连接
				$this->isConnected = true;
			}
			else
			{
				exit('Database error!');
			}
		}
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		if ($this->isConnected)
		{
			$this->result = @mysql_query($sql, $this->linkId);
			if ( ! $this->result)
			{
				exit('Database error!');
			}
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			return @mysql_fetch_array($this->result, $acctype);
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取当前查询的所有记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			$res = array();
			while ($row = @mysql_fetch_array($this->result, $acctype))
			{
				$res[] = $row;
			}
			
			return $res;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		if ($this->result)
		{
			return @mysql_num_rows($this->result);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		if ($this->isConnected)
		{
			$res = array();
			$fields = @mysql_list_fields($this->dbName, $tbName, $this->linkId);
			if ( ! $fields)
			{
				exit('Database error!');
			}
			$columns = @mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++)
			{
				$res[$i] = @mysql_field_name($fields, $i);
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		if ($this->linkId)
		{
			@mysql_close($this->linkId);
		}
		$this->result = 0;
		$this->linkId = 0;
		$this->isConnected = false;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		if ($this->linkId)
		{
			return @mysql_insert_id($this->linkId);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		if ($this->isConnected)
		{
			$res = array();
			$this->query("SHOW TABLES");
			$rows = $this->getAllRows(MYSQL_NUM);
			foreach ($rows as $value)
			{
				$res[] = $value[0];
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
}

/**
 * 管理后台模块
 * @author Shines
 */
class AdminController
{
	private $admin = null;//管理员
	private $install = null;//安装
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->install = new Install();
	}
	
	/**
	 * 生成验证码
	 */
	public function verify()
	{
		$this->admin->getVerify();
	}
	
	/**
	 * 登录
	 */
	public function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$verify = Security::varPost('verify');
		
		if ($this->admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				System::echoData(Config::$msg['usernamePwError']);
			}
			else
			{
				if ($this->admin->login($username, $password))
				{
					System::echoData(Config::$msg['ok']);
				}
				else
				{
					System::echoData(Config::$msg['usernamePwError']);
				}
			}
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword()
	{
		if ($this->admin->checkLogin())
		{
			$this->showChangePassword();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 修改密码
	 */
	public function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		if ($this->admin->checkLogin())
		{
			$srcPassword = Security::varPost('srcPassword');
			$newPassword = Security::varPost('newPassword');
			if (empty($srcPassword))
			{
				System::echoData(Config::$msg['srcPwErorr']);
			}
			else
			{
				if (empty($newPassword))
				{
					System::echoData(Config::$msg['newPwError']);
				}
				else
				{
					if ($this->admin->checkPassword($srcPassword))
					{
						$this->admin->changePassword($newPassword);
						$this->admin->logout();
						System::echoData(Config::$msg['ok']);
					}
					else
					{
						System::echoData(Config::$msg['srcPwErorr']);
					}
				}
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 退出
	 */
	public function logout()
	{
		System::fixSubmit('logout');
		if ($this->admin->checkLogin())
		{
			$this->admin->logout();
			$this->showLogin();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		System::fixSubmit('install');
		if ($this->admin->checkLogin())
		{
			$this->install->install();
			echo 'ok';
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看数据库数据
	 */
	public function db()
	{
		if ($this->admin->checkLogin())
		{
			$allTables = $this->install->getAllTables();
			$_tableList = array();
			foreach ($allTables as $tbName)
			{
				$tableInfo = array();
				$tableInfo['tbname'] = $tbName;
				$tableInfo['fields'] = $this->install->getAllFields($tbName);
				$tableInfo['records'] = $this->install->getRecords($tbName, 0, 1000000);
				$_tableList[] = $tableInfo;
			}
			$this->showDb($_tableList);
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看新闻数据
	 */
	public function dbNews()
	{
		if ($this->admin->checkLogin())
		{
			$allTables = array(Config::$tbNews);
			$_tableList = array();
			foreach ($allTables as $tbName)
			{
				$tableInfo = array();
				$tableInfo['tbname'] = $tbName;
				$tableInfo['fields'] = $this->install->getAllFields($tbName);
				$tableInfo['records'] = $this->install->getRecords($tbName, 0, 100000);
				$_tableList[] = $tableInfo;
			}
			$this->showDb($_tableList);
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		System::fixSubmit('upgrade');
		if ($this->admin->checkLogin())
		{
			$this->install->upgrade();
			echo 'ok';
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		System::fixSubmit('backup');
		if ($this->admin->checkLogin())
		{
			$this->install->backup();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		System::fixSubmit('recover');
		if ($this->admin->checkLogin())
		{
			$this->install->recover();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 数据库中查找关键字
	 */
	public function find()
	{
		if ($this->admin->checkLogin())
		{
			$keywords = Security::varGet('keywords');
			$_tableList = $this->install->find($keywords);
			$this->showDb($_tableList);
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看日志
	 */
	public function log()
	{
		if ($this->admin->checkLogin())
		{
			$date = Security::varGet('date');
			if (empty($date))
			{
				if (file_exists(Debug::$logFile))
				{
					include(Debug::$logFile);
				}
				else
				{
					echo 'No log!';
				}
			}
			else
			{
				$logFile = Config::$logDir . Utils::mdate('Y-m-d', $date) . '.php';
				if (file_exists($logFile))
				{
					include($logFile);
				}
				else
				{
					echo 'No log!';
				}
			}
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看执行时间日志
	 */
	public function logTime()
	{
		if ($this->admin->checkLogin())
		{
			$date = Security::varGet('date');
			if (empty($date))
			{
				if (file_exists(Debug::$timeFile))
				{
					include(Debug::$timeFile);
				}
				else
				{
					echo 'No log!';
				}
			}
			else
			{
				$timeFile = Config::$logDir . 'time_' . Utils::mdate('Y-m-d', $date) . '.php';
				if (file_exists($timeFile))
				{
					include($timeFile);
				}
				else
				{
					echo 'No log!';
				}
			}
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示php信息
	 */
	public function info()
	{
		if ($this->admin->checkLogin())
		{
			phpinfo();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 管理后台主页面
	 */
	public function main()
	{
		if ($this->admin->checkLogin())
		{
			$this->showMain();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示系统时间
	 */
	public function showDate()
	{
		if ($this->admin->checkLogin())
		{
			echo Utils::mdate('Y-m-d H:i:s');
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	public function showLogin()
	{
		include(Config::$htmlDir . 'admin/login.php');
	}
	
	/**
	 * 显示管理首页
	 */
	public function showMain()
	{
		include(Config::$htmlDir . 'admin/main.php');
	}
	
	/**
	 * 显示修改密码页
	 */
	public function showChangePassword()
	{
		include(Config::$htmlDir . 'admin/change_password.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	public function showDb($_tableList)
	{
		include(Config::$htmlDir . 'admin/db.php');
	}
}

/**
 * 好友模块
 * @author Shines
 */
class FriendController
{
	private $user = null;//用户
	
	public function __construct()
	{
		$this->user = new User();
	}
	
	public function getFriends()
	{
		
	}
	
	public function addFriend()
	{
		
	}
	
	public function deleteFriend()
	{
		
	}
	
	public function getRecommend()
	{
		
	}
	
	public function getMessage()
	{
		
	}
	
	public function setMessage()
	{
		
	}
	
	public function deleteMessage()
	{
		
	}
}

/**
 * 消息模块
 * @author Shines
 */
class InfoController
{
	private $info = null;//消息
	private $user = null;//用户
	private $admin = null;//管理员
	
	public function __construct()
	{
		$this->info = new Info();
		$this->user = new User();
		$this->admin = new Admin();
	}
	
	public function getSystemMessage()
	{
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->info->countSystemMessage();
		$res = $this->info->getSystemMessage($page, $pagesize);
		System::echoData(Config::$msg['ok'], array('total' => $total, 'data' => $res));
	}
	
	public function setSystemMessage()
	{
		System::fixSubmit('setSystemMessage');
		if ($this->admin->checkLogin())
		{
			$content = Security::varPost('content');
			$this->info->setSystemMessage($content);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function deleteSystemMessage()
	{
		System::fixSubmit('setSystemMessage');
		if ($this->admin->checkLogin())
		{
			$id = Security::varPost('id');
			$this->info->deleteSystemMessage($id);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getFeedback()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$res = $this->info->getFeedback($uid);
			System::echoData(Config::$msg['ok'], array('data' => $res));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setFeedback()
	{
		Config::$sid = Security::varPost('imei');
		$content = Security::varPost('content');
		$image = Security::varPost('image');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$id = $this->info->setFeedback($uid, 'system', $content, $image);
			$feedback = $this->info->getFeedbackById($id);
			System::echoData(Config::$msg['ok'], array('data' => array($feedback)));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function deleteFeedback()
	{
		Config::$sid = Security::varPost('imei');
		$id = Security::varPost('id');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->info->deleteFeedback($id);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getVersion()
	{
		System::echoData(Config::$msg['ok'], array('version' => '1.0.0', 'apkUrl' => 'http://159.8.94.69/publishers/globalpublishers1.0.0.apk', 'log' => '1.add comments.\n2.fix bug.'));
	}
	
	public function getFaq()
	{
		Config::$sid = Security::varPost('imei');
		$res = $this->info->getFaq();
		System::echoData(Config::$msg['ok'], array('data' => $res));
	}
	
	public function uploadImage()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$param = $this->info->uploadImage();
			$code = $param['code'];
			$pic = $param['pic'];
			$msg = $param['msg'];
			switch ($code)
			{
				case 0:
					System::echoData(Config::$msg['ok'], array('image' => $pic));
					break;
				case 1:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
					break;
				default:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getAllFeedback()
	{
		
	}
}

/**
 * 系统安装模块
 * @author Shines
 */
class InstallController
{
	private $install = null;//安装
	
	public function __construct()
	{
		$this->install = new Install();
	}
	
	/**
	 * 显示数据库名字
	 */
	public function dbName()
	{
		System::fixSubmit('dbName');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			echo Config::$dbConfig['dbName'];
		}
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		System::fixSubmit('createDatabase');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			$this->install->createDatabase();
			echo 'Succeed!';
		}
	}
	
	/**
	 * 安装数据库
	 */
	public function install()
	{
		System::fixSubmit('install');
		if (file_exists(Config::$installLock))
		{
			echo 'Locked!';
		}
		else
		{
			$this->install->install();
			$this->createLockFile();
			echo 'Succeed!';
		}
	}
	
	/**
	 * 生成锁定文件
	 */
	private function createLockFile()
	{
		$file = fopen(Config::$installLock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库时才可删除。?>');
		fclose($file);
	}
}

/**
 * 主入口
 * @author Shines
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
		$action = Security::varGet('a');//操作标识
		Config::$deviceType = Security::varGet('d');//设备类型
		if (empty(Config::$deviceType))
		{
			if (Utils::checkMobile())
			{
				//手机版
				Config::$deviceType = 'mobile';
			}
			else
			{
				//PC版
				Config::$deviceType = 'pc';
			}
		}
		
		switch ($module)
		{
			case 'install':
				$this->goInstall($action);
				break;
			case 'admin':
				$this->goAdmin($action);
				break;
			case 'user':
				$this->goUser($action);
				break;
			case 'news':
				$this->goNews($action);
				break;
			case 'info':
				$this->goInfo($action);
				break;
			case 'video':
				$this->goVideo($action);
				break;
			default:
		}
		
		//记录执行时间过长的接口
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
		
		/////////// debug
		Debug::log('GET: ' . json_encode($_GET));
		Debug::log('POST: ' . json_encode($_POST));
	}
	
	/**
	 * 安装模块
	 */
	private function goInstall($action)
	{
		$controller = new InstallController();
		switch ($action)
		{
			case 'dbName':
				$controller->dbName();
				break;
			case 'createDatabase':
				$controller->createDatabase();
				break;
			case 'install':
				$controller->install();
				break;
			default:
		}
	}
	
	/**
	 * 管理员模块
	 */
	private function goAdmin($action)
	{
		$controller = new AdminController();
		switch ($action)
		{
			case 'verify':
				$controller->verify();
				break;
			case 'doLogin':
				$controller->doLogin();
				break;
			case 'changePassword':
				$controller->changePassword();
				break;
			case 'doChangePassword':
				$controller->doChangePassword();
				break;
			case 'logout':
				$controller->logout();
				break;
			case 'install':
				$controller->install();
				break;
			case 'db':
				$controller->db();
				break;
			case 'dbNews':
				$controller->dbNews();
				break;
			case 'upgrade':
				$controller->upgrade();
				break;
			case 'backup':
				$controller->backup();
				break;
			case 'recover':
				$controller->recover();
				break;
			case 'find':
				$controller->find();
				break;
			case 'log':
				$controller->log();
				break;
			case 'logTime':
				$controller->logTime();
				break;
			case 'phpinfo':
				$controller->info();
				break;
			case 'date':
				$controller->showDate();
				break;
			default:
				$controller->main();
		}
	}
	
	/**
	 * 用户模块
	 */
	private function goUser($action)
	{
		$controller = new UserController();
		switch ($action)
		{
			case 'verify':
				$controller->verify();
				break;
			case 'register':
				$controller->register();
				break;
			case 'login':
				$controller->login();
				break;
			case 'setNick':
				$controller->setNick();
				break;
			case 'setPhone':
				$controller->setPhone();
				break;
			case 'setSignature':
				$controller->setSignature();
				break;
			case 'uploadPhoto':
				$controller->uploadPhoto();
				break;
			case 'logout':
				$controller->logout();
				break;
			case 'setEmail':
				$controller->setEmail();
				break;
			case 'changePassword':
				$controller->changePassword();
				break;
			case 'resetPassword':
				$controller->resetPassword();
				break;
			default:
		}
	}
	
	/**
	 * 新闻模块
	 */
	private function goNews($action)
	{
		$controller = new NewsController();
		switch ($action)
		{
			case 'updateNews':
				$controller->updateNews();
				break;
			case 'getRecentNews':
				$controller->getRecentNews();
				break;
			case 'getChannelNews':
				$controller->getChannelNews();
				break;
			case 'getComment':
				$controller->getComment();
				break;
			case 'addComment':
				$controller->addComment();
				break;
			case 'getChannel':
				$controller->getChannel();
				break;
			case 'addUserChannel':
				$controller->addUserChannel();
				break;
			case 'removeUserChannel':
				$controller->removeUserChannel();
				break;
			case 'moveUserChannel':
				$controller->moveUserChannel();
				break;
			case 'getLike':
				$controller->getLike();
				break;
			case 'like':
				$controller->like();
				break;
			case 'unlike':
				$controller->unlike();
				break;
			case 'getCollection':
				$controller->getCollection();
				break;
			case 'collect':
				$controller->collect();
				break;
			case 'uncollect':
				$controller->uncollect();
				break;
			case 'getMyComments':
				$controller->getMyComments();
				break;
			case 'search':
				$controller->search();
				break;
			case 'test':
				$controller->test();
				break;
			default:
		}
	}
	
	/**
	 * 消息模块
	 */
	private function goInfo($action)
	{
		$controller = new InfoController();
		switch ($action)
		{
			case 'getSystemMessage':
				$controller->getSystemMessage();
				break;
			case 'setSystemMessage':
				$controller->setSystemMessage();
				break;
			case 'deleteSystemMessage':
				$controller->deleteSystemMessage();
				break;
			case 'getFeedback':
				$controller->getFeedback();
				break;
			case 'setFeedback':
				$controller->setFeedback();
				break;
			case 'deleteFeedback':
				$controller->deleteFeedback();
				break;
			case 'getAllFeedback':
				$controller->getAllFeedback();
				break;
			case 'getVersion':
				$controller->getVersion();
				break;
			case 'getFaq':
				$controller->getFaq();
				break;
			case 'uploadImage':
				$controller->uploadImage();
				break;
			default:
		}
	}
	
	/**
	 * 视频模块
	 */
	private function goVideo($action)
	{
		$controller = new VideoController();
		switch ($action)
		{
			case 'test':
				//$controller->getSystemMessage();
				break;
			default:
				$controller->index();
		}
	}
}

/**
 * 新闻模块
 * @author Shines
 */
class NewsController
{
	private $news = null;//新闻
	private $user = null;//用户
	
	public function __construct()
	{
		$this->news = new News();
		$this->user = new User();
	}
	
	public function updateNews()
	{
		System::fixSubmit('updateNews');
		$key = Security::varGet('key');
		if ($key == 'fjajwiweincnfhf1234151')
		{
			$this->news->updateNews();
			echo 'ok';
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	public function getRecentNews()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countNews();
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->getNews($page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function getChannelNews()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		$channel = Security::varPost('channel');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countChannelNews($channel);
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->getChannelNews($channel, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function getComment()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = Security::varPost('newsId');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countComment($newsId);
		$comment = $this->news->getComment($newsId, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($comment as $key => $value)
			{
				if ($this->news->checkCommentLiked($uid, $value['id']))
				{
					$comment[$key]['liked'] = 1;
				}
			}
		}
		$arr = array('total' => $total, 'data' => $comment);
		System::echoData(Config::$msg['ok'], $arr);
	}
	
	public function addComment()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = Security::varPost('newsId');
		$content = Security::varPost('content');
		if (empty($newsId) || empty($content))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$commentId = $this->news->addComment($newsId, $uid, $content);
			$comment = $this->news->getCommentById($commentId);
			$userinfo = $this->user->getUserInfo();
			$comment['username'] = $userinfo['username'];
			$comment['nick'] = $userinfo['nick'];
			$comment['photo'] = $userinfo['photo'];
			$comment['liked'] = 0;
			System::echoData(Config::$msg['ok'], array('data' => array($comment)));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getChannel()
	{
		Config::$sid = Security::varPost('imei');
		$allChannel = $this->news->getChannel();
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$userChannel = $this->news->getUserChannel($uid);
			$userChannelArr = array();
			if (!empty($userChannel))
			{
				$userChannelArr = json_decode($userChannel, true);
			}
			$index = 1;
			$subIndex1 = 1;
			$subIndex2 = 0;
			foreach ($allChannel as $key => $value)
			{
				$allChannel[$key]['index'] = $index;
				if (in_array($value['channel'], $userChannelArr))
				{
					$allChannel[$key]['follow'] = 1;
					$allChannel[$key]['followIndex'] = $subIndex1;
					$subIndex1++;
				}
				else
				{
					$allChannel[$key]['follow'] = 0;
					$allChannel[$key]['followIndex'] = $subIndex2;
					$subIndex2++;
				}
				$index++;
			}
			$allChannel = array_merge(array(array('channel' => 'Recommend', 'index' => 0, 'follow' => 1, 'followIndex' => 0)), $allChannel);
		}
		else
		{
			$index = 1;
			$subIndex = 1;
			foreach ($allChannel as $key => $value)
			{
				$allChannel[$key]['index'] = $index;
				$allChannel[$key]['follow'] = 0;
				$allChannel[$key]['followIndex'] = $subIndex;
				$subIndex++;
				$index++;
			}
			$allChannel = array_merge(array(array('channel' => 'Recommend', 'index' => 0, 'follow' => 0, 'followIndex' => 0)), $allChannel);
		}
		System::echoData(Config::$msg['ok'], array('data' => $allChannel));
	}
	
	public function addUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		$place = Security::varPost('place');
		if (empty($channel) || empty($place))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->addUserChannel($uid, $channel, $place);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function removeUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		if (empty($channel))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->removeUserChannel($uid, $channel);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function moveUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		$place = Security::varPost('place');
		if (empty($channel) || empty($place))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->moveUserChannel($uid, $channel, $place);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getLike()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		$res = $this->news->getCommentLikes($commentId);
		$total = $this->news->countCommentLikes($commentId);
		System::echoData(Config::$msg['ok'], array('total' => $total, 'data' => $res));
	}
	
	public function like()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->likeComment($uid, $commentId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function unlike()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->unlikeComment($uid, $commentId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getCollection()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$total = $this->news->countCollection($uid);
			$newsArr = array('total' => $total, 'data' => array());
			$res = $this->news->getCollection($uid, $page, $pagesize);
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 1;
				$newsArr['data'][] = $value;
			}
			System::echoData(Config::$msg['ok'], $newsArr);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function collect()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = (int)Security::varPost('newsId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->collect($uid, $newsId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function uncollect()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = (int)Security::varPost('newsId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->uncollect($uid, $newsId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getMyComments()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$total = $this->news->countUserComments($uid);
			$newsArr = array('total' => $total, 'data' => array());
			$res = $this->news->getUserComments($uid, $page, $pagesize);
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$userinfo = $this->user->getUserInfo();
				$value['username'] = $userinfo['username'];
				$value['nick'] = $userinfo['nick'];
				$value['photo'] = $userinfo['photo'];
				if ($this->news->checkCommentLiked($uid, $value['id']))
				{
					$value['liked'] = 1;
				}
				else
				{
					$value['liked'] = 0;
				}
				$newsArr['data'][] = $value;
			}
			System::echoData(Config::$msg['ok'], $newsArr);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function search()
	{
		Config::$sid = Security::varPost('imei');
		$keywords = Security::varPost('keywords');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countSearch($keywords);
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->search($keywords, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function test()
	{
		$this->news->test();
	}
}

/**
 * 用户模块
 * @author Shines
 */
class UserController
{
	private $user = null;//用户
	private $news = null;//新闻
	
	public function __construct()
	{
		$this->user = new User();
		$this->news = new News();
	}
	
	/**
	 * 生成验证码
	 */
	public function verify()
	{
		Config::$sid = Security::varPost('imei');
		$this->user->getVerify();
	}
	
	public function register()
	{
		Config::$sid = Security::varPost('imei');
		$verify = Security::varPost('verify');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$email = Security::varPost('email');
		
		if ($this->user->checkVerify($verify))
		{
			$res = $this->user->register($username, $password, $email);
			$code = $res['code'];
			$uid = $res['uid'];
			switch ($code)
			{
				case 0:
					$this->news->initUserChannel($uid);
					System::echoData(Config::$msg['ok']);
					break;
				case 1:
					System::echoData(Config::$msg['userPwEmailEmpty']);
					break;
				case 2:
					System::echoData(Config::$msg['emailFormatError']);
					break;
				case 3:
					System::echoData(Config::$msg['usernameExist']);
					break;
				case 4:
					System::echoData(Config::$msg['emailExist']);
					break;
				case 5:
					System::echoData(Config::$msg['genUidError']);
					break;
				default:
			}
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
	
	public function login()
	{
		Config::$sid = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		
		if ($this->user->login($username, $password))
		{
			$userinfo = $this->user->getUserInfo();
			if (!empty($userinfo))
			{
				$uid = $userinfo['uid'];
				$key = Security::multiMd5($uid, Config::$key);
				System::echoData(Config::$msg['ok'], array('auth' => $uid, 'saltkey' => $key, 'userinfo' => $userinfo));
			}
			else
			{
				System::echoData(Config::$msg['usernamePwError']);
			}
		}
		else
		{
			System::echoData(Config::$msg['usernamePwError']);
		}
	}
	
	public function setNick()
	{
		Config::$sid = Security::varPost('imei');
		$nick = Security::varPost('nick');
		if ($this->user->checkLogin())
		{
			$this->user->setNick($nick);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('nick' => $userinfo['nick']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setPhone()
	{
		Config::$sid = Security::varPost('imei');
		$phone = Security::varPost('phone');
		if ($this->user->checkLogin())
		{
			$this->user->setPhone($phone);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('phone' => $userinfo['phone']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setSignature()
	{
		Config::$sid = Security::varPost('imei');
		$signature = Security::varPost('signature');
		if ($this->user->checkLogin())
		{
			$this->user->setSignature($signature);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('signature' => $userinfo['signature']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function uploadPhoto()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$param = $this->user->uploadPhoto();
			$code = $param['code'];
			$pic = $param['pic'];
			$msg = $param['msg'];
			switch ($code)
			{
				case 0:
					System::echoData(Config::$msg['ok'], array('photo' => $pic));
					break;
				case 1:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
					break;
				default:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function logout()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$this->user->logout();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setEmail()
	{
		Config::$sid = Security::varPost('imei');
		$email = Security::varPost('email');
		if ($this->user->checkLogin())
		{
			if (Check::email($email))
			{
				$this->user->setEmail($email);
				$userinfo = $this->user->getUserInfo();
				System::echoData(Config::$msg['ok'], array('email' => $userinfo['email']));
			}
			else
			{
				System::echoData(Config::$msg['emailFormatError']);
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword()
	{
		Config::$sid = Security::varPost('imei');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if ($this->user->checkLogin())
		{
			if ($this->user->checkPassword($srcPassword))
			{
				$this->user->changePassword($newPassword);
				System::echoData(Config::$msg['ok']);
			}
			else
			{
				System::echoData(Config::$msg['srcPwErorr']);
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 重置找回密码
	 */
	public function resetPassword()
	{
		Config::$sid = Security::varPost('imei');
		$verify = Security::varPost('verify');
		$username = Security::varPost('username');
		
		if ($this->user->checkVerify($verify))
		{
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
}

/**
 * 视频模块
 * @author Shines
 */
class VideoController
{
	public function __construct()
	{
		
	}
	
	public function index()
	{
		include(Config::$htmlDir . 'video/index.php');
	}
}

/**
 * 管理员
 * @author Shines
 */
class Admin
{
	public function __construct()
	{
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_adminVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_adminVerify']) ? $_SESSION[Config::$systemName . '_adminVerify'] : '';
		unset($_SESSION[Config::$systemName . '_adminVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$password = Security::multiMd5($password, Config::$key);
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbAdmin where username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (!empty($res))
		{
			if ($password == $res['password'])
			{
				System::setSession('adminUserId', (int)$res['id']);
				System::setSession('adminUsername', $res['username']);
				System::setSession('adminPassword', $res['password']);
				if (!Config::$isLocal)
				{
					Debug::log('[admin login] userId: ' . $res['id'] . ', username: ' . $res['username']);
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 检测是否已登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('adminUserId');
		System::clearSession('adminUsername');
		System::clearSession('adminPassword');
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($password)
	{
		$sessionPassword = $this->getPassword();
		$inPassword = Security::multiMd5($password, Config::$key);
		if ($sessionPassword == $inPassword)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($newPassword)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlId = (int)$this->getUserId();
		$newPassword = Security::multiMd5($newPassword, Config::$key);
		$sqlNewPassword = Security::varSql($newPassword);
		Config::$db->query("update $tbAdmin set password=$sqlNewPassword where id=$sqlId");
	}
	
	/**
	 * 获取用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('adminUserId');
	}
	
	/**
	 * 获取用户名
	 */
	public function getUsername()
	{
		return System::getSession('adminUsername');
	}
	
	/**
	 * 获取密码
	 */
	public function getPassword()
	{
		return System::getSession('adminPassword');
	}
}

/**
 * 配置信息
 * @author Shines
 */
class Config
{
	//通用部分
	public static $scheme = 2;//配置方案。1：local，2：线上68
	public static $isLocal = false;//是否为本地模式
	public static $backupDir = 'data/backup/';//数据库备份目录
	public static $recoverDir = 'data/recover/';//数据库恢复目录
	public static $logDir = 'data/log/';//日志目录
	public static $uploadsDir = 'data/uploads/';//上传目录
	public static $newsCacheDir = 'data/cache/news/';//新闻缓存目录
	public static $viewDir = '_view';//模板目录
	public static $htmlDir = 'html/';//模板缓存目录
	public static $viewMd5 = 'data/md5_view.php';//模板md5文件，用来检测模板是否有修改
	public static $installLock = 'data/lock_install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if (!defined(\'VIEW\')) exit; ?>';//VIEW入口检测代码
	public static $deviceType = '';//设备类型，pc，mobile
	public static $db = null;//数据库
	public static $tbSession = 'publishers_session';//会话表
	public static $tbAdmin = 'publishers_admin';//管理员表
	public static $tbUser = 'publishers_user';//用户表
	public static $tbFriend = 'publishers_friend';//好友表
	public static $tbMessage = 'publishers_message';//留言表
	public static $tbNews = 'publishers_news';//新闻表
	public static $tbNewsPic = 'publishers_news_pic';//新闻图片表
	public static $tbComment = 'publishers_comment';//评论表
	public static $tbCollection = 'publishers_collection';//收藏表
	public static $tbLike = 'publishers_like';//点赞表
	public static $tbChannel = 'publishers_channel';//栏目表
	public static $tbUserChannel = 'publishers_user_channel';//用户栏目表
	public static $tbFeedback = 'publishers_feedback';//反馈表
	public static $tbFaq = 'publishers_faq';//FAQ表
	public static $dataUrl = 'http://globalpublishers.co.tz';//获取数据地址
	public static $sid = '';//session id，会话id
	public static $msg = array
	(
		//通用
		'ok' => array('code' => 0, 'msg' => 'ok'),
		'requestError' => array('code' => 1, 'msg' => 'Request Error!'),
		
		//用户
		'noLogin' => array('code' => 101001, 'msg' => 'Not login!'),
		'usernamePwError' => array('code' => 101002, 'msg' => 'Username or password error!'),
		'verifyError' => array('code' => 101003, 'msg' => 'Verify error!'),
		'srcPwErorr' => array('code' => 101004, 'msg' => 'Source password error!'),
		'newPwError' => array('code' => 101005, 'msg' => 'New password too simple!'),
		'userExist' => array('code' => 101006, 'msg' => 'User exist!'),
		'emailFormatError' => array('code' => 101007, 'msg' => 'Email format error!'),
		'userPwEmailEmpty' => array('code' => 101008, 'msg' => 'Username password and email cannot be empty!'),
		'usernameExist' => array('code' => 101009, 'msg' => 'Username exist!'),
		'emailExist' => array('code' => 101010, 'msg' => 'Email exist!'),
		'genUidError' => array('code' => 101011, 'msg' => 'Generate ID error, please retry!'),
		'photoError' => array('code' => 101012, 'msg' => 'Upload photo error!')
	);//操作提示
	
	//单独配置部分
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = '';//资源文件地址
	public static $systemName = '';//系统名称
	public static $key = '';//密钥
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $ipUrl = '';//IP地址库
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	public static $maxPrize = 0;//最大奖品数
	public static $prizeName = null;//奖品名称
	public static $prizeMoney = null;//奖品名称
	public static $adminNewsPagesize = 0;//新闻管理每页显示新闻条数
	public static $maxNewsPagesize = 0;//前端每页显示新闻条数
	public static $maxContent = 0;//最大新闻长度
	public static $countCode = '';//统计代码
	
	private static $dbLocal = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);//本地数据库配置信息
	
	private static $db68 = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);//线上68数据库配置信息
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		@session_start();
		if (self::$isLocal)
		{
			self::$scheme = 1;
		}
		switch (self::$scheme)
		{
			case 1:
				self::configLocal();
				break;
			case 2:
				self::config68();
				break;
			default:
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$logDir . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$logDir . 'time_' . Utils::mdate('Y-m-d') . '.php';
		Debug::$maxTime = 0.01;
		self::$db = new Database(self::$dbConfig);
		define('VIEW', true);//限制视图文件须由控制器调用才可执行
	}
	
	/**
	 * 本地模式
	 */
	private static function configLocal()
	{
		@error_reporting(E_ALL);
		@date_default_timezone_set('Etc/GMT-8');//北京时间
		self::$dbConfig = self::$dbLocal;//数据库配置信息，线上或本地
		self::$baseUrl = 'http://172.17.2.73/svn/publishers';//当前网址，线上或本地
		self::$resUrl = 'http://172.17.2.73/svn/publishers';//资源文件地址
		self::$systemName = 'publishers';//系统名称
		self::$key = 'fieiubv,.257,._aiii111s';//密钥
		self::$newsEnabled = false;//新闻开关
		self::$zhuanPanEnabled = false;//转盘开关
		self::$hongBaoEnabled = false;//红包开关
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$maxPrize = 10;//最大奖品数
		self::$prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
		self::$prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
		self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
		self::$maxNewsPagesize = 1000;//前端每页显示新闻条数
		self::$maxContent = 10000;//最大新闻长度
		self::$countCode = '';//统计代码
	}
	
	/**
	 * 线上模式
	 */
	private static function config68()
	{
		@error_reporting(0);
		@date_default_timezone_set('Etc/GMT-8');//北京时间
		self::$dbConfig = self::$db68;//数据库配置信息，线上或本地
		self::$baseUrl = 'http://IP/publishers';//当前网址，线上或本地
		self::$resUrl = 'http://IP/publishers';//资源文件地址
		self::$systemName = 'publishers';//系统名称
		self::$key = 'iexcvmn12,_,1anxl,,..';//密钥
		self::$newsEnabled = false;//新闻开关
		self::$zhuanPanEnabled = false;//转盘开关
		self::$hongBaoEnabled = false;//红包开关
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$maxPrize = 10;//最大奖品数
		self::$prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
		self::$prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
		self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
		self::$maxNewsPagesize = 1000;//前端每页显示新闻条数
		self::$maxContent = 10000;//最大新闻长度
		self::$countCode = '';//统计代码
	}
}

/**
 * 系统消息
 * @author Shines
 */
class Info
{
	public function __construct()
	{
	}
	
	public function getSystemMessage($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbMessage = Config::$tbMessage;
		Config::$db->query("select id, content, message_date from $tbMessage where from_id='system' and to_id='all' order by id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countSystemMessage()
	{
		Config::$db->connect();
		$tbMessage = Config::$tbMessage;
		Config::$db->query("select count(*) as num from $tbMessage where from_id='system' and to_id='all'");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function setSystemMessage($content)
	{
		Config::$db->connect();
		$sqlContent = Security::varSql($content);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbMessage = Config::$tbMessage;
		Config::$db->query("insert into $tbMessage (from_id, to_id, content, message_date) values ('system', 'all', $sqlContent, $sqlDate)");
	}
	
	public function deleteSystemMessage($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbMessage = Config::$tbMessage;
		Config::$db->query("delete from $tbMessage where id=$sqlId");
	}
	
	public function getFeedback($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback where from_id=$sqlUid or to_id=$sqlUid or to_id='all'");
		return Config::$db->getAllRows();
	}
	
	public function setFeedback($from, $to, $content, $image)
	{
		Config::$db->connect();
		$sqlFrom = Security::varSql($from);
		$sqlTo = Security::varSql($to);
		$sqlContent = Security::varSql($content);
		$sqlImage = Security::varSql($image);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("insert into $tbFeedback (from_id, to_id, content, feedback_date, image) values ($sqlFrom, $sqlTo, $sqlContent, $sqlDate, $sqlImage)");
		return Config::$db->getInsertId();
	}
	
	public function getFeedbackById($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback where id=$sqlId");
		return Config::$db->getRow();
	}
	
	public function deleteFeedback($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("delete from $tbFeedback where id=$sqlId");
	}
	
	public function getAllFeedback()
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback order by id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countAllFeedback()
	{
		Config::$db->connect();
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select count(*) as num from $tbFeedback");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getFaq()
	{
		Config::$db->connect();
		$tbFaq = Config::$tbFaq;
		Config::$db->query("select id, question, answer, pubdate from $tbFaq");
		return Config::$db->getAllRows();
	}
	
	public function uploadImage()
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$tempPic = $param['file'];
			$newPic = Config::$uploadsDir . time() . rand(100000, 999999) . '.jpg';
			Image::thumb($tempPic, $newPic, "", 1000, 1000);
			@unlink($tempPic);
			return array('code' => 0, 'pic' => Config::$baseUrl . '/' . $newPic, 'msg' => 'ok');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'pic' => '', 'msg' => $msg);
		}
	}
}

/**
 * 安装系统
 * @author Shines
 */
class Install
{
	public function __construct()
	{
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		$dbName = Config::$dbConfig['dbName'];
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		Config::$db->connect();
		Config::$db->query("create database if not exists $dbName default character set $dbCharset collate $dbCollat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->createTable();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function createTable()
	{
		Config::$db->connect();
		$tbSession = Config::$tbSession;//会话表
		$tbAdmin = Config::$tbAdmin;//管理员表
		$tbUser = Config::$tbUser;//用户表
		$tbFriend = Config::$tbFriend;//好友表
		$tbMessage = Config::$tbMessage;//留言表
		$tbNews = Config::$tbNews;//新闻表
		$tbNewsPic = Config::$tbNewsPic;//新闻图片表
		$tbComment = Config::$tbComment;//评论表
		$tbCollection = Config::$tbCollection;//收藏表
		$tbLike = Config::$tbLike;//点赞表
		$tbChannel = Config::$tbChannel;//栏目表
		$tbUserChannel = Config::$tbUserChannel;//用户栏目表
		$tbFeedback = Config::$tbFeedback;//反馈表
		$tbFaq = Config::$tbFaq;//FAQ表
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbSession");
		Config::$db->query("create table $tbSession (
			id int not null auto_increment primary key,
			sid varchar(200) not null,
			content text not null,
			create_date datetime not null,
			expire_date datetime not null,
			index (sid),
			index (expire_date)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			uid varchar(50) not null,
			username varchar(50) not null,
			password varchar(200) not null,
			email varchar(255) not null,
			phone varchar(50) not null,
			nick varchar(50) not null,
			signature varchar (400) not null,
			photo varchar(255) not null,
			register_date datetime not null,
			register_ip varchar(50) not null,
			index (uid),
			index (username),
			index (email),
			index (phone)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFriend");
		Config::$db->query("create table $tbFriend (
			id int not null auto_increment primary key,
			uid1 varchar(50) not null,
			uid2 varchar(50) not null,
			is_add1 int not null,
			is_add2 int not null,
			add_date datetime not null,
			index (uid1),
			index (uid2)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbMessage");
		Config::$db->query("create table $tbMessage (
			id int not null auto_increment primary key,
			from_id varchar(50) not null,
			to_id varchar(50) not null,
			content text not null,
			message_date datetime not null,
			index (from_id),
			index (to_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbNews");
		Config::$db->query("create table $tbNews (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			type varchar(20) not null,
			slug varchar(50) not null,
			url varchar(255) not null,
			status varchar(20) not null,
			title varchar(200) not null,
			title_plain varchar(200) not null,
			content text not null,
			excerpt text not null,
			pubdate datetime not null,
			modified datetime not null,
			channel varchar(50) not null,
			tags varchar(300),
			author varchar(50) not null,
			index (newsid),
			index (channel)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbNewsPic");
		Config::$db->query("create table $tbNewsPic (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			full_img varchar(255) not null,
			full_width int not null,
			full_height int not null,
			thumbnail_img varchar(255) not null,
			thumbnail_width int not null,
			thumbnail_height int not null,
			medium_img varchar(255) not null,
			medium_width int not null,
			medium_height int not null,
			post_thumbnail_img varchar(255) not null,
			post_thumbnail_width int not null,
			post_thumbnail_height int not null,
			index (newsid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			uid varchar(50) not null,
			content text not null,
			comment_date datetime not null,
			like_count int not null,
			index (newsid),
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbCollection");
		Config::$db->query("create table $tbCollection (
			id int not null auto_increment primary key,
			uid varchar(50) not null,
			newsid varchar(50) not null,
			collect_date datetime not null,
			index (uid),
			index (newsid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbLike");
		Config::$db->query("create table $tbLike (
			id int not null auto_increment primary key,
			commentid int not null,
			uid varchar(50) not null,
			like_date datetime not null,
			index (commentid),
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbChannel");
		Config::$db->query("create table $tbChannel (
			id int not null auto_increment primary key,
			channel varchar(50) not null,
			index (channel)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUserChannel");
		Config::$db->query("create table $tbUserChannel (
			id int not null auto_increment primary key,
			uid varchar(50) not null,
			channel text not null,
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFeedback");
		Config::$db->query("create table $tbFeedback (
			id int not null auto_increment primary key,
			from_id varchar(50) not null,
			to_id varchar(50) not null,
			content text not null,
			feedback_date datetime not null,
			image varchar(255) not null,
			index (from_id),
			index (to_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFaq");
		Config::$db->query("create table $tbFaq (
			id int not null auto_increment primary key,
			question text not null,
			answer text not null,
			pubdate datetime not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlPassword = Security::multiMd5('admin', Config::$key);
		Config::$db->query("insert into $tbAdmin (username, password) values ('admin', '$sqlPassword')");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function getAllTables()
	{
		Config::$db->connect();
		return Config::$db->getAllTables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function getAllFields($tbName)
	{
		Config::$db->connect();
		return Config::$db->getAllFields($tbName);
	}
	
	/**
	 * 获取指定表的记录
	 */
	public function getRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		Config::$db->query("select * from $tbName limit $sqlStart, $sqlRecordCount");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars(substr($row[$i], 0, 50), ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$backupDir . Utils::mdate('Y-m-d') . '/';
		Utils::createDir($path);
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], Config::$recoverDir);
		$db->importSql();
	}
	
	/**
	 * 在数据库中查找关键词
	 */
	public function find($keywords)
	{
		Config::$db->connect();
		$res = array();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tables = $this->getAllTables();
		foreach ($tables as $tb)
		{
			//echo '$tb: ' . $tb . '<br />';
			$fields = $this->getAllFields($tb);
			foreach ($fields as $fd)
			{
				if ('register_date' == $fd)
				{
					continue;
				}
				//echo '$fd: ' . $fd . '<br />';
				$sqlTb = '`' . $tb . '`';
				$sqlFd = '`' . $fd . '`';
				Config::$db->query("select $sqlFd from $sqlTb where $sqlFd like $sqlKeywords");
				$rows = Config::$db->getAllRows();
				if (!empty($rows))
				{
					$tableInfo = array();
					$tableInfo['tbname'] = $tb;
					$tableInfo['fields'] = array($fd);
					$tableInfo['records'] = $rows;
					$res[] = $tableInfo;
				}
			}
		}
		return $res;
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		Config::$db->connect();
		$tbSession = Config::$tbSession;//会话表
		$tbAdmin = Config::$tbAdmin;//管理员表
		$tbUser = Config::$tbUser;//用户表
		$tbFriend = Config::$tbFriend;//好友表
		$tbMessage = Config::$tbMessage;//留言表
		$tbNews = Config::$tbNews;//新闻表
		$tbNewsPic = Config::$tbNewsPic;//新闻图片表
		$tbComment = Config::$tbComment;//评论表
		$tbCollection = Config::$tbCollection;//收藏表
		$tbLike = Config::$tbLike;//点赞表
		$tbChannel = Config::$tbChannel;//栏目表
		$tbUserChannel = Config::$tbUserChannel;//用户栏目表
		$tbFeedback = Config::$tbFeedback;//反馈表
		$tbFaq = Config::$tbFaq;//FAQ表
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
	}
}

/**
 * 新闻
 * @author Shines
 */
class News
{
	public function __construct()
	{
	}
	
	public function updateNews()
	{
		$res = Http::phpPost(Config::$dataUrl . '/?json=get_recent_posts', array(), 10);
		try
		{
			$arr = json_decode($res, true);
		}
		catch (Exception $e)
		{
			exit;
		}
		
		/////////// debug
		//echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		//Utils::dumpArr($arr);
		//return;
		
		if (!empty($arr))
		{
			if (isset($arr['status']) && $arr['status'] == 'ok')
			{
				//最新新闻列表
				$news = isset($arr['posts']) ? $arr['posts'] : array();
				$len = count($news);
				for ($i = $len - 1; $i>= 0; $i--)
				{
					$id = isset($news[$i]['id']) ? $news[$i]['id'] : 0;
					$type = isset($news[$i]['type']) ? $news[$i]['type'] : '';
					$slug = isset($news[$i]['slug']) ? $news[$i]['slug'] : '';
					$url = isset($news[$i]['url']) ? $news[$i]['url'] : '';
					$status = isset($news[$i]['status']) ? $news[$i]['status'] : '';
					$title = isset($news[$i]['title']) ? $news[$i]['title'] : '';
					$title_plain = isset($news[$i]['title_plain']) ? $news[$i]['title_plain'] : '';
					$content = isset($news[$i]['content']) ? $news[$i]['content'] : '';
					$excerpt = isset($news[$i]['excerpt']) ? $news[$i]['excerpt'] : '';
					$dateStr = isset($news[$i]['date']) ? $news[$i]['date'] : '';
					$date = Utils::mdate('Y-m-d H:i:s', $dateStr);
					$modifiedStr = isset($news[$i]['modified']) ? $news[$i]['modified'] : '';
					$modified = Utils::mdate('Y-m-d H:i:s', $modifiedStr);
					$categories = '';
					$categoriesArr = isset($news[$i]['categories']) ? $news[$i]['categories'] : array();
					if (!empty($categoriesArr))
					{
						$lastCategories = $categoriesArr[count($categoriesArr) - 1];
						$categories = isset($lastCategories['title']) ? trim($lastCategories['title']) : 'Others';
					}
					if (empty($categories))
					{
						continue;
					}
					$tags = '';
					$tagsArr = isset($news[$i]['tags']) ? $news[$i]['tags'] : array();
					$isFirst = true;
					if (!empty($tagsArr))
					{
						foreach ($tagsArr as $value)
						{
							if ($isFirst)
							{
								$isFirst = false;
								$tags = isset($value['title']) ? $value['title'] : '';
							}
							else
							{
								$title = isset($value['title']) ? $value['title'] : '';
								$tags .= ', ' . $title;
							}
						}
					}
					$author = '';
					$authorArr = isset($news[$i]['author']) ? $news[$i]['author'] : null;
					if (!empty($authorArr))
					{
						$author = $authorArr['name'];
						$author = isset($authorArr['name']) ? $authorArr['name'] : '';
					}
					
					if (!$this->existNews($id))
					{
						$this->addNews($id, $type, $slug, $url, $status, $title, $title_plain, $content, $excerpt, $date, $modified, $categories, $tags, $author);
						
						if (!$this->existChannel($categories))
						{
							$this->addChannel($categories);
						}
						
						$attachments = isset($news[$i]['attachments']) ? $news[$i]['attachments'] : array();
						if (!empty($attachments))
						{
							foreach ($attachments as $value)
							{
								$fullImg = isset($value['images']['full']['url']) ? $value['images']['full']['url'] : '';
								$fullWidth = isset($value['images']['full']['width']) ? $value['images']['full']['width'] : 0;
								$fullHeight = isset($value['images']['full']['height']) ? $value['images']['full']['height'] : 0;
								$thumbnailImg = isset($value['images']['thumbnail']['url']) ? $value['images']['thumbnail']['url'] : '';
								$thumbnailWidth = isset($value['images']['thumbnail']['width']) ? $value['images']['thumbnail']['width'] : 0;
								$thumbnailHeight = isset($value['images']['thumbnail']['height']) ? $value['images']['thumbnail']['height'] : 0;
								$mediumImg = isset($value['images']['medium']['url']) ? $value['images']['medium']['url'] : '';
								$mediumWidth = isset($value['images']['medium']['width']) ? $value['images']['medium']['width'] : 0;
								$mediumHeight = isset($value['images']['medium']['height']) ? $value['images']['medium']['height'] : 0;
								$postThumbnailImg = isset($value['images']['post-thumbnail']['url']) ? $value['images']['post-thumbnail']['url'] : '';
								$postThumbnailWidth = isset($value['images']['post-thumbnail']['width']) ? $value['images']['post-thumbnail']['width'] : 0;
								$postThumbnailHeight = isset($value['images']['post-thumbnail']['height']) ? $value['images']['post-thumbnail']['height'] : 0;
								$this->addImage($id, $fullImg, $fullWidth, $fullHeight, $thumbnailImg, $thumbnailWidth, $thumbnailHeight, $mediumImg, $mediumWidth, $mediumHeight, $postThumbnailImg, $postThumbnailWidth, $postThumbnailHeight);
							}
						}
					}
				}
			}
		}
	}
	
	public function existNews($newsId)
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		$sqlNewsId = Security::varSql($newsId);
		Config::$db->query("select id from $tbNews where newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function existChannel($channel)
	{
		Config::$db->connect();
		$tbChannel = Config::$tbChannel;
		$sqlChannel = Security::varSql($channel);
		Config::$db->query("select id from $tbChannel where channel=$sqlChannel");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 添加新闻
	 */
	public function addNews($newsId, $type, $slug, $url, $status, $title, $title_plain, $content, $excerpt, $date, $modified, $categories, $tags, $author)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlType = Security::varSql($type);
		$sqlSlug = Security::varSql($slug);
		$sqlUrl = Security::varSql($url);
		$sqlStatus = Security::varSql($status);
		$sqlTitle = Security::varSql($title);
		$sqlTitlePlain = Security::varSql($title_plain);
		$sqlContent = Security::varSql($content);
		$sqlExcerpt = Security::varSql($excerpt);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s', $date));
		$sqlModified = Security::varSql(Utils::mdate('Y-m-d H:i:s', $modified));
		$sqlCategories = Security::varSql($categories);
		$sqlTags = Security::varSql($tags);
		$sqlAuthor = Security::varSql($author);
		$tbNews = Config::$tbNews;
		Config::$db->query("insert into $tbNews (newsid, type, slug, url, status, title, title_plain, content, excerpt, pubdate, modified, channel, tags, author) values ($sqlNewsId, $sqlType, $sqlSlug, $sqlUrl, $sqlStatus, $sqlTitle, $sqlTitlePlain, $sqlContent, $sqlExcerpt, $sqlDate, $sqlModified, $sqlCategories, $sqlTags, $sqlAuthor)");
	}
	
	public function addChannel($value)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($value);
		$tbChannel = Config::$tbChannel;
		Config::$db->query("insert into $tbChannel (channel) values ($sqlChannel)");
	}
	
	public function addImage($newsId, $fullImg, $fullWidth, $fullHeight, $thumbnailImg, $thumbnailWidth, $thumbnailHeight, $mediumImg, $mediumWidth, $mediumHeight, $postThumbnailImg, $postThumbnailWidth, $postThumbnailHeight)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlFullImg = Security::varSql($fullImg);
		$sqlFullWidth = (int)$fullWidth;
		$sqlFullHeight = (int)$fullHeight;
		$sqlThumbnailImg = Security::varSql($thumbnailImg);
		$sqlThumbnailWidth = (int)$thumbnailWidth;
		$sqlThumbnailHeight = (int)$thumbnailHeight;
		$sqlMediumImg = Security::varSql($mediumImg);
		$sqlMediumWidth = (int)$mediumWidth;
		$sqlMediumHeight = (int)$mediumHeight;
		$sqlPostThumbnailImg = Security::varSql($postThumbnailImg);
		$sqlPostThumbnailWidth = (int)$postThumbnailWidth;
		$sqlPostThumbnailHeight = (int)$postThumbnailHeight;
		$tbNewsPic = Config::$tbNewsPic;
		Config::$db->query("insert into $tbNewsPic (newsid, full_img, full_width, full_height, thumbnail_img, thumbnail_width, thumbnail_height, medium_img, medium_width, medium_height, post_thumbnail_img, post_thumbnail_width, post_thumbnail_height) values ($sqlNewsId, $sqlFullImg, $sqlFullWidth, $sqlFullHeight, $sqlThumbnailImg, $sqlThumbnailWidth, $sqlThumbnailHeight, $sqlMediumImg, $sqlMediumWidth, $sqlMediumHeight, $sqlPostThumbnailImg, $sqlPostThumbnailWidth, $sqlPostThumbnailHeight)");
	}
	
	/**
	 * 获取新闻，按页
	 */
	public function getNews($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	/**
	 * 获取指定栏目的新闻，按页
	 */
	public function getChannelNews($channel, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($channel);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews where channel=$sqlChannel order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countNews()
	{
		Config::$db->connect();
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function countChannelNews($channel)
	{
		Config::$db->connect();
		$sqlChannel = Security::varSql($channel);
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews where channel=$sqlChannel");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getNewsImage($newsId)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$tbNewsPic = Config::$tbNewsPic;
		Config::$db->query("select full_img, full_width, full_height, thumbnail_img, thumbnail_width, thumbnail_height, medium_img, medium_width, medium_height, post_thumbnail_img, post_thumbnail_width, post_thumbnail_height from $tbNewsPic where newsid=$sqlNewsId");
		return Config::$db->getAllRows();
	}
	
	public function getComment($newsId, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		Config::$db->query("select t1.id as id, t1.newsid as newsid, t1.content as content, t1.comment_date as comment_date, t1.like_count as like_count, t2.username as username, t2.nick as nick, t2.photo as photo from $tbComment as t1 join $tbUser as t2 on t1.uid=t2.uid where t1.newsid=$sqlNewsId limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			if (!empty($res[$key]['photo']))
			{
				$res[$key]['photo'] = Config::$baseUrl . '/' . $res[$key]['photo'];
			}
			$res[$key]['liked'] = 0;
		}
		return $res;
	}
	
	public function countComment($newsId)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment where newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function addComment($newsId, $uid, $content)
	{
		Config::$db->connect();
		$sqlNewsId = Security::varSql($newsId);
		$sqlUid = Security::varSql($uid);
		$sqlContent = Security::varSql($content);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbComment = Config::$tbComment;
		Config::$db->query("insert into $tbComment (newsid, uid, content, comment_date, like_count) values ($sqlNewsId, $sqlUid, $sqlContent, $sqlDate, 0)");
		return Config::$db->getInsertId();
	}
	
	public function getCommentById($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("select id, newsid, content, comment_date, like_count from $tbComment where id=$sqlCommentId");
		return Config::$db->getRow();
	}
	
	public function getChannel()
	{
		Config::$db->connect();
		$tbChannel = Config::$tbChannel;
		Config::$db->query("select channel from $tbChannel");
		return Config::$db->getAllRows();
	}
	
	public function getUserChannel($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("select channel from $tbUserChannel where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['channel'];
		}
		return null;
	}
	
	public function addUserChannel($uid, $channel, $place)
	{
		$place = (int)$place;
		if ($place < 1)
		{
			$place = 1;
		}
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = json_encode(array($channel));
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			array_splice($srcChannelArr, $place - 1, 0, $channel);
			$newStrChannel = json_encode($srcChannelArr);
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function removeUserChannel($uid, $channel)
	{
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = '';
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			$index = array_search($channel, $srcChannelArr);
			if ($index === false)
			{
				$newStrChannel = $srcStrChannel;
			}
			else
			{
				array_splice($srcChannelArr, $index, 1);
				$newStrChannel = json_encode($srcChannelArr);
			}
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function moveUserChannel($uid, $channel, $place)
	{
		$place = (int)$place;
		if ($place < 1)
		{
			$place = 1;
		}
		$srcStrChannel = $this->getUserChannel($uid);
		if (empty($srcChannel))
		{
			$newStrChannel = '';
		}
		else
		{
			$srcChannelArr = json_decode($srcStrChannel, true);
			$index = array_search($channel, $srcChannelArr);
			if ($index === false)
			{
				$newStrChannel = $srcStrChannel;
			}
			else
			{
				array_splice($srcChannelArr, $index, 1);
				array_splice($srcChannelArr, $place - 1, 0, $channel);
				$newStrChannel = json_encode($srcChannelArr);
			}
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($newStrChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("update $tbUserChannel set channel=$sqlChannel where uid=$sqlUid");
	}
	
	public function initUserChannel($uid)
	{
		$allChannel = $this->getChannel();
		$userChannel = array();
		for ($i = 0; $i < 8; $i++)
		{
			$userChannel[] = $allChannel[$i]['channel'];
		}
		$strUserChannel = json_encode($userChannel);
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlChannel = Security::varSql($strUserChannel);
		$tbUserChannel = Config::$tbUserChannel;
		Config::$db->query("insert into $tbUserChannel (uid, channel) values ($sqlUid, $sqlChannel)");
	}
	
	public function getCommentLikes($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		$tbUser = Config::$tbUser;
		Config::$db->query("select t1.like_date as like_date, t2.username as username, t2.nick as nick, t2.photo as photo from $tbLike as t1 join $tbUser as t2 on t1.uid=t2.uid where t1.commentid=$sqlCommentId order by t1.id");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			if (!empty($res[$key]['photo']))
			{
				$res[$key]['photo'] = Config::$baseUrl . '/' . $res[$key]['photo'];
			}
		}
		return $res;
	}
	
	public function countCommentLikes($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		Config::$db->query("select count(*) as num from $tbLike where commentid=$sqlCommentId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function likeComment($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbLike = Config::$tbLike;
		if (!$this->checkCommentLiked($uid, $commentId))
		{
			Config::$db->query("insert into $tbLike (commentid, uid, like_date) values ($sqlCommentId, $sqlUid, $sqlDate)");
			$this->addLike($commentId);
		}
	}
	
	public function checkCommentLiked($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		Config::$db->query("select id from $tbLike where commentid=$sqlCommentId and uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return true;
		}
		return false;
	}
	
	public function addLike($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("update $tbComment set like_count = like_count+1 where id=$sqlCommentId");
	}
	
	public function reduceLike($commentId)
	{
		Config::$db->connect();
		$sqlCommentId = (int)$commentId;
		$tbComment = Config::$tbComment;
		Config::$db->query("update $tbComment set like_count = like_count-1 where id=$sqlCommentId");
	}
	
	public function unlikeComment($uid, $commentId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlCommentId = (int)$commentId;
		$tbLike = Config::$tbLike;
		if ($this->checkCommentLiked($uid, $commentId))
		{
			Config::$db->query("delete from $tbLike where commentid=$sqlCommentId and uid=$sqlUid");
			$this->reduceLike($commentId);
		}
	}
	
	public function collect($uid, $newsId)
	{
		if (!$this->checkCollect($uid, $newsId))
		{
			Config::$db->connect();
			$sqlUid = Security::varSql($uid);
			$sqlNewsId = Security::varSql($newsId);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			$tbCollection = Config::$tbCollection;
			Config::$db->query("insert into $tbCollection (uid, newsid, collect_date) values ($sqlUid, $sqlNewsId, $sqlDate)");
		}
	}
	
	public function checkCollect($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select id from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return true;
		}
		return false;
	}
	
	public function getCollectDate($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select collect_date from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['collect_date'];
		}
		return '';
	}
	
	public function uncollect($uid, $newsId)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlNewsId = Security::varSql($newsId);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("delete from $tbCollection where uid=$sqlUid and newsid=$sqlNewsId");
	}
	
	public function getCollection($uid, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbCollection = Config::$tbCollection;
		$tbNews = Config::$tbNews;
		Config::$db->query("select t1.newsid as newsid, t1.collect_date as collect_date, t2.title as title, t2.content as content, t2.excerpt as excerpt, t2.pubdate as pubdate, t2.channel as channel, t2.tags as tags, t2.author as author from $tbCollection as t1 join $tbNews as t2 on t1.newsid=t2.newsid where t1.uid=$sqlUid order by t1.id limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countCollection($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbCollection = Config::$tbCollection;
		Config::$db->query("select count(*) as num from $tbCollection where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getUserComments($uid, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbComment = Config::$tbComment;
		$tbNews = Config::$tbNews;
		Config::$db->query("select t1.id as id, t1.newsid as newsid, t1.content as comment, t1.comment_date as comment_date, t1.like_count as like_count, t2.title as title, t2.content as content, t2.excerpt as excerpt, t2.pubdate as pubdate, t2.channel as channel, t2.tags as tags, t2.author as author from $tbComment as t1 join $tbNews as t2 on t1.newsid=t2.newsid where t1.uid=$sqlUid order by t1.id limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countUserComments($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function search($keywords, $page, $pagesize)
	{
		Config::$db->connect();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbNews = Config::$tbNews;
		Config::$db->query("select newsid, title, content, excerpt, pubdate, channel, tags, author from $tbNews where content like $sqlKeywords order by id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			//$res[$key]['title'] = strip_tags($res[$key]['title']);
			$res[$key]['content'] = strip_tags($res[$key]['content']);
		}
		return $res;
	}
	
	public function countSearch($keywords)
	{
		Config::$db->connect();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tbNews = Config::$tbNews;
		Config::$db->query("select count(*) as num from $tbNews where content like $sqlKeywords");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function test()
	{
		//$res = Http::phpPost('http://127.0.0.1:8015/?m=news&a=getRecentNews', array('imei' => '11', 'page' => 1, 'pagesize' => 5, 'channel' => 'Dar Live'), 10);
		
		//$res = Http::phpPost('http://IP/publishers/?m=news&a=getMyComments&imei=868455015018234&page=1&pagesize=20&auth=53195939c846146be484b16acdea4abc&saltkey=cbbeccbedghdbb4a25ed75c8c12186c2030a7d89e1095efhaeacfcaeedibeagf', array(), 10);
		
		$res = Http::phpPost('http://127.0.0.1:8015/?m=news&a=getMyComments', array('imei' => '11', 'page' => 1, 'pagesize' => 5, 'channel' => 'Dar Live'), 10);
		
		try
		{
			$arr = json_decode($res, true);
		}
		catch (Exception $e)
		{
			exit;
		}
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		Utils::dumpArr($arr);
	}
}

/**
 * 系统
 * @author Shines
 */
class System
{
	/**
	 * 获取IP地址详细信息
	 */
	public static function getIpInfo($ip)
	{
		$res = @json_decode(Http::phpGet(Config::$ipUrl . $ip));
		if (isset($res->code) && ($res->code == 0) && isset($res->data))
		{
			return $res->data;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 返回数据到客户端
	 */
	public static function echoData($msg, $param = null)
	{
		if (is_array($param))
		{
			$msg = array_merge($msg, $param);
		}
		echo json_encode($msg);
	}
	
	/**
	 * 获取session
	 */
	public static function getSession($sessionName)
	{
		return isset($_SESSION[Config::$systemName . '_' . $sessionName]) ? $_SESSION[Config::$systemName . '_' . $sessionName] : null;
	}
	
	/**
	 * 设置session
	 */
	public static function setSession($sessionName, $value)
	{
		$_SESSION[Config::$systemName . '_' . $sessionName] = $value;
	}
	
	/**
	 * 清除session
	 */
	public static function clearSession($sessionName)
	{
		unset($_SESSION[Config::$systemName . '_' . $sessionName]);
	}
	
	/**
	 * 上传图片
	 */
	public static function uploadImage()
	{
		$upload = new Upload(2 * 1024 * 1024, 'gif,jpg,png,bmp', array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'), Config::$uploadsDir, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			//$url = $uploadInfo[0]['savepath'] . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . Config::$uploadsDir . $uploadInfo[0]['savename'];
			return json_encode(array('error' => 0, 'url' => $url));
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return json_encode(array('error' => 1, 'message' => $msg));
		}
	}
	
	/**
	 * JQ上传图片
	 */
	public static function uploadJqImage()
	{
		$error = "";
		$msg = "";
		$fileElementName = 'fileToUpload';
		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		}else
		{
				$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
				$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
				//for security reason, we force to remove all uploaded file
				//@unlink($_FILES['fileToUpload']);
				$url = self::getImageName($_FILES['fileToUpload']['name']);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $url);
		}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"url: '" . '/' . $url . "'\n";
		echo "}";
	}
	
	public static function uploadPhoto()
	{
		$upload = new Upload(2 * 1024 * 1024, '', '', Config::$uploadsDir, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			$file = Config::$uploadsDir . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . $file;
			return array('error' => 0, 'url' => $url, 'file' => $file);
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return array('error' => 1, 'message' => $msg);
		}
	}
	
	/**
	 * 生成图片文件名
	 */
	public static function getImageName($extend)
	{
		$arr = explode('.', $extend);
		return Config::$uploadsDir . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	/**
	 * 转义html代码
	 */
	public static function fixHtml($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", '<br>', $str);
		$str = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $str);
		$str = str_replace(' ', '&nbsp;', $str);
		return $str;
	}
	
	/**
	 * 转换标题内容
	 */
	public static function fixTitle($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", ' ', $str);
		return $str;
	}
	
	/**
	 * 将不带www的网址301跳转到带www的网址
	 */
	public static function fixUrl()
	{
		if (!Config::$isLocal)
		{
			$theHost = $_SERVER['HTTP_HOST'];//取得当前域名
			$theUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分
			$theUrl = strtolower($theUrl);//将英文字母转成小写
			//判断是不是首页
			if ("/index.php" == $theUrl)
			{
				$theUrl = "";//如果是首页，赋值为空
			}
			//如果域名不是带www的网址那么进行下面的301跳转
			$mainUrl = substr(Config::$baseUrl, 7);
			if ($theHost !== $mainUrl)
			{
				header('HTTP/1.1 301 Moved Permanently');//发出301头部
				header('Location:http://' . $mainUrl . $theUrl);//跳转到带www的网址
			}
		}
	}
	
	/**
	 * 防重复提交，限制0.2秒内只能提交一次
	 */
	public static function fixSubmit($flag)
	{
		$lastTime = self::getSession('_systemSubmitTime' . '_' . $flag);
		if (empty($lastTime))
		{
			self::setSession('_systemSubmitTime' . '_' . $flag, microtime(true));
		}
		else
		{
			$nowTime = microtime(true);
			$interval = $nowTime - $lastTime;
			if ($interval < 0.2)
			{
				exit;
			}
			else
			{
				self::setSession('_systemSubmitTime' . '_' . $flag, $nowTime);
			}
		}
	}
	
	/**
	 * 缓存模板文件
	 */
	public static function cacheTemplates()
	{
		//原模板文件md5
		$strTemplates = FileCache::read(Config::$viewMd5);
		
		//现模板文件md5
		$list = Utils::getFiles(Config::$viewDir);
		$dirs = array();
		$files = array();
		$md5Files = array();
		foreach ($list as $value)
		{
			if (is_dir($value))
			{
				$dirs[] = $value;
			}
			else if (is_file($value))
			{
				$files[] = $value;
				$md5Files[] = array('name' => $value, 'md5' => md5_file($value));
			}
		}
		$newTemplates = array('dirs' => $dirs, 'files' => $md5Files);
		
		if (empty($strTemplates))
		{
			//原模板文件为空，全新生成模板缓存文件
			Utils::delDir(Config::$htmlDir);
			self::copyTemplatesDirs($dirs);
			self::copyTemplatesFiles($files);
		}
		else
		{
			//比较原模板和现模板，将不同之处更新
			$srcTemplates = json_decode($strTemplates, true);
			$srcDirs = $srcTemplates['dirs'];
			$srcFiles = $srcTemplates['files'];
			
			$outDirs = array();//待删除的目录
			$outFiles = array();//待删除的文件
			$changedDirs = array();//新增加的目录
			$changedFiles = array();//有修改或新增加的文件
			
			//待删除的目录
			foreach ($srcDirs as $srcValue)
			{
				$isSame = false;
				foreach ($dirs as $newValue)
				{
					if ($srcValue == $newValue)
					{
						$isSame = true;
						break;
					}
				}
				if (!$isSame)
				{
					$outDirs[] = $srcValue;
				}
			}
			
			//待删除的文件
			foreach ($srcFiles as $srcValue)
			{
				$isSame = false;
				foreach ($md5Files as $newValue)
				{
					if ($srcValue['name'] == $newValue['name'])
					{
						$isSame = true;
						break;
					}
				}
				if (!$isSame)
				{
					$outFiles[] = $srcValue['name'];
				}
			}
			
			//新增加的目录
			foreach ($dirs as $newValue)
			{
				$isSame = false;
				foreach ($srcDirs as $srcValue)
				{
					if ($newValue == $srcValue)
					{
						$isSame = true;
						break;
					}
				}
				if (!$isSame)
				{
					$changedDirs[] = $newValue;
				}
			}
			
			//有修改或新增加的文件
			foreach ($md5Files as $newValue)
			{
				$isSame = false;
				foreach ($srcFiles as $srcValue)
				{
					if ($newValue['name'] == $srcValue['name'])
					{
						if ($newValue['md5'] == $srcValue['md5'])
						{
							$isSame = true;
						}
						else
						{
							$isSame = false;
						}
						break;
					}
				}
				if (!$isSame)
				{
					$changedFiles[] = $newValue['name'];
				}
			}
			
			//删除多余目录和文件，生成有修改或新增的文件
			foreach ($outFiles as $value)
			{
				$newFile = substr($value, strlen(Config::$viewDir) + 1);
				$newFile = substr($newFile, 0, strlen($newFile) - 5);
				$newFile = Config::$htmlDir . $newFile . '.php';
				@unlink($newFile);
			}
			foreach ($outDirs as $value)
			{
				$newFile = substr($value, strlen(Config::$viewDir) + 1);
				$newFile = Config::$htmlDir . $newFile;
				Utils::delDir($newFile);
			}
			self::copyTemplatesDirs($changedDirs);
			self::copyTemplatesFiles($changedFiles);
		}
		
		//写入现模板文件md5
		FileCache::write(Config::$viewMd5, json_encode($newTemplates));
	}
	
	/**
	 * 生成模板目录
	 */
	private static function copyTemplatesDirs($dirs)
	{
		foreach ($dirs as $value)
		{
			$newDir = Config::$htmlDir . substr($value, strlen(Config::$viewDir) + 1);
			Utils::createDir($newDir);
		}
	}
	
	/**
	 * 编译模板文件
	 */
	private static function copyTemplatesFiles($files)
	{
		foreach ($files as $value)
		{
			if (substr($value, -5) == '.html')
			{
				$newFile = substr($value, strlen(Config::$viewDir) + 1);
				$newFile = substr($newFile, 0, strlen($newFile) - 5);
				$newFile = Config::$htmlDir . $newFile . '.php';
				
				//生成文件
				$str = file_get_contents($value);
				$str = str_replace('{#', '<?php echo ', $str);
				$str = str_replace('#}', '; ?>', $str);
				$str = str_replace('<cmd>', '<?php ', $str);
				$str = str_replace('</cmd>', ' ?>', $str);
				$fileWrite = fopen($newFile, 'w');
				fwrite($fileWrite, Config::$viewCheck . "\r\n");
				fwrite($fileWrite, $str);
				fclose($fileWrite);
			}
		}
	}
	
	/**
	 * 获取数据库session
	 */
	public static function getDbSession($sessionName)
	{
		if (empty(Config::$sid))
		{
			exit('sid empty!');
		}
		Config::$db->connect();
		$sqlSessionName = Security::varSql(Config::$sid . '_' . $sessionName);
		$tbSession = Config::$tbSession;
		Config::$db->query("select content from $tbSession where sid=$sqlSessionName");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['content'];
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * 设置数据库session
	 */
	public static function setDbSession($sessionName, $value)
	{
		if (empty(Config::$sid))
		{
			exit('sid empty!');
		}
		Config::$db->connect();
		$sqlSessionName = Security::varSql(Config::$sid . '_' . $sessionName);
		$sqlValue = Security::varSql($value);
		$tbSession = Config::$tbSession;
		if (self::existDbSession($sessionName))
		{
			Config::$db->query("update $tbSession set content=$sqlValue where sid=$sqlSessionName");
		}
		else
		{
			Config::$db->query("insert into $tbSession (sid, content) values ($sqlSessionName, $sqlValue)");
		}
	}
	
	/**
	 * 检测数据库session是否存在
	 */
	public static function existDbSession($sessionName)
	{
		if (empty(Config::$sid))
		{
			exit('sid empty!');
		}
		Config::$db->connect();
		$sqlSessionName = Security::varSql(Config::$sid . '_' . $sessionName);
		$tbSession = Config::$tbSession;
		Config::$db->query("select id from $tbSession where sid=$sqlSessionName");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 清除数据库session
	 */
	public static function clearDbSession($sessionName)
	{
		if (empty(Config::$sid))
		{
			exit('sid empty!');
		}
		Config::$db->connect();
		$sqlSessionName = Security::varSql(Config::$sid . '_' . $sessionName);
		$tbSession = Config::$tbSession;
		Config::$db->query("delete from $tbSession where sid=$sqlSessionName");
	}
}

/**
 * 用户
 * @author Shines
 */
class User
{
	public function __construct()
	{
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		$rand = rand(1000, 9999);
		System::setDbSession('userVerify', $rand);
		Image::buildImageVerify(48, 22, $rand, 'userVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = System::getDbSession('userVerify');
		System::clearDbSession('userVerify');
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function register($username, $password, $email)
	{
		if (empty($username) || empty($password) || empty($email))
		{
			return array('code' => 1, 'uid' => '');
		}
		if (!Check::email($email))
		{
			return array('code' => 2, 'uid' => '');
		}
		if ($this->existUsername($username))
		{
			return array('code' => 3, 'uid' => '');
		}
		if ($this->existEmail($email))
		{
			return array('code' => 4, 'uid' => '');
		}
		$uid = Utils::genUniqid();
		if ($this->existUid($uid))
		{
			return array('code' => 5, 'uid' => '');
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlEmail = Security::varSql($email);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlIp = Security::varSql(Utils::getClientIp());
		$tbUser = Config::$tbUser;
		Config::$db->query("insert into $tbUser (uid, username, password, email, register_date, register_ip) values ($sqlUid, $sqlUsername, $sqlPassword, $sqlEmail, $sqlDate, $sqlIp)");
		return array('code' => 0, 'uid' => $uid);
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$sqlUsername = Security::varSql($username);
		$tbUser = Config::$tbUser;
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function existEmail($email)
	{
		Config::$db->connect();
		$sqlEmail = Security::varSql($email);
		$tbUser = Config::$tbUser;
		Config::$db->query("select id from $tbUser where email=$sqlEmail");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function existUid($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select id from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function login($username, $password)
	{
		if (empty($username) || empty($password))
		{
			return false;
		}
		if ($this->loginUsername($username, $password))
		{
			return true;
		}
		else
		{
			if ($this->loginEmail($username, $password))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function loginUsername($username, $password)
	{
		if (empty($username) || empty($password))
		{
			return false;
		}
		Config::$db->connect();
		$sqlUsername = Security::varSql($username);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			$srcPassword = $res['password'];
			if ($sPassword == $srcPassword)
			{
				System::setDbSession('userUid', $res['uid']);
				return true;
			}
		}
		return false;
	}
	
	public function loginEmail($email, $password)
	{
		if (empty($email) || empty($password))
		{
			return false;
		}
		Config::$db->connect();
		$sqlEmail = Security::varSql($email);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where email=$sqlEmail");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			$srcPassword = $res['password'];
			if ($sPassword == $srcPassword)
			{
				System::setDbSession('userUid', $res['uid']);
				return true;
			}
		}
		return false;
	}
	
	public function getUid()
	{
		return System::getDbSession('userUid');
	}
	
	public function checkLogin()
	{
		$uid = $this->getUid();
		if (empty($uid))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function getUserInfo()
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select uid, username, email, phone, nick, signature, photo, register_date from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			if (!empty($res['photo']))
			{
				$res['photo'] = Config::$baseUrl . '/' . $res['photo'];
			}
		}
		return $res;
	}
	
	public function setNick($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set nick=$sqlValue where uid=$sqlUid");
	}
	
	public function setPhone($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set phone=$sqlValue where uid=$sqlUid");
	}
	
	public function setSignature($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set signature=$sqlValue where uid=$sqlUid");
	}
	
	public function setPhoto($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set photo=$sqlValue where uid=$sqlUid");
	}
	
	public function setEmail($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set email=$sqlValue where uid=$sqlUid");
	}
	
	public function uploadPhoto()
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$tempPic = $param['file'];
			$newPic = Config::$uploadsDir . time() . rand(100000, 999999) . '.jpg';
			Image::thumb($tempPic, $newPic, "", 500, 500);
			@unlink($tempPic);
			$this->setPhoto($newPic);
			//return array('code' => 0, 'pic' => $url, 'msg' => '');
			return array('code' => 0, 'pic' => Config::$baseUrl . '/' . $newPic, 'msg' => 'ok');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'pic' => '', 'msg' => $msg);
		}
	}
	
	public function logout()
	{
		System::clearDbSession('userUid');
	}
	
	public function changePassword($password)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set password=$sqlPassword where uid=$sqlUid");
		$this->logout();
	}
	
	public function checkPassword($password)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select password from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			if ($sPassword == $res['password'])
			{
				return true;
			}
		}
		return false;
	}
}

/**
 * 视频
 * @author Shines
 */
class Video
{
	public function __construct()
	{
	}
}
new MainController();
?>
