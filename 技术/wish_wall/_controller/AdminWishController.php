<?php
/**
 * 许愿后台控制器
 * @author Shines
 */
class AdminWishController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'wishCount':
				$this->wishCount();
				return;
			case 'wishList':
				$this->wishList();
				return;
			case 'exportData':
				$this->exportData();
				return;
			case 'deleteWish':
				$this->deleteWish();
				return;
			default:
		}
	}
	
	private function wishCount()
	{
		$this->checkLogin();
		$wish = new Wish();
		$userList = $wish->getTbUser();
		$wishList = $wish->getTbWish();
		$dayList = array();
		$totalUser = 0;
		$totalWish = 0;
		foreach ($userList as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['regtime']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userCount'] = 0;
				$dayList[$date]['wishCount'] = 0;
			}
			$dayList[$date]['userCount']++;
			$totalUser++;
		}
		foreach ($wishList as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['pubdate']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userCount'] = 0;
				$dayList[$date]['wishCount'] = 0;
			}
			$dayList[$date]['wishCount']++;
			$totalWish++;
		}
		$this->showCount($dayList, $totalUser, $totalWish);
	}
	
	private function wishList()
	{
		$this->checkLogin();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$wish = new Wish();
		$wishList = $wish->getAdminWish($page, Config::$wishAdminPagesize);
		foreach ($wishList as $key => $value)
		{
			$wishList[$key]['id'] = (int)$wishList[$key]['id'];
			/*
			if (empty($wishList[$key]['localphoto']))
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			}
			else
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['localphoto']);
			}
			
			$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			$wishList[$key]['username'] = System::fixHtml($wishList[$key]['username']);
			$wishList[$key]['gender'] = System::fixHtml($wishList[$key]['gender']);
			$wishList[$key]['email'] = System::fixHtml($wishList[$key]['email']);
			$wishList[$key]['pubdate'] = System::fixHtml($wishList[$key]['pubdate']);
			*/
			$wishList[$key]['content'] = System::fixHtml($wishList[$key]['content']);
		}
		
		$pagelist = new Page();
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->urlBase = '?m=adminWish&a=wishList&page=';
		//$pagelist->leftDelimiter = '';
		//$pagelist->rightDelimiter = '';
		$allCount = $wish->getWishCount();
		$pagelist->totalPage = ceil($allCount / Config::$wishAdminPagesize);
		$pageStr = $pagelist->getPages($page);
		$this->showWishList($wishList, $pageStr, $page);
	}
	
	private function exportData()
	{
		$this->checkLogin();
		$wish = new Wish();
		$wish->exportUser();
	}
	
	private function deleteWish()
	{
		$this->checkLogin();
		$id = (int)Security::varGet('id');
		$page = (int) Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$wish = new Wish();
		$wish->deleteWish($id);
		$wishList = $wish->getAdminWish($page, Config::$wishAdminPagesize);
		foreach ($wishList as $key => $value)
		{
			$wishList[$key]['id'] = (int)$wishList[$key]['id'];
			/*
			if (empty($wishList[$key]['localphoto']))
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			}
			else
			{
				$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['localphoto']);
			}
			$wishList[$key]['photo'] = System::fixHtml($wishList[$key]['photo']);
			$wishList[$key]['username'] = System::fixHtml($wishList[$key]['username']);
			$wishList[$key]['gender'] = System::fixHtml($wishList[$key]['gender']);
			$wishList[$key]['email'] = System::fixHtml($wishList[$key]['email']);
			$wishList[$key]['pubdate'] = System::fixHtml($wishList[$key]['pubdate']);
			*/
			$wishList[$key]['content'] = System::fixHtml($wishList[$key]['content']);
		}
		
		$pagelist = new Page();
		$pagelist->format = '{preve}{pages}{next}';
		$pagelist->urlBase = '?m=adminWish&a=wishList&page=';
		//$pagelist->leftDelimiter = '';
		//$pagelist->rightDelimiter = '';
		$allCount = $wish->getWishCount();
		$pagelist->totalPage = ceil($allCount / Config::$wishAdminPagesize);
		$pageStr = $pagelist->getPages($page);
		$this->showWishList($wishList, $pageStr, $page);
	}
	
	private function showCount($dayList, $totalUser, $totalWish)
	{
		include(Config::$templatesDir . 'admin_wish/count.php');
	}
	
	private function showWishList($wishList, $pageStr, $page)
	{
		include(Config::$templatesDir . 'admin_wish/wishlist.php');
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
