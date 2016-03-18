<?php
/**
 * 管理后台控制器
 */
class AdminZeroController
{
	private $admin = null;//管理员模型
	private $zero = null;
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->zero = new FbZero();
		$action = Security::varGet('a');//操作标识
		
		if ($this->admin->checkLogin())
		{
			switch ($action)
			{
				case 'mainCount':
					$this->mainCount();
					return;
				case 'listPic':
					$this->listPic();
					return;
				case 'deletePic':
					$this->deletePic();
					return;
				default:
			}
		}
		else
		{
			$this->login();
		}
	}
	
	private function mainCount()
	{
		$_usersTotal = $this->zero->getUsersCount();
		$_picturesTotal = $this->zero->getPicCount();
		$_likesTotal = $this->zero->getLikesCount();
		$_commentsTotal = $this->zero->getCommentsCount();
		
		$_fbUsersTotal = $this->zero->usersCountByType(1);
		$_fbPicturesTotal = $this->zero->picCountByType(1);
		$_fbLikesTotal = $this->zero->likesCountByType(1);
		$_fbCommentsTotal = $this->zero->commentsCountByType(1);
		
		$_mUsersTotal = $this->zero->usersCountByType(2);
		$_mPicturesTotal = $this->zero->picCountByType(2);
		$_mLikesTotal = $this->zero->likesCountByType(2);
		$_mCommentsTotal = $this->zero->commentsCountByType(2);
		
		$_mwUsersTotal = $this->zero->usersCountByType(3);
		$_mwPicturesTotal = $this->zero->picCountByType(3);
		$_mwLikesTotal = $this->zero->likesCountByType(3);
		$_mwCommentsTotal = $this->zero->commentsCountByType(3);
		
		switch (Config::$configType)
		{
			case 5:
				$_country = 'Nigeria';
				break;
			case 6:
				$_country = 'Kenya';
				break;
			case 7:
				$_country = 'Egypt';
				break;
			case 8:
				$_country = 'Saudi Abrabia';
				break;
			case 9:
				$_country = 'Pakistan';
				break;
			case 10:
				$_country = 'Indonesia';
				break;
			default:
				$_country = 'Test Version';
		}
		include('view/admin/main_count.php');
	}
	
	private function listPic()
	{
		$page = (int) Security::varGet('page');
		$this->showPic($page);
	}
	
	private function showPic($page)
	{
		$pagesize = 20;
		if ($page < 1)
		{
			$page = 1;
		}
		$pagelist = new Page();
		$pagelist->format = '{pages}';
		$pagelist->urlBase = '?m=adminZero&a=listPic&page=';
		$pagelist->leftDelimiter = '';
		$pagelist->rightDelimiter = '';
		$allCount = $this->zero->getPicCount();
		$pagelist->totalPage = ceil($allCount / $pagesize);
		$_pagelist = $pagelist->getPages($page);
		$_page = $page;
		$_pagesize = $pagesize;
		$_data = $this->zero->getPics($page, $pagesize);
		$_appUrl = Config::$fbAppUrl;
		include('view/admin/list_pic.php');
	}
	
	private function deletePic()
	{
		$picId = (int) Security::varGet('id');
		$page = (int) Security::varGet('page');
		$this->zero->deletePic($picId);
		$this->showPic($page);
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function login()
	{
		include('view/admin/login.php');
	}
}
?>
