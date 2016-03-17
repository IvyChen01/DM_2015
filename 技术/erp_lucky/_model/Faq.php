<?php
/**
 *	答题
 */
class Faq
{
	private $db = null;//数据库
	private $tb_jiang_chi = '';//奖池表
	private $tb_zhong_jiang = '';//中奖表
	private $tb_faq = '';//题目表
	private $tb_faq_daily = '';//每日答题表
	private $tb_user = '';//每日答题表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_jiang_chi = Config::$tb_jiang_chi;
		$this->tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->tb_faq = Config::$tb_faq;
		$this->tb_faq_daily = Config::$tb_faq_daily;
		$this->tb_user = Config::$tb_user;
	}
	
	/**
	 * 获取题目
	 */
	public function get_faq()
	{
		$session_faq = $this->get_session_faq();
		if (!empty($session_faq))
		{
			return $session_faq;
		}
		
		$this->db->connect();
		///////////// change
		//取[第三个月]的题目
		$this->db->query("SELECT * FROM $this->tb_faq WHERE month_type=3");
		$res = $this->db->get_all_rows();
		$faq = array();
		
		if (!empty($res))
		{
			$res_count = count($res);
			if ($res_count < 4)
			{
				return null;
			}
			//随机打乱题目顺序
			for ($i = 0; $i < $res_count; $i++)
			{
				$rand = rand(0, $res_count - 1);
				$temp = $res[$i];
				$res[$i] = $res[$rand];
				$res[$rand] = $temp;
			}
			
			//选取4题给用户回答
			for ($i = 0; $i < 4; $i++)
			{
				$faq[$i] = $res[$i];
			}
			$this->set_faq_answer(array(
				'q1' => array('id' => $faq[0]['id'], 'answer' => $faq[0]['answer']), 
				'q2' => array('id' => $faq[1]['id'], 'answer' => $faq[1]['answer']), 
				'q3' => array('id' => $faq[2]['id'], 'answer' => $faq[2]['answer']), 
				'q4' => array('id' => $faq[3]['id'], 'answer' => $faq[3]['answer'])));
			$this->set_session_faq($faq);
			return $faq;
		}
		
		return null;
	}
	
	/**
	 * 判断回答是否正确
	 */
	public function check_answer($answer)
	{
		//////////// debug
		//return array('code' => 0);
		
		
		//系统答案
		$session_answer = $this->get_faq_answer();
		if (empty($session_answer))
		{
			return array('code' => 2);
		}
		$s1 = '' . (isset($session_answer['q1']['answer']) ? $session_answer['q1']['answer'] : '');
		$s2 = '' . (isset($session_answer['q2']['answer']) ? $session_answer['q2']['answer'] : '');
		$s3 = '' . (isset($session_answer['q3']['answer']) ? $session_answer['q3']['answer'] : '');
		$s4 = '' . (isset($session_answer['q4']['answer']) ? $session_answer['q4']['answer'] : '');
		
		//用户回答的答案
		if (empty($answer))
		{
			return array('code' => 1, 'q1' => 0, 'q2' => 0, 'q3' => 0, 'q4' => 0);
		}
		
		$answer = json_decode($answer, true);
		if (!empty($answer) && is_array($answer))
		{
			$q1 = '' . (isset($answer['p1']) ? $answer['p1'] : '');
			$q2 = '' . (isset($answer['p2']) ? $answer['p2'] : '');
			$q3 = '' . (isset($answer['p3']) ? $answer['p3'] : '');
			$q4 = '' . (isset($answer['p4']) ? $answer['p4'] : '');
		}
		else
		{
			return array('code' => 1, 'q1' => 0, 'q2' => 0, 'q3' => 0, 'q4' => 0);
		}
		
		if (!empty($s1) && $s1 == $q1 &&
			!empty($s2) && $s2 == $q2 &&
			!empty($s3) && $s3 == $q3 &&
			!empty($s4) && $s4 == $q4)
		{
			return array('code' => 0);
		}
		else
		{
			$c1 = 0;
			$c2 = 0;
			$c3 = 0;
			$c4 = 0;
			if (!empty($s1) && $s1 == $q1)
			{
				$c1 = 1;
			}
			if (!empty($s2) && $s2 == $q2)
			{
				$c2 = 1;
			}
			if (!empty($s3) && $s3 == $q3)
			{
				$c3 = 1;
			}
			if (!empty($s4) && $s4 == $q4)
			{
				$c4 = 1;
			}
			
			return array('code' => 1, 'q1' => $c1, 'q2' => $c2, 'q3' => $c3, 'q4' => $c4);
		}
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($user_id)
	{
		$this->db->connect();
		$sql_date = Security::sql_var(date('Y-m-d'));
		$this->db->query("SELECT * FROM $this->tb_jiang_chi WHERE prize_date=$sql_date");
		$res = $this->db->get_row();
		
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//检测是否中过大奖，中过大奖则不再中大奖
				if ($this->check_big_prize($user_id))
				{
					//组合奖品id，不含大奖
					$prize_arr = array_merge(
						$this->join_prize(3, $res['prize3']),
						$this->join_prize(4, $res['prize4']),
						$this->join_prize(5, $res['prize5']),
						$this->join_prize(6, $res['prize6']),
						$this->join_prize(7, $res['prize7']),
						$this->join_prize(8, $res['prize8']),
						$this->join_prize(9, $res['prize9']),
						$this->join_prize(10, $res['prize10'])
					);
				}
				else
				{
					//组合奖品id，含大奖
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
				}
				
				//判断当天奖池中是否还有奖品
				$prize_arr_count = count($prize_arr);
				if ($prize_arr_count > 0)
				{
					$prize_index = rand(0, $prize_arr_count - 1);
					$prize_id = $prize_arr[$prize_index];
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduce_jiang_chi($res['id'], $prize_id);
					$this->save_lucky($user_id, $prize_id);
					
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
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$sql_id = (int)$jiang_chi_id;
			$field_name = 'prize' . $prize_id;
			$this->db->query("UPDATE $this->tb_jiang_chi SET $field_name=$field_name-1 WHERE id=$sql_id");
		}
	}
	
	/**
	 * 记录当前题目的答案
	 */
	private function set_faq_answer($value)
	{
		$_SESSION[Config::$system_name . '_faq_answer'] = $value;
	}
	
	/**
	 * 获取当前题目的答案
	 */
	private function get_faq_answer()
	{
		return isset($_SESSION[Config::$system_name . '_faq_answer']) ? $_SESSION[Config::$system_name . '_faq_answer'] : null;
	}
	
	/**
	 * 获取当前题目编号
	 */
	public function get_faq_id()
	{
		$faq = isset($_SESSION[Config::$system_name . '_faq_answer']) ? $_SESSION[Config::$system_name . '_faq_answer'] : null;
		if (!empty($faq))
		{
			return $faq['q1']['id'] . ',' . $faq['q2']['id'] . ',' . $faq['q3']['id'] . ',' . $faq['q4']['id'];
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * 检测今天是否答过题
	 */
	public function check_faq_today($userid)
	{
		//////// debug
		//return false;
		
		$this->db->connect();
		$sql_userid = (int)$userid;
		$sql_date = Security::sql_var(date('Y-m-d'));
		$this->db->query("SELECT * FROM $this->tb_faq_daily WHERE user_id=$sql_userid AND date_format(faq_time, '%Y-%m-%d')=$sql_date");
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
	
	/**
	 * 检测是否中过大奖
	 */
	private function check_big_prize($userid)
	{
		$this->db->connect();
		$sql_userid = (int)$userid;
		$this->db->query("SELECT * FROM $this->tb_zhong_jiang WHERE user_id=$sql_userid AND (prize_id=1 OR prize_id=2)");
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
	
	/**
	 * 保存答题数据
	 */
	public function save_answer($user_id, $answer, $score)
	{
		$this->db->connect();
		$sql_user_id = (int)$user_id;
		$sql_answer = Security::sql_var($answer);
		$sql_score = (int)$score;
		$sql_time = Security::sql_var(date('Y-m-d H:i:s'));
		$this->db->query("INSERT INTO $this->tb_faq_daily (user_id, faq_answer, score, faq_time) VALUES ($sql_user_id, $sql_answer, $sql_score, $sql_time)");
	}
	
	/**
	 * 保存中奖数据
	 */
	private function save_lucky($user_id, $prize_id)
	{
		if ($prize_id >= 1 && $prize_id <= Config::$max_prize)
		{
			$this->db->connect();
			$sql_user_id = (int)$user_id;
			$sql_prize_id = (int)$prize_id;
			$sql_prize_name = Security::sql_var(Config::$prize_name[$prize_id - 1]);
			$sql_time = Security::sql_var(date('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $this->tb_zhong_jiang (user_id, prize_id, prize_name, prize_time) VALUES ($sql_user_id, $sql_prize_id, $sql_prize_name, $sql_time)");
		}
	}
	
	/**
	 * 中奖名单
	 */
	public function get_lucky_list()
	{
		$this->db->connect();
		$this->db->query("SELECT t1.prize_name AS prize_name, date_format(t1.prize_time, '%Y-%m-%d') AS prize_time, t2.username AS username, t2.jobnum AS jobnum FROM $this->tb_zhong_jiang AS t1 LEFT JOIN $this->tb_user AS t2 ON t1.user_id=t2.id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	private function set_session_faq($value)
	{
		$_SESSION[Config::$system_name . '_faq'] = $value;
	}
	
	private function get_session_faq()
	{
		return isset($_SESSION[Config::$system_name . '_faq']) ? $_SESSION[Config::$system_name . '_faq'] : null;
	}
	
	public function get_faq_daily()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_faq_daily ORDER BY id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
	
	public function get_zhong_jiang()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_zhong_jiang ORDER BY id");
		$res = $this->db->get_all_rows();
		
		return $res;
	}
}
?>
