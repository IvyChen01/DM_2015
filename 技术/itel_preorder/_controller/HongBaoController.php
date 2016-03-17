<?php
/**
 * 红包控制器
 * @author Shines
 */
class HongBaoController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				return;
			case 'clickHongBao':
				$this->clickHongBao();
				return;
			default:
		}
	}
	
	/**
	 * 主界面
	 */
	private function lucky()
	{
		$openId = trim(Security::varGet('openId'));
		$key = trim(Security::varGet('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		///// debug
		$openId = rand(1, 1000000000);
		$openId = 'a002';
		$key = Security::multiMd5($openId, Config::$key);
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		$_isClick = false;
		$_money = 0;
		$_luckyCode = '';
		$_records = null;
		$_openId = $openId;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openId))
		{
			$hongBao = new HongBao();
			$luckyInfo = $hongBao->checkLuckyToday($openId);
			$isLucky = $luckyInfo['isLucky'];
			$_isClick = $luckyInfo['isClick'];
			if ($isLucky)
			{
				$win = $hongBao->checkWinToday($openId);
				$_money = $win['money'];
				$_luckyCode = $win['luckyCode'];
			}
			else
			{
				$win = $hongBao->lucky($openId);
				$_money = $win['money'];
				$_luckyCode = $win['luckyCode'];
			}
			$_records = json_encode($hongBao->getRecords($openId));
			include(Config::$viewDir . 'hong_bao/main.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	/**
	 * 点击红包
	 */
	private function clickHongBao()
	{
		$openId = trim(Security::varPost('openId'));
		$key = trim(Security::varPost('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		if ($key == $srcKey && !empty($openId))
		{
			$hongBao = new HongBao();
			$hongBao->setClick($openId);
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['RequestError']);
		}
	}
}
?>
