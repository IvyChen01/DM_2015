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
		$this->initPrize();
	}
	
	/**
	 * 创建表
	 */
	private function createTable()
	{
		Config::$db->connect();
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		$tbAdmin = Config::$tbAdmin;
		$tbJiangChi = Config::$tbJiangChi;
		$tbZhongJiang = Config::$tbZhongJiang;
		$tbLuckyDaily = Config::$tbLuckyDaily;
		
		Config::$db->query("DROP TABLE IF EXISTS $tbAdmin");
		Config::$db->query("CREATE TABLE $tbAdmin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
		
		Config::$db->query("DROP TABLE IF EXISTS $tbJiangChi");
		Config::$db->query("CREATE TABLE $tbJiangChi (
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
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
		
		Config::$db->query("DROP TABLE IF EXISTS $tbZhongJiang");
		Config::$db->query("CREATE TABLE $tbZhongJiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			prizeid INT NOT NULL ,
			prizename VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			lucky_code VARCHAR( 50 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
		
		Config::$db->query("DROP TABLE IF EXISTS $tbLuckyDaily");
		Config::$db->query("CREATE TABLE $tbLuckyDaily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			pan_flag INT NOT NULL ,
			lose_code INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $dbCharset COLLATE $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlPassword = Security::multiMd5('admin', Config::$key);
		Config::$db->query("INSERT INTO $tbAdmin (username, password) VALUES ('admin', '$sqlPassword')");
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
	
	public function initPrize()
	{
		Config::$db->connect();
		$tbJiangChi = Config::$tbJiangChi;
		
		////////// debug
		//Config::$db->query("delete from $tbJiangChi");
		//Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-15', 50, 30, 30, 30, 20, 10)");
		
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-16', 50, 4, 2, 2, 1, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-17', 50, 4, 2, 2, 1, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-18', 50, 4, 2, 2, 1, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-19', 50, 4, 2, 2, 1, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-20', 50, 4, 2, 2, 0, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-21', 50, 4, 2, 2, 0, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-22', 50, 4, 2, 2, 0, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-23', 50, 4, 2, 2, 0, 1)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-24', 50, 4, 2, 2, 1, 0)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-25', 50, 4, 2, 2, 1, 0)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-26', 50, 4, 2, 2, 1, 0)");
		Config::$db->query("INSERT INTO $tbJiangChi (prize_date, rate, prize1, prize2, prize3, prize4, prize5) VALUES ('2015-3-27', 50, 4, 2, 2, 1, 0)");
	}
	
	public function sumPrize()
	{
		Config::$db->connect();
		$tbJiangChi = Config::$tbJiangChi;
		Config::$db->query("select sum(prize1), sum(prize2), sum(prize3), sum(prize4), sum(prize5), sum(prize6) from $tbJiangChi");
		$res = Config::$db->getRow();
		print_r($res);
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		Config::$db->connect();
		$tbJiangChi = Config::$tbJiangChi;
		//Config::$db->query("update $tbJiangChi set rate=100");
		Config::$db->query("update $tbJiangChi set prize1=0, prize2=0, prize3=0, prize4=0, prize5=0 where id=9");
		Config::$db->query("update $tbJiangChi set prize1=5, prize2=4, prize3=4, prize4=2, prize5=2 where id=10");
		//Config::$db->query("update $tbJiangChi set prize1=10, prize2=3, prize3=3, prize4=2, prize5=2 where id=4");
		//Config::$db->query("update $tbJiangChi set prize1=4, prize2=2, prize3=2, prize4=1, prize5=1 where id=12");
	}
}
?>
