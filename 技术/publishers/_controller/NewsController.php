<?php
/**
 * 新闻模块
 * @author Shines
 */
class NewsController
{
	private $news = null;//新闻
	private $user = null;//用户
	
	public function __construct()
	{
		$this->news = new News();
		$this->user = new User();
	}
	
	public function updateNews()
	{
		System::fixSubmit('updateNews');
		$key = Security::varGet('key');
		if ($key == 'fjajwiweincnfhf1234151')
		{
			$this->news->updateNews();
			echo 'ok';
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	public function getRecentNews()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countNews();
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->getNews($page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function getChannelNews()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		$channel = Security::varPost('channel');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countChannelNews($channel);
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->getChannelNews($channel, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function getComment()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = Security::varPost('newsId');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countComment($newsId);
		$comment = $this->news->getComment($newsId, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($comment as $key => $value)
			{
				if ($this->news->checkCommentLiked($uid, $value['id']))
				{
					$comment[$key]['liked'] = 1;
				}
			}
		}
		$arr = array('total' => $total, 'data' => $comment);
		System::echoData(Config::$msg['ok'], $arr);
	}
	
	public function addComment()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = Security::varPost('newsId');
		$content = Security::varPost('content');
		if (empty($newsId) || empty($content))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$commentId = $this->news->addComment($newsId, $uid, $content);
			$comment = $this->news->getCommentById($commentId);
			$userinfo = $this->user->getUserInfo();
			$comment['username'] = $userinfo['username'];
			$comment['nick'] = $userinfo['nick'];
			$comment['photo'] = $userinfo['photo'];
			$comment['liked'] = 0;
			System::echoData(Config::$msg['ok'], array('data' => array($comment)));
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getChannel()
	{
		Config::$sid = Security::varPost('imei');
		$allChannel = $this->news->getChannel();
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$userChannel = $this->news->getUserChannel($uid);
			$userChannelArr = array();
			if (!empty($userChannel))
			{
				$userChannelArr = json_decode($userChannel, true);
			}
			$index = 1;
			$subIndex1 = 1;
			$subIndex2 = 0;
			foreach ($allChannel as $key => $value)
			{
				$allChannel[$key]['index'] = $index;
				if (in_array($value['channel'], $userChannelArr))
				{
					$allChannel[$key]['follow'] = 1;
					$allChannel[$key]['followIndex'] = $subIndex1;
					$subIndex1++;
				}
				else
				{
					$allChannel[$key]['follow'] = 0;
					$allChannel[$key]['followIndex'] = $subIndex2;
					$subIndex2++;
				}
				$index++;
			}
			$allChannel = array_merge(array(array('channel' => 'Recommend', 'index' => 0, 'follow' => 1, 'followIndex' => 0)), $allChannel);
		}
		else
		{
			$index = 1;
			$subIndex = 1;
			foreach ($allChannel as $key => $value)
			{
				$allChannel[$key]['index'] = $index;
				$allChannel[$key]['follow'] = 0;
				$allChannel[$key]['followIndex'] = $subIndex;
				$subIndex++;
				$index++;
			}
			$allChannel = array_merge(array(array('channel' => 'Recommend', 'index' => 0, 'follow' => 0, 'followIndex' => 0)), $allChannel);
		}
		System::echoData(Config::$msg['ok'], array('data' => $allChannel));
	}
	
	public function addUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		$place = Security::varPost('place');
		if (empty($channel) || empty($place))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->addUserChannel($uid, $channel, $place);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function removeUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		if (empty($channel))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->removeUserChannel($uid, $channel);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function moveUserChannel()
	{
		Config::$sid = Security::varPost('imei');
		$channel = Security::varPost('channel');
		$place = Security::varPost('place');
		if (empty($channel) || empty($place))
		{
			System::echoData(Config::$msg['requestError']);
			return;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->moveUserChannel($uid, $channel, $place);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getLike()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		$res = $this->news->getCommentLikes($commentId);
		$total = $this->news->countCommentLikes($commentId);
		System::echoData(Config::$msg['ok'], array('total' => $total, 'data' => $res));
	}
	
	public function like()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->likeComment($uid, $commentId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function unlike()
	{
		Config::$sid = Security::varPost('imei');
		$commentId = (int)Security::varPost('commentId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->unlikeComment($uid, $commentId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getCollection()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$total = $this->news->countCollection($uid);
			$newsArr = array('total' => $total, 'data' => array());
			$res = $this->news->getCollection($uid, $page, $pagesize);
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 1;
				$newsArr['data'][] = $value;
			}
			System::echoData(Config::$msg['ok'], $newsArr);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function collect()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = (int)Security::varPost('newsId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->collect($uid, $newsId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function uncollect()
	{
		Config::$sid = Security::varPost('imei');
		$newsId = (int)Security::varPost('newsId');
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$this->news->uncollect($uid, $newsId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function getMyComments()
	{
		Config::$sid = Security::varPost('imei');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			$total = $this->news->countUserComments($uid);
			$newsArr = array('total' => $total, 'data' => array());
			$res = $this->news->getUserComments($uid, $page, $pagesize);
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$userinfo = $this->user->getUserInfo();
				$value['username'] = $userinfo['username'];
				$value['nick'] = $userinfo['nick'];
				$value['photo'] = $userinfo['photo'];
				if ($this->news->checkCommentLiked($uid, $value['id']))
				{
					$value['liked'] = 1;
				}
				else
				{
					$value['liked'] = 0;
				}
				$newsArr['data'][] = $value;
			}
			System::echoData(Config::$msg['ok'], $newsArr);
		}
		else
		{
			System::echoData(Config::$msg['noLogin']);
		}
	}
	
	public function search()
	{
		Config::$sid = Security::varPost('imei');
		$keywords = Security::varPost('keywords');
		$page = (int)Security::varPost('page');
		$pagesize = (int)Security::varPost('pagesize');
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$total = $this->news->countSearch($keywords);
		$newsArr = array('total' => $total, 'data' => array());
		$res = $this->news->search($keywords, $page, $pagesize);
		if ($this->user->checkLogin())
		{
			$uid = $this->user->getUid();
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$colletDate = $this->news->getCollectDate($uid, $value['newsid']);
				$value['collect_date'] = $colletDate;
				if (empty($colletDate))
				{
					$value['collected'] = 0;
				}
				else
				{
					$value['collected'] = 1;
				}
				$newsArr['data'][] = $value;
			}
		}
		else
		{
			foreach ($res as $value)
			{
				$newsImg = $this->news->getNewsImage($value['newsid']);
				$value['images'] = $newsImg;
				$value['commentCount'] = $this->news->countComment($value['newsid']);
				$value['collected'] = 0;
				$value['collect_date'] = '';
				$newsArr['data'][] = $value;
			}
		}
		System::echoData(Config::$msg['ok'], $newsArr);
	}
	
	public function test()
	{
		$this->news->test();
	}
}
?>
