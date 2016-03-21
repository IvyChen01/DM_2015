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
		$tbSession = Config::$tbSession;//会话表
		$tbAdmin = Config::$tbAdmin;//管理员表
		$tbUser = Config::$tbUser;//用户表
		$tbFriend = Config::$tbFriend;//好友表
		$tbMessage = Config::$tbMessage;//留言表
		$tbNews = Config::$tbNews;//新闻表
		$tbNewsPic = Config::$tbNewsPic;//新闻图片表
		$tbComment = Config::$tbComment;//评论表
		$tbCollection = Config::$tbCollection;//收藏表
		$tbLike = Config::$tbLike;//点赞表
		$tbChannel = Config::$tbChannel;//栏目表
		$tbUserChannel = Config::$tbUserChannel;//用户栏目表
		$tbFeedback = Config::$tbFeedback;//反馈表
		$tbFaq = Config::$tbFaq;//FAQ表
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
			uid varchar(50) not null,
			username varchar(50) not null,
			password varchar(200) not null,
			email varchar(255) not null,
			phone varchar(50) not null,
			nick varchar(50) not null,
			signature varchar (400) not null,
			photo varchar(255) not null,
			register_date datetime not null,
			register_ip varchar(50) not null,
			index (uid),
			index (username),
			index (email),
			index (phone)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFriend");
		Config::$db->query("create table $tbFriend (
			id int not null auto_increment primary key,
			uid1 varchar(50) not null,
			uid2 varchar(50) not null,
			is_add1 int not null,
			is_add2 int not null,
			add_date datetime not null,
			index (uid1),
			index (uid2)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbMessage");
		Config::$db->query("create table $tbMessage (
			id int not null auto_increment primary key,
			from_id varchar(50) not null,
			to_id varchar(50) not null,
			content text not null,
			message_date datetime not null,
			index (from_id),
			index (to_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbNews");
		Config::$db->query("create table $tbNews (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			type varchar(20) not null,
			slug varchar(50) not null,
			url varchar(255) not null,
			status varchar(20) not null,
			title varchar(200) not null,
			title_plain varchar(200) not null,
			content text not null,
			excerpt text not null,
			pubdate datetime not null,
			modified datetime not null,
			channel varchar(50) not null,
			tags varchar(300),
			author varchar(50) not null,
			index (newsid),
			index (channel)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbNewsPic");
		Config::$db->query("create table $tbNewsPic (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			full_img varchar(255) not null,
			full_width int not null,
			full_height int not null,
			thumbnail_img varchar(255) not null,
			thumbnail_width int not null,
			thumbnail_height int not null,
			medium_img varchar(255) not null,
			medium_width int not null,
			medium_height int not null,
			post_thumbnail_img varchar(255) not null,
			post_thumbnail_width int not null,
			post_thumbnail_height int not null,
			index (newsid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			newsid varchar(50) not null,
			uid varchar(50) not null,
			content text not null,
			comment_date datetime not null,
			like_count int not null,
			index (newsid),
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbCollection");
		Config::$db->query("create table $tbCollection (
			id int not null auto_increment primary key,
			uid varchar(50) not null,
			newsid varchar(50) not null,
			collect_date datetime not null,
			index (uid),
			index (newsid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbLike");
		Config::$db->query("create table $tbLike (
			id int not null auto_increment primary key,
			commentid int not null,
			uid varchar(50) not null,
			like_date datetime not null,
			index (commentid),
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbChannel");
		Config::$db->query("create table $tbChannel (
			id int not null auto_increment primary key,
			channel varchar(50) not null,
			index (channel)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUserChannel");
		Config::$db->query("create table $tbUserChannel (
			id int not null auto_increment primary key,
			uid varchar(50) not null,
			channel text not null,
			index (uid)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFeedback");
		Config::$db->query("create table $tbFeedback (
			id int not null auto_increment primary key,
			from_id varchar(50) not null,
			to_id varchar(50) not null,
			content text not null,
			feedback_date datetime not null,
			image varchar(255) not null,
			index (from_id),
			index (to_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbFaq");
		Config::$db->query("create table $tbFaq (
			id int not null auto_increment primary key,
			question text not null,
			answer text not null,
			pubdate datetime not null
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
		$tbSession = Config::$tbSession;//会话表
		$tbAdmin = Config::$tbAdmin;//管理员表
		$tbUser = Config::$tbUser;//用户表
		$tbFriend = Config::$tbFriend;//好友表
		$tbMessage = Config::$tbMessage;//留言表
		$tbNews = Config::$tbNews;//新闻表
		$tbNewsPic = Config::$tbNewsPic;//新闻图片表
		$tbComment = Config::$tbComment;//评论表
		$tbCollection = Config::$tbCollection;//收藏表
		$tbLike = Config::$tbLike;//点赞表
		$tbChannel = Config::$tbChannel;//栏目表
		$tbUserChannel = Config::$tbUserChannel;//用户栏目表
		$tbFeedback = Config::$tbFeedback;//反馈表
		$tbFaq = Config::$tbFaq;//FAQ表
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
	}
}
?>
