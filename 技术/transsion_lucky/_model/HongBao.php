<?php
/**
 *	抢红包
 */
class HongBao
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($jobnum, $username, $department, $openid)
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_hb_jiang_chi WHERE prize_date=$sql_date");
		$res = $this->db->get_row();
		$new_prize = 0;
		
		$max_prize = $this->get_max_prize($jobnum);
		$new_prize = $max_prize;
		
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//组合奖品id
				$prize_arr = array_merge(
					$this->join_prize(1, $res['prize1']),
					$this->join_prize(2, $res['prize2']),
					$this->join_prize(3, $res['prize3']),
					$this->join_prize(4, $res['prize4']),
					$this->join_prize(5, $res['prize5']),
					$this->join_prize(6, $res['prize6']),
					$this->join_prize(7, $res['prize7']),
					$this->join_prize(8, $res['prize8']),
					$this->join_prize(9, $res['prize9']),
					$this->join_prize(10, $res['prize10'])
				);
				
				//判断当天奖池中是否还有奖品
				$prize_arr_count = count($prize_arr);
				if ($prize_arr_count > 0)
				{
					$prize_index = rand(0, $prize_arr_count - 1);
					$prize_id = $prize_arr[$prize_index];
					
					if (0 == $max_prize)
					{
						//减少奖池中对应的奖品，保存中奖数据
						$this->reduce_jiang_chi($res['id'], $prize_id);
						$this->save_lucky($jobnum, $username, $department, $openid, $prize_id);
						$new_prize = $prize_id;
						$this->set_lucky_today($jobnum, Config::$prize_money[$prize_id - 1]);
						
						return Config::$prize_money[$prize_id - 1];
					}
					else
					{
						if ($prize_id < $max_prize)
						{
							$this->reduce_jiang_chi($res['id'], $prize_id);
							$this->add_jiang_chi($res['id'], $max_prize);
							$this->change_lucky($jobnum, $prize_id);
							$new_prize = $prize_id;
							$this->set_lucky_today($jobnum, Config::$prize_money[$prize_id - 1]);
							
							return Config::$prize_money[$prize_id - 1];
						}
					}
				}
			}
		}
		
		if (0 == $new_prize)
		{
			$this->set_lucky_today($jobnum, 0);
			return 0;
		}
		else
		{
			$money = Config::$prize_money[$new_prize - 1];
			$low_money = rand(0, $money);
			$this->set_lucky_today($jobnum, $low_money);
			return $low_money;
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function set_lucky_today($jobnum, $money)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_money = (int)$money;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$this->db->query("insert into $tb_hb_lucky_daily (jobnum, money, lucky_time, click_flag) values ($sql_jobnum, $sql_money, $sql_date, 0)");
	}
	
	// ok
	/**
	 * 组合奖品
	 */
	private function join_prize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		
		return $res;
	}
	
	// ok
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduce_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_hb_jiang_chi SET $field_name=$field_name-1 WHERE id=$sql_id");
		}
	}
	
	// ok
	/**
	 * 增加奖池里指定的奖品数量
	 */
	private function add_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_hb_jiang_chi SET $field_name=$field_name+1 WHERE id=$sql_id");
		}
	}
	
	private function get_max_prize($jobnum)
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$sql_jobnum = Security::var_sql($jobnum);
		$this->db->query("select * from $tb_hb_zhong_jiang where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return $res['prizeid'];
		}
		else
		{
			return 0;
		}
	}
	
	public function get_max_money($jobnum)
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$sql_jobnum = Security::var_sql($jobnum);
		$this->db->query("select * from $tb_hb_zhong_jiang where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if ($res['prizeid'] >= 1 && $res['prizeid'] <= Config::$max_prize)
			{
				return Config::$prize_money[$res['prizeid'] - 1];
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function save_lucky($jobnum, $username, $department, $openid, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
			$sql_jobnum = Security::var_sql($jobnum);
			$sql_username = Security::var_sql($username);
			$sql_department = Security::var_sql($department);
			$sql_openid = Security::var_sql($openid);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $tb_hb_zhong_jiang (jobnum, username, department, openid, prizeid, prizename, lucky_time) VALUES ($sql_jobnum, $sql_username, $sql_department, $sql_openid, $sql_prize_id, $sql_prize_name, $sql_time)");
		}
	}
	
	/**
	 * 修改中奖数据
	 */
	private function change_lucky($jobnum, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
			$sql_jobnum = Security::var_sql($jobnum);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("update $tb_hb_zhong_jiang set prizeid=$sql_prize_id, prizename=$sql_prize_name, lucky_time=$sql_time where jobnum=$sql_jobnum");
		}
	}
	
	// ok
	public function set_pan_click($jobnum)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("update $tb_hb_lucky_daily set click_flag=1 WHERE jobnum=$sql_jobnum AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
	}
	
	// ok
	public function get_bind_user_info($openid)
	{
		$this->db->connect();
		$sql_openid = Security::var_sql($openid);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where openid=$sql_openid");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('jobnum' => $res['jobnum'], 'username' => $res['username'], 'department' => $res['department']);
		}
		else
		{
			return null;
		}
	}
	
	// ok
	public function get_base_user_info($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_base_user = Config::$tb_hb_base_user;
		$this->db->query("select * from $tb_hb_base_user where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('jobnum' => $res['jobnum'], 'username' => $res['username'], 'department' => $res['department']);
		}
		else
		{
			return null;
		}
	}
	
	// ok
	public function check_bind_jobnum($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where jobnum=$sql_jobnum");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// ok
	public function check_bind_openid($openid)
	{
		$this->db->connect();
		$sql_openid = Security::var_sql($openid);
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("select * from $tb_hb_bind_user where openid=$sql_openid");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// ok
	public function bind_jobnum($jobnum, $username, $department, $openid)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_username = Security::var_sql($username);
		$sql_department = Security::var_sql($department);
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$this->db->query("insert into $tb_hb_bind_user (jobnum, username, department, openid, register_time) values ($sql_jobnum, $sql_username, $sql_department, $sql_openid, $sql_date)");
	}
	
	// ok
	/**
	 * 获取今天的抽奖数据
	 */
	public function get_lucky_today($jobnum)
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$sql_jobnum = Security::var_sql($jobnum);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily WHERE jobnum=$sql_jobnum AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array('is_lucky' => true, 'click_flag' => $res['click_flag'], 'money' => $res['money']);
		}
		else
		{
			return array('is_lucky' => false, 'click_flag' => 0, 'money' => 0);
		}
	}
	
	public function get_records($jobnum)
	{
		$this->db->connect();
		$sql_jobnum = Security::var_sql($jobnum);
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily where jobnum=$sql_jobnum order by id");
		$res = $this->db->get_all_rows();
		$records = array('d1' => -1, 'd2' => -1, 'd3' => -1, 'd4' => -1, 'd5' => -1, 'd6' => -1);
		
		if (!empty($res))
		{
			foreach ($res as $row)
			{
				$date = Utils::mdate('Y-m-d', $row['lucky_time']);
				switch ($date)
				{
					case '2015-02-03':
						$records['d1'] = $row['money'];
						break;
					case '2015-02-04':
						$records['d2'] = $row['money'];
						break;
					case '2015-02-05':
						$records['d3'] = $row['money'];
						break;
					case '2015-02-06':
						$records['d4'] = $row['money'];
						break;
					case '2015-02-07':
						$records['d5'] = $row['money'];
						break;
					case '2015-02-08':
						$records['d6'] = $row['money'];
						break;
					default:
				}
			}
		}
		
		return $records;
	}
	
	public function get_daily()
	{
		$this->db->connect();
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_hb_lucky_daily order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_zhong_jiang()
	{
		$this->db->connect();
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$this->db->query("SELECT * FROM $tb_hb_zhong_jiang order by department, prizeid desc");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
}
?>
