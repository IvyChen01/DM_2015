<?php
/**
 * 管理后台控制器
 * [ok]
 */
class AdminController
{
	public function __construct()
	{
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
			case 'install':
				$this->install();
				return;
			case 'db':
				$this->db();
				return;
			case 'upgrade':
				$this->upgrade();
				return;
			case 'backup':
				$this->backup();
				return;
			case 'recover':
				$this->recover();
				return;
			case 'find':
				$this->find();
				return;
			case 'log':
				$this->log();
				return;
			case 'logTime':
				$this->logTime();
				return;
			case 'phpinfo':
				$this->showPhpinfo();
				return;
			default:
				$this->main();
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$admin = new Admin();
		$admin->getVerify();
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
		
		$admin = new Admin();
		if ($admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				System::echoData(Config::$msg['usernamePwEmpty']);
			}
			else
			{
				if ($admin->login($username, $password))
				{
					System::echoData(Config::$msg['ok']);
				}
				else
				{
					System::echoData(Config::$msg['usernamePwError']);
				}
			}
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function changePassword()
	{
		$this->checkLogin(false);
		include('view/admin/change_password.php');
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
		}
		else
		{
			$admin = new Admin();
			if ($admin->checkPassword($srcPassword))
			{
				$admin->changePassword($newPassword);
				$admin->logout();
				System::echoData(Config::$msg['ok']);
			}
			else
			{
				System::echoData(Config::$msg['srcPwErorr']);
			}
		}
	}
	
	/**
	 * 退出
	 */
	private function logout()
	{
		$this->checkLogin(false);
		$admin = new Admin();
		$admin->logout();
		$this->showLogin();
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		System::fixSubmit('install');
		$this->checkLogin(false);
		$install = new Install();
		$install->install();
		echo 'ok';
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$this->checkLogin(false);
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
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		System::fixSubmit('upgrade');
		$this->checkLogin(false);
		$install = new Install();
		$install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		System::fixSubmit('backup');
		$this->checkLogin(false);
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
		$this->checkLogin(false);
		$install = new Install();
		$install->recover();
		echo 'ok';
	}
	
	/**
	 * 数据库中查找关键字
	 */
	private function find()
	{
		$this->checkLogin(false);
		$keywords = Security::varGet('keywords');
		$install = new Install();
		$_tableList = $install->find($keywords);
		include('view/admin/db.php');
	}
	
	/**
	 * 查看日志
	 */
	private function log()
	{
		$this->checkLogin(false);
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
		$this->checkLogin(false);
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
	 * 显示php配置信息
	 */
	private function showPhpinfo()
	{
		$this->checkLogin(false);
		phpinfo();
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		$this->checkLogin(false);
		include('view/admin/main.php');
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
