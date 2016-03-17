<?php
/**
 * 用户控制器
 * @author Shines
 */
class UserController
{
	public function __construct()
	{
		//System::fixUrl();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			case 'changePassword':
				$this->changePassword();
				return;
			case 'doChangePassword':
				$this->doChangePassword();
				return;
			case 'logout':
				$this->logout();
				return;
			default:
				$this->main();
		}
	}
	
	/**
	 * 显示用户首页
	 */
	private function main()
	{
		$this->checkLogin();
		include(Config::$viewDir . 'user/main.php');
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$user = new User();
		$user->getVerify();
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		if (empty($username) || empty($password))
		{
			System::echoData(Config::$msg['usernamePwEmpty']);
		}
		else
		{
			$user = new User();
			if ($user->login($username, $password))
			{
				System::echoData(Config::$msg['ok']);
			}
			else
			{
				System::echoData(Config::$msg['usernamePwError']);
			}
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function changePassword()
	{
		$this->checkLogin();
		include(Config::$viewDir . 'user/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		$this->checkLogin(true);
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			System::echoData(Config::$msg['srcPwEmpty']);
			return;
		}
		$user = new User();
		if ($user->checkPassword($srcPassword))
		{
			$user->changePassword($newPassword);
			$user->logout();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['srcPwErorr']);
		}
	}
	
	/**
	 * 退出登录
	 */
	private function logout()
	{
		$this->checkLogin();
		$user = new User();
		$user->logout();
		$this->showLogin(false);
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
			include(Config::$viewDir . 'user/login.php');
		}
	}
}
?>
