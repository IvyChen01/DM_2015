<?php
class AdminFansController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'add':
				$this->add();
				return;
			case 'doAdd':
				$this->doAdd();
				return;
			case 'modify':
				$this->modify();
				return;
			case 'doModify':
				$this->doModify();
				return;
			case 'delete':
				$this->delete();
				return;
			case 'uploadJqImage':
				$this->uploadJqImage();
				return;
			default:
				$this->main();
		}
	}
	
	private function add()
	{
		$this->checkLogin(false);
		$_pubTime = Utils::mdate('Y-m-d H:i:s');
		include('view/admin_fans/add.php');
	}
	
	private function doAdd()
	{
		System::fixSubmit('doAdd');
		$this->checkLogin(true);
		$photo = Security::varPost('photo');
		$username = Security::varPost('username');
		$content = Security::varPost('content');
		$pubtime = Security::varPost('pubtime');
		$fans = new Fans();
		$fans->add($photo, $username, $content, $pubtime);
		System::echoData(Config::$msg['ok']);
	}
	
	private function modify()
	{
		$this->checkLogin(false);
		$id = (int)Security::varGet('id');
		$fans = new Fans();
		$fans->setModifyId($id);
		$_fans = $fans->getFansById($id);
		if (empty($_fans))
		{
			include('view/404.html');
		}
		else
		{
			include('view/admin_fans/modify.php');
		}
	}
	
	private function doModify()
	{
		System::fixSubmit('doModify');
		$this->checkLogin(true);
		$photo = Security::varPost('photo');
		$username = Security::varPost('username');
		$content = Security::varPost('content');
		$pubtime = Security::varPost('pubtime');
		$fans = new Fans();
		$id = $fans->getModifyId();
		$fans->modify($id, $photo, $username, $content, $pubtime);
		System::echoData(Config::$msg['ok']);
	}
	
	private function delete()
	{
		System::fixSubmit('delete');
		$this->checkLogin(false);
		$id = (int)Security::varGet('id');
		$fans = new Fans();
		$fans->delete($id);
		$this->main();
	}
	
	private function uploadJqImage()
	{
		System::fixSubmit('uploadJqImage');
		$this->checkLogin(true);
		System::uploadJqImage();
	}
	
	private function main()
	{
		$this->checkLogin(false);
		$fans = new Fans();
		$_fans = $fans->getFansByTime();
		include('view/admin_fans/main.php');
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin($isDataAction = false)
	{
		$admin = new Admin();
		if (!$admin->checkLogin())
		{
			$this->showLogin($isDataAction);
			exit(0);
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin($isDataAction = false)
	{
		if ($isDataAction)
		{
			System::echoData(Config::$msg['noLogin']);
		}
		else
		{
			include('view/admin/login.php');
		}
	}
}
?>
