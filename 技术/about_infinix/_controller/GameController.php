<?php
/**
 * 游戏控制器
 * @author Shines
 */
class GameController
{
	private $game = null;
	private $fb = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->game = new Game();
		$this->fb = new Fb();
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
		$isPlayed = $this->game->checkPlayed($this->fbid);
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
		
		$q1 = (int)Security::varPost('Q1');
		$q2 = (int)Security::varPost('Q2');
		$q3 = (int)Security::varPost('Q3');
		$q4 = (int)Security::varPost('Q4');
		$q5 = (int)Security::varPost('Q5');
		$q6 = (int)Security::varPost('Q6');
		$q7 = (int)Security::varPost('Q7');
		$q8 = (int)Security::varPost('Q8');
		$q9 = (int)Security::varPost('Q9');
		$q10 = (int)Security::varPost('Q10');
		
		if (($q1 >= 1 && $q1 <=3) && ($q2 >= 1 && $q2 <=3) && ($q3 >= 1 && $q3 <=3) && ($q4 >= 1 && $q4 <=3) && ($q5 >= 1 && $q5 <=3) && ($q6 >= 1 && $q6 <=3) && ($q7 >= 1 && $q7 <=3) && ($q8 >= 1 && $q8 <=3) && ($q9 >= 1 && $q9 <=3) && ($q10 >= 1 && $q10 <=3))
		{
			$this->game->setAnswer($this->fbid, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['inputError']);
		}
	}
}
?>
