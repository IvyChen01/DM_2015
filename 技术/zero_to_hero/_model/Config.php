<?php
/**
 * 配置信息
 */
class Config
{
	public static $configType = 10;//配置方案//5：尼日利亚，6：肯尼亚，7：埃及，8：沙特阿拉伯，9：巴基斯坦，10：印尼
	public static $isLocal = false;//调试开关
	public static $isFb = false;//是否连接Facebook
	public static $systemName = 'p67_zero_to_hero';//系统名称
	public static $key = '22a,p67__zer.,o_to_hero1.f9f';//密钥
	public static $dirBackup = 'extends/db_backup/';//数据库备份目录
	public static $dirRecover = 'extends/db_recover/';//数据库恢复目录
	public static $dirLog = 'extends/log/';//日志目录
	public static $dirUploads = 'extends/uploads/';//上传目录
	public static $dirCache = 'extends/cache/';//缓存主目录
	public static $dirCacheNews = 'extends/cache/news/';//新闻缓存目录
	public static $installLock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if(!defined(\'VIEW\')) exit(0); ?>';//VIEW入口检测代码
	public static $countCode = '';//统计代码
	
	public static $maxUpload = 3;//3次上传机会
	public static $startDate = '2015-5-4';//活动的开始日期，用于计算当前为第几周
	public static $loginTypes = array('fb', 'apk', 'wap');//账号类型
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $fbAppId = '728451010610692';//facebook app id
	public static $fbAppKey = '8befd93e19e95fef3bc2cebf8c69839f';//facebook app key
	public static $fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/infinixzero/';//facebook app跳转地址
	public static $fbAppUrl = 'https://apps.facebook.com/infinixzero/';//facebook app地址
	
	public static $tbAdmin = 'zero_admin';//管理员表
	public static $tbUser = 'zero_user';//会员表
	public static $tbPic = 'zero_pic';//图片表
	public static $tbLike = 'zero_like';//点赞表
	public static $tbComment = 'zero_comment';//评论表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $baseUrl = '';//当前网址，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//qumuwu数据库配置信息
	private static $dbQumuwu = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//infinixmobility数据库配置信息
	private static $dbInfinix = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//infinix2数据库配置信息
	private static $dbInfinixZero = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'zerotohero',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//尼日利亚数据库配置信息
	private static $dbZeroNg = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_ng',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//肯尼亚数据库配置信息
	private static $dbZeroKe = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_ke',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//埃及数据库配置信息
	private static $dbZeroEg = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_eg',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//沙特阿拉伯数据库配置信息
	private static $dbZeroSa = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_sa',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//巴基斯坦数据库配置信息
	private static $dbZeroPk = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_pk',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//印尼数据库配置信息
	private static $dbZeroId = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'zero_id',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		//设置中国时区，开启session
		@date_default_timezone_set('PRC');
		@session_start();
		if (self::$isLocal)
		{
			@error_reporting(E_ALL);
			self::$configType = 1;
		}
		else
		{
			@error_reporting(0);
		}
		
		switch (self::$configType)
		{
			case 1:
				//localhost
				self::$systemName = 'local_zero';
				self::$dbConfig = self::$dbLocal;
				self::$baseUrl = 'http://localhost:8008';
				self::$isFb = false;
				break;
			case 2:
				//qumuwu
				self::$systemName = 'qumuwu_zero';
				self::$dbConfig = self::$dbQumuwu;
				self::$baseUrl = 'http://zero.infinixmobility.qumuwu.com';
				self::$isFb = false;
				break;
			case 3:
				//infinixmobility
				self::$systemName = 'infinix_zero';
				self::$dbConfig = self::$dbInfinix;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/zerotohero';
				self::$isFb = false;
				break;
			case 4:
				//infinix线上
				self::$systemName = 'common_zero';
				self::$dbConfig = self::$dbInfinixZero;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/infinixzero';
				self::$isFb = true;
				self::$fbAppId = '728451010610692';
				self::$fbAppKey = '8befd93e19e95fef3bc2cebf8c69839f';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/infinixzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixzero/';
				break;
			case 5:
				//尼日利亚
				self::$systemName = 'ng_zero';
				self::$dbConfig = self::$dbZeroNg;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/ngzero';
				self::$isFb = true;
				self::$fbAppId = '634236150045400';
				self::$fbAppKey = 'a50a59a5aaaf1792e15987469ca30ac8';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/ngzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixng_zerotohero/';
				break;
			case 6:
				//肯尼亚
				self::$systemName = 'ke_zero';
				self::$dbConfig = self::$dbZeroKe;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/kezero';
				self::$isFb = true;
				self::$fbAppId = '726708487440435';
				self::$fbAppKey = '977a982884057f8a8362756e6ae0f6c0';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/kezero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixke_zerotohero/';
				break;
			case 7:
				//埃及
				self::$systemName = 'eg_zero';
				self::$dbConfig = self::$dbZeroEg;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/egzero';
				self::$isFb = true;
				self::$fbAppId = '459057217590512';
				self::$fbAppKey = '0dfe0c4d9803fbb026282be61c98ded1';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/egzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixeg_zerotohero/';
				break;
			case 8:
				//沙特阿拉伯
				self::$systemName = 'sa_zero';
				self::$dbConfig = self::$dbZeroSa;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/sazero';
				self::$isFb = true;
				self::$fbAppId = '834409353313840';
				self::$fbAppKey = 'f78bc9de4ac686f041a02905fb115cc1';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/sazero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixsa_zerotohero/';
				break;
			case 9:
				//巴基斯坦
				self::$systemName = 'pk_zero';
				self::$dbConfig = self::$dbZeroPk;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/pkzero';
				self::$isFb = true;
				self::$fbAppId = '300775696781186';
				self::$fbAppKey = '7242a09640089ea86994eb3bd0d6c002';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/pkzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixpk_zerotohero/';
				break;
			case 10:
				//印尼
				self::$systemName = 'id_zero';
				self::$dbConfig = self::$dbZeroId;
				self::$baseUrl = 'http://www.infinixmobility.com/fb/idzero';
				self::$isFb = true;
				self::$fbAppId = '1598722133727859';
				self::$fbAppKey = '5198f892ec6a3e8bac73b7f036c9580d';
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/fb/idzero/';
				self::$fbAppUrl = 'https://apps.facebook.com/infinixid_zerotohero/';
				break;
			default:
		}
		
		if (!self::$isFb)
		{
			self::$fbAppUrl = self::$baseUrl . '/';
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$dirLog . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$dirLog . 'time_' . Utils::mdate('Y-m-d') . '.php';
		self::$db = new Database(self::$dbConfig);
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
	}
}
?>
