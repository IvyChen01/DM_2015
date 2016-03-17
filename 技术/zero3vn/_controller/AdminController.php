<?php
/**
 * 管理后台模块
 * @author Shines
 */
class AdminController
{
	private $admin = null;//管理员
	private $install = null;//安装
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->install = new Install();
	}
	
	/**
	 * 生成验证码
	 */
	public function verify()
	{
		$this->admin->getVerify();
	}
	
	/**
	 * 登录
	 */
	public function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$verify = Security::varPost('verify');
		
		if ($this->admin->checkVerify($verify))
		{
			if (empty($username) || empty($password))
			{
				System::echoData(Config::$msg['usernamePwError']);
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
	public function changePassword()
	{
		if ($this->admin->checkLogin())
		{
			$this->showChangePassword();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 修改密码
	 */
	public function doChangePassword()
	{
		System::fixSubmit('doChangePassword');
		if ($this->admin->checkLogin())
		{
			$srcPassword = Security::varPost('srcPassword');
			$newPassword = Security::varPost('newPassword');
			if (empty($srcPassword))
			{
				System::echoData(Config::$msg['srcPwErorr']);
			}
			else
			{
				if (empty($newPassword))
				{
					System::echoData(Config::$msg['newPwError']);
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
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 退出
	 */
	public function logout()
	{
		System::fixSubmit('logout');
		if ($this->admin->checkLogin())
		{
			$this->admin->logout();
		}
		$this->showLogin();
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		System::fixSubmit('install');
		if ($this->admin->checkLogin())
		{
			$this->install->install();
			echo 'ok';
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看数据库数据
	 */
	public function db()
	{
		if ($this->admin->checkLogin())
		{
			$allTables = $this->install->getAllTables();
			$_tableList = array();
			foreach ($allTables as $tbName)
			{
				$tableInfo = array();
				$tableInfo['tbname'] = $tbName;
				$tableInfo['fields'] = $this->install->getAllFields($tbName);
				$tableInfo['records'] = $this->install->getRecords($tbName, 0, 10000);
				$_tableList[] = $tableInfo;
			}
			$this->showDb($_tableList);
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看新闻数据
	 */
	public function dbNews()
	{
		if ($this->admin->checkLogin())
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
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		System::fixSubmit('upgrade');
		if ($this->admin->checkLogin())
		{
			$this->install->upgrade();
			echo 'ok';
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		System::fixSubmit('backup');
		if ($this->admin->checkLogin())
		{
			$this->install->backup();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		System::fixSubmit('recover');
		if ($this->admin->checkLogin())
		{
			$this->install->recover();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 数据库中查找关键字
	 */
	public function find()
	{
		if ($this->admin->checkLogin())
		{
			$keywords = Security::varGet('keywords');
			$_tableList = $this->install->find($keywords);
			$this->showDb($_tableList);
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看日志
	 */
	public function log()
	{
		if ($this->admin->checkLogin())
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
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 查看执行时间日志
	 */
	public function logTime()
	{
		if ($this->admin->checkLogin())
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
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示php信息
	 */
	public function info()
	{
		if ($this->admin->checkLogin())
		{
			phpinfo();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示系统时间
	 */
	public function showDate()
	{
		if ($this->admin->checkLogin())
		{
			echo Utils::mdate('Y-m-d H:i:s');
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 管理后台主页面
	 */
	public function main()
	{
		if ($this->admin->checkLogin())
		{
			$this->showMain();
		}
		else
		{
			$this->showLogin();
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	public function showLogin()
	{
		include(Config::$htmlDir . 'admin/login.php');
	}
	
	/**
	 * 显示管理首页
	 */
	public function showMain()
	{
		include(Config::$htmlDir . 'admin/main.php');
	}
	
	/**
	 * 显示修改密码页
	 */
	public function showChangePassword()
	{
		include(Config::$htmlDir . 'admin/change_password.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	public function showDb($_tableList)
	{
		include(Config::$htmlDir . 'admin/db.php');
	}
}
?>
