<?php
/**
 * 红包控制器
 */
class HongBaoController
{
	private $hong_bao = null;//红包模型
	
	public function __construct()
	{
		$this->hong_bao = new HongBao();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'hong_bao':
				$this->hong_bao();
				return;
			case 'bind_jobnum':
				$this->bind_jobnum();
				return;
			case 'click_hong_bao':
				$this->click_hong_bao();
				return;
			case 'hong_bao_test':
				$this->hong_bao_test();
				return;
			default:
		}
	}
	
	private function hong_bao()
	{
		$openid = trim(Security::var_get('openid'));
		$key = trim(Security::var_get('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		/*
		///// debug
		$openid = rand(1, 1000000000);
		$openid = 'a001';
		$key = Security::md5_multi($openid, Config::$key);
		$srcKey = Security::md5_multi($openid, Config::$key);
		*/
		
		$_is_bind_jobnum = false;
		$_click_flag = 0;
		$_money = 0;
		$_max_money = 0;
		$_records = null;
		$_jobnum = '';
		$_username = '';
		$_openid = $openid;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openid))
		{
			$userinfo = $this->hong_bao->get_bind_user_info($openid);
			if (empty($userinfo))
			{
				//没绑定工号
				$_is_bind_jobnum = false;
				$_records = json_encode(array());
			}
			else
			{
				//已绑定工号
				$jobnum = $userinfo['jobnum'];
				$username = $userinfo['username'];
				$department = $userinfo['department'];
				$lucky_info = $this->hong_bao->get_lucky_today($jobnum);
				$is_lucky = $lucky_info['is_lucky'];
				
				if ($is_lucky)
				{
					$click_flag = $lucky_info['click_flag'];
					$money = $lucky_info['money'];
				}
				else
				{
					$click_flag = 0;
					//$money = $this->hong_bao->lucky($jobnum, $username, $department, $openid);
					$money = 0;
				}
				
				$_is_bind_jobnum = true;
				$_click_flag = $click_flag;
				$_money = $money;
				$_max_money = $this->hong_bao->get_max_money($jobnum);
				$_records = json_encode($this->hong_bao->get_records($jobnum));
				$_jobnum = $jobnum;
				$_username = $username;
			}
			
			//include('view/hong_bao.php');
			include('view/hong_bao_end.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function bind_jobnum()
	{
		Utils::echo_data(5, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$jobnum = trim(Security::var_post('jobnum'));
		$username = trim(Security::var_post('username'));
		
		if ($key == $srcKey && !empty($openid))
		{
			if (empty($jobnum) || empty($username))
			{
				Utils::echo_data(1, '工号和姓名不能为空！');
			}
			else
			{
				$userinfo = $this->hong_bao->get_base_user_info($jobnum);
				if (empty($userinfo))
				{
					Utils::echo_data(2, '工号或姓名不正确！');
				}
				else
				{
					$base_username = $userinfo['username'];
					if ($username != $base_username)
					{
						Utils::echo_data(2, '工号或姓名不正确！');
					}
					else
					{
						if ($this->hong_bao->check_bind_jobnum($jobnum))
						{
							Utils::echo_data(3, '该工号已被绑定过了！');
						}
						else
						{
							if ($this->hong_bao->check_bind_openid($openid))
							{
								Utils::echo_data(4, '该微信号已经绑定过工号了！');
							}
							else
							{
								$department = $userinfo['department'];
								$this->hong_bao->bind_jobnum($jobnum, $username, $department, $openid);
								$money = $this->hong_bao->lucky($jobnum, $username, $department, $openid);
								$max_money = $this->hong_bao->get_max_money($jobnum);
								$records = $this->hong_bao->get_records($jobnum);
								Utils::echo_data(0, '绑定成功！', array('money' => $money, 'maxMoney' => $max_money, 'records' => json_encode($records), 'jobnum' => $jobnum, 'username' => $username));
							}
						}
					}
				}
			}
		}
		else
		{
			Utils::echo_data(5, '非法请求！');
		}
	}
	
	private function click_hong_bao()
	{
		Utils::echo_data(1, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$jobnum = trim(Security::var_post('jobnum'));
		
		if ($key == $srcKey && !empty($openid))
		{
			$this->hong_bao->set_pan_click($jobnum);
			Utils::echo_data(0, 'ok');
		}
		else
		{
			Utils::echo_data(1, '非法请求！');
		}
	}
	
	private function hong_bao_test()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '<p style="font-size: 60px;">抢红包测试通道已经关闭了~</p>';
	}
}
?>
