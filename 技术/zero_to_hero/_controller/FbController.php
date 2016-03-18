<?php
/**
 * Facebook控制器
 */
class FbController
{
	private $fb = null;//会员模型
	
	public function __construct()
	{
		$this->fb = new Fb();
		
		//奇偶页跳转登录
		$pageFlag = $this->fb->getPageFlag();
		if (1 == $pageFlag)
		{
			$this->fb->setPageFlag(0);
			echo '<a href="' . Config::$fbAppUrl . '" target="_top">Refresh</a><script type="text/javascript"> top.location.href = "' . Config::$fbAppUrl . '"; </script>';
			return;
		}
		
		if ($this->fb->checkLogin())
		{
			$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
			switch ($action)
			{
				case 'me':
					$this->me();
					break;
				case 'feed':
					$this->feed();
					break;
				case 'apprequests':
					$this->apprequests();
					break;
				case 'photos':
					$this->photos();
					break;
				case 'friends':
					$this->friends();
					break;
				case 'naitik':
					$this->naitik();
					break;
				case 'like':
					$this->like();
					break;
				case 'logFeed':
					$this->logFeed();
					break;
				case 'logInvite':
					$this->logInvite();
					break;
				default:
					//$this->main();
					$this->me();
			}
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function redirectLogin()
	{
		$this->fb->setPageFlag(1);
		$loginUrl = $this->fb->getLoginUrl();
		echo '<a href="' . $loginUrl . '" target="_top">Login with Facebook</a><script type="text/javascript"> top.location.href = "' . $loginUrl . '"; </script>';
	}
	
	private function me()
	{
		$res = $this->fb->me();
		$code = $res['code'];
		$userProfile = $res['userProfile'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$userProfile:<br />';
			var_dump($userProfile);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function feed()
	{
		$res = $this->fb->feed();
		$code = $res['code'];
		$feed = $res['feed'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$feed:<br />';
			var_dump($feed);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function apprequests()
	{
		$res = $this->fb->apprequests();
		$code = $res['code'];
		$apprequests = $res['apprequests'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$apprequests:<br />';
			var_dump($apprequests);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function photos()
	{
		$res = $this->fb->photos();
		$code = $res['code'];
		$photos = $res['photos'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$photos:<br />';
			var_dump($photos);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function friends()
	{
		$res = $this->fb->friends();
		$code = $res['code'];
		$friends = $res['friends'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$friends:<br />';
			var_dump($friends);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function naitik()
	{
		$res = $this->fb->naitik();
		$code = $res['code'];
		$naitik = $res['naitik'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$naitik:<br />';
			var_dump($naitik);
			echo '<br />';
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function like()
	{
		$res = $this->fb->like();
		$code = $res['code'];
		$info = $res['info'];
		if (0 == $code)
		{
			echo 'userId: ' . $this->fb->userId . '<br />';
			echo '$info:<br />';
			var_dump($info);
			echo '<br />';
		}
		else
		{
			echo 'error<br />';
			//$this->redirectLogin();
		}
	}
	
	private function logFeed()
	{
		$user = new User();
		$user->add_feed($this->fb->userId);
	}
	
	private function logInvite()
	{
		$user = new User();
		$user->add_invite($this->fb->userId);
	}
	
	private function main()
	{
		$res = $this->fb->me();
		$code = $res['code'];
		$userProfile = $res['userProfile'];
		if (0 == $code && !empty($userProfile))
		{
			$this->addUser($userProfile);
			$_['fbAppId'] = Config::$fbAppId;
			$_['userId'] = $this->fb->userId;
			$_['pagetab_uri'] = Config::$fbAppRedirectUrl;
			include('view/index.php');
		}
		else
		{
			$this->redirectLogin();
		}
	}
	
	private function addUser($userProfile)
	{
		$user = new User();
		$fbid = $this->fb->userId;
		if (!empty($fbid) && !empty($userProfile) && !$user->exist_user($fbid))
		{
			$username = isset($userProfile['username']) ? $userProfile['username'] : '';
			$email = isset($userProfile['email']) ? $userProfile['email'] : '';
			$link = isset($userProfile['link']) ? $userProfile['link'] : '';
			$realname = isset($userProfile['name']) ? $userProfile['name'] : '';
			$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
			$timezone = isset($userProfile['timezone']) ? $userProfile['timezone'] : '';
			$locale = isset($userProfile['locale']) ? $userProfile['locale'] : '';
			$user->addUser($fbid, $username, $email, $link, $realname, $gender, $timezone, $locale);
		}
	}
}
?>
