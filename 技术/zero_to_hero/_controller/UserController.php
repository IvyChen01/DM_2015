<?php
/**
 * 手机端用户控制器
 */
class UserController
{
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'doRegister':
				$this->doRegister();
				return;
			case 'doLogin':
				$this->doLogin();
				return;
			case 'getBaseInfo':
				$this->getBaseInfo();
				return;
			case 'doChangePassword':
				$this->doChangePassword();
				return;
			case 'doChangeName':
				$this->doChangeName();
				return;
			case 'doChangeGender':
				$this->doChangeGender();
				return;
			case 'doChangeAge':
				$this->doChangeAge();
				return;
			case 'doChangeLocale':
				$this->doChangeLocale();
				return;
			case 'doChangeEmail':
				$this->doChangeEmail();
				return;
			case 'doChangePhoto':
				$this->doChangePhoto();
				return;
			case 'doLogout':
				$this->doLogout();
				return;
			case 'viewInfo':
				$this->viewInfo();
				return;
			case 'doLoginFb':
				$this->doLoginFb();
				return;
			default:
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->user->getVerify();
	}
	
	private function doRegister()
	{
		$imei = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$realname = Security::varPost('nick');
		$gender = Security::varPost('gender');
		$email = Security::varPost('email');
		
		if (empty($username) || empty($password) || empty($imei))
		{
			Utils::echoData(103, 'Username & password cannot be empty!');
			return;
		}
		if (!empty($email) && !Check::email($email))
		{
			Utils::echoData(121, 'Please enter the correct email!');
			return;
		}
		if ($this->user->existUsername($username))
		{
			Utils::echoData(102, 'Username exist!');
			return;
		}
		$uid = $this->user->genUid();
		if (empty($uid))
		{
			Utils::echoData(203, 'User ID create error, please try again!');
			return;
		}
		$this->user->register($username, $password, $realname, $gender, $email, $imei, $uid);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		$imei = Security::varPost('imei');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		if (empty($username) || empty($password) || empty($imei))
		{
			Utils::echoData(104, '用户名和密码不能为空！');
			return;
		}
		$param = $this->user->loginImei($username, $password);
		$state = $param['state'];
		if ($state)
		{
			$uid = $param['uid'];
			$data = $this->user->getBaseInfo($uid);
			Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
		}
		else
		{
			Utils::echoData(105, '用户名或密码错误！');
		}
	}
	
	private function getBaseInfo()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$data = $this->user->getBaseInfo($uid);
		Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		$this->checkLogin($uid);
		if (empty($srcPassword) || empty($newPassword) || empty($imei) || empty($uid))
		{
			Utils::echoData(106, '原密码和新密码不能为空！');
			return;
		}
		if ($this->user->checkPassword($uid, $srcPassword))
		{
			$this->user->changePassword($uid, $newPassword);
			//$this->user->logoutImei($uid);
			Utils::echoData(0, '修改成功！', array('imei' => $imei, 'uid' => $uid));
		}
		else
		{
			Utils::echoData(107, '原密码错误！');
		}
	}
	
	private function doChangeName()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$realname = Security::varPost('realname');
		$this->checkLogin($uid);
		$this->user->changeName($uid, $realname);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeGender()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$gender = Security::varPost('gender');
		$this->checkLogin($uid);
		$this->user->changeGender($uid, $gender);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeAge()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$age = (int) Security::varPost('age');
		$this->checkLogin($uid);
		$this->user->changeAge($uid, $age);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeLocale()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$locale = Security::varPost('locale');
		$this->checkLogin($uid);
		$this->user->changeLocale($uid, $locale);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function doChangeEmail()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$email = Security::varPost('email');
		if (Check::email($email))
		{
			$this->checkLogin($uid);
			$this->user->changeEmail($uid, $email);
			Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
		}
		else
		{
			Utils::echoData(121, 'Please enter the correct email!');
		}
	}
	
	private function doChangePhoto()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$param = $this->user->uploadPhoto($uid);
		$code = $param['code'];
		$msg = $param['msg'];
		switch ($code)
		{
			case 0:
				$photo = $param['photo'];
				Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'local_photo' => $photo));
				break;
			case 1:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
				break;
			default:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
		}
	}
	
	private function doLogout()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$this->user->logoutImei($uid);
		Utils::echoData(0, 'ok');
	}
	
	private function viewInfo()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$openId = Security::varPost('openId');
		$data = $this->user->getUserInfo($openId);
		Utils::echoData(0, 'ok', array_merge(array('imei' => $imei, 'uid' => $uid, 'openId' => $openId), $data));
	}
	
	private function doLoginFb()
	{
		$fb = new Fb();
		$imei = Security::varPost('imei');
		$fbid = Security::varPost('fbid');
		$realname = Security::varPost('realname');
		$photo = Security::varPost('local_photo');
		if (empty($imei) || empty($fbid) || empty($realname) || empty($photo))
		{
			Utils::echoData(201, 'fbid、name、photo cannot be empty！');
			return;
		}
		if ($this->user->existUsername($realname))
		{
			Utils::echoData(202, 'Name exist！');
			return;
		}
		$uid = $this->user->getUidByFbid($fbid);
		if ('' == $uid)
		{
			$uid = $this->user->genUid();
			if ('' == $uid)
			{
				Utils::echoData(203, 'User ID create error, please try again!');
			}
			else
			{
				$this->user->addFbid($fbid, $imei, $uid, $realname, $photo);
				$data = $this->user->getBaseInfo($uid);
				Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
			}
		}
		else
		{
			$this->user->loginUid($uid);
			$data = $this->user->getBaseInfo($uid);
			Utils::echoData(0, 'ok', array_merge(array('imei' => $imei), $data));
		}
	}
	
	private function checkLogin($uid)
	{
		if (!$this->user->checkLoginImei($uid))
		{
			Utils::echoData(101, 'Not logged in!');
			exit(0);
		}
	}
}
?>
