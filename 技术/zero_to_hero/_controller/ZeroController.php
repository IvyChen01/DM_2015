<?php
/**
 * Zero控制器
 */
class ZeroController
{
	private $zero = null;
	private $user = null;
	
	public function __construct()
	{
		$this->zero = new Zero();
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'agreement':
				$this->agreement();
				return;
			case 'upload':
				$this->upload();
				return;
			case 'like':
				$this->like();
				return;
			case 'getTopTotal':
				$this->getTopTotal();
				return;
			case 'getLatest':
				$this->getLatest();
				return;
			case 'getMyRank':
				$this->getMyRank();
				return;
			case 'viewRank':
				$this->viewRank();
				return;
			case 'findUser':
				$this->findUser();
				return;
			case 'getComment':
				$this->getComment();
				return;
			case 'addComment':
				$this->addComment();
				return;
			default:
		}
	}
	
	private function agreement()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$this->zero->agreement($userId);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid));
	}
	
	private function upload()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$param = $this->zero->upload($userId, 2);
		$code = $param['code'];
		$pic = $param['pic'];
		$smallPic = $param['smallPic'];
		$msg = $param['msg'];
		$picId = $param['picId'];
		
		switch ($code)
		{
			case 0:
				Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'pic' => $pic, 'smallPic' => $smallPic, 'picId' => $picId));
				break;
			case 1:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
				break;
			default:
				Utils::echoData(1, $msg, array('imei' => $imei, 'uid' => $uid));
		}
	}
	
	private function like()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		if ($this->zero->checkLikeToday($picId, $userId))
		{
			Utils::echoData(1, 'liked');
		}
		else
		{
			$this->zero->like($picId, $userId, 2);
			$num = $this->zero->getPicLikeNum($picId);
			Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'num' => $num));
		}
	}
	
	private function getTopTotal()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$page = (int)Security::varPost('page');
		$pagesize = (int) Security::varPost('pagesize');
		if ($page < 1)
		{
			$page =  1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 100;
		}
		if ($pagesize > 1000)
		{
			$pagesize = 1000;
		}
		$from = ($page - 1) * $pagesize;
		$total = $this->zero->getPicCount();
		if ($total > 1000)
		{
			$total = 1000;
		}
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$res = $this->zero->topTotal(1000);
		$data = array();
		$index = 0;
		$count = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			if ($index >= $from)
			{
				$picId = $row['pic_id'];
				if ($isLogin)
				{
					//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
					$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
				}
				else
				{
					$liked = 0;
				}
				$data[] = array_merge($row, array('liked' => $liked));
				$count++;
				if ($count >= $pagesize)
				{
					break;
				}
			}
			$index++;
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'total' => $total, 'data' => $data));
	}
	
	private function getLatest()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$page = (int)Security::varPost('page');
		$pagesize = (int) Security::varPost('pagesize');
		if ($page < 1)
		{
			$page =  1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 100;
		}
		if ($pagesize > 1000)
		{
			$pagesize = 1000;
		}
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$total = $this->zero->getPicCount();
		$res = $this->zero->latest($page, $pagesize);
		$data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			if ($isLogin)
			{
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			}
			else
			{
				$liked = 0;
			}
			$data[] = array_merge($row, array('liked' => $liked));
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'total' => $total, 'data' => $data));
	}
	
	private function getMyRank()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		$res = $this->zero->myRank($userId);
		$data = array();
		$index = 0;
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$index++;
			$picId = $row['pic_id'];
			//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
			$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			$data[] = array_merge($row, array('liked' => $liked));
			if ($index >= 500)
			{
				break;
			}
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
	}
	
	private function viewRank()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$openId = Security::varPost('openId');
		$isLogin = $this->user->checkLoginImei($uid);
		if ($isLogin)
		{
			$userId = $this->user->getUserId($uid);
		}
		$res = $this->zero->myRank($openId);
		$data = array();
		$likes = $this->zero->getLikesKey();
		$date = Utils::mdate('Y-m-d');
		foreach ($res as $row)
		{
			$picId = $row['pic_id'];
			if ($isLogin)
			{
				//$liked = $this->zero->checkLikeToday($picId, $userId) ? 1 : 0;
				$liked = isset($likes[$picId . '_' . $userId . '_' . $date]) ? 1 : 0;
			}
			else
			{
				$liked = 0;
			}
			$data[] = array_merge($row, array('liked' => $liked));
		}
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'openId' => $openId, 'data' => $data));
	}
	
	private function findUser()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$username = Security::varPost('username');
		$openId = $this->user->getIdByName($username);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'openId' => $openId));
	}
	
	private function getComment()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$data = $this->zero->getComment($picId);
		Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
	}
	
	private function addComment()
	{
		$imei = Security::varPost('imei');
		$uid = Security::varPost('uid');
		$picId = Security::varPost('picId');
		$comment = Security::varPost('comment');
		$this->checkLogin($uid);
		$userId = $this->user->getUserId($uid);
		if ($this->zero->checkCommentLock($picId, $userId))
		{
			Utils::echoData(111, 'Comments interval 60s.');
		}
		else
		{
			if ($picId > 0)
			{
				if (empty($comment))
				{
					Utils::echoData(113, 'Comments empty!');
				}
				else
				{
					$this->zero->addComment($picId, $userId, $comment, 2);
					$data = $this->zero->getComment($picId);
					Utils::echoData(0, 'ok', array('imei' => $imei, 'uid' => $uid, 'data' => $data));
				}
			}
			else
			{
				Utils::echoData(112, 'picId not exist!');
			}
		}
	}
	
	private function checkLogin($uid)
	{
		if (!$this->user->checkLoginImei($uid))
		{
			Utils::echoData(101, 'Not logged in!');
			exit(0);
		}
	}
}
?>
