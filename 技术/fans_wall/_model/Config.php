<?php
/**
 * 配置信息
 * [ok]
 */
class Config
{
	public static $configType = 4;//配置方案，1：localhost，2：egypt，3：kenya，4：Indonesia
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'fanswall';//系统名称
	public static $key = 'ff}78f9fans_dfwall,.';//密钥
	public static $dirBackup = 'extends/db_backup/';//数据库备份目录
	public static $dirRecover = 'extends/db_recover/';//数据库恢复目录
	public static $dirLog = 'extends/log/';//日志目录
	public static $dirUploads = 'extends/uploads/';//上传目录
	public static $dirCache = 'extends/cache/';//缓存主目录
	public static $dirCacheNews = 'extends/cache/news/';//新闻缓存目录
	public static $installLock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if(!defined(\'VIEW\')) exit(0); ?>';//VIEW入口检测代码
	public static $countCode = '';//统计代码
	
	public static $monthEn = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'fans_wall_admin';//管理员表
	public static $tbFans = 'fans_wall_fans';//粉丝表
	public static $tbIpLike = 'fans_wall_ip_like';//点赞表
	public static $tbIpShare = 'fans_wall_ip_share';//分享表
	
	public static $baseUrl = '';//当前网址，线上或本地
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'fanswall',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//egypt数据库配置信息
	private static $dbEgypt = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'fanswall',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//kenya数据库配置信息
	private static $dbKenya = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'fanswallKe',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//Indonesia数据库配置信息
	private static $dbIndonesia = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'fanswallId',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//操作提示
	public static $msg = array
	(
		//通用
		'ok' => array('code' => 0, 'msg' => 'ok'),
		'sysError' => array('code' => 1, 'msg' => '系统错误！'),
		'appError' => array('code' => 2, 'msg' => '业务处理错误！'),
		
		//用户
		'noLogin' => array('code' => 101001, 'msg' => '未登录'),
		'usernamePwEmpty' => array('code' => 101002, 'msg' => '用户名和密码不能为空！'),
		'usernamePwError' => array('code' => 101003, 'msg' => '用户名或密码错误！'),
		'verifyError' => array('code' => 101004, 'msg' => '验证码错误！'),
		'srcPwEmpty' => array('code' => 101005, 'msg' => '原密码和新密码不能为空！'),
		'srcPwErorr' => array('code' => 101006, 'msg' => '原密码错误！'),
		'userExist' => array('code' => 101007, 'msg' => '该用户名已经存在！'),
		'emailFormatError' => array('code' => 101008, 'msg' => 'Email格式不正确！'),
		
		//粉丝墙
		'liked' => array('code' => 102001, 'msg' => 'Liked today!'),
		'shared' => array('code' => 102002, 'msg' => 'Shared today!')
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
				self::$baseUrl = 'http://localhost';
				self::$dbConfig = self::$dbLocal;
				break;
			case 2:
				//egypt
				self::$systemName = 'fanswall';//系统名称
				self::$key = 'ff}78f9fans_dfwall,.';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/fb/fanswall';
				self::$dbConfig = self::$dbEgypt;
				break;
			case 3:
				//kenya
				self::$systemName = 'fanswallke';//系统名称
				self::$key = 'asdfkeff}7fal....l,.';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/fb/fanswallke';
				self::$dbConfig = self::$dbKenya;
				break;
			case 4:
				//Indonesia
				self::$systemName = 'fanswallid';//系统名称
				self::$key = 'idf7f_wa .l,,.132';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/fb/fanswallid';
				self::$dbConfig = self::$dbIndonesia;
				break;
			default:
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$dirLog . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$dirLog . 'time_' . Utils::mdate('Y-m-d') . '.php';
		Debug::$maxTime = 0.01;
		self::$db = new Database(self::$dbConfig);
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
	}
}
?>
