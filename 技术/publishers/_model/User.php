<?php
/**
 * 用户
 * @author Shines
 */
class User
{
	public function __construct()
	{
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		$rand = rand(1000, 9999);
		System::setDbSession('userVerify', $rand);
		Image::buildImageVerify(48, 22, $rand, 'userVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = System::getDbSession('userVerify');
		System::clearDbSession('userVerify');
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function register($username, $password, $email)
	{
		if (empty($username) || empty($password) || empty($email))
		{
			return array('code' => 1, 'uid' => '');
		}
		if (!Check::email($email))
		{
			return array('code' => 2, 'uid' => '');
		}
		if ($this->existUsername($username))
		{
			return array('code' => 3, 'uid' => '');
		}
		if ($this->existEmail($email))
		{
			return array('code' => 4, 'uid' => '');
		}
		$uid = Utils::genUniqid();
		if ($this->existUid($uid))
		{
			return array('code' => 5, 'uid' => '');
		}
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$sqlUsername = Security::varSql($username);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$sqlEmail = Security::varSql($email);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlIp = Security::varSql(Utils::getClientIp());
		$tbUser = Config::$tbUser;
		Config::$db->query("insert into $tbUser (uid, username, password, email, register_date, register_ip) values ($sqlUid, $sqlUsername, $sqlPassword, $sqlEmail, $sqlDate, $sqlIp)");
		return array('code' => 0, 'uid' => $uid);
	}
	
	public function existUsername($username)
	{
		Config::$db->connect();
		$sqlUsername = Security::varSql($username);
		$tbUser = Config::$tbUser;
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
	
	public function existEmail($email)
	{
		Config::$db->connect();
		$sqlEmail = Security::varSql($email);
		$tbUser = Config::$tbUser;
		Config::$db->query("select id from $tbUser where email=$sqlEmail");
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
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
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
	
	public function login($username, $password)
	{
		if (empty($username) || empty($password))
		{
			return false;
		}
		if ($this->loginUsername($username, $password))
		{
			return true;
		}
		else
		{
			if ($this->loginEmail($username, $password))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function loginUsername($username, $password)
	{
		if (empty($username) || empty($password))
		{
			return false;
		}
		Config::$db->connect();
		$sqlUsername = Security::varSql($username);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where username=$sqlUsername");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			$srcPassword = $res['password'];
			if ($sPassword == $srcPassword)
			{
				System::setDbSession('userUid', $res['uid']);
				return true;
			}
		}
		return false;
	}
	
	public function loginEmail($email, $password)
	{
		if (empty($email) || empty($password))
		{
			return false;
		}
		Config::$db->connect();
		$sqlEmail = Security::varSql($email);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where email=$sqlEmail");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			$srcPassword = $res['password'];
			if ($sPassword == $srcPassword)
			{
				System::setDbSession('userUid', $res['uid']);
				return true;
			}
		}
		return false;
	}
	
	public function getUid()
	{
		return System::getDbSession('userUid');
	}
	
	public function checkLogin()
	{
		$uid = $this->getUid();
		if (empty($uid))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function getUserInfo()
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select uid, username, email, phone, nick, signature, photo, register_date from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			if (!empty($res['photo']))
			{
				$res['photo'] = Config::$baseUrl . '/' . $res['photo'];
			}
		}
		return $res;
	}
	
	public function setNick($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set nick=$sqlValue where uid=$sqlUid");
	}
	
	public function setPhone($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set phone=$sqlValue where uid=$sqlUid");
	}
	
	public function setSignature($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set signature=$sqlValue where uid=$sqlUid");
	}
	
	public function setPhoto($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set photo=$sqlValue where uid=$sqlUid");
	}
	
	public function setEmail($value)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlValue = Security::varSql($value);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set email=$sqlValue where uid=$sqlUid");
	}
	
	public function uploadPhoto()
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$tempPic = $param['file'];
			$newPic = Config::$uploadsDir . time() . rand(100000, 999999) . '.jpg';
			Image::thumb($tempPic, $newPic, "", 500, 500);
			@unlink($tempPic);
			$this->setPhoto($newPic);
			//return array('code' => 0, 'pic' => $url, 'msg' => '');
			return array('code' => 0, 'pic' => Config::$baseUrl . '/' . $newPic, 'msg' => 'ok');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'pic' => '', 'msg' => $msg);
		}
	}
	
	public function logout()
	{
		System::clearDbSession('userUid');
	}
	
	public function changePassword($password)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$sqlPassword = Security::varSql(Security::multiMd5($password, Config::$key));
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set password=$sqlPassword where uid=$sqlUid");
		$this->logout();
	}
	
	public function checkPassword($password)
	{
		Config::$db->connect();
		$uid = $this->getUid();
		$sqlUid = Security::varSql($uid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select password from $tbUser where uid=$sqlUid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$sPassword = Security::multiMd5($password, Config::$key);
			if ($sPassword == $res['password'])
			{
				return true;
			}
		}
		return false;
	}
}
?>
