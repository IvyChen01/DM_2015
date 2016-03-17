<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 3;//配置方案。1：local，2：itel，3：fr
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'itel_preorder';//系统名称
	public static $key = 'f.12,s3fa,.itel_preorder{,c.as}d9';//密钥
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
	public static $resUrl = 'http://www.itel-mobile.com';//资源文件地址
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	public static $countCode = '';//统计代码
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'itel_admin';//管理员表
	public static $tbUser = 'itel_user';//会员表
	public static $tbNews = 'itel_news';//新闻表
	
	public static $tbZpJiangChi = 'itel_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'itel_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'itel_zp_daily';//转盘每日抽奖表
	
	public static $tbHbJiangChi = 'itel_hb_jiang_chi';//红包奖池表
	public static $tbHbZhongJiang = 'itel_hb_zhong_jiang';//红包中奖表
	public static $tbHbDaily = 'itel_hb_daily';//红包每日记录表
	
	public static $tbOrder = 'itel_order';//手机预订表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'itel_preorder',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//itel数据库配置信息
	private static $dbItel = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB68transsion',//密码
		'dbName' => 'itel_preorder',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//fr数据库配置信息
	private static $dbFr = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB68transsion',//密码
		'dbName' => 'itel_preorder_fr',//数据库名
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
		'verifyError' => array('code' => 101004, 'msg' => 'Verify code error!'),
		'srcPwEmpty' => array('code' => 101005, 'msg' => '原密码和新密码不能为空！'),
		'srcPwErorr' => array('code' => 101006, 'msg' => '原密码错误！'),
		'userExist' => array('code' => 101007, 'msg' => '该用户名已经存在！'),
		'emailFormatError' => array('code' => 101008, 'msg' => 'Please enter the correct email!'),
		
		//手机预订
		'nameEmpty' => array('code' => 102003, 'msg' => 'Name can not be empty!')
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
				self::$systemName = 'itel_preorder';
				self::$key = 'f.12,s3fa,.itel_preorder{,c.as}d9';
				self::$baseUrl = 'http://172.17.2.73/svn/itel_preorder';
				self::$dbConfig = self::$dbLocal;
				self::$countCode = '';
				break;
			case 2:
				//itel
				self::$systemName = 'itel_preorder_en';
				self::$key = 'asdf.as}d9asdfitel1.';
				self::$baseUrl = 'http://www.itel-mobile.com/it1505';
				self::$dbConfig = self::$dbItel;
				self::$countCode = '';
				break;
			case 3:
				//fr
				self::$systemName = 'itel_preorder_fr';
				self::$key = 'frfitadel1.{asdf.fj1jas';
				self::$baseUrl = 'http://www.itel-mobile.com/vision';
				self::$dbConfig = self::$dbFr;
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42219295-2', 'auto');
  ga('send', 'pageview');

</script>";
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
	}
}
?>
