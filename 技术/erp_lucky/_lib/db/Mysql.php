<?php
/**
 * Mysql数据库操作
 */
class Mysql
{
	public $link_id = 0;//连接id
	public $result = 0;//查询结果
	
	//数据库配置信息	
	private $hostname = '';//数据库主机
	private $username = '';//用户名
	private $password = '';//密码
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	private $db_pconnect = false;//是否长连接
	
	private $is_connected = false;//是否已连接
	
	/**
	 * 存储配置信息并连接数据库
	 * $db_config	配置信息
	 */
	public function __construct($db_config)
	{
		$this->hostname = $db_config['hostname'];
		$this->username = $db_config['username'];
		$this->password = $db_config['password'];
		$this->db_name = $db_config['db_name'];
		$this->db_charset = $db_config['db_charset'];
		$this->db_collat = $db_config['db_collat'];
		$this->db_pconnect = $db_config['db_pconnect'];
	}
	
	/**
	 * 连接数据库
	 */
	public function connect()
	{
		if ( ! $this->is_connected)
		{
			if ($this->db_pconnect)
			{
				$this->link_id = mysql_pconnect($this->hostname, $this->username, $this->password);
			}
			else
			{
				$this->link_id = mysql_connect($this->hostname, $this->username, $this->password);
			}
			
			//成功连接则选择数据库，否则处理错误
			if ($this->link_id)
			{
				mysql_select_db($this->db_name);
				mysql_query("SET NAMES '{$this->db_charset}', character_set_client=binary, sql_mode='', interactive_timeout=3600 ;", $this->link_id);
				//标记已连接
				$this->is_connected = true;
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
		if ($this->is_connected)
		{
			$this->result = mysql_query($sql, $this->link_id);
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
	public function get_row($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			return mysql_fetch_array($this->result, $acctype);
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
	public function get_all_rows($acctype = MYSQL_ASSOC)
	{
		if ($this->result)
		{
			$res = array();
			while ($row = mysql_fetch_array($this->result, $acctype))
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
	public function get_num_rows()
	{
		if ($this->result)
		{
			return mysql_num_rows($this->result);
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 获取指定表的所有字段名
	 * $tb_name	表名
	 */
	public function get_all_fields($tb_name)
	{
		if ($this->is_connected)
		{
			$res = array();
			$fields = mysql_list_fields($this->db_name, $tb_name, $this->link_id);
			if ( ! $fields)
			{
				exit('Database error!');
			}
			$columns = mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++)
			{
				$res[$i] = mysql_field_name($fields, $i);
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
		if ($this->link_id)
		{
			mysql_close($this->link_id);
		}
		$this->result = 0;
		$this->link_id = 0;
		$this->is_connected = false;
	}
	
	/**
	 * 获取新插入记录的id
	 */
	public function get_insert_id()
	{
		if ($this->link_id)
		{
			return mysql_insert_id($this->link_id);
		}
		else
		{
			return 0;
		}
	}
}
?>
