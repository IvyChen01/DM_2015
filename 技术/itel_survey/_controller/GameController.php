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
					$isPlayed = $this->game->checkPlayed($this->fbid);
					if ($isPlayed)
					{
						$this->showLucky();
					}
					else
					{
						$this->showMain();
					}
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'lucky':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showLucky();
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
			case 'doLucky':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doLucky();
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
		include(Config::$viewDir . 'main.php');
	}
	
	private function showLucky()
	{
		Config::$shareUrl .= $this->fbid;
		$restLucky = $this->game->getRestLucky($this->fbid);
		$prizeId = $this->zhuanPan->getMyPrizeId($this->fbid);
		include(Config::$viewDir . 'lucky.php');
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
		$q2 = (int)Security::varPost('q2');
		$q3 = (int)Security::varPost('q3');
		$q4 = (int)Security::varPost('q4');
		$q5 = (int)Security::varPost('q5');
		$q6 = (int)Security::varPost('q6');
		$q7 = (int)Security::varPost('q7');
		$q4f = trim(Security::varPost('q4f'));
		$q5f = trim(Security::varPost('q5f'));
		$q6f = trim(Security::varPost('q6f'));
		
		if (($q1 >= 1 && $q1 <=2) && ($q2 >= 1 && $q2 <=4) && ($q3 >= 1 && $q3 <=5) && ($q4 >= 1 && $q4 <=6) && ($q5 >= 1 && $q5 <=5) && ($q6 >= 1 && $q6 <=5) && ($q7 >= 1 && $q7 <=2))
		{
			if ($q4 != 6)
			{
				$q4f = '';
			}
			if ($q5 != 5)
			{
				$q5f = '';
			}
			if ($q6 != 5)
			{
				$q6f = '';
			}
			$this->game->setAnswer($this->fbid, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q4f, $q5f, $q6f);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['inputError']);
		}
	}
	
	private function doLucky()
	{
		System::fixSubmit('doLucky');
		$restLucky = $this->game->getRestLucky($this->fbid);
		if ($restLucky > 0)
		{
			$this->game->reduceRestLucky($this->fbid);
			$win = $this->zhuanPan->lucky($this->fbid);
			$prizeId = $win['prizeId'];
			$prizeName = $win['prizeName'];
			$luckyCode = $win['luckyCode'];
			System::echoData(Config::$msg['ok'], array('prizeId' => $prizeId, 'restLucky' => $restLucky - 1));
		}
		else
		{
			System::echoData(Config::$msg['ok'], array('prizeId' => 0, 'restLucky' => 0));
		}
	}
}
?>
