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
			case 'introduction':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showIntroduction();
				}
				else
				{
					$this->showEnter();
				}
				break;
			case 'main':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showMain();
				}
				else
				{
					$this->showEnter();
				}
				break;
			case 'personal':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showPersonal();
				}
				else
				{
					$this->showEnter();
				}
				break;
			case 'rank':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showRank();
				}
				else
				{
					$this->showEnter();
				}
				break;
			case 'rule':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showRule();
				}
				else
				{
					$this->showEnter();
				}
				break;
			case 'score':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->score();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
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
			case 'doShare':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doShare();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'winner':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showWinner();
				}
				else
				{
					$this->showEnter();
				}
				break;
			default:
				$this->showEnter();
		}
	}
	
	private function score()
	{
		System::fixSubmit('score');
		$score = (int) Security::varPost('score');
		if ($score >= Config::$minDailyScore && $score < Config::$maxDailyScore)
		{
			if ($this->game->checkPlayed($this->fbid))
			{
				System::echoData(Config::$msg['played']);
			}
			else
			{
				$this->game->addScore($this->fbid, $score);
				System::echoData(Config::$msg['ok']);
			}
		}
		else
		{
			System::echoData(Config::$msg['RequestError']);
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
		$personal = $this->game-> getPersonal($this->fbid);
		$restLucky = $personal['restLucky'];
		
		///////// debug
		if (Config::$isLocal)
		{
			//$restLucky = 3;
		}
		
		if ($restLucky > 0)
		{
			$this->game-> reduceRestLucky($this->fbid);
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
	
	private function doShare()
	{
		System::fixSubmit('doShare');
		$personal = $this->game->getPersonal($this->fbid);
		if (!$personal['isshared'])
		{
			$this->game-> setShared($this->fbid);
		}
	}
	
	private function showEnter()
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
				$loginUrl = './?m=game&a=introduction&d=mobile&shareId=' . $shareId;
			}
			else
			{
				$loginUrl = './?m=game&a=introduction&shareId=' . $shareId;
			}
		}
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_enter.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/enter.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_enter.php');
						break;
					default:
						include(Config::$viewDir . 'game/enter.php');
				}
		}
	}
	
	private function showIntroduction()
	{
		$personal = $this->game->getPersonal($this->fbid);
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 1:
					case 3:
						include(Config::$viewDir . 'game/mobile/sa_introduction.php');
						break;
					case 4:
						include(Config::$viewDir . 'game/mobile/ssd_introduction.php');
						break;
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_introduction.php');
						break;
					case 6:
						include(Config::$viewDir . 'game/mobile/gh_introduction.php');
						break;
					case 7:
						include(Config::$viewDir . 'game/mobile/sa_introduction.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/introduction.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 1:
					case 3:
						include(Config::$viewDir . 'game/sa_introduction.php');
						break;
					case 4:
						include(Config::$viewDir . 'game/ssd_introduction.php');
						break;
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_introduction.php');
						break;
					case 6:
						include(Config::$viewDir . 'game/gh_introduction.php');
						break;
					case 7:
						include(Config::$viewDir . 'game/sa_introduction.php');
						break;
					default:
						include(Config::$viewDir . 'game/introduction.php');
				}
		}
	}
	
	private function showMain()
	{
		Config::$shareUrl .= $this->fbid;
		$personal = $this->game->getPersonal($this->fbid);
		$isPlayed = $this->game->checkPlayed($this->fbid) ? 1 : 0;
		$todayScore = $this->game-> getTodayScore($this->fbid);
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_main.php');
						break;
					case 6:
						include(Config::$viewDir . 'game/mobile/gh_main.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/main.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_main.php');
						break;
					case 6:
						include(Config::$viewDir . 'game/gh_main.php');
						break;
					default:
						include(Config::$viewDir . 'game/main.php');
				}
		}
	}
	
	private function showPersonal()
	{
		$page = (int) Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		Config::$shareUrl .= $this->fbid;
		$personal = $this->game->getPersonal($this->fbid);
		$daily = $this->game->getDaily($this->fbid, $page);
		
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=game&a=personal&page=';
		$pagelist->leftDelimiter = '&nbsp;';
		$pagelist->rightDelimiter = '&nbsp;';
		$allCount = $this->game->getDailyCount($this->fbid);
		$pagelist->totalPage = ceil($allCount / Config::$dailyPagesize);
		$pageStr = $pagelist->getPages($page);
		$prevPage = $page - 1;
		if ($prevPage < 1)
		{
			$prevPage = 1;
		}
		$nextPage = $page + 1;
		if ($nextPage > $pagelist->totalPage)
		{
			$nextPage =  $pagelist->totalPage;
		}
		$prevLink = '?m=game&a=personal&page=' . $prevPage;
		$nextLink = '?m=game&a=personal&page=' . $nextPage;
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						break;
					case 6:
						include(Config::$viewDir . 'game/mobile/gh_personal.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/personal.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						break;
					case 6:
						include(Config::$viewDir . 'game/gh_personal.php');
						break;
					default:
						include(Config::$viewDir . 'game/personal.php');
				}
		}
	}
	
	private function showRank()
	{
		$page = (int) Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$personal = $this->game->getPersonal($this->fbid);
		$rank = $this->game->getRank($this->fbid, $page);
		
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=game&a=rank&page=';
		$pagelist->leftDelimiter = '&nbsp;';
		$pagelist->rightDelimiter = '&nbsp;';
		$allCount = $this->game->getRankCount();
		$pagelist->totalPage = ceil($allCount / Config::$rankPagesize);
		$pageStr = $pagelist->getPages($page);
		$prevPage = $page - 1;
		if ($prevPage < 1)
		{
			$prevPage = 1;
		}
		$nextPage = $page + 1;
		if ($nextPage > $pagelist->totalPage)
		{
			$nextPage =  $pagelist->totalPage;
		}
		$prevLink = '?m=game&a=rank&page=' . $prevPage;
		$nextLink = '?m=game&a=rank&page=' . $nextPage;
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_rank.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/rank.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_rank.php');
						break;
					default:
						include(Config::$viewDir . 'game/rank.php');
				}
		}
	}
	
	private function showRule()
	{
		$personal = $this->game->getPersonal($this->fbid);
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 1:
					case 3:
						include(Config::$viewDir . 'game/mobile/sa_rule.php');
						break;
					case 4:
						include(Config::$viewDir . 'game/mobile/ssd_rule.php');
						break;
					case 5:
						break;
					case 6:
						include(Config::$viewDir . 'game/mobile/gh_rule.php');
						break;
					case 7:
						include(Config::$viewDir . 'game/mobile/sa_rule.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/rule.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 1:
					case 3:
						include(Config::$viewDir . 'game/sa_rule.php');
						break;
					case 4:
						include(Config::$viewDir . 'game/ssd_rule.php');
						break;
					case 5:
						break;
					case 6:
						include(Config::$viewDir . 'game/gh_rule.php');
						break;
					case 7:
						include(Config::$viewDir . 'game/sa_rule.php');
						break;
					default:
						include(Config::$viewDir . 'game/rule.php');
				}
		}
	}
	
	private function showLucky()
	{
		Config::$shareUrl .= $this->fbid;
		$personal = $this->game->getPersonal($this->fbid);
		$photo = $personal['photo'];
		$restLucky = $personal['restLucky'];
		$isShared = $personal['isshared'];
		
		///////// debug
		if (Config::$isLocal)
		{
			//$restLucky = 3;
		}
		
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_lucky.php');
						break;
					default:
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_lucky.php');
						break;
					default:
				}
		}
	}
	
	private function showWinner()
	{
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$personal = $this->game->getPersonal($this->fbid);
		$winner = $this->zhuanPan->getWinnerByPage($page);
		$myPrize = $this->zhuanPan->getMyPrize($this->fbid);
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=game&a=winner&page=';
		$pagelist->leftDelimiter = '&nbsp;';
		$pagelist->rightDelimiter = '&nbsp;';
		$allCount = $this->zhuanPan->getWinnerCount();
		$pagelist->totalPage = ceil($allCount / Config::$winnerPagesize);
		$pageStr = $pagelist->getPages($page);
		$prevPage = $page - 1;
		if ($prevPage < 1)
		{
			$prevPage = 1;
		}
		$nextPage = $page + 1;
		if ($nextPage > $pagelist->totalPage)
		{
			$nextPage =  $pagelist->totalPage;
		}
		$prevLink = '?m=game&a=winner&page=' . $prevPage;
		$nextLink = '?m=game&a=winner&page=' . $nextPage;
		$photo = $personal['photo'];
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_winner.php');
						break;
					default:
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 5:
						include(Config::$viewDir . 'game/mobile/ke_winner.php');
						break;
					default:
				}
		}
	}
}
?>
