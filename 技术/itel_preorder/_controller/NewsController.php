<?php
/**
 * 新闻控制器
 * @author Shines
 */
class NewsController
{
	public function __construct()
	{
		//System::fixUrl();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'detail':
				$this->detailNews();
				return;
			default:
				$this->listNews();
		}
	}
	
	/**
	 * 显示新闻列表页
	 * [增加分页列表]
	 */
	private function listNews()
	{
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$news = new News();
		$_news = $news->getNewsByPage($page, Config::$newsPagesize);
		$_countCode = System::getCountCode();
		include(Config::$viewDir . 'news/list.php');
		
		/*
		if (Utils::checkMobile())
		{
			//手机版
			include(Config::$viewDir . 'news/mobile_list.php');
		}
		else
		{
			//PC版
			include(Config::$viewDir . 'news/list.php');
		}
		*/
	}
	
	/**
	 * 显示新闻页
	 */
	private function detailNews()
	{
		$id = (int) Security::varGet('id');
		$news = new News();
		$_news = $news->readNewsById($id);
		$_countCode = System::getCountCode();
		if (empty($_news))
		{
			include('404.html');
		}
		else
		{
			include(Config::$viewDir . 'news/detail.php');
			
			/*
			if (Utils::checkMobile())
			{
				//手机版
				include(Config::$viewDir . 'news/mobile_detail.php');
			}
			else
			{
				//PC版
				include(Config::$viewDir . 'news/detail.php');
			}
			*/
		}
	}
}
?>
