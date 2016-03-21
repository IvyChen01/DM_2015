<?php
/**
 * 用户模块
 * @author Shines
 */
class UserController
{
	private $user = null;//用户
	private $news = null;//新闻
	
	public function __construct()
	{
		$this->user = new User();
		$this->news = new News();
	}
	
	/**
	 * 生成验证码
	 */
	public function verify()
	{
		Config::$sid = Security::varPost('imei');
		$this->user->getVerify();
	}
	
	public function register()
	{
		Config::$sid = Security::varPost('imei');
		$verify = Security::varPost('verify');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$email = Security::varPost('email');
		
		if ($this->user->checkVerify($verify))
		{
			$res = $this->user->register($username, $password, $email);
			$code = $res['code'];
			$uid = $res['uid'];
			switch ($code)
			{
				case 0:
					$this->news->initUserChannel($uid);
					System::echoData(Config::$msg['ok']);
					break;
				case 1:
					System::echoData(Config::$msg['userPwEmailEmpty']);
					break;
				case 2:
					System::echoData(Config::$msg['emailFormatError']);
					break;
				case 3:
					System::echoData(Config::$msg['usernameExist']);
					break;
				case 4:
					System::echoData(Config::$msg['emailExist']);
					break;
				case 5:
					System::echoData(Config::$msg['genUidError']);
					break;
				default:
			}
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
	
	public function login()
	{
		Config::$sid = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		
		if ($this->user->login($username, $password))
		{
			$userinfo = $this->user->getUserInfo();
			if (!empty($userinfo))
			{
				$uid = $userinfo['uid'];
				$key = Security::multiMd5($uid, Config::$key);
				System::echoData(Config::$msg['ok'], array('auth' => $uid, 'saltkey' => $key, 'userinfo' => $userinfo));
			}
			else
			{
				System::echoData(Config::$msg['usernamePwError']);
			}
		}
		else
		{
			System::echoData(Config::$msg['usernamePwError']);
		}
	}
	
	public function setNick()
	{
		Config::$sid = Security::varPost('imei');
		$nick = Security::varPost('nick');
		if ($this->user->checkLogin())
		{
			$this->user->setNick($nick);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('nick' => $userinfo['nick']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setPhone()
	{
		Config::$sid = Security::varPost('imei');
		$phone = Security::varPost('phone');
		if ($this->user->checkLogin())
		{
			$this->user->setPhone($phone);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('phone' => $userinfo['phone']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setSignature()
	{
		Config::$sid = Security::varPost('imei');
		$signature = Security::varPost('signature');
		if ($this->user->checkLogin())
		{
			$this->user->setSignature($signature);
			$userinfo = $this->user->getUserInfo();
			System::echoData(Config::$msg['ok'], array('signature' => $userinfo['signature']));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function uploadPhoto()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$param = $this->user->uploadPhoto();
			$code = $param['code'];
			$pic = $param['pic'];
			$msg = $param['msg'];
			switch ($code)
			{
				case 0:
					System::echoData(Config::$msg['ok'], array('photo' => $pic));
					break;
				case 1:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
					break;
				default:
					System::echoData(Config::$msg['photoError'], array('detail' => $msg));
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function logout()
	{
		Config::$sid = Security::varPost('imei');
		if ($this->user->checkLogin())
		{
			$this->user->logout();
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function setEmail()
	{
		Config::$sid = Security::varPost('imei');
		$email = Security::varPost('email');
		if ($this->user->checkLogin())
		{
			if (Check::email($email))
			{
				$this->user->setEmail($email);
				$userinfo = $this->user->getUserInfo();
				System::echoData(Config::$msg['ok'], array('email' => $userinfo['email']));
			}
			else
			{
				System::echoData(Config::$msg['emailFormatError']);
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 修改密码
	 */
	public function changePassword()
	{
		Config::$sid = Security::varPost('imei');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if ($this->user->checkLogin())
		{
			if ($this->user->checkPassword($srcPassword))
			{
				$this->user->changePassword($newPassword);
				System::echoData(Config::$msg['ok']);
			}
			else
			{
				System::echoData(Config::$msg['srcPwErorr']);
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	/**
	 * 重置找回密码
	 */
	public function resetPassword()
	{
		Config::$sid = Security::varPost('imei');
		$verify = Security::varPost('verify');
		$username = Security::varPost('username');
		
		if ($this->user->checkVerify($verify))
		{
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['verifyError']);
		}
	}
}
?>
