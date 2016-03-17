<?php
/**
 * 配置信息
 */
class Config
{
	public static $debug_enabled = false;//调试开关
	public static $log_enabled = true;//日志记录开关
	
	public static $system_name = 'fb_faq';//系统名称
	public static $key = 'af...,3aff,.fou2,3tecno_faq34o34,.3a1.';//密钥
	
	public static $url = '';//当前网址，线上或本地
	public static $url_online = 'http://http://www.gsmvillage.net';//线上网址
	public static $url_local = 'http://localhost';//本地网址
	
	public static $app_id = '620392044722875';//App ID
	public static $app_key = '77f1fef696f5ebc749500d8f5169a7a3';//App Secret
	public static $app_redirect_url = 'https://http://www.gsmvillage.net/';//App跳转地址
	public static $app_url = 'http://http://www.gsmvillage.net/';//App地址
	
	public static $dir_log = 'log/';//日志目录
	public static $dir_lock = 'lock/';//锁定文件目录
	public static $dir_dbbackup = 'dbbackup/';//数据库备份目录
	public static $dir_uploads = 'uploads/';//上传目录
	
	//答题允许的值，用于安全检测
	public static $answer_config = array
	(
		'ABCD',
		'ABCD',
		'ABCD',
		'ABCD',
		'ABCD',
		'ABCD',
		'ABCD',
		'ABCDEF',
		'ABCDEF',
		'ABCDEF'
	);
	
	public static $tb_admin = 'fb_faq_admin';//管理员表
	public static $tb_user = 'fb_faq_user';//会员表
	public static $tb_answer = 'fb_faq_answer';//答题表
	public static $tb_count = 'fb_faq_count';//统计表
	
	public static $db_config = null;//数据库配置信息，线上或本地
	
	//线上数据库配置信息
	private static $db_online = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'tecno123',//密码
		'db_name' => 'fb_faq',//数据库名
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
		'db_name' => 'fb_faq',//数据库名
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
		//记录执行程序的当前时间
		//限制视图文件须由控制器调用才可执行
		//初始化调试状态
		Debug::$src_time = microtime(true);
		Debug::$log_file = self::$dir_log . date('Y-m-d') . '.php';
		Debug::$log_enabled = self::$log_enabled;
		define('VIEW', true);
		
		//设置中国时区，开启session
		if (self::$debug_enabled)
		{
			@error_reporting(E_ALL);
			self::$url = self::$url_local;
			self::$db_config = self::$db_local;
		}
		else
		{
			@error_reporting(0);
			self::$url = self::$url_online;
			self::$db_config = self::$db_online;
		}
		@date_default_timezone_set('PRC');
		@session_start();
	}
}
?>
