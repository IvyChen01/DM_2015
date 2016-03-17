<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	//通用部分
	public static $scheme = 2;//配置方案。1：local，2：vn
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
	public static $tbSession = 'zero3vn_session';//会话表
	public static $tbAdmin = 'zero3vn_admin';//管理员表
	public static $tbUser = 'zero3vn_user';//用户表
	public static $tbZpJiangChi = 'zero3vn_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'zero3vn_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'zero3vn_zp_daily';//转盘每日抽奖表
	public static $sid = '';//session id，会话id
	public static $dailyPagesize = 5;
	public static $rankPagesize = 5;//排行榜每页显示排名个数
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	public static $msg = array
	(
		//通用
		'ok' => array('code' => 0, 'msg' => 'ok'),
		
		//用户
		'noLogin' => array('code' => 101001, 'msg' => 'No login!'),
		'usernamePwError' => array('code' => 101002, 'msg' => 'Username or password error!'),
		'verifyError' => array('code' => 101003, 'msg' => 'Verify error!'),
		'srcPwErorr' => array('code' => 101004, 'msg' => 'Source password error!'),
		'newPwError' => array('code' => 101005, 'msg' => 'New password too simple!'),
		'userExist' => array('code' => 101006, 'msg' => 'Username exist!'),
		'emailFormatError' => array('code' => 101007, 'msg' => 'Email format error!'),
		
		//新闻
		'contentLong' => array('code' => 102001, 'msg' => 'Content too long!'),
		
		//转盘抽奖
		'licked' => array('code' => 103001, 'msg' => 'Clicked!'),
		'deptUsernameEmpty' => array('code' => 103002, 'msg' => 'Dept and username cannot be empty!'),
		'submitRepeat' => array('code' => 103003, 'msg' => 'Submited!'),
		'noChances' => array('code' => 103004, 'msg' => 'No chances!'),
		'shared' => array('code' => 103005, 'msg' => 'Shared!'),
		
		//抢红包
		'jobnumUsernameEmpty' => array('code' => 104001, 'msg' => 'Jobnum and username cannot be empty!'),
		'jobnumUsernameError' => array('code' => 104002, 'msg' => 'Jobnum or username error!'),
		'jobnumBinded' => array('code' => 104003, 'msg' => 'This jobnum has been binded!'),
		'wxNumBinded' => array('code' => 104004, 'msg' => 'This id has been binded!'),
		'RequestError' => array('code' => 104005, 'msg' => 'Request error!')
	);//操作提示
	//public static $activeTime = '2016-3-17 0:0:0';
	//public static $endTime = '2016-3-19 0:0:0';
	
	public static $activeTime = '2016-3-17 0:0:0';
	public static $endTime = '2016-3-19 0:0:0';
	
	//单独配置部分
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = '';//资源文件地址
	public static $systemName = '';//系统名称
	public static $key = '';//密钥
	public static $ipUrl = '';//IP地址库
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	public static $countCode = '';//统计代码
	public static $isFb = false;//是否调用facebook接口
	public static $fbAppId = '';//facebook app id
	public static $fbAppKey = '';//facebook app key
	public static $fbAppRedirectUrl = '';//facebook app跳转地址
	public static $fbAppUrl = '';//facebook app地址
	public static $siteUrl = '';
	public static $shareUrl = '';
	public static $sharePic = '';
	
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero3vn',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);//本地数据库配置信息
	
	private static $dbVn = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero3vn',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);//Infinix数据库配置信息
	
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
				self::configVn();
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
		self::$baseUrl = 'http://localhost:8017';//当前网址，线上或本地
		self::$resUrl = 'http://localhost:8017';//资源文件地址
		self::$systemName = 'zero3vn';//系统名称
		self::$key = '5fzero3vnf.8a__dlL23zero3';//密钥
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$countCode = '';//统计代码
		self::$isFb = false;
		self::$fbAppId = '';//facebook app id
		self::$fbAppKey = '';//facebook app key
		self::$fbAppRedirectUrl = '';//facebook app跳转地址
		self::$fbAppUrl = '';//facebook app地址
		self::$siteUrl = 'http://localhost:8017/?a=lucky';
		self::$shareUrl = 'http://localhost:8017/?shareId=';
		self::$sharePic = 'http://localhost:8017/images/share.jpg';
	}
	
	/**
	 * 线上模式
	 */
	private static function configVn()
	{
		@error_reporting(0);
		@date_default_timezone_set('Etc/GMT-7');//越南时间
		self::$dbConfig = self::$dbVn;//数据库配置信息，线上或本地
		self::$baseUrl = 'www.infinixmobility.com/zero3vn';//当前网址，线上或本地
		self::$resUrl = 'www.infinixmobility.com/zero3vn';//资源文件地址
		self::$systemName = 'zero3vn';//系统名称
		self::$key = 'fixzero3vnv789aSfi_.,_a';//密钥
		self::$ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
		self::$wxAppId = '';//微信app id
		self::$wxAppSecret = '';//微信app secret
		self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54295225-5', 'auto');
  ga('send', 'pageview');

</script>";//统计代码
		self::$isFb = true;
		self::$fbAppId = '956885524425857';//facebook app id
		self::$fbAppKey = '796bf7f6e00143d15aa1a81b56f14aae';//facebook app key
		self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/zero3vn/';//facebook app跳转地址
		self::$fbAppUrl = 'https://apps.facebook.com/zero3vn/';//facebook app地址
		self::$siteUrl = 'http://www.infinixmobility.com/zero3vn/?a=lucky';
		self::$shareUrl = 'http://www.infinixmobility.com/zero3vn/?shareId=';
		self::$sharePic = 'http://www.infinixmobility.com/zero3vn/images/share.jpg';
	}
}
?>
