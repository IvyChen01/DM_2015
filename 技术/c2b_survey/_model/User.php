<?php
/**
 *	用户
 */
class User
{
	private $db = null;//数据库
	private $tb_user = '';//用户表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_user = Config::$tb_user;
	}
	
	public function exist_user($fbid)
	{
		$this->db->connect();
		$sql_fbid = Security::sql_var($fbid);
		$this->db->query("SELECT * FROM $this->tb_user WHERE fbid=$sql_fbid");
		$res = $this->db->get_row();
		
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function add_user($fbid, $username, $email, $gender, $locale)
	{
		$this->db->connect();
		$sql_fbid = Security::sql_var($fbid);
		$sql_username = Security::sql_var($username);
		$sql_email = Security::sql_var($email);
		$sql_gender = Security::sql_var($gender);
		$sql_locale = Security::sql_var($locale);
		$sql_app_time = Security::sql_var(date('Y-m-d H:i:s'));
		
		$this->db->query("INSERT INTO $this->tb_user (fbid, username, email, gender, locale, app_time) VALUES ($sql_fbid, $sql_username, $sql_email, $sql_gender, $sql_locale, $sql_app_time)");
	}
	
	public function add_user_fbid($fbid)
	{
		$this->db->connect();
		$sql_fbid = Security::sql_var($fbid);
		$sql_app_time = Security::sql_var(date('Y-m-d H:i:s'));
		
		$this->db->query("INSERT INTO $this->tb_user (fbid, app_time) VALUES ($sql_fbid, $sql_app_time)");
	}
	
	public function add_profile($fbid, $username, $email, $gender, $locale)
	{
		$this->db->connect();
		$sql_fbid = Security::sql_var($fbid);
		$sql_username = Security::sql_var($username);
		$sql_email = Security::sql_var($email);
		$sql_gender = Security::sql_var($gender);
		$sql_locale = Security::sql_var($locale);
		
		$this->db->query("UPDATE $this->tb_user SET username=$sql_username, email=$sql_email, gender=$sql_gender, locale=$sql_locale WHERE fbid=$sql_fbid");
	}
}
?>
