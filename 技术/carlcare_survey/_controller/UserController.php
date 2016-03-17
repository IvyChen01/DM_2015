<?php
/**
 * 用户控制器
 */
class UserController
{
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			default:
		}
		
		if ($this->user->checkLogin())
		{
			switch ($action)
			{
				case 'changePassword':
					//$this->changePassword();
					return;
				case 'doChangePassword':
					//$this->doChangePassword();
					return;
				case 'logout':
					$this->logout();
					return;
				default:
					//$this->main();
			}
		}
		else
		{
			$this->login();
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->user->getVerify();
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
		$remember = (int)Security::varPost('remember');
		$isRemember = false;
		
		if (0 == $remember)
		{
			$isRemember = false;
		}
		else
		{
			$isRemember = true;
		}
		
		if ($this->user->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				Utils::echoData(2, '用户名和密码不能为空！');
			}
			else
			{
				if ($this->user->login($username, $password, $isRemember))
				{
					$level = $this->user->getLevel();
					Utils::echoData(0, '登录成功！', array('level' => $level));
				}
				else
				{
					Utils::echoData(1, '用户名或密码不正确！');
				}
			}
		}
		else
		{
			Utils::echoData(3, '验证码不正确！');
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function changePassword()
	{
		include('view/user/change_password.php');
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
			Utils::echoData(2, '原密码和新密码不能为空！');
		}
		else
		{
			if ($this->user->checkPassword($srcPassword))
			{
				$this->user->changePassword($newPassword);
				$this->user->logout();
				Utils::echoData(0, '修改成功！');
			}
			else
			{
				Utils::echoData(1, '原密码错误！');
			}
		}
	}
	
	/**
	 * 退出登录
	 */
	private function logout()
	{
		$this->user->logout();
		$this->login();
	}
	
	/**
	 * 显示用户首页
	 */
	private function main()
	{
		$_userId = $this->user->getUserId();
		$_username = $this->user->getUsername();
		$_password = $this->user->getPassword();
		$_level = $this->user->getLevel();
		//include('view/user/main.php');
	}
	
	/**
	 * 显示登录界面
	 */
	private function login()
	{
		include('view/survey/login.php');
	}
}
?>
