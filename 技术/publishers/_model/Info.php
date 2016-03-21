<?php
/**
 * 系统消息
 * @author Shines
 */
class Info
{
	public function __construct()
	{
	}
	
	public function getSystemMessage($page, $pagesize)
	{
		Config::$db->connect();
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
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbMessage = Config::$tbMessage;
		Config::$db->query("select id, content, message_date from $tbMessage where from_id='system' and to_id='all' order by id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countSystemMessage()
	{
		Config::$db->connect();
		$tbMessage = Config::$tbMessage;
		Config::$db->query("select count(*) as num from $tbMessage where from_id='system' and to_id='all'");
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
	
	public function setSystemMessage($content)
	{
		Config::$db->connect();
		$sqlContent = Security::varSql($content);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbMessage = Config::$tbMessage;
		Config::$db->query("insert into $tbMessage (from_id, to_id, content, message_date) values ('system', 'all', $sqlContent, $sqlDate)");
	}
	
	public function deleteSystemMessage($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbMessage = Config::$tbMessage;
		Config::$db->query("delete from $tbMessage where id=$sqlId");
	}
	
	public function getFeedback($uid)
	{
		Config::$db->connect();
		$sqlUid = Security::varSql($uid);
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback where from_id=$sqlUid or to_id=$sqlUid or to_id='all'");
		return Config::$db->getAllRows();
	}
	
	public function setFeedback($from, $to, $content, $image)
	{
		Config::$db->connect();
		$sqlFrom = Security::varSql($from);
		$sqlTo = Security::varSql($to);
		$sqlContent = Security::varSql($content);
		$sqlImage = Security::varSql($image);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("insert into $tbFeedback (from_id, to_id, content, feedback_date, image) values ($sqlFrom, $sqlTo, $sqlContent, $sqlDate, $sqlImage)");
		return Config::$db->getInsertId();
	}
	
	public function getFeedbackById($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback where id=$sqlId");
		return Config::$db->getRow();
	}
	
	public function deleteFeedback($id)
	{
		Config::$db->connect();
		$sqlId = (int)$id;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("delete from $tbFeedback where id=$sqlId");
	}
	
	public function getAllFeedback()
	{
		Config::$db->connect();
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
		if ($pagesize > Config::$maxNewsPagesize)
		{
			$pagesize = Config::$maxNewsPagesize;
		}
		$from = ($page - 1) * $pagesize;
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select id, from_id, to_id, content, feedback_date, image from $tbFeedback order by id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countAllFeedback()
	{
		Config::$db->connect();
		$tbFeedback = Config::$tbFeedback;
		Config::$db->query("select count(*) as num from $tbFeedback");
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
	
	public function getFaq()
	{
		Config::$db->connect();
		$tbFaq = Config::$tbFaq;
		Config::$db->query("select id, question, answer, pubdate from $tbFaq");
		return Config::$db->getAllRows();
	}
	
	public function uploadImage()
	{
		$param = System::uploadPhoto();
		if (0 == $param['error'])
		{
			$url = $param['url'];
			$tempPic = $param['file'];
			$newPic = Config::$uploadsDir . time() . rand(100000, 999999) . '.jpg';
			Image::thumb($tempPic, $newPic, "", 1000, 1000);
			@unlink($tempPic);
			return array('code' => 0, 'pic' => Config::$baseUrl . '/' . $newPic, 'msg' => 'ok');
		}
		else
		{
			$msg = $param['message'];
			return array('code' => 1, 'pic' => '', 'msg' => $msg);
		}
	}
}
?>
