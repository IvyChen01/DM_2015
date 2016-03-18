<?php
/**
 * 管理后台控制器
 */
class AdminController
{
	private $admin = null;//管理员模型
	
	public function __construct()
	{
		$this->admin = new Admin();
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
		
		if ($this->admin->checkLogin())
		{
			switch ($action)
			{
				case 'changePassword':
					$this->changePassword();
					return;
				case 'doChangePassword':
					$this->doChangePassword();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'log':
					$this->log();
					return;
				case 'logTime':
					$this->logTime();
					return;
				case 'db':
					$this->db();
					return;
				case 'dbUser':
					$this->dbUser();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					//return;//disable
					$this->recover();
					return;
				case 'upgrade':
					$this->upgrade();
					return;
				case 'install':
					return;//disable
					$this->install();
					return;
				case 'find':
					$this->find();
					return;
				case 'phpinfo':
					$this->showPhpinfo();
					return;
				case 'exportUser':
					$this->exportUser();
					return;
				default:
					$this->main();
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
		$this->admin->getVerify();
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
		
		if ($this->admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				Utils::echoData(2, '用户名和密码不能为空！');
			}
			else
			{
				if ($this->admin->login($username, $password))
				{
					Utils::echoData(0, '登录成功！');
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
		include('view/admin/change_password.php');
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
			if ($this->admin->checkPassword($srcPassword))
			{
				$this->admin->changePassword($newPassword);
				$this->admin->logout();
				Utils::echoData(0, '修改成功！');
			}
			else
			{
				Utils::echoData(1, '原密码错误！');
			}
		}
	}
	
	/**
	 * 退出
	 */
	private function logout()
	{
		$this->admin->logout();
		$this->login();
	}
	
	/**
	 * 查看日志
	 */
	private function log()
	{
		$date = Security::varGet('date');
		if (empty($date))
		{
			if (file_exists(Debug::$logFile))
			{
				include(Debug::$logFile);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$logFile = Config::$dirLog . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($logFile))
			{
				include($logFile);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 查看执行时间日志
	 */
	private function logTime()
	{
		$date = Security::varGet('date');
		if (empty($date))
		{
			if (file_exists(Debug::$timeFile))
			{
				include(Debug::$timeFile);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$timeFile = Config::$dirLog . 'time_' . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($timeFile))
			{
				include($timeFile);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$install = new Install();
		$allTables = $install->getAllTables();
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $install->getAllFields($tbName);
			$tableInfo['records'] = $install->getRecords($tbName, 0, 1000);
			$_tableList[] = $tableInfo;
		}
		include('view/admin/db.php');
	}
	
	private function dbUser()
	{
		$install = new Install();
		$allTables = array(Config::$tbUser);
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $install->getAllFields($tbName);
			$tableInfo['records'] = $install->getUserRecords($tbName, 0, 100);
			$_tableList[] = $tableInfo;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		System::fixSubmit('backup');
		$install = new Install();
		$install->backup();
		echo 'ok';
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		System::fixSubmit('recover');
		$install = new Install();
		$install->recover();
		echo 'ok';
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		System::fixSubmit('upgrade');
		$install = new Install();
		$install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		System::fixSubmit('install');
		$install = new Install();
		$install->install();
		echo 'ok';
	}
	
	private function find()
	{
		$keywords = Security::varGet('keywords');
		$install = new Install();
		$_tableList = $install->find($keywords);
		include('view/admin/db.php');
	}
	
	private function showPhpinfo()
	{
		phpinfo();
	}
	
	private function exportUser()
	{
		$install = new Install();
		$install->exportUser();
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		include('view/admin/main.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function login()
	{
		include('view/admin/login.php');
	}
}
?>
