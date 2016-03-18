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
		
		$randval =empty($randval)? ("".rand(1000,9999)):$randval;
		
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
 * 管理后台控制器
 * @author Shines
 */
class AdminController
{
	private $admin = null;
	private $install = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->install = new Install();
		switch ($action)
		{
			case 'verify':
				$this->admin->getVerify();
				break;
			case 'doLogin':
				$this->doLogin();
				break;
			case 'changePassword':
				if ($this->admin->checkLogin())
				{
					$this->showChangePassword();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'doChangePassword':
				if ($this->admin->checkLogin())
				{
					$this->doChangePassword();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'logout':
				if ($this->admin->checkLogin())
				{
					$this->logout();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'install':
				if ($this->admin->checkLogin())
				{
					$this->install();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'db':
				if ($this->admin->checkLogin())
				{
					$this->db();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'dbNews':
				if ($this->admin->checkLogin())
				{
					$this->dbNews();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'upgrade':
				if ($this->admin->checkLogin())
				{
					$this->upgrade();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'backup':
				if ($this->admin->checkLogin())
				{
					$this->backup();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'recover':
				if ($this->admin->checkLogin())
				{
					$this->recover();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'find':
				if ($this->admin->checkLogin())
				{
					$this->find();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'log':
				if ($this->admin->checkLogin())
				{
					$this->log();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'logTime':
				if ($this->admin->checkLogin())
				{
					$this->logTime();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'phpinfo':
				if ($this->admin->checkLogin())
				{
					phpinfo();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'cacheTemplates':
				if ($this->admin->checkLogin())
				{
					$this->cacheTemplates();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'date':
				if ($this->admin->checkLogin())
				{
					echo Utils::mdate('Y-m-d H:i:s');
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
				if ($this->admin->checkLogin())
				{
					$this->showMain();
				}
				else
				{
					$this->showLogin();
				}
		}
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$verify = Security::varPost('verify');
		
		if ($this->admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				System::echoData(Config::$msg['usernamePwEmpty']);
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
	private function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			System::echoData(Config::$msg['srcPwEmpty']);
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
	
	/**
	 * 退出
	 */
	private function logout()
	{
		System::fixSubmit('logout');
		$this->admin->logout();
		$this->showLogin();
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		System::fixSubmit('install');
		$this->install->install();
		echo 'ok';
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
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
	
	/**
	 * 查看数据库数据
	 */
	private function dbNews()
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
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		System::fixSubmit('upgrade');
		$this->install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		System::fixSubmit('backup');
		$this->install->backup();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		System::fixSubmit('recover');
		$this->install->recover();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 数据库中查找关键字
	 */
	private function find()
	{
		$keywords = Security::varGet('keywords');
		$_tableList = $this->install->find($keywords);
		$this->showDb($_tableList);
	}
	
	/**
	 * 查看日志
	 */
	private function log()
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
	
	/**
	 * 查看执行时间日志
	 */
	private function logTime()
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
	
	/**
	 * 更新模板
	 */
	private function cacheTemplates()
	{
		System::fixSubmit('cacheTemplates');
		System::cacheTemplates();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
	
	/**
	 * 显示管理首页
	 */
	private function showMain()
	{
		include(Config::$viewDir . 'admin/main.php');
	}
	
	/**
	 * 显示修改密码页
	 */
	private function showChangePassword()
	{
		include(Config::$viewDir . 'admin/change_password.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	private function showDb($_tableList)
	{
		include(Config::$viewDir . 'admin/db.php');
	}
}

/**
 * 系统安装控制器
 * @author Shines
 */
class InstallController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'dbName':
				echo Config::$dbConfig['dbName'];
				break;
			case 'createDatabase':
				if (file_exists(Config::$installLock))
				{
					echo 'Locked!';
				}
				else
				{
					$this->createDatabase();
				}
				break;
			case 'install':
				if (file_exists(Config::$installLock))
				{
					echo 'Locked!';
				}
				else
				{
					$this->install();
				}
				break;
			default:
		}
	}
	
	/**
	 * 创建数据库
	 */
	private function createDatabase()
	{
		System::fixSubmit('createDatabase');
		$install = new Install();
		$install->createDatabase();
		echo 'Succeed!';
	}
	
	/**
	 * 安装数据库
	 */
	private function install()
	{
		System::fixSubmit('install');
		$install = new Install();
		$install->install();
		$this->createLockFile();
		echo 'Succeed!';
	}
	
	/**
	 * 生成锁定文件
	 */
	private function createLockFile()
	{
		$file = fopen(Config::$installLock, 'a');
		fwrite($file, '<?php //重要，请勿删除！需重新安装数据库或升级数据库时才可删除。?>');
		fclose($file);
	}
}

/**
 * 主入口控制器
 * @author Shines
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
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
				new InstallController();
				break;
			case 'admin':
				new AdminController();
				break;
			default:
				new ZhuanPanController();
		}
		
		//记录执行时间过长的接口
		$action = Security::varGet('a');//操作标识
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
	}
}

/**
 * 转盘控制器
 * @author Shines
 */
class ZhuanPanController
{
	private $zhuanPan = null;
	private $weiXin = null;
	private $admin = null;
	private $install = null;
	
	public function __construct()
	{
		$this->zhuanPan = new ZhuanPan();
		$this->weiXin = new WeiXin();
		$this->admin = new Admin();
		$this->install = new Install();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				break;
			case 'doLogin':
				$this->doLogin();
				break;
			case 'doLucky':
				$this->doLucky();
				break;
			case 'dbJiangChi':
				if ($this->admin->checkLogin())
				{
					$this->dbJiangChi();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'winner':
				if ($this->admin->checkLogin())
				{
					$this->winner();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'dataCount':
				if ($this->admin->checkLogin())
				{
					$this->dataCount();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
				$this->main();
		}
	}
	
	/**
	 * 抽奖主界面
	 */
	private function lucky()
	{
		System::fixSubmit('lucky');
		$openId = trim(Security::varGet('openId'));
		$key = trim(Security::varGet('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		/////// debug
		if (Config::$isLocal)
		{
			//$openId = rand(1, 1000000000);
			//$openId = '001';
			//$key = Security::multiMd5($openId, Config::$key);
			//$srcKey = Security::multiMd5($openId, Config::$key);
		}
		
		if ($key == $srcKey && !empty($openId))
		{
			$profile = $this->zhuanPan->getProfile($openId);
			if (empty($profile))
			{
				$isLogin = false;
				$restLucky = 0;
			}
			else
			{
				$isLogin = true;
				if ($this->zhuanPan->checkLuckyToday($openId))
				{
					$restLucky = 0;
				}
				else
				{
					$restLucky = 1;
				}
			}
			System::setSession('openId', $openId);
			$pics = array(
				'lose1.png',
				'lose2.png',
				'lose3.png',
				'lose4.png',
				'lose5.png',
				'lose6.png',
				'lose7.png',
				'lose8.png',
				'lose9.gif',
				'lose10.png',
				'lose11.gif'
			);
			$loseIndex = rand(0, 10);
			$losePic = $pics[$loseIndex];
			$timeNum = Utils::mdate('H') * 10000 + Utils::mdate('i') * 100 + Utils::mdate('s');
			
			///////// debug
			if (Config::$isLocal)
			{
				//$timeNum = 165901;
			}
			
			if ($timeNum < 165900)
			{
				$isLockTime = true;
			}
			else
			{
				$isLockTime = false;
			}
			//include(Config::$viewDir . 'zhuanpan/main.php');
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '抽奖已结束了哦~';
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function doLogin()
	{
		echo '';
		return;
		
		System::fixSubmit('doLogin');
		$openId = System::getSession('openId');
		if (empty($openId))
		{
			System::echoData(Config::$msg['expired']);
		}
		else
		{
			$jobnum = strtoupper(trim(Security::varPost('jobnum')));
			$username = trim(Security::varPost('username'));
			$dept = $this->zhuanPan->getDept($jobnum, $username);
			if (empty($dept))
			{
				System::echoData(Config::$msg['jobnumError']);
			}
			else
			{
				if ($this->zhuanPan->existUser($openId, $jobnum))
				{
					System::echoData(Config::$msg['binded']);
				}
				else
				{
					$this->zhuanPan->addUser($openId, $jobnum, $username, $dept);
					System::echoData(Config::$msg['ok'], array('restLucky' => 1));
				}
			}
		}
	}
	
	private function doLucky()
	{
		echo '';
		return;
		
		///////////// debug
		if (Config::$isLocal)
		{
			//System::echoData(Config::$msg['ok'], array('prizeId' => 0));
			//return;
		}
		
		System::fixSubmit('doLucky');
		$openId = System::getSession('openId');
		if (empty($openId))
		{
			System::echoData(Config::$msg['expired']);
		}
		else
		{
			$profile = $this->zhuanPan->getProfile($openId);
			if (empty($profile))
			{
				System::echoData(Config::$msg['noLogin']);
			}
			else
			{
				if ($this->zhuanPan->checkLuckyToday($openId))
				{
					System::echoData(Config::$msg['played']);
				}
				else
				{
					$timeNum = Utils::mdate('H') * 10000 + Utils::mdate('i') * 100 + Utils::mdate('s');
					
					///////// debug
					if (Config::$isLocal)
					{
						//$timeNum = 165901;
					}
					
					if ($timeNum < 165900)
					{
						System::echoData(Config::$msg['lockTime']);
					}
					else
					{
						$info = $this->zhuanPan->lucky($openId);
						$prizeId = $info['prizeId'];
						System::echoData(Config::$msg['ok'], array('prizeId' => $prizeId));
					}
				}
			}
		}
	}
	
	private function main()
	{
		$this->weiXin->valid();
		if ($this->weiXin->checkSignature())
		{
			$this->response();
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	/**
	 * 微信消息处理
	 */
	private function response()
	{
		//get post data, May be due to the different environments
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		
		//extract post data
		if (!empty($postStr))
		{
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$toUserName = $postObj->ToUserName;
			$fromUserName = $postObj->FromUserName;
			$createTime = $postObj->CreateTime;
			$msgType = $postObj->MsgType;
			$content = trim($postObj->Content);
			$msgid = $postObj->MsgId;
			$event = $postObj->Event;
			
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
			$time = time();
			
			switch ($msgType)
			{
				case 'text':
					switch ($content)
					{
						case '我要抽奖':
							$key = Security::multiMd5($fromUserName, Config::$key);
							//$contentStr = '猛戳这里进入抽奖：' . "\n" . '<a href="http://transsion.qumuwu.com/?a=lucky&openId=' . $fromUserName . '&key=' . $key . '">传音年会大福利</a>';
							$contentStr = '抽奖已结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						default:
							echo '';
					}
					break;
				case 'event':
					switch ($event)
					{
						case 'subscribe':
							//$contentStr = "欢迎来到传音\n查看历史纪录，点击右上角人像";
							$contentStr = '终于等到你！还好你没放弃。来这儿就对了！这儿，美女如云。这儿，呈现一手花絮。这儿，更多礼物送！送！送！';
							//$contentStr = '这儿，美女如云。这儿，更多一手花絮，深情表白，匿名点歌。天青色等烟雨，长腿欧巴就在这等着你！！';
							//$contentStr = '非常感谢你的关注！小编将为您爆料2015传音年会最劲爆动态，最逗B的花絮敬请期待。';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case 'unsubscribe':
							echo '';
							break;
						default:
							echo '';
					}
					break;
				default:
					echo '';
			}
		}
		else
		{
			echo '';
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	private function showDb($_tableList)
	{
		include(Config::$viewDir . 'admin/db.php');
	}
	
	private function dbJiangChi()
	{
		$allTables = array(Config::$tbZpJiangChi);
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
	
	private function winner()
	{
		$res = $this->zhuanPan->getAllWinner();
		$winner = array();
		foreach ($res as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($winner[$date]))
			{
				$winner[$date] = array('date' => $date, 'list' => array());
			}
			$winner[$date]['list'][] = array(
				'dept' => $value['dept'],
				'username' => $value['username'],
				'jobnum' => $value['jobnum'],
				'address' => $value['address'],
				'prize' => Config::$prizeName[$value['prize_id'] - 1]
			);
		}
		include(Config::$viewDir . 'zhuanpan/winner.php');
	}
	
	private function dataCount()
	{
		$users = $this->zhuanPan->getAllUsers();
		$daily = $this->zhuanPan->getAllDaily();
		$winner = $this->zhuanPan->getZhongJiang();
		$dayList = array();
		$totalUser = 0;
		$totalPlay = 0;
		$totalWinner = 0;
		
		foreach ($users as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['register_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['userNum']++;
			$totalUser++;
		}
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['playNum']++;
			$totalPlay++;
		}
		
		foreach ($winner as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['winner']++;
			$totalWinner++;
		}
		include(Config::$viewDir . 'zhuanpan/count.php');
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
}

/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 2;//配置方案。1：local，2：shenzhen
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = true;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'transsion2016';//系统名称
	public static $key = '12.transsion2016<ffd.<>f';//密钥
	public static $backupDir = 'data/backup/';//数据库备份目录
	public static $recoverDir = 'data/recover/';//数据库恢复目录
	public static $logDir = 'data/log/';//日志目录
	public static $uploadsDir = 'data/uploads/';//上传目录
	public static $cacheDir = 'data/cache/';//缓存主目录
	public static $newsCacheDir = 'data/cache/news/';//新闻缓存目录
	public static $templatesDir = 'templates';//模板目录
	public static $viewDir = 'data/cache/templates/';//视图目录，缓存模板
	public static $templatesMd5 = 'data/cache/templates_md5.php';//模板md5文件，用来检测模板是否有修改
	public static $installLock = 'data/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if (!defined(\'VIEW\')) exit; ?>';//VIEW入口检测代码
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = 'http://img.qumuwu.com/transsion';//资源文件地址
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	public static $countCode = '';//统计代码
	
	public static $deviceType = '';//设备类型，pc，mobile
	public static $maxPrize = 13;//最大奖品数
	public static $prizeName = array(
		'TECNO C8',
		'TECNO Phantom 5',
		'TECNO pad 7C',
		'TECNO pad 8H',
		'itel it1505',
		'Infinix X511',
		'Infinix X405',
		'Syinix原汁机',
		'Oraimo充电宝',
		'iflux应急灯',
		'现金红包 8元',
		'现金红包 18元',
		'现金红包 28元'
	);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'transsion2016_admin';//管理员表
	public static $tbUser = 'transsion2016_user';//会员表
	public static $tbNews = 'transsion2016_news';//新闻表
	
	public static $tbZpJiangChi = 'transsion2016_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'transsion2016_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'transsion2016_zp_daily';//转盘每日抽奖表
	
	public static $tbHbJiangChi = 'transsion2016_hb_jiang_chi';//红包奖池表
	public static $tbHbZhongJiang = 'transsion2016_hb_zhong_jiang';//红包中奖表
	public static $tbHbDaily = 'transsion2016_hb_daily';//红包每日记录表
	
	public static $tbJobnum = 'transsion2016_jobnum';//工号表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'transsion2016',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//transsion数据库配置信息
	private static $dbTranssion = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => 'd17b39b0c9',//密码
		'dbName' => 'transsion2016',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//操作提示
	public static $msg = array
	(
		//通用
		'ok' => array('code' => 0, 'msg' => 'ok'),
		'sysError' => array('code' => 1, 'msg' => '系统错误！'),
		'appError' => array('code' => 2, 'msg' => '业务处理错误！'),
		
		//用户
		'noLogin' => array('code' => 101001, 'msg' => '未登录'),
		'usernamePwEmpty' => array('code' => 101002, 'msg' => '用户名和密码不能为空！'),
		'usernamePwError' => array('code' => 101003, 'msg' => '用户名或密码错误！'),
		'verifyError' => array('code' => 101004, 'msg' => '验证码错误！'),
		'srcPwEmpty' => array('code' => 101005, 'msg' => '原密码和新密码不能为空！'),
		'srcPwErorr' => array('code' => 101006, 'msg' => '原密码错误！'),
		'userExist' => array('code' => 101007, 'msg' => '该用户名已经存在！'),
		'emailFormatError' => array('code' => 101008, 'msg' => 'Email格式不正确！'),
		
		//转盘抽奖
		'jobnumError' => array('code' => 103001, 'msg' => '工号或姓名输入错误！'),
		'binded' => array('code' => 103002, 'msg' => '该工号已登录！'),
		'expired' => array('code' => 103003, 'msg' => '会话已过期，请重新登录！'),
		'played' => array('code' => 103004, 'msg' => '今天的抽奖次数已用完，请明天再来！'),
		'lockTime' => array('code' => 103005, 'msg' => '抽奖每天下午5点开始哦！')
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		@session_start();
		if (self::$isLocal)
		{
			@error_reporting(E_ALL);
			self::$configType = 1;
			self::$countCode = '';
		}
		else
		{
			@error_reporting(0);
		}
		
		switch (self::$configType)
		{
			case 1:
				//localhost
				@date_default_timezone_set('Etc/GMT-8');//北京时间
				self::$baseUrl = 'http://localhost:8012';
				self::$dbConfig = self::$dbLocal;
				self::$resUrl = '.';
				break;
			case 2:
				//transsion
				@date_default_timezone_set('Etc/GMT-8');//北京时间
				self::$baseUrl = 'http://transsion.qumuwu.com';
				self::$dbConfig = self::$dbTranssion;
				self::$resUrl = 'http://img.qumuwu.com/transsion';
				break;
			default:
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$logDir . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$logDir . 'time_' . Utils::mdate('Y-m-d') . '.php';
		Debug::$maxTime = 0.01;
		self::$db = new Database(self::$dbConfig);
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
		define('TOKEN', 'fsie473jfHJhduJKee51');
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
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbNews = Config::$tbNews;
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		$tbHbJiangChi = Config::$tbHbJiangChi;
		$tbHbZhongJiang = Config::$tbHbZhongJiang;
		$tbHbDaily = Config::$tbHbDaily;
		$tbJobnum = Config::$tbJobnum;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			jobnum varchar(50) not null,
			dept varchar(50) not null,
			password varchar(200) not null,
			phone varchar(50) not null,
			open_id varchar(50) not null,
			register_date datetime not null,
			index (open_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpJiangChi");
		Config::$db->query("create table $tbZpJiangChi (
			id int not null auto_increment primary key,
			prize_date date not null,
			rate int not null,
			prize1 int not null,
			prize2 int not null,
			prize3 int not null,
			prize4 int not null,
			prize5 int not null,
			prize6 int not null,
			prize7 int not null,
			prize8 int not null,
			prize9 int not null,
			prize10 int not null,
			prize11 int not null,
			prize12 int not null,
			prize13 int not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpZhongJiang");
		Config::$db->query("create table $tbZpZhongJiang (
			id int not null auto_increment primary key,
			open_id varchar(50) not null,
			prize_id int not null,
			lucky_code varchar(50) not null,
			lucky_date datetime not null,
			index (open_id),
			index (lucky_code)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpDaily");
		Config::$db->query("create table $tbZpDaily (
			id int not null auto_increment primary key,
			open_id varchar(50) not null,
			lucky_date datetime not null,
			index (open_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbJobnum");
		Config::$db->query("create table $tbJobnum (
			id int not null auto_increment primary key,
			jobnum varchar(50) not null,
			username varchar(50) not null,
			dept varchar(50) not null,
			index (jobnum)
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
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
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
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbNews = Config::$tbNews;
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		$tbHbJiangChi = Config::$tbHbJiangChi;
		$tbHbZhongJiang = Config::$tbHbZhongJiang;
		$tbHbDaily = Config::$tbHbDaily;
		$tbJobnum = Config::$tbJobnum;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		$zhuanPan = new ZhuanPan();
		/*
		$zhuanPan->initPrize();
		$zhuanPan->initJobnum();
		$zhuanPan->initJobnum2();
		$zhuanPan->initJobnum3();
		$zhuanPan->initJobnum4();
		$zhuanPan->initJobnum5();
		$zhuanPan->initJobnum6();
		$zhuanPan->initJobnum7();
		$zhuanPan->initJobnum8();
		*/
		
		if (Config::$isLocal)
		{
			//Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-20', 80, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10)");
			//$zhuanPan->initJobnum6();
		}
		
		$zhuanPan->addAddress();
		$zhuanPan->initAddress();
		$zhuanPan->initAddress2();
		$zhuanPan->initAddress3();
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
		$strTemplates = FileCache::read(Config::$templatesMd5);
		
		//现模板文件md5
		$list = Utils::getFiles(Config::$templatesDir);
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
			Utils::delDir(Config::$viewDir);
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
				$newFile = substr($value, strlen(Config::$templatesDir) + 1);
				$newFile = substr($newFile, 0, strlen($newFile) - 5);
				$newFile = Config::$viewDir . $newFile . '.php';
				@unlink($newFile);
			}
			foreach ($outDirs as $value)
			{
				$newFile = substr($value, strlen(Config::$templatesDir) + 1);
				$newFile = Config::$viewDir . $newFile;
				Utils::delDir($newFile);
			}
			self::copyTemplatesDirs($changedDirs);
			self::copyTemplatesFiles($changedFiles);
		}
		
		//写入现模板文件md5
		FileCache::write(Config::$templatesMd5, json_encode($newTemplates));
	}
	
	/**
	 * 生成模板目录
	 */
	private static function copyTemplatesDirs($dirs)
	{
		foreach ($dirs as $value)
		{
			$newDir = Config::$viewDir . substr($value, strlen(Config::$templatesDir) + 1);
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
				$newFile = substr($value, strlen(Config::$templatesDir) + 1);
				$newFile = substr($newFile, 0, strlen($newFile) - 5);
				$newFile = Config::$viewDir . $newFile . '.php';
				
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
}

/**
 * 微信
 * @author Shines
 */
class WeiXin
{
	public function __construct()
	{
	}
	
	/**
	 * 验证签名
	 */
	public function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = Security::varGet('signature');
        $timestamp = Security::varGet('timestamp');
        $nonce = Security::varGet('nonce');
        
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 微信消息处理
	 */
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
        }else {
        	echo "";
        	exit;
        }
    }
	
	/**
	 * 验证网址
	 */
	public function valid()
    {
		$echoStr = Security::varGet('echostr');
		//valid signature , option
		if ($this->checkSignature())
		{
			echo $echoStr;
		}
	}
}

/**
 * 转盘
 * @author Shines
 */
class ZhuanPan
{
	public function __construct()
	{
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openId)
	{
		//记录今天抽过奖
		$this->setLuckyToday($openId);
		
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbZpJiangChi where prize_date=$sqlDate");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//抽中过手机的，不再中手机，只中红包
				if ($this->checkBigPrize($openId))
				{
					//组合奖品id
					$prizeArr = array_merge(
						$this->joinPrize(11, $res['prize11']),
						$this->joinPrize(12, $res['prize12']),
						$this->joinPrize(13, $res['prize13'])
					);
				}
				else
				{
					//组合奖品id
					$prizeArr = array_merge(
						$this->joinPrize(1, $res['prize1']),
						$this->joinPrize(2, $res['prize2']),
						$this->joinPrize(3, $res['prize3']),
						$this->joinPrize(4, $res['prize4']),
						$this->joinPrize(5, $res['prize5']),
						$this->joinPrize(6, $res['prize6']),
						$this->joinPrize(7, $res['prize7']),
						$this->joinPrize(8, $res['prize8']),
						$this->joinPrize(9, $res['prize9']),
						$this->joinPrize(10, $res['prize10']),
						$this->joinPrize(11, $res['prize11']),
						$this->joinPrize(12, $res['prize12']),
						$this->joinPrize(13, $res['prize13'])
					);
				}
				
				//判断当天奖池中是否还有奖品
				$prizeArrCount = count($prizeArr);
				if ($prizeArrCount > 0)
				{
					$prizeRnd = rand(0, $prizeArrCount - 1);
					$prizeId = $prizeArr[$prizeRnd];
					$luckyCode = $this->genCode();
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduceJiangChi($date, $prizeId);
					$this->saveLucky($openId, $prizeId, $luckyCode);
					return array('prizeId' => $prizeId, 'prizeName' => Config::$prizeName[$prizeId - 1], 'luckyCode' => $luckyCode);
				}
			}
		}
		return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function checkLuckyToday($openId)
	{
		///////// debug
		if (Config::$isLocal)
		{
			//return false;
		}
		
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpDaily where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
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
	
	public function checkBigPrize($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbZpZhongJiang where open_id=$sqlOpenId");
		$res = Config::$db->getAllRows();
		foreach ($res as $key => $value)
		{
			if ($value['prize_id'] <= 10)
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 获取今天所中奖项
	 */
	public function getWinToday($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpZhongJiang where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prize_id'], 'prizeName' => Config::$prizeName[$res['prize_id'] - 1], 'luckyCode' => $res['lucky_code']);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function setLuckyToday($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbZpDaily (open_id, lucky_date) values ($sqlOpenId, $sqlDate)");
	}
	
	/**
	 * 组合奖品
	 */
	private function joinPrize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		return $res;
	}
	
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduceJiangChi($date, $prizeId)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpJiangChi = Config::$tbZpJiangChi;
			$sqlDate = Security::varSql($date);
			$fieldName = 'prize' . $prizeId;
			Config::$db->query("update $tbZpJiangChi set $fieldName=$fieldName-1 where prize_date=$sqlDate");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function saveLucky($openId, $prizeId, $luckyCode)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpZhongJiang = Config::$tbZpZhongJiang;
			$sqlOpenId = Security::varSql($openId);
			$sqlLuckyCode = Security::varSql($luckyCode);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			Config::$db->query("insert into $tbZpZhongJiang (open_id, prize_id, lucky_code, lucky_date) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
		}
	}
	
	/**
	 * 获取每日抽奖数据
	 */
	public function getDaily()
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		Config::$db->query("select * from $tbZpDaily order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 获取中奖数据
	 */
	public function getZhongJiang()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select * from $tbZpZhongJiang order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 初始化转盘奖池
	 */
	public function initPrize()
	{
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		Config::$db->query("delete from $tbZpJiangChi");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-18', 25, 2, 1, 2, 1, 3, 1, 2, 1, 4, 2, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-19', 25, 2, 1, 2, 1, 3, 1, 1, 2, 4, 2, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-20', 25, 2, 1, 1, 2, 2, 2, 1, 2, 4, 1, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-21', 25, 1, 2, 1, 2, 3, 2, 1, 2, 4, 1, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-22', 25, 1, 2, 1, 2, 3, 2, 1, 1, 5, 1, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-23', 50, 1, 2, 1, 1, 3, 1, 2, 1, 5, 1, 81, 30, 21)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6, prize7, prize8, prize9, prize10, prize11, prize12, prize13) values ('2016-1-24', 50, 1, 1, 2, 1, 3, 1, 2, 1, 4, 2, 81, 30, 21)");
		
		Config::$db->query("select * from $tbZpJiangChi");
		$res = Config::$db->getAllRows();
		$count = 0;
		$allCount = 0;
		$colCounts = array();
		foreach ($res as $key => $value)
		{
			$count = 0;
			for ($i = 1; $i <= 13; $i++)
			{
				if (empty($colCounts['prize' . $i]))
				{
					$colCounts['prize' . $i] = 0;
				}
				$colCounts['prize' . $i] += $value['prize' . $i];
				$count += $value['prize' . $i];
			}
			$allCount += $count;
			echo $value['prize_date'] . ': ' . $count . '<br />';
		}
		Utils::dump($colCounts);
		echo '$allCount: ' . $allCount . '<br />';
	}
	
	public function initJobnum()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("delete from $tbJobnum");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '竺兆江', '00001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '张祺', '00002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '焦永刚', '00310')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '严孟', '00006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '秦霖', '00007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '杨宏', '00269')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '胡盛龙', '00005')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '叶伟强', '00004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '邓翔', '00022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '肖明', '60001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', 'Chowdhury Mohammad Ariful Hasan', '00079')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '徐幼芳', '00916')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '马殿元', '01024')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '龚晓明', '01625')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '李林珊', '01723')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '王欣颖', '01724')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '丘昀宗', '01460')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '黄琼舒', '01651')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '李文静', '00945')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '周也', '00980')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '刘光华', '01073')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '刘治江', '00654')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '黄善婷', '01179')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '郑善华', '00994')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '伍玲华', '00386')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '刘巧丽', '01774')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '胡海瑞', '00789')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '范小娟', '00778')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '万佳欣', '01763')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '张家俊', '01848')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '肖永辉', '00634')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '夏春雷', '00064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王齐', '00082')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '高亮', '00700')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '李扬帆', '07712')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '付美云', '01063')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张敏', '01064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王静', '00573')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '吴蔚', '01650')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '徐国琴', '01891')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张金花', '00286')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王先波', '00296')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '郑莎', '01379')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '陈伏秀', '00571')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '周瑾', '00951')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '黄世平', '00905')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张婧', '00932')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王宜', '01436')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '胡珊珊', '01679')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '卢文科', '00173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '谭洪天', '01656')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '徐航', '00884')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王婉莹', '01630')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '胡伟平', '00065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '郭耕耘', '00357')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '郭京京', '00598')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '徐中一', '01002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '文芝', '01416')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '马芬', '01375')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '曾䶮', '01725')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '罗刚', '01157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '喻培福', '12051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '卫桂芬', '00772')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '胡志勇', '00611')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '唐晓梅', '00691')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张宇洁', '01584')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张孟龙', '01839')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '黄丰南', '03778')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张凤云', '01670')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '詹芳', '01859')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '官爱民', '00781')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张兰华', '60008')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '沈海河', '60415')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '郑显彪', '00208')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '黄伟铭', '01242')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '郑文全', '01475')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '纪长志', '01719')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '谭科', '00926')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '李俭彬', '00373')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '田建文', '01639')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '刘井泉', '00018')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '宋慈', '00582')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '胡继伟', '00952')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '李平', '00153')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '李海宾', '01691')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '梁燕妮', '01757')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张静', '01479')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张甄楠', '00290')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '曹亚敏', '01654')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '董丹萍', '00195')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '代元元', '00566')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '黄恬', '01680')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '韩靖羽', '00053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王旭芬', '00480')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '王兵兵', '01437')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '叶乔', '01279')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '周鑫', '00594')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '符良宏', '00621')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '杨双', '09299')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '高长瑜', '01786')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '黄向东', '01876')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张友忠', '01894')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '陈元海', '00925')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '于光远', '01789')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '鲍静', '01424')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '陈玲', '01248')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '梅洁', '01486')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '江雅琴', '00835')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '范娅', '01484')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '莫艳莹', '01107')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '胡霆灵', '01828')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '夏鹏', '01172')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '黄海荣', '01556')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '蔡瑞芬', '01824')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '仲山', '01858')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '苏丽红', '01879')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '卢甜汇', '01506')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '张磊', '01742')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '周静', '00818')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '黄婉婷', '01185')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '唐永甜', '01198')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '周丹', '01485')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '段培俊', '60650')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '所迪', '60271')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '邓慧', '00858')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '沈倍佩', '60431')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '王跞一', '68059')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '田慧茹', '60761')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '石杉钐', '60751')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '杨婉岑', '60452')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '魏登梅', '68058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '欧伟哲', '00822')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '王晓明', '00823')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '莫细明', '01209')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '魏海龙', '00979')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '程刚', '01009')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '马秋平', '00871')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '孙英超', '00289')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '黄强国', '00939')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '徐淑珍', '00615')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '康理波', '01610')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '朱宁平', '01617')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '王欣', '01189')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '王军蓉', '01070')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '黄石娟', '00241')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '宁丽琴', '01509')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张京', '01501')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '周炎福', '00600')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '樊朋博', '01337')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '冯振洲', '00869')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '何三山', '01202')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '曾勇', '01285')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '唐欢欢', '01361')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '肖国庆', '01020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '罗闪', '01183')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '何德阳', '01356')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张宝立', '01410')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '陈佳涛', '01540')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张鸿', '01543')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '王成军', '00087')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '李创生', '00624')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '王柯', '00836')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '吕帅', '60178')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '柯灜', '60641')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '蒋松萌', '60409')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张阳', '60714')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '陆岸宏', '01713')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张大敏', '60743')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '何秀水', '00540')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '崔天福', '01066')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '石文彬', '00407')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '叶婷', '00881')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '张文斌', '00530')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '黄思乐', '01050')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '王小兰', '01411')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '张小鹏', '01471')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '张建', '00068')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '兰云贵', '00176')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '陈丽琼', '01433')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '胡开辉', '00995')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '朱超', '01735')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '杨美玲', '01838')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '陈琼', '00741')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '陈方华', '00792')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '王满', '01181')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '曹美女', '01086')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '汪虎', '00794')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '金燕', '00262')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '徐红月', '01434')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '余雅丽', '01498')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '王玉倩', '01500')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '龚金银', '00069')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '招燕玲', '01089')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '崔宇光', '01481')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '韦燕羽', '01090')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '曾凡', '01360')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '朱建刚', '60250')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '李小霞', '00737')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '周惠娟', '01038')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '刘娜', '60429')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '王慧', '01802')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '孟娟', '00774')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '陈方', '00120')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '袁杰', '01150')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '徐仁誉', '00732')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '史静', '00254')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '刘会', '00577')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '邹春芳', '01156')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '彭祝云', '01354')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '袁旦', '01374')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '田春云', '01438')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '许宏月', '01766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '刘英', '01791')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '乐苏华', '00163')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '南彬', '00963')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '张桂秀', '00848')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '洪丹玲', '00873')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '张艳', '00891')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '佐佳', '01439')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '陈孝旺', '01595')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '孙莉', '01499')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '凌桂甜', '01480')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '高威', '00867')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '苏磊', '00031')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '蒋慧芳', '01071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '谢乐斌', '00313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '骆伊婷', '00477')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张漫', '00976')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '王甲亮', '60195')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周为英', '60238')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '蒋佳星', '00760')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '何小刚', '60304')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张腾达', '01830')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '朱洪君', '01192')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张慎桥', '01673')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '林剑', '60612')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张彦博', '60556')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周思瑞', '60767')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '董闻卿', '60768')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '王国材', '01241')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '洪亚婷', '60451')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '朱秋琳', '60672')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '岳翠忠', '00115')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '陈海飞', '01098')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '莫艳勇', '00587')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '潘世伟', '01270')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘贵文', '01622')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘雄', '01823')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李华新', '00687')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '谢先锐', '00993')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '曾立城', '01120')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '江民烽', '00938')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '梅勇彬', '01237')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李新涛', '01271')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '卢琪文', '01581')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '柯贤径', '01641')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张振', '01800')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周军庭', '01855')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黄思伟', '01873')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '崔志鹏', '01085')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘正', '01082')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周茂盛', '00855')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李向阳', '01329')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周绍清', '01388')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘凯', '01199')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '曹珍珍', '01240')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周佳', '01174')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘卫东', '01343')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '吕小虎', '01344')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '宁才清', '01338')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '夏中年', '01346')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黄雨先', '01393')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '王翠霞', '01456')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '王又良', '01657')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邓杨平', '01727')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '唐浩', '01768')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '牟庆杰', '01348')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '童少波', '01441')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘波', '00728')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '陈润东', '01054')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '朱林海', '01363')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '唐挺', '01587')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黄明松', '00592')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '冯程', '01186')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '曹振华', '00790')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘颖', '00731')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '蓝永霖', '01834')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘辉', '00934')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张喜鹏', '00846')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '洪仲坤', '01218')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '吴赛', '00517')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '杨波', '01332')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李峰', '01609')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '郝东', '01756')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '曾照江', '01811')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '喻旭海', '01815')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李巧飞', '01136')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邓小军', '01392')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '吴海霞', '00274')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '徐婕', '01316')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '孙亚萍', '01278')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '伍小艳', '01728')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黄雅欣', '01770')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '程仲溪', '01492')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '陈姗', '01600')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '苏丹', '01857')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '肖美林', '01618')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邓光深', '01367')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '袁丽清', '00534')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '陶国英', '01792')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '甘世宏', '01767')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黎勇', '01660')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李甜美', '01709')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '柯尊焱', '00468')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '蔡永', '00764')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '匡智斌', '01623')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周志晨', '01214')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邹凯', '01215')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李政华', '01522')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '骆研名', '01491')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '曾峰晴', '00868')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '何志', '01166')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '余中英', '01494')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '潘文义', '01816')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '贾友', '01875')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李俊锋', '01886')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张金海', '01817')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '柯阳', '00749')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘伟奇', '00924')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张力心', '01887')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '李泽喜', '01140')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '吴金妹', '01178')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘福宏', '01207')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '赵维', '01380')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '郭品艳', '01400')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邓林华', '01493')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '黄绍文', '01627')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '古裕彬', '00382')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '丁雷', '01495')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '郭威', '01496')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '银登华', '01497')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘明', '00829')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '彭广川', '01468')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '沈丽君', '60449')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '苏弦贤', '01097')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '孙茂英', '01676')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '毛海霞', '60299')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '邓焜', '01601')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘洪璋', '01730')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张博', '01736')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '刘志岱', '01810')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '周宗政', '00080')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张永乐', '60003')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张蕊', '60163')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '蒲思安', '01217')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '冯喜泉', '01737')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '娄华云', '04909')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '左国强', '00893')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '康燕', '01076')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '夏霄月', '60145')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张金海', '01445')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '王端琴', '01420')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '朱全勇', '01527')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '贺利霞', '00721')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '冯璐', '01677')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '许旭', '01391')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '苏宝合', '01390')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '陈勇', '01685')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '代芳', '00023')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '严翠娥', '00244')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '卢丽萍', '01127')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李双红', '01220')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '朱奇玲', '01801')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张绪波', '01821')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李景全', '00709')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '徐峰', '01109')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '杨琳莉', '00992')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李青明', '04716')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '姚海珍', '00075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '邹振良', '01173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '乔世英', '00238')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '徐辉平', '01421')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '肖晴', '01783')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '邱晓芳', '01772')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '王利', '00889')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '许飞祥', '01504')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张敏', '01505')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '胡诗汇', '01521')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '朱雄', '05612')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '唐慰', '00982')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '魏瑞', '00902')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '陈桂君', '01165')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '胡珍', '01203')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '蒲明海', '01212')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李旭啸', '00898')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '王彬', '01280')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '唐仁亮', '01446')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '宋朝魄', '01442')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '蒋庆华', '01152')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '王永奇', '01674')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '董登峰', '01645')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李超', '01646')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '侯刚', '01845')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '陈献红', '01760')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张琳琳', '01769')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '苟小庆', '01490')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '李玉洁', '01503')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '王安琪', '01539')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '简繁', '01267')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '陈宇', '01230')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '唐华', '01115')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '舒辉', '01030')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '易晓菲', '01235')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '刘仔勤', '01239')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '邓东', '01822')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '丁仕科', '01682')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '汪盛希', '01234')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '黄婉如', '01154')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '刘晨昱', '01219')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '谭洁', '00843')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '刘仰宏', '00066')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '管银银', '00616')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '叶媛媛', '00866')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '龙泳蓉', '01550')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '肖红', '00491')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '姜楠', '00914')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '毛艳', '01118')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '徐阳', '01541')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '唐丹丹', '00509')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '朱巧林', '01102')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '魏君巍', '01448')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '肖春霞', '01201')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '张群', '00381')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '周蕾', '00942')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '杨倩', '01056')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '朱贺', '01526')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '刘建生', '00989')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '李芙蓉', '01284')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '黎镇', '00461')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '潘小英', '00948')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '沈燕', '01022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '邱秀梅', '01711')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '吴竹', '01334')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('商务部', '高青', '01686')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '梁朗', '01665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '索超', '00610')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '陈文臻', '00512')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '陈周涛', '00632')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '欧阳葵', '00013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '闵晓兰', '00252')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '张丽丽', '00622')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '周红芳', '00954')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '张维', '01077')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '文平', '01759')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '何艳', '00597')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '张仁员', '00665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '滕菲', '01633')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '张慕媛', '01262')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '王振宇', '00203')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '田孟芬', '00201')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '陈燕芬', '00207')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '陈慧珠', '00713')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '朱子恒', '01831')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '彭逸民', '01832')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '林鹰君', '01833')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '蔡孙荣', '00324')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '黄伟俊', '01852')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '颜晓熙', '01253')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '周金宝', '00489')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('物流部', '张德星', '00745')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '刘俊杰', '00088')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '曾剑锋', '01732')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '陈密', '00975')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '陶威', '00399')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '胡欣利', '01750')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '赵航', '00453')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '刘振亚', '01793')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', 'Arnaud Lefebvre', '00744')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '赵震', '00605')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '罗典', '01872')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '王越', '01582')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '赵冰峰', '01583')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '旷建辉', '01699')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '阳成芬', '01687')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '贺美园', '01752')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '齐战', '00609')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '邹剑锋', '00851')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '黄露莎', '00776')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '崔锡涛', '01613')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '王志杰', '00210')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '李福根', '01753')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '王银行', '01867')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '黄晓雪', '01138')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', 'El Hassani Mohamed', '01516')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '张瑞', '01862')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', 'Dinneweth Arnaud', '01696')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '刘红玲', '00099')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '薛丽', '01075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '胡黎', '00673')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '赵倩', '01751')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '尹明', '01733')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '唐丹', '01476')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '杨涟忆', '01483')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '肖思薇', '01515')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '邹莎', '01554')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '李贝贝', '01557')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '宋英男', '00111')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '徐跃华', '01184')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '徐华盛', '01037')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '尹雪', '01381')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '柳思琦', '01196')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '苏帅', '01573')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '李馥', '01642')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '李超', '00961')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '余勇', '00451')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '何建波', '00038')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '蔡宇超', '01146')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '陈双双', '00307')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '鲁岚', '00513')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '夏钊', '00746')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '罗龙', '00747')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '刘洋', '00504')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '冯运通', '00853')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '罗继光', '01323')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '瞿全坤', '01325')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '冯智聪', '01369')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '贺建红', '01560')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '李瑞涵', '01321')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '申瑞刚', '00129')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '刘国利', '01246')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '杨勇', '01139')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '魏望', '01798')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '施成星', '01808')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李祥', '01621')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '刘年红', '01797')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '袁野', '61339')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '任文', '01121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李传堃', '00809')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '王藉民', '01409')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '沈祥荣', '01426')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '曲兴城', '01567')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '薛榆蒙', '01333')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '鲁林海', '01148')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '黎哲煌', '01340')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '胡志远', '01799')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '赵琳', '80083')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '廖阳杰', '80135')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李旻婧', '80089')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '潘蒙', '80128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李璟', '01820')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '王腾', '01669')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '项赟', '00715')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李梅', '01331')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '齐子铭', '00626')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '向前梁', '01710')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '肖俊婷', '01142')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '孟雪莹', '01706')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', 'Muhammad Umair Ul Ali', '01743')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '彭星', '00740')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '陈燕连', '01489')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '陈潜', '01324')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '陈焰辉', '01362')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '刘攀峰', '01596')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '邢朗然', '01688')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '李凯', '01451')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '孟志赟', '00397')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '魏祥', '01785')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '卢惠端', '00305')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '易恺', '00652')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '蒋克蓉', '01450')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', 'Arman Salim', '01649')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '马永勇', '01809')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '李姣', '01065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '彭珺', '01061')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '惠晓明', '01568')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '黄欢欢', '01729')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '周威', '01814')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '卢佳', '01697')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '陆娟芳', '01488')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '王迪', '01487')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('数字营销部', '张玲玲', '01546')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '代书燕', '00154')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '王礼安', '00987')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '洪吉', '01389')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '王功泽', '00549')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '邱能凯', '00026')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '万正位', '01195')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '张梦琳', '01762')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '孙道阔', '01428')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '洪东阳', '00986')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', 'Mohamed Ismail Omar', '01263')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '陈爽', '01771')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '赵欣', '01689')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '吴俊', '01844')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '崔文君', '00151')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '俞卫国', '00086')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '何紫辉', '00043')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '马明', '01675')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '哈乐', '01692')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部 ', '何玉民', '01788')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '阮富臻', '01561')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '吕延雷', '01652')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '冯波', '01370')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘龙飞', '01790')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '郭磊', '00042')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '陈见平', '01784')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '潘旭景', '01464')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '耿丽', '01068')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘博', '01684')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曾繁博', '01551')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '倪凯', '00499')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '金言', '01247')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '肖培彪', '00664')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李庭', '01432')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '叶镇和', '00756')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王芳', '00714')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '吴连军', '00148')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李启军', '01326')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曾敬禹', '01384')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '舒怡', '01463')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '梁丹', '01474')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王朝慈', '01592')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张亚琼', '01548')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '勉涛荣', '01846')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '蒋玲珠', '01565')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', 'Hanane Karroumi', '01616')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '贺晓秋', '00387')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '梁铂琚', '80015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '高菲云', '80086')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李国优', '80150')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '罗明星', '80196')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '程玉强', '80101')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '皮超', '80190')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '郭培培', '01707')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '黄刚', '01589')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李斯燕', '01607')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '罗威', '01661')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张皓燃', '01547')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '杨双赫', '00723')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘若天', '00850')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李可一', '01662')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '于洋', '01716')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '陈海鹰', '01268')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李山飞', '00734')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘小谦', '01386')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张欣', '00543')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '雷程', '00658')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘杰', '00508')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曾鹏', '01544')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王锦程', '01640')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '马晓川', '00783')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘钦', '00849')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王强', '01842')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '金卫星', '00141')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曾乐兴', '01124')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '林锦坤', '01224')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王翀', '00010')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '莫斯淇', '00875')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '叶昆', '01881')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张峰', '00811')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张义', '00355')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '黄健', '00041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '盘浩', '01016')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李云', '01507')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '代祥', '00171')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '赖骏星', '01663')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '段盛晓', '00303')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '寇士洋', '00553')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '蒋小龙', '00583')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曹豪磊', '01047')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '陈浩', '00758')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王渊博', '00887')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '龚建春', '01377')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '梁路', '01542')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '韩虚谷', '01256')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘天明', '00906')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '方锐城', '01114')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '闵丽', '00560')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', 'Shairful Islam', '')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '马国良', '01698')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李丹平', '00754')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '蔡欣城', '00876')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '马强', '01518')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '曾忠', '00492')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '徐显斌', '00936')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '涂颢', '00631')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '董海忠', '00377')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '孙良锋', '00419')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '吴昊', '00909')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张镇群', '01225')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '许道银', '01545')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '王春生', '00725')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '陈磊', '01532')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '潘胜荣', '00816')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '梁咏咏', '01671')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '廖一舸', '01537')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '刘峰', '01598')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '陈盛欢', '01508')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '于栋才', '01531')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '雷伟国', '00044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '韩立春', '01286')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '单彤', '01694')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李璠', '01287')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '吴少波', '00751')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '涂才荣', '00028')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '顾丽芳', '01288')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '姚长征', '00872')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '谭波', '00027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '蔡海山', '00168')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李少锋', '01347')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王术银', '01290')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张海', '01690')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵建武', '1868')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '屠建桥', '01176')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '肖志高', '00518')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '吴青', '00953')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘勇', '01406')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赖沛坚', '01659')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李小斌', '01668')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张森', '01755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '涂齐鹏', '01155')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘根平', '00856')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '汪鹏', '00379')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱兴荣', '01291')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '沈云鹏', '01292')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈正伟', '01796')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '平原', '01293')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '郭少锋', '01294')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '顾程诚', '01404')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '方理', '01301')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陶其雷', '01295')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵西锋', '01296')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '孙杰', '01298')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '孙伟伟', '01299')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '冯楠', '01303')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '蒋圣辉', '01304')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵琳瑕', '01307')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '毛秀芬', '01311')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '占飞', '01452')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘剑刚', '01453')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '鲍书林', '01461')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '徐广赢', '01574')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张俊鹤', '01578')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李建辉', '01579')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杜俊超', '01580')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '田亚军', '01619')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈俊冉', '01620')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '肖琪', '01700')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵凯', '01701')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '姚礼文', '01703')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李炫', '01702')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '郭佳佳', '01798')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨辑斌', '01799')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱红伟', '01800')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵敏', '01806')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王宏健', '01803')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '鲍诚', '01804')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '乐宏瑞', '01805')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王显仁', '01807')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '顾蓉蓉', '01300')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张方芳', '01320')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '宋佩', '01402')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '钱悦', '01658')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李洪录', '01667')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李艳春', '01778')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李琪', '01779')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '唐一昊', '01780')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '周聪慧', '01777')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '袁玉丰', '01797')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张逸晨', '01849')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李云军', '01850')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱凌峰', '01851')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张宏远', '01781')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '马荣来', '01289')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陆海雷', '00522')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '肖辉', '00345')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '冯帆', '01693')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '袁程程', '01812')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '伍亮', '00422')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈云', '00877')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '周永成', '01167')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '梁振宽', '01734')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '廖春阳', '01683')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '吴国成', '00586')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨静静', '01655')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘磊', '01168')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '韦萍', '01357')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '别琴', '01458')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '孔秀敏', '01187')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '梁馨文', '01794')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李智', '00960')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '曲文', '01008')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '丁莫云', '01429')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '梁文雅', '01108')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '黄东', '00527')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '郭玉', '01397')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '钟承星', '01259')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨晨', '00134')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '鹿炳全', '01330')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵向蓝', '01018')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '饶庄黎', '01530')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李霞', '00917')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈慧子', '00359')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '郭雪妮', '00958')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王瑾晓', '01341')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '余思', '01407')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '尹阳平', '01228')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘沛', '01510')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '崔圆圆', '01549')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '罗环环', '01864')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱苗', '00569')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '熊爽', '00904')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱丽璇', '01101')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈焦焦', '01399')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '李小娇', '01226')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '林燕梅', '01529')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '覃秋香', '01590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '丁鼎', '00342')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈梓博', '00514')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '黄宇航', '00427')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈钦明', '00564')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', 'Ziaur Rahman', '00805')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '铁小文', '01251')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '鲍彬彬', '00557')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨根龙', '01856')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘亚楠', '01566')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赵贤凯', '00602')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '万里', '01457')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '谢关明', '01000')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '韩康', '01257')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '廖伟添', '01731')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '胡兵', '01394')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '胡蒋科', '00017')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王路', '01754')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '燕朝建', '01430')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '吴玉虎', '01863')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘宏', '00179')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '鲁荣豪', '00116')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张操', '00532')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '王正文', '00988')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱锦江', '01260')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张杰', '01615')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '黄友军', '00672')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘小龙', '00558')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '庞星星', '01213')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘航宇', '01586')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨帆', '00787')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '屈明荣', '01553')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', 'Kenmoe Jacques', '01045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '林锐鹏', '01413')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '赛文强', '01517')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '巫震宇', '00748')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '吴昊', '01282')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '万亮', '01708')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '何安祥', '01552')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '武洲迪', '01643')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', 'Saha Shyamol Kumar', '00009')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '贺为', '01473')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '过瑞骏', '01632')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '周猛', '01647')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '刘建宇', '01695')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张华龙', '01705')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '屈翀', '01739')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '窦维熙', '01773')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张群', '01741')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈波', '01747')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '熊锋', '01748')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '冯素雯', '01738')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '梁柱', '01870')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '张金雷', '01877')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '袁首罡', '01882')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '田少林', '01883')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '陈以杰', '01885')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '姜曙明', '00455')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '李魁', '00556')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '曾英', '01254')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '洪科', '01835')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '伊晓蕾', '01563')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '左涛', '00460')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '施其杰', '01562')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '季锴', '01871')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王玉华', '01470')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '周鸿武', '00918')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '叶淑婷', '00650')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '叶珍', '01672')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '陈呈', '01417')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王梅', '01478')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '李春鹏', '00562')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Camille Louis Leon', '01014')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '张明玮', '01396')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '胡秋灵', '01608')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '介淼森', '01534')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '张同仕', '01843')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '钟小爽', '01536')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '唐俊飞', '00529')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王承龙', '01408')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '龚晓伟', '00784')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '韩倚尼', '01535')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '张文皓', '00785')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '陈艳霞', '00520')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '马佐刚', '00841')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '涂茂婷', '01105')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Nayyar Hussain', '00819')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '施建鑫', '01524')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '冼志彪', '01035')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Chatelain Jeanalexis Jerome', '01103')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '蔡茂', '00584')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '彭继圭', '00567')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '孙晓蒙', '01466')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Anis Thoha Manshur', '01455')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Calvin', '01597')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '文艺', '01533')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Boudchiche Itkane', '01272')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '余雷', '00827')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '林涛', '01664')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王晓虹', '01277')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '杨爽', '01558')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '周毅', '01559')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '胡飞侠', '00008')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '李贵品', '01182')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '韩冬', '00941')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '王文超', '01342')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '傅鑫', '01365')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '郑小龙', '01449')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '李玥', '00595')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '孙媛媛', '00974')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '许昭', '00135')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '危娜', '01371')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '韩雪梅', '01765')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '周凌艳', '01761')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '李倩雯', '01576')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '唐波', '00251')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '关铮杰', '00730')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '林朝升', '01210')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '李健', '01414')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '赵起', '01395')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '周敏章', '01605')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '董爱保', '01860')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('新事业部', '周博', '01847')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '吴文', '00240')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '徐晓玲', '01001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '温玉辉', '01884')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '黄永源', '00136')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '高建旺', '01744')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '朱文卿', '00531')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘望可', '01093')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '何元靖', '01721')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '金宏亮', '01890')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', 'Mohammad Mahfuzul Huq', '00165')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '姚少飞', '01123')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '石伟', '00295')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张聂', '00670')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '赵毅', '01276')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '欧阳振瑞', '00186')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '黄仕帅', '00433')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '徐超', '01048')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '赵伯威', '01513')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '李长江', '01273')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '林宏强', '00561')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '赵仰强', '00420')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘凯', '00229')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '肖文', '00971')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '马骄', '00832')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '李明', '01512')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '齐进', '01722')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '胡军', '00820')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王超', '01712')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '艾余胜', '00439')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '高斌斌', '00200')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '杜灿', '01023')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王辉', '00391')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '吴加辉', '01274')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '邓介刚', '00969')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张强', '01467')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '廖京林', '00970')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '马骏', '01523')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '汪静', '01015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '向东', '00845')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '雷富金', '01205')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '宁建梅', '00157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '陆翠洪', '00695')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '游起发', '01130')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '谢本朴', '01387')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王增良', '01427')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '凌伟栋', '01853')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '章越', '01888')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '熊佩', '01401')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '程杰', '01555')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '曾飞', '01720')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '冯颖', '01826')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '周牡丹', '01854')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张友利', '01861')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '苟桂花', '01145')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '罗春迎', '01175')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王佳', '01319')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '黄庭美', '01281')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '彭卓', '01327')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王训清', '01418')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '李娜', '01745')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '黄剑锋', '01746')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张元中', '01644')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '郝明雄', '01046')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '汪波', '01232')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '陈辉', '01233')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '钟虎', '01440')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '王宏业', '01572')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '赵斯亮', '01893')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '姜柏宇', '00060')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘代林', '01603')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张小飞', '01726')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '邓可爽', '00328')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '张家威', '00940')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘团', '00854')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '金阳', '01079')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '杨柠铭', '01125')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '赵耀', '01069')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '何巍', '00962')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '曾续琴', '01051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '彭丽', '01188')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '郭天舒', '01364')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '李云水', '01465')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '李丽', '01840')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘凡', '01606')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '巩祥君', '01631')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '翁高群', '01594')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '孙慧敏', '01525')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', 'Gvenkadee Javish', '01637')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', 'Elizabeth Ampaw', '01636')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王济纬', '80001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '赖怡璇', '80218')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘靓', '80071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '卢健', '80013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王凡', '80045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈小双', '80062')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈志立', '80186')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '方芳', '00259')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '曾志英', '80099')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '郑艳清', '80206')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '彭义臻', '80044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '马依德', '80180')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘文杰', '80028')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '高健伦', '80056')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '吴倍苍', '80063')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '程刚', '80080')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '聂登辉', '80203')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '季鹏', '80172')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黄程', '80170')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '眭志伟', '80159')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '雷志强', '80163')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '谢锦', '80104')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '李冠霖', '80155')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王贺', '80061')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '冯立彬', '80197')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '毛健羽', '80122')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈竞雄', '80153')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘巧', '80157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '赵辉', '80169')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '张硕', '80205')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '明亮', '80210')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈家乐', '80011')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈风斌', '80149')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '尹金亮', '80156')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '邓立', '80175')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '温湛波', '80207')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '林耀亮', '80209')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈加凯', '80016')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '梁发源', '80006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '徐伟松', '80005')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '卓优', '80052')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '李妮丽', '80020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黄俏', '80173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '汪玲', '80214')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黄琦', '80098')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈志萍', '80139')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '张杰', '80213')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '苏超', '80174')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '栾红', '80212')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '谭云', '80047')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '孙盼', '80129')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '朱朝阳', '80184')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '官焕静', '80140')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '张茂军', '80021')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '何启凤', '80178')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '罗松松', '80202')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '成宇', '80103')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '张慧辉', '80177')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '蒙杰', '80201')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '韦星', '80215')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王成君', '80147')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王晓龙', '80054')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '马庆毅', '80118')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王伟', '80181')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '杜桓', '80193')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈志豪', '80199')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黄杰', '80106')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '杨运祥', '80189')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黎晓文', '80125')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '邓如桔', '80137')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '余来志', '80004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '程屹东', '80036')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘志', '80031')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '何祥阳', '80195')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '史坤', '80043')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陶凯林', '80126')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王益', '80134')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '何建国', '80185')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '赵清华', '80074')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '李航', '80041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '谢梦晨', '80102')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '黄帆', '80121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '唐裕', '80075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '雷玲玲', '80070')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '马丽婵', '80100')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '王储玺', '80151')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '袁杨杨', '80176')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '邓丽姣', '80211')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '符小小', '80198')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '林佳彬', '80200')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '邓浩', '80007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘艺良', '80204')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '李靖', '80024')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '杨玲', '80161')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '陈忆佳', '80053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '熊菊莲', '80191')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '胡名扬', '80216')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '姚泽武', '80217')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '罗远辉', '80034')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '钟超', '80179')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '刘茜茜', '80009')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', 'Mounir Boukali', '80171')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '林闽琦', '80162')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('移动互联部', '孙浩桓', '80120')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆伟峰', '60002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王海滨', '00131')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张喜荣', '60708')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '辛未', '00859')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张丽清', '60268')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晓晓', '60712')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨颜菁', '60742')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邓国彬', '00025')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈海军', '60691')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴一鸣', '00679')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴筱颖', '60631')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '包永强', '60630')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏晨', '60646')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈林', '60640')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹娟', '60006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王栋', '60013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任凯', '60698')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪丽', '60011')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐永涛', '60045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚茂礼', '60629')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪琳', '60223')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王建伟', '60624')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐利科', '60689')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王肖伟', '60546')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '金凤麟', '60015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '焦小平', '60695')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张合乾', '60075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '滕帅', '60284')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈冲', '60350')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '柳佰华', '60447')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '查海辉', '60525')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏雨', '60457')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '葛伍全', '60494')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '虞荣喆', '60495')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李熙', '60670')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈宇', '60040')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄鑫', '60226')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '闫秋雨', '60217')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李肇光', '60336')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘龙振', '60383')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '祝俊', '60729')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '芦海龙', '60270')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈谊俊', '60598')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘攀', '60599')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王海军', '60037')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周灿', '60131')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王福龙', '60309')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏相声', '60144')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐秦煜', '60171')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卞仕功', '60416')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '金鼎', '01095')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘文生', '60334')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆志民', '60371')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭成勇', '60490')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '申帅帅', '60536')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱海飞', '60499')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王远', '60501')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟浩', '60504')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王周丹', '60505')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭金义', '60512')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '于建华', '60513')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王有威', '60527')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '施亚', '60673')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹跃峰', '00436')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '阮勇', '60674')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郑旭', '60706')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '章富洪', '60436')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐新民', '60511')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '涂才福', '00198')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐涛', '01378')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡澈', '60600')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '储昭阳', '60344')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱勇', '60020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董军', '60146')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陶丽君', '60174')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '皇甫娜', '60200')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '舒凯', '60332')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '苏静', '60260')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张释引', '60278')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '洪宗胜', '60283')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马丹丹', '60353')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '程慧君', '60227')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗丽', '60182')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姜飞', '60009')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '聂维祺', '60022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李金山', '60458')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任新泉', '60065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘芳', '60027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '詹昌松', '60455')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '常义兵', '60041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊辉', '60051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李凯', '60096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵江伟', '60150')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林肖敏', '60551')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李杨', '60077')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '崔娜娜', '60086')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱伟', '60253')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '束陈林', '60259')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '毛育滔', '60324')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张涛', '60151')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾少平', '60179')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王春生', '60368')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马文涛', '60380')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾加成', '60399')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴昊', '60400')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文灿', '60426')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王鹏', '60405')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱诗宇', '60388')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王轶超', '60446')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈跃申', '60545')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈立佳', '60555')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '辛弦', '60616')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谷金凤', '60661')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '饶平峰', '60667')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘志强', '60437')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘豪杰', '60090')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟达', '60741')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邵伟', '60746')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '高明明', '60747')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨硕', '60763')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董二强', '60766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李康', '60668')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '巫运辰', '60596')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周乃涛', '60440')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邱宙清', '60463')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨钧', '60464')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周金建', '60465')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张永彪', '60466')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙明玉', '60572')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李诚', '60573')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张宇', '60574')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '武长坤', '60017')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周飞', '60064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '江威', '60491')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈飞飞', '60752')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张德祥', '60134')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈俊明', '60724')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '亓凯旋', '60109')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄坤明', '60517')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周志刚', '60760')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈睿', '60108')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭少朋', '60118')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡家旋', '60130')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈敏', '60311')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '龚乾坤', '60197')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪晗', '60378')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蒋贻峰', '60342')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄宇杰', '60046')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '韦灵春', '60105')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王栋森', '60374')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨亮', '60247')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '唐圣杰', '60274')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾仁波', '60280')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李琪', '60292')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王新东', '60618')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李守辉', '60321')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张少华', '60323')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '梁朋朋', '60360')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘世权', '60364')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邵广庆', '60367')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭志强', '60369')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林兵', '60390')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '代其全', '60391')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晓刚', '60402')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '殷建红', '60532')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈云库', '60432')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '付宇栋', '60460')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '麻国强', '60677')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄粟', '60678')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨欢', '60694')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈旭', '60702')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周申杰', '60732')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '苏志明', '60688')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '纪廷廷', '60579')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '寇斌', '60581')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '覃桐', '60582')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '莫通', '60583')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁鹏', '60617')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王书颖', '60660')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '史新新', '60557')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴松', '60563')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '连自选', '60565')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '史雷', '60470')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '霍绍强', '60471')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐捷', '60701')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱成', '60771')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王振', '60493')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢志超', '60410')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张浩斌', '60313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘彦忠', '60053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王政', '60316')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周庆怡', '60203')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '戴林春', '60222')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '江涛', '60273')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈敏', '60157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邱红', '60036')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卢常旭', '60711')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '桂云卿', '60736')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '牛建伟', '60241')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚伟', '60297')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴承东', '60303')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马强强', '60326')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周磊', '60335')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗方丽', '60119')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶彩梨', '60121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张颖瑞', '60155')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张闽泉', '60288')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱宁波', '60365')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚黄鑫', '60376')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '屈阳', '60379')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄猷', '60386')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蒋博', '60387')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘家福', '60392')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王奇林', '60394')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张巍', '60403')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李韩', '60445')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '庞婉晶', '60413')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱飞', '60414')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周嵩', '60528')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹远文', '60529')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨庆斌', '60560')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢秋艳', '60620')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈麓阳', '60645')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '冯帅', '60647')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张彦', '60740')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '施伟', '60737')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '季自豪', '60759')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁慧敏', '60642')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '肖孝元', '60474')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王春阳', '60475')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '莫春岑', '60477')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李思翠', '60585')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '向梅', '60586')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘婷', '60587')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘银银', '60588')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈丹', '60589')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李勇刚', '60590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '薛萍', '60591')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '闫晓波', '60592')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王钱', '60548')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈超', '60482')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黎道强', '60750')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭辉奇', '00669')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵永明', '60719')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '梁卉卉', '00032')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李江涛', '00717')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '党进', '00306')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '唐宇鑫', '00628')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴兴丽', '60651')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙海知', '01149')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '袁鹏', '01005')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏继伟', '60613')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭植远', '60643')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李金智', '60686')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘君杰', '60699')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张福洲', '60700')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨玉琳', '60704')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林汉斌', '01029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢碧芳', '01128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄小寒', '60509')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张新田', '60521')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '揭应平', '60658')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘庆', '60692')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钱帮国', '60716')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张玉磊', '00915')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘志浪', '00132')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余玟龙', '00155')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王成永', '60459')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄楠', '60652')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '鄢明智', '60439')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张文海', '60435')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '颜强', '60644')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '耿凯悦', '60606')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗坤', '60608')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许逸君', '60609')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董雯雯', '60718')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '秦西利', '60749')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨道庄', '00705')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孟跃龙', '60004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周劲', '00029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '肖风', '60687')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴孝亮', '60614')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘康', '01072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王小强', '00493')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗湘陵', '00870')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张继海', '00396')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李鸿', '60056')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭立乾', '00777')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许运生', '60621')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '安鑫', '60662')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许宁', '60731')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董兆涛', '60735')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭建森', '60443')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴长国', '01044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李秀明', '60264')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '田超群', '60366')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘殿好', '01137')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶海波', '00957')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马帅', '60448')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赖让锦', '01221')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陶玉华', '60635')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '商骁', '60671')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邹亮', '00280')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡伟欣', '00810')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '晏鹏飞', '60481')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '阳元泽', '60602')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '段锋', '60603')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何正文', '60604')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李贺', '60605')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘晶晶', '00815')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余显波', '60720')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周凡贻', '60072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '柳小龙', '60611')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄俊俊', '60730')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '翟鑫坪', '60540')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵蕊星', '60666')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴经山', '60770')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '温隆祥', '60530')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐斌', '00674')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林湘琦', '60071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '匡捷', '60507')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卞静云', '60488')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵帛羽', '60095')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '章天璐', '60235')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '覃纳', '00991')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张颖', '00950')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郑毓莉', '60568')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾瑜玮', '60680')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '严开灵', '60483')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余永利', '01096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余亚鹏', '01058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈廷波', '00554')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '盛剑', '01585')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '葛春雷', '60665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李景哲', '00464')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈伟园', '00702')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王彬', '60249')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄凌宾', '00885')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵思琦', '60558')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张志坤', '60627')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘灿', '60628')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈宏俊', '60659')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '詹海波', '60444')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何明苍', '60535')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李博', '60544')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '欧阳波', '60649')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周骋', '60478')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘丽', '60480')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余朝阳', '60597')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李扬', '01057')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '尹贤明', '60669')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '袁雪梅', '00590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭必亮', '00156')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘鑫', '01141')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '苏春雷', '01349')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈思贤', '60552')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢精一', '60648')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '壮振邦', '60653')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙介仁', '60690')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何冬梅', '60479')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王伟槐', '60199')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '高启杰', '60346')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '剡飞龙', '60359')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '占雄伟', '60058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆德锁', '60266')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '易朝阳', '60534')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文渊', '60610')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张频捷', '60639')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李仁志', '60173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张阿昌', '60300')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任帅帅', '60100')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任伟', '60218')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊根根', '60325')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟祥超', '60362')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周如磊', '60425')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵华哲', '60454')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱能金', '60514')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '方梦遥', '60725')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张学熙', '60498')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡伟', '60322')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '仇培旋', '60428')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王亚辉', '60496')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '窦永清', '60519')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱轶群', '60634')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '唐启涛', '60461')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐同瑞', '60758')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨葛', '60685')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆正武', '60703')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王龙昌', '60462')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张辉', '60468')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李旭洲', '60570')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '缪威', '60571')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蔡加奇', '60769')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张银', '60576')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '尹文博', '60577')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张亚洲', '60578')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吕磊', '60601')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吉晓伟', '60010')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '韦明微', '60472')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张鹏飞', '60723')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李兵兵', '60566')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭思康', '60569')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '应正大', '60580')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何鹏', '60584')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈昌胜', '60726')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '龙海进', '60637')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '方正栋', '60632')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张柳', '60654')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶翠', '60656')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王健', '60657')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '商令云', '60707')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁丽飞', '60522')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周昌勇', '60754')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵清龙', '60755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王晋', '60728')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晨', '60554')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '冯士严', '00657')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卢帅', '60682')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊红涛', '00639')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周剑', '00701')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '金筱珮', '60697')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李凌志', '60228')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王忠明', '60033')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '秦进', '60007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟劲松', '00575')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '崔晓玲', '60099')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁瑜', '60161')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈雨', '00660')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭利平', '00169')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈高翔', '60520')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '段永国', '60683')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈欢', '60709')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶培智', '60738')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈李奖', '60533')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭锐', '60526')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵巍', '60713')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢其锋', '60727')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李磊', '60710')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张冬', '60739')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文瑞', '60748')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱家瑞', '60663')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘克', '60595')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄建淞', '01258')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '郑雪瑞', '68001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '金山', '68062')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '高翔', '68066')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曾维忠', '68068')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵刚', '68073')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐叶辉', '68079')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '隋亮', '68072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄成钟', '68002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '姚瑞明', '68004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李晓亮', '68005')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '倪鑫', '68006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赖家霞', '68007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵苏州', '68010')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李建林', '68011')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '沈锋', '68012')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张栋梁', '68013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '胡爱策', '68014')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '叶敏', '68015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '刘晓鹏', '68016')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐毅', '68017')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '谢敏', '68020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '毛茗', '68022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李应德', '68023')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '詹丰乐', '68025')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王风', '68026')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '周明伟', '68027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '秦婷', '68028')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '倪磊', '68029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '宋鹃含', '68032')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '杨鹏', '68033')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '朱宇轩', '00964')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '游晓俊', '01577')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '肖雪琴', '68034')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李川江', '68075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '仇彬', '68035')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '陈程', '68036')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '陈玲', '68045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '夏钢', '68041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '戴婷', '68037')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '朱冬冬', '68040')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '章紫云', '68042')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '呙文跃', '68043')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王涛', '68065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '杨刚', '68044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐鹏', '68064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵涛', '68038')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '孙永刚', '68039')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '韩潇潇', '68067')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '何仁杰', '68071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '卫东风', '68048')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '关路明', '68063')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张学朝', '68061')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '刘静江', '68050')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '金超', '68051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张凤柳', '68052')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '常俊宇', '68069')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '唐华杰', '68053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曾笑飞', '68054')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曹建刚', '68055')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '江凤玲', '68057')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '艾玲风', '01477')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '谌思明', '00663')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李志华', '68080')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李德鹏', '68060')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '时萧', '01588')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄梓杰', '01715')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '马昭烈', '80148')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '刘奇', '01880')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王悦颖', '68070')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李宽', '68076')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '屈红燕', '68077')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '李天济', '50025')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '林启武', '50032')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '靳海涛', '50029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '钟崇珍', '50035')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '张伟', '50027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '何超', '50031')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('照明事业部', '何一洋', '50030')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '王功波', '50039')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '张旭东', '00526')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '虞峥峥', '50040')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '古骏锋', '50041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '高鑫东', '50044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '范珊珊', '50042')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '李红霞', '50052')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '李飞', '50043')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '刘军佑', '50045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', 'Arman Ashraf', '50049')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '何淑平', '50057')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('小家电事业部', '唐伟京', '50056')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('PMO办公室', '何翔', '01827')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('南亚地区部', '毛晓军', '01869')");
	}
	
	public function initJobnum2()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '苏凌', 'A04398')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '林丽琴', 'Z12697')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '甘泉', '07313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '戴芳', '07068')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '周毅', '03237')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '王惠丽', 'A06172')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '丘琦鹏', 'A05551')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '李庆尚', 'A05506')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '钟均民', 'A04708')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '邝明科', 'A03464')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '杨俊', 'Z13763')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '罗小彦', 'A03253')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '刘演清', 'Z12813')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '李兵', 'Z11614')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '庞伟亮', 'Z00552')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '安雨桐', 'Z00950')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '冯吉永', 'A01766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '杨少华', '01132')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '刘银辉', '00027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '周祖强', '00107')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '王彩蝶', 'A06027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '黄慧萍', 'A03747')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '张晓艳', 'Z13948')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '杨艳玲', 'Z00401')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('关务部', '冯泽欣', 'A04829')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('关务部', '黄缕', 'A03570')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('关务部', '李金金', 'Z12929')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('关务部', '周凯', 'Z12404')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('关务部', '何爱平', 'Z01121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '宁琳', 'A03461')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '陈尚枫', 'A05552')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '宋美玲', 'A03387')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '林枫', 'Z13498')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '张玲', 'Z13497')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '罗水仟', 'A02541')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '杨黎', 'Z01308')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库', '张何雯', 'A05778')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库', '赵宝链', 'Z12193')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库', '张新玉', '04793')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库', '李光美', '02703')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库', '戴春明', '02391')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '周云文', 'A06372')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '裴江平', 'A05940')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '皮永标', 'A05759')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '邹树青', 'A05729')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '周琳', 'A05553')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '王洁', 'A04839')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '钟佳', 'A04560')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '翁冰娜', 'A03568')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '江娜', 'A03435')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '彭辉', 'Z13782')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '王梦云', 'A03290')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '熊秉意', 'A03521')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '黄永健', 'A05779')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '刘红春', 'A05761')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '甘伟剑', 'A05739')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '关健盈', 'A05722')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '向金明', 'A05319')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '张翔', 'A04762')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '刘左骏', 'A03220')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('测试部', '江期园', 'Z00317')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('部门名称', '姓名', '工号')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造部', '周毅', '03237')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '黄前宇', 'A06229')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '王柏文', 'A06206')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '李容全', 'A06171')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '罗姣梅', 'A05997')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '张宇', 'A05765')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '魏坤', 'A05754')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '毛勇超', 'A05755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '张明', 'A05762')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '邵劭', 'A05620')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '宋昌运', 'A04800')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '周微', 'A03473')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '杨长秀', 'Z12052')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '蔡然', 'Z01285')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '程谭洋', '08746')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '谭香莲', 'A01219')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '杨艳玲', '03235')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('精益革新部', '王智聪', 'A00949')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '黄一星', 'A05757')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '谢绍辉', 'A05758')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '刘良衍', 'A05764')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '邓凯', 'A05763')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '冯楷', 'A05780')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '王楚峰', 'A05728')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '杨国庆', 'A05724')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '王承辉', 'A05721')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '颜燕青', 'A05385')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '何雷', 'A05336')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '和文文', 'A05335')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '罗津', 'A04691')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '李鸿幸', 'A04556')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '蔡星', 'A04381')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '彭金根', 'A04279')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '蒋冠勇', 'A03098')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '齐诚云', 'Z13098')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '陈荣源', 'Z12971')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '赵新', 'Z12665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '刘天东', 'Z12128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '叶重吕', 'Z00938')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '陈程', 'A02253')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '邓林周', '08975')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '李振干', '06336')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '王青博', '05192')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '苏廷桥', '04088')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '滕树华', '03869')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '陈礼文', '03559')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '陵欢欢', '01803')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '黄承富', 'A03178')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '麦祝瑞', 'A03176')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '郑彪', 'A03125')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '张维', 'A02831')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '李飞', 'A02254')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '曾华生', 'A02830')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '郑培生', '01062')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '李耀熙', 'A05311')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '袁立', 'Z12673')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品导入部', '包俊兵', 'Z01110')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制程工艺部', '刘慧琪', 'A06026')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量部', '甘泉', '07313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '杨淑', 'A05776')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '周亚民', 'Z13649')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '王学文', 'A03157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '刘霞', 'A02787')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '付先进', 'Z11808')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '彭光宗', '05590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('来料质量控制部', '马铁', 'A01440')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('文控中心', '胡秀兰', '04927')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '钟凤珍', 'A06285')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '白晓煌', 'A05772')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '李志豪', 'Z11788')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '李莉芝', '07112')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '王卫杰', '06412')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '胡贵荣', '04992')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '巫丽', 'A01297')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '黄东海', 'A03518')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '彭龙', 'A05828')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '李梦瑶', 'A05766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '付福军', 'A05753')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '肖俊', 'A05313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '王东', 'A03162')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '李雪利', 'Z13096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '郑剑锋', 'Z11751')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('文控中心', '谢秋红', 'A05955')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('文控中心', '罗宇霞', 'A05636')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '邹全喜', 'A01885')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '李桂胜', '07933')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '刘锡友', 'A05817')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '李鹏', '00423')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '李孙南', '09366')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '吴兰英', 'A01799')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '罗永春', '05896')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '胡胤熙', '05307')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '周建军', '02379')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '杨红梅', 'A03246')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '毛海燕', '04767')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '刘森', 'A01969')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '王方坤', 'A00562')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '梁意', 'A00688')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '古永强', '06388')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '刘川东', '01470')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '赵娟', 'A01348')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '刘彩群', 'A06173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '何虎辉', '03764')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '谭发友', '08266')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '周响民', '03285')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '闻明', 'Z12175')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '林显华', '04755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('集装部', '陈才', '05601')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '徐琪', 'A06165')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '谭敏仪', 'A05954')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '李昊峰', 'A06233')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '唐正', 'A05807')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '袁栋', 'A04685')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '李宇程', 'Z13097')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '蒋春花', 'Z11755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('实验室', '银涛', 'Z11690')");
	}
	
	public function initJobnum3()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆伟峰', '60002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王海滨', '00131')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张喜荣', '60708')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '辛未', '00859')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晓晓', '60712')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张丽清', '60268')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邓国彬', '00025')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨颜菁', '60742')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐斌', '00674')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈海军', '60691')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴一鸣', '00679')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴筱颖', '60631')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '包永强', '60630')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏晨', '60646')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈林', '60640')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹娟', '60006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王栋', '60013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任凯', '60698')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪丽', '60011')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐永涛', '60045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚茂礼', '60629')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪琳', '60223')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王建伟', '60624')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐利科', '60689')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王肖伟', '60546')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '金凤麟', '60015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '焦小平', '60695')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张合乾', '60075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '滕帅', '60284')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈冲', '60350')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '柳佰华', '60447')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王有威', '60527')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '查海辉', '60525')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏雨', '60457')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '葛伍全', '60494')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '虞荣喆', '60495')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李熙', '60670')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈宇', '60040')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱勇', '60020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄鑫', '60226')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '闫秋雨', '60217')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李肇光', '60336')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘龙振', '60383')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '祝俊', '60729')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈谊俊', '60598')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘攀', '60599')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王海军', '60037')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周灿', '60131')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卞仕功', '60416')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '金鼎', '01095')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王福龙', '60309')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘文生', '60334')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆志民', '60371')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏相声', '60144')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐秦煜', '60171')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭成勇', '60490')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '申帅帅', '60536')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '芦海龙', '60270')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱海飞', '60499')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王远', '60501')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟浩', '60504')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王周丹', '60505')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭金义', '60512')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '于建华', '60513')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '施亚', '60673')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹跃峰', '00436')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '阮勇', '60674')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郑旭', '60706')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '章富洪', '60436')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐新民', '60511')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡澈', '60600')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '储昭阳', '60344')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董军', '60146')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陶丽君', '60174')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '皇甫娜', '60200')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '舒凯', '60332')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '苏静', '60260')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张释引', '60278')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '洪宗胜', '60283')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马丹丹', '60353')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '程慧君', '60227')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗丽', '60182')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姜飞', '60009')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '聂维祺', '60022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李金山', '60458')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘芳', '60027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任新泉', '60065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '常义兵', '60041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊辉', '60051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李凯', '60096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵江伟', '60150')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林肖敏', '60551')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '詹昌松', '60455')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李杨', '60077')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '崔娜娜', '60086')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱伟', '60253')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '束陈林', '60259')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '毛育滔', '60324')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张涛', '60151')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾少平', '60179')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王春生', '60368')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马文涛', '60380')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾加成', '60399')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴昊', '60400')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文灿', '60426')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王鹏', '60405')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱诗宇', '60388')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王轶超', '60446')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈跃申', '60545')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈立佳', '60555')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '辛弦', '60616')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谷金凤', '60661')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '饶平峰', '60667')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘志强', '60437')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘豪杰', '60090')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李康', '60668')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '巫运辰', '60596')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周乃涛', '60440')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邱宙清', '60463')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨钧', '60464')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周金建', '60465')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张永彪', '60466')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙明玉', '60572')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李诚', '60573')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张宇', '60574')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟达', '60741')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邵伟', '60746')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '高明明', '60747')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐涛', '60575')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨硕', '60763')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董二强', '60766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '武长坤', '60017')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张德祥', '60134')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周飞', '60064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈俊明', '60724')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈睿', '60108')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '亓凯旋', '60109')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭少朋', '60118')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡家旋', '60130')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈敏', '60311')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄坤明', '60517')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蒋贻峰', '60342')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄宇杰', '60046')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '韦灵春', '60105')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '龚乾坤', '60197')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王栋森', '60374')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨亮', '60247')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '唐圣杰', '60274')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾仁波', '60280')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李琪', '60292')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁鹏', '60617')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王新东', '60618')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李守辉', '60321')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王书颖', '60660')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张少华', '60323')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '梁朋朋', '60360')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘世权', '60364')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邵广庆', '60367')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭志强', '60369')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '汪晗', '60378')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林兵', '60390')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '代其全', '60391')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晓刚', '60402')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '殷建红', '60532')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈云库', '60432')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '付宇栋', '60460')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '史新新', '60557')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴松', '60563')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '连自选', '60565')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '麻国强', '60677')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄粟', '60678')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨欢', '60694')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈旭', '60702')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '史雷', '60470')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '霍绍强', '60471')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周申杰', '60732')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '苏志明', '60688')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '纪廷廷', '60579')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '寇斌', '60581')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '覃桐', '60582')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '莫通', '60583')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王振', '60493')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢志超', '60410')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张浩斌', '60313')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '江威', '60491')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐捷', '60701')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈飞飞', '60752')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周志刚', '60760')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱成', '60771')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘彦忠', '60053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈敏', '60157')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '邱红', '60036')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卢常旭', '60711')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王政', '60316')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗方丽', '60119')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶彩梨', '60121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张颖瑞', '60155')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周庆怡', '60203')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '牛建伟', '60241')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '戴林春', '60222')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '江涛', '60273')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张闽泉', '60288')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚伟', '60297')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴承东', '60303')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱宁波', '60365')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马强强', '60326')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周磊', '60335')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '姚黄鑫', '60376')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '屈阳', '60379')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄猷', '60386')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蒋博', '60387')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘家福', '60392')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王奇林', '60394')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张巍', '60403')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李韩', '60445')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '庞婉晶', '60413')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱飞', '60414')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周嵩', '60528')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '曹远文', '60529')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨庆斌', '60560')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王钱', '60548')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢秋艳', '60620')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈超', '60482')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈麓阳', '60645')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '冯帅', '60647')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁慧敏', '60642')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '肖孝元', '60474')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王春阳', '60475')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '莫春岑', '60477')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李思翠', '60585')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '向梅', '60586')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘婷', '60587')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘银银', '60588')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈丹', '60589')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李勇刚', '60590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '薛萍', '60591')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '闫晓波', '60592')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '桂云卿', '60736')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张彦', '60740')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '施伟', '60737')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黎道强', '60750')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '季自豪', '60759')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭辉奇', '00669')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵永明', '60719')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '梁卉卉', '00032')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李江涛', '00717')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴兴丽', '60651')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙海知', '01149')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '夏继伟', '60613')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭植远', '60643')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李金智', '60686')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘君杰', '60699')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张福洲', '60700')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨玉琳', '60704')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林汉斌', '01029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢碧芳', '01128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄小寒', '60509')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张新田', '60521')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '揭应平', '60658')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘庆', '60692')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钱帮国', '60716')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张玉磊', '00915')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王成永', '60459')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄楠', '60652')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '鄢明智', '60439')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张文海', '60435')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '耿凯悦', '60606')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '罗坤', '60608')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许逸君', '60609')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董雯雯', '60718')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '秦西利', '60749')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '安子', '60441')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孟跃龙', '60004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨道庄', '00705')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '肖风', '60687')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张继海', '00396')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李鸿', '60056')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭立乾', '00777')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴孝亮', '60614')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许运生', '60621')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '安鑫', '60662')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '许宁', '60731')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '董兆涛', '60735')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴长国', '01044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘康', '01072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭建森', '60443')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李秀明', '60264')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '田超群', '60366')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '马帅', '60448')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '商骁', '60671')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '晏鹏飞', '60481')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '阳元泽', '60602')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '段锋', '60603')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何正文', '60604')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李贺', '60605')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘晶晶', '00815')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余显波', '60720')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周永静', '60772')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周凡贻', '60072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '柳小龙', '60611')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '黄俊俊', '60730')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '林湘琦', '60071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '翟鑫坪', '60540')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '温隆祥', '60530')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵蕊星', '60666')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卞静云', '60488')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '匡捷', '60507')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵帛羽', '60095')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '章天璐', '60235')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '覃纳', '00991')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张颖', '00950')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郑毓莉', '60568')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '顾瑜玮', '60680')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '严开灵', '60483')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余永利', '01096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余亚鹏', '01058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐珺', '60753')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吴经山', '60770')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '壮振邦', '60653')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈廷波', '00554')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '葛春雷', '60665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵思琦', '60558')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈宏俊', '60659')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '孙介仁', '60690')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈伟园', '00702')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李扬', '01057')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '詹海波', '60444')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王彬', '60249')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何明苍', '60535')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李博', '60544')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周骋', '60478')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何冬梅', '60479')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '刘丽', '60480')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '余朝阳', '60597')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王伟槐', '60199')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '高启杰', '60346')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '易朝阳', '60534')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文渊', '60610')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张频捷', '60639')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '剡飞龙', '60359')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '占雄伟', '60058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李仁志', '60173')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任帅帅', '60100')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '任伟', '60218')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊根根', '60325')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '钟祥超', '60362')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周如磊', '60425')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵华哲', '60454')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱能金', '60514')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '方梦遥', '60725')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张学熙', '60498')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆德锁', '60266')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张阿昌', '60300')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '胡伟', '60322')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '仇培旋', '60428')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王亚辉', '60496')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '窦永清', '60519')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱轶群', '60634')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '杨葛', '60685')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陆正武', '60703')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '唐启涛', '60461')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王龙昌', '60462')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张辉', '60468')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李旭洲', '60570')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '缪威', '60571')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张银', '60576')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '尹文博', '60577')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张亚洲', '60578')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吕磊', '60601')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '徐同瑞', '60758')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '蔡加奇', '60769')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '吉晓伟', '60010')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '韦明微', '60472')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张鹏飞', '60723')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李兵兵', '60566')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭思康', '60569')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '应正大', '60580')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '何鹏', '60584')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈昌胜', '60726')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '龙海进', '60637')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '方正栋', '60632')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张柳', '60654')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '叶翠', '60656')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王健', '60657')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '商令云', '60707')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁丽飞', '60522')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王晋', '60728')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李晨', '60554')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周昌勇', '60754')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵清龙', '60755')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '卢帅', '60682')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '熊红涛', '00639')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李凌志', '60228')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '王忠明', '60033')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '崔晓玲', '60099')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '丁瑜', '60161')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '彭利平', '00169')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈高翔', '60520')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '沈欢', '60709')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陈李奖', '60533')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '郭锐', '60526')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵巍', '60713')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '谢其锋', '60727')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李磊', '60710')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '秦进', '60007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '朱家瑞', '60663')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘克', '60595')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '张冬', '60739')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李文瑞', '60748')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄建淞', '01258')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '郑雪瑞', '68001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '金山', '68062')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '高翔', '68066')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曾维忠', '68068')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵刚', '68073')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '隋亮', '68072')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄成钟', '68002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '姚瑞明', '68004')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李晓亮', '68005')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '倪鑫', '68006')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赖家霞', '68007')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵苏州', '68010')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李建林', '68011')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '沈锋', '68012')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张栋梁', '68013')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '胡爱策', '68014')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '叶敏', '68015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '刘晓鹏', '68016')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐毅', '68017')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '谢敏', '68020')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '毛茗', '68022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李应德', '68023')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '詹丰乐', '68025')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王风', '68026')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '周明伟', '68027')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '秦婷', '68028')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '倪磊', '68029')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '宋鹃含', '68032')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '杨鹏', '68033')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '朱宇轩', '00964')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '游晓俊', '01577')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '肖雪琴', '68034')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李川江', '68075')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '仇彬', '68035')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '陈程', '68036')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '陈玲', '68045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '夏钢', '68041')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '戴婷', '68037')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '朱冬冬', '68040')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '章紫云', '68042')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '呙文跃', '68043')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王涛', '68065')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '杨刚', '68044')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐鹏', '68064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '赵涛', '68038')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '孙永刚', '68039')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '韩潇潇', '68067')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '何仁杰', '68071')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '卫东风', '68048')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '关路明', '68063')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张学朝', '68061')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '刘静江', '68050')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '金超', '68051')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '张凤柳', '68052')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '常俊宇', '68069')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '唐华杰', '68053')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曾笑飞', '68054')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '曹建刚', '68055')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '江凤玲', '68057')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '艾玲风', '01477')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '谌思明', '00663')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李德鹏', '68060')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '时萧', '01588')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '黄梓杰', '01715')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '王悦颖', '68070')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李宽', '68076')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '屈红燕', '68077')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '徐叶辉', '68079')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '李志华', '68080')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '邓翔', '00022')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总裁办', '肖明', '60001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '段培俊', '60650')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '所迪', '60271')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '邓慧', '00858')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '沈倍佩', '60431')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '王跞一', '68059')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '杨婉岑', '60452')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '魏登梅', '68058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '石杉钐', '60751')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '田慧茹', '60761')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '官爱民', '00781')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '张兰华', '60008')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '沈海河', '60415')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '吕帅', '60178')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '柯灜', '60641')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '蒋松萌', '60409')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张阳', '60714')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '张大敏', '60743')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '朱建刚', '60250')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '李小霞', '00737')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '周惠娟', '01038')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '刘娜', '60429')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('采购部', '王慧', '01802')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '王甲亮', '60195')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周为英', '60238')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '蒋佳星', '00760')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '何小刚', '60304')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '朱洪君', '01192')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '林剑', '60612')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张彦博', '60556')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '洪亚婷', '60451')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '朱秋琳', '60672')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '沈丽君', '60449')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '毛海霞', '60299')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '张腾达', '01830')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '周思瑞', '60767')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '董闻卿', '60768')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '夏霄月', '60145')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张永乐', '60003')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '张蕊', '60163')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '赵震', '00605')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '李贝贝', '01557')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('品牌管理部', '王银行', '01867')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '申瑞刚', '00129')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '刘国利', '01246')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '杨勇', '01139')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '魏望', '01798')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '施成星', '01808')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李祥', '01621')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '刘年红', '01797')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '袁野', '61339')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '任文', '01121')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李传堃', '00809')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '沈祥荣', '01426')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '曲兴城', '01567')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '薛榆蒙', '01333')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '鲁林海', '01148')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '黎哲煌', '01340')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '胡志远', '01799')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '赵琳', '80083')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '廖阳杰', '80135')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李旻婧', '80089')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '潘蒙', '80128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李璟', '01820')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '王腾', '01669')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '项赟', '00715')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('产品规划部', '李梅', '01331')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('运营商事业部', '孙道阔', '01428')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '哈乐', '01692')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '金言', '01247')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李庭', '01432')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '李启军', '01326')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('TECNO事业部', '张欣', '00543')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '姜曙明', '00455')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '伊晓蕾', '01563')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '左涛', '00460')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王玉华', '01470')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '叶珍', '01672')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '杨爽', '01558')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '周毅', '01559')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', 'Camille Louis Leon', '01014')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '龚晓伟', '00784')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '马佐刚', '00841')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '涂茂婷', '01105')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '孙晓蒙', '01466')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王梅', '01478')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '洪科', '01835')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '季锴', '01871')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('PMO办公室', '何翔', '01827')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('投资法务部', '张家俊', '01848')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('南亚地区部', '马明', '01675')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('南亚地区部', '何玉民', '01788')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('南亚地区部', '陈见平', '01784')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '陶红珍', '01158')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '潘燕', '60625')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平板事业部', '吴长春', '68078')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周婷', '60756')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '赵成书', '60762')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('Infinix事业部', '王云霞', '01878')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('软件开发一部', '陈龙', '60765')");
	}
	
	public function initJobnum4()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('行政管理部', '孙梦霞', '60780')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('用户体验部', '邹成珅', '60776')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('软件开发一部', '王士龙', '60773')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('infinix事业部', '侯学庆', '01895')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '屠建桥', '01776')");
	}
	
	public function initJobnum5()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海结构部', '聂秀风', '60779')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '朱红伟', '01836')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '郭佳佳', '01865')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨辑斌', '01866')");
	}
	
	public function initJobnum6()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '黄燕恒', '50060')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('制造管理部', '赵晶', '01897')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('平台管理部', '谢从孝', '01892')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '周勇', '60781')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', 'NGA GUY JOSEPH', '60782')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '付奕群', '01889')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('itel事业部', '杨含月', '01896')");
	}
	
	public function initJobnum7()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '王朝辉', 'H00001')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量部', '王中琦', 'H00003')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '刘思勤', 'H00116')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '杨志祥', 'H00127')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '陈晓青', 'H00128')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '李奎', 'H00131')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '邹永梅', 'H00175')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '刘艳', 'H00255')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '林尽妮', 'H00299')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '管丽萍', 'H00322')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '周胜鹏', 'H00360')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '周宗成', 'H00361')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '王裕华', 'H00362')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库管理部', '苏小龙', 'H00468')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '吴新媚', 'H00589')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '温锦业', 'H00524')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '邹夏玲', 'H00548')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '罗亮平', 'H00708')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '孙长保', 'H00714')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '詹吉金', 'H00780')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '林杰青', 'H00793')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '丁冬梅', 'H00636')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '黄志威', 'H00852')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '肖慧珍', 'H01104')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '陈梦红', 'H01206')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '陈海山', 'H01375')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '温望朋', 'H01414')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '李丽萍', 'H01454')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '戴加军', 'H01553')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '刘志坚', 'H01580')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '叶凡', 'H01590')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '杨汉林', 'H01607')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '谢东海', 'H01649')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '唐健', 'H01707')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '李敏', 'H01722')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '唐权', 'H01729')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '彭峰', 'H01764')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '李巧', 'H01766')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '程竹君', 'H01928')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '欧阳海星', 'H01988')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '胡丽', 'H01992')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '胡麒亮', 'H02023')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '林少辉', 'H02045')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '龙玉香', 'H02096')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库管理部', '朱光英', 'H02110')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '陈斌', 'H02211')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '刘钱林', 'H02332')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '黄丽球', 'H02412')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '余锋', 'H02658')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '吴文香', 'H02688')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库管理部', '高俊', 'H02752')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '胡俊豪', 'H02775')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '李志鹏', 'H02780')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '雷国珍', 'H02804')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '向军', 'H02945')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '周文浩', 'H03239')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '黄嘉红', 'H03241')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '刘洋', 'H03262')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '方军', 'H03266')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('维修车间', '李浩华', 'H03315')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('人力资源部', '李彦龙', 'H03399')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '吴智波', 'H03418')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('维修车间', '罗珊', 'H03432')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('计划部', '王海霞', 'H03530')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '程秋鹏', 'H03531')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '方声康', 'H03607')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('总经办', '宋小伟', 'H00002')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '张硬月', 'H03664')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '羊军', 'H03665')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '冯德杰', 'H03666')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '杨洪', 'H03683')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '杨梅花', 'H03715')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库管理部', '卜洪德', 'H03839')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '吴天河', 'H03870')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质控部', '江奇', 'H03884')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '刘道琼', 'H04014')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '吴德康', 'H04015')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '何龙', 'H04018')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '李建波', 'H04207')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '邓超', 'H04251')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '苏雪芬', 'H04274')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '钟小红', 'H04278')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '赵海', 'H04292')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('仓库管理部', '郝勇', 'H04309')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '林秋月', 'H04323')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('工程部', '邓碧', 'H04335')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '陈欢', 'H04506')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质检部', '娄彩丽', 'H04553')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '易国龙', 'H04620')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('文控中心', '杨丽红', 'H04630')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('生产部', '高瑜敏', 'H04779')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('后勤部', '孙任生', 'H04802')");
	}
	
	public function initJobnum8()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('信息管理部', '娄博', '01903')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('上海研发中心', '李立', '60785')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('财务管理部', '叶任凯', '50055')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '刘文琪', '50058')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('客户服务中心', '徐玉欣', '50059')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('质量管理部', '杨信鑫', '01874')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('北京研发结构部', '陈志强', '50061')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('北京研发结构部', '谭东华', '50046')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('北京研发结构部', '刘明', '50063')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('北京研发结构部', '杨吉', '50064')");
		Config::$db->query("insert into $tbJobnum (dept, username, jobnum) values ('北京研发结构部', '关天浪', '50065')");
	}
	
	public function addAddress()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		$tbUser = Config::$tbUser;
		Config::$db->query("alter table $tbJobnum add column address varchar(50) not null");
		Config::$db->query("alter table $tbUser add column address varchar(50) not null");
	}
	
	public function initAddress()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbJobnum set address='深圳'");
		Config::$db->query("update $tbUser set address='深圳'");
	}
	
	public function initAddress2()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60002'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00131'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60708'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00859'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60712'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60268'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00025'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60742'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00674'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60691'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00679'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60631'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60630'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60646'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60640'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60006'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60013'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60698'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60011'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60045'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60629'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60223'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60624'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60689'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60546'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60015'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60695'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60075'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60284'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60350'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60447'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60527'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60525'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60457'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60494'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60495'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60670'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60040'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60020'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60226'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60217'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60336'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60383'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60729'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60598'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60599'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60037'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60131'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60416'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01095'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60309'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60334'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60371'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60144'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60171'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60490'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60536'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60270'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60499'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60501'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60504'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60505'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60512'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60513'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60673'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00436'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60674'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60706'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60436'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60511'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60600'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60344'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60146'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60174'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60200'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60332'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60260'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60278'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60283'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60353'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60227'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60182'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60009'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60022'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60458'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60027'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60065'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60041'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60051'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60096'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60150'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60551'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60455'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60077'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60086'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60253'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60259'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60324'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60151'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60179'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60368'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60380'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60399'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60400'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60426'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60405'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60388'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60446'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60545'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60555'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60616'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60661'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60667'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60437'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60090'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60668'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60596'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60440'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60463'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60464'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60465'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60466'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60572'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60573'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60574'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60741'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60746'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60747'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60575'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60763'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60766'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60017'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60134'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60064'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60724'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60108'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60109'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60118'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60130'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60311'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60517'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60342'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60046'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60105'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60197'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60374'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60247'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60274'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60280'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60292'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60617'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60618'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60321'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60660'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60323'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60360'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60364'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60367'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60369'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60378'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60390'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60391'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60402'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60532'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60432'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60460'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60557'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60563'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60565'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60677'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60678'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60694'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60702'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60470'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60471'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60732'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60688'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60579'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60581'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60582'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60583'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60493'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60410'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60313'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60491'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60701'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60752'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60760'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60771'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60053'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60157'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60036'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60711'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60316'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60119'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60121'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60155'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60203'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60241'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60222'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60273'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60288'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60297'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60303'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60365'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60326'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60335'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60376'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60379'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60386'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60387'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60392'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60394'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60403'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60445'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60413'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60414'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60528'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60529'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60560'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60548'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60620'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60482'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60645'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60647'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60642'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60474'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60475'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60477'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60585'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60586'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60587'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60588'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60589'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60590'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60591'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60592'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60736'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60740'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60737'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60750'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60759'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00669'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60719'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00032'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00717'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60651'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01149'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60613'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60643'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60686'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60699'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60700'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60704'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01029'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01128'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60509'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60521'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60658'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60692'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60716'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00915'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60459'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60652'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60439'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60435'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60606'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60608'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60609'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60718'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60749'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60441'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60004'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00705'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60687'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00396'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60056'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00777'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60614'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60621'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60662'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60731'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60735'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01044'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01072'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60443'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60264'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60366'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60448'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60671'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60481'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60602'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60603'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60604'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60605'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00815'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60720'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60772'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60072'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60611'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60730'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60071'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60540'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60530'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60666'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60488'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60507'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60095'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60235'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00991'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00950'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60568'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60680'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60483'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01096'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01058'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60753'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60770'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60653'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00554'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60665'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60558'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60659'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60690'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00702'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01057'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60444'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60249'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60535'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60544'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60478'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60479'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60480'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60597'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60669'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60199'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60346'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60534'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60610'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60639'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60359'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60058'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60173'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60100'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60218'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60325'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60362'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60425'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60454'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60514'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60725'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60498'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60266'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60300'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60322'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60428'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60496'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60519'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60634'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60685'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60703'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60461'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60462'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60468'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60570'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60571'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60576'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60577'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60578'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60601'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60758'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60769'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60010'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60472'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60723'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60566'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60569'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60580'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60584'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60726'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60637'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60632'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60654'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60656'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60657'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60707'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60522'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60728'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60554'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60754'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60755'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60682'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00639'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60228'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60033'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60099'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60161'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00169'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60520'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60709'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60533'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60526'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60713'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60727'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60710'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60007'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60663'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60595'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60739'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60748'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00022'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60001'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60650'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60271'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00858'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60431'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68059'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60452'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68058'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60751'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60761'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00781'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60008'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60415'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60178'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60641'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60409'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60714'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60743'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60250'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00737'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01038'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60429'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01802'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60195'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60238'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00760'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60304'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01192'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60612'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60556'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60451'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60672'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60449'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60299'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01830'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60767'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60768'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60145'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60003'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60163'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00605'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01557'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01867'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00129'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01246'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01139'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01798'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01808'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01621'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01797'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='61339'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01121'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00809'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01426'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01567'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01333'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01148'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01340'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01799'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='80083'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='80135'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='80089'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='80128'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01820'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01669'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00715'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01331'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01428'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01692'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01247'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01432'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01326'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00543'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00455'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01563'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00460'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01470'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01672'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01558'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01559'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01014'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00784'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00841'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01105'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01466'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01478'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01835'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01871'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01827'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01848'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01675'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01788'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01784'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01258'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68001'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68062'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68066'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68068'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68073'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68072'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68002'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68004'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68005'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68006'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68007'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68010'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68011'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68012'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68013'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68014'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68015'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68016'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68017'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68020'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68022'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68023'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68025'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68026'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68027'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68028'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68029'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68032'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68033'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00964'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01577'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68034'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68075'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68035'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68036'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68045'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68041'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68037'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68040'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68042'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68043'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68065'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68044'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68064'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68038'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68039'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68067'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68071'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68048'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68063'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68061'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68050'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68051'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68052'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68069'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68053'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68054'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68055'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68057'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01477'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00663'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68060'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01588'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01715'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68070'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68076'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68077'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68079'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68080'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01158'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60625'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='68078'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60756'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60762'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01878'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60765'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00022'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50039'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50044'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50043'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50045'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00526'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50040'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50041'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00905'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50056'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50057'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50043'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='50052'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='00605'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01557'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='60669'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01286'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01287'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01288'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01289'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01290'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01868'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01776'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01781'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01291'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01292'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01796'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01293'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01294'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01404'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01296'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01295'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01299'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01300'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01301'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01303'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01298'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01304'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01307'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01311'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01452'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01453'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01461'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01574'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01578'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01579'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01580'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01619'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01620'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01700'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01701'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01703'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01702'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01865'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01866'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01836'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01806'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01803'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01804'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01805'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01807'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01320'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01402'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01777'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01658'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01667'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01778'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01779'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01780'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01837'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01849'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01850'");
		Config::$db->query("update $tbJobnum set address='上海' where jobnum='01851'");
	}
	
	public function initAddress3()
	{
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set address='上海' where jobnum='60002'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00131'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60708'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00859'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60712'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60268'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00025'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60742'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00674'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60691'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00679'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60631'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60630'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60646'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60640'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60006'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60013'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60698'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60011'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60045'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60629'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60223'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60624'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60689'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60546'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60015'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60695'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60075'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60284'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60350'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60447'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60527'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60525'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60457'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60494'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60495'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60670'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60040'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60020'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60226'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60217'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60336'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60383'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60729'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60598'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60599'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60037'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60131'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60416'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01095'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60309'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60334'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60371'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60144'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60171'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60490'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60536'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60270'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60499'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60501'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60504'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60505'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60512'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60513'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60673'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00436'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60674'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60706'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60436'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60511'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60600'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60344'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60146'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60174'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60200'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60332'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60260'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60278'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60283'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60353'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60227'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60182'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60009'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60022'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60458'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60027'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60065'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60041'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60051'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60096'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60150'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60551'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60455'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60077'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60086'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60253'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60259'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60324'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60151'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60179'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60368'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60380'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60399'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60400'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60426'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60405'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60388'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60446'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60545'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60555'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60616'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60661'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60667'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60437'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60090'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60668'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60596'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60440'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60463'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60464'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60465'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60466'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60572'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60573'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60574'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60741'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60746'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60747'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60575'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60763'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60766'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60017'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60134'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60064'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60724'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60108'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60109'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60118'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60130'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60311'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60517'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60342'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60046'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60105'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60197'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60374'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60247'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60274'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60280'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60292'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60617'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60618'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60321'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60660'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60323'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60360'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60364'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60367'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60369'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60378'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60390'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60391'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60402'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60532'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60432'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60460'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60557'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60563'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60565'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60677'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60678'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60694'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60702'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60470'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60471'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60732'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60688'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60579'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60581'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60582'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60583'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60493'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60410'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60313'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60491'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60701'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60752'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60760'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60771'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60053'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60157'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60036'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60711'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60316'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60119'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60121'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60155'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60203'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60241'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60222'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60273'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60288'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60297'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60303'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60365'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60326'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60335'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60376'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60379'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60386'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60387'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60392'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60394'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60403'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60445'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60413'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60414'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60528'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60529'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60560'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60548'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60620'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60482'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60645'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60647'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60642'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60474'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60475'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60477'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60585'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60586'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60587'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60588'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60589'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60590'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60591'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60592'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60736'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60740'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60737'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60750'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60759'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00669'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60719'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00032'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00717'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60651'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01149'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60613'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60643'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60686'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60699'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60700'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60704'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01029'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01128'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60509'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60521'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60658'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60692'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60716'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00915'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60459'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60652'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60439'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60435'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60606'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60608'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60609'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60718'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60749'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60441'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60004'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00705'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60687'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00396'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60056'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00777'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60614'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60621'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60662'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60731'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60735'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01044'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01072'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60443'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60264'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60366'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60448'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60671'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60481'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60602'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60603'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60604'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60605'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00815'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60720'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60772'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60072'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60611'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60730'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60071'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60540'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60530'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60666'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60488'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60507'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60095'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60235'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00991'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00950'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60568'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60680'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60483'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01096'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01058'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60753'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60770'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60653'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00554'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60665'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60558'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60659'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60690'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00702'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01057'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60444'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60249'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60535'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60544'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60478'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60479'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60480'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60597'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60669'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60199'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60346'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60534'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60610'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60639'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60359'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60058'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60173'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60100'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60218'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60325'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60362'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60425'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60454'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60514'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60725'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60498'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60266'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60300'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60322'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60428'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60496'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60519'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60634'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60685'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60703'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60461'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60462'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60468'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60570'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60571'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60576'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60577'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60578'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60601'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60758'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60769'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60010'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60472'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60723'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60566'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60569'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60580'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60584'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60726'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60637'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60632'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60654'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60656'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60657'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60707'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60522'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60728'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60554'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60754'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60755'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60682'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00639'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60228'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60033'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60099'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60161'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00169'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60520'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60709'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60533'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60526'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60713'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60727'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60710'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60007'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60663'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60595'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60739'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60748'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00022'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60001'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60650'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60271'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00858'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60431'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68059'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60452'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68058'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60751'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60761'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00781'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60008'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60415'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60178'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60641'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60409'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60714'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60743'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60250'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00737'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01038'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60429'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01802'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60195'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60238'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00760'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60304'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01192'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60612'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60556'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60451'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60672'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60449'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60299'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01830'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60767'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60768'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60145'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60003'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60163'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00605'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01557'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01867'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00129'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01246'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01139'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01798'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01808'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01621'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01797'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='61339'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01121'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00809'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01426'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01567'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01333'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01148'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01340'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01799'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='80083'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='80135'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='80089'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='80128'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01820'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01669'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00715'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01331'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01428'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01692'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01247'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01432'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01326'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00543'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00455'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01563'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00460'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01470'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01672'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01558'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01559'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01014'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00784'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00841'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01105'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01466'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01478'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01835'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01871'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01827'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01848'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01675'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01788'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01784'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01258'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68001'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68062'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68066'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68068'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68073'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68072'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68002'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68004'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68005'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68006'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68007'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68010'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68011'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68012'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68013'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68014'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68015'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68016'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68017'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68020'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68022'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68023'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68025'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68026'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68027'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68028'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68029'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68032'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68033'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00964'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01577'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68034'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68075'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68035'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68036'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68045'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68041'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68037'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68040'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68042'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68043'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68065'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68044'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68064'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68038'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68039'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68067'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68071'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68048'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68063'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68061'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68050'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68051'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68052'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68069'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68053'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68054'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68055'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68057'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01477'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00663'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68060'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01588'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01715'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68070'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68076'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68077'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68079'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68080'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01158'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60625'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='68078'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60756'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60762'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01878'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60765'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00022'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50039'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50044'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50043'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50045'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00526'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50040'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50041'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00905'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50056'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50057'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50043'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='50052'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='00605'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01557'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='60669'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01286'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01287'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01288'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01289'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01290'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01868'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01776'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01781'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01291'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01292'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01796'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01293'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01294'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01404'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01296'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01295'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01299'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01300'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01301'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01303'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01298'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01304'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01307'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01311'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01452'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01453'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01461'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01574'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01578'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01579'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01580'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01619'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01620'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01700'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01701'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01703'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01702'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01865'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01866'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01836'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01806'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01803'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01804'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01805'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01807'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01320'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01402'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01777'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01658'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01667'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01778'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01779'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01780'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01837'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01849'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01850'");
		Config::$db->query("update $tbUser set address='上海' where jobnum='01851'");
	}
	
	/**
	 * 生成随机码
	 */
	public function genCode()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		for ($i = 0; $i < 10; $i++)
		{
			$rnd = rand(10000000, 99999999);
			$sqlRnd = Security::varSql($rnd);
			Config::$db->query("select id from $tbZpZhongJiang where lucky_code=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
	
	public function getDept($jobnum, $username)
	{
		if (empty($jobnum) || empty($username))
		{
			return '';
		}
		Config::$db->connect();
		$tbJobnum = Config::$tbJobnum;
		$sqlJobnum = Security::varSql($jobnum);
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select dept from $tbJobnum where jobnum=$sqlJobnum and username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return '';
		}
		else
		{
			return $res['dept'];
		}
	}
	
	public function getProfile($openId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbUser where open_id=$sqlOpenId");
		$res = Config::$db->getRow();
		return $res;
	}
	
	public function addUser($openId, $jobnum, $username, $dept)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlOpenId = Security::varSql($openId);
		$sqlJobnum = Security::varSql($jobnum);
		$sqlUsername = Security::varSql($username);
		$sqlDept = Security::varSql($dept);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, jobnum, dept, open_id, register_date) values ($sqlUsername, $sqlJobnum, $sqlDept, $sqlOpenId, $sqlDate)");
	}
	
	public function existUser($openId, $jobnum)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlOpenId = Security::varSql($openId);
		$sqlJobnum = Security::varSql($jobnum);
		Config::$db->query("select id from $tbUser where open_id=$sqlOpenId or jobnum=$sqlJobnum");
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
	
	public function getAllWinner()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.jobnum as jobnum, user.username as username, user.dept as dept, user.address as address, zj.prize_id as prize_id, zj.lucky_date as lucky_date from $tbZpZhongJiang as zj join $tbUser as user on zj.open_id=user.open_id order by zj.id");
		return Config::$db->getAllRows();
	}
	
	public function getAllUsers()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser order by id");
		return Config::$db->getAllRows();
	}
	
	public function getAllDaily()
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		Config::$db->query("select * from $tbZpDaily order by id");
		return Config::$db->getAllRows();
	}
}
new MainController();
?>
