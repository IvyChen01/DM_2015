<?php
/**
 *	系统
 */
class System
{
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
		$upload = new Upload(2 * 1024 * 1024, 'gif,jpg,png,bmp', array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'), Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			//$url = $uploadInfo[0]['savepath'] . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . Config::$dirUploads . $uploadInfo[0]['savename'];
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
	
	public static function uploadZeroImage()
	{
		$upload = new Upload(2 * 1024 * 1024, '', '', Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			$file = Config::$dirUploads . $uploadInfo[0]['savename'];
			$url = Config::$baseUrl . '/' . $file;
			return array('error' => 0, 'url' => $url, 'file' => $file);
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return array('error' => 1, 'message' => $msg);
		}
	}
	
	public static function uploadPhoto()
	{
		$upload = new Upload(2 * 1024 * 1024, '', '', Config::$dirUploads, Utils::genFilename());
		if ($upload->upload())
		{
			$uploadInfo = $upload->getUploadFileInfo();
			$file = Config::$dirUploads . $uploadInfo[0]['savename'];
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
		return Config::$dirUploads . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	/**
	 * 设置为数据提交状态
	 */
	public static function setSubmit()
	{
		self::setSession('submitKey', 1);
	}
	
	/**
	 * 检测是否为数据提交状态
	 */
	public static function checkSubmit()
	{
		$is_set = (int)self::getSession('submitKey');
		if (1 == $is_set)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 清除数据提交状态
	 */
	public static function clearSubmit()
	{
		self::clearSession('submitKey');
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
	 * 获取统计代码
	 */
	public static function getCountCode()
	{
		if (Config::$isLocal)
		{
			return '';
		}
		else
		{
			return Config::$countCode;
		}
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
			if ($theHost !== 'www.qumuwu.com')
			{
				header('HTTP/1.1 301 Moved Permanently');//发出301头部
				header('Location:http://www.qumuwu.com' . $theUrl);//跳转到带www的网址
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
				exit(0);
			}
			else
			{
				self::setSession('_systemSubmitTime' . '_' . $flag, $nowTime);
			}
		}
	}
}
?>
