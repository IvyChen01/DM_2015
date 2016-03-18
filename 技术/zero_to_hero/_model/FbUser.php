<?php
/**
 *	用户
 */
class FbUser
{
	public function __construct()
	{
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function register($username, $password, $imei, $uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, imei, uid, register_time, upload_times, agreement, login_type, login_status) values ($sqlUsername, $sqlPassword, $sqlImei, $sqlUid, $registerTime, 0, 0, 2, 0)");
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
		if (empty($res))
		{
			return false;
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$userId = (int)$res['id'];
				$username = $res['username'];
				System::setSession('userUserId', $userId);
				Debug::log('[user login] userId: ' . $userId . ', username: ' . $username);
				
				return true;
			}
			else
			{
				return false;
			}
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
			return false;
		}
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId()
	{
		return (int)System::getSession('userUserId');
	}
	
	public function getUserPhoto()
	{
		return System::getSession('userUserPhoto');
	}
	
	public function existFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function addFbUser($fbid, $userProfile)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$username = isset($userProfile['username']) ? $userProfile['username'] : '';
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$link = isset($userProfile['link']) ? $userProfile['link'] : '';
		$realname = isset($userProfile['name']) ? $userProfile['name'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$timezone = isset($userProfile['timezone']) ? $userProfile['timezone'] : '';
		$locale = isset($userProfile['locale']) ? $userProfile['locale'] : '';
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlEmail = Security::varSql($email);
		$sqlLink = Security::varSql($link);
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlTimezone = Security::varSql($timezone);
		$sqlLocale = Security::varSql($locale);
		$sqlRegisterTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlPhoto = Security::varSql('https://graph.facebook.com/' . $fbid . '/picture');
		Config::$db->query("insert into $tbUser (fbid, username, email, photo, link, realname, gender, timezone, locale, register_time, upload_times, agreement, login_type, login_status, local_photo) values ($sqlFbid, $sqlUsername, $sqlEmail, $sqlPhoto, $sqlLink, $sqlRealname, $sqlGender, $sqlTimezone, $sqlLocale, $sqlRegisterTime, 0, 0, 1, 0, $sqlPhoto)");
	}
	
	public function addFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		$sqlPhoto = Security::varSql('https://graph.facebook.com/' . $fbid . '/picture');
		$sqlRegisterTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (fbid, photo, register_time, upload_times, agreement, login_type, login_status, local_photo) values ($sqlFbid, $sqlPhoto, $sqlRegisterTime, 0, 0, 1, 0, $sqlPhoto)");
	}
	
	public function loginFb($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select * from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$userId = (int)$res['id'];
			$username = $res['username'];
			System::setSession('userUserId', $userId);
			System::setSession('userUserPhoto', $res['local_photo']);
			Debug::log('[user fb login] userId: ' . $userId . ', username: ' . $username);
		}
	}
}
?>
