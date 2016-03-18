<?php
/**
 * 红包管理控制器
 * @author Shines
 */
class AdminHongBaoController
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
		$hongBao = new HongBao();
		$hongBao->initPrize();
		echo 'ok';
	}
	
	/**
	 * 统计抽奖数据
	 */
	private function luckyCount()
	{
		$this->checkLogin();
		$hongBao = new HongBao();
		$daily = $hongBao->getDaily();
		$_dayList = array();
		$_totalLucky = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($_dayList[$date]))
			{
				$_dayList[$date] = array();
				$_dayList[$date]['date'] = $date;
				$_dayList[$date]['num'] = 0;
			}
			$_dayList[$date]['num']++;
			$_totalLucky++;
		}
		include(Config::$templatesDir . 'admin_hong_bao/count.php');
	}
	
	/**
	 * 中奖名单
	 */
	private function winlist()
	{
		$this->checkLogin();
		$hongBao = new HongBao();
		$zhongJiang = $hongBao->getZhongJiang();
		$_jiangList = array();
		foreach ($zhongJiang as $value)
		{
			$_jiangList[] = array('luckyDate' => $value['lucky_date'], 'openId' => $value['open_id'], 'money' => Config::$prizeMoney[$value['prize_id'] - 1], 'luckyCode' => $value['lucky_code']);
		}
		include(Config::$templatesDir . 'admin_hong_bao/winlist.php');
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
