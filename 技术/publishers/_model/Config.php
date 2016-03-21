<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	//通用部分
	public static $scheme = 2;//配置方案。1：local，2：线上68
	public static $isLocal = false;//是否为本地模式
	public static $backupDir = 'data/backup/';//数据库备份目录
	public static $recoverDir = 'data/recover/';//数据库恢复目录
	public static $logDir = 'data/log/';//日志目录
	public static $uploadsDir = 'data/uploads/';//上传目录
	public static $newsCacheDir = 'data/cache/news/';//新闻缓存目录
	public static $viewDir = '_view';//模板目录
	public static $htmlDir = 'html/';//模板缓存目录
	public static $viewMd5 = 'data/md5_view.php';//模板md5文件，用来检测模板是否有修改
	public static $installLock = 'data/lock_install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if (!defined(\'VIEW\')) exit; ?>';//VIEW入口检测代码
	public static $deviceType = '';//设备类型，pc，mobile
	public static $db = null;//数据库
	public static $tbSession = 'publishers_session';//会话表
	public static $tbAdmin = 'publishers_admin';//管理员表
	public static $tbUser = 'publishers_user';//用户表
	public static $tbFriend = 'publishers_friend';//好友表
	public static $tbMessage = 'publishers_message';//留言表
	public static $tbNews = 'publishers_news';//新闻表
	public static $tbNewsPic = 'publishers_news_pic';//新闻图片表
	public static $tbComment = 'publishers_comment';//评论表
	public static $tbCollection = 'publishers_collection';//收藏表
	public static $tbLike = 'publishers_like';//点赞表
	public static $tbChannel = 'publishers_channel';//栏目表
	public static $tbUserChannel = 'publishers_user_channel';//用户栏目表
	public static $tbFeedback = 'publishers_feedback';//反馈表
	public static $tbFaq = 'publishers_faq';//FAQ表
	public static $dataUrl = 'http://globalpublishers.co.tz';//获取数据地址
	public static $sid = '';//session id，会话id
	public static $msg = array
	(
		//通用
		'ok' => array('code' => 0, 'msg' => 'ok'),
		'requestError' => array('code' => 1, 'msg' => 'Request Error!'),
		
		//用户
		'noLogin' => array('code' => 101001, 'msg' => 'Not login!'),
		'usernamePwError' => array('code' => 101002, 'msg' => 'Username or password error!'),
		'verifyError' => array('code' => 101003, 'msg' => 'Verify error!'),
		'srcPwErorr' => array('code' => 101004, 'msg' => 'Source password error!'),
		'newPwError' => array('code' => 101005, 'msg' => 'New password too simple!'),
		'userExist' => array('code' => 101006, 'msg' => 'User exist!'),
		'emailFormatError' => array('code' => 101007, 'msg' => 'Email format error!'),
		'userPwEmailEmpty' => array('code' => 101008, 'msg' => 'Username password and email cannot be empty!'),
		'usernameExist' => array('code' => 101009, 'msg' => 'Username exist!'),
		'emailExist' => array('code' => 101010, 'msg' => 'Email exist!'),
		'genUidError' => array('code' => 101011, 'msg' => 'Generate ID error, please retry!'),
		'photoError' => array('code' => 101012, 'msg' => 'Upload photo error!')
	);//操作提示
	
	//单独配置部分
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = '';//资源文件地址
	public static $systemName = '';//系统名称
	public static $key = '';//密钥
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $ipUrl = '';//IP地址库
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	public static $maxPrize = 0;//最大奖品数
	public static $prizeName = null;//奖品名称
	public static $prizeMoney = null;//奖品名称
	public static $adminNewsPagesize = 0;//新闻管理每页显示新闻条数
	public static $maxNewsPagesize = 0;//前端每页显示新闻条数
	public static $maxContent = 0;//最大新闻长度
	public static $countCode = '';//统计代码
	
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'publishers',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);//本地数据库配置信息
	
	private static $db68 = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB68transsion',//密码
		'dbName' => 'publishers',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);//线上68数据库配置信息
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		@session_start();
		if (self::$isLocal)
		{
			self::$scheme = 1;
		}
		switch (self::$scheme)
		{
			case 1:
				self::configLocal();
				break;
			case 2:
				self::config68();
				break;
			default:
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$logDir . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$logDir . 'time_' . Utils::mdate('Y-m-d') . '.php';
		Debug::$maxTime = 0.01;
		self::$db = new Database(self::$dbConfig);
		define('VIEW', true);//限制视图文件须由控制器调用才可执行
	}
	
	/**
	 * 本地模式
	 */
	private static function configLocal()
	{
		@error_reporting(E_ALL);
		@date_default_timezone_set('Etc/GMT-8');//北京时间
		self::$dbConfig = self::$dbLocal;//数据库配置信息，线上或本地
		self::$baseUrl = 'http://172.17.2.73/svn/publishers';//当前网址，线上或本地
		self::$resUrl = 'http://172.17.2.73/svn/publishers';//资源文件地址
		self::$systemName = 'publishers';//系统名称
		self::$key = 'fieiubv,.257,._aiii111s';//密钥
		self::$newsEnabled = false;//新闻开关
		self::$zhuanPanEnabled = false;//转盘开关
		self::$hongBaoEnabled = false;//红包开关
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$maxPrize = 10;//最大奖品数
		self::$prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
		self::$prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
		self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
		self::$maxNewsPagesize = 1000;//前端每页显示新闻条数
		self::$maxContent = 10000;//最大新闻长度
		self::$countCode = '';//统计代码
	}
	
	/**
	 * 线上模式
	 */
	private static function config68()
	{
		@error_reporting(0);
		@date_default_timezone_set('Etc/GMT-8');//北京时间
		self::$dbConfig = self::$db68;//数据库配置信息，线上或本地
		self::$baseUrl = 'http://159.8.94.68/publishers';//当前网址，线上或本地
		self::$resUrl = 'http://159.8.94.68/publishers';//资源文件地址
		self::$systemName = 'publishers';//系统名称
		self::$key = 'iexcvmn12,_,1anxl,,..';//密钥
		self::$newsEnabled = false;//新闻开关
		self::$zhuanPanEnabled = false;//转盘开关
		self::$hongBaoEnabled = false;//红包开关
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$maxPrize = 10;//最大奖品数
		self::$prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
		self::$prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
		self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
		self::$maxNewsPagesize = 1000;//前端每页显示新闻条数
		self::$maxContent = 10000;//最大新闻长度
		self::$countCode = '';//统计代码
	}
}
?>
