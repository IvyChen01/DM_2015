<?php
/**
 * Facebook控制器
 */
class FbController
{
	private $fb = null;
	private $user = null;
	private $faq = null;
	
	private $userid = '';
	
	public function __construct()
	{
		if (Config::$debug_enabled)
		{
			$this->user = new User();
			$this->faq = new Faq();
			if (!isset($_SESSION['userid']))
			{
				$_SESSION['userid'] = rand(100000, 999999);
			}
			$this->userid = $_SESSION['userid'];
			
			if ($this->user->exist_user($this->userid))
			{
				$res_answer = $this->faq->check_answered($this->userid);
				if (empty($res_answer))
				{
					//进入答题页
					include('view/faq.php');
				}
				else
				{
					//已答过题了
					$is_tecno = $res_answer['is_tecno'];
					if ($is_tecno)
					{
						$_lucky_code = $res_answer['lucky_code'];
						include('view/finished.php');
					}
					else
					{
						include('view/finished_other.php');
					}
				}
			}
			else
			{
				$user_profile = array();
				$user_profile['name'] = 'name' . $this->userid;
				$user_profile['email'] = 'email' . $this->userid;
				$user_profile['gender'] = 'gender' . $this->userid;
				$user_profile['locale'] = 'locale' . $this->userid;
				$this->add_user($user_profile);
				include('view/welcome.php');
			}
			
			return;
		}
		
		
		
		
		$this->fb = new Fb();
		$this->user = new User();
		$this->faq = new Faq();
		
		if ($this->fb->check_login())
		{
			if ($this->user->exist_user($this->fb->user_id))
			{
				$res_answer = $this->faq->check_answered($this->fb->user_id);
				if (empty($res_answer))
				{
					//进入答题页
					include('view/faq.php');
				}
				else
				{
					//已答过题了
					$is_tecno = $res_answer['is_tecno'];
					if ($is_tecno)
					{
						$_lucky_code = $res_answer['lucky_code'];
						include('view/finished.php');
					}
					else
					{
						include('view/finished_other.php');
					}
				}
			}
			else
			{
				$res = $this->fb->me();
				$code = $res['code'];
				$user_profile = $res['user_profile'];
				if (0 == $code && !empty($user_profile))
				{
					Debug::log('user_profile: ' . json_encode($user_profile));
					//添加用户，进入答题页
					$this->add_user($user_profile);
					include('view/welcome.php');
				}
				else
				{
					$this->redirect_login();
				}
			}
		}
		else
		{
			$this->redirect_login();
		}
	}
	
	private function add_user($user_profile)
	{
		$username = isset($user_profile['name']) ? $user_profile['name'] : '';
		$email = isset($user_profile['email']) ? $user_profile['email'] : '';
		$gender = isset($user_profile['gender']) ? $user_profile['gender'] : '';
		$locale = isset($user_profile['locale']) ? $user_profile['locale'] : '';
		if (Config::$debug_enabled)
		{
			$this->user->add_user($this->userid, $username, $email, $gender, $locale);
		}
		else
		{
			$this->user->add_user($this->fb->user_id, $username, $email, $gender, $locale);
		}
	}
	
	private function redirect_login()
	{
		$_app_id = Config::$app_id;
		include('view/login.php');
	}
}
?>
