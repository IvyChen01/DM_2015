<?php
/**
 * Mysql数据库操作
 * @author Shines
 */
class Mysql
{
	public $linkId = 0;//连接id
	public $result = 0;//查询结果
	
	//数据库配置信息	
	private $hostname = '';//数据库主机
	private $username = '';//用户名
	private $password = '';//密码
	private $dbName = '';//数据库名
	private $dbCharset = '';//数据库字符集
	private $dbCollat = '';//排序规则
	private $dbPconnect = false;//是否长连接
	private $isConnected = false;//是否已连接
	
	/**
	 * 存储配置信息并连接数据库
	 * $dbConfig	配置信息
	 */
	public function __construct($dbConfig)
	{
		$this->hostname = $dbConfig['hostname'];
		$this->username = $dbConfig['username'];
		$this->password = $dbConfig['password'];
		$this->dbName = $dbConfig['dbName'];
		$this->dbCharset = $dbConfig['dbCharset'];
		$this->dbCollat = $dbConfig['dbCollat'];
		$this->dbPconnect = $dbConfig['dbPconnect'];
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		if ( ! $this->isConnected)
		{
			if ($this->dbPconnect)
			{
				$this->linkId = @mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->linkId = @mysql_connect($this->hostname, $this->username, $this->password);
			}
			
			//成功连接则选择数据库，否则处理错误
			if ($this->linkId)
			{
				@mysql_select_db($this->dbName);
				@mysql_query("SET NAMES '{$this->dbCharset}', character_set_client=binary, sql_mode='', interactive_timeout=3600;", $this->linkId);
				//标记已连接
				$this->isConnected = true;
			}
			else
			{
				exit('Database error!');
			}
		}
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		if ($this->isConnected)
		{
			$this->result = @mysql_query($sql, $this->linkId);
			if ( ! $this->result)
			{
				exit('Database error!');
			}
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			return @mysql_fetch_array($this->result, $acctype);
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取当前查询的所有记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			$res = array();
			while ($row = @mysql_fetch_array($this->result, $acctype))
			{
				$res[] = $row;
			}
			
			return $res;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		if ($this->result)
		{
			return @mysql_num_rows($this->result);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		if ($this->isConnected)
		{
			$res = array();
			$fields = @mysql_list_fields($this->dbName, $tbName, $this->linkId);
			if ( ! $fields)
			{
				exit('Database error!');
			}
			$columns = @mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++)
			{
				$res[$i] = @mysql_field_name($fields, $i);
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		if ($this->linkId)
		{
			@mysql_close($this->linkId);
		}
		$this->result = 0;
		$this->linkId = 0;
		$this->isConnected = false;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		if ($this->linkId)
		{
			return @mysql_insert_id($this->linkId);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		if ($this->isConnected)
		{
			$res = array();
			$this->query("SHOW TABLES");
			$rows = $this->getAllRows(MYSQL_NUM);
			foreach ($rows as $value)
			{
				$res[] = $value[0];
			}
			
			return $res;
		}
		else
		{
			exit('Database not connected!');
		}
	}
}
?>
