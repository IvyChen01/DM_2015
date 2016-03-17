<?php
/**
 * 安装系统
 * @author Shines
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
		Config::$db->query("create database if not exists $dbName default character set $dbCharset collate $dbCollat");
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
		$tbSession = Config::$tbSession;
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbSession");
		Config::$db->query("create table $tbSession (
			id int not null auto_increment primary key,
			sid varchar(200) not null,
			content text not null,
			create_date datetime not null,
			expire_date datetime not null,
			index (sid),
			index (expire_date)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			username varchar(50) not null,
			photo varchar(256) not null,
			email varchar(320) not null,
			gender varchar(50) not null,
			regtime datetime not null,
			logintype int not null,
			localphoto varchar(256) not null,
			ip varchar(32) not null,
			totalscore int not null,
			dailyscore int not null,
			friendscore int not null,
			lastplay datetime not null,
			isinvite tinyint not null,
			restLucky int not null,
			isshared tinyint not null,
			isplayed tinyint not null,
			index (fbid),
			index (totalscore)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpJiangChi");
		Config::$db->query("create table $tbZpJiangChi (
			id int not null auto_increment primary key,
			prizedate date not null,
			rate int not null,
			prize1 int not null,
			prize2 int not null,
			prize3 int not null,
			prize4 int not null,
			prize5 int not null,
			prize6 int not null,
			prize7 int not null,
			prize8 int not null,
			prize9 int not null,
			prize10 int not null,
			index (prizedate)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpZhongJiang");
		Config::$db->query("create table $tbZpZhongJiang (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			prizeid int not null,
			luckycode varchar(50) not null,
			luckydate datetime not null,
			index (fbid),
			index (luckycode)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbZpDaily");
		Config::$db->query("create table $tbZpDaily (
			id int not null auto_increment primary key,
			fbid varchar(50) not null,
			luckydate datetime not null,
			index (fbid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlPassword = Security::multiMd5('admin', Config::$key);
		Config::$db->query("insert into $tbAdmin (username, password) values ('admin', '$sqlPassword')");
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
	 * 获取指定表的记录
	 */
	public function getRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		Config::$db->query("select * from $tbName limit $sqlStart, $sqlRecordCount");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars(substr($row[$i], 0, 50), ENT_QUOTES);
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
		$path = Config::$backupDir . Utils::mdate('Y-m-d') . '/';
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
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], Config::$recoverDir);
		$db->importSql();
	}
	
	/**
	 * 在数据库中查找关键词
	 */
	public function find($keywords)
	{
		Config::$db->connect();
		$res = array();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tables = $this->getAllTables();
		foreach ($tables as $tb)
		{
			//echo '$tb: ' . $tb . '<br />';
			$fields = $this->getAllFields($tb);
			foreach ($fields as $fd)
			{
				if ('register_date' == $fd)
				{
					continue;
				}
				//echo '$fd: ' . $fd . '<br />';
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
		$tbSession = Config::$tbSession;
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$tbZpDaily = Config::$tbZpDaily;
		
		//Config::$db->query("insert into $tbHbDaily (userid, is_click, lucky_date) values (1, 1, $sqlDate)");
	}
}
?>
