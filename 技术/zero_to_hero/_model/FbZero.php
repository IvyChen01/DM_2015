<?php
/**
 *	Zero
 */
class FbZero
{
	public function __construct()
	{
	}
	
	public function agreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("UPDATE $tbUser SET agreement=1 WHERE id=$sqlUserId");
	}
	
	public function agreementEmail($userId, $nick, $email)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		$sqlNick = Security::varSql($nick);
		$sqlEmail = Security::varSql($email);
		Config::$db->query("UPDATE $tbUser SET agreement=1, username=$sqlNick, realname=$sqlNick, email=$sqlEmail WHERE id=$sqlUserId");
	}
	
	public function checkAgreement($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlUserId = (int)$userId;
		Config::$db->query("select agreement from $tbUser WHERE id=$sqlUserId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			if (1 == $res['agreement'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function upload($userId, $loginType)
	{
		$baseName = Config::$dirUploads . time() . rand(100000, 999999);
		$tempPic = $baseName . '_temp.jpg';
		$pic = $baseName . '.jpg';
		$smallPic = $baseName . '_small.jpg';
		//$postStr =  $GLOBALS[HTTP_RAW_POST_DATA];
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		if (empty($postStr))
		{
			$postStr = file_get_contents('php://input');
		}
		if (empty($postStr))
		{
			return array('code' => 1, 'pic' => '', 'smallPic' => '');
		}
		if (strlen($postStr) > 500000)
		{
			return array('code' => 2, 'pic' => '', 'smallPic' => '');
		}
		$file = fopen($tempPic, 'w');
		fwrite($file, $postStr);
		fclose($file);
		Image::thumb($tempPic, $pic, "", 764, 616);
		Image::thumb($tempPic, $smallPic, "", 248, 200);
		@unlink($tempPic);
		
		$picUrl = Config::$baseUrl . '/' . $pic;
		$smallPicUrl = Config::$baseUrl . '/' . $smallPic;
		$picId = $this->savePic($picUrl, $smallPicUrl, $userId, $loginType);
		
		return array('code' => 0, 'pic' => $picUrl, 'smallPic' => $smallPicUrl, 'picId' => $picId);
	}
	
	public function savePic($pic, $smallPic, $userId, $loginType)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbUser = Config::$tbUser;
		$sqlPic = Security::varSql($pic);
		$sqlSmallPic = Security::varSql($smallPic);
		$sqlUserId = (int)$userId;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
		Config::$db->query("insert into $tbPic (pic, small_pic, user_id, do_time, login_type) values ($sqlPic, $sqlSmallPic, $sqlUserId, $sqlDoTime, $sqlLoginType)");
		$picId = Config::$db->getInsertId();
		Config::$db->query("update $tbUser set upload_times = upload_times+1 where id=$sqlUserId");
		return $picId;
	}
	
	public function checkLikeToday($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
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
	
	public function checkLiked($picId, $userId)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
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
	
	public function like($picId, $userId, $loginType)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$sqlWeek = $this->getCurrentWeek();
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoginType = (int)$loginType;
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
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
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
	
	public function myRank($userId)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$sqlWeek = $this->getCurrentWeek();
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc");
		$res = Config::$db->getAllRows();
		
		$rankIndex = 1;
		$selfRank = array();
		if (!empty($res))
		{
			foreach ($res as $row)
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
	
	public function addComment($picId, $userId, $content, $loginType)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
		$content = json_encode(mb_substr($content, 0, 500));
		$sqlContent = Security::varSql($content);
		$sqlLoginType = (int)$loginType;
		$sqlDoTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbComment (pic_id, user_id, content, do_time, login_type) values ($sqlPicId, $sqlUserId, $sqlContent, $sqlDoTime, $sqlLoginType)");
	}
	
	public function checkCommentLock($picId, $userId)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		$sqlUserId = (int)$userId;
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
	
	public function getUsersCount()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select count(*) as num from $tbUser");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
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
	
	public function getLikesCount()
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		Config::$db->query("select count(*) as num from $tbLike");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function getCommentsCount()
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		Config::$db->query("select count(*) as num from $tbComment");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function usersCountByType($type)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbUser where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function picCountByType($type)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbPic where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function likesCountByType($type)
	{
		Config::$db->connect();
		$tbLike = Config::$tbLike;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbLike where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
	}
	
	public function commentsCountByType($type)
	{
		Config::$db->connect();
		$tbComment = Config::$tbComment;
		$sqlType = (int)$type;
		Config::$db->query("select count(*) as num from $tbComment where login_type=$sqlType");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return $res['num'];
		}
		return 0;
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
	
	public function getPics($page, $pagesize)
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
		Config::$db->query("select t1.id as pic_id, count(pic_id) as num, t1.pic as pic, t1.small_pic as small_pic, t1.do_time as upload_time, t3.username as username, t3.local_photo as photo, t3.id as open_id, t3.phone as phone, t3.email as email from $tbPic t1 left join $tbLike t2 on t1.id=t2.pic_id left join $tbUser t3 on t1.user_id=t3.id group by t1.id order by num desc, t1.id desc limit $from, $pagesize");
		$res = Config::$db->getAllRows();
		return $res;
	}
	
	public function deletePic($picId)
	{
		Config::$db->connect();
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$sqlPicId = (int)$picId;
		Config::$db->query("delete from $tbLike where pic_id=$sqlPicId");
		Config::$db->query("delete from $tbComment where pic_id=$sqlPicId");
		Config::$db->query("delete from $tbPic where id=$sqlPicId");
	}
}
?>
