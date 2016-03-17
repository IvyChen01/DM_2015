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
		
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbZpJiangChi where prize_date=$sqlDate");
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
	 * 检测今天是否抽过奖
	 */
	public function checkLuckyToday($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpDaily where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('isLucky' => false, 'isClick' => false);
		}
		else
		{
			$isClick = ($res['is_click'] == 0) ? false : true;
			return array('isLucky' => true, 'isClick' => $isClick);
		}
	}
	
	/**
	 * 检测今天是否中奖
	 */
	public function checkWinToday($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpZhongJiang where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prize_id'], 'prizeName' => Config::$prizeName[$res['prize_id'] - 1], 'luckyCode' => $res['lucky_code']);
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
		Config::$db->query("insert into $tbZpDaily (open_id, is_click, lucky_date) values ($sqlOpenId, 0, $sqlDate)");
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
			Config::$db->query("update $tbZpJiangChi set $fieldName=$fieldName-1 where prize_date=$sqlDate");
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
			Config::$db->query("insert into $tbZpZhongJiang (open_id, prize_id, lucky_code, lucky_date) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
		}
	}
	
	/**
	 * 记录点击过转盘
	 */
	public function setClick($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("update $tbZpDaily set is_click=1 where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
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
		$tbZhongJiang = Config::$tbZhongJiang;
		Config::$db->query("select * from $tbZhongJiang order by id");
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
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-6', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-7', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-8', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbZpJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-9', 50, 10, 20, 30)");
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
			Config::$db->query("select id from $tbZpZhongJiang where lucky_code=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
}
?>
