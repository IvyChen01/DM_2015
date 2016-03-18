<?php
/**
 * 移动Web Zero控制器
 */
class MwZeroController
{
	private $zero = null;
	private $user = null;
	private $fb = null;
	
	public function __construct()
	{
		$this->zero = new MwZero();
		$this->user = new MwUser();
		$this->fb = new Fb();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'rank':
				$this->rank();
				return;
			case 'latest':
				$this->latest();
				return;
			case 'create':
				$this->create();
				return;
			case 'history':
				$this->history();
				return;
			case 'uploadPic':
				$this->uploadPic();
				return;
			case 'getRank':
				$this->getRank();
				return;
			case 'like':
				$this->like();
				return;
			case 'viewPic':
				$this->viewPic();
				return;
			default:
				$this->rank();
		}
	}
	
	private function rank()
	{
		$this->checkLogin(true);
		$res = $this->zero->topTotal(1, 100);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_allCount = $this->zero->getPicCount();
		if ($_allCount > 100)
		{
			$_allCount = 100;
		}
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		include('view/mobile/rank.php');
	}
	
	private function latest()
	{
		$this->checkLogin(true);
		$res = $this->zero->latest(1, 20);
		$_data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$_data[] = array_merge($row, array('liked' => $liked));
		}
		$_allCount = $this->zero->getPicCount();
		if ($_allCount > 20)
		{
			$_allCount = 20;
		}
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		include('view/mobile/latest.php');
	}
	
	private function create()
	{
		$this->checkLogin(true);
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_isFb = Config::$isFb;
		include('view/mobile/create.php');
	}
	
	private function history()
	{
		$_configType = Config::$configType;
		$_fbAppId = Config::$fbAppId;
		$_appUrl = Config::$fbAppUrl;
		$_isFb = Config::$isFb;
		$_bestRank = 0;
		$_totalLikes = 0;
		$_data = array();
		$_userinfo = array();
		
		$this->checkLogin(true);
		$res = $this->zero->myRank();
		$index = 0;
		$isFirst = true;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		$userId = (int)$this->user->getUserId();
		foreach ($res as $key => $row)
		{
			$index++;
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$row['upload_time'] = Utils::mdate('Y-m-d', $row['upload_time']);
			$_data[] = array_merge($row, array('liked' => $liked));
			if ($isFirst)
			{
				$isFirst = false;
				$_bestRank = $row['rank'];
			}
			$_totalLikes += $row['num'];
			if ($index >= 500)
			{
				break;
			}
		}
		$_userinfo = $this->user->getBaseInfo();
		include('view/mobile/history.php');
	}
	
	private function uploadPic()
	{
		System::fixSubmit('uploadPic');
		$this->checkLogin();
		$param = $this->zero->upload();
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
	
	private function getRank()
	{
		
	}
	
	private function checkLogin($isPage = false)
	{
		if (!Config::$isFb)
		{
			$this->checkTestCode();
		}
		
		if (!$this->user->checkLogin())
		{
			if (!$this->user->loginCookie())
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
		include('view/mobile/login.php');
		//$this->redirectLogin();
	}
	
	private function like()
	{
		System::fixSubmit('like');
		$this->checkLogin();
		$picId = (int)Security::varPost('picId');
		if ($this->zero->checkLikeToday($picId))
		{
			Utils::echoData(1, 'Liked Today!');
		}
		else
		{
			if ($picId > 0)
			{
				$this->zero->like($picId);
				Utils::echoData(0, 'ok');
			}
			else
			{
				Utils::echoData(2, 'picId not exist!');
			}
		}
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
		$pageFlag = (int) Security::varGet('pageFlag');
		$_isLogin = $this->user->checkLogin();
		$_picInfo = $this->zero->getPicInfo($picId);
		$_shareLink = Config::$fbAppUrl . '?m=fbzero&a=viewPic&picId=' . $picId;
		
		if (!empty($_picInfo))
		{
			$_isPic = true;
			if ($_isLogin)
			{
				$liked = $this->zero->checkLikeToday($picId) ? 1 : 0;
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
		
		$_backUrl = '';
		switch ($pageFlag)
		{
			case 1:
				$_backUrl = '?m=mwzero&a=rank';
				break;
			case 2:
				$_backUrl = '?m=mwzero&a=latest';
				break;
			case 3:
				$_backUrl = '?m=mwzero&a=history';
				break;
			default:
				$_backUrl = '?m=mwzero&a=rank';
		}
		include('view/mobile/view_pic.php');
	}
}
?>
