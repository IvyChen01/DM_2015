<?php
/**
 * 移动Web用户控制器
 */
class MwUserController
{
	private $user = null;//用户模型
	private $fb = null;
	
	public function __construct()
	{
		$this->user = new MwUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		
		switch ($action)
		{
			case 'register':
				$this->register();
				return;
			case 'login':
				$this->login();
				return;
			case 'profile':
				$this->profile();
				return;
			case 'logout':
				$this->logout();
				return;
			case 'verify':
				$this->user->getVerify();
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
			case 'doChangePhone':
				$this->doChangePhone();
				return;
			case 'doChangePhoto':
				$this->doChangePhoto();
				return;
			case 'doLogout':
				$this->doLogout();
				return;
			case 'doLoginFb':
				$this->doLoginFb();
				return;
			default:
		}
	}
	
	private function register()
	{
		include('view/mobile/register.php');
	}
	
	private function login()
	{
		include('view/mobile/login.php');
	}
	
	private function profile()
	{
		$this->checkLogin(true);
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		$_data = $this->user->getBaseInfo();
		include('view/mobile/profile.php');
	}
	
	private function logout()
	{
		$this->user->logout();
		$this->login();
	}
	
	private function doRegister()
	{
		System::fixSubmit('doRegister');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		$phone = Security::varPost('phone');
		$realname = Security::varPost('nick');
		
		if (empty($username) || empty($password))
		{
			Utils::echoData(1, 'Username & password cannot be empty!');
			return;
		}
		if (empty($phone))
		{
			Utils::echoData(4, 'Phone number cannot be empty!');
			return;
		}
		if (empty($realname))
		{
			Utils::echoData(2, 'Nickname cannot be empty!');
			return;
		}
		if ($this->user->existUsername($username))
		{
			Utils::echoData(3, 'Username exist!');
			return;
		}
		$this->user->register($username, $password, $phone, $realname);
		$this->user->login($username, $password);
		Utils::echoData(0, 'ok');
	}
	
	/**
	 * 登录
	 */
	private function doLogin()
	{
		System::fixSubmit('doLogin');
		$username = Security::varPost('username');
		$password = Security::varPost('password');
		if (empty($username) || empty($password))
		{
			Utils::echoData(1, 'Username & password cannot be empty!');
			return;
		}
		$isLogin = $this->user->login($username, $password);
		if ($isLogin)
		{
			Utils::echoData(0, 'ok');
		}
		else
		{
			Utils::echoData(2, 'Username or password error!');
		}
	}
	
	private function getBaseInfo()
	{
		$this->checkLogin();
		$data = $this->user->getBaseInfo();
		Utils::echoData(0, 'ok', array('data' => $data));
	}
	
	/**
	 * 修改密码
	 */
	private function doChangePassword()
	{
		$this->checkLogin();
		$srcPassword = Security::varPost('srcPassword');
		$newPassword = Security::varPost('newPassword');
		if (empty($srcPassword) || empty($newPassword))
		{
			Utils::echoData(106, '原密码和新密码不能为空！');
			return;
		}
		if ($this->user->checkPassword($srcPassword))
		{
			$this->user->changePassword($newPassword);
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
		$this->checkLogin();
		$realname = Security::varPost('realname');
		if (empty($realname))
		{
			Utils::echoData(1, 'Name cannot be empty!');
			return;
		}
		$this->user->changeName($realname);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeGender()
	{
		$this->checkLogin();
		$gender = Security::varPost('gender');
		if (empty($gender))
		{
			Utils::echoData(1, 'Gender cannot be empty!');
			return;
		}
		$this->user->changeGender($gender);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeAge()
	{
		$this->checkLogin();
		$age = (int) Security::varPost('age');
		if ($age <= 0 || $age >= 200)
		{
			Utils::echoData(1, 'Age error!');
			return;
		}
		$this->user->changeAge($age);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeLocale()
	{
		$this->checkLogin();
		$locale = Security::varPost('locale');
		if (empty($locale))
		{
			Utils::echoData(1, 'Area cannot be empty!');
			return;
		}
		$this->user->changeLocale($locale);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangeEmail()
	{
		$this->checkLogin();
		$email = Security::varPost('email');
		if (Check::email($email))
		{
			$this->user->changeEmail($email);
			Utils::echoData(0, 'ok');
		}
		else
		{
			Utils::echoData(1, 'Please enter the correct email!');
		}
	}
	
	private function doChangePhone()
	{
		$this->checkLogin();
		$phone = Security::varPost('phone');
		if (empty($phone))
		{
			Utils::echoData(1, 'Phone number cannot be empty!');
			return;
		}
		$this->user->changePhone($phone);
		Utils::echoData(0, 'ok');
	}
	
	private function doChangePhoto()
	{
		$this->checkLogin();
		$param = $this->user->uploadPhoto();
		$code = $param['code'];
		$info = $param['info'];
		$pic = $param['pic'];
		Utils::echoData($code, $info, array('local_photo' => $pic));
	}
	
	private function doLogout()
	{
		$this->checkLogin();
		$this->user->logoutImei($uid);
		Utils::echoData(0, 'ok');
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
			Utils::echoData(201, 'IMEI、fbid、姓名、头像地址不能为空！');
			return;
		}
		$uid = $this->user->getUidByFbid($fbid);
		if ('' == $uid)
		{
			$uid = $this->user->genUid();
			if ('' == $uid)
			{
				Utils::echoData(2, '用户id生成出错！');
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
	
	private function checkLogin($isPage = false)
	{
		if (!Config::$isFb)
		{
			$this->checkTestCode();
		}
		
		if (!$this->user->checkLogin())
		{
			if (!$this->user->loginCookie())
			{
				if ($isPage)
				{
					$this->login();
				}
				else
				{
					Utils::echoData(101, 'Not logged in!');
				}
				exit(0);
			}
		}
	}
	
	private function checkTestCode()
	{
		$userTestFbid = System::getSession('userTestFbid');
		if (empty($userTestFbid))
		{
			$userTestFbid = rand(10000000, 99999999);
			System::setSession('userTestFbid', $userTestFbid);
		}
		else
		{
			$userTestFbid = System::getSession('userTestFbid');
		}
		$this->fb->userId = $userTestFbid;
	}
}
?>
