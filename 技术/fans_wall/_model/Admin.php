<?php
/**
 * 管理员
 * [ok]
 */
class Admin
{
	public function __construct()
	{
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$password = Security::multiMd5($password, Config::$key);
		$sqlUsername = Security::varSql($username);
		Config::$db->query("SELECT * FROM $tbAdmin WHERE username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (!empty($res))
		{
			if ($password == $res['password'])
			{
				System::setSession('adminUserId', (int)$res['id']);
				System::setSession('adminUsername', $res['username']);
				System::setSession('adminPassword', $res['password']);
				Debug::log('[admin login] userId: ' . $res['id'] . ', username: ' . $res['username']);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 检测是否已登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('adminUserId');
		System::clearSession('adminUsername');
		System::clearSession('adminPassword');
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($password)
	{
		$sessionPassword = $this->getPassword();
		$inPassword = Security::multiMd5($password, Config::$key);
		if ($sessionPassword == $inPassword)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($newPassword)
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlId = (int)$this->getUserId();
		$newPassword = Security::multiMd5($newPassword, Config::$key);
		$sqlNewPassword = Security::varSql($newPassword);
		Config::$db->query("UPDATE $tbAdmin SET password=$sqlNewPassword WHERE id=$sqlId");
	}
	
	/**
	 * 获取用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('adminUserId');
	}
	
	/**
	 * 获取用户名
	 */
	public function getUsername()
	{
		return System::getSession('adminUsername');
	}
	
	/**
	 * 获取密码
	 */
	public function getPassword()
	{
		return System::getSession('adminPassword');
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_adminVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_adminVerify']) ? $_SESSION[Config::$systemName . '_adminVerify'] : '';
		unset($_SESSION[Config::$systemName . '_adminVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
