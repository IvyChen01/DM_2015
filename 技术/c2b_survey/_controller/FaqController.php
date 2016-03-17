<?php
/**
 * 答题控制器
 */
class FaqController
{
	private $fb = null;
	private $faq = null;
	
	public function __construct()
	{
		if (Config::$debug_enabled)
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
			
			return;
		}
		
		
		
		
		$this->fb = new Fb();
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
			
			return;
		}
		
		
		
		
		$lucky_code = $this->faq->check_answered($this->fb->user_id);
		if (empty($lucky_code))
		{
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
}
?>
