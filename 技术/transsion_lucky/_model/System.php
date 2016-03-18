<?php
/**
 *	系统
 */
class System
{
	/**
	 * 获取session
	 */
	public static function get_session($session_name)
	{
		return isset($_SESSION[Config::$system_name . '_' . $session_name]) ? $_SESSION[Config::$system_name . '_' . $session_name] : null;
	}
	
	/**
	 * 设置session
	 */
	public static function set_session($session_name, $value)
	{
		$_SESSION[Config::$system_name . '_' . $session_name] = $value;
	}
	
	/**
	 * 清除session
	 */
	public static function clear_session($session_name)
	{
		unset($_SESSION[Config::$system_name . '_' . $session_name]);
	}
	
	/**
	 * 上传图片
	 */
	public static function upload_image()
	{
		$upload = new Upload(2 * 1024 * 1024, 'gif,jpg,png,bmp', array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'), Config::$dir_uploads, Utils::gen_filename());
		if ($upload->upload())
		{
			$upload_info = $upload->getUploadFileInfo();
			//$url = $upload_info[0]['savepath'] . $upload_info[0]['savename'];
			$url = Config::$base_url . '/' . Config::$dir_uploads . $upload_info[0]['savename'];
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
	public static function upload_jq_image()
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
				$url = self::get_image_name($_FILES['fileToUpload']['name']);
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
	public static function get_image_name($extend)
	{
		$arr = explode('.', $extend);
		return Config::$dir_uploads . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	/**
	 * 设置为数据提交状态
	 */
	public static function set_submit()
	{
		self::set_session('submit_key', 1);
	}
	
	/**
	 * 检测是否为数据提交状态
	 */
	public static function check_submit()
	{
		$is_set = (int)self::get_session('submit_key');
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
	public static function clear_submit()
	{
		self::clear_session('submit_key');
	}
	
	/**
	 * 转义html代码
	 */
	public function fix_html($value)
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
	public function fix_title($value)
	{
		$str = htmlspecialchars($value, ENT_QUOTES);
		$str = str_replace("\n", ' ', $str);
		return $str;
	}
}
?>
