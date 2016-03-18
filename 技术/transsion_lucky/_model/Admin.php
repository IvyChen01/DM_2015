<?php
/**
 *	管理员
 */
class Admin
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 登录
	 */
	public function login($username, $password)
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$password = Security::md5_multi($password, Config::$key);
		$sql_username = Security::var_sql($username);
		$this->db->query("SELECT * FROM $tb_admin WHERE username=$sql_username");
		$res = $this->db->get_row();
		
		if (!empty($res))
		{
			if ($password == $res['password'])
			{
				System::set_session('admin_userid', (int)$res['id']);
				System::set_session('admin_username', $res['username']);
				System::set_session('admin_password', $res['password']);
				Debug::log('[admin login] userid: ' . $res['id'] . ', username: ' . $res['username']);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
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
	 * 注销
	 */
	public function logout()
	{
		System::clear_session('admin_userid');
		System::clear_session('admin_username');
		System::clear_session('admin_password');
	}
	
	/**
	 * 检测密码是否正确
	 */
	public function check_password($password)
	{
		$session_password = $this->get_password();
		$in_password = Security::md5_multi($password, Config::$key);
		if ($session_password == $in_password)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	public function change_password($new_password)
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$sql_id = (int)$this->get_userid();
		$new_password = Security::md5_multi($new_password, Config::$key);
		$sql_new_password = Security::var_sql($new_password);
		$this->db->query("UPDATE $tb_admin SET password=$sql_new_password WHERE id=$sql_id");
	}
	
	/**
	 * 获取用户编号
	 */
	public function get_userid()
	{
		return (int)System::get_session('admin_userid');
	}
	
	/**
	 * 获取用户名
	 */
	public function get_username()
	{
		return System::get_session('admin_username');
	}
	
	/**
	 * 获取密码
	 */
	public function get_password()
	{
		return System::get_session('admin_password');
	}
	
	/**
	 * 生成验证码
	 */
	public function get_verify()
	{
		Image::buildImageVerify('48', '22', null, Config::$system_name . '_admin_verify');
	}
	
	/**
	 * 检查验证码
	 */
	public function check_verify($code)
	{
		$verify = isset($_SESSION[Config::$system_name . '_admin_verify']) ? $_SESSION[Config::$system_name . '_admin_verify'] : '';
		unset($_SESSION[Config::$system_name . '_admin_verify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
