<?php
/**
 * Zero控制器
 */
class FbZeroController
{
	private $zero = null;
	private $user = null;
	private $fb = null;
	
	public function __construct()
	{
		$this->zero = new FbZero();
		$this->user = new FbUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'addPage':
				$_fbAppId = Config::$fbAppId;
				$_isFb = Config::$isFb;
				$_appSrcUrl = Config::$fbAppRedirectUrl;
				$_configType = Config::$configType;
				include('view/addPage.php');
				return;
			case 'testLogin':
				$testCode = Security::varPost('code');
				if ($testCode != 'zero')
				{
					Utils::echoData(1, 'code error');
					return;
				}
				else
				{
					System::setSession('userTestCode', 'zero');
					System::setSession('userTestFbid', rand(10000000, 99999999));
					Utils::echoData(0, 'ok');
				}
				return;
			case 'agreement':
				$this->agreement();
				return;
			case 'upload':
				$this->upload();
				return;
			case 'like':
				$this->like();
				return;
			case 'topTotal':
				$this->topTotal();
				return;
			case 'myRank':
				$this->myRank();
				return;
			case 'viewPic':
				$this->viewPic();
				return;
			case 'addComment':
				$this->addComment();
				return;
			case 'latest':
				$this->latest();
				return;
			default:
				$this->main();
		}
	}
	
	private function agreement()
	{
		System::fixSubmit('agreement');
		$nick = Security::varPost('nick');
		$email = Security::varPost('email');
		if (empty($nick))
		{
			Utils::echoData(2, 'Please enter the nickname!');
		}
		else
		{
			if ($this->user->existUsername($nick))
			{
				Utils::echoData(3, 'Nickname exist!');
			}
			else
			{
				if (!Check::email($email))
				{
					Utils::echoData(1, 'Please enter the correct email!');
				}
				else
				{
					$this->checkLogin();
					$userId = $this->user->getUserId();
					$fbid = $this->fb->userId;
					$photo = 'https://graph.facebook.com/' . $fbid . '/picture';
					//$this->zero->agreement($userId);
					$this->zero->agreementEmail($userId, $nick, $email, $photo);
					Utils::echoData(0, 'ok');
				}
			}
		}
	}
	
	private function upload()
	{
		System::fixSubmit('upload');
		$this->checkLogin();
		$userId = $this->user->getUserId();
		$param = $this->zero->upload($userId, 1);
		$code = $param['code'];
		$pic = $param['pic'];
		$smallPic = $param['smallPic'];
		$picId = $param['picId'];
		
		switch ($code)
		{
			case 0:
				$shareUrl = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
				Utils::echoData(0, 'ok', array('pic' => $pic, 'smallPic' => $smallPic, 'shareUrl' => $shareUrl, 'sharePic' => $smallPic));
				break;
			case 1:
				Utils::echoData(1, 'empty error!');
				break;
			case 2:
				Utils::echoData(2, 'size error!');
				break;
			default:
				Utils::echoData(3, 'upload error!');
		}
	}
	
	private function like()
	{
		System::fixSubmit('like');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		$userId = $this->user->getUserId();
		if ($this->zero->checkLikeToday($picId, $userId))
		{
			Utils::echoData(1, 'Liked Today!');
		}
		else
		{
			if ($picId > 0)
			{
				$this->zero->like($picId, $userId, 1);
				Utils::echoData(0, 'ok');
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
	}
	
	private function topTotal()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > 25)
		{
			$page = 25;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=topTotal&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		if ($allCount > 100)
		{
			$allCount = 100;
		}
		$pagelist->totalPage = ceil($allCount / 4);
		$_pagelist = $pagelist->getPages($page);
		$res = $this->zero->topTotal($page, 4);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/rank_total.php');
	}
	
	private function latest()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > 5)
		{
			$page = 5;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=latest&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		if ($allCount > 20)
		{
			$allCount = 20;
		}
		$pagelist->totalPage = ceil($allCount / 4);
		$_pagelist = $pagelist->getPages($page);
		$res = $this->zero->latest($page, 4);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/latest_upload.php');
	}
	
	private function myRank()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=fbzero&a=myRank&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$res = $this->zero->myRank($userId);
		$pagelist->totalPage = ceil(count($res) / 4);
		$_pagelist = $pagelist->getPages($page);
		$_data = array();
		$index = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$index++;
			if ($index > ($page - 1) * 4 && $index <= $page * 4)
			{
				$picId = $row['pic_id'];
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
				$_data[] = array_merge($row, array('liked' => $liked));
			}
			if ($index > $page * 4)
			{
				break;
			}
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/rank_self.php');
	}
	
	private function viewPic()
	{
		$_isPic = false;
		$_isLogin = false;
		$_picInfo = array();
		$_comment = array();
		$_selfPhoto = 'images/comment_photo.png';
		$_fbAppId = Config::$fbAppId;
		$_shareLink = '';
		
		$picId = (int) Security::varGet('picId');
		$_isLogin = $this->user->checkLogin();
		$_picInfo = $this->zero->getPicInfo($picId);
		$_shareLink = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
		
		if (!empty($_picInfo))
		{
			$_isPic = true;
			if ($_isLogin)
			{
				$userId = $this->user->getUserId();
				$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$_selfPhoto = $this->user->getUserPhoto();
			}
			else
			{
				$liked = 0;
			}
			$_picInfo['liked'] = $liked;
			$_comment = $this->zero->getComment($picId);
		}
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/view_pic.php');
	}
	
	private function addComment()
	{
		System::fixSubmit('addComment');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		$comment = Security::varPost('comment');
		$userId = $this->user->getUserId();
		if ($this->zero->checkCommentLock($picId, $userId))
		{
			Utils::echoData(1, 'Comments interval 60s.');
		}
		else
		{
			if ($picId > 0)
			{
				if (empty($comment))
				{
					Utils::echoData(3, 'Comments empty!');
				}
				else
				{
					$this->zero->addComment($picId, $userId, $comment, 1);
					$res = $this->zero->getComment($picId);
					Utils::echoData(0, 'ok', array('comments' => $res));
				}
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
	}
	
	private function main()
	{
		$this->checkLogin(true);
		$userId = $this->user->getUserId();
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		
		if ($this->zero->checkAgreement($userId))
		{
			include('view/main.php');
		}
		else
		{
			include('view/agreement.php');
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
			if ($this->fb->checkLogin())
			{
				$fbid = $this->fb->userId;
				if (!$this->user->existFbid($this->fb->userId))
				{
					$this->user->addFbid($fbid);
				}
				$this->user->loginFb($fbid);
			}
			else
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
	
	/**
	 * 显示登录界面
	 */
	private function login()
	{
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		$_configType = Config::$configType;
		include('view/agreement.php');
		//$this->redirectLogin();
	}
	
	private function flagRedirect()
	{
		//奇偶页跳转登录
		$pageFlag = $this->fb->getPageFlag();
		if (1 == $pageFlag)
		{
			$this->fb->setPageFlag(0);
			echo '<a href="' . Config::$fbAppUrl . '" target="_top">Refresh</a><script type="text/javascript"> top.location.href = "' . Config::$fbAppUrl . '"; </script>';
			exit(0);
		}
	}
	
	private function redirectLogin()
	{
		$this->fb->setPageFlag(1);
		$loginUrl = $this->fb->getLoginUrl();
		echo '<a href="' . $loginUrl . '" target="_top">Login with Facebook</a><script type="text/javascript"> top.location.href = "' . $loginUrl . '"; </script>';
		exit(0);
	}
}
?>
