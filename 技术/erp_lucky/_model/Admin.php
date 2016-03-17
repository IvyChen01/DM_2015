<?php
/**
 *	管理员
 */
class Admin
{
	private $db = null;//数据库
	private $tb_admin = '';//管理员表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_admin = Config::$tb_admin;
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		$this->db->connect();
		$password = Security::md5_multi($password, Config::$key);
		$sql_username = Security::sql_var($username);
		$this->db->query("SELECT * FROM $this->tb_admin WHERE username=$sql_username");
		$res = $this->db->get_row();
		
		if (empty($res))
		{
			return false;
		}
		else
		{
			if ($password == $res['password'])
			{
				$_SESSION[Config::$system_name . '_admin_userid'] = (int)$res['id'];
				$_SESSION[Config::$system_name . '_admin_username'] = $res['username'];
				$_SESSION[Config::$system_name . '_admin_password'] = $res['password'];
				$sql_id = (int)$res['id'];
				$sql_login_time = Security::sql_var(date('Y-m-d H:i:s'));
				$this->db->query("UPDATE $this->tb_admin SET login_time=$sql_login_time WHERE id=$sql_id");
				
				Debug::log('[admin login] userid: ' . $res['id'] . ', username: ' . $res['username']);
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * 检测是否登录
	 */
	public function check_login()
	{
		if ($this->get_userid() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function check_password($password)
	{
		$src_password = $this->get_password();
		$password = Security::md5_multi($password, Config::$key);
		if ($password == $src_password)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 注销
	 */
	public function logout()
	{
		unset($_SESSION[Config::$system_name . '_admin_userid']);
		unset($_SESSION[Config::$system_name . '_admin_username']);
		unset($_SESSION[Config::$system_name . '_admin_password']);
	}
	
	/**
	 * 修改密码
	 */
	public function change_password($new_password)
	{
		$this->db->connect();
		$sql_id = (int)$this->get_userid();
		$new_password = Security::md5_multi($new_password, Config::$key);
		$sql_new_password = Security::sql_var($new_password);
		$this->db->query("UPDATE $this->tb_admin SET password=$sql_new_password WHERE id=$sql_id");
	}
	
	/**
	 * 获取用户编号
	 */
	public function get_userid()
	{
		return isset($_SESSION[Config::$system_name . '_admin_userid']) ? (int)$_SESSION[Config::$system_name . '_admin_userid'] : 0;
	}
	
	/**
	 * 获取用户名
	 */
	public function get_username()
	{
		return isset($_SESSION[Config::$system_name . '_admin_username']) ? $_SESSION[Config::$system_name . '_admin_username'] : '';
	}
	
	/**
	 * 获取密码
	 */
	public function get_password()
	{
		return isset($_SESSION[Config::$system_name . '_admin_password']) ? $_SESSION[Config::$system_name . '_admin_password'] : '';
	}
}
?>
