<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 7;//配置方案。1：local，2：埃及，3：bj，4：南苏丹，5：肯尼亚，6：加纳，7：沙特
	public static $isFb = false;//是否调用facebook接口
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'phantom5game';//系统名称
	public static $key = 'f1~a.phantom5gameu<>{,aadf.df.9';//密钥
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
	public static $inviteScore = 20000;//邀请好友获得金币数
	public static $maxDailyScore = 900000;
	public static $minDailyScore = 15000;
	public static $adminUserPagesize = 50;
	public static $chanceScore = 100000;
	public static $winnerPagesize = 5;
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('TECNO Phantom 5', 'Power Bank', 'Selfie Stick', '10% off Coupon for TECNO Smartphone', '5% off Coupon for TECNO Smartphone', 'TECNO Cup', 'TECNO Golf Umbrella', 'TECNO T-shirt', 'TECNO Fashion Bag', 'Wall Clock');//奖品名称
	public static $prizeMoney = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'phantom5game_admin';//管理员表
	public static $tbUser = 'phantom5game_user';//用户表
	public static $tbDaily = 'phantom5game_daily';//得分记录表
	public static $tbFriend = 'phantom5game_friend';//好友表
	public static $tbZpJiangChi = 'phantom5game_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'phantom5game_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'phantom5game_zp_daily';//转盘每日抽奖表
	
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
		'hostname' => '',//数据库主机
		'username' => '',//用户名
		'password' => '',//密码
		'dbName' => '',//数据库名
		'dbDriver' => '',//数据库驱动
		'dbCharset' => '',//数据库字符集
		'dbCollat' => '',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//埃及数据库配置信息
	private static $dbPhantom5game = array
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
	
	//南苏丹数据库配置信息
	private static $dbSsd = array
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
	
	//肯尼亚数据库配置信息
	private static $dbKe = array
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
	
	//肯尼亚数据库配置信息
	private static $dbGh = array
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
	
	//沙特数据库配置信息
	private static $dbSa = array
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
		
		//phantom5游戏
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
				self::$systemName = 'phantom5game';//系统名称
				self::$key = 'f1~a.phantom5gameu<>{,aadf.df.9';//密钥
				self::$baseUrl = 'http://localhost:8015';
				self::$dbConfig = self::$dbLocal;
				self::$fbAppId = '187242224949263';//facebook app id
				self::$fbAppKey = '9318bcf7af446def0a37effdf8dd1078';//facebook app key
				self::$fbAppRedirectUrl = 'https://localhost:8015/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5game/';//facebook app地址
				self::$siteUrl = 'http://localhost:8015/?m=game&a=introduction';
				self::$shareUrl = 'http://localhost:8015/?m=game&shareId=';
				self::$sharePic = 'http://localhost:8015/images/share.jpg';
				self::$countCode = '';
				break;
			case 2:
				//埃及
				@date_default_timezone_set('PRC');
				self::$isFb = true;
				self::$systemName = 'phantom5game';//系统名称
				self::$key = 'f1~a.phantom5gameu<>{,aadf.df.9';//密钥
				self::$baseUrl = 'http://www.tecno-mobile.com/phantom5';
				self::$dbConfig = self::$dbPhantom5game;
				self::$fbAppId = '187242224949263';//facebook app id
				self::$fbAppKey = '9318bcf7af446def0a37effdf8dd1078';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.tecno-mobile.com/phantom5game/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5game/';//facebook app地址
				self::$siteUrl = 'http://www.tecno-mobile.com/phantom5game/?m=game&a=introduction';
				self::$shareUrl = 'http://www.tecno-mobile.com/phantom5game/?m=game&shareId=';
				self::$sharePic = 'http://www.tecno-mobile.com/phantom5game/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59533821-5', 'auto');
  ga('send', 'pageview');

</script>";
				break;
			case 3:
				//bj
				@date_default_timezone_set('PRC');
				self::$isFb = false;
				self::$systemName = 'phantom5game';//系统名称
				self::$key = 'f1~a.phantom5gameu<>{,aadf.df.9';//密钥
				self::$baseUrl = 'http://203.88.173.126/phantom5';
				self::$dbConfig = self::$dbBj;
				self::$fbAppId = '187242224949263';//facebook app id
				self::$fbAppKey = '9318bcf7af446def0a37effdf8dd1078';//facebook app key
				self::$fbAppRedirectUrl = 'https://203.88.173.126/phantom5/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5game/';//facebook app地址
				self::$siteUrl = 'http://203.88.173.126/phantom5/?m=game&a=introduction';
				self::$shareUrl = 'http://203.88.173.126/phantom5/?m=game&shareId=';
				self::$sharePic = 'http://203.88.173.126/phantom5/images/share.jpg';
				self::$countCode = '';
				break;
			case 4:
				//南苏丹
				@date_default_timezone_set('PRC');
				self::$isFb = true;
				self::$systemName = 'phantom5ssd';//系统名称
				self::$key = 'fssdu<>{,a1a.1.,.ffphantom5ss9';//密钥
				self::$baseUrl = 'http://www.tecno-mobile.com/phantom5ssd';
				self::$dbConfig = self::$dbSsd;
				self::$fbAppId = '1102251439786519';//facebook app id
				self::$fbAppKey = 'ce0cdac4a394de0b7efeac1facdd1bbe';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.tecno-mobile.com/phantom5ssd/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5ssd/';//facebook app地址
				self::$siteUrl = 'http://www.tecno-mobile.com/phantom5ssd/?m=game&a=introduction';
				self::$shareUrl = 'http://www.tecno-mobile.com/phantom5ssd/?m=game&shareId=';
				self::$sharePic = 'http://www.tecno-mobile.com/phantom5ssd/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59533821-7', 'auto');
  ga('send', 'pageview');

</script>";
				break;
			case 5:
				//肯尼亚
				@date_default_timezone_set('Etc/GMT-3');
				self::$isFb = true;
				self::$systemName = 'phantom5ke';//系统名称
				self::$key = 'fsphantom5ke..phantfss1ss9';//密钥
				self::$baseUrl = 'http://www.tecno-mobile.com/phantom5ke';
				self::$dbConfig = self::$dbKe;
				self::$fbAppId = '1528269727483260';//facebook app id
				self::$fbAppKey = '75a0e466f4152e176d24b703510a3f2c';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.tecno-mobile.com/phantom5ke/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5ke/';//facebook app地址
				self::$siteUrl = 'http://www.tecno-mobile.com/phantom5ke/?m=game&a=introduction';
				self::$shareUrl = 'http://www.tecno-mobile.com/phantom5ke/?m=game&shareId=';
				self::$sharePic = 'http://www.tecno-mobile.com/phantom5ke/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59533821-6', 'auto');
  ga('send', 'pageview');

</script>";
				
				// 肯尼亚
				self::$inviteScore = 0;
				self::$maxDailyScore = 49000;
				self::$minDailyScore = 5000;
				self::$chanceScore = 10000;
				break;
			case 6:
				//加纳
				@date_default_timezone_set('PRC');
				self::$isFb = true;
				self::$systemName = 'phantom5gh';//系统名称
				self::$key = '1fspghphanttfs2s1a';//密钥
				self::$baseUrl = 'http://www.tecno-mobile.com/phantom5gh';
				self::$dbConfig = self::$dbGh;
				self::$fbAppId = '1389132458061179';//facebook app id
				self::$fbAppKey = '5e319a0e79cc2b13c0d40cd2086eabc0';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.tecno-mobile.com/phantom5gh/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5gh/';//facebook app地址
				self::$siteUrl = 'http://www.tecno-mobile.com/phantom5gh/?m=game&a=introduction';
				self::$shareUrl = 'http://www.tecno-mobile.com/phantom5gh/?m=game&shareId=';
				self::$sharePic = 'http://www.tecno-mobile.com/phantom5gh/images/share.jpg';
				self::$countCode = "";
				break;
			case 7:
				//沙特
				@date_default_timezone_set('Etc/GMT-3');
				self::$isFb = true;
				self::$systemName = 'phantom5sa';//系统名称
				self::$key = '1fh!p^sa-s2.phantom5sa.<s1a';//密钥
				self::$baseUrl = 'http://www.tecno-mobile.com/phantom5sa';
				self::$dbConfig = self::$dbSa;
				self::$fbAppId = '1683493408599698';//facebook app id
				self::$fbAppKey = '8dc6ddec8fbaa5a76f9d0c83d2bcfca0';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.tecno-mobile.com/phantom5sa/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/phantom5sa/';//facebook app地址
				self::$siteUrl = 'http://www.tecno-mobile.com/phantom5sa/?m=game&a=introduction';
				self::$shareUrl = 'http://www.tecno-mobile.com/phantom5sa/?m=game&shareId=';
				self::$sharePic = 'http://www.tecno-mobile.com/phantom5sa/images/share.jpg';
				self::$countCode = "";
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
