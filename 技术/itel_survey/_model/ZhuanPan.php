<?php
/**
 * 转盘
 * @author Shines
 */
class ZhuanPan
{
	public function __construct()
	{
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openId)
	{
		//记录今天抽过奖
		$this->setLuckyToday($openId);
		
		//中过奖的不再中奖
		$win = $this->checkWin($openId);
		$prizeId = $win['prizeId'];
		if ($prizeId > 0)
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbZpJiangChi where prizedate=$sqlDate");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//组合奖品id
				$prizeArr = array_merge(
					$this->joinPrize(1, $res['prize1']),
					$this->joinPrize(2, $res['prize2']),
					$this->joinPrize(3, $res['prize3']),
					$this->joinPrize(4, $res['prize4']),
					$this->joinPrize(5, $res['prize5']),
					$this->joinPrize(6, $res['prize6']),
					$this->joinPrize(7, $res['prize7']),
					$this->joinPrize(8, $res['prize8']),
					$this->joinPrize(9, $res['prize9']),
					$this->joinPrize(10, $res['prize10'])
				);
				//判断当天奖池中是否还有奖品
				$prizeArrCount = count($prizeArr);
				if ($prizeArrCount > 0)
				{
					$prizeRnd = rand(0, $prizeArrCount - 1);
					$prizeId = $prizeArr[$prizeRnd];
					$luckyCode = $this->genCode();
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduceJiangChi($date, $prizeId);
					$this->saveLucky($openId, $prizeId, $luckyCode);
					return array('prizeId' => $prizeId, 'prizeName' => Config::$prizeName[$prizeId - 1], 'luckyCode' => $luckyCode);
				}
			}
		}
		return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
	}
	
	/**
	 * 检测是否中过奖
	 */
	public function checkWin($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbZpZhongJiang where fbid=$sqlOpenId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prizeid'], 'prizeName' => Config::$prizeName[$res['prizeid'] - 1], 'luckyCode' => $res['luckycode']);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function setLuckyToday($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbZpDaily (fbid, luckydate) values ($sqlOpenId, $sqlDate)");
	}
	
	/**
	 * 组合奖品
	 */
	private function joinPrize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		return $res;
	}
	
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduceJiangChi($date, $prizeId)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpJiangChi = Config::$tbZpJiangChi;
			$sqlDate = Security::varSql($date);
			$fieldName = 'prize' . $prizeId;
			Config::$db->query("update $tbZpJiangChi set $fieldName=$fieldName-1 where prizedate=$sqlDate");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function saveLucky($openId, $prizeId, $luckyCode)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpZhongJiang = Config::$tbZpZhongJiang;
			$sqlOpenId = Security::varSql($openId);
			$sqlLuckyCode = Security::varSql($luckyCode);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			Config::$db->query("insert into $tbZpZhongJiang (fbid, prizeid, luckycode, luckydate) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
		}
	}
	
	/**
	 * 获取每日抽奖数据
	 */
	public function getDaily()
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		Config::$db->query("select * from $tbZpDaily order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 获取中奖数据
	 */
	public function getZhongJiang()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select * from $tbZpZhongJiang order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 初始化转盘奖池
	 */
	public function initPrize()
	{
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		Config::$db->query("delete from $tbZpJiangChi");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-26', 20, 0, 1, 1, 0, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-27', 20, 0, 0, 1, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-28', 20, 1, 0, 0, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-29', 20, 0, 1, 1, 1, 0)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-30', 20, 0, 0, 1, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3, prize4, prize5) values ('2015-12-31', 20, 0, 0, 1, 1, 1)");
		
		Config::$db->query("select * from $tbZpJiangChi");
		$res = Config::$db->getAllRows();
		$num = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$total = 0;
		foreach ($res as $value)
		{
			for ($i = 1; $i <= 10; $i++)
			{
				$num[$i - 1] += $value['prize' . $i];
				$total += $value['prize' . $i];
			}
		}
		Utils::dump($num);
		echo '<br />total: ' . $total . '<br /><br />';
	}
	
	/**
	 * 生成随机码
	 */
	public function genCode()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		for ($i = 0; $i < 10; $i++)
		{
			$rnd = rand(10000000, 99999999);
			$sqlRnd = Security::varSql($rnd);
			Config::$db->query("select id from $tbZpZhongJiang where luckycode=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
	
	public function getWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id desc");
		return Config::$db->getAllRows();
	}
	
	public function getWinnerByPage($page)
	{
		Config::$db->connect();
		$page = (int)$page;
		if ($page < 1)
		{
			$page = 1;
		}
		$pagesize = Config::$winnerPagesize;
		$from = ($page - 1) * $pagesize;
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function getWinnerCount()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select count(*) as num from $tbZpZhongJiang");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			return (int)$res['num'];
		}
		else
		{
			return 0;
		}
	}
	
	public function getAllWinner()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.email as email, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id");
		return Config::$db->getAllRows();
	}
	
	public function getMyPrize($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select prizeid from $tbZpZhongJiang where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$prizeId = (int)$res['prizeid'];
			return Config::$prizeName[$prizeId - 1];
		}
		else
		{
			return 'No Prize';
		}
	}
	
	public function getMyPrizeId($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select prizeid from $tbZpZhongJiang where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			$prizeId = (int)$res['prizeid'];
			return $prizeId;
		}
		else
		{
			return 0;
		}
	}
	
	public function getAdminWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.email as email, user.gender as gender, user.regtime as regtime, user.logintype as logintype, zj.prizeid as prizeid, zj.luckycode as luckycode, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id");
		return Config::$db->getAllRows();
	}
}
?>
