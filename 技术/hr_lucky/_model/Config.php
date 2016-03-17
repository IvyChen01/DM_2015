<?php
/**
 * 配置信息
 */
class Config
{
	public static $debugEnabled = false;//调试开关
	public static $systemName = 'hr_lucky';//系统名称
	public static $key = '{a}1ba.c,af,hr_luc9kyc.a251';//密钥
	public static $baseUrl = 'http://hr.transsion.qumuwu.com';//当前网址，线上或本地
	public static $dirBackup = 'extends/db_backup/';//数据库备份目录
	public static $dirRecover = 'extends/db_recover/';//数据库恢复目录
	public static $dirLog = 'extends/log/';//日志目录
	public static $dirUploads = 'extends/uploads/';//上传目录
	public static $dirCache = 'extends/cache/';//缓存主目录
	public static $installLock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if(!defined(\'VIEW\')) exit(0); ?>';//VIEW入口检测代码
	public static $countCode = '';//统计代码
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('TECNO 酷炫手表', 'TECNO 运动水壶', 'TECNO 创意水杯', 'TECNO 充电宝', 'TECNO 蓝牙耳机', '', '', '', '', '');//奖品名称
	
	public static $wxAppId = 'wx60ca7e67f4c36fc7';//微信app id
	public static $wxAppSecret = 'f76273583956c6f44297fbd3d44bd866';//微信app secret
	
	public static $fbAppId = '';//facebook app id
	public static $fbAppKey = '';//facebook app key
	public static $fbAppRedirectUrl = '';//facebook app跳转地址
	public static $fbAppUrl = '';//facebook app地址
	
	public static $tbAdmin = 'hr_admin';//管理员表
	public static $tbJiangChi = 'hr_jiang_chi';//奖池表
	public static $tbZhongJiang = 'hr_zhong_jiang';//中奖表
	public static $tbLuckyDaily = 'hr_lucky_daily';//每日抽奖表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//线上数据库配置信息
	private static $dbOnline = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '84374e6dd5',//密码
		'dbName' => 'hr_lucky',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'hr_lucky',//数据库名
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
		if (self::$debugEnabled)
		{
			@error_reporting(E_ALL);
			self::$dbConfig = self::$dbLocal;
		}
		else
		{
			@error_reporting(0);
			self::$dbConfig = self::$dbOnline;
		}
		@date_default_timezone_set('PRC');
		@session_start();
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
		define('TOKEN', '8023happy');
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$dirLog . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$dirLog . 'time_' . Utils::mdate('Y-m-d') . '.php';
		self::$db = new Database(self::$dbConfig);
	}
}
?>
