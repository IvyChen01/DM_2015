<?php
/**
 * 配置信息
 */
class Config
{
	public static $debug_enabled = false;//调试开关
	public static $system_name = 'transsion_weixin';//系统名称
	public static $key = '13232,g[][3.ba.f,c..fa3[]23a34';//密钥
	public static $base_url = 'http://www.geyaa.com/transsion_weixin/';//当前网址，线上或本地
	public static $dir_backup = 'extends/db_backup/';//数据库备份目录
	public static $dir_recover = 'extends/db_recover/';//数据库恢复目录
	public static $dir_log = 'extends/log/';//日志目录
	public static $dir_uploads = 'extends/uploads/';//上传目录
	public static $dir_cache = 'extends/cache/';//缓存主目录
	public static $install_lock = 'extends/lock/install.php';//数据库安装锁定文件
	public static $view_check = '<?php if(!defined(\'VIEW\')) exit(\'Request Error!\'); ?>';//VIEW入口检测代码
	
	public static $max_prize = 10;//最大奖品数
	public static $prize_name = array('88元', '18元', '8元', '', '', '', '', '', '', '');//奖品名称
	public static $prize_money = array(88, 18, 8, 0, 0, 0, 0, 0, 0, 0);//奖品名称
	
	public static $wx_appid = 'wxc4c3e3d41130ff68';
	public static $wx_appsecret = '2bac8f0460f6ee411a404f565675649c';
	
	public static $tb_admin = 'transsion_weixin_admin';//管理员表
	public static $tb_user = 'transsion_weixin_user';//会员表
	public static $tb_jiang_chi = 'transsion_weixin_jiang_chi';//奖池表
	public static $tb_zhong_jiang = 'transsion_weixin_zhong_jiang';//中奖表
	public static $tb_lucky_daily = 'transsion_weixin_lucky_daily';//每日抽奖表
	
	public static $tb_hb_jiang_chi = 'transsion_weixin_hb_jiang_chi';//红包奖池表
	public static $tb_hb_zhong_jiang = 'transsion_weixin_hb_zhong_jiang';//红包中奖表
	public static $tb_hb_lucky_daily = 'transsion_weixin_hb_lucky_daily';//红包每日记录表
	public static $tb_hb_bind_user = 'transsion_weixin_hb_bind_user';//红包绑定工号表
	public static $tb_hb_base_user = 'transsion_weixin_hb_base_user';//红包工号库，绑定工号时从工号库判断工号数据是否正确
	
	public static $db_config = null;//数据库配置信息，线上或本地
	
	//线上数据库配置信息
	private static $db_online = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => '95f1be182d',//密码
		'db_name' => 'transsion_weixin',//数据库名
		'db_driver' => 'mysql',//数据库驱动
		'db_charset' => 'utf8',//数据库字符集
		'db_collat' => 'utf8_general_ci',
		'db_pconnect' => false//是否永久连接
	);
	
	//本地数据库配置信息
	private static $db_local = array
	(
		'hostname' => 'localhost',//数据库主机
		'username' => 'root',//用户名
		'password' => '',//密码
		'db_name' => 'geyaa',//数据库名 geyaa
		'db_driver' => 'mysql',//数据库驱动
		'db_charset' => 'utf8',//数据库字符集
		'db_collat' => 'utf8_general_ci',
		'db_pconnect' => false//是否永久连接
	);
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		//记录执行程序的当前时间，配置log文件位置
		//限制视图文件须由控制器调用才可执行
		Debug::$src_time = microtime(true);
		Debug::$log_file = self::$dir_log . Utils::mdate('Y-m-d') . '.php';
		define('VIEW', true);
		define('TOKEN', 'feijcljsoihr');
		
		//设置中国时区，开启session
		if (self::$debug_enabled)
		{
			@error_reporting(E_ALL);
			self::$db_config = self::$db_local;
		}
		else
		{
			@error_reporting(0);
			self::$db_config = self::$db_online;
		}
		@date_default_timezone_set('PRC');
		@session_start();
	}
}
?>
