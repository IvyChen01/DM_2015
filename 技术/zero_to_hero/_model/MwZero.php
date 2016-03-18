<?php
/**
 *	Zero
 */
class MwZero
{
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->user = new MwUser();
	}
	
	public function upload()
	{
		$img = Security::varPost('img');
		if (empty($img))
		{
			return array('code' => 1, 'info' => 'Empty error!', 'pic' => '', 'smallPic' => '');
		}
		if (strlen($img) > 500000)
		{
			return array('code' => 2, 'info' => 'Size error!', 'pic' => '', 'smallPic' => '');
		}
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$smallPic = $baseName . '_small.jpg';
		$data = base64_decode($img);
		file_put_contents($tempPic, $data);
		Image::thumb($tempPic, $pic, "", 764, 616);
		Image::thumb($tempPic, $smallPic, "", 248, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$smallPicUrl = Config::$baseUrl . '/' . $smallPic;
		$picId = $this->savePic($picUrl, $smallPicUrl);
		return array('code' => 0, 'pic' => $picUrl, 'smallPic' => $smallPicUrl, 'picId' => $picId);
	}
	
	public function savePic($pic, $smallPic)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbUser = Config::$tbUser;
		$sqlPic = Security::varSql($pic);
		$sqlSmallPic = Security::varSql($smallPic);
		$sqlUserId = (int)$this->user->getUserId();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = 3;
		Config::$db->query("insert into $tbPic (pic, small_pic, user_id, do_time, login_type) values ($sqlPic, $sqlSmallPic, $sqlUserId, $sqlDoTime, $sqlLoginType)");
		$picId = Config::$db->getInsertId();
		Config::$db->query("update $tbUser set upload_times = upload_times+1 where id=$sqlUserId");
		return $picId;
	}
	
	public function checkLikeToday($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId and date_format(do_time, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function checkLiked($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		Config::$db->query("select id from $tbLike where pic_id=$sqlPicId and user_id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function like($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$sqlWeek = $this->getCurrentWeek();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = 3;
		Config::$db->query("insert into $tbLike (pic_id, user_id, week, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlWeek, $sqlDoTime, $sqlLoginType)");
	}
	
	public function topTotal($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		if ($pagesize < 1)
		{
			$pagesize = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			$rankIndex = ($page - 1) * $pagesize + 1;
			foreach ($res as $key => $value)
			{
				$res[$key]['rank'] = $rankIndex;
				$rankIndex++;
			}
		}
		return $res;
	}
	
	public function latest($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function myRank()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$userId = (int)$this->user->getUserId();
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$selfRank = array();
		if (!empty($res))
		{
			foreach ($res as $key => $row)
			{
				if ($userId == $row['open_id'])
				{
					$selfRank[] = array_merge($row, array('rank' => $rankIndex));
				}
				$rankIndex++;
			}
		}
		return $selfRank;
	}
	
	public function getCurrentWeek()
	{
		$day = Utils::restDays(Config::$startDate, Utils::mdate('Y-m-d'));
		$week = (int)($day / 7) + 1;
		return $week;
	}
	
	public function addComment($picId, $content)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		$content = json_encode(mb_substr($content, 0, 500));
		$sqlContent = Security::varSql($content);
		$sqlLoginType = 3;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbComment (pic_id, user_id, content, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlContent, $sqlDoTime, $sqlLoginType)");
	}
	
	public function checkCommentLock($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$this->user->getUserId();
		Config::$db->query("select do_time from $tbComment where pic_id=$sqlPicId and user_id=$sqlUserId order by id desc limit 0, 1");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			$lastTime = $res['do_time'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($lastTime, $now) <= 60)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getComment($picId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$tbUser = Config::$tbUser;
		$sqlPicId = (int)$picId;
		Config::$db->query("select t1.id id, t1.pic_id pic_id, t1.user_id user_id, t1.content content, t1.do_time comment_time, t2.username username, t2.local_photo photo from $tbComment t1 join $tbUser t2 on t1.user_id=t2.id where pic_id=$sqlPicId order by id desc limit 0, 1000");
		$res = Config::$db->getAllRows();
		if (!empty($res))
		{
			foreach ($res as $key => $row)
			{
				$res[$key]['comment_time'] = Utils::mdate('Y-m-d', $row['comment_time']);
				$res[$key]['content'] = htmlspecialchars(json_decode($row['content'], true), ENT_QUOTES);
			}
		}
		return $res;
	}
	
	public function getPicCount()
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		Config::$db->query("select count(*) as num from $tbPic");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getPicInfo($picId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$picId = (int)$picId;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$picInfo = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				if ($picId == $row['pic_id'])
				{
					$picInfo = array_merge($row, array('rank' => $rankIndex));
					$picInfo['upload_time'] = Utils::mdate('Y-m-d', $picInfo['upload_time']);
					break;
				}
				$rankIndex++;
			}
		}
		
		return $picInfo;
	}
	
	public function getPicLikeNum($picId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		Config::$db->query("select count(*) as num from $tbLike where pic_id=$sqlPicId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	public function getLikesKey()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select pic_id, user_id, do_time from $tbLike");
		$res = Config::$db->getAllRows();
		$arr = array();
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$arr[$row['pic_id'] . '_' . $row['user_id'] . '_' . Utils::mdate('Y-m-d', $row['do_time'])] = 1;
			}
		}
		return $arr;
	}
}
?>
