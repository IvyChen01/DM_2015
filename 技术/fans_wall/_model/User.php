<?php
/**
 * 用户
 * [待测试]
 */
class User
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
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$userId = (int)$res['id'];
				$username = $res['username'];
				$phone = $res['phone'];
				
				System::setSession('userUserId', $userId);
				System::setSession('userUsername', $username);
				System::setSession('userPassword', $libPassword);
				System::setSession('userPhone', $phone);
				
				$cookieKey = Security::multiMd5($userId . $username . $libPassword . $phone, Config::$key);
				setcookie(Config::$systemName . "_userCookieUserid", $userId, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$systemName . "_userCookieUsername", $username, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$systemName . "_userCookiePassword", $libPassword, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$systemName . "_userCookiePhone", $phone, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$systemName . "_userCookieKey", $cookieKey, time() + 12 * 30 * 24 * 60 * 60);
				
				Debug::log('[user login] userId: ' . $userId . ', username: ' . $username);
				
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
	 * 检测是否登录
	 */
	public function checkLogin()
	{
		if ($this->getUserId() > 0)
		{
			return true;
		}
		else
		{
			$cookieUserId = isset($_COOKIE[Config::$systemName . "_userCookieUserid"]) ? (int)$_COOKIE[Config::$systemName . "_userCookieUserid"] : 0;
			$cookieUsername = isset($_COOKIE[Config::$systemName . "_userCookieUsername"]) ? $_COOKIE[Config::$systemName . "_userCookieUsername"] : '';
			$cookiePassword = isset($_COOKIE[Config::$systemName . "_userCookiePassword"]) ? $_COOKIE[Config::$systemName . "_userCookiePassword"] : '';
			$cookiePhone = isset($_COOKIE[Config::$systemName . "_userCookiePhone"]) ? $_COOKIE[Config::$systemName . "_userCookiePhone"] : '';
			$cookieKey = isset($_COOKIE[Config::$systemName . "_userCookieKey"]) ? $_COOKIE[Config::$systemName . "_userCookieKey"] : '';
			$safeKey = Security::multiMd5($cookieUserId . $cookieUsername . $cookiePassword . $cookiePhone, Config::$key);
			
			if (!empty($cookieUserId) && !empty($cookieUsername) && !empty($cookiePassword) && !empty($cookiePhone) && $cookieKey == $safeKey)
			{
				System::setSession('userUserId', $cookieUserId);
				System::setSession('userUsername', $cookieUsername);
				System::setSession('userPassword', $cookiePassword);
				System::setSession('userPhone', $cookiePhone);
				Debug::log('[user cookieLogin] userId: ' . $cookieUserId . ', username: ' . $cookieUsername);
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('userUserId');
		System::clearSession('userUsername');
		System::clearSession('userPassword');
		System::clearSession('userPhone');
		
		setcookie(Config::$systemName . "_userCookieUserid", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieUsername", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookiePassword", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookiePhone", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieKey", '', time() - 3600);
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($password)
	{
		$sessionPassword = $this->getPassword();
		$inputPassword = Security::multiMd5($password, Config::$key);
		if ($sessionPassword == $inputPassword)
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
	public function changePassword($password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		Config::$db->query("update $tbUser set password=$sqlPassword where id=$sqlUserId");
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('userUserId');
	}
	
	/**
	 * 用户名
	 */
	public function getUsername()
	{
		return System::getSession('userUsername');
	}
	
	/**
	 * 密码
	 */
	public function getPassword()
	{
		return System::getSession('userPassword');
	}
	
	/**
	 * 电话
	 */
	public function getPhone()
	{
		return System::getSession('userPhone');
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_userVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_userVerify']) ? $_SESSION[Config::$systemName . '_userVerify'] : '';
		unset($_SESSION[Config::$systemName . '_userVerify']);
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
