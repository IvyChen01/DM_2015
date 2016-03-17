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
	private $tb_user = '';//会员表
	private $tb_answer = '';//答题表
	private $tb_count = '';//统计表
	private $tb_lucky = '';//中奖表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
		
		$this->tb_admin = Config::$tb_admin;
		$this->tb_user = Config::$tb_user;
		$this->tb_answer = Config::$tb_answer;
		$this->tb_count = Config::$tb_count;
		$this->tb_lucky = Config::$tb_lucky;
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
			fbid VARCHAR( 50 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			email VARCHAR( 320 ) NOT NULL ,
			gender VARCHAR( 10 ) NOT NULL ,
			locale VARCHAR( 50 ) NOT NULL ,
			app_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_answer");
		$this->db->query("CREATE TABLE $this->tb_answer (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			fbid VARCHAR( 50 ) NOT NULL ,
			question1 VARCHAR( 2 ) NOT NULL ,
			question2 VARCHAR( 2 ) NOT NULL ,
			question3 VARCHAR( 50 ) NOT NULL ,
			question3_fill VARCHAR( 200 ) NOT NULL ,
			question4 VARCHAR( 50 ) NOT NULL ,
			question4_fill VARCHAR( 200 ) NOT NULL ,
			question5 VARCHAR( 50 ) NOT NULL ,
			question5_fill VARCHAR( 200 ) NOT NULL ,
			question6 VARCHAR( 50 ) NOT NULL ,
			question6_fill VARCHAR( 200 ) NOT NULL ,
			question7 VARCHAR( 50 ) NOT NULL ,
			question7_fill VARCHAR( 200 ) NOT NULL ,
			question8 VARCHAR( 50 ) NOT NULL ,
			question8_fill VARCHAR( 200 ) NOT NULL ,
			question9 VARCHAR( 50 ) NOT NULL ,
			question10 VARCHAR( 50 ) NOT NULL ,
			question10_fill VARCHAR( 200 ) NOT NULL ,
			question11 VARCHAR( 50 ) NOT NULL ,
			question11_fill VARCHAR( 200 ) NOT NULL ,
			question12 VARCHAR( 50 ) NOT NULL ,
			question12_fill VARCHAR( 200 ) NOT NULL ,
			question13 VARCHAR( 2 ) NOT NULL ,
			question14 INT NOT NULL ,
			question15 VARCHAR( 2 ) NOT NULL ,
			question16 VARCHAR( 2 ) NOT NULL ,
			lucky_code VARCHAR( 10 ) NOT NULL ,
			do_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $this->tb_count");
		$this->db->query("CREATE TABLE $this->tb_count (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			answer_count INT NOT NULL,
			question2_1 INT NOT NULL,
			question2_2 INT NOT NULL,
			question2_3 INT NOT NULL,
			question2_4 INT NOT NULL,
			question2_5 INT NOT NULL,
			question2_6 INT NOT NULL,
			question3_1 INT NOT NULL,
			question3_2 INT NOT NULL,
			question3_3 INT NOT NULL,
			question3_4 INT NOT NULL,
			question3_5 INT NOT NULL,
			question3_6 INT NOT NULL,
			question3_7 INT NOT NULL,
			question3_8 INT NOT NULL,
			question3_9 INT NOT NULL,
			question3_10 INT NOT NULL,
			question3_11 INT NOT NULL,
			question3_12 INT NOT NULL,
			question3_13 INT NOT NULL,
			question3_14 INT NOT NULL,
			question3_15 INT NOT NULL,
			question3_16 INT NOT NULL,
			question3_17 INT NOT NULL,
			question4_1 INT NOT NULL,
			question4_2 INT NOT NULL,
			question4_3 INT NOT NULL,
			question4_4 INT NOT NULL,
			question4_5 INT NOT NULL,
			question4_6 INT NOT NULL,
			question4_7 INT NOT NULL,
			question4_8 INT NOT NULL,
			question4_9 INT NOT NULL,
			question4_10 INT NOT NULL,
			question4_11 INT NOT NULL,
			question4_12 INT NOT NULL,
			question4_13 INT NOT NULL,
			question4_14 INT NOT NULL,
			question4_15 INT NOT NULL,
			question4_16 INT NOT NULL,
			question4_17 INT NOT NULL,
			question5_1 INT NOT NULL,
			question5_2 INT NOT NULL,
			question5_3 INT NOT NULL,
			question5_4 INT NOT NULL,
			question5_5 INT NOT NULL,
			question5_6 INT NOT NULL,
			question5_7 INT NOT NULL,
			question5_8 INT NOT NULL,
			question5_9 INT NOT NULL,
			question5_10 INT NOT NULL,
			question5_11 INT NOT NULL,
			question5_12 INT NOT NULL,
			question5_13 INT NOT NULL,
			question6_1 INT NOT NULL,
			question6_2 INT NOT NULL,
			question6_3 INT NOT NULL,
			question6_4 INT NOT NULL,
			question6_5 INT NOT NULL,
			question6_6 INT NOT NULL,
			question7_1 INT NOT NULL,
			question7_2 INT NOT NULL,
			question7_3 INT NOT NULL,
			question7_4 INT NOT NULL,
			question7_5 INT NOT NULL,
			question7_6 INT NOT NULL,
			question7_7 INT NOT NULL,
			question7_8 INT NOT NULL,
			question7_9 INT NOT NULL,
			question7_10 INT NOT NULL,
			question7_11 INT NOT NULL,
			question7_12 INT NOT NULL,
			question7_13 INT NOT NULL,
			question7_14 INT NOT NULL,
			question7_15 INT NOT NULL,
			question7_16 INT NOT NULL,
			question7_17 INT NOT NULL,
			question7_18 INT NOT NULL,
			question7_19 INT NOT NULL,
			question7_20 INT NOT NULL,
			question8_1 INT NOT NULL,
			question8_2 INT NOT NULL,
			question8_3 INT NOT NULL,
			question8_4 INT NOT NULL,
			question8_5 INT NOT NULL,
			question8_6 INT NOT NULL,
			question8_7 INT NOT NULL,
			question8_8 INT NOT NULL,
			question8_9 INT NOT NULL,
			question8_10 INT NOT NULL,
			question8_11 INT NOT NULL,
			question8_12 INT NOT NULL,
			question8_13 INT NOT NULL,
			question8_14 INT NOT NULL,
			question8_15 INT NOT NULL,
			question8_16 INT NOT NULL,
			question8_17 INT NOT NULL,
			question8_18 INT NOT NULL,
			question8_19 INT NOT NULL,
			question8_20 INT NOT NULL,
			question9_1 INT NOT NULL,
			question9_2 INT NOT NULL,
			question9_3 INT NOT NULL,
			question9_4 INT NOT NULL,
			question9_5 INT NOT NULL,
			question9_6 INT NOT NULL,
			question9_7 INT NOT NULL,
			question9_8 INT NOT NULL,
			question9_9 INT NOT NULL,
			question9_10 INT NOT NULL,
			question9_11 INT NOT NULL,
			question9_12 INT NOT NULL,
			question9_13 INT NOT NULL,
			question10_1 INT NOT NULL,
			question10_2 INT NOT NULL,
			question10_3 INT NOT NULL,
			question10_4 INT NOT NULL,
			question10_5 INT NOT NULL,
			question10_6 INT NOT NULL,
			question10_7 INT NOT NULL,
			question10_8 INT NOT NULL,
			question10_9 INT NOT NULL,
			question10_10 INT NOT NULL,
			question10_11 INT NOT NULL,
			question10_12 INT NOT NULL,
			question11_1 INT NOT NULL,
			question11_2 INT NOT NULL,
			question11_3 INT NOT NULL,
			question11_4 INT NOT NULL,
			question11_5 INT NOT NULL,
			question11_6 INT NOT NULL,
			question12_1 INT NOT NULL,
			question12_2 INT NOT NULL,
			question12_3 INT NOT NULL,
			question12_4 INT NOT NULL,
			question13_1 INT NOT NULL,
			question13_2 INT NOT NULL,
			question15_1 INT NOT NULL,
			question15_2 INT NOT NULL,
			question16_1 INT NOT NULL,
			question16_2 INT NOT NULL,
			question16_3 INT NOT NULL,
			question16_4 INT NOT NULL,
			question16_5 INT NOT NULL,
			question16_6 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		$this->db->connect();
		$password = 'eifdafbcifbdcd04ceb5b22d44bd9d9cb777198c1a6jafeebcafabgeddfbfc';
		$sql_login_time = Security::sql_var(date('Y-m-d H:i:s'));
		$this->db->query("INSERT INTO $this->tb_admin (username, password, login_time) VALUES ('admin', '$password', $sql_login_time)");
		
		$this->db->query("INSERT INTO $this->tb_count VALUES (
			1, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 
			0, 0, 
			0, 0, 
			0, 0, 0, 0, 0, 0
		)");
		
		$this->db->query("INSERT INTO $this->tb_count VALUES (
			2, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 
			0, 0, 
			0, 0, 
			0, 0, 0, 0, 0, 0
		)");
		
		$this->db->query("INSERT INTO $this->tb_count VALUES (
			3, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 
			0, 0, 
			0, 0, 
			0, 0, 0, 0, 0, 0
		)");
		
		$this->db->query("INSERT INTO $this->tb_count VALUES (
			4, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 
			0, 0, 
			0, 0, 
			0, 0, 0, 0, 0, 0
		)");
		
		$this->db->query("INSERT INTO $this->tb_count VALUES (
			5, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
			0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 
			0, 0, 
			0, 0, 
			0, 0, 0, 0, 0, 0
		)");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_all_tables()
	{
		$res = array();
		$res[] = $this->tb_admin;
		$res[] = $this->tb_user;
		$res[] = $this->tb_answer;
		$res[] = $this->tb_count;
		$res[] = $this->tb_lucky;
		
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
	 * 获取用户表名
	 */
	public function get_user_table()
	{
		$res = array();
		$res[] = $this->tb_user;
		
		return $res;
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		$this->db->connect();
		
		/*
		$this->db->query("DROP TABLE IF EXISTS $this->tb_lucky");
		$this->db->query("CREATE TABLE $this->tb_lucky (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			fbid VARCHAR( 50 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			email VARCHAR( 320 ) NOT NULL ,
			gender VARCHAR( 10 ) NOT NULL ,
			locale VARCHAR( 50 ) NOT NULL ,
			type VARCHAR( 2 ) NOT NULL ,
			lucky_code VARCHAR( 10 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		*/
	}
}
?>
