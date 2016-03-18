<?php
/**
 * 数据库操作
 */
class Database
{
	private $db_driver = '';//数据库驱动类型
	private $db = null;//指定驱动的数据库对象
	
	/**
	 * 创建指定驱动的数据库对象
	 * $db_config	配置数据
	 */
	public function __construct($db_config)
	{
		$this->db_driver = $db_config['db_driver'];
		switch ($this->db_driver)
		{
			case 'mysql':
				$this->db = new Mysql($db_config);
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
	public function get_row($acctype = MYSQL_ASSOC)
	{
		return $this->db->get_row($acctype);
	}
	
	/**
	 * 返回当前的所有记录并把游标移向表尾
	 * $acctype	MYSQL_ASSOC、MYSQL_NUM、MYSQL_BOTH
	 */
	public function get_all_rows($acctype = MYSQL_ASSOC)
	{
		return $this->db->get_all_rows($acctype);
	}
	
	/**
	 * 获取查询的记录个数
	 */
	public function get_num_rows()
	{
		return $this->db->get_num_rows();
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tb_name	表名
	 */
	public function get_all_fields($tb_name)
	{
		return $this->db->get_all_fields($tb_name);
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
	public function get_link_id()
	{
		return $this->db->link_id;
	}
	
	/**
	 * 获取查询结果
	 */
	public function get_result()
	{
		return $this->db->result;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function get_insert_id()
	{
		return $this->db->get_insert_id();
	}
	
	/**
	 * 获取当前数据库的所有表名
	 */
	public function get_all_tables()
	{
		return $this->db->get_all_tables();
	}
}
?>
