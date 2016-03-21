<?php
/**
 * 游戏控制器
 * @author Shines
 */
class GameController
{
	private $game = null;
	private $fb = null;
	private $zhuanPan = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->game = new Game();
		$this->fb = new Fb();
		$this->zhuanPan = new ZhuanPan();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'main':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showMain();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'doAnswer':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doAnswer();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'setEmail':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->setEmail();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			default:
				$this->showLogin();
		}
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin()
	{
		$shareId = substr(trim(Security::varGet('shareId')), 0, 100);
		if (Config::$isFb)
		{
			if ($this->fb->checkLogin())
			{
				$this->fbid = $this->fb->getUserId();
				if ($this->game->existUser($this->fbid))
				{
					return true;
				}
			}
			
			$this->fb->initToken();
			$me = $this->fb->me();
			if ($me['code'] == 0)
			{
				$this->fbid = $this->fb->getUserId();
				if (empty($this->fbid))
				{
					return false;
				}
				else
				{
					if (!$this->game->existUser($this->fbid))
					{
						$this->game->addUser($this->fbid, $me['userProfile'], $shareId);
					}
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->loginLocal($shareId);
			return true;
		}
	}
	
	private function loginLocal($shareId)
	{
		$this->fbid = System::getSession('userTestFbid');
		if (empty($this->fbid))
		{
			$this->fbid = $this->genFbid();
		}
		if (!$this->game->existUser($this->fbid))
		{
			$username = array('Kity', 'Bruce', 'David', 'Kevin', 'Nancy');
			$photo = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg');
			$gender = array('female', 'male', 'male', 'male', 'female');
			$rand = rand(0, 4);
			$userProfile = array(
				'name' => $username[$rand] . rand(1000, 9999),
				'photo' => 'images/photo/' . $photo[$rand],
				'email' => 'test@test.com',
				'gender' => $gender[$rand]
			);
			$this->game->addUser($this->fbid, $userProfile, $shareId);
		}
	}
	
	private function genFbid()
	{
		$fbid = rand(10000000, 99999999);
		System::setSession('userTestFbid', $fbid);
		return $fbid;
	}
	
	private function showLogin()
	{
		$shareId = substr(trim(Security::varGet('shareId')), 0, 100);
		if (Config::$isFb)
		{
			Config::$siteUrl .= '&shareId=' . $shareId;
			$loginUrl = $this->fb->getLoginUrl();
		}
		else
		{
			if (Config::$deviceType == 'mobile')
			{
				$loginUrl = './?a=main&d=mobile&shareId=' . $shareId;
			}
			else
			{
				$loginUrl = './?a=main&shareId=' . $shareId;
			}
		}
		include(Config::$viewDir . 'login.php');
	}
	
	private function showMain()
	{
		Config::$shareUrl .= $this->fbid;
		$profile = $this->game->getProfile($this->fbid);
		$isPlayed = $profile['isplayed'] == 1 ? true : false;
		$isEmail = empty($profile['email2']) ? false : true;
		$luckyCode = $profile['luckycode'];
		include(Config::$viewDir . 'main.php');
	}
	
	private function doAnswer()
	{
		System::fixSubmit('doAnswer');
		if ($this->game->checkPlayed($this->fbid))
		{
			System::echoData(Config::$msg['played']);
			return;
		}
		
		$q1 = (int)Security::varPost('q1');
		$q3 = (int)Security::varPost('q3');
		$q4 = (int)Security::varPost('q4');
		$q6 = (int)Security::varPost('q6');
		$qs1 = trim(Security::varPost('qs1'));
		$qs2 = (int)trim(Security::varPost('qs2'));
		$qs4 = trim(Security::varPost('qs4'));
		$qs5 = (int)trim(Security::varPost('qs5'));
		
		if (($q1 >= 1 && $q1 <=5) && ($q3 >= 1 && $q3 <=6) && ($q4 >= 1 && $q4 <=14) && ($q6 >= 1 && $q6 <=8))
		{
			if ($q1 != 5)
			{
				$qs1 = '';
			}
			if ($q4 != 14)
			{
				$qs4 = '';
			}
			if ($qs2 > 0 && $qs5 > 0)
			{
				$this->game->setAnswer($this->fbid, $q1, $q3, $q4, $q6, $qs1, $qs2, $qs4, $qs5);
				System::echoData(Config::$msg['ok']);
			}
			else
			{
				System::echoData(Config::$msg['inputError']);
			}
		}
		else
		{
			System::echoData(Config::$msg['inputError']);
		}
	}
	
	private function setEmail()
	{
		System::fixSubmit('setEmail');
		$email = trim(Security::varPost('email'));
		
		if (Check::email($email))
		{
			$this->game->setEmail($this->fbid, $email);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['emailFormatError']);
		}
	}
}
?>
