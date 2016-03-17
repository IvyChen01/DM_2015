<?php
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
?>
