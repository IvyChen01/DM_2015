<?php
/**
 * 配置信息
 */
class Config
{
	public static $debug_enabled = true;//调试开关
	public static $log_enabled = true;//日志记录开关
	
	public static $system_name = 'fb_faq';//系统名称
	public static $key = 'af...,3aff,.fou2,3tecno_faq34o34,.3a1.';//密钥
	
	public static $url = '';//当前网址，线上或本地
	public static $url_online = 'http://www.tecno-mobile.com/fb/fb_faq';//线上网址
	public static $url_local = 'http://localhost';//本地网址
	
	public static $app_id = '503915806404735';//App ID
	public static $app_key = 'a6ad3945b02b957da85f91b89383d5ae';//App Secret
	public static $app_redirect_url = 'https://www.tecno-mobile.com/fb/fb_faq/';//App跳转地址
	public static $app_url = 'http://www.tecno-mobile.com/fb/fb_faq/';//App地址
	
	public static $dir_log = 'log/';//日志目录
	public static $dir_lock = 'lock/';//锁定文件目录
	public static $dir_dbbackup = 'dbbackup/';//数据库备份目录
	public static $dir_uploads = 'uploads/';//上传目录
	
	public static $type_count = 5;//手机类型个数
	public static $question_count = 16;//总题目个数
	//各题目选项数
	public static $option_count = array
	(
		5, 5, 17, 17, 13,
		6, 20, 20, 13, 12,
		6, 4, 2, 0, 2, 5
	);
	//第3题选项对应第5题后详细题号
	public static $q3_q5 = array
	(
		'0' => 0,
		'1' => 0,
		'2' => 0,
		'3' => 5,
		'4' => 6,
		'5' => 7,
		'6' => 8,
		'7' => 10,
		'8' => 0,
		'9' => 9,
		'10' => 11,
		'11' => 0,
		'12' => 0,
		'13' => 0,
		'14' => 12,
		'15' => 0,
		'16' => 0
	);
	//第5题后详细题号对应第3题选项
	public static $q5_q3 = array
	(
		'5' => 3,
		'6' => 4,
		'7' => 5,
		'8' => 6,
		'10' => 7,
		'9' => 9,
		'11' => 10,
		'12' => 14
	);
	
	public static $list_pagesize = 100;//统计数据每页显示条数
	
	public static $tb_admin = 'fb_faq_admin';//管理员表
	public static $tb_user = 'fb_faq_user';//会员表
	public static $tb_answer = 'fb_faq_answer';//答题表
	public static $tb_count = 'fb_faq_count';//统计表
	public static $tb_lucky = 'fb_faq_lucky';//中奖表
	
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
