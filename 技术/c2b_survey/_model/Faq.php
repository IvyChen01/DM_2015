<?php
/**
 *	答题操作
 */
class Faq
{
	private $db = null;//数据库
	private $tb_answer = '';//答题表
	private $tb_count = '';//统计表
	private $tb_user = '';
	private $tb_lucky = '';
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->tb_answer = Config::$tb_answer;
		$this->tb_count = Config::$tb_count;
		$this->tb_user = Config::$tb_user;
		$this->tb_lucky = Config::$tb_lucky;
	}
	
	public function answer($fbid, $answer)
	{
		$answer_arr = json_decode($answer, true);
		if (!empty($answer_arr) && is_array($answer_arr))
		{
			if ($this->check_answer_error($answer_arr))
			{
				$this->db->connect();
				$phone_type = $this->get_phone_type($answer_arr);
				$answer_count = $this->get_answer_count();
				$lucky_code = $this->get_lucky_code($answer_count);
				$this->save_count($answer_arr, $phone_type);
				$this->save_answer($fbid, $answer_arr, $lucky_code, $phone_type);
				
				return true;
			}
		}
		return false;
	}
	
	private function check_answer_error($answer)
	{
		return true;
	}
	
	private function get_answer_count()
	{
		$count = 0;
		$this->db->connect();
		$this->db->query("SELECT answer_count FROM $this->tb_count");
		$res = $this->db->get_all_rows();
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				$count += $value['answer_count'];
			}
		}
		
		return $count;
	}
	
	private function save_count($answer, $phone_type)
	{
		if (!in_array($phone_type, array('0', '1', '2', '3')))
		{
			$this->db->query("UPDATE $this->tb_count SET answer_count = answer_count + 1 WHERE id=5");
			return;
		}
		
		$sql_id = (int)$phone_type + 1;
		$sql_question2_1 = 'question2_1';
		$sql_question2_2 = 'question2_2';
		$sql_question2_3 = 'question2_3';
		$sql_question2_4 = 'question2_4';
		$sql_question2_5 = 'question2_5';
		$sql_question2_6 = 'question2_6';
		$sql_question3_1 = 'question3_1';
		$sql_question3_2 = 'question3_2';
		$sql_question3_3 = 'question3_3';
		$sql_question3_4 = 'question3_4';
		$sql_question3_5 = 'question3_5';
		$sql_question3_6 = 'question3_6';
		$sql_question3_7 = 'question3_7';
		$sql_question3_8 = 'question3_8';
		$sql_question3_9 = 'question3_9';
		$sql_question3_10 = 'question3_10';
		$sql_question3_11 = 'question3_11';
		$sql_question3_12 = 'question3_12';
		$sql_question3_13 = 'question3_13';
		$sql_question3_14 = 'question3_14';
		$sql_question3_15 = 'question3_15';
		$sql_question3_16 = 'question3_16';
		$sql_question3_17 = 'question3_17';
		$sql_question4_1 = 'question4_1';
		$sql_question4_2 = 'question4_2';
		$sql_question4_3 = 'question4_3';
		$sql_question4_4 = 'question4_4';
		$sql_question4_5 = 'question4_5';
		$sql_question4_6 = 'question4_6';
		$sql_question4_7 = 'question4_7';
		$sql_question4_8 = 'question4_8';
		$sql_question4_9 = 'question4_9';
		$sql_question4_10 = 'question4_10';
		$sql_question4_11 = 'question4_11';
		$sql_question4_12 = 'question4_12';
		$sql_question4_13 = 'question4_13';
		$sql_question4_14 = 'question4_14';
		$sql_question4_15 = 'question4_15';
		$sql_question4_16 = 'question4_16';
		$sql_question4_17 = 'question4_17';
		$sql_question5_1 = 'question5_1';
		$sql_question5_2 = 'question5_2';
		$sql_question5_3 = 'question5_3';
		$sql_question5_4 = 'question5_4';
		$sql_question5_5 = 'question5_5';
		$sql_question5_6 = 'question5_6';
		$sql_question5_7 = 'question5_7';
		$sql_question5_8 = 'question5_8';
		$sql_question5_9 = 'question5_9';
		$sql_question5_10 = 'question5_10';
		$sql_question5_11 = 'question5_11';
		$sql_question5_12 = 'question5_12';
		$sql_question5_13 = 'question5_13';
		$sql_question6_1 = 'question6_1';
		$sql_question6_2 = 'question6_2';
		$sql_question6_3 = 'question6_3';
		$sql_question6_4 = 'question6_4';
		$sql_question6_5 = 'question6_5';
		$sql_question6_6 = 'question6_6';
		$sql_question7_1 = 'question7_1';
		$sql_question7_2 = 'question7_2';
		$sql_question7_3 = 'question7_3';
		$sql_question7_4 = 'question7_4';
		$sql_question7_5 = 'question7_5';
		$sql_question7_6 = 'question7_6';
		$sql_question7_7 = 'question7_7';
		$sql_question7_8 = 'question7_8';
		$sql_question7_9 = 'question7_9';
		$sql_question7_10 = 'question7_10';
		$sql_question7_11 = 'question7_11';
		$sql_question7_12 = 'question7_12';
		$sql_question7_13 = 'question7_13';
		$sql_question7_14 = 'question7_14';
		$sql_question7_15 = 'question7_15';
		$sql_question7_16 = 'question7_16';
		$sql_question7_17 = 'question7_17';
		$sql_question7_18 = 'question7_18';
		$sql_question7_19 = 'question7_19';
		$sql_question7_20 = 'question7_20';
		$sql_question8_1 = 'question8_1';
		$sql_question8_2 = 'question8_2';
		$sql_question8_3 = 'question8_3';
		$sql_question8_4 = 'question8_4';
		$sql_question8_5 = 'question8_5';
		$sql_question8_6 = 'question8_6';
		$sql_question8_7 = 'question8_7';
		$sql_question8_8 = 'question8_8';
		$sql_question8_9 = 'question8_9';
		$sql_question8_10 = 'question8_10';
		$sql_question8_11 = 'question8_11';
		$sql_question8_12 = 'question8_12';
		$sql_question8_13 = 'question8_13';
		$sql_question8_14 = 'question8_14';
		$sql_question8_15 = 'question8_15';
		$sql_question8_16 = 'question8_16';
		$sql_question8_17 = 'question8_17';
		$sql_question8_18 = 'question8_18';
		$sql_question8_19 = 'question8_19';
		$sql_question8_20 = 'question8_20';
		$sql_question9_1 = 'question9_1';
		$sql_question9_2 = 'question9_2';
		$sql_question9_3 = 'question9_3';
		$sql_question9_4 = 'question9_4';
		$sql_question9_5 = 'question9_5';
		$sql_question9_6 = 'question9_6';
		$sql_question9_7 = 'question9_7';
		$sql_question9_8 = 'question9_8';
		$sql_question9_9 = 'question9_9';
		$sql_question9_10 = 'question9_10';
		$sql_question9_11 = 'question9_11';
		$sql_question9_12 = 'question9_12';
		$sql_question9_13 = 'question9_13';
		$sql_question10_1 = 'question10_1';
		$sql_question10_2 = 'question10_2';
		$sql_question10_3 = 'question10_3';
		$sql_question10_4 = 'question10_4';
		$sql_question10_5 = 'question10_5';
		$sql_question10_6 = 'question10_6';
		$sql_question10_7 = 'question10_7';
		$sql_question10_8 = 'question10_8';
		$sql_question10_9 = 'question10_9';
		$sql_question10_10 = 'question10_10';
		$sql_question10_11 = 'question10_11';
		$sql_question10_12 = 'question10_12';
		$sql_question11_1 = 'question11_1';
		$sql_question11_2 = 'question11_2';
		$sql_question11_3 = 'question11_3';
		$sql_question11_4 = 'question11_4';
		$sql_question11_5 = 'question11_5';
		$sql_question11_6 = 'question11_6';
		$sql_question12_1 = 'question12_1';
		$sql_question12_2 = 'question12_2';
		$sql_question12_3 = 'question12_3';
		$sql_question12_4 = 'question12_4';
		$sql_question13_1 = 'question13_1';
		$sql_question13_2 = 'question13_2';
		$sql_question15_1 = 'question15_1';
		$sql_question15_2 = 'question15_2';
		$sql_question16_1 = 'question16_1';
		$sql_question16_2 = 'question16_2';
		$sql_question16_3 = 'question16_3';
		$sql_question16_4 = 'question16_4';
		$sql_question16_5 = 'question16_5';
		$sql_question16_6 = 'question16_6';
		
		foreach ($answer as $key => $value)
		{
			switch ($value['id'])
			{
				case 2:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question2_1 = 'question2_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question2_2 = 'question2_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question2_3 = 'question2_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question2_4 = 'question2_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question2_5 = 'question2_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question2_6 = 'question2_6+1';
					}
					break;
				case 3:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question3_1 = 'question3_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question3_2 = 'question3_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question3_3 = 'question3_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question3_4 = 'question3_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question3_5 = 'question3_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question3_6 = 'question3_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question3_7 = 'question3_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question3_8 = 'question3_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question3_9 = 'question3_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question3_10 = 'question3_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question3_11 = 'question3_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question3_12 = 'question3_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question3_13 = 'question3_13+1';
					}
					if ($this->check_contain_value($value['answer'], 13))
					{
						$sql_question3_14 = 'question3_14+1';
					}
					if ($this->check_contain_value($value['answer'], 14))
					{
						$sql_question3_15 = 'question3_15+1';
					}
					if ($this->check_contain_value($value['answer'], 15))
					{
						$sql_question3_16 = 'question3_16+1';
					}
					if ($this->check_contain_value($value['answer'], 16))
					{
						$sql_question3_17 = 'question3_17+1';
					}
					break;
				case 4:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question4_1 = 'question4_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question4_2 = 'question4_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question4_3 = 'question4_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question4_4 = 'question4_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question4_5 = 'question4_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question4_6 = 'question4_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question4_7 = 'question4_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question4_8 = 'question4_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question4_9 = 'question4_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question4_10 = 'question4_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question4_11 = 'question4_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question4_12 = 'question4_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question4_13 = 'question4_13+1';
					}
					if ($this->check_contain_value($value['answer'], 13))
					{
						$sql_question4_14 = 'question4_14+1';
					}
					if ($this->check_contain_value($value['answer'], 14))
					{
						$sql_question4_15 = 'question4_15+1';
					}
					if ($this->check_contain_value($value['answer'], 15))
					{
						$sql_question4_16 = 'question4_16+1';
					}
					if ($this->check_contain_value($value['answer'], 16))
					{
						$sql_question4_17 = 'question4_17+1';
					}
					break;
				case 5:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question5_1 = 'question5_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question5_2 = 'question5_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question5_3 = 'question5_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question5_4 = 'question5_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question5_5 = 'question5_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question5_6 = 'question5_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question5_7 = 'question5_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question5_8 = 'question5_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question5_9 = 'question5_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question5_10 = 'question5_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question5_11 = 'question5_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question5_12 = 'question5_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question5_13 = 'question5_13+1';
					}
					break;
				case 6:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question6_1 = 'question6_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question6_2 = 'question6_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question6_3 = 'question6_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question6_4 = 'question6_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question6_5 = 'question6_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question6_6 = 'question6_6+1';
					}
					break;
				case 7:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question7_1 = 'question7_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question7_2 = 'question7_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question7_3 = 'question7_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question7_4 = 'question7_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question7_5 = 'question7_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question7_6 = 'question7_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question7_7 = 'question7_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question7_8 = 'question7_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question7_9 = 'question7_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question7_10 = 'question7_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question7_11 = 'question7_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question7_12 = 'question7_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question7_13 = 'question7_13+1';
					}
					if ($this->check_contain_value($value['answer'], 13))
					{
						$sql_question7_14 = 'question7_14+1';
					}
					if ($this->check_contain_value($value['answer'], 14))
					{
						$sql_question7_15 = 'question7_15+1';
					}
					if ($this->check_contain_value($value['answer'], 15))
					{
						$sql_question7_16 = 'question7_16+1';
					}
					if ($this->check_contain_value($value['answer'], 16))
					{
						$sql_question7_17 = 'question7_17+1';
					}
					if ($this->check_contain_value($value['answer'], 17))
					{
						$sql_question7_18 = 'question7_18+1';
					}
					if ($this->check_contain_value($value['answer'], 18))
					{
						$sql_question7_19 = 'question7_19+1';
					}
					if ($this->check_contain_value($value['answer'], 19))
					{
						$sql_question7_20 = 'question7_20+1';
					}
					break;
				case 8:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question8_1 = 'question8_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question8_2 = 'question8_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question8_3 = 'question8_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question8_4 = 'question8_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question8_5 = 'question8_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question8_6 = 'question8_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question8_7 = 'question8_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question8_8 = 'question8_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question8_9 = 'question8_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question8_10 = 'question8_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question8_11 = 'question8_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question8_12 = 'question8_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question8_13 = 'question8_13+1';
					}
					if ($this->check_contain_value($value['answer'], 13))
					{
						$sql_question8_14 = 'question8_14+1';
					}
					if ($this->check_contain_value($value['answer'], 14))
					{
						$sql_question8_15 = 'question8_15+1';
					}
					if ($this->check_contain_value($value['answer'], 15))
					{
						$sql_question8_16 = 'question8_16+1';
					}
					if ($this->check_contain_value($value['answer'], 16))
					{
						$sql_question8_17 = 'question8_17+1';
					}
					if ($this->check_contain_value($value['answer'], 17))
					{
						$sql_question8_18 = 'question8_18+1';
					}
					if ($this->check_contain_value($value['answer'], 18))
					{
						$sql_question8_19 = 'question8_19+1';
					}
					if ($this->check_contain_value($value['answer'], 19))
					{
						$sql_question8_20 = 'question8_20+1';
					}
					break;
				case 9:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question9_1 = 'question9_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question9_2 = 'question9_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question9_3 = 'question9_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question9_4 = 'question9_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question9_5 = 'question9_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question9_6 = 'question9_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question9_7 = 'question9_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question9_8 = 'question9_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question9_9 = 'question9_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question9_10 = 'question9_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question9_11 = 'question9_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question9_12 = 'question9_12+1';
					}
					if ($this->check_contain_value($value['answer'], 12))
					{
						$sql_question9_13 = 'question9_13+1';
					}
					break;
				case 10:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question10_1 = 'question10_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question10_2 = 'question10_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question10_3 = 'question10_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question10_4 = 'question10_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question10_5 = 'question10_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question10_6 = 'question10_6+1';
					}
					if ($this->check_contain_value($value['answer'], 6))
					{
						$sql_question10_7 = 'question10_7+1';
					}
					if ($this->check_contain_value($value['answer'], 7))
					{
						$sql_question10_8 = 'question10_8+1';
					}
					if ($this->check_contain_value($value['answer'], 8))
					{
						$sql_question10_9 = 'question10_9+1';
					}
					if ($this->check_contain_value($value['answer'], 9))
					{
						$sql_question10_10 = 'question10_10+1';
					}
					if ($this->check_contain_value($value['answer'], 10))
					{
						$sql_question10_11 = 'question10_11+1';
					}
					if ($this->check_contain_value($value['answer'], 11))
					{
						$sql_question10_12 = 'question10_12+1';
					}
					break;
				case 11:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question11_1 = 'question11_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question11_2 = 'question11_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question11_3 = 'question11_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question11_4 = 'question11_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question11_5 = 'question11_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question11_6 = 'question11_6+1';
					}
					break;
				case 12:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question12_1 = 'question12_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question12_2 = 'question12_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question12_3 = 'question12_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question12_4 = 'question12_4+1';
					}
					break;
				case 13:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question13_1 = 'question13_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question13_2 = 'question13_2+1';
					}
					break;
				case 15:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question15_1 = 'question15_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question15_2 = 'question15_2+1';
					}
					break;
				case 16:
					if ($this->check_contain_value($value['answer'], 0))
					{
						$sql_question16_1 = 'question16_1+1';
					}
					if ($this->check_contain_value($value['answer'], 1))
					{
						$sql_question16_2 = 'question16_2+1';
					}
					if ($this->check_contain_value($value['answer'], 2))
					{
						$sql_question16_3 = 'question16_3+1';
					}
					if ($this->check_contain_value($value['answer'], 3))
					{
						$sql_question16_4 = 'question16_4+1';
					}
					if ($this->check_contain_value($value['answer'], 4))
					{
						$sql_question16_5 = 'question16_5+1';
					}
					if ($this->check_contain_value($value['answer'], 5))
					{
						$sql_question16_6 = 'question16_6+1';
					}
					break;
				default:
			}
		}
		
		$sql_count = "UPDATE $this->tb_count SET 
			answer_count = answer_count + 1,
			question2_1 = $sql_question2_1,
			question2_2 = $sql_question2_2,
			question2_3 = $sql_question2_3,
			question2_4 = $sql_question2_4,
			question2_5 = $sql_question2_5,
			question2_6 = $sql_question2_6,
			question3_1 = $sql_question3_1,
			question3_2 = $sql_question3_2,
			question3_3 = $sql_question3_3,
			question3_4 = $sql_question3_4,
			question3_5 = $sql_question3_5,
			question3_6 = $sql_question3_6,
			question3_7 = $sql_question3_7,
			question3_8 = $sql_question3_8,
			question3_9 = $sql_question3_9,
			question3_10 = $sql_question3_10,
			question3_11 = $sql_question3_11,
			question3_12 = $sql_question3_12,
			question3_13 = $sql_question3_13,
			question3_14 = $sql_question3_14,
			question3_15 = $sql_question3_15,
			question3_16 = $sql_question3_16,
			question3_17 = $sql_question3_17,
			question4_1 = $sql_question4_1,
			question4_2 = $sql_question4_2,
			question4_3 = $sql_question4_3,
			question4_4 = $sql_question4_4,
			question4_5 = $sql_question4_5,
			question4_6 = $sql_question4_6,
			question4_7 = $sql_question4_7,
			question4_8 = $sql_question4_8,
			question4_9 = $sql_question4_9,
			question4_10 = $sql_question4_10,
			question4_11 = $sql_question4_11,
			question4_12 = $sql_question4_12,
			question4_13 = $sql_question4_13,
			question4_14 = $sql_question4_14,
			question4_15 = $sql_question4_15,
			question4_16 = $sql_question4_16,
			question4_17 = $sql_question4_17,
			question5_1 = $sql_question5_1,
			question5_2 = $sql_question5_2,
			question5_3 = $sql_question5_3,
			question5_4 = $sql_question5_4,
			question5_5 = $sql_question5_5,
			question5_6 = $sql_question5_6,
			question5_7 = $sql_question5_7,
			question5_8 = $sql_question5_8,
			question5_9 = $sql_question5_9,
			question5_10 = $sql_question5_10,
			question5_11 = $sql_question5_11,
			question5_12 = $sql_question5_12,
			question5_13 = $sql_question5_13,
			question6_1 = $sql_question6_1,
			question6_2 = $sql_question6_2,
			question6_3 = $sql_question6_3,
			question6_4 = $sql_question6_4,
			question6_5 = $sql_question6_5,
			question6_6 = $sql_question6_6,
			question7_1 = $sql_question7_1,
			question7_2 = $sql_question7_2,
			question7_3 = $sql_question7_3,
			question7_4 = $sql_question7_4,
			question7_5 = $sql_question7_5,
			question7_6 = $sql_question7_6,
			question7_7 = $sql_question7_7,
			question7_8 = $sql_question7_8,
			question7_9 = $sql_question7_9,
			question7_10 = $sql_question7_10,
			question7_11 = $sql_question7_11,
			question7_12 = $sql_question7_12,
			question7_13 = $sql_question7_13,
			question7_14 = $sql_question7_14,
			question7_15 = $sql_question7_15,
			question7_16 = $sql_question7_16,
			question7_17 = $sql_question7_17,
			question7_18 = $sql_question7_18,
			question7_19 = $sql_question7_19,
			question7_20 = $sql_question7_20,
			question8_1 = $sql_question8_1,
			question8_2 = $sql_question8_2,
			question8_3 = $sql_question8_3,
			question8_4 = $sql_question8_4,
			question8_5 = $sql_question8_5,
			question8_6 = $sql_question8_6,
			question8_7 = $sql_question8_7,
			question8_8 = $sql_question8_8,
			question8_9 = $sql_question8_9,
			question8_10 = $sql_question8_10,
			question8_11 = $sql_question8_11,
			question8_12 = $sql_question8_12,
			question8_13 = $sql_question8_13,
			question8_14 = $sql_question8_14,
			question8_15 = $sql_question8_15,
			question8_16 = $sql_question8_16,
			question8_17 = $sql_question8_17,
			question8_18 = $sql_question8_18,
			question8_19 = $sql_question8_19,
			question8_20 = $sql_question8_20,
			question9_1 = $sql_question9_1,
			question9_2 = $sql_question9_2,
			question9_3 = $sql_question9_3,
			question9_4 = $sql_question9_4,
			question9_5 = $sql_question9_5,
			question9_6 = $sql_question9_6,
			question9_7 = $sql_question9_7,
			question9_8 = $sql_question9_8,
			question9_9 = $sql_question9_9,
			question9_10 = $sql_question9_10,
			question9_11 = $sql_question9_11,
			question9_12 = $sql_question9_12,
			question9_13 = $sql_question9_13,
			question10_1 = $sql_question10_1,
			question10_2 = $sql_question10_2,
			question10_3 = $sql_question10_3,
			question10_4 = $sql_question10_4,
			question10_5 = $sql_question10_5,
			question10_6 = $sql_question10_6,
			question10_7 = $sql_question10_7,
			question10_8 = $sql_question10_8,
			question10_9 = $sql_question10_9,
			question10_10 = $sql_question10_10,
			question10_11 = $sql_question10_11,
			question10_12 = $sql_question10_12,
			question11_1 = $sql_question11_1,
			question11_2 = $sql_question11_2,
			question11_3 = $sql_question11_3,
			question11_4 = $sql_question11_4,
			question11_5 = $sql_question11_5,
			question11_6 = $sql_question11_6,
			question12_1 = $sql_question12_1,
			question12_2 = $sql_question12_2,
			question12_3 = $sql_question12_3,
			question12_4 = $sql_question12_4,
			question13_1 = $sql_question13_1,
			question13_2 = $sql_question13_2,
			question15_1 = $sql_question15_1,
			question15_2 = $sql_question15_2,
			question16_1 = $sql_question16_1,
			question16_2 = $sql_question16_2,
			question16_3 = $sql_question16_3,
			question16_4 = $sql_question16_4,
			question16_5 = $sql_question16_5,
			question16_6 = $sql_question16_6 
			WHERE id=$sql_id";
			
		$this->db->query($sql_count);
	}
	
	private function check_contain_value($arr, $contain)
	{
		$contain = '' . $contain;
		if (is_array($arr))
		{
			foreach ($arr as $key => $value)
			{
				if ($value == $contain)
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	private function get_phone_type($answer)
	{
		foreach ($answer as $key => $value)
		{
			if ($value['id'] == 1)
			{
				if (is_array($value['answer']))
				{
					return $value['answer'][0];
				}
				
				return '4';
			}
		}
		
		return '4';
	}
	
	private function save_answer($fbid, $answer, $lucky_code, $phone_type)
	{
		if (!in_array($phone_type, array('0', '1', '2', '3')))
		{
			$sql_fbid = Security::sql_var($fbid);
			$sql_lucky_code = Security::sql_var($lucky_code);
			$sql_do_time = Security::sql_var(date('Y-m-d H:i:s'));
			$this->db->query("INSERT INTO $this->tb_answer (fbid, question1, lucky_code, do_time) VALUES ($sql_fbid, '4', $sql_lucky_code, $sql_do_time)");
			return;
		}
		
		$sql_fbid = Security::sql_var($fbid);
		$sql_question1 = Security::sql_var($this->get_answer_by_id($answer, 1));
		$sql_question2 = Security::sql_var($this->get_answer_by_id($answer, 2));
		$sql_question3 = Security::sql_var($this->get_answer_by_id($answer, 3));
		$sql_question3_fill = Security::sql_var($this->get_fill_by_id($answer, 3));
		$sql_question4 = Security::sql_var($this->get_answer_by_id($answer, 4));
		$sql_question4_fill = Security::sql_var($this->get_fill_by_id($answer, 4));
		$sql_question5 = Security::sql_var($this->get_answer_by_id($answer, 5));
		$sql_question5_fill = Security::sql_var($this->get_fill_by_id($answer, 5));
		$sql_question6 = Security::sql_var($this->get_answer_by_id($answer, 6));
		$sql_question6_fill = Security::sql_var($this->get_fill_by_id($answer, 6));
		$sql_question7 = Security::sql_var($this->get_answer_by_id($answer, 7));
		$sql_question7_fill = Security::sql_var($this->get_fill_by_id($answer, 7));
		$sql_question8 = Security::sql_var($this->get_answer_by_id($answer, 8));
		$sql_question8_fill = Security::sql_var($this->get_fill_by_id($answer, 8));
		$sql_question9 = Security::sql_var($this->get_answer_by_id($answer, 9));
		$sql_question10 = Security::sql_var($this->get_answer_by_id($answer, 10));
		$sql_question10_fill = Security::sql_var($this->get_fill_by_id($answer, 10));
		$sql_question11 = Security::sql_var($this->get_answer_by_id($answer, 11));
		$sql_question11_fill = Security::sql_var($this->get_fill_by_id($answer, 11));
		$sql_question12 = Security::sql_var($this->get_answer_by_id($answer, 12));
		$sql_question12_fill = Security::sql_var($this->get_fill_by_id($answer, 12));
		$sql_question13 = Security::sql_var($this->get_answer_by_id($answer, 13));
		$sql_question14 = (int)($this->get_fill_by_id($answer, 14));
		$sql_question15 = Security::sql_var($this->get_answer_by_id($answer, 15));
		$sql_question16 = Security::sql_var($this->get_answer_by_id($answer, 16));
		$sql_lucky_code = Security::sql_var($lucky_code);
		$sql_do_time = Security::sql_var(date('Y-m-d H:i:s'));
		$sql_answer = "INSERT INTO $this->tb_answer (fbid, question1, question2, question3, question3_fill, question4, question4_fill, question5, question5_fill, question6, question6_fill, question7, question7_fill, question8, question8_fill, question9, question10, question10_fill, question11, question11_fill, question12, question12_fill, question13, question14, question15, question16, lucky_code, do_time) VALUES ($sql_fbid, $sql_question1, $sql_question2, $sql_question3, $sql_question3_fill, $sql_question4, $sql_question4_fill, $sql_question5, $sql_question5_fill, $sql_question6, $sql_question6_fill, $sql_question7, $sql_question7_fill, $sql_question8, $sql_question8_fill, $sql_question9, $sql_question10, $sql_question10_fill, $sql_question11, $sql_question11_fill, $sql_question12, $sql_question12_fill, $sql_question13, $sql_question14, $sql_question15, $sql_question16, $sql_lucky_code, $sql_do_time)";
		
		$this->db->query($sql_answer);
	}
	
	private function get_answer_by_id($answer, $id)
	{
		$res = '';
		foreach ($answer as $key => $value)
		{
			if ($value['id'] == $id)
			{
				if (is_array($value['answer']))
				{
					$res = implode(',', $value['answer']);
				}
				
				return $res;
			}
		}
		
		return $res;
	}
	
	private function get_fill_by_id($answer, $id)
	{
		foreach ($answer as $key => $value)
		{
			if ($value['id'] == $id)
			{
				if (isset($value['fill']))
				{
					return $value['fill'];
				}
				return '';
			}
		}
		
		return '';
	}
	
	public function check_answered($fbid)
	{
		$this->db->connect();
		$sql_fbid = Security::sql_var($fbid);
		$this->db->query("SELECT lucky_code, question1 FROM $this->tb_answer WHERE fbid=$sql_fbid");
		$res = $this->db->get_row();
		
		if (empty($res))
		{
			return null;
		}
		else
		{
			$is_tecno = (('' . $res['question1']) == '4' ? false : true);
			
			return array('lucky_code' => $res['lucky_code'], 'is_tecno' => $is_tecno);
		}
	}
	
	public function get_lucky_code($value)
	{
		$value += 1000000;
		$res = '';
		while ($value > 0)
		{
			$x1 = $value % 26;
			$res = chr(65 + $x1) . $res;
			$value = (int)($value / 26);
		}
		
		return chr(65 + rand(0, 25)) . $res;
	}
	
	public function get_all_answer()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_answer");
		$res = $this->db->get_all_rows();
		$count = $this->db->get_num_rows();
		
		return array('count' => $count, 'data' => $res);
	}
	
	public function get_answer_by_type($type)
	{
		$this->db->connect();
		$sql_type = (int)$type;
		$this->db->query("SELECT * FROM $this->tb_answer WHERE question1=$sql_type");
		return $this->db->get_all_rows();
	}
	
	public function get_list_data()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_answer AS t1 LEFT JOIN $this->tb_user AS t2 ON t1.fbid=t2.fbid");
		$res = $this->db->get_all_rows();
		$count = $this->db->get_num_rows();
		
		return array('count' => $count, 'data' => $res);
	}
	
	/*
	public function get_list_data($page)
	{
		$pagesize = Config::$list_pagesize;
		$start = ($page - 1) * $pagesize;
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_answer AS t1 LEFT JOIN $this->tb_user AS t2 ON t1.fbid=t2.fbid LIMIT $start, $pagesize");
		$res = $this->db->get_all_rows();
		$count = $this->db->get_num_rows();
		
		return array('count' => $count, 'data' => $res);
	}
	*/
	
	public function get_answer_count2()
	{
		$this->db->connect();
		$this->db->query("SELECT count(*) AS c1 FROM $this->tb_answer");
		$res = $this->db->get_row();
		if (!empty($res))
		{
			return $res['c1'];
		}
		
		return 0;
	}
	
	public function fix1()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question3='', question3_fill='', question4='', question4_fill='', question5='', question5_fill='', question6='', question6_fill='', question7='', question7_fill='', question8='', question8_fill='', question9='', question10='', question10_fill='', question11='', question11_fill='', question12='', question12_fill='' WHERE question1='3'";
		$this->db->query($sql_answer);
	}
	
	public function fix2()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question5='', question5_fill='', question6='', question6_fill='', question7='', question7_fill='', question8='', question8_fill='', question9='', question10='', question10_fill='', question11='', question11_fill='', question12='', question12_fill='' WHERE question1='2'";
		$this->db->query($sql_answer);
	}
	
	public function fix3()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question2='0' WHERE question1!='4' AND question2=''";
		$this->db->query($sql_answer);
	}
	
	public function fix4()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question3='16' WHERE question1!='4' AND question1!='3' AND question3=''";
		$this->db->query($sql_answer);
	}
	
	public function fix5()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question3_fill='', question4='', question4_fill='', question5='', question5_fill='', question6='', question6_fill='', question7='', question7_fill='', question8='', question8_fill='', question9='', question10='', question10_fill='', question11='', question11_fill='', question12='', question12_fill='' WHERE question3='16'";
		$this->db->query($sql_answer);
	}
	
	public function fix6()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question13='1' WHERE question1!='4' AND question13=''";
		$this->db->query($sql_answer);
	}
	
	public function fix7()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question15='0' WHERE question1!='4' AND question15=''";
		$this->db->query($sql_answer);
	}
	
	public function fix8()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question16='0' WHERE question1!='4' AND question15='0' AND question16=''";
		$this->db->query($sql_answer);
	}
	
	public function fix9()
	{
		$this->db->connect();
		$sql_answer = "UPDATE $this->tb_answer SET question16='' WHERE question1!='4' AND question15='1' AND question16!=''";
		$this->db->query($sql_answer);
	}
	
	public function fix10()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='12,7,5', question3_fill='' WHERE fbid='877771242249555'");
		
		//$this->db->query("UPDATE $this->tb_answer SET question3='5,4,3,12,11,7,9,15' WHERE fbid='904163442942855'");
		
		/*
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='4,15' WHERE fbid='506471342819234'");
		$this->db->query("UPDATE $this->tb_answer SET question3='1,4,3,8,7,12,14,15' WHERE fbid='10202620217010063'");
		$this->db->query("UPDATE $this->tb_answer SET question3='3,15' WHERE fbid='888421611183653'");
		$this->db->query("UPDATE $this->tb_answer SET question3='12,15' WHERE fbid='684375014933347'");
		*/
		
		/*
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='4,15' WHERE fbid='639269436155814'");
		$this->db->query("UPDATE $this->tb_answer SET question3='9,15' WHERE fbid='644928955598632'");
		$this->db->query("UPDATE $this->tb_answer SET question3='1,4,10,12,15' WHERE fbid='10202425570384024'");
		$this->db->query("UPDATE $this->tb_answer SET question3='8,15' WHERE fbid='518355628269611'");
		$this->db->query("UPDATE $this->tb_answer SET question3='12,15' WHERE fbid='499017006865015'");
		$this->db->query("UPDATE $this->tb_answer SET question3='1,6,2,4,9,12,11,14,15' WHERE fbid='606326472799705'");
		$this->db->query("UPDATE $this->tb_answer SET question3='4,15' WHERE fbid='662812590465768'");
		$this->db->query("UPDATE $this->tb_answer SET question3='11,15' WHERE fbid='260116490857386'");
		$this->db->query("UPDATE $this->tb_answer SET question3='1,7,4,12,14,15' WHERE fbid='233057116905619'");
		$this->db->query("UPDATE $this->tb_answer SET question3='12,14,15' WHERE fbid='757944167590550'");
		$this->db->query("UPDATE $this->tb_answer SET question3='0,12,15' WHERE fbid='877915728901773'");
		*/
	}
	
	public function fix11()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question4_fill='' WHERE fbid='4264275702365'");
		/*
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question4_fill='' WHERE fbid='813576981995367'");
		$this->db->query("UPDATE $this->tb_answer SET question4_fill='' WHERE fbid='745485478837441'");
		*/
	}
	
	public function fix12()
	{
		
	}
	
	public function fix13()
	{
		
	}
	
	public function fix14()
	{
		
	}
	
	public function fix15()
	{
		
	}
	
	public function fix16()
	{
		
	}
	
	public function fix17()
	{
		
	}
	
	public function fix18()
	{
		
	}
	
	public function fix19()
	{
		
	}
	
	public function fix20()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='3,12' WHERE fbid='582312475217438'");
		$this->db->query("UPDATE $this->tb_answer SET question3='3,4' WHERE fbid='636199706469184'");
	}
	
	public function fix21()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='4,6,12' WHERE fbid='1438301163092611'");
	}
	
	public function fix22()
	{
		
	}
	
	public function fix23()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='3,12,6' WHERE fbid='582312475217438'");
	}
	
	public function fix24()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='9,7' WHERE fbid='1450377995209533'");
		$this->db->query("UPDATE $this->tb_answer SET question3='9,7' WHERE fbid='1564858373741295'");
		/*
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='9,7' WHERE fbid='768966463147450'");
		$this->db->query("UPDATE $this->tb_answer SET question3='12,2,4,9,6,11,0,7' WHERE fbid='718099928250845'");
		$this->db->query("UPDATE $this->tb_answer SET question3='9,7' WHERE fbid='10200982472003280'");
		$this->db->query("UPDATE $this->tb_answer SET question3='12,9,0,11,7' WHERE fbid='634149383341630'");
		$this->db->query("UPDATE $this->tb_answer SET question3='9,7' WHERE fbid='874534639227794'");
		$this->db->query("UPDATE $this->tb_answer SET question3='4,10,12,9,7' WHERE fbid='1443887469200788'");
		*/
	}
	
	public function fix25()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='4,5,10,7,0,12,13,9' WHERE fbid='791425434209719'");
		$this->db->query("UPDATE $this->tb_answer SET question3='5,4,7,12,9' WHERE fbid='10202121543749458'");
		$this->db->query("UPDATE $this->tb_answer SET question3='6,3,7,5,12,9' WHERE fbid='647206438701640'");
	}
	
	public function fix26()
	{
		
	}
	
	public function fix27()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question3='10,14' WHERE fbid='538251426279233'");
	}
	
	public function fix28()
	{
		
	}
	
	public function fix29()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='582312475217438'");
	}
	
	public function fix30()
	{
		
	}
	
	public function fix31()
	{
		$this->db->connect();
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='763552680356451'");
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='311280435697066'");
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='674499949288323'");
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='942742165753380'");
		$this->db->query("UPDATE $this->tb_answer SET question4='' WHERE fbid='456473901163706'");
	}
	
	public function fix32()
	{
		
	}
	
	public function lucky()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_answer AS t1 LEFT JOIN $this->tb_user AS t2 ON t1.fbid=t2.fbid");
		$res = $this->db->get_all_rows();
		
		$t1 = array();
		$t2 = array();
		$t3 = array();
		$t4 = array();
		
		$lucky_data = array();
		
		if (!empty($res))
		{
			foreach ($res as $key => $value)
			{
				if (empty($value['email']))
				{
					continue;
				}
				if ($value['fbid'] == '495479197250220')
				{
					continue;
				}
				if ($value['fbid'] == '633303713419547')
				{
					continue;
				}
				if ($value['fbid'] == '1433136700278910')
				{
					continue;
				}
				
				switch ($value['question1'])
				{
					case '0':
						$t1[] = $value;
						break;
					case '1':
						$t2[] = $value;
						break;
					case '2':
						$t3[] = $value;
						break;
					case '3':
						$t4[] = $value;
						break;
					default:
				}
			}
			
			$t1_len = count($t1);
			$t2_len = count($t2);
			$t3_len = count($t3);
			$t4_len = count($t4);
			
			for ($i = 0; $i < $t1_len; $i++)
			{
				$rand = rand(0, $t1_len - 1);
				$temp = $t1[$i];
				$t1[$i] = $t1[$rand];
				$t1[$rand] = $temp;
			}
			
			for ($i = 0; $i < $t2_len; $i++)
			{
				$rand = rand(0, $t2_len - 1);
				$temp = $t2[$i];
				$t2[$i] = $t2[$rand];
				$t2[$rand] = $temp;
			}
			
			for ($i = 0; $i < $t3_len; $i++)
			{
				$rand = rand(0, $t3_len - 1);
				$temp = $t3[$i];
				$t3[$i] = $t3[$rand];
				$t3[$rand] = $temp;
			}
			
			for ($i = 0; $i < $t4_len; $i++)
			{
				$rand = rand(0, $t4_len - 1);
				$temp = $t4[$i];
				$t4[$i] = $t4[$rand];
				$t4[$rand] = $temp;
			}
			
			$lucky_data[] = $t1[0];
			$lucky_data[] = $t3[0];
			
			for ($i = 1; $i < 21; $i++)
			{
				$lucky_data[] = $t1[$i];
			}
			for ($i = 0; $i < 20; $i++)
			{
				$lucky_data[] = $t2[$i];
			}
			for ($i = 1; $i < 41; $i++)
			{
				$lucky_data[] = $t3[$i];
			}
			for ($i = 0; $i < 20; $i++)
			{
				$lucky_data[] = $t4[$i];
			}
		}
		
		$this->save_lucky($lucky_data);
		
		return $lucky_data;
	}
	
	private function save_lucky($data)
	{
		$this->db->connect();
		$this->db->query("DELETE FROM $this->tb_lucky");
		
		foreach ($data as $key => $value)
		{
			$sql_fbid = Security::sql_var($value['fbid']);
			$sql_username = Security::sql_var($value['username']);
			$sql_email = Security::sql_var($value['email']);
			$sql_gender = Security::sql_var($value['gender']);
			$sql_locale = Security::sql_var($value['locale']);
			$sql_type = Security::sql_var($value['question1']);
			$sql_lucky_code = Security::sql_var($value['lucky_code']);
			
			$this->db->query("INSERT INTO $this->tb_lucky (fbid, username, email, gender, locale, type, lucky_code) VALUES ($sql_fbid, $sql_username, $sql_email, $sql_gender, $sql_locale, $sql_type, $sql_lucky_code)");
		}
	}
	
	public function list_lucky()
	{
		$this->db->connect();
		$this->db->query("SELECT * FROM $this->tb_lucky");
		
		return $this->db->get_all_rows();
	}
}
?>
