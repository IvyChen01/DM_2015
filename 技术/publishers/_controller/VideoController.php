<?php
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
?>
