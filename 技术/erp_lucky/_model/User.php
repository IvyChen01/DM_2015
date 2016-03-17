<?php
/**
 *	用户
 */
class User
{
	private $db = null;//数据库
	private $tb_user = '';
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_user = Config::$tb_user;
	}
	
	/**
	 * 登录
	 */
	public function login($jobnum, $password)
	{
		$this->db->connect();
		$sql_jobnum = Security::sql_var($jobnum);
		$this->db->query("SELECT * FROM $this->tb_user WHERE jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			$lib_password = $res['password'];
			$input_password = Security::md5_multi($password, Config::$key);
			if ($lib_password == $input_password)
			{
				$userid = (int)$res['id'];
				$username = $res['username'];
				$dept = $res['dept'];
				$type = (int)$res['type'];
				
				$_SESSION[Config::$system_name . '_user_userid'] = $userid;
				$_SESSION[Config::$system_name . '_user_username'] = $username;
				$_SESSION[Config::$system_name . '_user_password'] = $lib_password;
				$_SESSION[Config::$system_name . '_user_jobnum'] = $jobnum;
				$_SESSION[Config::$system_name . '_user_dept'] = $dept;
				$_SESSION[Config::$system_name . '_user_type'] = $type;
				
				$cookie_key = Security::md5_multi($userid . $username . $lib_password . $jobnum . $dept . $type, Config::$key);
				setcookie(Config::$system_name . "_user_cookie_userid", $userid, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_username", $username, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_password", $lib_password, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_jobnum", $jobnum, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_dept", $dept, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_type", $type, time() + 12 * 30 * 24 * 60 * 60);
				setcookie(Config::$system_name . "_user_cookie_key", $cookie_key, time() + 12 * 30 * 24 * 60 * 60);
				
				Debug::log('[user login] userid: ' . $userid . ', jobnum: ' . $jobnum . ', username: ' . $username);
				
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
			$cookie_userid = isset($_COOKIE[Config::$system_name . "_user_cookie_userid"]) ? (int)$_COOKIE[Config::$system_name . "_user_cookie_userid"] : 0;
			$cookie_username = isset($_COOKIE[Config::$system_name . "_user_cookie_username"]) ? $_COOKIE[Config::$system_name . "_user_cookie_username"] : '';
			$cookie_password = isset($_COOKIE[Config::$system_name . "_user_cookie_password"]) ? $_COOKIE[Config::$system_name . "_user_cookie_password"] : '';
			$cookie_jobnum = isset($_COOKIE[Config::$system_name . "_user_cookie_jobnum"]) ? $_COOKIE[Config::$system_name . "_user_cookie_jobnum"] : '';
			$cookie_dept = isset($_COOKIE[Config::$system_name . "_user_cookie_dept"]) ? $_COOKIE[Config::$system_name . "_user_cookie_dept"] : '';
			$cookie_type = isset($_COOKIE[Config::$system_name . "_user_cookie_type"]) ? (int)$_COOKIE[Config::$system_name . "_user_cookie_type"] : '';
			$cookie_key = isset($_COOKIE[Config::$system_name . "_user_cookie_key"]) ? $_COOKIE[Config::$system_name . "_user_cookie_key"] : '';
			
			$safe_key = Security::md5_multi($cookie_userid . $cookie_username . $cookie_password . $cookie_jobnum . $cookie_dept . $cookie_type, Config::$key);
			
			if (!empty($cookie_userid) && !empty($cookie_username) && !empty($cookie_password) && !empty($cookie_jobnum) && !empty($cookie_dept) && !empty($cookie_type) && $cookie_key == $safe_key)
			{
				$_SESSION[Config::$system_name . '_user_userid'] = $cookie_userid;
				$_SESSION[Config::$system_name . '_user_username'] = $cookie_username;
				$_SESSION[Config::$system_name . '_user_password'] = $cookie_password;
				$_SESSION[Config::$system_name . '_user_jobnum'] = $cookie_jobnum;
				$_SESSION[Config::$system_name . '_user_dept'] = $cookie_dept;
				$_SESSION[Config::$system_name . '_user_type'] = $cookie_type;
				
				Debug::log('[user cookie_login] userid: ' . $cookie_userid . ', jobnum: ' . $cookie_jobnum . ', username: ' . $cookie_username);
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function check_password($password)
	{
		$session_password = $this->get_password();
		$input_password = Security::md5_multi($password, Config::$key);
		
		if ($session_password == $input_password)
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
		unset($_SESSION[Config::$system_name . '_user_userid']);
		unset($_SESSION[Config::$system_name . '_user_username']);
		unset($_SESSION[Config::$system_name . '_user_password']);
		unset($_SESSION[Config::$system_name . '_user_jobnum']);
		unset($_SESSION[Config::$system_name . '_user_dept']);
		unset($_SESSION[Config::$system_name . '_user_type']);
		
		setcookie(Config::$system_name . "_user_cookie_userid", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_username", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_password", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_jobnum", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_dept", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_type", '', time() - 3600);
		setcookie(Config::$system_name . "_user_cookie_key", '', time() - 3600);
	}
	
	/**
	 * 修改密码
	 */
	public function change_password($password)
	{
		$this->db->connect();
		$sql_userid = (int)$this->get_userid();
		$sql_password = Security::sql_var(Security::md5_multi($password, Config::$key));
		$this->db->query("UPDATE $this->tb_user SET password=$sql_password WHERE id=$sql_userid");
	}
	
	/**
	 * 用户编号
	 */
	public function get_userid()
	{
		return isset($_SESSION[Config::$system_name . '_user_userid']) ? (int)$_SESSION[Config::$system_name . '_user_userid'] : 0;
	}
	
	/**
	 * 用户名
	 */
	public function get_username()
	{
		return isset($_SESSION[Config::$system_name . '_user_username']) ? $_SESSION[Config::$system_name . '_user_username'] : '';
	}
	
	/**
	 * 密码
	 */
	public function get_password()
	{
		return isset($_SESSION[Config::$system_name . '_user_password']) ? $_SESSION[Config::$system_name . '_user_password'] : '';
	}
	
	/**
	 * 工号
	 */
	public function get_jobnum()
	{
		return isset($_SESSION[Config::$system_name . '_user_jobnum']) ? $_SESSION[Config::$system_name . '_user_jobnum'] : '';
	}
	
	/**
	 * 部门
	 */
	public function get_dept()
	{
		return isset($_SESSION[Config::$system_name . '_user_dept']) ? $_SESSION[Config::$system_name . '_user_dept'] : '';
	}
	
	/**
	 * 帐号类型
	 */
	public function get_type()
	{
		return isset($_SESSION[Config::$system_name . '_user_type']) ? (int)$_SESSION[Config::$system_name . '_user_type'] : '';
	}
}
?>
