<?php
/**
 * 安全
 * des加密
 * 静态类
 */
class Security
{
	//加密函数，可用decrypt()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
	public static function encrypt($data, $key = '', $expire = 0)
	{
		$string=serialize($data);
		$ckey_length = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr(md5(microtime()), -$ckey_length);
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		
		$string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) 
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
		$ckey_length = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = substr($string, 0, $ckey_length);
		
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		
		$string =  base64_decode(substr($string, $ckey_length));
		$string_length = strlen($string);
		
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) 
		{
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) 
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) 
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
	 * 多次md5加密
	 * $id: 原文
	 * $key: 密钥
	 */
	public static function md5_multi($id, $key)
	{
		$id_key = $key . $id;
		$str1 = md5(substr(md5($id_key), 3, 16) . substr(md5($key), 5, 11) . $id_key);
		$str2 = md5($id_key);
		$code = '';
		for ($i = 0; $i < 32; $i++)
		{
			$t = substr($str2, $i, 1);
			$t_code = ord($t);
			if ($t_code >= 48 && $t_code <= 57)
			{
				$t = chr(97 + $t_code - 48);
			}
			$code .= $t;
		}
		
		return substr($code, 0, 13) . $str1 . substr($code, 13, 19);
	}
	
	/**
	 * 功能：用来过滤字符串和字符串数组，防止被挂马和sql注入
	 * 参数$data，待过滤的字符串或字符串数组，
	 * $force为true，忽略get_magic_quotes_gpc
	 */
	public static function in($data,$force=false)
	{
		if(is_string($data))
		{
			$data=trim(htmlspecialchars($data));//防止被挂马，跨站攻击
			if(($force==true)||(!get_magic_quotes_gpc())) 
			{
			   $data = addslashes($data);//防止sql注入
			}
			return  $data;
		}
		else if(is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key=>$value)
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
		if(is_string($data))
		{
			return $data = stripslashes($data);
		}
		else if(is_array($data))//如果是数组采用递归过滤
		{
			foreach($data as $key=>$value)
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
	public static function text_in($str)
	{
		$str=strip_tags($str,'<br>');
		$str = str_replace(" ", "&nbsp;", $str);
		$str = str_replace("\n", "<br>", $str);	
		if(!get_magic_quotes_gpc()) 
		{
		  $str = addslashes($str);
		}
		return $str;
	}
	
	//文本输出
	public static function text_out($str)
	{
		$str = str_replace("&nbsp;", " ", $str);
		$str = str_replace("<br>", "\n", $str);	
		$str = stripslashes($str);
		return $str;
	}
	
	//html代码输入
	public static function html_in($str)
	{
		$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
						 "'<iframe[^>]*?>.*?</iframe>'si", // 去掉iframe
						);
		$replace = array ("",
						  "",
						);			  
	   $str=@preg_replace ($search, $replace, $str);
	   $str=htmlspecialchars($str);
		if(!get_magic_quotes_gpc()) 
		{
		  $str = addslashes($str);
		}
	   return $str;
	}
	
	//html代码输出
	public static function html_out($str)
	{
		if(function_exists('htmlspecialchars_decode'))
			$str=htmlspecialchars_decode($str);
		else
			$str=html_entity_decode($str);
	
		$str = stripslashes($str);
		return $str;
	}
	
	/**
	 * SQL安全变量
	 */
	public static function sql_var($value)
	{
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		// 如果不是数字则加引号
		if (!is_numeric($value))
		{
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		
		return $value;
	}
	
	/**
	 * html转换输出
	 */
	public static function htmlspecialchars_array($arr)
	{
		if (is_array($arr))
		{
			$res = array();
			foreach ($arr as $key => $value)
			{
				$res[$key] = self::htmlspecialchars_array($value);
			}
			
			return $res;
		}
		else
		{
			return htmlspecialchars($arr, ENT_QUOTES);
		}
	}
}
?>
