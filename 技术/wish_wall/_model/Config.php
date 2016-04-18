<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 8;//配置方案。1：local，2：wishwalleg，3：wishwallke，4：wishwalluae，5：wishwallksa，6：HK，7：EG Christmas，8：摩洛哥
	public static $debugAddWish = false;//调试许愿功能
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'wishwall';//系统名称
	public static $key = '';//密钥
	public static $backupDir = 'data/backup/';//数据库备份目录
	public static $recoverDir = 'data/recover/';//数据库恢复目录
	public static $logDir = 'data/log/';//日志目录
	public static $uploadsDir = 'data/uploads/';//上传目录
	public static $cacheDir = 'data/cache/';//缓存主目录
	public static $newsCacheDir = 'data/cache/news/';//新闻缓存目录
	public static $templatesDir = 'data/templates/';//模板文件目录
	public static $installLock = 'data/lock/install.php';//数据库安装锁定文件
	public static $viewCheck = '<?php if (!defined(\'VIEW\')) exit; ?>';//VIEW入口检测代码
	public static $imgUrl = '';//图片链接目录
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	public static $countCode = '';//访问统计代码
	public static $deviceType = '';//设备类型，pc，mobile
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('奖品1', '奖品2', '奖品3', '奖品4', '奖品5', '奖品6', '奖品7', '奖品8', '奖品9', '奖品10');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $fbAppId = '781895381920220';//facebook app id
	public static $fbAppKey = '50e734cb76e475b04b751f8cc81ae4d7';//facebook app key
	public static $fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwall/';//facebook app跳转地址
	public static $fbAppUrl = 'https://apps.facebook.com/infinixwishwall/';//facebook app地址
	public static $siteUrl = 'http://www.infinixmobility.com/wishwall/?m=wish&a=main';
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	public static $maxWish = 2000;//最大许愿内容长度
	public static $wishPagesize = 10;//每页显示愿望条数
	public static $wishAdminPagesize = 50;//管理后台每页显示愿望条数
	
	public static $tbAdmin = 'wishwall_admin';//管理员表
	public static $tbUser = 'wishwall_user';//用户表
	public static $tbWish = 'wishwall_wish';//愿望表
	
	public static $tbNews = 'wishwall_news';//新闻表
	
	public static $tbZpJiangChi = 'wishwall_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'wishwall_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'wishwall_zp_daily';//转盘每日抽奖表
	
	public static $tbHbJiangChi = 'wishwall_hb_jiang_chi';//红包奖池表
	public static $tbHbZhongJiang = 'wishwall_hb_zhong_jiang';//红包中奖表
	public static $tbHbDaily = 'wishwall_hb_daily';//红包每日记录表
	
	public static $baseUrl = '';//当前网址，线上或本地
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//HK数据库配置信息
	private static $dbHk = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//wishwalleg数据库配置信息
	private static $dbWishwall = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//wishwallke数据库配置信息
	private static $dbWishwallke = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//wishwalluae数据库配置信息
	private static $dbWishwalluae = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//wishwallksa数据库配置信息
	private static $dbWishwallksa = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//wishwallksa数据库配置信息
	private static $dbNewYearEg = array
	(
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => ',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//摩洛哥数据库配置信息
	private static $dbMa = array
	(
		'hostname' => '',//数据库主机
		'username' => ',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
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
		'noLogin' => array('code' => 101001, 'msg' => 'Not logged in!'),
		'usernamePwEmpty' => array('code' => 101002, 'msg' => '用户名和密码不能为空！'),
		'usernamePwError' => array('code' => 101003, 'msg' => '用户名或密码错误！'),
		'verifyError' => array('code' => 101004, 'msg' => '验证码错误！'),
		'srcPwEmpty' => array('code' => 101005, 'msg' => '原密码和新密码不能为空！'),
		'srcPwErorr' => array('code' => 101006, 'msg' => '原密码错误！'),
		'userExist' => array('code' => 101007, 'msg' => '该用户名已经存在！'),
		'emailFormatError' => array('code' => 101008, 'msg' => 'Email格式不正确！'),
		
		//新闻
		'contentLong' => array('code' => 102001, 'msg' => '内容过长！'),
		
		//转盘抽奖
		'licked' => array('code' => 103001, 'msg' => '已经点击过了！'),
		'deptUsernameEmpty' => array('code' => 103002, 'msg' => '部门和姓名不能为空！'),
		'submitRepeat' => array('code' => 103003, 'msg' => '请勿重复提交！'),
		
		//抢红包
		'jobnumUsernameEmpty' => array('code' => 104001, 'msg' => '工号和姓名不能为空！'),
		'jobnumUsernameError' => array('code' => 104002, 'msg' => '工号或姓名不正确！'),
		'jobnumBinded' => array('code' => 104003, 'msg' => '该工号已被绑定过了！'),
		'wxNumBinded' => array('code' => 104004, 'msg' => '该微信号已经绑定过工号了！'),
		'RequestError' => array('code' => 104005, 'msg' => '非法请求！'),
		
		//许愿墙
		'contentEmpty' => array('code' => 105001, 'msg' => 'Content can not be empty!'),
		'oneChance' => array('code' => 105002, 'msg' => 'Only one chance everyone!')
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
		}
		else
		{
			@error_reporting(0);
		}
		
		switch (self::$configType)
		{
			case 1:
				//localhost
				@date_default_timezone_set('Etc/GMT-8');
				self::$baseUrl = 'http://172.16.6.73:8000/wish_wall';
				self::$dbConfig = self::$dbLocal;
				
				//self::$baseUrl = 'http://203.88.173.126/wishwall';
				//self::$dbConfig = self::$dbHk;
				break;
			case 2:
				//wishwalleg
				@date_default_timezone_set('Etc/GMT-2');
				self::$systemName = 'wishwall';//系统名称
				self::$key = '1faafa,.wishwall>{dfl2kj322';//密钥
				self::$fbAppId = '781895381920220';//facebook app id
				self::$fbAppKey = '50e734cb76e475b04b751f8cc81ae4d7';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwall/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/infinixwishwall/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/wishwall/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/wishwall';
				self::$dbConfig = self::$dbWishwall;
				break;
			case 3:
				//wishwallke
				@date_default_timezone_set('Etc/GMT-3');
				self::$systemName = 'wishwallke';//系统名称
				self::$key = '1fa.afa,.wishwallke>{dfllfpw22';//密钥
				self::$fbAppId = '1017045908334921';//facebook app id
				self::$fbAppKey = 'f94d0903ca32f4cf7b8d13de2d648f1e';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwallke/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/wishwallke/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/wishwallke/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/wishwallke';
				self::$dbConfig = self::$dbWishwallke;
				break;
			case 4:
				//wishwalluae
				@date_default_timezone_set('Etc/GMT-8');
				self::$systemName = 'wishwalluae';//系统名称
				self::$key = '1fss.aafa,.wishwalluae>{dffl.2kj322';//密钥
				self::$fbAppId = '997133030331573';//facebook app id
				self::$fbAppKey = '92b03c794ced71d6b1ef52774c2cf366';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwalluae/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/wishwalluae/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/wishwalluae/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/wishwalluae';
				self::$dbConfig = self::$dbWishwalluae;
				break;
			case 5:
				//wishwallksa
				@date_default_timezone_set('Etc/GMT-8');
				self::$systemName = 'wishwallksa';//系统名称
				self::$key = '1fa,.wishwallksa>{dfl2kj>,,322';//密钥
				self::$fbAppId = '1659714494304175';//facebook app id
				self::$fbAppKey = '00cf6191ea147814e6725989a4bf1e9f';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwallksa/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/wishwallksa/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/wishwallksa/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/wishwallksa';
				self::$dbConfig = self::$dbWishwallksa;
				break;
			case 6:
				//hk
				@date_default_timezone_set('Etc/GMT-8');
				self::$baseUrl = 'http://203.88.173.126/wishwall';
				self::$dbConfig = self::$dbHk;
				break;
			case 7:
				//newyeareg
				@date_default_timezone_set('Etc/GMT-2');
				self::$systemName = 'newyeareg';//系统名称
				self::$key = '1fa2.a.newyeareg123isw22';//密钥
				self::$fbAppId = '165990923757596';//facebook app id
				self::$fbAppKey = 'da6a93492aa1d6426aaaf5661dd9b616';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/newyeareg/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/newyeareg/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/newyeareg/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/newyeareg';
				self::$dbConfig = self::$dbNewYearEg;
				break;
			case 8:
				//wishwallma
				@date_default_timezone_set('Etc/GMT-0');
				self::$systemName = 'wishwallma';//系统名称
				self::$key = '1f2.a,wishwallmafllfpwasd.12a2';//密钥
				self::$fbAppId = '541040952739480';//facebook app id
				self::$fbAppKey = '0a3662a02f5a9a0675d78796f6572341';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/wishwallma/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/wishwallma/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/wishwallma/?m=wish&a=main';
				self::$baseUrl = 'http://www.infinixmobility.com/wishwallma';
				self::$dbConfig = self::$dbMa;
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
