<?php
/**
 * 答题控制器
 */
class FaqController
{
	private $fb = null;
	private $user = null;
	private $faq = null;
	
	public function __construct()
	{
		if (Config::$debug_enabled)
		{
			$this->debug_init();
			return;
		}
		
		$this->fb = new Fb();
		$this->user = new User();
		$this->faq = new Faq();
		
		if ($this->fb->check_login())
		{
			$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
			switch ($action)
			{
				case 'answer':
					$this->answer();
					Debug::log('answer time: ' . Debug::runtime());
					break;
				default:
			}
		}
		else
		{
			System::echo_data(1, 'Unlogin');
		}
	}
	
	private function answer()
	{
		if (Config::$debug_enabled)
		{
			$this->debug_answer();
			return;
		}
		
		$lucky_code = $this->faq->check_answered($this->fb->user_id);
		if (empty($lucky_code))
		{
			$this->save_profile();
			
			$answer = isset($_POST['data']) ? $_POST['data'] : '';
			//去除斜杠
			if (get_magic_quotes_gpc())
			{
				$answer = stripslashes($answer);
			}
			Debug::log('fbid:[' . $this->fb->user_id . '] answer: ' . $answer);
			$res = $this->faq->answer($this->fb->user_id, $answer);
			if ($res)
			{
				System::echo_data(0, 'ok');
			}
			else
			{
				System::echo_data(3, 'Error');
			}
		}
		else
		{
			System::echo_data(2, 'Answered');
		}
	}
	
	private function save_profile()
	{
		$res = $this->fb->me();
		$code = $res['code'];
		$user_profile = $res['user_profile'];
		if (0 == $code && !empty($user_profile))
		{
			Debug::log('user_profile: ' . json_encode($user_profile));
			//添加用户，进入答题页
			$this->add_user($user_profile);
		}
		else
		{
			System::echo_data(1, 'Unlogin');
			exit(0);
		}
	}
	
	private function add_user($user_profile)
	{
		$username = isset($user_profile['name']) ? $user_profile['name'] : '';
		$email = isset($user_profile['email']) ? $user_profile['email'] : '';
		$gender = isset($user_profile['gender']) ? $user_profile['gender'] : '';
		$locale = isset($user_profile['locale']) ? $user_profile['locale'] : '';
		$this->user->add_profile($this->fb->user_id, $username, $email, $gender, $locale);
	}
	
	private function debug_init()
	{
		$this->faq = new Faq();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		switch ($action)
		{
			case 'answer':
				$this->answer();
				Debug::log('answer time: ' . Debug::runtime());
				break;
			default:
		}
	}
	
	private function debug_answer()
	{
		$answer = isset($_POST['data']) ? $_POST['data'] : '';
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$answer = stripslashes($answer);
		}
		$userid = $_SESSION['userid'];
		Debug::log('fbid:[' . $userid . '] answer: ' . $answer);
		$res = $this->faq->answer($userid, $answer);
		if ($res)
		{
			System::echo_data(0, 'ok');
		}
		else
		{
			System::echo_data(3, 'Error');
		}
	}
}
?>
