<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 3;//配置方案。1：local，2：bj，3：印尼
	public static $isFb = false;//是否调用facebook接口
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'idnote2';//系统名称
	public static $key = 'f1d..luckygamep.ky1';//密钥
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
	public static $resUrl = '';//资源文件地址
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	public static $countCode = '';//统计代码
	public static $deviceType = '';//设备类型，pc，mobile
	public static $dailyPagesize = 5;
	public static $rankPagesize = 5;//排行榜每页显示排名个数
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('Infinix Note 2', 'Power Bank', 'Voucher Pulsa', '', '', '', '', '', '', '');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'idnote2_admin';//管理员表
	public static $tbUser = 'idnote2_user';//用户表
	public static $tbZpJiangChi = 'idnote2_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'idnote2_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'idnote2_zp_daily';//转盘每日抽奖表
	
	public static $db = null;//数据库
	public static $dbConfig = null;//数据库配置信息，线上或本地
	
	public static $fbAppId = '';//facebook app id
	public static $fbAppKey = '';//facebook app key
	public static $fbAppRedirectUrl = '';//facebook app跳转地址
	public static $fbAppUrl = '';//facebook app地址
	public static $siteUrl = '';
	public static $shareUrl = '';
	public static $sharePic = '';
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'idnote2',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//bj数据库配置信息
	private static $dbBj = array
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
	
	//印尼数据库配置信息
	private static $dbId = array
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
		'RequestError' => array('code' => 104005, 'msg' => 'Request Error!'),
		
		//idnote2
		'played' => array('code' => 105001, 'msg' => 'Played Today!')
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
				@date_default_timezone_set('Etc/GMT-8');//北京时间
				self::$isFb = false;
				self::$systemName = 'idnote2';//系统名称
				self::$key = 'f121~a.phanidl12.,uckyadf.ff9';//密钥
				self::$baseUrl = 'http://localhost:8019';
				self::$dbConfig = self::$dbLocal;
				self::$fbAppId = '';//facebook app id
				self::$fbAppKey = '';//facebook app key
				self::$fbAppRedirectUrl = '';//facebook app跳转地址
				self::$fbAppUrl = '';//facebook app地址
				self::$siteUrl = 'http://localhost:8019/?a=lucky';
				self::$shareUrl = 'http://localhost:8019/?shareId=';
				self::$sharePic = 'http://localhost:8019/images/share.jpg';
				self::$countCode = '';
				break;
			case 2:
				//bj
				@date_default_timezone_set('PRC');
				self::$isFb = false;
				self::$systemName = 'idnote2';//系统名称
				self::$key = 'f1~a.idnote2gameu<>{,aadf.df.9';//密钥
				self::$baseUrl = 'http://203.88.173.126/idnote2';
				self::$dbConfig = self::$dbBj;
				self::$fbAppId = '';//facebook app id
				self::$fbAppKey = '';//facebook app key
				self::$fbAppRedirectUrl = '';//facebook app跳转地址
				self::$fbAppUrl = '';//facebook app地址
				self::$siteUrl = 'http://203.88.173.126/idnote2/?a=lucky';
				self::$shareUrl = 'http://203.88.173.126/idnote2/?shareId=';
				self::$sharePic = 'http://203.88.173.126/idnote2/images/share.jpg';
				self::$countCode = '';
				break;
			case 3:
				//印尼
				@date_default_timezone_set('Etc/GMT-7');
				self::$isFb = true;
				self::$systemName = 'idnote2';//系统名称
				self::$key = 'fb..Idh_antoidnote2.m19a';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/id/note2';
				self::$dbConfig = self::$dbId;
				self::$fbAppId = '1007219276002882';//facebook app id
				self::$fbAppKey = '5a6fc94bb7d257c1173e0fa8f1e23dd7';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/id/note2/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/note2id/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/id/note2/?a=lucky';
				self::$shareUrl = 'http://www.infinixmobility.com/id/note2/?shareId=';
				self::$sharePic = 'http://www.infinixmobility.com/id/note2/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54295225-2', 'auto');
  ga('require', 'displayfeatures');
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
