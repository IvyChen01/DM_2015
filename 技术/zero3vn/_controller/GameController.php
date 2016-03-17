<?php
/**
 * 游戏控制器
 * @author Shines
 */
class GameController
{
	private $admin = null;
	private $game = null;
	private $zhuanPan = null;
	private $fb = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->game = new Game();
		$this->zhuanPan = new ZhuanPan();
		$this->fb = new Fb();
	}
	
	public function lucky()
	{
		if ($this->checkLogin())
		{
			$this->showLucky();
		}
		else
		{
			$this->showEnter();
		}
	}
	
	public function doLucky()
	{
		System::fixSubmit('doLucky');
		if ($this->checkLogin())
		{
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
				System::echoData(Config::$msg['noChances']);
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function doShare()
	{
		System::fixSubmit('doShare');
		if ($this->checkLogin())
		{
			if ($this->game->checkShared($this->fbid))
			{
				System::echoData(Config::$msg['shared']);
			}
			else
			{
				$this->game->setShare($this->fbid);
				$this->game->addRestLucky($this->fbid);
				$personal = $this->game->getPersonal($this->fbid);
				$restLucky = $personal['restLucky'];
				System::echoData(Config::$msg['ok'], array('restLucky' => $restLucky));
			}
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function winner()
	{
		if ($this->admin->checkLogin())
		{
			$winner = $this->zhuanPan->getAdminWinlist();
			include(Config::$htmlDir . 'game/admin/winner.php');
		}
		else
		{
			$this->showAdminLogin();
		}
	}
	
	public function dataCount()
	{
		if ($this->admin->checkLogin())
		{
			$daily = $this->zhuanPan->getDaily();
			$zhongJiang = $this->zhuanPan->getZhongJiang();
			
			$dayList = array();
			$totalLucky = 0;
			$totalWinner = 0;
			$totalLuckyRate = 0;
			
			foreach ($daily as $value)
			{
				$date = Utils::mdate('Y-m-d', $value['luckydate']);
				if (!isset($dayList[$date]))
				{
					$dayList[$date] = array();
					$dayList[$date]['date'] = $date;
					$dayList[$date]['lucky'] = 0;
					$dayList[$date]['winner'] = 0;
					$dayList[$date]['luckyRate'] = 0;
				}
				$dayList[$date]['lucky']++;
				$totalLucky++;
			}
			
			foreach ($zhongJiang as $value)
			{
				$date = Utils::mdate('Y-m-d', $value['luckydate']);
				if (isset($dayList[$date]))
				{
					$dayList[$date]['winner']++;
					$totalWinner++;
				}
			}
			
			foreach ($dayList as $value)
			{
				$date = $value['date'];
				$numWinner = $dayList[$date]['winner'];
				$numLucky = $dayList[$date]['lucky'];
				if ($numLucky != 0)
				{
					$dayList[$date]['luckyRate'] = round($numWinner / $numLucky * 100, 1);
				}
			}
			
			if ($totalLucky != 0)
			{
				$totalLuckyRate = round($totalWinner / $totalLucky * 100, 1);
			}
			include(Config::$htmlDir . 'game/admin/count.php');
		}
		else
		{
			$this->showAdminLogin();
		}
	}
	
	public function exportUser()
	{
		if ($this->admin->checkLogin())
		{
			$this->game->exportUser();
		}
		else
		{
			$this->showAdminLogin();
		}
	}
	
	public function initPrize()
	{
		if ($this->admin->checkLogin())
		{
			$this->zhuanPan->initPrize();
		}
		else
		{
			$this->showAdminLogin();
		}
	}
	
	/**
	 * 检测用户是否已登录
	 */
	public function checkLogin()
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
	
	public function loginLocal($shareId)
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
	
	public function genFbid()
	{
		$fbid = rand(10000000, 99999999);
		System::setSession('userTestFbid', $fbid);
		return $fbid;
	}
	
	public function showEnter()
	{
		$page = (int)Security::varGet('page');
		if (empty($page))
		{
			$isScroll = false;
			$date = Utils::mdate('Y-m-d');
			switch ($date)
			{
				case Utils::mdate('Y-m-d', '2016-3-9'):
					$page = 1;
					break;
				case Utils::mdate('Y-m-d', '2016-3-10'):
					$page = 2;
					break;
				default:
					$page = 2;
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
		$restSecond = Utils::restSeconds(date('Y-m-d H:i:s'), Config::$activeTime);
		$endSecond = Utils::restSeconds(date('Y-m-d H:i:s'), Config::$endTime);
		$isLogin = false;
		$winList = $this->zhuanPan->getPageWinner($page);
		$isShared = false;
		if ($restSecond > 0)
		{
			$timeState = 1;
		}
		else
		{
			if ($endSecond > 0)
			{
				$timeState = 2;
			}
			else
			{
				$timeState = 3;
			}
		}
		include(Config::$htmlDir . 'game/main.php');
	}
	
	public function showLucky()
	{
		$page = (int)Security::varGet('page');
		if (empty($page))
		{
			$isScroll = false;
			$date = Utils::mdate('Y-m-d');
			switch ($date)
			{
				case Utils::mdate('Y-m-d', '2016-3-9'):
					$page = 1;
					break;
				case Utils::mdate('Y-m-d', '2016-3-10'):
					$page = 2;
					break;
				default:
					$page = 2;
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
		$restSecond = Utils::restSeconds(date('Y-m-d H:i:s'), Config::$activeTime);
		$endSecond = Utils::restSeconds(date('Y-m-d H:i:s'), Config::$endTime);
		$isLogin = true;
		$winList = $this->zhuanPan->getPageWinner($page);
		$isShared = $this->game->checkShared($this->fbid);
		if ($restSecond > 0)
		{
			$timeState = 1;
		}
		else
		{
			if ($endSecond > 0)
			{
				$timeState = 2;
			}
			else
			{
				$timeState = 3;
			}
		}
		switch (Config::$deviceType)
		{
			case 'mobile':
				include(Config::$htmlDir . 'game/main.php');
				break;
			default:
				include(Config::$htmlDir . 'game/main.php');
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	public function showAdminLogin()
	{
		include(Config::$htmlDir . 'admin/login.php');
	}
}
?>
