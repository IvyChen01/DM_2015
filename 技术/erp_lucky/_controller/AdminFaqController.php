<?php
/**
 * 管理员答题控制器
 */
class AdminFaqController
{
	private $admin = null;//管理员模型
	private $faq = null;//答题抽奖模型
	
	public function __construct()
	{
		$this->admin = new Admin();
		$this->faq = new Faq();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		
		if ($this->admin->check_login())
		{
			switch ($action)
			{
				case 'count_faq':
					$this->count_faq();
					return;
				default:
			}
		}
	}
	
	private function count_faq()
	{
		$faq_daily = $this->faq->get_faq_daily();
		$zhong_jiang = $this->faq->get_zhong_jiang();
		$src_date = '';
		$new_date = '';
		
		$_total_answer = 0;
		$_total_right = 0;
		$_total_right_rate = 0;
		$_total_lucky = 0;
		$_total_lucky_rate = 0;
		$_day_list = array();
		
		if (!empty($zhong_jiang))
		{
			$_total_lucky = count($zhong_jiang);
		}
		
		if (!empty($faq_daily))
		{
			foreach ($faq_daily as $value_daily)
			{
				$_total_answer++;
				if ($value_daily['score'] == 1)
				{
					$_total_right++;
				}
				
				$new_date = date('Y-m-d', strtotime($value_daily['faq_time']));
				if ($new_date != $src_date)
				{
					$src_date = $new_date;
					$day_answer = 0;
					$day_right = 0;
					foreach ($faq_daily as $value)
					{
						$faq_time = date('Y-m-d', strtotime($value['faq_time']));
						if ($faq_time == $new_date)
						{
							$day_answer++;
							if ($value['score'] == 1)
							{
								$day_right++;
							}
						}
					}
					
					if ($day_answer > 0)
					{
						$day_right_rate = round($day_right / $day_answer * 100, 1);
					}
					else
					{
						$day_right_rate = 0;
					}
					
					$day_lucky = 0;
					if (!empty($zhong_jiang))
					{
						foreach ($zhong_jiang as $value_jiang)
						{
							$prize_time = date('Y-m-d', strtotime($value_jiang['prize_time']));
							if ($prize_time == $new_date)
							{
								$day_lucky++;
							}
						}
					}
					if ($day_right > 0)
					{
						$day_lucky_rate = round($day_lucky / $day_right * 100, 1);
					}
					else
					{
						$day_lucky_rate = 0;
					}
					
					$_day_list[] = array(
						'date' => $new_date,
						'answer' => $day_answer,
						'right' => $day_right,
						'right_rate' => $day_right_rate,
						'lucky' => $day_lucky,
						'lucky_rate' => $day_lucky_rate
					);
				}
			}
		}
		
		if ($_total_answer > 0)
		{
			$_total_right_rate = round($_total_right / $_total_answer * 100, 1);
		}
		else
		{
			$_total_right_rate = 0;
		}
		
		if ($_total_right > 0)
		{
			$_total_lucky_rate = round($_total_lucky / $_total_right * 100, 1);
		}
		else
		{
			$_total_lucky_rate = 0;
		}
		
		include('view/admin_faq/faq_count.php');
	}
}
?>
