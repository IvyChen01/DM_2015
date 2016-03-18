<?php
/**
 * 管理后台控制器
 * @author Shines
 */
class AdminController
{
	private $admin = null;
	private $install = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->install = new Install();
		switch ($action)
		{
			case 'verify':
				$this->admin->getVerify();
				break;
			case 'doLogin':
				$this->doLogin();
				break;
			case 'changePassword':
				if ($this->admin->checkLogin())
				{
					$this->showChangePassword();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'doChangePassword':
				if ($this->admin->checkLogin())
				{
					$this->doChangePassword();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'logout':
				if ($this->admin->checkLogin())
				{
					$this->logout();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'install':
				if ($this->admin->checkLogin())
				{
					$this->install();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'db':
				if ($this->admin->checkLogin())
				{
					$this->db();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'dbNews':
				if ($this->admin->checkLogin())
				{
					$this->dbNews();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'upgrade':
				if ($this->admin->checkLogin())
				{
					$this->upgrade();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'backup':
				if ($this->admin->checkLogin())
				{
					$this->backup();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'recover':
				if ($this->admin->checkLogin())
				{
					$this->recover();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'find':
				if ($this->admin->checkLogin())
				{
					$this->find();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'log':
				if ($this->admin->checkLogin())
				{
					$this->log();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'logTime':
				if ($this->admin->checkLogin())
				{
					$this->logTime();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'phpinfo':
				if ($this->admin->checkLogin())
				{
					phpinfo();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'cacheTemplates':
				if ($this->admin->checkLogin())
				{
					$this->cacheTemplates();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'date':
				if ($this->admin->checkLogin())
				{
					echo Utils::mdate('Y-m-d H:i:s');
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
				if ($this->admin->checkLogin())
				{
					$this->showMain();
				}
				else
				{
					$this->showLogin();
				}
		}
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
				System::echoData(Config::$msg['usernamePwEmpty']);
			}
			else
			{
				if ($this->admin->login($username, $password))
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
	 * 修改密码
	 */
	private function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			System::echoData(Config::$msg['srcPwEmpty']);
		}
		else
		{
			if ($this->admin->checkPassword($srcPassword))
			{
				$this->admin->changePassword($newPassword);
				$this->admin->logout();
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
		System::fixSubmit('logout');
		$this->admin->logout();
		$this->showLogin();
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		System::fixSubmit('install');
		$this->install->install();
		echo 'ok';
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$allTables = $this->install->getAllTables();
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $this->install->getAllFields($tbName);
			$tableInfo['records'] = $this->install->getRecords($tbName, 0, 1000000);
			$_tableList[] = $tableInfo;
		}
		$this->showDb($_tableList);
	}
	
	/**
	 * 查看数据库数据
	 */
	private function dbNews()
	{
		$allTables = array(Config::$tbNews);
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $this->install->getAllFields($tbName);
			$tableInfo['records'] = $this->install->getRecords($tbName, 0, 100000);
			$_tableList[] = $tableInfo;
		}
		$this->showDb($_tableList);
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		System::fixSubmit('upgrade');
		$this->install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		System::fixSubmit('backup');
		$this->install->backup();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		System::fixSubmit('recover');
		$this->install->recover();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 数据库中查找关键字
	 */
	private function find()
	{
		$keywords = Security::varGet('keywords');
		$_tableList = $this->install->find($keywords);
		$this->showDb($_tableList);
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
			$logFile = Config::$logDir . Utils::mdate('Y-m-d', $date) . '.php';
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
			$timeFile = Config::$logDir . 'time_' . Utils::mdate('Y-m-d', $date) . '.php';
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
	 * 更新模板
	 */
	private function cacheTemplates()
	{
		System::fixSubmit('cacheTemplates');
		System::cacheTemplates();
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
	
	/**
	 * 显示管理首页
	 */
	private function showMain()
	{
		include(Config::$viewDir . 'admin/main.php');
	}
	
	/**
	 * 显示修改密码页
	 */
	private function showChangePassword()
	{
		include(Config::$viewDir . 'admin/change_password.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	private function showDb($_tableList)
	{
		include(Config::$viewDir . 'admin/db.php');
	}
}
?>
