<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 2;//配置方案。1：local，2：shenzhen
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = true;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'transsion2016';//系统名称
	public static $key = '12.transsion2016<ffd.<>f';//密钥
	public static $backupDir = 'data/backup/';//数据库备份目录
	public static $recoverDir = 'data/recover/';//数据库恢复目录
	public static $logDir = 'data/log/';//日志目录
	public static $uploadsDir = 'data/uploads/';//上传目录
	public static $cacheDir = 'data/cache/';//缓存主目录
	public static $newsCacheDir = 'data/cache/news/';//新闻缓存目录
	public static $templatesDir = 'templates';//模板目录
	public static $viewDir = 'data/cache/templates/';//视图目录，缓存模板
	public static $templatesMd5 = 'data/cache/templates_md5.php';//模板md5文件，用来检测模板是否有修改
	public static $installLock = 'data/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if (!defined(\'VIEW\')) exit; ?>';//VIEW入口检测代码
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = 'http://img.qumuwu.com/transsion';//资源文件地址
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	public static $countCode = '';//统计代码
	
	public static $deviceType = '';//设备类型，pc，mobile
	public static $maxPrize = 13;//最大奖品数
	public static $prizeName = array(
		'TECNO C8',
		'TECNO Phantom 5',
		'TECNO pad 7C',
		'TECNO pad 8H',
		'itel it1505',
		'Infinix X511',
		'Infinix X405',
		'Syinix原汁机',
		'Oraimo充电宝',
		'iflux应急灯',
		'现金红包 8元',
		'现金红包 18元',
		'现金红包 28元'
	);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'transsion2016_admin';//管理员表
	public static $tbUser = 'transsion2016_user';//会员表
	public static $tbNews = 'transsion2016_news';//新闻表
	
	public static $tbZpJiangChi = 'transsion2016_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'transsion2016_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'transsion2016_zp_daily';//转盘每日抽奖表
	
	public static $tbHbJiangChi = 'transsion2016_hb_jiang_chi';//红包奖池表
	public static $tbHbZhongJiang = 'transsion2016_hb_zhong_jiang';//红包中奖表
	public static $tbHbDaily = 'transsion2016_hb_daily';//红包每日记录表
	
	public static $tbJobnum = 'transsion2016_jobnum';//工号表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'transsion2016',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//transsion数据库配置信息
	private static $dbTranssion = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => 'd17b39b0c9',//密码
		'dbName' => 'transsion2016',//数据库名
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
		
		//转盘抽奖
		'jobnumError' => array('code' => 103001, 'msg' => '工号或姓名输入错误！'),
		'binded' => array('code' => 103002, 'msg' => '该工号已登录！'),
		'expired' => array('code' => 103003, 'msg' => '会话已过期，请重新登录！'),
		'played' => array('code' => 103004, 'msg' => '今天的抽奖次数已用完，请明天再来！'),
		'lockTime' => array('code' => 103005, 'msg' => '抽奖每天下午5点开始哦！')
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		@session_start();
		if (self::$isLocal)
		{
			@error_reporting(E_ALL);
			self::$configType = 1;
			self::$countCode = '';
		}
		else
		{
			@error_reporting(0);
		}
		
		switch (self::$configType)
		{
			case 1:
				//localhost
				@date_default_timezone_set('Etc/GMT-8');//北京时间
				self::$baseUrl = 'http://localhost:8012';
				self::$dbConfig = self::$dbLocal;
				self::$resUrl = '.';
				break;
			case 2:
				//transsion
				@date_default_timezone_set('Etc/GMT-8');//北京时间
				self::$baseUrl = 'http://transsion.qumuwu.com';
				self::$dbConfig = self::$dbTranssion;
				self::$resUrl = 'http://img.qumuwu.com/transsion';
				break;
			default:
		}
		
		//记录执行程序的当前时间，配置log文件位置
		Debug::$srcTime = microtime(true);
		Debug::$logFile = self::$logDir . Utils::mdate('Y-m-d') . '.php';
		Debug::$timeFile = self::$logDir . 'time_' . Utils::mdate('Y-m-d') . '.php';
		Debug::$maxTime = 0.01;
		self::$db = new Database(self::$dbConfig);
		
		//限制视图文件须由控制器调用才可执行
		define('VIEW', true);
		define('TOKEN', 'fsie473jfHJhduJKee51');
	}
}
?>
