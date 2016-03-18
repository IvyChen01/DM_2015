<?php
/**
 *	用户
 */
class User
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
	
	public function register($username, $password, $realname, $gender, $email, $imei, $uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlEmail = Security::varSql($email);
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, realname, gender, email, imei, uid, register_time, upload_times, agreement, login_type, login_status) values ($sqlUsername, $sqlPassword, $sqlRealname, $sqlGender, $sqlEmail, $sqlImei, $sqlUid, $registerTime, 0, 0, 2, 1)");
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
				System::setSession('userUsername', $username);
				System::setSession('userPassword', $libPassword);
				//$this->setCookie($userId, $username, $libPassword);
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
	 * 注销
	 */
	public function logout()
	{
		System::clearSession('userUserId');
		System::clearSession('userUsername');
		System::clearSession('userPassword');
		//$this->clearCookie();
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function checkPassword($uid, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select password from $tbUser where uid=$sqlUid");
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
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword($uid, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		Config::$db->query("UPDATE $tbUser SET password=$sqlPassword WHERE uid=$sqlUid");
	}
	
	public function changeName($uid, $realname)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlRealname = Security::varSql($realname);
		Config::$db->query("UPDATE $tbUser SET realname=$sqlRealname WHERE uid=$sqlUid");
	}
	
	public function changeGender($uid, $gender)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlGender = Security::varSql($gender);
		Config::$db->query("UPDATE $tbUser SET gender=$sqlGender WHERE uid=$sqlUid");
	}
	
	public function changeAge($uid, $age)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlAge = (int)$age;
		Config::$db->query("UPDATE $tbUser SET age=$sqlAge WHERE uid=$sqlUid");
	}
	
	public function changeLocale($uid, $locale)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlLocale = Security::varSql($locale);
		Config::$db->query("UPDATE $tbUser SET locale=$sqlLocale WHERE uid=$sqlUid");
	}
	
	public function changeEmail($uid, $email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET email=$sqlEmail WHERE uid=$sqlUid");
	}
	
	public function uploadPhoto($uid)
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$this->savePhoto($uid, $url);
			return array('code' => 0, 'photo' => $url, 'msg' => '');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'msg' => $msg);
		}
	}
	
	public function savePhoto($uid, $photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		$sqlPhoto = Security::varSql($photo);
		Config::$db->query("UPDATE $tbUser SET local_photo=$sqlPhoto WHERE uid=$sqlUid");
	}
	
	/**
	 * 用户编号
	 */
	public function getUserId($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select id from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['id'];
		}
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
	
	public function setCookie($userId, $username, $password)
	{
		$cookieKey = Security::multiMd5($userId . $username . $password, Config::$key);
		setcookie(Config::$systemName . "_userCookieUserId", $userId, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieUsername", $username, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookiePassword", $password, time() + 12 * 30 * 24 * 60 * 60);
		setcookie(Config::$systemName . "_userCookieKey", $cookieKey, time() + 12 * 30 * 24 * 60 * 60);
	}
	
	public function clearCookie()
	{
		setcookie(Config::$systemName . "_userCookieUserId", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieUsername", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookiePassword", '', time() - 3600);
		setcookie(Config::$systemName . "_userCookieKey", '', time() - 3600);
	}
	
	public function loginCookie()
	{
		$cookieUserId = isset($_COOKIE[Config::$systemName . "_userCookieUserId"]) ? (int)$_COOKIE[Config::$systemName . "_userCookieUserId"] : 0;
		$cookieUsername = isset($_COOKIE[Config::$systemName . "_userCookieUsername"]) ? $_COOKIE[Config::$systemName . "_userCookieUsername"] : '';
		$cookiePassword = isset($_COOKIE[Config::$systemName . "_userCookiePassword"]) ? $_COOKIE[Config::$systemName . "_userCookiePassword"] : '';
		$cookieKey = isset($_COOKIE[Config::$systemName . "_userCookieKey"]) ? $_COOKIE[Config::$systemName . "_userCookieKey"] : '';
		$safeKey = Security::multiMd5($cookieUserId . $cookieUsername . $cookiePassword, Config::$key);
		
		if (!empty($cookieUserId) && !empty($cookieUsername) && !empty($cookiePassword) && $cookieKey == $safeKey)
		{
			System::setSession('userUserId', $cookieUserId);
			System::setSession('userUsername', $cookieUsername);
			System::setSession('userPassword', $cookiePassword);
			Debug::log('[user cookieLogin] userId: ' . $cookieUserId . ', username: ' . $cookieUsername);
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getBaseInfo($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select uid, realname, gender, age, locale, email, upload_times, agreement, local_photo from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			$res = array('uid' => '', 'realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'agreement' => 0, 'local_photo' => '');
		}
		
		return $res;
	}
	
	public function existImei($imei)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlImei = Security::varSql($imei);
		Config::$db->query("select id from $tbUser where imei=$sqlImei");
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
	
	public function existUid($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select id from $tbUser where uid=$sqlUid");
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
	
	public function genUid()
	{
		$count = 1;
		$maxCount = 10;
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		while (true)
		{
			$uid = rand(10000000, 99999999);
			$sqlUid = Security::varSql($uid);
			Config::$db->query("select id from $tbUser where uid=$sqlUid");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return $uid;
			}
			if ($count >= $maxCount)
			{
				return '';
			}
			$count++;
		}
	}
	
	public function checkLoginImei($uid)
	{
		if (empty($uid))
		{
			return false;
		}
		
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("select login_status from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$loginStatus = (int)$res['login_status'];
			if ($loginStatus > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function loginImei($username, $password)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('state' => false, 'uid' => '');
		}
		else
		{
			$libPassword = $res['password'];
			$inputPassword = Security::multiMd5($password, Config::$key);
			if ($libPassword == $inputPassword)
			{
				$uid = $res['uid'];
				$sqlUid = Security::varSql($uid);
				Config::$db->query("update $tbUser set login_status=1 where uid=$sqlUid");
				Debug::log('[loginImei] username: ' . $username);
				
				return array('state' => true, 'uid' => $uid);
			}
			else
			{
				return array('state' => false, 'uid' => '');
			}
		}
	}
	
	public function logoutImei($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("update $tbUser set login_status=0 where uid=$sqlUid");
	}
	
	public function getUserInfo($id)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlId = (int)$id;
		Config::$db->query("select realname, gender, age, locale, email, upload_times, local_photo from $tbUser where id=$sqlId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			$res = array('realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'local_photo' => '');
		}
		return $res;
	}
	
	public function getIdByName($username)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		Config::$db->query("select id from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['id'];
		}
	}
	
	public function getUidByFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select uid from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return '';
		}
		else
		{
			return $res['uid'];
		}
	}
	
	public function addFbid($fbid, $imei, $uid, $realname, $photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		$sqlImei = Security::varSql($imei);
		$sqlUid = Security::varSql($uid);
		$sqlRealname = Security::varSql($realname);
		$sqlPhoto = Security::varSql($photo);
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (fbid, imei, uid, username, realname, photo, local_photo, register_time, upload_times, agreement, login_type, login_status) values ($sqlFbid, $sqlImei, $sqlUid, $sqlRealname, $sqlRealname, $sqlPhoto, $sqlPhoto, $registerTime, 0, 0, 2, 1)");
	}
	
	public function loginUid($uid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUid = Security::varSql($uid);
		Config::$db->query("update $tbUser set login_status=1 where uid=$sqlUid");
		Debug::log('[loginUid] uid: ' . $uid);
	}
}
?>
