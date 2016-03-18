<?php
/**
 *	用户
 */
class MwUser
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
	
	public function register($username, $password, $phone = '', $realname = '', $gender = '', $email = '')
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlPhone = Security::varSql($phone);
		$sqlRealname = Security::varSql($realname);
		$sqlGender = Security::varSql($gender);
		$sqlEmail = Security::varSql($email);
		$sqlPhoto = Security::varSql(Config::$baseUrl . '/images/mobile/photo3.png');
		$registerTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbUser (username, password, phone, realname, gender, email, register_time, upload_times, agreement, login_type, login_status, photo, local_photo) values ($sqlUsername, $sqlPassword, $sqlPhone, $sqlRealname, $sqlGender, $sqlEmail, $registerTime, 0, 1, 3, 1, $sqlPhoto, $sqlPhoto)");
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
				$this->setCookie($userId, $username, $libPassword);
				Debug::log('[mwuser login] userId: ' . $userId . ', username: ' . $username);
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
	
	public function getUserPhoto()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		Config::$db->query("select local_photo from $tbUser where id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return '';
		}
		else
		{
			return $res['local_photo'];
		}
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
			System::setSession('userUsername', $username);
			Debug::log('[user fb login] userId: ' . $userId . ', username: ' . $username);
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
		$this->clearCookie();
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
		Config::$db->query("UPDATE $tbUser SET password=$sqlPassword WHERE id=$sqlUserId");
	}
	
	public function changeName($realname)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlRealname = Security::varSql($realname);
		Config::$db->query("UPDATE $tbUser SET realname=$sqlRealname WHERE id=$sqlUserId");
	}
	
	public function changeGender($gender)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlGender = Security::varSql($gender);
		Config::$db->query("UPDATE $tbUser SET gender=$sqlGender WHERE id=$sqlUserId");
	}
	
	public function changeAge($age)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlAge = (int)$age;
		Config::$db->query("UPDATE $tbUser SET age=$sqlAge WHERE id=$sqlUserId");
	}
	
	public function changeLocale($locale)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlLocale = Security::varSql($locale);
		Config::$db->query("UPDATE $tbUser SET locale=$sqlLocale WHERE id=$sqlUserId");
	}
	
	public function changeEmail($email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET email=$sqlEmail WHERE id=$sqlUserId");
	}
	
	public function changePhone($phone)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPhone = Security::varSql($phone);
		Config::$db->query("UPDATE $tbUser SET phone=$sqlPhone WHERE id=$sqlUserId");
	}
	
	public function uploadPhoto()
	{
		$img = Security::varPost('img');
		if (empty($img))
		{
			return array('code' => 1, 'info' => 'Empty error!', 'pic' => '');
		}
		if (strlen($img) > 500000)
		{
			return array('code' => 2, 'info' => 'Size error!', 'pic' => '');
		}
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$data = base64_decode($img);
		file_put_contents($tempPic, $data);
		Image::thumb($tempPic, $pic, "", 200, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$this->savePhoto($picUrl);
		return array('code' => 0, 'info' => 'ok', 'pic' => $picUrl);
	}
	
	public function savePhoto($photo)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		$sqlPhoto = Security::varSql($photo);
		Config::$db->query("UPDATE $tbUser SET local_photo=$sqlPhoto WHERE id=$sqlUserId");
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
	
	public function getBaseInfo()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$this->getUserId();
		Config::$db->query("select uid, realname, gender, age, locale, email, upload_times, agreement, local_photo, phone from $tbUser where id=$sqlUserId");
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			$res = array('uid' => '', 'realname' => '', 'gender' => '', 'age' => 0, 'locale' => '', 'email' => '', 'upload_times' => 0, 'agreement' => 0, 'local_photo' => '');
		}
		return $res;
	}
	
	public function getUserInfo($id)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlId = (int)$id;
		Config::$db->query("select realname, gender, age, locale, email, upload_times, local_photo, phone from $tbUser where id=$sqlId");
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
}
?>
