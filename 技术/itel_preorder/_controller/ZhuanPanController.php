<?php
/**
 * 转盘控制器
 * @author Shines
 */
class ZhuanPanController
{
	public function __construct()
	{
		$zhuanPan = new ZhuanPan();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'genOpenId':
				$this->genOpenId();
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
	
	/**
	 * 生成开放id
	 */
	private function genOpenId()
	{
		$openId = isset($_COOKIE[Config::$systemName . "_zhuanPanOpenId"]) ? $_COOKIE[Config::$systemName . "_zhuanPanOpenId"] : '';
		if (empty($openId))
		{
			$openId = Utils::genUniqid();
			setcookie(Config::$systemName . "_zhuanPanOpenId", $openId, time() + 12 * 30 * 24 * 60 * 60);
		}
		$key = Security::multiMd5($openId, Config::$key);
		header('Location:' . Config::$baseUrl . '/?m=zhuanPan&a=lucky&openId=' . $openId . '&key=' . $key);
	}
	
	/**
	 * 抽奖主界面
	 */
	private function lucky()
	{
		System::fixSubmit('lucky');
		$openId = trim(Security::varGet('openId'));
		$key = trim(Security::varGet('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		/*
		///// debug
		$openId = rand(1, 1000000000);
		$openId = 'a0012';
		$key = Security::multiMd5($openId, Config::$key);
		$srcKey = Security::multiMd5($openId, Config::$key);
		*/
		
		$_isClick = false;
		$_prizeId = 0;
		$_prizeName = '';
		$_luckyCode = '';
		$_openId = $openId;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openId))
		{
			$zhuanPan = new ZhuanPan();
			$luckyToday = $zhuanPan->checkLuckyToday($openId);
			$isLucky = $luckyToday['isLucky'];
			$_isClick = $luckyToday['isClick'];
			if ($isLucky)
			{
				$win = $zhuanPan->checkWinToday($openId);
				$_prizeId = $win['prizeId'];
				$_prizeName = $win['prizeName'];
				$_luckyCode = $win['luckyCode'];
			}
			else
			{
				$win = $zhuanPan->lucky($openId);
				$_prizeId = $win['prizeId'];
				$_prizeName = $win['prizeName'];
				$_luckyCode = $win['luckyCode'];
			}
			include(Config::$viewDir . 'zhaun_pan/main.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	/**
	 * 点击转盘
	 */
	private function clickPan()
	{
		$openId = trim(Security::varPost('openId'));
		$key = trim(Security::varPost('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		if ($key == $srcKey && !empty($openId))
		{
			$zhuanPan = new ZhuanPan();
			$zhuanPan->setClick($openId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['RequestError']);
		}
	}
}
?>
