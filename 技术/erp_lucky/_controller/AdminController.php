<?php
/**
 * 管理后台控制器
 */
class AdminController
{
	private $admin = null;//管理员模型
	private $install = null;//安装模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->install = new Install();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		switch ($action)
		{
			case 'login':
				$this->login();
				return;
			default:
		}
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'main':
					$this->main();
					return;
				case 'show_change_password':
					$this->show_change_password();
					return;
				case 'change_password':
					$this->change_password();
					return;
				case 'make_index_html':
					$this->make_index_html();
					return;
				case 'logout':
					$this->logout();
					return;
				case 'db':
					$this->db();
					return;
				case 'db_user':
					$this->db_user();
					return;
				case 'db_jiang_chi':
					$this->db_jiang_chi();
					return;
				case 'db_zhong_jiang':
					$this->db_zhong_jiang();
					return;
				case 'db_faq':
					$this->db_faq();
					return;
				case 'db_faq_daily':
					$this->db_faq_daily();
					return;
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					return;
					$this->recover();
					return;
				case 'db_select':
					$this->db_select();
					return;
				case 'upgrade':
					//return;
					$this->upgrade();
					return;
				case 'install':
					return;
					$this->install();
					return;
				case 'install_user':
					return;
					$this->install_user();
					return;
				case 'install_faq':
					return;
					$this->install_faq();
					return;
				case 'install_jiang_chi':
					return;
					$this->install_jiang_chi();
					return;
				default:
					$this->main();
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	/**
	 * 登录
	 */
	private function login()
	{
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if (empty($username) || empty($password))
		{
			System::echo_data(2, '用户名和密码不能为空！');
		}
		else
		{
			if ($this->admin->login($username, $password))
			{
				System::echo_data(0, '登录成功！');
			}
			else
			{
				System::echo_data(1, '用户名或密码错误！');
			}
		}
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		include('view/admin/main.php');
	}
	
	/**
	 * 显示修改密码页
	 */
	private function show_change_password()
	{
		include('view/admin/change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function change_password()
	{
		$src_password = isset($_POST['src_password']) ? $_POST['src_password'] : '';
		$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
		if (empty($src_password) || empty($new_password))
		{
			System::echo_data(1, '原密码和新密码不能为空！');
			return;
		}
		if ($this->admin->check_password($src_password))
		{
			$this->admin->change_password($new_password);
			$this->admin->logout();
			System::echo_data(0, '修改成功！');
		}
		else
		{
			System::echo_data(2, '原密码错误！');
		}
	}
	
	/**
	 * 生成首页静态页
	 */
	private function make_index_html()
	{
		//System::make_index_html();
		echo 'ok';
	}
	
	/**
	 * 退出登录
	 */
	private function logout()
	{
		$this->admin->logout();
		$this->show_login();
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$all_tables = $this->install->get_all_tables();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 查看用户表数据
	 */
	private function db_user()
	{
		$all_tables = $this->install->get_user_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 查看奖池表数据
	 */
	private function db_jiang_chi()
	{
		$all_tables = $this->install->get_jiang_chi_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 查看中奖表数据
	 */
	private function db_zhong_jiang()
	{
		$all_tables = $this->install->get_zhong_jiang_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 查看题目表数据
	 */
	private function db_faq()
	{
		$all_tables = $this->install->get_faq_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 查看每日答题表数据
	 */
	private function db_faq_daily()
	{
		$all_tables = $this->install->get_faq_daily_table();
		$_table_list = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_table_list[] = $table_info;
		}
		include('view/admin/db.php');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		$this->install->backup();
		echo 'ok';
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		$this->install->recover();
		echo 'ok';
	}
	
	/**
	 * 查看数据
	 */
	private function db_select()
	{
		echo '<meta charset="utf-8">';
		$this->install->db_select();
		echo '<br />ok';
	}
	
	/**
	 * 升级系统
	 */
	private function upgrade()
	{
		$this->install->upgrade();
		echo 'ok';
	}
	
	/**
	 * 安装系统
	 */
	private function install()
	{
		$this->install->install();
		echo 'ok';
	}
	
	private function install_user()
	{
		$install = new InstallUser();
		$install->install();
		echo 'ok';
	}
	
	private function install_faq()
	{
		$install = new InstallFaq();
		$install->install();
		echo 'ok';
	}
	
	private function install_jiang_chi()
	{
		$install = new InstallLucky();
		$install->install();
		echo 'ok';
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function show_login()
	{
		include('view/admin/login.php');
	}
}
?>
