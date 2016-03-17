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
	
	private function dataCount()
	{
		$users = $this->game->getUserByPage(1, 1000000);
		$dayList = array();
		$totalUser = 0;
		$totalPlay = 0;
		$totalAnswer = 0;
		
		foreach ($users as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['regtime']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['answerNum'] = 0;
			}
			$dayList[$date]['userNum']++;
			$totalUser++;
			if ($value['isplayed'] == 1)
			{
				$dayList[$date]['answerNum']++;
				$totalAnswer++;
			}
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
	
	private function winner()
	{
		$winner = $this->zhuanPan->getAllWinner();
		include(Config::$viewDir . 'admin_game/winner.php');
	}
}
?>
