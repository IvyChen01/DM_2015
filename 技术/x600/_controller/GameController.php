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
					$this->lucky();
				}
				else
				{
					$this->main();
				}
				break;
			case 'setClick':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->setClick();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			default:
				$this->main();
		}
	}
	
	private function lucky()
	{
		$loginUrl = '';
		$isClick = 0;
		$prizeId = 0;
		$prizeName = '';
		$luckyCode = '';
		
		//$luckyToday = $this->zhuanPan->checkLuckyToday($this->fbid);
		$luckyToday = $this->zhuanPan->checkLucky($this->fbid);
		$isLucky = $luckyToday['isLucky'];
		$isClick = $luckyToday['isClick'] ? 1 : 0;
		if ($isLucky)
		{
			//$win = $this->zhuanPan->checkWinToday($this->fbid);
			$win = $this->zhuanPan->checkWin($this->fbid);
			$prizeId = $win['prizeId'];
			$prizeName = $win['prizeName'];
			$luckyCode = $win['luckyCode'];
		}
		else
		{
			$win = $this->zhuanPan->lucky($this->fbid);
			$prizeId = $win['prizeId'];
			$prizeName = $win['prizeName'];
			$luckyCode = $win['luckyCode'];
		}
		$this->showMain(true, $loginUrl, $isClick, $prizeId, $prizeName, $luckyCode);
	}
	
	private function setClick()
	{
		System::fixSubmit('setClick');
		$this->zhuanPan->setClick($this->fbid);
		System::echoData(Config::$msg['ok']);
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin()
	{
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
						$this->game->addUser($this->fbid, $me['userProfile']);
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
			$this->loginLocal();
			return true;
		}
	}
	
	private function loginLocal()
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
			$this->game->addUser($this->fbid, $userProfile);
		}
	}
	
	private function genFbid()
	{
		$fbid = rand(10000000, 99999999);
		System::setSession('userTestFbid', $fbid);
		return $fbid;
	}
	
	private function main()
	{
		$loginUrl = '';
		$isClick = 0;
		$prizeId = 0;
		$prizeName = '';
		$luckyCode = '';
		
		if (Config::$isFb)
		{
			$loginUrl = $this->fb->getLoginUrl();
		}
		else
		{
			if (Config::$deviceType == 'mobile')
			{
				$loginUrl = './?a=lucky&d=mobile';
			}
			else
			{
				$loginUrl = './?a=lucky';
			}
		}
		$this->showMain(false, $loginUrl, $isClick, $prizeId, $prizeName, $luckyCode);
	}
	
	private function showMain($isLogin, $loginUrl, $isClick, $prizeId, $prizeName, $luckyCode)
	{
		$fbid = $this->fbid;
		$winlist = $this->zhuanPan->getWinlist();
		$prize = Config::$prizeName;
		switch (Config::$deviceType)
		{
			case 'mobile':
				switch (Config::$configType)
				{
					case 2:
						include(Config::$viewDir . 'game/mobile/main.php');
						break;
					case 3:
						include(Config::$viewDir . 'game/mobile/ke_main.php');
						break;
					default:
						include(Config::$viewDir . 'game/mobile/ke_main.php');
				}
				break;
			default:
				switch (Config::$configType)
				{
					case 2:
						include(Config::$viewDir . 'game/main.php');
						break;
					case 3:
						include(Config::$viewDir . 'game/ke_main.php');
						break;
					default:
						include(Config::$viewDir . 'game/ke_main.php');
				}
		}
	}
}
?>
