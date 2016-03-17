<?php
/**
 * 抽奖控制器
 */
class ZhuanPanController
{
	private $zhuanPan = null;//抽奖模型
	
	public function __construct()
	{
		$this->zhuanPan = new ZhuanPan();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'tempCreateOpenid':
				$this->tempCreateOpenid();
				return;
			case 'lucky':
				$this->lucky();
				return;
			case 'clickPan':
				$this->clickPan();
				return;
			default:
		}
	}
	
	private function tempCreateOpenid()
	{
		$openid = isset($_COOKIE[Config::$systemName . "_zhuanPanOpenid"]) ? $_COOKIE[Config::$systemName . "_zhuanPanOpenid"] : '';
		if (empty($openid))
		{
			$openid = Utils::genUniqid();
			setcookie(Config::$systemName . "_zhuanPanOpenid", $openid, time() + 12 * 30 * 24 * 60 * 60);
		}
		$key = Security::multiMd5($openid, Config::$key);
		
		header('Location:http://hr.transsion.qumuwu.com/?m=zhuanPan&a=lucky&openid=' . $openid . '&key=' . $key);
		//header('Location:http://localhost:8002/?m=zhuanPan&a=lucky&openid=' . $openid . '&key=' . $key);
	}
	
	private function lucky()
	{
		System::fixSubmit('lucky');
		$openid = trim(Security::varGet('openid'));
		$key = trim(Security::varGet('key'));
		$srcKey = Security::multiMd5($openid, Config::$key);
		
		/*
		///// debug
		$openid = Utils::genUniqid();
		//$openid = 'a0008';
		$key = Security::multiMd5($openid, Config::$key);
		$srcKey = Security::multiMd5($openid, Config::$key);
		*/
		
		$_openid = $openid;
		$_key = $srcKey;
		$_isLuckyToday = false;
		$_panFlag = 0;
		$_isWinToday = false;
		$_luckyCode = 0;
		$_getCode = '';
		$_loseCode = 0;
		
		if ($key == $srcKey && !empty($openid))
		{
			$luckyToday = $this->zhuanPan->checkLuckyToday($openid);
			$_isLuckyToday = $luckyToday['isLucky'];
			$_panFlag = $luckyToday['panFlag'];
			$_loseCode = $luckyToday['loseCode'];
			if ($_isLuckyToday)
			{
				$param = $this->zhuanPan->getPrizeToday($openid);
				$_luckyCode = $param['prizeId'];
				$_getCode = $param['luckyCode'];
				if ($_luckyCode > 0)
				{
					$_isWinToday = true;
				}
				else
				{
					$_isWinToday = false;
				}
			}
			else
			{
				$param = $this->zhuanPan->lucky($openid);
				$_luckyCode = $param['prizeId'];
				$_getCode = $param['luckyCode'];
				$_loseCode = $param['loseCode'];
			}
			include('view/lucky.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function clickPan()
	{
		System::fixSubmit('clickPan');
		$openid = trim(Security::varPost('openid'));
		$key = trim(Security::varPost('key'));
		$srcKey = Security::multiMd5($openid, Config::$key);
		if ($key == $srcKey && !empty($openid))
		{
			$this->zhuanPan->setPanClick($openid);
			Utils::echoData(0, 'ok');
		}
		else
		{
			Utils::echoData(1, '非法请求！');
		}
	}
}
?>
