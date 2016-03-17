<?php
/**
 * 安装系统
 */
class Install
{
	private $db = null;//数据库
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	
	private $tb_admin = '';//管理员表
	private $tb_user = '';//用户表
	private $tb_jiang_chi = '';//奖池表
	private $tb_zhong_jiang = '';//中奖表
	private $tb_faq = '';//题目表
	private $tb_faq_daily = '';//每日答题表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
		
		$this->tb_admin = Config::$tb_admin;
		$this->tb_user = Config::$tb_user;
		$this->tb_jiang_chi = Config::$tb_jiang_chi;
		$this->tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->tb_faq = Config::$tb_faq;
		$this->tb_faq_daily = Config::$tb_faq_daily;
	}
	
	/**
	 * 创建数据库
	 */
	public function create_database()
	{
		$this->db->connect();
		$this->db->query("CREATE DATABASE IF NOT EXISTS $this->db_name DEFAULT CHARACTER SET $this->db_charset COLLATE $this->db_collat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->create_table();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function create_table()
	{
		$this->db->connect();
		$this->db->query("DROP TABLE IF EXISTS $this->tb_admin");
		$this->db->query("CREATE TABLE $this->tb_admin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			login_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_user");
		$this->db->query("CREATE TABLE $this->tb_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			jobnum VARCHAR( 20 ) NOT NULL ,
			dept VARCHAR( 50 ) NOT NULL ,
			type INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_jiang_chi");
		$this->db->query("CREATE TABLE $this->tb_jiang_chi (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			prize_date DATE NOT NULL ,
			rate INT NOT NULL ,
			prize1 INT NOT NULL ,
			prize2 INT NOT NULL ,
			prize3 INT NOT NULL ,
			prize4 INT NOT NULL ,
			prize5 INT NOT NULL ,
			prize6 INT NOT NULL ,
			prize7 INT NOT NULL ,
			prize8 INT NOT NULL ,
			prize9 INT NOT NULL ,
			prize10 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat; ");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_zhong_jiang");
		$this->db->query("CREATE TABLE $this->tb_zhong_jiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			user_id INT NOT NULL ,
			prize_id INT NOT NULL ,
			prize_name VARCHAR( 50 ) NOT NULL ,
			prize_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_faq");
		$this->db->query("CREATE TABLE $this->tb_faq (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			question TEXT NOT NULL ,
			option1 VARCHAR( 300 ) NOT NULL ,
			option2 VARCHAR( 300 ) NOT NULL ,
			option3 VARCHAR( 300 ) NOT NULL ,
			option4 VARCHAR( 300 ) NOT NULL ,
			answer VARCHAR( 10 ) NOT NULL ,
			question_type INT NOT NULL ,
			month_type INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat; ");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_faq_daily");
		$this->db->query("CREATE TABLE $this->tb_faq_daily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			user_id INT NOT NULL ,
			faq_answer VARCHAR( 100 ) NOT NULL ,
			score INT NOT NULL ,
			faq_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		$this->db->connect();
		$password = 'dfddbgjhbbbcc05519ff0dc31989ef50499541733b6d8gbdaejdajdiacjececj';
		$sql_login_time = Security::sql_var(date('Y-m-d H:i:s'));
		$this->db->query("INSERT INTO $this->tb_admin (username, password, login_time) VALUES ('admin', '$password', $sql_login_time)");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_all_tables()
	{
		$res = array();
		$res[] = $this->tb_admin;
		$res[] = $this->tb_user;
		$res[] = $this->tb_jiang_chi;
		$res[] = $this->tb_zhong_jiang;
		$res[] = $this->tb_faq;
		$res[] = $this->tb_faq_daily;
		
		return $res;
	}
	
	/**
	 * 获取用户表表名
	 */
	public function get_user_table()
	{
		$res = array();
		$res[] = $this->tb_user;
		
		return $res;
	}
	
	/**
	 * 获取奖池表表名
	 */
	public function get_jiang_chi_table()
	{
		$res = array();
		$res[] = $this->tb_jiang_chi;
		
		return $res;
	}
	
	/**
	 * 获取中奖表表名
	 */
	public function get_zhong_jiang_table()
	{
		$res = array();
		$res[] = $this->tb_zhong_jiang;
		
		return $res;
	}
	
	/**
	 * 获取题目表表名
	 */
	public function get_faq_table()
	{
		$res = array();
		$res[] = $this->tb_faq;
		
		return $res;
	}
	
	/**
	 * 获取每日答题表表名
	 */
	public function get_faq_daily_table()
	{
		$res = array();
		$res[] = $this->tb_faq_daily;
		
		return $res;
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function get_all_fields($tb_name)
	{
		$this->db->connect();
		
		return $this->db->get_all_fields($tb_name);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function get_records($tb_name, $start = 0, $record_count = 10)
	{
		$this->db->connect();
		$res = array();
		$res_index = 0;
		$sql_start = (int)$start;
		$sql_record_count = (int)$record_count;
		$this->db->query("SELECT * FROM $tb_name LIMIT $sql_start, $sql_record_count");
		while ($row = $this->db->get_row(MYSQL_NUM))
		{
			$fields_count = count($row);
			for ($i = 0; $i < $fields_count; $i++)
			{
				$res[$res_index][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$res_index++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_dbbackup);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_dbbackup);
		$db->importSql();
	}
	
	/**
	 * 查看数据
	 */
	public function db_select()
	{
		$this->db->connect();
		$this->db->query("select * from $this->tb_user WHERE jobnum='Z12283'");
		$res = $this->db->get_all_rows();
		
		if (!empty($res))
		{
			echo 'count: ' . count($res) . '<br />';
			print_r($res);
		}
		
		$this->db->query("select * from $this->tb_user WHERE jobnum='Z12268'");
		$res = $this->db->get_all_rows();
		
		if (!empty($res))
		{
			echo 'count: ' . count($res) . '<br />';
			print_r($res);
		}
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		$this->db->connect();
		
		$sql_password = Security::sql_var(Security::md5_multi('01173', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('01173', '邹振良', '制造管理部', 1, $sql_password)");
		
		/*
		$sql_password = Security::sql_var(Security::md5_multi('01201', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('01201', '肖春霞', '商务物流部', 1, $sql_password)");
		
		$sql_password = Security::sql_var(Security::md5_multi('01181', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('01181', '王满', '采购部', 1, $sql_password)");
		
		$sql_password = Security::sql_var(Security::md5_multi('01206', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('01206', '李春秀', '质量管理部', 1, $sql_password)");
		
		$sql_password = Security::sql_var(Security::md5_multi('09110', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('09110', '徐海玲', '物流商务部', 1, $sql_password)");
		
		$sql_password = Security::sql_var(Security::md5_multi('60429', Config::$key));
		$this->db->query("INSERT INTO $this->tb_user (jobnum, username, dept, type, password) VALUES ('60429', '刘娜', '采购部', 1, $sql_password)");
		*/
		
		/*
		$sql_password = Security::sql_var(Security::md5_multi('01190', Config::$key));
		$this->db->query("UPDATE $this->tb_user SET jobnum='01190', password=$sql_password WHERE jobnum='09110'");
		*/
		
		//$this->db->query("UPDATE $this->tb_jiang_chi SET rate=40");
	}
}
?>
