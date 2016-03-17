<?php
/**
 * 游戏控制器
 * @author Shines
 */
class GameController
{
	private $game = null;
	private $zhuanPan = null;
	private $fb = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->game = new Game();
		$this->zhuanPan = new ZhuanPan();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showLucky();
				}
				else
				{
					$this->showEnter();
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
				$this->showEnter();
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
	
	private function doLucky()
	{
		System::fixSubmit('doLucky');
		$personal = $this->game->getPersonal($this->fbid);
		$restLucky = $personal['restLucky'];
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
	
	private function showEnter()
	{
		$page = (int)Security::varGet('page');
		if (empty($page))
		{
			$isScroll = false;
			$date = Utils::mdate('Y-m-d');
			switch ($date)
			{
				case Utils::mdate('Y-m-d', '2015-12-8'):
					$page = 1;
					break;
				case Utils::mdate('Y-m-d', '2015-12-9'):
					$page = 2;
					break;
				case Utils::mdate('Y-m-d', '2015-12-10'):
					$page = 3;
					break;
				case Utils::mdate('Y-m-d', '2015-12-11'):
					$page = 4;
					break;
				case Utils::mdate('Y-m-d', '2015-12-12'):
					$page = 5;
					break;
				default:
					$page = 5;
			}
		}
		else
		{
			$isScroll = true;
		}
		if ($page < 1)
		{
			$page = 1;
		}
		$pageUrl = './?page=';
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
				$loginUrl = './?a=lucky&d=mobile&shareId=' . $shareId;
			}
			else
			{
				$loginUrl = './?a=lucky&shareId=' . $shareId;
			}
		}
		$username = '';
		$photo = '';
		$restLucky = 0;
		$restSecond = Utils::restSeconds(date('Y-m-d H:i:s'), '2015-12-11 0:0:0');
		$isLogin = false;
		$winList = $this->zhuanPan->getPageWinner($page);
		
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 3:
						include(Config::$viewDir . 'game/main.php');
						break;
					default:
						include(Config::$viewDir . 'game/main.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 3:
						include(Config::$viewDir . 'game/main.php');
						break;
					default:
						include(Config::$viewDir . 'game/main.php');
				}
		}
	}
	
	private function showLucky()
	{
		$page = (int)Security::varGet('page');
		if (empty($page))
		{
			$isScroll = false;
			$date = Utils::mdate('Y-m-d');
			switch ($date)
			{
				case Utils::mdate('Y-m-d', '2015-12-8'):
					$page = 1;
					break;
				case Utils::mdate('Y-m-d', '2015-12-9'):
					$page = 2;
					break;
				case Utils::mdate('Y-m-d', '2015-12-10'):
					$page = 3;
					break;
				case Utils::mdate('Y-m-d', '2015-12-11'):
					$page = 4;
					break;
				case Utils::mdate('Y-m-d', '2015-12-12'):
					$page = 5;
					break;
				default:
					$page = 5;
			}
		}
		else
		{
			$isScroll = true;
		}
		if ($page < 1)
		{
			$page = 1;
		}
		$pageUrl = './?a=lucky&page=';
		Config::$shareUrl .= $this->fbid;
		$loginUrl = '';
		$personal = $this->game->getPersonal($this->fbid);
		$username = $personal['username'];
		$photo = $personal['photo'];
		$restLucky = $personal['restLucky'];
		$restSecond = Utils::restSeconds(date('Y-m-d H:i:s'), '2015-12-11 0:0:0');
		$isLogin = true;
		$winList = $this->zhuanPan->getPageWinner($page);
		
		switch (Config::$deviceType)
		{
			case 'mobile':
				include(Config::$viewDir . 'game/main.php');
				break;
			default:
				include(Config::$viewDir . 'game/main.php');
		}
	}
}
?>
