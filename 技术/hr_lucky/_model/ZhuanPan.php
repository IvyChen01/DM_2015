<?php
/**
 *	抽奖
 */
class ZhuanPan
{
	public function __construct()
	{
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function checkLuckyToday($openid)
	{
		Config::$db->connect();
		$tbLuckyDaily = Config::$tbLuckyDaily;
		$sqlOpenid = Security::varSql($openid);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("SELECT * FROM $tbLuckyDaily WHERE openid=$sqlOpenid AND date_format(lucky_time, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('isLucky' => false, 'panFlag' => 0, 'loseCode' => 0);
		}
		else
		{
			return array('isLucky' => true, 'panFlag' => $res['pan_flag'], 'loseCode' => $res['lose_code']);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	public function setLuckyToday($openid, $loseCode)
	{
		Config::$db->connect();
		$tbLuckyDaily = Config::$tbLuckyDaily;
		$sqlOpenid = Security::varSql($openid);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlLoseCode = (int)$loseCode;
		Config::$db->query("insert into $tbLuckyDaily (openid, lucky_time, pan_flag, lose_code) values ($sqlOpenid, $sqlDate, 0, $sqlLoseCode)");
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openid)
	{
		$loseCode = $this->genLoseCode();
		$this->setLuckyToday($openid, $loseCode);
		if ($this->checkIsWin($openid))
		{
			return array('prizeId' => 0, 'luckyCode' => '', 'loseCode' => $loseCode);
		}
		
		Config::$db->connect();
		$tbJiangChi = Config::$tbJiangChi;
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("SELECT * FROM $tbJiangChi WHERE prize_date=$sqlDate");
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
					$prizeIndex = rand(0, $prizeArrCount - 1);
					$prizeId = $prizeArr[$prizeIndex];
					$luckyCode = $this->genLuckyCode();
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduceJiangChi($res['id'], $prizeId);
					$this->saveLucky($openid, $prizeId, $luckyCode);
					
					return array('prizeId' => $prizeId, 'luckyCode' => $luckyCode, 'loseCode' => $loseCode);
				}
			}
		}
		
		return array('prizeId' => 0, 'luckyCode' => '', 'loseCode' => $loseCode);
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
	private function reduceJiangChi($jiangChiId, $prizeId)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbJiangChi = Config::$tbJiangChi;
			$sqlId = (int)$jiangChiId;
			$fieldName = 'prize' . $prizeId;
			Config::$db->query("UPDATE $tbJiangChi SET $fieldName=$fieldName-1 WHERE id=$sqlId");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function saveLucky($openid, $prizeId, $luckyCode)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZhongJiang = Config::$tbZhongJiang;
			$sqlOpenid = Security::varSql($openid);
			$sqlPrizeId = (int)$prizeId;
			$sqlPrizeName = Security::varSql(Config::$prizeName[$prizeId - 1]);
			$sqlTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			$sqlLuckyCode = Security::varSql($luckyCode);
			Config::$db->query("INSERT INTO $tbZhongJiang (openid, prizeid, prizename, lucky_time, lucky_code) VALUES ($sqlOpenid, $sqlPrizeId, $sqlPrizeName, $sqlTime, $sqlLuckyCode)");
		}
	}
	
	public function genLuckyCode()
	{
		$maxCount = 10;
		$count = 0;
		while (true)
		{
			$count++;
			Config::$db->connect();
			$tbZhongJiang = Config::$tbZhongJiang;
			$rnd = rand(10000000, 99999999);
			$sqlRnd = Security::varSql($rnd);
			Config::$db->query("select * from $tbZhongJiang where lucky_code=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
			if ($count >= $maxCount)
			{
				return '';
			}
		}
	}
	
	public function checkIsWin($openid)
	{
		Config::$db->connect();
		$tbZhongJiang = Config::$tbZhongJiang;
		$sqlOpenid = Security::varSql($openid);
		Config::$db->query("SELECT * FROM $tbZhongJiang WHERE openid=$sqlOpenid");
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
	
	public function getPrizeToday($openid)
	{
		Config::$db->connect();
		$tbZhongJiang = Config::$tbZhongJiang;
		$sqlOpenid = Security::varSql($openid);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("SELECT * FROM $tbZhongJiang WHERE openid=$sqlOpenid AND date_format(lucky_time, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => (int)$res['prizeid'], 'luckyCode' => $res['lucky_code']);
		}
	}
	
	public function getDaily()
	{
		Config::$db->connect();
		$tbLuckyDaily = Config::$tbLuckyDaily;
		Config::$db->query("SELECT * FROM $tbLuckyDaily order by id");
		$res = Config::$db->getAllRows();
		
		return $res;
	}
	
	public function getZhongJiang()
	{
		Config::$db->connect();
		$tbZhongJiang = Config::$tbZhongJiang;
		Config::$db->query("SELECT * FROM $tbZhongJiang order by lucky_code");
		$res = Config::$db->getAllRows();
		
		return $res;
	}
	
	public function checkPanToday($openid)
	{
		Config::$db->connect();
		$tbLuckyDaily = Config::$tbLuckyDaily;
		$sqlOpenid = Security::varSql($openid);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("SELECT * FROM $tbLuckyDaily WHERE openid=$sqlOpenid AND date_format(lucky_time, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			if (1 == $res['pan_flag'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function setPanClick($openid)
	{
		Config::$db->connect();
		$tbLuckyDaily = Config::$tbLuckyDaily;
		$sqlOpenid = Security::varSql($openid);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("update $tbLuckyDaily set pan_flag=1 where openid=$sqlOpenid and date_format(lucky_time, '%Y-%m-%d')=$sqlDate");
	}
	
	private function genLoseCode()
	{
		return rand(0, 2);
	}
}
?>
