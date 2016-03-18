<?php
/**
 * 转盘管理控制器
 * @author Shines
 */
class AdminZhuanPanController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'initPrize':
				$this->initPrize();
				return;
			case 'luckyCount':
				$this->luckyCount();
				return;
			case 'winlist':
				$this->winlist();
				return;
			default:
		}
	}
	
	/**
	 * 初始化奖池数据
	 */
	private function initPrize()
	{
		$this->checkLogin();
		$zhuanPan = new ZhuanPan();
		$zhuanPan->initPrize();
		echo 'ok';
	}
	
	/**
	 * 统计抽奖数据
	 */
	private function luckyCount()
	{
		$this->checkLogin();
		$zhuanPan = new ZhuanPan();
		$daily = $zhuanPan->getDaily();
		$zhongJiang = $zhuanPan->getZhongJiang();
		
		$_dayList = array();
		$_totalLucky = 0;
		$_totalWinner = 0;
		$_totalLuckyRate = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($_dayList[$date]))
			{
				$_dayList[$date] = array();
				$_dayList[$date]['date'] = $date;
				$_dayList[$date]['lucky'] = 0;
				$_dayList[$date]['winner'] = 0;
				$_dayList[$date]['lucky_rate'] = 0;
			}
			$_dayList[$date]['lucky']++;
			$_totalLucky++;
		}
		
		foreach ($zhongJiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($_dayList[$date]))
			{
				$_dayList[$date] = array();
				$_dayList[$date]['date'] = $date;
				$_dayList[$date]['lucky'] = 0;
				$_dayList[$date]['winner'] = 0;
				$_dayList[$date]['lucky_rate'] = 0;
			}
			$_dayList[$date]['winner']++;
			$_totalWinner++;
		}
		
		foreach ($_dayList as $value)
		{
			$date = $value['date'];
			$numWinner = $_dayList[$date]['winner'];
			$numLucky = $_dayList[$date]['lucky'];
			if ($numLucky != 0)
			{
				$_dayList[$date]['lucky_rate'] = round($numWinner / $numLucky * 100, 1);
			}
		}
		
		if ($_totalLucky != 0)
		{
			$_totalLuckyRate = round($_totalWinner / $_totalLucky * 100, 1);
		}
		
		include(Config::$templatesDir . 'admin/lucky_count.php');
	}
	
	/**
	 * 中奖名单
	 */
	private function winlist()
	{
		$this->checkLogin();
		$zhuanPan = new ZhuanPan();
		$zhongJiang = $zhuanPan->getZhongJiang();
		$_jiangList = array();
		
		foreach ($zhongJiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($_jiangList[$date]))
			{
				$_jiangList[$date] = array();
				$_jiangList[$date]['date'] = $date;
				$_jiangList[$date]['winner'] = array();
			}
			$_jiangList[$date]['winner'][] = array('userId' => $value['userId'], 'prizeId' => $value['prize_id'], 'lucky_code' => $value['lucky_code'], 'lucky_date' => $value['lucky_date']);
		}
		
		include(Config::$templatesDir . 'admin/winlist.php');
	}
	
	/**
	 * 检测用户是否已登录
	 */
	private function checkLogin($isDataAction = false)
	{
		$admin = new Admin();
		if (!$admin->checkLogin())
		{
			$this->showLogin($isDataAction);
			exit(0);
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin($isDataAction = false)
	{
		if ($isDataAction)
		{
			System::echoData(Config::$msg['noLogin']);
		}
		else
		{
			include(Config::$templatesDir . 'admin/login.php');
		}
	}
}
?>
