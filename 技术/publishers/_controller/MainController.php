<?php
/**
 * 主入口
 * @author Shines
 */
class MainController
{
	public function __construct()
	{
		Config::init();
		$module = Security::varGet('m');//模块标识
		$action = Security::varGet('a');//操作标识
		Config::$deviceType = Security::varGet('d');//设备类型
		if (empty(Config::$deviceType))
		{
			if (Utils::checkMobile())
			{
				//手机版
				Config::$deviceType = 'mobile';
			}
			else
			{
				//PC版
				Config::$deviceType = 'pc';
			}
		}
		
		switch ($module)
		{
			case 'install':
				$this->goInstall($action);
				break;
			case 'admin':
				$this->goAdmin($action);
				break;
			case 'user':
				$this->goUser($action);
				break;
			case 'news':
				$this->goNews($action);
				break;
			case 'info':
				$this->goInfo($action);
				break;
			case 'video':
				$this->goVideo($action);
				break;
			default:
		}
		
		//记录执行时间过长的接口
		if (!Config::$isLocal)
		{
			Debug::logMaxTime("[$module][$action]");
		}
		
		/////////// debug
		Debug::log('GET: ' . json_encode($_GET));
		Debug::log('POST: ' . json_encode($_POST));
	}
	
	/**
	 * 安装模块
	 */
	private function goInstall($action)
	{
		$controller = new InstallController();
		switch ($action)
		{
			case 'dbName':
				$controller->dbName();
				break;
			case 'createDatabase':
				$controller->createDatabase();
				break;
			case 'install':
				$controller->install();
				break;
			default:
		}
	}
	
	/**
	 * 管理员模块
	 */
	private function goAdmin($action)
	{
		$controller = new AdminController();
		switch ($action)
		{
			case 'verify':
				$controller->verify();
				break;
			case 'doLogin':
				$controller->doLogin();
				break;
			case 'changePassword':
				$controller->changePassword();
				break;
			case 'doChangePassword':
				$controller->doChangePassword();
				break;
			case 'logout':
				$controller->logout();
				break;
			case 'install':
				$controller->install();
				break;
			case 'db':
				$controller->db();
				break;
			case 'dbNews':
				$controller->dbNews();
				break;
			case 'upgrade':
				$controller->upgrade();
				break;
			case 'backup':
				$controller->backup();
				break;
			case 'recover':
				$controller->recover();
				break;
			case 'find':
				$controller->find();
				break;
			case 'log':
				$controller->log();
				break;
			case 'logTime':
				$controller->logTime();
				break;
			case 'phpinfo':
				$controller->info();
				break;
			case 'date':
				$controller->showDate();
				break;
			default:
				$controller->main();
		}
	}
	
	/**
	 * 用户模块
	 */
	private function goUser($action)
	{
		$controller = new UserController();
		switch ($action)
		{
			case 'verify':
				$controller->verify();
				break;
			case 'register':
				$controller->register();
				break;
			case 'login':
				$controller->login();
				break;
			case 'setNick':
				$controller->setNick();
				break;
			case 'setPhone':
				$controller->setPhone();
				break;
			case 'setSignature':
				$controller->setSignature();
				break;
			case 'uploadPhoto':
				$controller->uploadPhoto();
				break;
			case 'logout':
				$controller->logout();
				break;
			case 'setEmail':
				$controller->setEmail();
				break;
			case 'changePassword':
				$controller->changePassword();
				break;
			case 'resetPassword':
				$controller->resetPassword();
				break;
			default:
		}
	}
	
	/**
	 * 新闻模块
	 */
	private function goNews($action)
	{
		$controller = new NewsController();
		switch ($action)
		{
			case 'updateNews':
				$controller->updateNews();
				break;
			case 'getRecentNews':
				$controller->getRecentNews();
				break;
			case 'getChannelNews':
				$controller->getChannelNews();
				break;
			case 'getComment':
				$controller->getComment();
				break;
			case 'addComment':
				$controller->addComment();
				break;
			case 'getChannel':
				$controller->getChannel();
				break;
			case 'addUserChannel':
				$controller->addUserChannel();
				break;
			case 'removeUserChannel':
				$controller->removeUserChannel();
				break;
			case 'moveUserChannel':
				$controller->moveUserChannel();
				break;
			case 'getLike':
				$controller->getLike();
				break;
			case 'like':
				$controller->like();
				break;
			case 'unlike':
				$controller->unlike();
				break;
			case 'getCollection':
				$controller->getCollection();
				break;
			case 'collect':
				$controller->collect();
				break;
			case 'uncollect':
				$controller->uncollect();
				break;
			case 'getMyComments':
				$controller->getMyComments();
				break;
			case 'search':
				$controller->search();
				break;
			case 'test':
				$controller->test();
				break;
			default:
		}
	}
	
	/**
	 * 消息模块
	 */
	private function goInfo($action)
	{
		$controller = new InfoController();
		switch ($action)
		{
			case 'getSystemMessage':
				$controller->getSystemMessage();
				break;
			case 'setSystemMessage':
				$controller->setSystemMessage();
				break;
			case 'deleteSystemMessage':
				$controller->deleteSystemMessage();
				break;
			case 'getFeedback':
				$controller->getFeedback();
				break;
			case 'setFeedback':
				$controller->setFeedback();
				break;
			case 'deleteFeedback':
				$controller->deleteFeedback();
				break;
			case 'getAllFeedback':
				$controller->getAllFeedback();
				break;
			case 'getVersion':
				$controller->getVersion();
				break;
			case 'getFaq':
				$controller->getFaq();
				break;
			case 'uploadImage':
				$controller->uploadImage();
				break;
			default:
		}
	}
	
	/**
	 * 视频模块
	 */
	private function goVideo($action)
	{
		$controller = new VideoController();
		switch ($action)
		{
			case 'test':
				//$controller->getSystemMessage();
				break;
			default:
				$controller->index();
		}
	}
}
?>
