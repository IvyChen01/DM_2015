<?php
/**
 * 配置信息
 */
class Config
{
	public static $debugEnabled = true;//调试开关
	public static $systemName = 'call_management';//系统名称
	public static $key = 'a1gb..bacall_ma.,nagementa2ff4';//密钥
	public static $baseUrl = 'http://www.carlcare.com';//当前网址，线上或本地
	public static $dirBackup = 'extends/db_backup/';//数据库备份目录
	public static $dirRecover = 'extends/db_recover/';//数据库恢复目录
	public static $dirLog = 'extends/log/';//日志目录
	public static $dirUploads = 'extends/uploads/';//上传目录
	public static $dirCache = 'extends/cache/';//缓存主目录
	public static $installLock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if(!defined(\'VIEW\')) exit(0); ?>';//VIEW入口检测代码
	public static $countCode = '';//统计代码
	
	public static $customerPagesize = 10;
	
	public static $status = array
	(
		'wait', 
		'success', 
		'failed'
	);
	
	public static $errorStatus = array
	(
		'Not the respondent himself/herself answers the phone', 
		'The line is busy', 
		'respondent refused', 
		'The subscriber dialed cannot be connected/powered off', 
		'No one answers the phone',
		'The number dialed does not exist/ digits of phone number is incorrect',
		'Others'
	);
	
	public static $language = array
	(
		'English', 
		'aaa', 
		'bbb'
	);
	
	public static $q1 = array
	(
		'Very Satisfied', 
		'Somewhat Satisfied', 
		'Neither satisfied nor dissatisfied', 
		'Somewhat Dissatisfied', 
		'Very Dissatisfied', 
		'I do not know'
	);
	
	public static $q2 = array
	(
		'Very Satisfied', 
		'Somewhat Satisfied', 
		'Neither satisfied nor dissatisfied', 
		'Somewhat Dissatisfied', 
		'Very Dissatisfied', 
		'I do not know'
	);
	
	public static $q3 = array
	(
		'Very Satisfied', 
		'Somewhat Satisfied', 
		'Neither satisfied nor dissatisfied', 
		'Somewhat Dissatisfied', 
		'Very Dissatisfied', 
		'I do not know'
	);
	
	public static $q4 = array
	(
		'Very Satisfied', 
		'Somewhat Satisfied', 
		'Neither satisfied nor dissatisfied', 
		'Somewhat Dissatisfied', 
		'Very Dissatisfied', 
		'I do not know'
	);
	
	public static $q5 = array
	(
		'Yes', 
		'No'
	);
	
	public static $q5_2 = array
	(
		'Very Satisfied', 
		'Somewhat Dissatisfied', 
		'Very Dissatisfied'
	);
	
	public static $q7 = array
	(
		'aaa', 
		'bbb', 
		'ccc', 
		'ddd', 
		'eee', 
	);
	
	public static $tbAdmin = 'call_admin';//管理员表
	public static $tbUser = 'call_user';//会员表
	public static $tbCustomer = 'call_customer';//顾客表
	public static $tbSurvey = 'call_survey';//调研表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//线上数据库配置信息
	private static $dbOnline = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
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
		'dbName' => 'carlcare_survey',//数据库名
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
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$dirLog . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$dirLog . 'time_' . Utils::mdate('Y-m-d') . '.php';
		self::$db = new Database(self::$dbConfig);
	}
}
?>
