<?php
/**
 * 抢红包
 * @author Shines
 */
class HongBao
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
		$tbHbJiangChi = Config::$tbHbJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbHbJiangChi where prize_date=$sqlDate");
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
					return array('prizeId' => $prizeId, 'money' => Config::$prizeMoney[$prizeId - 1], 'luckyCode' => $luckyCode);
				}
			}
		}
		return array('prizeId' => 0, 'money' => 0, 'luckyCode' => '');
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function checkLuckyToday($openId)
	{
		Config::$db->connect();
		$tbHbDaily = Config::$tbHbDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbHbDaily where open_id=$openId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
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
		$tbHbZhongJiang = Config::$tbHbZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbHbZhongJiang where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'money' => 0, 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prize_id'], 'money' => Config::$prizeMoney[$res['prize_id'] - 1], 'luckyCode' => $res['lucky_code']);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function setLuckyToday($openId)
	{
		Config::$db->connect();
		$tbHbDaily = Config::$tbHbDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbHbDaily (open_id, is_click, lucky_date) values ($sqlOpenId, 0, $sqlDate)");
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
			$tbHbJiangChi = Config::$tbHbJiangChi;
			$sqlDate = Security::varSql($date);
			$fieldName = 'prize' . $prizeId;
			Config::$db->query("update $tbHbJiangChi set $fieldName=$fieldName-1 where prize_date=$sqlDate");
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
			$tbHbZhongJiang = Config::$tbHbZhongJiang;
			$sqlOpenId = Security::varSql($openId);
			$sqlLuckyCode = Security::varSql($luckyCode);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			Config::$db->query("insert into $tbHbZhongJiang (open_id, prize_id, lucky_code, lucky_date) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
		}
	}
	
	/**
	 * 设置点击过红包
	 */
	public function setClick($openId)
	{
		Config::$db->connect();
		$tbHbDaily = Config::$tbHbDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("update $tbHbDaily set is_click=1 where open_id=$sqlOpenId and date_format(lucky_date, '%Y-%m-%d')=$sqlDate");
	}
	
	/**
	 * 获取每日抽奖记录
	 */
	public function getDaily()
	{
		Config::$db->connect();
		$tbHbDaily = Config::$tbHbDaily;
		Config::$db->query("select * from $tbHbDaily order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 获取全部中奖数据
	 */
	public function getZhongJiang()
	{
		Config::$db->connect();
		$tbHbZhongJiang = Config::$tbHbZhongJiang;
		Config::$db->query("select * from $tbHbZhongJiang order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 初始化红包奖池
	 */
	public function initPrize()
	{
		Config::$db->connect();
		$tbHbJiangChi = Config::$tbHbJiangChi;
		Config::$db->query("delete from $tbHbJiangChi");
		Config::$db->query("insert into $tbHbJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-3', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbHbJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-4', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbHbJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-5', 50, 10, 20, 30)");
		Config::$db->query("insert into $tbHbJiangChi (prize_date, rate, prize1, prize2, prize3) values ('2015-7-6', 50, 10, 20, 30)");
	}
	
	/**
	 * 生成随机码
	 */
	public function genCode()
	{
		Config::$db->connect();
		$tbHbZhongJiang = Config::$tbHbZhongJiang;
		for ($i = 0; $i < 10; $i++)
		{
			$rnd = rand(10000000, 99999999);
			$sqlRnd = Security::varSql($rnd);
			Config::$db->query("select id from $tbHbZhongJiang where lucky_code=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
	
	/**
	 * 获取指定用户的抽奖记录
	 */
	public function getRecords($openId)
	{
		Config::$db->connect();
		$tbHbDaily = Config::$tbHbDaily;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbHbDaily where open_id=$sqlOpenId order by id");
		return Config::$db->getAllRows();
	}
}
?>
