<?php
/**
 * 新闻管理控制器
 * @author Shines
 */
class AdminNewsController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'add':
				$this->add();
				return;
			case 'doAdd':
				$this->doAdd();
				return;
			case 'modify':
				$this->modify();
				return;
			case 'doModify':
				$this->doModify();
				return;
			case 'delete':
				$this->delete();
				return;
			case 'detail':
				$this->detail();
				return;
			case 'uploadImage':
				return;
				$this->uploadImage();
				return;
			default:
				$this->main();
		}
	}
	
	/**
	 * 新闻管理首页
	 */
	private function main()
	{
		$this->checkLogin();
		$page = (int)Security::varGet('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$news = new News();
		$_news = $news->getNewsByPage($page, Config::$adminNewsPagesize);
		include(Config::$templatesDir . 'admin_news/main.php');
	}
	
	/**
	 * 显示添加新闻页
	 */
	private function add()
	{
		$this->checkLogin();
		include(Config::$templatesDir . 'admin_news/add.php');
	}
	
	/**
	 * 添加新闻
	 */
	private function doAdd()
	{
		System::fixSubmit('doAdd');
		$this->checkLogin(true);
		$content = Security::varPost('content');
		$contentLen = mb_strlen($content, 'utf-8');
		if ($contentLen > Config::$maxContent)
		{
			System::echoData(Config::$msg['contentLong']);
		}
		else
		{
			$news = new News();
			$id = $news->addNews($content);
			System::echoData(Config::$msg['ok'], array('id' => $id));
		}
	}
	
	/**
	 * 显示修改新闻页
	 */
	private function modify()
	{
		$this->checkLogin();
		$id = (int) Security::varGet('id');
		$news = new News();
		$news->setModifyId($id);
		$_news = $news->getNewsById($id);
		if (empty($_news))
		{
			include('404.html');
		}
		else
		{
			include(Config::$templatesDir . 'admin_news/modify.php');
		}
	}
	
	/**
	 * 修改新闻
	 */
	private function doModify()
	{
		System::fixSubmit('doModify');
		$this->checkLogin(true);
		$content = Security::varPost('content');
		$pubdate = Security::varPost('pubdate');
		$contentLen = mb_strlen($content, 'utf-8');
		if ($contentLen > Config::$maxContent)
		{
			System::echoData(Config::$msg['contentLong']);
		}
		else
		{
			$news = new News();
			$id = $news->getModifyId();
			$news->modifyNews($id, $content, $pubdate);
			System::echoData(Config::$msg['ok']);
		}
	}
	
	/**
	 * 删除新闻
	 */
	private function delete()
	{
		$this->checkLogin();
		$id = (int) Security::varGet('id');
		$news = new News();
		$news->deleteNews($id);
		$this->main();
	}
	
	/**
	 * 显示新闻页
	 */
	private function detail()
	{
		$this->checkLogin();
		$id = (int) Security::varGet('id');
		$news = new News();
		$_news = $news->readNewsById($id);
		if (empty($_news))
		{
			include('404.html');
		}
		else
		{
			include(Config::$templatesDir . 'admin_news/detail.php');
		}
	}
	
	/**
	 * 上传图片
	 */
	private function uploadImage()
	{
		System::fixSubmit('uploadImage');
		$this->checkLogin(true);
		echo System::uploadImage();
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
