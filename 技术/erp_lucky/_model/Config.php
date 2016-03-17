<?php
/**
 * 配置信息
 */
class Config
{
	public static $debug_enabled = true;//调试开关
	public static $system_name = 'erp_lucky';//系统名称
	public static $key = 'aff.asd.,jja1fapf...baaffa.2';//密钥
	public static $base_url = 'http://localhost';//当前网址，线上或本地
	public static $dir_dbbackup = 'extends/db/';//数据库备份目录
	public static $dir_log = 'extends/log/';//日志目录
	public static $dir_lock = 'extends/lock/';//锁定文件目录
	
	public static $max_prize = 10;//最大奖品数
	public static $prize_name = array('蓝牙耳机', '充电宝', '果冻表', '三折伞', '压缩毛巾', '拍拍手环', '', '', '', '');//奖品名称
	
	public static $tb_admin = 'erp_lucky_admin';//管理员表
	public static $tb_user = 'erp_lucky_user';//用户表
	public static $tb_jiang_chi = 'erp_lucky_jiang_chi';//奖池表
	public static $tb_zhong_jiang = 'erp_lucky_zhong_jiang';//中奖表
	public static $tb_faq = 'erp_lucky_faq';//题库表
	public static $tb_faq_daily = 'erp_lucky_faq_daily';//每日答题表
	
	//线上数据库配置信息
	private static $db_online = array
	(
		'hostname' => '127.0.0.1',//数据库主机
		'username' => 'root',//用户名
		'password' => 'iejf34root123',//密码
		'db_name' => 'erp_lucky',//数据库名
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
		'db_name' => 'erp_lucky',//数据库名
		'db_driver' => 'mysql',//数据库驱动
		'db_charset' => 'utf8',//数据库字符集
		'db_collat' => 'utf8_general_ci',
		'db_pconnect' => false//是否永久连接
	);
	
	public static $db_config = null;//数据库配置信息，线上或本地
	
	/**
	 * 初始化状态
	 */
	public static function init()
	{
		//记录执行程序的当前时间，配置log文件位置
		//限制视图文件须由控制器调用才可执行
		Debug::$src_time = microtime(true);
		Debug::$log_file = self::$dir_log . date('Y-m-d') . '.php';
		define('VIEW', true);
		
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
