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
			return true;
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
			$tableInfo['records'] = $this->install->getRecords($tbName, 0, 100000);
			$_tableList[] = $tableInfo;
		}
		$this->showDb($_tableList);
	}
	
	/**
	 * 查看数据库数据
	 */
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
 * 游戏后台控制器
 * @author Shines
 */
class AdminGameController
{
	private $admin = null;
	private $game = null;
	private $zhuanPan = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->game = new Game();
		$this->zhuanPan = new ZhuanPan();
		switch ($action)
		{
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
			case 'exportUser':
				if ($this->admin->checkLogin())
				{
					$this->exportUser();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
		}
	}
	
	private function dataCount()
	{
		$users = $this->game->getUserByPage(1, 1000000);
		$dayList = array();
		$totalUser = 0;
		$totalPlay = 0;
		$totalAnswer = 0;
		
		foreach ($users as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['regtime']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['answerNum'] = 0;
			}
			$dayList[$date]['userNum']++;
			$totalUser++;
			if ($value['isplayed'] == 1)
			{
				$dayList[$date]['answerNum']++;
				$totalAnswer++;
			}
		}
		include(Config::$viewDir . 'admin_game/count.php');
	}
	
	private function exportUser()
	{
		$this->game->exportUser();
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
	
	private function winner()
	{
		$winner = $this->zhuanPan->getAllWinner();
		include(Config::$viewDir . 'admin_game/winner.php');
	}
}

/**
 * 游戏控制器
 * @author Shines
 */
class GameController
{
	private $game = null;
	private $fb = null;
	private $zhuanPan = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->game = new Game();
		$this->fb = new Fb();
		$this->zhuanPan = new ZhuanPan();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'main':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$isPlayed = $this->game->checkPlayed($this->fbid);
					if ($isPlayed)
					{
						$this->showLucky();
					}
					else
					{
						$this->showMain();
					}
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'lucky':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showLucky();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'doAnswer':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doAnswer();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'doLucky':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doLucky();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			default:
				$this->showLogin();
		}
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin()
	{
		$shareId = substr(trim(Security::varGet('shareId')), 0, 100);
		if (Config::$isFb)
		{
			if ($this->fb->checkLogin())
			{
				$this->fbid = $this->fb->getUserId();
				if ($this->game->existUser($this->fbid))
				{
					return true;
				}
			}
			
			$this->fb->initToken();
			$me = $this->fb->me();
			if ($me['code'] == 0)
			{
				$this->fbid = $this->fb->getUserId();
				if (empty($this->fbid))
				{
					return false;
				}
				else
				{
					if (!$this->game->existUser($this->fbid))
					{
						$this->game->addUser($this->fbid, $me['userProfile'], $shareId);
					}
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->loginLocal($shareId);
			return true;
		}
	}
	
	private function loginLocal($shareId)
	{
		$this->fbid = System::getSession('userTestFbid');
		if (empty($this->fbid))
		{
			$this->fbid = $this->genFbid();
		}
		if (!$this->game->existUser($this->fbid))
		{
			$username = array('Kity', 'Bruce', 'David', 'Kevin', 'Nancy');
			$photo = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg');
			$gender = array('female', 'male', 'male', 'male', 'female');
			$rand = rand(0, 4);
			$userProfile = array(
				'name' => $username[$rand] . rand(1000, 9999),
				'photo' => 'images/photo/' . $photo[$rand],
				'email' => 'test@test.com',
				'gender' => $gender[$rand]
			);
			$this->game->addUser($this->fbid, $userProfile, $shareId);
		}
	}
	
	private function genFbid()
	{
		$fbid = rand(10000000, 99999999);
		System::setSession('userTestFbid', $fbid);
		return $fbid;
	}
	
	private function showLogin()
	{
		$shareId = substr(trim(Security::varGet('shareId')), 0, 100);
		if (Config::$isFb)
		{
			Config::$siteUrl .= '&shareId=' . $shareId;
			$loginUrl = $this->fb->getLoginUrl();
		}
		else
		{
			if (Config::$deviceType == 'mobile')
			{
				$loginUrl = './?a=main&d=mobile&shareId=' . $shareId;
			}
			else
			{
				$loginUrl = './?a=main&shareId=' . $shareId;
			}
		}
		include(Config::$viewDir . 'login.php');
	}
	
	private function showMain()
	{
		Config::$shareUrl .= $this->fbid;
		include(Config::$viewDir . 'main.php');
	}
	
	private function showLucky()
	{
		Config::$shareUrl .= $this->fbid;
		$restLucky = $this->game->getRestLucky($this->fbid);
		$prizeId = $this->zhuanPan->getMyPrizeId($this->fbid);
		include(Config::$viewDir . 'lucky.php');
	}
	
	private function doAnswer()
	{
		System::fixSubmit('doAnswer');
		if ($this->game->checkPlayed($this->fbid))
		{
			System::echoData(Config::$msg['played']);
			return;
		}
		
		$q1 = (int)Security::varPost('q1');
		$q2 = (int)Security::varPost('q2');
		$q3 = (int)Security::varPost('q3');
		$q4 = (int)Security::varPost('q4');
		$q5 = (int)Security::varPost('q5');
		$q6 = (int)Security::varPost('q6');
		$q7 = (int)Security::varPost('q7');
		$q4f = trim(Security::varPost('q4f'));
		$q5f = trim(Security::varPost('q5f'));
		$q6f = trim(Security::varPost('q6f'));
		
		if (($q1 >= 1 && $q1 <=2) && ($q2 >= 1 && $q2 <=4) && ($q3 >= 1 && $q3 <=5) && ($q4 >= 1 && $q4 <=6) && ($q5 >= 1 && $q5 <=5) && ($q6 >= 1 && $q6 <=5) && ($q7 >= 1 && $q7 <=2))
		{
			if ($q4 != 6)
			{
				$q4f = '';
			}
			if ($q5 != 5)
			{
				$q5f = '';
			}
			if ($q6 != 5)
			{
				$q6f = '';
			}
			$this->game->setAnswer($this->fbid, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q4f, $q5f, $q6f);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['inputError']);
		}
	}
	
	private function doLucky()
	{
		System::fixSubmit('doLucky');
		$restLucky = $this->game->getRestLucky($this->fbid);
		if ($restLucky > 0)
		{
			$this->game->reduceRestLucky($this->fbid);
			$win = $this->zhuanPan->lucky($this->fbid);
			$prizeId = $win['prizeId'];
			$prizeName = $win['prizeName'];
			$luckyCode = $win['luckyCode'];
			System::echoData(Config::$msg['ok'], array('prizeId' => $prizeId, 'restLucky' => $restLucky - 1));
		}
		else
		{
			System::echoData(Config::$msg['ok'], array('prizeId' => 0, 'restLucky' => 0));
		}
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
			case 'adminGame':
				new AdminGameController();
				break;
			default:
				new GameController();
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
	public static $configType = 2;//配置方案。1：local，2：喀麦隆
	public static $isLocal = false;//是否为本地模式
	public static $deviceType = '';//设备类型，pc，mobile
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
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	
	public static $db = null;//数据库
	public static $tbAdmin = 'itelsurvey_admin';//管理员表
	public static $tbUser = 'itelsurvey_user';//用户表
	public static $tbAnswer = 'itelsurvey_answer';//答题表
	public static $tbZpJiangChi = 'itelsurvey_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'itelsurvey_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'itelsurvey_zp_daily';//转盘每日抽奖表
	
	//各国家单独配置参数
	public static $systemName = '';//系统名称
	public static $key = '';//密钥
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = '';//资源文件地址
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $dailyPagesize = 0;
	public static $rankPagesize = 0;//排行榜每页显示排名个数
	public static $inviteScore = 0;//邀请好友获得金币数
	public static $maxDailyScore = 0;
	public static $minDailyScore = 0;
	public static $adminUserPagesize = 0;
	public static $chanceScore = 0;
	public static $winnerPagesize = 0;
	public static $maxPrize = 0;//最大奖品数
	public static $prizeName = null;//奖品名称
	public static $prizeMoney = null;//奖品名称
	public static $adminNewsPagesize = 0;//新闻管理每页显示新闻条数
	public static $newsPagesize = 0;//前端每页显示新闻条数
	public static $maxContent = 0;//最大新闻长度
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	public static $isFb = false;//是否调用facebook接口
	public static $fbAppId = '';//facebook app id
	public static $fbAppKey = '';//facebook app key
	public static $fbAppRedirectUrl = '';//facebook app跳转地址
	public static $fbAppUrl = '';//facebook app地址
	public static $siteUrl = '';
	public static $shareUrl = '';
	public static $sharePic = '';
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $countCode = '';//统计代码
	public static $msg = null;//操作提示
	
	//本地数据库配置信息
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
	);
	
	//肯尼亚数据库配置信息
	private static $dbCm = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
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
				self::$systemName = 'itelsurvey';//系统名称
				self::$key = 'f1.f2fitelsurvey123ini.1ab';//密钥
				self::$baseUrl = 'http://localhost:8009';//当前网址，线上或本地
				self::$resUrl = '';//资源文件地址
				self::$newsEnabled = false;//新闻开关
				self::$zhuanPanEnabled = false;//转盘开关
				self::$hongBaoEnabled = false;//红包开关
				self::$dailyPagesize = 5;
				self::$rankPagesize = 5;//排行榜每页显示排名个数
				self::$inviteScore = 20000;//邀请好友获得金币数
				self::$maxDailyScore = 900000;
				self::$minDailyScore = 15000;
				self::$adminUserPagesize = 50;
				self::$chanceScore = 100000;
				self::$winnerPagesize = 5;
				self::$maxPrize = 10;//最大奖品数
				self::$prizeName = array('it1505', 'it1407', 'itel Umbrella', 'Tshirt', 'Selfie Stick', '', '', '', '', '');
				self::$prizeMoney = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//奖品名称
				self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
				self::$newsPagesize = 100;//前端每页显示新闻条数
				self::$maxContent = 10000;//最大新闻长度
				self::$wxAppId = '';//微信app id
				self::$wxAppSecret = '';//微信app secret
				self::$isFb = false;//是否调用facebook接口
				self::$fbAppId = '';//facebook app id
				self::$fbAppKey = '';//facebook app key
				self::$fbAppRedirectUrl = 'https://localhost:8009/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/itelsurvey/';//facebook app地址
				self::$siteUrl = 'http://localhost:8009/?a=main';
				self::$shareUrl = 'http://localhost:8009/?shareId=';
				self::$sharePic = 'http://localhost:8009/images/share.jpg';
				self::$dbConfig = self::$dbLocal;//数据库配置信息，线上或本地
				self::$countCode = '';//统计代码
				self::$msg = array
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
					
					//新闻
					'contentLong' => array('code' => 102001, 'msg' => '内容过长！'),
					
					//转盘抽奖
					'licked' => array('code' => 103001, 'msg' => '已经点击过了！'),
					'deptUsernameEmpty' => array('code' => 103002, 'msg' => '部门和姓名不能为空！'),
					'submitRepeat' => array('code' => 103003, 'msg' => '请勿重复提交！'),
					
					//抢红包
					'jobnumUsernameEmpty' => array('code' => 104001, 'msg' => '工号和姓名不能为空！'),
					'jobnumUsernameError' => array('code' => 104002, 'msg' => '工号或姓名不正确！'),
					'jobnumBinded' => array('code' => 104003, 'msg' => '该工号已被绑定过了！'),
					'wxNumBinded' => array('code' => 104004, 'msg' => '该微信号已经绑定过工号了！'),
					'RequestError' => array('code' => 104005, 'msg' => 'Request Error!'),
					
					//itel调研
					'played' => array('code' => 105001, 'msg' => 'Played!'),
					'inputError' => array('code' => 105002, 'msg' => 'Input Error!')
				);//操作提示
				break;
			case 2:
				//喀麦隆
				@date_default_timezone_set('Etc/GMT-1');
				self::$systemName = 'itelsurvey';//系统名称
				self::$key = '1.23f1itelsurvey.d.,b1a3';//密钥
				self::$baseUrl = 'http://www.itel-mobile.com/survey';//当前网址，线上或本地
				self::$resUrl = '';//资源文件地址
				self::$newsEnabled = false;//新闻开关
				self::$zhuanPanEnabled = false;//转盘开关
				self::$hongBaoEnabled = false;//红包开关
				self::$dailyPagesize = 5;
				self::$rankPagesize = 5;//排行榜每页显示排名个数
				self::$inviteScore = 20000;//邀请好友获得金币数
				self::$maxDailyScore = 900000;
				self::$minDailyScore = 15000;
				self::$adminUserPagesize = 50;
				self::$chanceScore = 100000;
				self::$winnerPagesize = 5;
				self::$maxPrize = 10;//最大奖品数
				self::$prizeName = array('it1505', 'it1407', 'itel Umbrella', 'Tshirt', 'Selfie Stick', '', '', '', '', '');//奖品名称
				self::$prizeMoney = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//奖品名称
				self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
				self::$newsPagesize = 100;//前端每页显示新闻条数
				self::$maxContent = 10000;//最大新闻长度
				self::$wxAppId = '';//微信app id
				self::$wxAppSecret = '';//微信app secret
				self::$isFb = true;//是否调用facebook接口
				self::$fbAppId = '1217959848219350';//facebook app id
				self::$fbAppKey = '1a7fd4a7e75167109940cafcb23fade4';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.itel-mobile.com/survey/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/itelsurvey/';//facebook app地址
				self::$siteUrl = 'http://www.itel-mobile.com/survey/?a=main';
				self::$shareUrl = 'http://www.itel-mobile.com/survey/?shareId=';
				self::$sharePic = 'http://www.itel-mobile.com/survey/images/share.jpg';
				self::$dbConfig = self::$dbCm;//数据库配置信息，线上或本地
				self::$countCode = '';//统计代码
				self::$msg = array
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
					
					//新闻
					'contentLong' => array('code' => 102001, 'msg' => '内容过长！'),
					
					//转盘抽奖
					'licked' => array('code' => 103001, 'msg' => '已经点击过了！'),
					'deptUsernameEmpty' => array('code' => 103002, 'msg' => '部门和姓名不能为空！'),
					'submitRepeat' => array('code' => 103003, 'msg' => '请勿重复提交！'),
					
					//抢红包
					'jobnumUsernameEmpty' => array('code' => 104001, 'msg' => '工号和姓名不能为空！'),
					'jobnumUsernameError' => array('code' => 104002, 'msg' => '工号或姓名不正确！'),
					'jobnumBinded' => array('code' => 104003, 'msg' => '该工号已被绑定过了！'),
					'wxNumBinded' => array('code' => 104004, 'msg' => '该微信号已经绑定过工号了！'),
					'RequestError' => array('code' => 104005, 'msg' => 'Request Error!'),
					
					//itel调研
					'played' => array('code' => 105001, 'msg' => 'Played Today!'),
					'inputError' => array('code' => 105002, 'msg' => 'Input Error!'),
					'played' => array('code' => 105003, 'msg' => 'Played!')
				);//操作提示
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
	}
}

/**
 *	Facebook操作
 */
class Fb
{
	private $facebook = null;
	private $token = '';
	
	public function __construct()
	{
		if (!Config::$isFb)
		{
			return;
		}
		
		require_once('extends/facebook4.5/autoload.php');
		$this->facebook = new Facebook\Facebook([
			'app_id' => Config::$fbAppId,
			'app_secret' => Config::$fbAppKey,
			'default_graph_version' => 'v2.4',
		]);
	}
	
	function getLoginUrl()
	{
		$helper = $this->facebook->getRedirectLoginHelper();
		//$permissions = ['email', 'public_profile', 'user_friends']; // optional
		$permissions = ['public_profile', 'email']; // optional
		$loginUrl = $helper->getLoginUrl(Config::$siteUrl, $permissions);
		return $loginUrl;
	}
	
	public function checkLogin()
	{
		$token = $this->getToken();
		$userId = $this->getUserId();
		return !empty($token) && !empty($userId);
	}
	
	public function initToken()
	{
		$this->token = $this->getToken();
		if (empty($this->token))
		{
			$helper = $this->facebook->getRedirectLoginHelper();
			try {
				$this->token = $helper->getAccessToken();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				//echo 'Graph returned an error: ' . $e->getMessage();
				//exit;
				$this->token = '';
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				//echo 'Facebook SDK returned an error: ' . $e->getMessage();
				//exit;
				$this->token = '';
			}
			$this->setToken($this->token);
			
			/*
			// OAuth 2.0 client handler
			$oAuth2Client = $this->facebook->getOAuth2Client();
			// Exchanges a short-lived access token for a long-lived one
			$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($this->token);
			*/
		}
	}
	
	public function me()
	{
		if (empty($this->token))
		{
			return array('code' => 1, 'userProfile' => null);
		}
		
		//$this->facebook->setDefaultAccessToken($this->token);
		try {
			$response = $this->facebook->get('/me?fields=id,name,email,gender', $this->token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			//echo 'Graph returned an error: ' . $e->getMessage();
			//exit;
			return array('code' => 1, 'userProfile' => null);
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			//echo 'Facebook SDK returned an error: ' . $e->getMessage();
			//exit;
			return array('code' => 1, 'userProfile' => null);
		}
		$userProfile = $response->getGraphUser();
		$this->setUserId($userProfile['id']);
		return array('code' => 0, 'userProfile' => $userProfile);
	}
	
	private function getToken()
	{
		$token = isset($_SESSION[Config::$systemName . '_facebookToken']) ? $_SESSION[Config::$systemName . '_facebookToken'] : '';
		return (string)$token;
	}
	
	private function setToken($value)
	{
		$_SESSION[Config::$systemName . '_facebookToken'] = (string)$value;
	}
	
	public function getUserId()
	{
		$userId = isset($_SESSION[Config::$systemName . '_facebookUserId']) ? $_SESSION[Config::$systemName . '_facebookUserId'] : '';
		return (string)$userId;
	}
	
	public function setUserId($value)
	{
		$_SESSION[Config::$systemName . '_facebookUserId'] = (string)$value;
	}
}

/**
 * 游戏
 * @author Shines
 */
class Game
{
	public function __construct()
	{
	}
	
	public function getProfile($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where fbid=$sqlFbid");
		return Config::$db->getRow();
	}
	
	/**
	 * 检测用户是否存在
	 */
	public function existUser($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
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
	 * 添加用户
	 */
	public function addUser($fbid, $userProfile)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$username = isset($userProfile['name']) ? $userProfile['name'] : '';
		if (Config::$isFb)
		{
			$photo = 'https://graph.facebook.com/' . $fbid . '/picture?width=330&height=330';
		}
		else
		{
			$photo = isset($userProfile['photo']) ? $userProfile['photo'] : '';
		}
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$regtime = Utils::mdate('Y-m-d H:i:s');
		switch (Config::$deviceType)
		{
			case 'mobile':
				$logintype = 2;
				break;
			default:
				$logintype = 1;
		}
		$ip = Utils::getClientIp();
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlPhoto = Security::varSql($photo);
		$sqlEmail = Security::varSql($email);
		$sqlGender = Security::varSql($gender);
		$sqlRegtime = Security::varSql($regtime);
		$sqlLogintype = (int)$logintype;
		$sqlIp = Security::varSql($ip);
		Config::$db->query("insert into $tbUser (fbid, username, photo, email, gender, regtime, logintype, ip) values ($sqlFbid, $sqlUsername, $sqlPhoto, $sqlEmail, $sqlGender, $sqlRegtime, $sqlLogintype, $sqlIp)");
	}
	
	public function getUserByPage($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser order by id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countUser()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select count(*) as num from $tbUser");
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
	
	/**
	 * 导出用户数据到Excel
	 */
	public function exportUser()
	{
		require_once('extends/PHPExcel_1.8.0/PHPExcel.php');
		$excel = new PHPExcel();
		//设置文件的详细信息
		$excel->getProperties()->setCreator("Administrators")
			->setLastModifiedBy("Administrators")
			->setTitle("Data")
			->setSubject("")
			->setDescription("")
			->setKeywords("")
			->setCategory("");
		
		//操作第一个工作表
		$excel->setActiveSheetIndex(0);
		//设置工作薄名称
		$excel->getActiveSheet()->setTitle('Data');
		//设置默认字体和大小
		$excel->getDefaultStyle()->getFont()->setName('Times New Roman');
		$excel->getDefaultStyle()->getFont()->setSize(14);
		
		//设置列宽度
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
		
		/*
		//设置行高度
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(169);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(60);
		*/
		
		//设置水平居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('J')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('K')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('L')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('M')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('N')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		/*
		//合并单元格
		$excel->getActiveSheet()->mergeCells('A1:D1');
		*/
		
		/*
		//给单元格中放入图片
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('images/test.png');
		$objDrawing->setWidth(148);
		$objDrawing->setHeight(169);
		$objDrawing->setCoordinates('D2');
		$objDrawing->setWorksheet($excel->getActiveSheet());
		*/
		
		//设置单元格数据
		$excel->getActiveSheet()
			->setCellValue('A1', 'Name')
			->setCellValue('B1', 'Gender')
			->setCellValue('C1', 'Email')
			->setCellValue('D1', 'Register Date')
			->setCellValue('E1', 'Q1')
			->setCellValue('F1', 'Q2')
			->setCellValue('G1', 'Q3')
			->setCellValue('H1', 'Q4')
			->setCellValue('I1', 'QS4')
			->setCellValue('J1', 'Q5')
			->setCellValue('K1', 'QS5')
			->setCellValue('L1', 'Q6')
			->setCellValue('M1', 'QS6')
			->setCellValue('N1', 'Q7');
		
		$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$res = $this->getAnswerData();
		$rowIndex = 2;
		foreach ($res as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['gender'])
				->setCellValue('C' . $rowIndex, $row['email'])
				->setCellValue('D' . $rowIndex, $row['regtime'])
				->setCellValue('E' . $rowIndex, $row['q1'])
				->setCellValue('F' . $rowIndex, $row['q2'])
				->setCellValue('G' . $rowIndex, $row['q3'])
				->setCellValue('H' . $rowIndex, $row['q4'])
				->setCellValue('I' . $rowIndex, $row['q4f'])
				->setCellValue('J' . $rowIndex, $row['q5'])
				->setCellValue('K' . $rowIndex, $row['q5f'])
				->setCellValue('L' . $rowIndex, $row['q6'])
				->setCellValue('M' . $rowIndex, $row['q6f'])
				->setCellValue('N' . $rowIndex, $row['q7']);
			$excel->getActiveSheet()->getRowDimension($rowIndex)->setRowHeight(30);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$filename = 'survey_' . Utils::mdate('Y.m.d') . '.xls';
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			//从浏览器直接输出$filename
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/vnd.ms-excel;");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
		else if ('pdf' == $fileFormat)
		{
			//输出PDF格式
			$filename = 'survey_' . Utils::mdate('Y.m.d') . '.pdf';
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'PDF');
			$objWriter->setSheetIndex(0);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/pdf");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
	}
	
	public function checkPlayed($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select isplayed from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			if ($res['isplayed'] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function setAnswer($fbid, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q4f, $q5f, $q6f)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$sqlQ1 = (int)$q1;
		$sqlQ2 = (int)$q2;
		$sqlQ3 = (int)$q3;
		$sqlQ4 = (int)$q4;
		$sqlQ5 = (int)$q5;
		$sqlQ6 = (int)$q6;
		$sqlQ7 = (int)$q7;
		$sqlQ4f = Security::varSql($q4f);
		$sqlQ5f = Security::varSql($q5f);
		$sqlQ6f = Security::varSql($q6f);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		
		$tbAnswer = Config::$tbAnswer;
		$tbUser = Config::$tbUser;
		Config::$db->query("insert into $tbAnswer (fbid, type, q1, q2, q3, q4, q5, q6, q7, q4f, q5f, q6f) values($sqlFbid, 1, $sqlQ1, $sqlQ2, $sqlQ3, $sqlQ4, $sqlQ5, $sqlQ6, $sqlQ7, $sqlQ4f, $sqlQ5f, $sqlQ6f)");
		Config::$db->query("update $tbUser set isplayed=1, lastplay=$sqlDate, restLucky=1 where fbid=$sqlFbid");
	}
	
	public function getRestLucky($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select restLucky from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['restLucky'];
		}
	}
	
	public function reduceRestLucky($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set restLucky=restLucky-1 where fbid=$sqlFbid");
	}
	
	public function getAnswerData()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbAnswer = Config::$tbAnswer;
		Config::$db->query("select 
			user.fbid as fbid,
			user.username as username,
			user.gender as gender,
			user.email as email,
			user.regtime as regtime,
			answer.q1 as q1,
			answer.q2 as q2,
			answer.q3 as q3,
			answer.q4 as q4,
			answer.q5 as q5,
			answer.q6 as q6,
			answer.q7 as q7,
			answer.q4f as q4f,
			answer.q5f as q5f,
			answer.q6f as q6f
			from $tbUser as user join $tbAnswer as answer on user.fbid = answer.fbid
			order by user.id");
		$res = Config::$db->getAllRows();
		return $res;
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
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		$tbAnswer = Config::$tbAnswer;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			username varchar(50) not null,
			photo varchar(256) not null,
			email varchar(320) not null,
			gender varchar(50) not null,
			regtime datetime not null,
			logintype int not null,
			ip varchar(32) not null,
			isplayed tinyint not null,
			lastplay datetime not null,
			restLucky int not null,
			index (fbid)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbZpJiangChi");
		Config::$db->query("create table $tbZpJiangChi (
			id int not null auto_increment primary key,
			prizedate date not null,
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
			prize10 int not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpZhongJiang");
		Config::$db->query("create table $tbZpZhongJiang (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			prizeid int not null,
			luckycode varchar(50) not null,
			luckydate datetime not null,
			index (fbid),
			index (luckycode)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpDaily");
		Config::$db->query("create table $tbZpDaily (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			luckydate datetime not null,
			index (fbid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbAnswer");
		Config::$db->query("create table $tbAnswer (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			type int not null,
			q1 int not null,
			q2 int not null,
			q3 int not null,
			q4 int not null,
			q5 int not null,
			q6 int not null,
			q7 int not null,
			q8 int not null,
			q9 int not null,
			q10 int not null,
			q11 int not null,
			q12 int not null,
			q13 int not null,
			q14 int not null,
			q15 int not null,
			q16 int not null,
			q17 int not null,
			q18 int not null,
			q19 int not null,
			q20 int not null,
			q21 int not null,
			q22 int not null,
			q23 int not null,
			q24 int not null,
			q25 int not null,
			q26 int not null,
			q27 int not null,
			q28 int not null,
			q29 int not null,
			q30 int not null,
			q1f varchar(200) not null,
			q2f varchar(200) not null,
			q3f varchar(200) not null,
			q4f varchar(200) not null,
			q5f varchar(200) not null,
			q6f varchar(200) not null,
			q7f varchar(200) not null,
			q8f varchar(200) not null,
			q9f varchar(200) not null,
			q10f varchar(200) not null,
			q11f varchar(200) not null,
			q12f varchar(200) not null,
			q13f varchar(200) not null,
			q14f varchar(200) not null,
			q15f varchar(200) not null,
			q16f varchar(200) not null,
			q17f varchar(200) not null,
			q18f varchar(200) not null,
			q19f varchar(200) not null,
			q20f varchar(200) not null,
			q21f varchar(200) not null,
			q22f varchar(200) not null,
			q23f varchar(200) not null,
			q24f varchar(200) not null,
			q25f varchar(200) not null,
			q26f varchar(200) not null,
			q27f varchar(200) not null,
			q28f varchar(200) not null,
			q29f varchar(200) not null,
			q30f varchar(200) not null,
			index (fbid)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
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
		$zhuanPan = new ZhuanPan();
		$zhuanPan->initPrize();
		return;
		
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		$tbAnswer = Config::$tbAnswer;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		//Config::$db->query("delete from $tbZpJiangChi");
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
		
		//中过奖的不再中奖
		$win = $this->checkWin($openId);
		$prizeId = $win['prizeId'];
		if ($prizeId > 0)
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbZpJiangChi where prizedate=$sqlDate");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
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
					$this->joinPrize(10, $res['prize10'])
				);
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
	 * 检测是否中过奖
	 */
	public function checkWin($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbZpZhongJiang where fbid=$sqlOpenId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prizeid'], 'prizeName' => Config::$prizeName[$res['prizeid'] - 1], 'luckyCode' => $res['luckycode']);
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
		Config::$db->query("insert into $tbZpDaily (fbid, luckydate) values ($sqlOpenId, $sqlDate)");
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
			Config::$db->query("update $tbZpJiangChi set $fieldName=$fieldName-1 where prizedate=$sqlDate");
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
			Config::$db->query("insert into $tbZpZhongJiang (fbid, prizeid, luckycode, luckydate) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
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
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-26', 20, 0, 1, 1, 0, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-27', 20, 0, 0, 1, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-28', 20, 1, 0, 0, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-29', 20, 0, 1, 1, 1, 0)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-30', 20, 0, 0, 1, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-31', 20, 0, 0, 1, 1, 1)");
		
		Config::$db->query("select * from $tbZpJiangChi");
		$res = Config::$db->getAllRows();
		$num = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$total = 0;
		foreach ($res as $value)
		{
			for ($i = 1; $i <= 10; $i++)
			{
				$num[$i - 1] += $value['prize' . $i];
				$total += $value['prize' . $i];
			}
		}
		Utils::dump($num);
		echo '<br />total: ' . $total . '<br /><br />';
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
			Config::$db->query("select id from $tbZpZhongJiang where luckycode=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
	
	public function getWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id desc");
		return Config::$db->getAllRows();
	}
	
	public function getWinnerByPage($page)
	{
		Config::$db->connect();
		$page = (int)$page;
		if ($page < 1)
		{
			$page = 1;
		}
		$pagesize = Config::$winnerPagesize;
		$from = ($page - 1) * $pagesize;
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function getWinnerCount()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select count(*) as num from $tbZpZhongJiang");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return (int)$res['num'];
		}
		else
		{
			return 0;
		}
	}
	
	public function getAllWinner()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.email as email, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id");
		return Config::$db->getAllRows();
	}
	
	public function getMyPrize($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select prizeid from $tbZpZhongJiang where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$prizeId = (int)$res['prizeid'];
			return Config::$prizeName[$prizeId - 1];
		}
		else
		{
			return 'No Prize';
		}
	}
	
	public function getMyPrizeId($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select prizeid from $tbZpZhongJiang where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$prizeId = (int)$res['prizeid'];
			return $prizeId;
		}
		else
		{
			return 0;
		}
	}
	
	public function getAdminWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.email as email, user.gender as gender, user.regtime as regtime, user.logintype as logintype, zj.prizeid as prizeid, zj.luckycode as luckycode, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id");
		return Config::$db->getAllRows();
	}
}
new MainController();
?>
