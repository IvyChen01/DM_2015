<?php
/**
 * 安装系统
 * [ok]
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
		$tbAdmin = Config::$tbAdmin;
		$tbFans = Config::$tbFans;
		$tbIpLike = Config::$tbIpLike;
		$tbIpShare = Config::$tbIpShare;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbFans");
		Config::$db->query("create table $tbFans (
			id int not null auto_increment primary key,
			photo varchar(255) not null,
			username varchar(50) not null,
			content text not null,
			pubtime datetime not null,
			like_num int not null,
			share_num int not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbIpLike");
		Config::$db->query("create table $tbIpLike (
			id int not null auto_increment primary key,
			ip varchar(50) not null,
			photo_id int not null,
			pubtime datetime not null,
			index (ip),
			index (photo_id)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbIpShare");
		Config::$db->query("create table $tbIpShare (
			id int not null auto_increment primary key,
			ip varchar(50) not null,
			photo_id int not null,
			pubtime datetime not null,
			index (ip),
			index (photo_id)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
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
	 * 获取指定表的所有记录
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
		$tbAdmin = Config::$tbAdmin;
		$tbFans = Config::$tbFans;
		$tbIpLike = Config::$tbIpLike;
		$tbIpShare = Config::$tbIpShare;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
	}
}
?>
