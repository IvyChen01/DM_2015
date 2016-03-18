<?php
/**
 * 许愿墙控制器
 * @author Shines
 */
class WishController
{
	private $wish = null;
	private $fb = null;
	private $fbid = '';
	
	public function __construct()
	{
		$this->wish = new Wish();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'main':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->main();
				}
				else
				{
					$this->showIntroduction();
				}
				break;
			case 'doAdd':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->doAdd();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'search':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->search();
				}
				else
				{
					System::echoData(Config::$msg['noLogin']);
				}
				break;
			case 'share':
				$this->share();
				break;
			case 'add':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showAdd();
				}
				else
				{
					$this->showIntroduction();
				}
				break;
			case 'pageSearch':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->showSearch();
				}
				else
				{
					$this->showIntroduction();
				}
				break;
			case 'shareSelf':
				$isLogin = $this->checkLogin();
				if ($isLogin)
				{
					$this->share(true);
				}
				else
				{
					$this->showIntroduction();
				}
				break;
			default:
				$this->showIntroduction();
		}
	}
	
	private function main()
	{
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$wishList = $this->wish->getWish($page, Config::$wishPagesize);
		foreach ($wishList as $key => $value)
		{
			/*
			if (empty($wishList[$key]['localphoto']))
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			}
			else
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['localphoto']);
			}
			$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			$wishList[$key]['username'] = System::fixHtml($wishList[$key]['username']);
			*/
			$wishList[$key]['content'] = System::fixHtml($wishList[$key]['content']);
			$wishList[$key]['bgcolor'] = System::fixHtml($wishList[$key]['bgcolor']);
			$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$monthNum = (int)Utils::mdate('m', $wishList[$key]['pubdate']);
			$month = $monthEn[$monthNum - 1];
			$day = Utils::mdate('d', $wishList[$key]['pubdate']);
			$wishList[$key]['pubdate'] = $month . ', ' . $day;
		}
		//反转列表，使自己的愿望显示在最前面
		$wishList = array_reverse($wishList);
		
		$isWished = $this->wish->checkAdded($this->fbid) ? 'true' : 'false';
		$shareUrl = Config::$baseUrl . '/?m=wish&a=share&fbid=' . $this->fbid;
		$sharePic = Config::$baseUrl . '/images/image/fbshare.jpg';
		$isFb = Config::$isLocal ? 'false' : 'true';
		$fbAppId = Config::$fbAppId;
		$this->showMain($wishList, $isWished, $shareUrl, $sharePic, $isFb, $fbAppId);
	}
	
	private function doAdd()
	{
		$content = Security::varPost('content');
		$bgColor = Security::varPost('bgColor');
		if (empty($content))
		{
			System::echoData(Config::$msg['contentEmpty']);
		}
		else
		{
			if (Config::$debugAddWish)
			{
				$content = substr($content, 0, Config::$maxWish);
				//$bgColor = $this->getBgColor($bgColor);
				$this->wish->add($this->fbid, $content, $bgColor);
				$wishData = $this->wish->getFixWish($this->fbid);
				System::echoData(Config::$msg['ok'], $wishData);
			}
			else
			{
				if ($this->wish->checkAdded($this->fbid))
				{
					System::echoData(Config::$msg['oneChance']);
				}
				else
				{
					$content = substr($content, 0, Config::$maxWish);
					//$bgColor = $this->getBgColor($bgColor);
					$this->wish->add($this->fbid, $content, $bgColor);
					$wishData = $this->wish->getFixWish($this->fbid);
					System::echoData(Config::$msg['ok'], $wishData);
				}
			}
		}
	}
	
	private function getBgColor($bgColor)
	{
		$colorLimit = array('FFFFFF', 'FF0000', '00FF00', '0000FF');
		if (empty($bgColor))
		{
			$bgColor = $colorLimit[0];
		}
		else
		{
			$bgColor = strtoupper($bgColor);
			$exist = false;
			foreach ($colorLimit as $value)
			{
				if ($bgColor == $value)
				{
					$exist = true;
					break;
				}
			}
			if (!$exist)
			{
				//颜色限制
				$bgColor = $colorLimit[0];
			}
		}
		return $bgColor;
	}
	
	private function search()
	{
		$keywords = substr(trim(Security::varPost('keywords')), 0, 100);
		if (empty($keywords))
		{
			$wishList = $this->wish->getWish(1, Config::$wishPagesize);
		}
		else
		{
			$wishList = $this->wish->search($keywords, 1, Config::$wishPagesize);
		}
		foreach ($wishList as $key => $value)
		{
			/*
			if (empty($wishList[$key]['localphoto']))
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			}
			else
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['localphoto']);
			}
			$wishList[$key]['username'] = System::fixHtml($wishList[$key]['username']);
			$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			*/
			$wishList[$key]['content'] = System::fixHtml($wishList[$key]['content']);
			$wishList[$key]['bgcolor'] = System::fixHtml($wishList[$key]['bgcolor']);
			$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$monthNum = (int)Utils::mdate('m', $wishList[$key]['pubdate']);
			$month = $monthEn[$monthNum - 1];
			$day = Utils::mdate('d', $wishList[$key]['pubdate']);
			$wishList[$key]['pubdate'] = $month . ', ' . $day;
		}
		System::echoData(Config::$msg['ok'], array('wishList' => $wishList));
	}
	
	private function share($isSelf = false)
	{
		$fbid = (int) Security::varGet('fbid');
		$wishData = $this->wish->getWishByFbid($fbid);
		if (empty($wishData))
		{
			$this->show404();
		}
		else
		{
			/*
			if (empty($wishData['localphoto']))
			{
				$wishData['photo'] = System::fixHtml($wishData['photo']);
			}
			else
			{
				$wishData['photo'] = System::fixHtml($wishData['localphoto']);
			}
			$wishData['username'] = System::fixHtml($wishData['username']);
			$wishData['photo'] = System::fixHtml($wishData['photo']);
			*/
			$wishData['content'] = System::fixHtml($wishData['content']);
			$wishData['bgcolor'] = System::fixHtml($wishData['bgcolor']);
			$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$monthNum = (int)Utils::mdate('m', $wishData['pubdate']);
			$month = $monthEn[$monthNum - 1];
			$day = Utils::mdate('d', $wishData['pubdate']);
			$wishData['pubdate'] = $month . ', ' . $day;
			if ($isSelf)
			{
				$this->showShareSelf($wishData);
			}
			else
			{
				$this->showShare($wishData);
			}
		}
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin()
	{
		if (Config::$isLocal)
		{
			$this->loginLocal();
			return true;
		}
		else
		{
			if ($this->fb->checkLogin())
			{
				$this->fbid = $this->fb->getUserId();
				if ($this->wish->existUser($this->fbid))
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
					if (!$this->wish->existUser($this->fbid))
					{
						$this->wish->addUser($this->fbid, $me['userProfile']);
					}
					return true;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	private function loginLocal()
	{
		$this->fbid = System::getSession('userTestFbid');
		if (empty($this->fbid))
		{
			$this->fbid = $this->genFbid();
		}
		if (!$this->wish->existUser($this->fbid))
		{
			$username = array('Kity', 'Bruce', 'David', 'Kevin', 'Nancy');
			$photo = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg');
			$gender = array('female', 'male', 'male', 'male', 'female');
			$rand = rand(0, 4);
			$userProfile = array(
				'name' => $username[$rand],
				'photo' => 'images/photo/' . $photo[$rand],
				'email' => 'test@test.com',
				'gender' => $gender[$rand]
			);
			$this->wish->addUser($this->fbid, $userProfile);
		}
	}
	
	private function genFbid()
	{
		$fbid = rand(10000000, 99999999);
		System::setSession('userTestFbid', $fbid);
		return $fbid;
	}
	
	private function showIntroduction()
	{
		if (Config::$isLocal)
		{
			if (Config::$deviceType == 'mobile')
			{
				$loginUrl = '?m=wish&a=main&d=mobile';
			}
			else
			{
				$loginUrl = '?m=wish&a=main';
			}
		}
		else
		{
			$loginUrl = $this->fb->getLoginUrl();
		}
		switch (Config::$deviceType)
		{
			case 'mobile':
				include(Config::$templatesDir . 'wish/mobile_introduction.php');
				break;
			default:
				switch(Config::$configType)
				{
					case 1:
					case 8:
						include(Config::$templatesDir . 'wish/introduction_ma.php');
						break;
					case 7:
						include(Config::$templatesDir . 'wish/introduction_eg.php');
						break;
					default:
						include(Config::$templatesDir . 'wish/introduction.php');
				}
		}
	}
	
	private function showMain($wishList, $isWished, $shareUrl, $sharePic, $isFb, $fbAppId)
	{
		switch (Config::$deviceType)
		{
			case 'mobile':
				include(Config::$templatesDir . 'wish/mobile_main.php');
				break;
			default:
				switch (Config::$configType)
				{
					case 1:
					case 8:
						include(Config::$templatesDir . 'wish/main_ma.php');
						break;
					case 7:
						include(Config::$templatesDir . 'wish/main_eg.php');
						break;
					case 4:
						//wishwalluae
						include(Config::$templatesDir . 'wish/main_uae.php');
						break;
					case 5:
						//wishwallksa
						include(Config::$templatesDir . 'wish/main_ksa.php');
						break;
					default:
						include(Config::$templatesDir . 'wish/main.php');
				}
		}
	}
	
	private function showShare($wishData)
	{
		switch (Config::$deviceType)
		{
			case 'mobile':
				include(Config::$templatesDir . 'wish/mobile_share.php');
				break;
			default:
				include(Config::$templatesDir . 'wish/share.php');
		}
	}
	
	private function showAdd()
	{
		$shareUrl = Config::$baseUrl . '/?m=wish&a=share&fbid=' . $this->fbid;
		$sharePic = Config::$baseUrl . '/images/image/fbshare.jpg';
		$isFb = Config::$isLocal ? 'false' : 'true';
		$fbAppId = Config::$fbAppId;
		include(Config::$templatesDir . 'wish/mobile_add.php');
	}
	
	private function showSearch()
	{
		$shareUrl = Config::$baseUrl . '/?m=wish&a=share&fbid=' . $this->fbid;
		$sharePic = Config::$baseUrl . '/images/image/fbshare.jpg';
		$isFb = Config::$isLocal ? 'false' : 'true';
		$fbAppId = Config::$fbAppId;
		include(Config::$templatesDir . 'wish/mobile_search.php');
	}
	
	private function showShareSelf($wishData)
	{
		$shareUrl = Config::$baseUrl . '/?m=wish&a=share&fbid=' . $this->fbid;
		$sharePic = Config::$baseUrl . '/images/image/fbshare.jpg';
		$isFb = Config::$isLocal ? 'false' : 'true';
		$fbAppId = Config::$fbAppId;
		include(Config::$templatesDir . 'wish/mobile_share_self.php');
	}
	
	private function show404()
	{
		include('404.html');
	}
}
?>
