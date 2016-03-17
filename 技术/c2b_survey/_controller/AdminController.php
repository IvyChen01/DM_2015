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
				case 'show_admin':
					$this->show_admin();
					return;
				case 'logout':
					$this->logout();
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
				case 'backup':
					$this->backup();
					return;
				case 'recover':
					$this->recover();
					return;
				case 'db':
					$this->db();
					return;
				case 'log':
					$this->log();
					return;
				case 'user':
					$this->show_user();
					return;
				case 'upgrade':
					$install = new Install();
					$install->upgrade();
					echo 'ok';
					return;
				case 'reset':
					$install = new Install();
					$install->install();
					echo 'ok';
					return;
				case 'count':
					$this->count_data();
					return;
				case 'fill':
					$this->fill_data();
					return;
				case 'list':
					$this->list_data();
					return;
				case 'excel':
					$this->excel();
					return;
				case 'check0':
					$this->check0();
					return;
				case 'check1':
					$this->check1();
					return;
				case 'fix1':
					$this->fix1();
					return;
				case 'check2':
					$this->check2();
					return;
				case 'fix2':
					$this->fix2();
					return;
				case 'check3':
					$this->check3();
					return;
				case 'fix3':
					$this->fix3();
					return;
				case 'check4':
					$this->check4();
					return;
				case 'fix4':
					$this->fix4();
					return;
				case 'check5':
					$this->check5();
					return;
				case 'fix5':
					$this->fix5();
					return;
				case 'check6':
					$this->check6();
					return;
				case 'fix6':
					$this->fix6();
					return;
				case 'check7':
					$this->check7();
					return;
				case 'fix7':
					$this->fix7();
					return;
				case 'check8':
					$this->check8();
					return;
				case 'fix8':
					$this->fix8();
					return;
				case 'check9':
					$this->check9();
					return;
				case 'fix9':
					$this->fix9();
					return;
				case 'check10':
					$this->check10();
					return;
				case 'fix10':
					$this->fix10();
					return;
				case 'check11':
					$this->check11();
					return;
				case 'fix11':
					$this->fix11();
					return;
				case 'check12':
					$this->check12();
					return;
				case 'fix12':
					$this->fix12();
					return;
				case 'check13':
					$this->check13();
					return;
				case 'fix13':
					$this->fix13();
					return;
				case 'check14':
					$this->check14();
					return;
				case 'fix14':
					$this->fix14();
					return;
				case 'check15':
					$this->check15();
					return;
				case 'fix15':
					$this->fix15();
					return;
				case 'check16':
					$this->check16();
					return;
				case 'fix16':
					$this->fix16();
					return;
				case 'check17':
					$this->check17();
					return;
				case 'fix17':
					$this->fix17();
					return;
				case 'check18':
					$this->check18();
					return;
				case 'fix18':
					$this->fix18();
					return;
				case 'check19':
					$this->check19();
					return;
				case 'fix19':
					$this->fix19();
					return;
				case 'check20':
					$this->check20();
					return;
				case 'fix20':
					$this->fix20();
					return;
				case 'check21':
					$this->check21();
					return;
				case 'fix21':
					$this->fix21();
					return;
				case 'check22':
					$this->check22();
					return;
				case 'fix22':
					$this->fix22();
					return;
				case 'check23':
					$this->check23();
					return;
				case 'fix23':
					$this->fix23();
					return;
				case 'check24':
					$this->check24();
					return;
				case 'fix24':
					$this->fix24();
					return;
				case 'check25':
					$this->check25();
					return;
				case 'fix25':
					$this->fix25();
					return;
				case 'check26':
					$this->check26();
					return;
				case 'fix26':
					$this->fix26();
					return;
				case 'check27':
					$this->check27();
					return;
				case 'fix27':
					$this->fix27();
					return;
				case 'check28':
					$this->check28();
					return;
				case 'fix28':
					$this->fix28();
					return;
				case 'check29':
					$this->check29();
					return;
				case 'fix29':
					$this->fix29();
					return;
				case 'check30':
					$this->check30();
					return;
				case 'fix30':
					$this->fix30();
					return;
				case 'check31':
					$this->check31();
					return;
				case 'fix31':
					$this->fix31();
					return;
				case 'check32':
					$this->check32();
					return;
				case 'fix32':
					$this->fix32();
					return;
				case 'lucky':
					$this->lucky();
					return;
				case 'list_lucky':
					$this->list_lucky();
					return;
				case 'excel_lucky':
					$this->excel_lucky();
					return;
				default:
					$this->show_admin();
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
			$is_succeed = $this->admin->login($username, $password);
			if ($is_succeed)
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
	 * 显示管理页
	 */
	private function show_admin()
	{
		$_['log_date'] = date('Y-m-d');
		include('view/admin_main.php');
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
	 * 显示修改密码页
	 */
	private function show_change_password()
	{
		include('view/admin_change_password.php');
	}
	
	/**
	 * 修改密码
	 */
	private function change_password()
	{
		$src_password = isset($_POST['src_password']) ? $_POST['src_password'] : '';
		$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
		if (empty($src_password))
		{
			System::echo_data(2, '原密码不能为空！');
			return;
		}
		if (empty($new_password))
		{
			System::echo_data(3, '新密码不能为空！');
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
			System::echo_data(1, '原密码错误！');
		}
	}
	
	/**
	 * 生成首页静态页
	 */
	private function make_index_html()
	{
		//System::make_index_html();
		$this->show_admin();
		Utils::show_message('更新完成！');
	}
	
	/**
	 * 备份数据库
	 */
	private function backup()
	{
		$this->install->backup();
		$this->show_admin();
		Utils::show_message('备份完成！');
	}
	
	/**
	 * 恢复数据库
	 */
	private function recover()
	{
		$this->install->recover();
		$this->show_admin();
		Utils::show_message('恢复完成！');
	}
	
	/**
	 * 查看数据库数据
	 */
	private function db()
	{
		$all_tables = $this->install->get_all_tables();
		$_['table_list'] = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name, 0, 10000);
			$_['table_list'][] = $table_info;
		}
		include('view/admin_db.php');
	}
	
	/**
	 * 查看日志文件
	 */
	private function log()
	{
		$log_date = isset($_GET['b']) ? $_GET['b'] : '';
		if (!empty($log_date))
		{
			$_['log_file'] = Config::$dir_log . $log_date . '.php';
		}
		else
		{
			$_['log_file'] = Config::$dir_log . date('Y-m-d') . '.php';
		}
		include('view/admin_log.php');
	}
	
	/**
	 * 查看数据库数据
	 */
	private function show_user()
	{
		$all_tables = $this->install->get_user_table();
		$_['table_list'] = array();
		foreach ($all_tables as $tb_name)
		{
			$table_info = array();
			$table_info['tbname'] = $tb_name;
			$table_info['fields'] = $this->install->get_all_fields($tb_name);
			$table_info['records'] = $this->install->get_records($tb_name);
			$_['table_list'][] = $table_info;
		}
		include('view/admin_user.php');
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function show_login()
	{
		include('view/admin_login.php');
	}
	
	/**
	 * 显示统计数据
	 */
	private function count_data()
	{
		$_phone_type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
		if ($_phone_type < 0 || $_phone_type >= Config::$type_count - 1)
		{
			exit('Error');
		}
		
		$_phone_name = $this->get_phone_type($_phone_type);
		
		$_all_count = 0;
		$_type_count = array(0, 0, 0, 0, 0);
		$_question_count = array();
		
		//初始化统计人数为0
		for ($type_index = 0; $type_index < Config::$type_count; $type_index++)
		{
			$_question_count[$type_index] = array();
			for ($question_index = 0; $question_index < Config::$question_count; $question_index++)
			{
				for ($option_index = 0; $option_index < Config::$option_count[$question_index]; $option_index++)
				{
					$_question_count[$type_index]['question' . ($question_index + 1) . '_' . ($option_index + 1)] = 0;
				}
			}
		}
		
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$_all_count = $res['count'];
		$all_answer = $res['data'];
		
		//遍历所有答题，统计各题目选项人数
		for ($type_index = 0; $type_index < Config::$type_count; $type_index++)
		{
			for ($question_index = 0; $question_index < Config::$question_count; $question_index++)
			{
				for ($option_index = 0; $option_index < Config::$option_count[$question_index]; $option_index++)
				{
					foreach ($all_answer as $answer_key => $answer_value)
					{
						if (('' . $answer_value['question1']) == ('' . $type_index) && $this->in_str($option_index, $answer_value['question' . ($question_index + 1)]))
						{
							$_question_count[$type_index]['question' . ($question_index + 1) . '_' . ($option_index + 1)]++;
						}
					}
				}
			}
		}
		
		$_answer_num = $_question_count[$_phone_type];
		switch ($_phone_type)
		{
			case 0:
				include('view/admin_count_data0.php');
				break;
			case 1:
				include('view/admin_count_data1.php');
				break;
			case 2:
				include('view/admin_count_data2.php');
				break;
			case 3:
				include('view/admin_count_data3.php');
				break;
			default:
		}
		echo '<br />time: ' . Debug::runtime() . '<br /><br />';
	}
	
	private function get_phone_type($value)
	{
		switch ($value)
		{
			case 0:
				return 'TECNO Phantom A+ (F7+)';
			case 1:
				return 'TECNO P5';
			case 2:
				return 'Other TECNO smartphone (Android phone)';
			case 3:
				return 'Other TECNO phone (Not smartphone/ not Android phone)';
			default:
				return 'Other Brand\'s phone';
		}
	}
	
	private function in_str($src_str, $arr_str)
	{
		$arr = explode(',' , $arr_str);
		foreach ($arr as $key => $value)
		{
			if (('' . $src_str) == ('' . $value))
			{
				return true;
			}
		}
		
		return false;
	}
	
	private function count_str($arr_str)
	{
		$arr = explode(',' , $arr_str);
		
		return count($arr);
	}
	
	private function fill_data()
	{
		$phone_type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
		$_question_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		if ($phone_type < 0 || $phone_type >= Config::$type_count - 1)
		{
			exit('Error');
		}
		if ($_question_id < 1 || $_question_id > Config::$question_count)
		{
			exit('Error');
		}
		
		$faq = new Faq();
		$answer = $faq->get_answer_by_type($phone_type);
		
		$_fill_data = array();
		$_month_avg = 0;
		if ($_question_id == 14)
		{
			$month_index = 0;
			$month_sum = 0;
			foreach ($answer as $key => $value)
			{
				if (!empty($value['question' . $_question_id]))
				{
					$_fill_data[] = array('fbid' => $value['fbid'], 'answer' => $value['question' . $_question_id]);
					$month_index++;
					$month_sum += (int)$value['question' . $_question_id];
				}
			}
			if ($month_index != 0)
			{
				$_month_avg = $month_sum / $month_index;
			}
		}
		else
		{
			foreach ($answer as $key => $value)
			{
				if (!empty($value['question' . $_question_id . '_fill']))
				{
					$_fill_data[] = array('fbid' => $value['fbid'], 'answer' => $value['question' . $_question_id . '_fill']);
				}
			}
		}
		
		include('view/admin_count_fill.php');
		echo '<br />time: ' . Debug::runtime() . '<br /><br />';
	}
	
	private function list_data()
	{
		$faq = new Faq();
		$res = $faq->get_list_data();
		$_all_count = $res['count'];
		$_all_answer = $res['data'];
		include('view/admin_list_data.php');
		echo '<br />time: ' . Debug::runtime() . '<br /><br />';
	}
	
	private function excel()
	{
		require_once('Classes/PHPExcel.php');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator("Administrators")
			->setLastModifiedBy("Administrators")
			->setTitle("C2BSurvey")
			->setSubject("")
			->setDescription("")
			->setKeywords("")
			->setCategory("");
		
		$excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'fbid')
			->setCellValue('B1', 'name')
			->setCellValue('C1', 'email')
			->setCellValue('D1', 'gender')
			->setCellValue('E1', 'locale')
			->setCellValue('F1', 'Q1')
			->setCellValue('G1', 'Q2')
			->setCellValue('H1', 'Q3')
			->setCellValue('I1', 'Q3_fill')
			->setCellValue('J1', 'Q4')
			->setCellValue('K1', 'Q4_fill')
			->setCellValue('L1', 'Q5')
			->setCellValue('M1', 'Q5_fill')
			->setCellValue('N1', 'Q6')
			->setCellValue('O1', 'Q6_fill')
			->setCellValue('P1', 'Q7')
			->setCellValue('Q1', 'Q7_fill')
			->setCellValue('R1', 'Q8')
			->setCellValue('S1', 'Q8_fill')
			->setCellValue('T1', 'Q9')
			->setCellValue('U1', 'Q10')
			->setCellValue('V1', 'Q10_fill')
			->setCellValue('W1', 'Q11')
			->setCellValue('X1', 'Q11_fill')
			->setCellValue('Y1', 'Q12')
			->setCellValue('Z1', 'Q12_fill')
			->setCellValue('AA1', 'Q13')
			->setCellValue('AB1', 'Q14')
			->setCellValue('AC1', 'Q15')
			->setCellValue('AD1', 'Q16')
			->setCellValue('AE1', 'lucky_code')
			->setCellValue('AF1', 'time');
		
		$faq = new Faq();
		$res = $faq->get_list_data();
		$all_count = $res['count'];
		$all_answer = $res['data'];
		$temp_i = 2;
		foreach ($all_answer as $key => $value)
		{
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . $temp_i, "'" . $value['fbid'])
				->setCellValue('B' . $temp_i, $value['username'])
				->setCellValue('C' . $temp_i, $value['email'])
				->setCellValue('D' . $temp_i, $value['gender'])
				->setCellValue('E' . $temp_i, $value['locale'])
				->setCellValue('F' . $temp_i, $value['question1'])
				->setCellValue('G' . $temp_i, $value['question2'])
				->setCellValue('H' . $temp_i, $value['question3'])
				->setCellValue('I' . $temp_i, $value['question3_fill'])
				->setCellValue('J' . $temp_i, $value['question4'])
				->setCellValue('K' . $temp_i, $value['question4_fill'])
				->setCellValue('L' . $temp_i, $value['question5'])
				->setCellValue('M' . $temp_i, $value['question5_fill'])
				->setCellValue('N' . $temp_i, $value['question6'])
				->setCellValue('O' . $temp_i, $value['question6_fill'])
				->setCellValue('P' . $temp_i, $value['question7'])
				->setCellValue('Q' . $temp_i, $value['question7_fill'])
				->setCellValue('R' . $temp_i, $value['question8'])
				->setCellValue('S' . $temp_i, $value['question8_fill'])
				->setCellValue('T' . $temp_i, $value['question9'])
				->setCellValue('U' . $temp_i, $value['question10'])
				->setCellValue('V' . $temp_i, $value['question10_fill'])
				->setCellValue('W' . $temp_i, $value['question11'])
				->setCellValue('X' . $temp_i, $value['question11_fill'])
				->setCellValue('Y' . $temp_i, $value['question12'])
				->setCellValue('Z' . $temp_i, $value['question12_fill'])
				->setCellValue('AA' . $temp_i, $value['question13'])
				->setCellValue('AB' . $temp_i, $value['question14'])
				->setCellValue('AC' . $temp_i, $value['question15'])
				->setCellValue('AD' . $temp_i, $value['question16'])
				->setCellValue('AE' . $temp_i, $value['lucky_code'])
				->setCellValue('AF' . $temp_i, $value['do_time']);
			$temp_i++;
		}
		
		resheader('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="C2BSurvey.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expi: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	private function check0()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question1'] == '4')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function check1()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question1'] == '3')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix1()
	{
		$faq = new Faq();
		//$faq->fix1();
		echo 'ok';
	}
	
	private function check2()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question1'] == '2')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix2()
	{
		$faq = new Faq();
		//$faq->fix2();
		echo 'ok';
	}
	
	private function check3()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question2'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix3()
	{
		$faq = new Faq();
		//$faq->fix3();
		echo 'ok';
	}
	
	private function check4()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question1'] != '3') && ('' . $value['question3'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix4()
	{
		$faq = new Faq();
		//$faq->fix4();
		echo 'ok';
	}
	
	private function check5()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question3'] == '16')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix5()
	{
		$faq = new Faq();
		//$faq->fix5();
		echo 'ok';
	}
	
	private function check6()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question13'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix6()
	{
		$faq = new Faq();
		//$faq->fix6();
		echo 'ok';
	}
	
	private function check7()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question15'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix7()
	{
		$faq = new Faq();
		//$faq->fix7();
		echo 'ok';
	}
	
	private function check8()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question15'] == '0') && ('' . $value['question16'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix8()
	{
		$faq = new Faq();
		//$faq->fix8();
		echo 'ok';
	}
	
	private function check9()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] != '4') && ('' . $value['question15'] == '1') && ('' . $value['question16'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix9()
	{
		$faq = new Faq();
		//$faq->fix9();
		echo 'ok';
	}
	
	private function check10()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question3_fill'] != '') && !$this->in_str('15', $value['question3']))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix10()
	{
		$faq = new Faq();
		//$faq->fix10();
		echo 'ok';
	}
	
	private function check11()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question4_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix11()
	{
		$faq = new Faq();
		//$faq->fix11();
		echo 'ok';
	}
	
	private function check12()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question5_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix12()
	{
		$faq = new Faq();
		//$faq->fix12();
		echo 'ok';
	}
	
	private function check13()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question6_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix13()
	{
		$faq = new Faq();
		//$faq->fix13();
		echo 'ok';
	}
	
	private function check14()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question7_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix14()
	{
		$faq = new Faq();
		//$faq->fix14();
		echo 'ok';
	}
	
	private function check15()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question8_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix15()
	{
		$faq = new Faq();
		//$faq->fix15();
		echo 'ok';
	}
	
	private function check16()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question10_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix16()
	{
		$faq = new Faq();
		//$faq->fix16();
		echo 'ok';
	}
	
	private function check17()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question11_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix17()
	{
		$faq = new Faq();
		//$faq->fix17();
		echo 'ok';
	}
	
	private function check18()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ('' . $value['question12_fill'] != '')
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix18()
	{
		$faq = new Faq();
		//$faq->fix18();
		echo 'ok';
	}
	
	private function check19()
	{
		
	}
	
	private function fix19()
	{
		$faq = new Faq();
		//$faq->fix19();
		echo 'ok';
	}
	
	private function check20()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('3', $value['question3']) && ('' . $value['question5'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix20()
	{
		$faq = new Faq();
		//$faq->fix20();
		echo 'ok';
	}
	
	private function check21()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('4', $value['question3']) && ('' . $value['question6'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix21()
	{
		$faq = new Faq();
		//$faq->fix21();
		echo 'ok';
	}
	
	private function check22()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('5', $value['question3']) && ('' . $value['question7'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix22()
	{
		$faq = new Faq();
		//$faq->fix22();
		echo 'ok';
	}
	
	private function check23()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('6', $value['question3']) && ('' . $value['question8'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix23()
	{
		$faq = new Faq();
		//$faq->fix23();
		echo 'ok';
	}
	
	private function check24()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('7', $value['question3']) && ('' . $value['question10'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix24()
	{
		$faq = new Faq();
		//$faq->fix24();
		echo 'ok';
	}
	
	private function check25()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('9', $value['question3']) && ('' . $value['question9'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix25()
	{
		$faq = new Faq();
		//$faq->fix25();
		echo 'ok';
	}
	
	private function check26()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('10', $value['question3']) && ('' . $value['question11'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix26()
	{
		$faq = new Faq();
		//$faq->fix26();
		echo 'ok';
	}
	
	private function check27()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (!$this->in_str('14', $value['question3']) && ('' . $value['question12'] != ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix27()
	{
		$faq = new Faq();
		//$faq->fix27();
		echo 'ok';
	}
	
	private function check28()
	{
		
	}
	
	private function fix28()
	{
		$faq = new Faq();
		//$faq->fix28();
		echo 'ok';
	}
	
	private function check29()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (('' . $value['question1'] == '0') || ('' . $value['question1'] == '1'))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix29()
	{
		$faq = new Faq();
		//$faq->fix29();
		echo 'ok';
	}
	
	private function check30()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (($this->count_str($value['question3']) > 3) && ($value['question4'] == ''))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix30()
	{
		$faq = new Faq();
		//$faq->fix30();
		echo 'ok';
	}
	
	private function check31()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if (($this->count_str($value['question3']) <= 3) && ($value['question4'] != '') && ($this->count_str($value['question4']) > 0))
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix31()
	{
		$faq = new Faq();
		//$faq->fix31();
		echo 'ok';
	}
	
	private function check32()
	{
		$faq = new Faq();
		$res = $faq->get_all_answer();
		$all_answer = $res['data'];
		$_data = array();
		$_count = 0;
		foreach ($all_answer as $key => $value)
		{
			if ($this->count_str($value['question4']) > 3)
			{
				$_data[] = $value;
				$_count++;
			}
		}
		$_fields = $this->install->get_all_fields(Config::$tb_answer);
		include('view/admin_check.php');
	}
	
	private function fix32()
	{
		$faq = new Faq();
		//$faq->fix32();
		echo 'ok';
	}
	
	private function lucky()
	{
		$faq = new Faq();
		//$faq->lucky();
		echo '<br />time: ' . Debug::runtime() . '<br /><br />';
	}
	
	private function list_lucky()
	{
		$faq = new Faq();
		$_data = $faq->list_lucky();
		include('view/admin_lucky.php');
	}
	
	private function excel_lucky()
	{
		require_once('Classes/PHPExcel.php');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator("Administrators")
			->setLastModifiedBy("Administrators")
			->setTitle("C2BSurvey")
			->setSubject("")
			->setDescription("")
			->setKeywords("")
			->setCategory("");
		
		$excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'id')
			->setCellValue('B1', 'fbid')
			->setCellValue('C1', 'name')
			->setCellValue('D1', 'email')
			->setCellValue('E1', 'gender')
			->setCellValue('F1', 'locale')
			->setCellValue('G1', 'type')
			->setCellValue('H1', 'lucky_code');
		
		$faq = new Faq();
		$data = $faq->list_lucky();
		$temp_i = 2;
		foreach ($data as $key => $value)
		{
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . $temp_i, $temp_i - 1)
				->setCellValue('B' . $temp_i, "'" . $value['fbid'])
				->setCellValue('C' . $temp_i, $value['username'])
				->setCellValue('D' . $temp_i, $value['email'])
				->setCellValue('E' . $temp_i, $value['gender'])
				->setCellValue('F' . $temp_i, $value['locale'])
				->setCellValue('G' . $temp_i, $value['type'])
				->setCellValue('H' . $temp_i, $value['lucky_code']);
			$temp_i++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="C2BSurvey_lucky.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$objWriter->save('php://output');
	}
}
?>
