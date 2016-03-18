<?php
/**
 *	抽奖
 */
class Lucky
{
	private $db = null;//数据库
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function check_lucky_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_lucky_daily WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return array(true, $res['pan_flag']);
		}
		else
		{
			return array(false, 0);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	public function set_lucky_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
		$this->db->query("insert into $tb_lucky_daily (openid, lucky_time, pan_flag) values ($sql_openid, $sql_date, 0)");
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openid)
	{
		$this->set_lucky_today($openid);
		if ($this->check_is_win($openid))
		{
			return 0;
		}
		
		$this->db->connect();
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_jiang_chi WHERE prize_date=$sql_date");
		$res = $this->db->get_row();
		
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
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduce_jiang_chi($res['id'], $prize_id);
					$this->save_lucky($openid, $prize_id);
					
					return $prize_id;
				}
			}
		}
		
		return 0;
	}
	
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
	
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduce_jiang_chi($jiang_chi_id, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_jiang_chi = Config::$tb_jiang_chi;
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $tb_jiang_chi SET $field_name=$field_name-1 WHERE id=$sql_id");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function save_lucky($openid, $prize_id)
	{
		$prize_id = (int)$prize_id;
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$tb_zhong_jiang = Config::$tb_zhong_jiang;
			$sql_openid = Security::var_sql($openid);
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::var_sql(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::var_sql(Utils::mdate('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $tb_zhong_jiang (openid, prizeid, prizename, lucky_time) VALUES ($sql_openid, $sql_prize_id, $sql_prize_name, $sql_time)");
		}
	}
	
	/**
	 * 保存中奖用户信息
	 */
	public function save_win_userinfo($openid, $department, $username)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_department = Security::var_sql($department);
		$sql_username = Security::var_sql($username);
		$this->db->query("update $tb_zhong_jiang set department=$sql_department, username=$sql_username where openid=$sql_openid");
	}
	
	public function check_is_win($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid");
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
	
	public function check_is_win_today($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
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
	
	public function get_userinfo_today($openid)
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_zhong_jiang WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if (!empty($res['department']) && !empty($res['username']))
			{
				return array(true, $res['department'], $res['username'], (int)$res['prizeid']);
			}
			else
			{
				return array(false, '', '', (int)$res['prizeid']);
			}
		}
		else
		{
			return array(false, '', '', 0);
		}
	}
	
	public function get_daily()
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$this->db->query("SELECT * FROM $tb_lucky_daily order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_zhong_jiang()
	{
		$this->db->connect();
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->db->query("SELECT * FROM $tb_zhong_jiang order by id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function check_pan_today($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("SELECT * FROM $tb_lucky_daily WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			if (1 == $res['pan_flag'])
			{
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
	
	public function set_pan_click($openid)
	{
		$this->db->connect();
		$tb_lucky_daily = Config::$tb_lucky_daily;
		$sql_openid = Security::var_sql($openid);
		$sql_date = Security::var_sql(Utils::mdate('Y-m-d'));
		$this->db->query("update $tb_lucky_daily set pan_flag=1 WHERE openid=$sql_openid AND date_format(lucky_time, '%Y-%m-%d')=$sql_date");
	}
}
?>
