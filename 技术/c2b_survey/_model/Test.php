<?php
class Test
{
	private $db = null;//数据库
	private $tb_user = '';
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_user = Config::$tb_user;
	}
	
	public function test_redis()
	{
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379) or exit('Redis Error!');
		$redis->set('t3', 'sdfoiwef askdfj ;asdfj apsdifh akasdkfh asdjf;as df;j asdf;l ');
		echo 't1: ' . $redis->get('t1') . '<br />';
		echo 't2: ' . $redis->get('t2') . '<br />';
		echo 't3: ' . $redis->get('t3') . '<br />';
		
		
		for ($i = 0; $i < 10000; $i++)
		{
			$redis->set('user_username_' . $i, 'user' . $i);
			$redis->set('user_password_' . $i, 'password' . $i);
			$redis->set('user_logintime_' . $i, date('Y-m-d H:i:s'));
			
			//$redis->get('user_username_' . $i);
			//$redis->get('user_password_' . $i);
			//$redis->get('user_logintime_' . $i);
		}
		
		echo 'user_username_900: ' . $redis->get('user_username_900') . '<br />';
		echo 'user_password_900: ' . $redis->get('user_password_900') . '<br />';
		echo 'user_logintime_900: ' . $redis->get('user_logintime_900') . '<br />';
		
		$redis->close();
	}
	
	public function test_memcache()
	{
		$mem = new Memcache();
		$mem->connect('127.0.0.1', 11211) or exit('Memcache Error!');
		$mem->set('t1', 't1');
		//$mem->set('t2', 't2');
		//$mem->set('t3', 't3');
		echo 't1: ' . $mem->get('t1') . '<br />';
		echo 't2: ' . $mem->get('t2') . '<br />';
		echo 't3: ' . $mem->get('t3') . '<br />';
		
		for ($i = 0; $i < 10000; $i++)
		{
			//$mem->set('user_username_' . $i, 'user' . $i);
			//$mem->set('user_password_' . $i, 'password' . $i);
			//$mem->set('user_logintime_' . $i, date('Y-m-d H:i:s'));
			
			$mem->get('user_username_' . $i);
			$mem->get('user_password_' . $i);
			$mem->get('user_logintime_' . $i);
		}
		
		echo 'user_username_900: ' . $mem->get('user_username_900') . '<br />';
		echo 'user_password_900: ' . $mem->get('user_password_900') . '<br />';
		echo 'user_logintime_900: ' . $mem->get('user_logintime_900') . '<br />';
		
		$mem->close();
	}
	
	public function test_mysql()
	{
		$this->db->connect();
		$tb_user = Config::$tb_user;
		$kk = '';
		$count = 0;
		
		/*
		$this->db->query("SELECT * FROM $tb_user WHERE id=50");
		for ($i = 0; $i < 1000; $i++)
		{
			$sql_rand = "'" . rand(0, 100) . "'";
			//$this->db->query("SELECT * FROM $tb_user WHERE id=$i");
			$this->db->query("INSERT INTO $tb_user (username, email, link, realname, register_time) VALUES ($sql_rand, 'email$i', 'link$i', 'realname$i', '2014-5-16')");
			//$this->db->query("SELECT * FROM $tb_user WHERE id=$sql_rand");
			//$res = $this->db->get_row();
			//$kk = $res['username'];
		}
		*/
		
		
		$this->db->query("SELECT * FROM $tb_user LIMIT 0, 10000");
		$res = $this->db->get_all_rows();
		foreach ($res as $key => $value)
		{
			$temp = $value['username'];
			$count++;
		}
		
		
		$this->db->query("SELECT count(*) AS num FROM $tb_user");
		$res = $this->db->get_row();
		
		echo '$count: ' . $count . '<br />';
		echo '$kk: ' . $kk . '<br />';
		echo '$num: ' . $res['num'] . '<br />';
		echo 'time: ' . Debug::runtime() . '<br />';
	}
	
	public function test_for()
	{
		$arr = array();
		for ($i = 0; $i < 100000; $i++)
		{
			$rnd = $i;
			$arr['_' . $rnd . $i] = '' . $rnd . $i;
		}
		echo $arr['_' . $rnd . ($i - 1)] . '<br />';
		
		echo '<br />time: ' . Debug::runtime();
	}
}
?>
