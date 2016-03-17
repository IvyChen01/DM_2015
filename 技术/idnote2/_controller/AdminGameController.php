<?php
/**
 * 游戏后台控制器
 * @author Shines
 */
class AdminGameController
{
	private $admin = null;
	private $game = null;
	private $zhuanPan = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->game = new Game();
		$this->zhuanPan = new ZhuanPan();
		switch ($action)
		{
			case 'winner':
				$this->winner();
				break;
			case 'dataCount':
				if ($this->admin->checkLogin())
				{
					$this->dataCount();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'exportUser':
				if ($this->admin->checkLogin())
				{
					$this->exportUser();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
		}
	}
	
	private function winner()
	{
		$winner = $this->zhuanPan->getAdminWinlist();
		include(Config::$viewDir . 'admin_game/winner.php');
	}
	
	private function dataCount()
	{
		$daily = $this->zhuanPan->getDaily();
		$zhongJiang = $this->zhuanPan->getZhongJiang();
		
		$dayList = array();
		$totalLucky = 0;
		$totalWinner = 0;
		$totalLuckyRate = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['luckydate']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['lucky'] = 0;
				$dayList[$date]['winner'] = 0;
				$dayList[$date]['luckyRate'] = 0;
			}
			$dayList[$date]['lucky']++;
			$totalLucky++;
		}
		
		foreach ($zhongJiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['luckydate']);
			if (isset($dayList[$date]))
			{
				$dayList[$date]['winner']++;
				$totalWinner++;
			}
		}
		
		foreach ($dayList as $value)
		{
			$date = $value['date'];
			$numWinner = $dayList[$date]['winner'];
			$numLucky = $dayList[$date]['lucky'];
			if ($numLucky != 0)
			{
				$dayList[$date]['luckyRate'] = round($numWinner / $numLucky * 100, 1);
			}
		}
		
		if ($totalLucky != 0)
		{
			$totalLuckyRate = round($totalWinner / $totalLucky * 100, 1);
		}
		include(Config::$viewDir . 'admin_game/count.php');
	}
	
	private function exportUser()
	{
		$this->game->exportUser();
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
}
?>
