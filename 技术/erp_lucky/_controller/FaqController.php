<?php
/**
 * 答题控制器
 */
class FaqController
{
	private $user = null;
	private $faq = null;//答题抽奖模型
	
	public function __construct()
	{
		$this->user = new User();
		$this->faq = new Faq();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		
		if ($this->user->check_login())
		{
			switch ($action)
			{
				case 'main':
					$this->main();
					return;
				case 'check_answer':
					$this->check_answer();
					return;
				case 'show_question':
					$this->show_question();
					return;
				case 'show_lucky':
					$this->show_lucky();
					return;
				default:
					$this->main();
			}
		}
		else
		{
			$this->show_login();
		}
	}
	
	private function main()
	{
		$user_id = (int)$this->user->get_userid();
		$_faq = null;
		if ($this->faq->check_faq_today($user_id))
		{
			$_answered = true;
		}
		else
		{
			$_answered = false;
			$_faq = $this->faq->get_faq();
		}
		$_username = $this->user->get_username();
		if (empty($_faq))
		{
			$_faq = array();
		}
		include('view/faq/main.php');
	}
	
	private function check_answer()
	{
		$answer = isset($_POST['answer']) ? $_POST['answer'] : '';
		//去除斜杠
		if (get_magic_quotes_gpc())
		{
			$answer = stripslashes($answer);
		}
		$user_id = $this->user->get_userid();
		
		if ($this->faq->check_faq_today($user_id))
		{
			//今天已答过题
			System::echo_data(1, '今天已经答过题了！');
		}
		else
		{
			$res = $this->faq->check_answer($answer);
			if ($res['code'] == 0)
			{
				//回答正确，返回抽奖结果
				$this->faq->save_answer($user_id, 'id:[' . $this->faq->get_faq_id() . '], ansewr:' . $answer, 1);
				$lucky = $this->faq->lucky($user_id);
				System::echo_data(0, 'ok', array('ansewr' => $res, 'lucky_code' => $lucky));
			}
			else
			{
				//回答错误
				$this->faq->save_answer($user_id, 'id:[' . $this->faq->get_faq_id() . '], ansewr:' . $answer, 0);
				System::echo_data(0, 'ok', array('ansewr' => $res));
			}
		}
	}
	
	/**
	 * 显示问题页
	 */
	private function show_question()
	{
		$_username = $this->user->get_username();
		///////////// change
		//取[第三个月]的资料
		include('view/faq/questions3.php');
	}
	
	/**
	 * 显示中奖名单
	 */
	private function show_lucky()
	{
		$_username = $this->user->get_username();
		$_lucky = $this->faq->get_lucky_list();
		if (empty($_lucky))
		{
			$_lucky = array();
		}
		include('view/faq/winners_list.php');
	}
	
	/**
	 * 显示登录界面
	 */
	private function show_login()
	{
		include('view/user/login.php');
	}
}
?>
