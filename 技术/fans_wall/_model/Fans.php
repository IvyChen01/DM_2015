<?php
class Fans
{
	public function __construct()
	{
	}
	
	public function getFansByTime()
	{
		Config::$db->connect();
		$tbFans = Config::$tbFans;
		Config::$db->query("select * from $tbFans order by pubtime desc");
		return Config::$db->getAllRows();
	}
	
	public function getFansByLike()
	{
		Config::$db->connect();
		$tbFans = Config::$tbFans;
		Config::$db->query("select * from $tbFans order by like_num desc");
		return Config::$db->getAllRows();
	}
	
	public function getFansById($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFans = Config::$tbFans;
		Config::$db->query("select * from $tbFans where id=$sqlId");
		return Config::$db->getRow();
	}
	
	public function add($photo, $username, $content, $pubtime)
	{
		Config::$db->connect();
		$sqlPhoto = Security::varSql($photo);
		$sqlUsername = Security::varSql($username);
		$sqlContent = Security::varSql($content);
		$pubtime = Utils::mdate('Y-m-d H:i:s', $pubtime);
		$sqlPubtime = Security::varSql($pubtime);
		$tbFans = Config::$tbFans;
		Config::$db->query("insert into $tbFans (photo, username, content, pubtime, like_num, share_num) values ($sqlPhoto, $sqlUsername, $sqlContent, $sqlPubtime, 0, 0)");
	}
	
	public function modify($id, $photo, $username, $content, $pubtime)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$sqlPhoto = Security::varSql($photo);
		$sqlUsername = Security::varSql($username);
		$sqlContent = Security::varSql($content);
		$pubtime = Utils::mdate('Y-m-d H:i:s', $pubtime);
		$sqlPubtime = Security::varSql($pubtime);
		$tbFans = Config::$tbFans;
		Config::$db->query("update $tbFans set photo=$sqlPhoto, username=$sqlUsername, content=$sqlContent, pubtime=$sqlPubtime where id=$sqlId");
	}
	
	public function delete($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFans = Config::$tbFans;
		Config::$db->query("delete from $tbFans where id=$sqlId");
	}
	
	/**
	 * 记录当前修改的新闻id
	 */
	public function setModifyId($id)
	{
		System::setSession('adminFansModifyId', (int)$id);
	}
	
	/**
	 * 获取当前修改的新闻id
	 */
	public function getModifyId()
	{
		return (int)System::getSession('adminFansModifyId');
	}
	
	public function checkLike($ip, $photoId)
	{
		Config::$db->connect();
		$sqlIp = Security::varSql($ip);
		$sqlPhotoId = (int)$photoId;
		$tbIpLike = Config::$tbIpLike;
		Config::$db->query("select pubtime from $tbIpLike where ip=$sqlIp and photo_id=$sqlPhotoId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			//返回1，可以点赞，无ip记录
			return 1;
		}
		else
		{
			$date = $res['pubtime'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($date, $now) < 24 * 3600)
			{
				//返回0，点赞间隔没超过24小时，不可以点赞
				return 0;
			}
			else
			{
				//返回2，可以点赞，有ip记录
				return 2;
			}
		}
	}
	
	public function setLike($photoId)
	{
		Config::$db->connect();
		$ip = Utils::getClientIp();
		$sqlIp = Security::varSql($ip);
		$sqlPhotoId = (int)$photoId;
		$date = Utils::mdate('Y-m-d H:i:s');
		$sqlDate = Security::varSql($date);
		$tbIpLike = Config::$tbIpLike;
		$tbFans = Config::$tbFans;
		$code = $this->checkLike($ip, $sqlPhotoId);
		
		switch ($code)
		{
			case 0:
				return false;
			case 1:
				Config::$db->query("insert into $tbIpLike (ip, photo_id, pubtime) values ($sqlIp, $sqlPhotoId, $sqlDate)");
				Config::$db->query("update $tbFans set like_num=like_num+1 where id=$sqlPhotoId");
				return true;
			case 2:
				Config::$db->query("update $tbIpLike set pubtime=$sqlDate where ip=$sqlIp and photo_id=$sqlPhotoId");
				Config::$db->query("update $tbFans set like_num=like_num+1 where id=$sqlPhotoId");
				return true;
			default:
		}
	}
	
	public function checkShare($ip, $photoId)
	{
		Config::$db->connect();
		$sqlIp = Security::varSql($ip);
		$sqlPhotoId = (int)$photoId;
		$tbIpShare = Config::$tbIpShare;
		Config::$db->query("select pubtime from $tbIpShare where ip=$sqlIp and photo_id=$sqlPhotoId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			//返回1，可以点赞，无ip记录
			return 1;
		}
		else
		{
			$date = $res['pubtime'];
			$now = Utils::mdate('Y-m-d H:i:s');
			if (Utils::restSeconds($date, $now) < 24 * 3600)
			{
				//返回0，点赞间隔没超过24小时，不可以点赞
				return 0;
			}
			else
			{
				//返回2，可以点赞，有ip记录
				return 2;
			}
		}
	}
	
	public function setShare($photoId)
	{
		Config::$db->connect();
		$ip = Utils::getClientIp();
		$sqlIp = Security::varSql($ip);
		$sqlPhotoId = (int)$photoId;
		$date = Utils::mdate('Y-m-d H:i:s');
		$sqlDate = Security::varSql($date);
		$tbIpShare = Config::$tbIpShare;
		$tbFans = Config::$tbFans;
		$code = $this->checkShare($ip, $sqlPhotoId);
		
		switch ($code)
		{
			case 0:
				return false;
			case 1:
				Config::$db->query("insert into $tbIpShare (ip, photo_id, pubtime) values ($sqlIp, $sqlPhotoId, $sqlDate)");
				Config::$db->query("update $tbFans set share_num=share_num+1 where id=$sqlPhotoId");
				return true;
			case 2:
				Config::$db->query("update $tbIpShare set pubtime=$sqlDate where ip=$sqlIp and photo_id=$sqlPhotoId");
				Config::$db->query("update $tbFans set share_num=share_num+1 where id=$sqlPhotoId");
				return true;
			default:
		}
	}
	
	public function getAllLike()
	{
		Config::$db->connect();
		$tbIpLike = Config::$tbIpLike;
		Config::$db->query("select * from $tbIpLike");
		return Config::$db->getAllRows();
	}
	
	public function getAllShare()
	{
		Config::$db->connect();
		$tbIpShare = Config::$tbIpShare;
		Config::$db->query("select * from $tbIpShare");
		return Config::$db->getAllRows();
	}
	
	public function getLikeArr()
	{
		$res = array();
		$like = $this->getAllLike();
		foreach ($like as $value)
		{
			$res[$value['ip'] . '_' . $value['photo_id']] = $value['pubtime'];
		}
		return $res;
	}
	
	public function getShareArr()
	{
		$res = array();
		$like = $this->getAllShare();
		foreach ($like as $value)
		{
			$res[$value['ip'] . '_' . $value['photo_id']] = $value['pubtime'];
		}
		return $res;
	}
}
?>
