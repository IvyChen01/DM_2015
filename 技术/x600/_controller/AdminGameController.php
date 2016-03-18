<?php
/**
 * 抽奖后台控制器
 * @author Shines
 */
class AdminGameController
{
	private $admin = null;
	private $zhuanPan = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->admin = new Admin();
		$this->zhuanPan = new ZhuanPan();
		switch ($action)
		{
			case 'winList':
				if ($this->admin->checkLogin())
				{
					$this->winList();
				}
				else
				{
					$this->showLogin();
				}
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
			case 'userList':
				if ($this->admin->checkLogin())
				{
					$this->userList();
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
	
	private function winList()
	{
		$list = $this->zhuanPan->getAdminWinlist();
		include(Config::$viewDir . 'admin_game/winlist.php');
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
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['lucky'] = 0;
				$dayList[$date]['winner'] = 0;
				$dayList[$date]['luckyRate'] = 0;
			}
			$dayList[$date]['winner']++;
			$totalWinner++;
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
	
	private function userList()
	{
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$users = $this->zhuanPan->getUserByPage($page, Config::$adminUserPagesize);
		$indexOffset = ($page - 1) * Config::$adminUserPagesize;
		$pagelist = new Page();
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->urlBase = './?m=adminGame&a=userList&page=';
		$allCount = $this->zhuanPan->countUser();
		$pagelist->totalPage = ceil($allCount / Config::$adminUserPagesize);
		$pageStr = $pagelist->getPages($page);
		include(Config::$viewDir . 'admin_game/userlist.php');
	}
	
	private function exportUser()
	{
		$this->zhuanPan->exportUser();
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
