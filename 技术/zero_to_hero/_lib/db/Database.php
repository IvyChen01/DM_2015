<?php
/**
 * 数据库操作
 */
class Database
{
	private $dbDriver = '';//数据库驱动类型
	private $db = null;//指定驱动的数据库对象
	
	/**
	 * 创建指定驱动的数据库对象
	 * $dbConfig	配置数据
	 */
	public function __construct($dbConfig)
	{
		$this->dbDriver = $dbConfig['dbDriver'];
		switch ($this->dbDriver)
		{
			case 'mysql':
				$this->db = new Mysql($dbConfig);
				break;
			case 'mysqli':
				break;
			case 'oracle':
				break;
			default:
		}
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		$this->db->connect();
	}
	
	/**
	 * 执行一个SQL语句
	 * $sql	SQL语句
	 */
	public function query($sql)
	{
		$this->db->query($sql);
	}
	
	/**
	 * 返回当前的一条记录并把游标移向下一记录
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getRow($acctype = MYSQL_ASSOC)
	{
		return $this->db->getRow($acctype);
	}
	
	/**
	 * 返回当前的所有记录并把游标移向表尾
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function getAllRows($acctype = MYSQL_ASSOC)
	{
		return $this->db->getAllRows($acctype);
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function getNumRows()
	{
		return $this->db->getNumRows();
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tbName	表名
	 */
	public function getAllFields($tbName)
	{
		return $this->db->getAllFields($tbName);
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
		$this->db->close();
	}
	
	/**
	 * 获取连接id
	 */
	public function getLinkId()
	{
		return $this->db->linkId;
	}
	
	/**
	 * 获取查询结果
	 */
	public function getResult()
	{
		return $this->db->result;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function getAllTables()
	{
		return $this->db->getAllTables();
	}
}
?>
