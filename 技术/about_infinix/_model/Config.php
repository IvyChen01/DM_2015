<?php
/**
 * 配置信息
 * @author Shines
 */
class Config
{
	public static $configType = 2;//配置方案。1：local，2：肯尼亚
	public static $isLocal = false;//是否为本地模式
	public static $deviceType = '';//设备类型，pc，mobile
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
	public static $ipUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=';//IP地址库
	
	public static $db = null;//数据库
	public static $tbAdmin = 'aboutinfinix_admin';//管理员表
	public static $tbUser = 'aboutinfinix_user';//用户表
	public static $tbAnswer = 'aboutinfinix_answer';//答题表
	public static $tbZpJiangChi = 'aboutinfinix_zp_jiang_chi';//转盘奖池表
	public static $tbZpZhongJiang = 'aboutinfinix_zp_zhong_jiang';//转盘中奖表
	public static $tbZpDaily = 'aboutinfinix_zp_daily';//转盘每日抽奖表
	
	//各国家单独配置参数
	public static $systemName = '';//系统名称
	public static $key = '';//密钥
	public static $baseUrl = '';//当前网址，线上或本地
	public static $resUrl = '';//资源文件地址
	public static $newsEnabled = false;//新闻开关
	public static $zhuanPanEnabled = false;//转盘开关
	public static $hongBaoEnabled = false;//红包开关
	public static $dailyPagesize = 0;
	public static $rankPagesize = 0;//排行榜每页显示排名个数
	public static $inviteScore = 0;//邀请好友获得金币数
	public static $maxDailyScore = 0;
	public static $minDailyScore = 0;
	public static $adminUserPagesize = 0;
	public static $chanceScore = 0;
	public static $winnerPagesize = 0;
	public static $maxPrize = 0;//最大奖品数
	public static $prizeName = null;//奖品名称
	public static $prizeMoney = null;//奖品名称
	public static $adminNewsPagesize = 0;//新闻管理每页显示新闻条数
	public static $newsPagesize = 0;//前端每页显示新闻条数
	public static $maxContent = 0;//最大新闻长度
	public static $wxAppId = '';//微信app id
	public static $wxAppSecret = '';//微信app secret
	public static $isFb = false;//是否调用facebook接口
	public static $fbAppId = '';//facebook app id
	public static $fbAppKey = '';//facebook app key
	public static $fbAppRedirectUrl = '';//facebook app跳转地址
	public static $fbAppUrl = '';//facebook app地址
	public static $siteUrl = '';
	public static $shareUrl = '';
	public static $sharePic = '';
	public static $dbConfig = null;//数据库配置信息，线上或本地
	public static $countCode = '';//统计代码
	public static $msg = null;//操作提示
	
	//本地数据库配置信息
	private static $dbLocal = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'dbName' => 'aboutinfinix',//数据库名
		'dbDriver' => 'mysql',//数据库驱动
		'dbCharset' => 'utf8',//数据库字符集
		'dbCollat' => 'utf8_general_ci',//排序规则
		'dbPconnect' => false//是否永久连接
	);
	
	//肯尼亚数据库配置信息
	private static $dbKe = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'DB69transsion',//密码
		'dbName' => 'aboutinfinix',//数据库名
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
				self::$systemName = 'aboutinfinix';//系统名称
				self::$key = 'f1f2f~asd.aboutinfinixx.d1ab';//密钥
				self::$baseUrl = 'http://localhost:8006';//当前网址，线上或本地
				self::$resUrl = '';//资源文件地址
				self::$newsEnabled = false;//新闻开关
				self::$zhuanPanEnabled = false;//转盘开关
				self::$hongBaoEnabled = false;//红包开关
				self::$dailyPagesize = 5;
				self::$rankPagesize = 5;//排行榜每页显示排名个数
				self::$inviteScore = 20000;//邀请好友获得金币数
				self::$maxDailyScore = 900000;
				self::$minDailyScore = 15000;
				self::$adminUserPagesize = 50;
				self::$chanceScore = 100000;
				self::$winnerPagesize = 5;
				self::$maxPrize = 10;//最大奖品数
				self::$prizeName = array('', '', '', '', '', '', '', '', '', '');//奖品名称
				self::$prizeMoney = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//奖品名称
				self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
				self::$newsPagesize = 100;//前端每页显示新闻条数
				self::$maxContent = 10000;//最大新闻长度
				self::$wxAppId = '';//微信app id
				self::$wxAppSecret = '';//微信app secret
				self::$isFb = false;//是否调用facebook接口
				self::$fbAppId = '';//facebook app id
				self::$fbAppKey = '';//facebook app key
				self::$fbAppRedirectUrl = 'https://localhost:8006/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/aboutinfinix/';//facebook app地址
				self::$siteUrl = 'http://localhost:8006/?a=main';
				self::$shareUrl = 'http://localhost:8006/?shareId=';
				self::$sharePic = 'http://localhost:8006/images/share.jpg';
				self::$dbConfig = self::$dbLocal;//数据库配置信息，线上或本地
				self::$countCode = '';//统计代码
				self::$msg = array
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
					
					//Infinix知多少
					'played' => array('code' => 105001, 'msg' => 'Played Today!'),
					'inputError' => array('code' => 105002, 'msg' => 'Input Error!')
				);//操作提示
				break;
			case 2:
				//肯尼亚
				@date_default_timezone_set('Etc/GMT-3');
				self::$systemName = 'aboutinfinix';//系统名称
				self::$key = '123f1a.aboutinfinix.d.,b123';//密钥
				self::$baseUrl = 'http://www.infinixmobility.com/aboutinfinix';//当前网址，线上或本地
				self::$resUrl = '';//资源文件地址
				self::$newsEnabled = false;//新闻开关
				self::$zhuanPanEnabled = false;//转盘开关
				self::$hongBaoEnabled = false;//红包开关
				self::$dailyPagesize = 5;
				self::$rankPagesize = 5;//排行榜每页显示排名个数
				self::$inviteScore = 20000;//邀请好友获得金币数
				self::$maxDailyScore = 900000;
				self::$minDailyScore = 15000;
				self::$adminUserPagesize = 50;
				self::$chanceScore = 100000;
				self::$winnerPagesize = 5;
				self::$maxPrize = 10;//最大奖品数
				self::$prizeName = array('', '', '', '', '', '', '', '', '', '');//奖品名称
				self::$prizeMoney = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//奖品名称
				self::$adminNewsPagesize = 100;//新闻管理每页显示新闻条数
				self::$newsPagesize = 100;//前端每页显示新闻条数
				self::$maxContent = 10000;//最大新闻长度
				self::$wxAppId = '';//微信app id
				self::$wxAppSecret = '';//微信app secret
				self::$isFb = true;//是否调用facebook接口
				self::$fbAppId = '1704535959759872';//facebook app id
				self::$fbAppKey = '8e6ff8cd598cd663319825e2bd7f167d';//facebook app key
				self::$fbAppRedirectUrl = 'https://www.infinixmobility.com/aboutinfinix/';//facebook app跳转地址
				self::$fbAppUrl = 'https://apps.facebook.com/aboutinfinix/';//facebook app地址
				self::$siteUrl = 'http://www.infinixmobility.com/aboutinfinix/?a=main';
				self::$shareUrl = 'http://www.infinixmobility.com/aboutinfinix/?shareId=';
				self::$sharePic = 'http://www.infinixmobility.com/aboutinfinix/images/share.jpg';
				self::$dbConfig = self::$dbKe;//数据库配置信息，线上或本地
				self::$countCode = '';//统计代码
				self::$msg = array
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
					
					//Infinix知多少
					'played' => array('code' => 105001, 'msg' => 'Played Today!'),
					'inputError' => array('code' => 105002, 'msg' => 'Input Error!')
				);//操作提示
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
