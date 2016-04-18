<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 3;//配置方案。1：local，2：infinix，3：ke
	public static $isFb = false;//是否调用facebook接口
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $isLocal = false;//是否为本地模式
	public static $systemName = 'x600';//系统名称
	public static $key = '';//密钥
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
	public static $maxDailyScore = 90000;
	public static $adminUserPagesize = 50;
	
	public static $snow = 2;
	
	public static $maxPrize = 10;//最大奖品数
	public static $prizeName = array('Infinix NOTE2', 'Power bank', 'Recharge card', '', '', '', '', '', '', '');//奖品名称
	public static $prizeMoney = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	
	public static $adminNewsPagesize = 100;//新闻管理每页显示新闻条数
	public static $newsPagesize = 100;//前端每页显示新闻条数
	public static $maxContent = 10000;//最大新闻长度
	
	public static $tbAdmin = 'x600_admin';//管理员表
	public static $tbUser = 'x600_user';//用户表
	public static $tbZpJiangChi = 'x600_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'x600_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'x600_zp_daily';//转盘每日抽奖表
	
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
	
	//x600数据库配置信息
	private static $dbX600 = array
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
	
	//note2ke数据库配置信息
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
		
		//x600抽奖
		'played' => array('code' => 105001, 'msg' => 'Played Today!')
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
				self::$isFb = false;
				self::$systemName = 'x600';//系统名称
				self::$key = '111f..x60uckx60asky.9a,';//密钥
				self::$baseUrl = 'http://localhost:8018';
				self::$dbConfig = self::$dbLocal;
				self::$fbAppId = '';//facebook app id
				self::$fbAppKey = '';//facebook app key
				self::$fbAppRedirectUrl = 'https://localhost:8018/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/x600/';//facebook app地址
				self::$siteUrl = 'http://localhost:8018/?a=lucky';
				self::$shareUrl = 'http://localhost:8018/';
				self::$sharePic = 'http://localhost:8018/images/share.jpg';
				self::$countCode = '';
				break;
			case 2:
				//x600
				self::$isFb = true;
				self::$systemName = 'x600';//系统名称
				self::$key = '111f..x60uckx60asky.9a,';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/note2ng';
				self::$dbConfig = self::$dbX600;
				self::$fbAppId = '1521216878199419';//facebook app id
				self::$fbAppKey = 'a5700e76c85be427d914806c172e2f06';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/note2ng/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/note2ng/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/note2ng/?a=lucky';
				self::$shareUrl = 'http://www.infinixmobility.com/note2ng/';
				self::$sharePic = 'http://www.infinixmobility.com/note2ng/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-69866453-1', 'auto');
  ga('send', 'pageview');

</script>";
				break;
			case 3:
				//note2ke
				self::$isFb = true;
				self::$systemName = 'note2ke';//系统名称
				self::$key = '111note2keu.1ckx62.ky.9a,';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/note2ke';
				self::$dbConfig = self::$dbKe;
				self::$fbAppId = '497339457105587';//facebook app id
				self::$fbAppKey = 'a3ae46aeb52e3651cade576e8ba8fc7a';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/note2ke/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/note2ke/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/note2ke/?a=lucky';
				self::$shareUrl = 'http://www.infinixmobility.com/note2ke/';
				self::$sharePic = 'http://www.infinixmobility.com/note2ke/images/share.jpg';
				self::$countCode = "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54295225-3', 'auto');
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
