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
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		switch ($action)
		{
			case 'login':
				$this->login();
				return;
			default:
		}
		
		if ($this->user->check_login())
		{
			switch ($action)
			{
				case 'show_change_password':
					$this->show_change_password();
					return;
				case 'change_password':
					$this->change_password();
					return;
				case 'logout':
					$this->logout();
					return;
				default:
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	/**
	 * 登录
	 */
	private function login()
	{
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		
		if (empty($username) || empty($password))
		{
			System::echo_data(1, '用户名和密码不能为空！');
		}
		else
		{
			if ($this->user->login($username, $password))
			{
				System::echo_data(0, '登录成功！');
			}
			else
			{
				System::echo_data(1, '用户名或密码错误！');
			}
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function show_change_password()
	{
		$_username = $this->user->get_username();
		include('view/user/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function change_password()
	{
		$src_password = isset($_POST['src_password']) ? $_POST['src_password'] : '';
		$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
		
		if (empty($src_password) || empty($new_password))
		{
			System::echo_data(1, '原密码和新密码不能为空！');
			return;
		}
		if ($this->user->check_password($src_password))
		{
			$this->user->change_password($new_password);
			$this->user->logout();
			System::echo_data(0, '修改成功！');
		}
		else
		{
			System::echo_data(2, '原密码错误！');
		}
	}
	
	/**
	 * 退出登录
	 */
	private function logout()
	{
		$this->user->logout();
		$this->show_login();
	}
	
	/**
	 * 显示登录界面
	 */
	private function show_login()
	{
		include('view/user/login.php');
	}
}
?>
