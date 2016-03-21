<?php
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
		System::echoData(Config::$msg['ok'], array('version' => '1.0.0', 'apkUrl' => 'http://159.8.94.69/publishers/globalpublishers.apk', 'log' => '1.add comments.\n2.fix bug.'));
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
?>
