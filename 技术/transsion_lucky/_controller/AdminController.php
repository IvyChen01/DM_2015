<?php
/**
 * 管理后台控制器
 */
class AdminController
{
	private $admin = null;//管理员模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'verify':
				$this->verify();
				return;
			case 'do_login':
				$this->do_login();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'change_password':
					$this->change_password();
					return;
				case 'do_change_password':
					$this->do_change_password();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'log':
					$this->log();
					return;
				case 'clear_log':
					$this->clear_log();
					return;
				case 'db':
					$this->db();
					return;
				case 'db2':
					$this->db2();
					return;
				case 'db_daily':
					$this->db_daily();
					return;
				case 'db_zhong_jiang':
					$this->db_zhong_jiang();
					return;
				case 'db_jiang_chi':
					$this->db_jiang_chi();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					$this->recover();
					return;
				case 'upgrade':
					$this->upgrade();
					return;
				case 'install':
					return;
					$this->install();
					return;
				case 'upload_image':
					$this->upload_image();
					return;
				case 'upload_jq_image':
					$this->upload_jq_image();
					return;
				case 'sum_prize':
					$this->sum_prize();
					return;
				case 'init_prize':
					$this->init_prize();
					return;
				case 'winlist':
					$this->winlist();
					return;
				case 'lucky_count':
					$this->lucky_count();
					return;
				case 'install_hong_bao':
					return;
					$this->install_hong_bao();
					return;
				case 'db3':
					$this->db3();
					return;
				case 'hong_bao_count':
					$this->hong_bao_count();
					return;
				case 'hong_bao_winlist':
					$this->hong_bao_winlist();
					return;
				default:
					$this->main();
			}
		}
		else
		{
			$this->login();
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->admin->get_verify();
	}
	
	/**
	 * 登录
	 */
	private function do_login()
	{
		$username = Security::var_post('username');
		$password = Security::var_post('password');
		$verify = Security::var_post('verify');
		
		if ($this->admin->check_verify($verify))
		{
			if (!empty($username) && !empty($password))
			{
				if ($this->admin->login($username, $password))
				{
					Utils::echo_data(0, '登录成功！');
				}
				else
				{
					Utils::echo_data(1, '用户名或密码不正确！');
				}
			}
			else
			{
				Utils::echo_data(2, '用户名和密码不能为空！');
			}
		}
		else
		{
			Utils::echo_data(3, '验证码不正确！');
		}
	}
	
	/**
	 * 显示修改密码页
	 */
	private function change_password()
	{
		include('view/admin/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function do_change_password()
	{
		$src_password = Security::var_post('src_password');
		$new_password = Security::var_post('new_password');
		if (!empty($src_password) && !empty($new_password))
		{
			if ($this->admin->check_password($src_password))
			{
				$this->admin->change_password($new_password);
				$this->admin->logout();
				Utils::echo_data(0, '修改成功！');
			}
			else
			{
				Utils::echo_data(1, '原密码错误！');
			}
		}
		else
		{
			Utils::echo_data(2, '原密码和新密码不能为空！');
		}
	}
	
	/**
	 * 退出
	 */
	private function logout()
	{
		$this->admin->logout();
		$this->login();
	}
	
	/**
	 * 查看日志
	 */
	private function log()
	{
		$date = Security::var_get('date');
		if (empty($date))
		{
			if (file_exists(Debug::$log_file))
			{
				include(Debug::$log_file);
			}
			else
			{
				echo 'No log!';
			}
		}
		else
		{
			$log_file = Config::$dir_log . Utils::mdate('Y-m-d', $date) . '.php';
			if (file_exists($log_file))
			{
				include($log_file);
			}
			else
			{
				echo 'No log!';
			}
		}
	}
	
	/**
	 * 清空当天日志
	 */
	private function clear_log()
	{
		Debug::clear_log();
		echo 'ok';
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$install = new Install();
		$all_tables = $install->get_all_tables();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db2()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_admin, Config::$tb_user, Config::$tb_jiang_chi, Config::$tb_zhong_jiang, Config::$tb_lucky_daily);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_daily()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_lucky_daily);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_zhong_jiang()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_zhong_jiang);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function db_jiang_chi()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_jiang_chi);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		$install = new Install();
		$install->backup();
		echo 'ok';
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		$install = new Install();
		$install->recover();
		echo 'ok';
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		$install = new Install();
		$install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		$install = new Install();
		$install->install();
		echo 'ok';
	}
	
	/**
	 * 上传图片
	 */
	private function upload_image()
	{
		echo System::upload_image();
	}
	
	/**
	 * 上传JQ图片
	 */
	private function upload_jq_image()
	{
		System::upload_jq_image();
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		include('view/admin/main.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function login()
	{
		include('view/admin/login.php');
	}
	
	private function sum_prize()
	{
		$install = new Install();
		$install->sum_prize();
	}
	
	private function init_prize()
	{
		$install = new Install();
		$install->init_prize();
		echo 'ok';
	}
	
	private function winlist()
	{
		$lucky = new Lucky();
		$zhong_jiang = $lucky->get_zhong_jiang();
		$_jiang_list = array();
		
		foreach ($zhong_jiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_jiang_list[$date]))
			{
				$_jiang_list[$date] = array();
				$_jiang_list[$date]['date'] = $date;
				$_jiang_list[$date]['winner'] = array();
			}
			$_jiang_list[$date]['winner'][] = array('department' => $value['department'], 'username' => $value['username'], 'prizename' => $value['prizename']);
		}
		
		include('view/admin/winlist.php');
	}
	
	private function lucky_count()
	{
		$lucky = new Lucky();
		$daily = $lucky->get_daily();
		$zhong_jiang = $lucky->get_zhong_jiang();
		
		$_day_list = array();
		$_total_lucky = 0;
		$_total_winner = 0;
		$_total_lucky_rate = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
				$_day_list[$date]['winner'] = 0;
				$_day_list[$date]['lucky_rate'] = 0;
			}
			$_day_list[$date]['lucky']++;
			$_total_lucky++;
		}
		
		foreach ($zhong_jiang as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
				$_day_list[$date]['winner'] = 0;
				$_day_list[$date]['lucky_rate'] = 0;
			}
			$_day_list[$date]['winner']++;
			$_total_winner++;
		}
		
		foreach ($_day_list as $value)
		{
			$date = $value['date'];
			$numWinner = $_day_list[$date]['winner'];
			$numLucky = $_day_list[$date]['lucky'];
			if ($numLucky != 0)
			{
				$_day_list[$date]['lucky_rate'] = round($numWinner / $numLucky * 100, 1);
			}
		}
		
		if ($_total_lucky != 0)
		{
			$_total_lucky_rate = round($_total_winner / $_total_lucky * 100, 1);
		}
		
		include('view/admin/lucky_count.php');
	}
	
	private function install_hong_bao()
	{
		$install = new Install();
		$install->install_hong_bao();
		echo 'ok';
	}
	
	private function db3()
	{
		$install = new Install();
		$all_tables = array(Config::$tb_hb_jiang_chi, Config::$tb_hb_zhong_jiang, Config::$tb_hb_lucky_daily, Config::$tb_hb_bind_user, Config::$tb_hb_base_user);
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $install->get_all_fields($tb_name);
			$table_info['records'] = $install->get_records($tb_name, 0, 1100);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	private function hong_bao_count()
	{
		$hong_bao = new HongBao();
		$daily = $hong_bao->get_daily();
		$_day_list = array();
		$_total_lucky = 0;
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_time']);
			if (!isset($_day_list[$date]))
			{
				$_day_list[$date] = array();
				$_day_list[$date]['date'] = $date;
				$_day_list[$date]['lucky'] = 0;
			}
			$_day_list[$date]['lucky']++;
			$_total_lucky++;
		}
		
		include('view/admin/hong_bao_count.php');
	}
	
	private function hong_bao_winlist()
	{
		$hong_bao = new HongBao();
		$zhong_jiang = $hong_bao->get_zhong_jiang();
		$_jiang_list = array();
		
		foreach ($zhong_jiang as $value)
		{
			$_jiang_list[] = array('jobnum' => $value['jobnum'], 'username' => $value['username'], 'department' => $value['department'], 'prizename' => $value['prizename']);
		}
		
		include('view/admin/hong_bao_winlist.php');
	}
}
?>
