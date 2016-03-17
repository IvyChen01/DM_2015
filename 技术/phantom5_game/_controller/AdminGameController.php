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
			case 'rank':
				if ($this->admin->checkLogin())
				{
					$this->rank();
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
			case 'winner':
				if ($this->admin->checkLogin())
				{
					$this->winner();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
		}
	}
	
	private function dataCount()
	{
		$users = $this->game->getUserByPage(1, 1000000);
		$daily = $this->game->getAllDaily();
		
		$dayList = array();
		$totalUser = 0;
		$totalPlay = 0;
		$totalInvite = 0;
		
		foreach ($users as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['regtime']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['inviteNum'] = 0;
			}
			$dayList[$date]['userNum']++;
			$totalUser++;
			if ($value['isinvite'] == 1)
			{
				$dayList[$date]['inviteNum']++;
				$totalInvite++;
			}
		}
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['playtime']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['inviteNum'] = 0;
			}
			$dayList[$date]['playNum']++;
			$totalPlay++;
		}
		include(Config::$viewDir . 'admin_game/count.php');
	}
	
	private function rank()
	{
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$users = $this->game->getAdminRank($page, Config::$adminUserPagesize);
		$pagelist = new Page();
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->urlBase = './?m=adminGame&a=rank&page=';
		$allCount = $this->game->countUser();
		$pagelist->totalPage = ceil($allCount / Config::$adminUserPagesize);
		$pageStr = $pagelist->getPages($page);
		
		switch (Config::$configType)
		{
			case 5:
				include(Config::$viewDir . 'admin_game/ke_rank.php');
				break;
			default:
				include(Config::$viewDir . 'admin_game/rank.php');
		}
	}
	
	private function exportUser()
	{
		switch (Config::$configType)
		{
			case 5:
				$this->game->exportUserKe();
				break;
			default:
				$this->game->exportUser();
		}
	}
	
	private function winner()
	{
		$winner = $this->zhuanPan->getAllWinner();
		include(Config::$viewDir . 'admin_game/winner.php');
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
