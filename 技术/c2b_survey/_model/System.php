<?php
/**
 *	系统
 */
class System
{
	public function __construct()
	{
		//
	}
	
	/**
	 * 返回数据到客户端
	 */
	public static function echo_data($code = 0, $info = 'ok', $param = null)
	{
		$res = array('code' => $code, 'info' => $info);
		if (is_array($param))
		{
			$res = array_merge($res, $param);
		}
		echo json_encode($res);
	}
	
	/**
	 * 上传图片
	 */
	public static function upload_image()
	{
		$upload = new Upload(1 * 1024 * 1024, 'jpg,gif,png,bmp', '', 'uploads/', 'time');
		if ($upload->upload())
		{
			$upload_info = $upload->getUploadFileInfo();
			//$url = $upload_info[0]['savepath'] . $upload_info[0]['savename'];
			$url = Config::$url . '/uploads/' . $upload_info[0]['savename'];
			return json_encode(array('error' => 0, 'url' => $url));
		}
		else
		{
			$msg = $upload->getErrorMsg();
			return json_encode(array('error' => 1, 'message' => $msg));
		}
	}
	
	/**
	 * 设置提交key
	 */
	public static function set_submit_key()
	{
		$_SESSION[Config::$system_name . '_submit_key'] = 1;
	}
	
	/**
	 * 检测是否设置提交key
	 */
	public static function check_submit_key()
	{
		$is_set = isset($_SESSION[Config::$system_name . '_submit_key']) ? (int)$_SESSION[Config::$system_name . '_submit_key'] : 0;
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
	 * 清除提交key
	 */
	public static function clear_submit_key()
	{
		unset($_SESSION[Config::$system_name . '_submit_key']);
	}
	
	/**
	 * 生成首页html
	 */
	public static function make_index_html()
	{
		//Utils::make_html('index.html', Config::$url . '/?m=system&a=show_index');
	}
}
?>
