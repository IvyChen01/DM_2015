<?php
/**
 * 抽奖控制器
 */
class LuckyController
{
	private $lucky = null;//抽奖模型
	
	public function __construct()
	{
		$this->lucky = new Lucky();
		$action = Security::var_get('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				return;
			case 'fill_lucky_info':
				$this->fill_lucky_info();
				return;
			case 'click_pan':
				$this->click_pan();
				return;
			default:
		}
	}
	
	private function lucky()
	{
		include('view/lucky_end.php');
		return;
		
		$openid = trim(Security::var_get('openid'));
		$key = trim(Security::var_get('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		/*
		///// debug
		$openid = rand(1, 1000000000);
		$openid = 'a0012';
		$key = Security::md5_multi($openid, Config::$key);
		$srcKey = Security::md5_multi($openid, Config::$key);
		*/
		
		$_is_lucky_today = false;
		$_pan_flag = 0;
		$_is_win_today = false;
		$_is_saved_info = false;
		$_department = '';
		$_username = '';
		$_lucky_code = 0;
		$_openid = $openid;
		$_key = $srcKey;
		
		if ($key == $srcKey && !empty($openid))
		{
			$lucky_today = $this->lucky->check_lucky_today($openid);
			$_is_lucky_today = $lucky_today[0];
			$_pan_flag = $lucky_today[1];
			if ($_is_lucky_today)
			{
				if ($this->lucky->check_is_win_today($openid))
				{
					$_is_win_today = true;
					$userinfo = $this->lucky->get_userinfo_today($openid);
					$is_save = $userinfo[0];
					$_department = $userinfo[1];
					$_username = $userinfo[2];
					$_lucky_code = $userinfo[3];
					if ($is_save)
					{
						$_is_saved_info = true;
					}
					else
					{
						$_is_saved_info = false;
					}
				}
				else
				{
					$_is_win_today = false;
				}
			}
			else
			{
				$_lucky_code = $this->lucky->lucky($openid);
			}
			include('view/lucky.php');
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function fill_lucky_info()
	{
		Utils::echo_data(2, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		$department = trim(Security::var_post('department'));
		$username = trim(Security::var_post('username'));
		
		if ($key == $srcKey && !empty($openid))
		{
			if (empty($department) || empty($username))
			{
				Utils::echo_data(3, '部门和姓名不能为空！');
			}
			else
			{
				$userinfo = $this->lucky->get_userinfo_today($openid);
				$is_save = $userinfo[0];
				if ($is_save)
				{
					Utils::echo_data(1, '请勿重复提交！');
				}
				else
				{
					$this->lucky->save_win_userinfo($openid, $department, $username);
					Utils::echo_data(0, 'ok', array('department' => $department, 'username' => $username));
				}
			}
		}
		else
		{
			Utils::echo_data(2, '非法请求！');
		}
	}
	
	private function click_pan()
	{
		Utils::echo_data(2, '非法请求！');
		return;
		
		$openid = trim(Security::var_post('openid'));
		$key = trim(Security::var_post('key'));
		$srcKey = Security::md5_multi($openid, Config::$key);
		
		if ($key == $srcKey && !empty($openid))
		{
			if (!$this->lucky->check_pan_today($openid))
			{
				$this->lucky->set_pan_click($openid);
				Utils::echo_data(0, 'ok');
			}
			else
			{
				Utils::echo_data(1, '已经点击过了！');
			}
		}
		else
		{
			Utils::echo_data(2, '非法请求！');
		}
	}
}
?>
