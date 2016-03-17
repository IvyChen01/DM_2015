<?php
/**
 * 安装系统
 */
class Install
{
	public function __construct()
	{
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		$dbName = Config::$dbConfig['dbName'];
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		Config::$db->connect();
		Config::$db->query("CREATE DATABASE IF NOT EXISTS $dbName DEFAULT CHARACTER SET $dbCharset COLLATE $dbCollat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->createTable();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function createTable()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbCustomer = Config::$tbCustomer;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("DROP TABLE IF EXISTS $tbAdmin");
		Config::$db->query("CREATE TABLE $tbAdmin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
		
		Config::$db->query("DROP TABLE IF EXISTS $tbUser");
		Config::$db->query("CREATE TABLE $tbUser (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			level INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
		
		Config::$db->query("DROP TABLE IF EXISTS $tbCustomer");
		Config::$db->query("CREATE TABLE $tbCustomer (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			no VARCHAR( 10 ) NOT NULL ,
			country VARCHAR( 20 ) NOT NULL ,
			date1 DATE NOT NULL ,
			wo_number VARCHAR( 20 ) NOT NULL ,
			customer_name VARCHAR( 50 ) NOT NULL ,
			type VARCHAR( 20 ) NOT NULL ,
			phone VARCHAR( 20 ) NOT NULL ,
			model VARCHAR( 20 ) NOT NULL ,
			set_return DATE NOT NULL ,
			wb VARCHAR( 20 ) NOT NULL ,
			in_bay VARCHAR( 20 ) NOT NULL ,
			import_user INT NOT NULL ,
			import_time DATETIME NOT NULL ,
			year INT NOT NULL ,
			month INT NOT NULL ,
			week INT NOT NULL ,
			fill_user INT NOT NULL ,
			fill_time DATETIME NOT NULL ,
			change_user INT NOT NULL ,
			change_time DATETIME NOT NULL ,
			status INT NOT NULL ,
			error_status INT NOT NULL ,
			dial_number INT NOT NULL ,
			feedback INT NOT NULL ,
			language INT NOT NULL ,
			is_take_back INT NOT NULL ,
			is_accept_interview INT NOT NULL ,
			q1 INT NOT NULL ,
			q2 INT NOT NULL ,
			q3 INT NOT NULL ,
			q4 INT NOT NULL ,
			q5 INT NOT NULL ,
			q5_2 INT NOT NULL ,
			q6 VARCHAR( 500 ) NOT NULL ,
			q7 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$password = Security::multiMd5('admin', Config::$key);
		Config::$db->query("INSERT INTO $tbAdmin (username, password) VALUES ('admin', '$password')");
		
		$passwords = array('afihgi223', 'ahbuec362', 'ahgurb785', 'ahirib568', 'aeijfn665', 'aqwedf853', 'ajcndu982', 'apqpwx987', 'asifjw289', 'anwasp378');
		for ($i = 1; $i <= 10; $i++)
		{
			$username = 'admin' . $i;
			$password = Security::multiMd5($passwords[$i - 1], Config::$key);
			Config::$db->query("INSERT INTO $tbUser (username, password, level) VALUES ('$username', '$password', 1)");
		}
		
		$passwords = array('mwnmix239', 'meixpq326', 'mrpxwn579', 'mtqyxu633', 'myuqpx752', 'muwipx822', 'miqpxx982', 'mpnvbb228', 'majyeb339', 'msiwpx552');
		for ($i = 1; $i <= 10; $i++)
		{
			$username = 'manager' . $i;
			$password = Security::multiMd5($passwords[$i - 1], Config::$key);
			Config::$db->query("INSERT INTO $tbUser (username, password, level) VALUES ('$username', '$password', 2)");
		}
		
		$passwords = array('usdepn296', 'udqspx376', 'ufqpxn527', 'ugqsvn639', 'uhwpmr752', 'ujqpnc832', 'ukqpnx953', 'uxwpce269', 'ucwytr357', 'uvrwep533');
		for ($i = 1; $i <= 10; $i++)
		{
			$username = 'user' . $i;
			$password = Security::multiMd5($passwords[$i - 1], Config::$key);
			Config::$db->query("INSERT INTO $tbUser (username, password, level) VALUES ('$username', '$password', 3)");
		}
	}
	
	/**
	 * 获取所有的表名
	 */
	public function getAllTables()
	{
		Config::$db->connect();
		return Config::$db->getAllTables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function getAllFields($tbName)
	{
		Config::$db->connect();
		return Config::$db->getAllFields($tbName);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function getRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		Config::$db->query("SELECT * FROM $tbName LIMIT $sqlStart, $sqlRecordCount");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$dirBackup . Utils::mdate('Y-m-d') . '/';
		Utils::createDir($path);
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], Config::$dirRecover);
		$db->importSql();
	}
	
	public function find($keywords)
	{
		Config::$db->connect();
		$res = array();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tables = $this->getAllTables();
		foreach ($tables as $tb)
		{
			echo '$tb: ' . $tb . '<br />';
			$fields = $this->getAllFields($tb);
			foreach ($fields as $fd)
			{
				if ('register_time' == $fd)
				{
					continue;
				}
				echo '$fd: ' . $fd . '<br />';
				$sqlTb = '`' . $tb . '`';
				$sqlFd = '`' . $fd . '`';
				Config::$db->query("select $sqlFd from $sqlTb where $sqlFd like $sqlKeywords");
				$rows = Config::$db->getAllRows();
				if (!empty($rows))
				{
					$tableInfo = array();
					$tableInfo['tbname'] = $tb;
					$tableInfo['fields'] = array($fd);
					$tableInfo['records'] = $rows;
					$res[] = $tableInfo;
				}
			}
		}
		
		return $res;
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		Config::$db->connect();
	}
}
?>
