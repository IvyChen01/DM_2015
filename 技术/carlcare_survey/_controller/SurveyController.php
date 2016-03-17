<?php
/**
 * 调研控制器
 */
class SurveyController
{
	private $survey = null;//调研模型
	private $user = null;//用户模型
	
	public function __construct()
	{
		$this->survey = new Survey();
		$this->user = new User();
		$action = Security::varGet('a');//操作标识
		
		if ($this->user->checkLogin())
		{
			switch ($action)
			{
				case 'edit':
					$this->edit();
					return;
				case 'examine':
					$this->examine();
					return;
				case 'failvisit':
					$this->failvisit();
					return;
				case 'home':
					$this->home();
					return;
				case 'question':
					$this->question();
					return;
				case 'thankyou':
					$this->thankyou();
					return;
				case 'tovisit':
					$this->tovisit();
					return;
				case 'visit':
					$this->visit();
					return;
				case 'getList':
					$this->getList();
					return;
				case 'getCustomer':
					$this->getCustomer();
					return;
				case 'dial':
					$this->dial();
					return;
				case 'drop':
					$this->drop();
					return;
				case 'fillForm':
					$this->fillForm();
					return;
				case 'changeForm':
					$this->changeForm();
					return;
				default:
			}
			
			$level = $this->user->getLevel();
			switch ($level)
			{
				case 1:
					switch ($action)
					{
						case 'checkExist':
							$this->checkExist();
							return;
						case 'import':
							$this->import();
							return;
						case 'export':
							$this->export();
							return;
						case 'count':
							$this->count();
							return;
						default:
							$this->home();
							return;
					}
					return;
				case 2:
					switch ($action)
					{
						case 'checkExist':
							$this->checkExist();
							return;
						case 'import':
							$this->import();
							return;
						default:
							$this->home();
							return;
					}
					return;
				case 3:
					$this->home();
					return;
				default:
			}
		}
		else
		{
			$this->login();
		}
	}
	
	private function getList()
	{
		System::fixSubmit('getList');
		$year = Security::varPost('year');
		$month = Security::varPost('month');
		$week = Security::varPost('week');
		$country = Security::varPost('country');
		$type = Security::varPost('type');
		$page = Security::varPost('page');
		$list = $this->survey->getCustomerByWeek($year, $month, $week, $country, $type, $page);
		$pageCount = $this->survey->getPageCountByWeek($year, $month, $week, $country, $type);
		$waitNum = $this->survey->countByWeek($year, $month, $week, $country, 1);
		$successNum = $this->survey->countByWeek($year, $month, $week, $country, 2);
		$failNum = $this->survey->countByWeek($year, $month, $week, $country, 3);
		$countryList = $this->survey->getCountryList();
		$yearList = $this->survey->getYearList();
		Utils::echoData(0, 'ok', array('data' => $list, 'pageCount' => $pageCount, 'waitNum' => $waitNum, 'successNum' => $successNum, 'failNum' => $failNum, 'countryList' => $countryList, 'yearList' => $yearList));
	}
	
	private function getCustomer()
	{
		System::fixSubmit('getCustomer');
		$id = (int)Security::varGet('id');
		$customer = $this->survey->getCustomerById($id);
		Utils::echoData(0, 'ok', array('data' => $customer));
	}
	
	private function checkExist()
	{
		System::fixSubmit('checkExist');
		$year = Security::varPost('year');
		$month = Security::varPost('month');
		$week = Security::varPost('week');
		if ($this->survey->checkExist($year, $month, $week))
		{
			Utils::echoData(1, 'Exist!');
		}
		else
		{
			Utils::echoData(0, 'Not exist!');
		}
	}
	
	private function import()
	{
		System::fixSubmit('import');
		$year = (int)Security::varPost('year');
		$month = (int)Security::varPost('month');
		$week = (int)Security::varPost('week');
		
		if ($month >= 1 && $month <= 12)
		{
			if ($week >= 1 && $week <= 5)
			{
				$param = $this->survey->import($year, $month, $week);
				$error = $param['error'];
				$msg = $param['msg'];
			}
			else
			{
				$error = 'week limited';
				$msg = '';
			}
		}
		else
		{
			$error = 'month limited';
			$msg = '';
		}
		
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";
	}
	
	private function export()
	{
		System::fixSubmit('export');
		$year = Security::varGet('year');
		$month = Security::varGet('month');
		$week = Security::varGet('week');
		$this->survey->export($year, $month, $week);
	}
	
	private function dial()
	{
		System::fixSubmit('dial');
		$id = (int)Security::varPost('id');
		$dialNum = Security::varPost('dialNum');
		$feedback = Security::varPost('feedback');
		$language = Security::varPost('language');
		$isTakeBack = Security::varPost('isTakeBack');
		$isAcceptInterview = Security::varPost('isAcceptInterview');
		$this->survey->dial($id, $dialNum, $feedback, $language, $isTakeBack, $isAcceptInterview);
		Utils::echoData(0, 'ok');
	}
	
	private function drop()
	{
		System::fixSubmit('drop');
		$id = (int)Security::varPost('id');
		$exception = Security::varPost('exception');
		$this->survey->drop($id, $exception);
		Utils::echoData(0, 'ok');
	}
	
	private function fillForm()
	{
		System::fixSubmit('fillForm');
		$id = (int)Security::varPost('id');
		$q1 = Security::varPost('q1');
		$q2 = Security::varPost('q2');
		$q3 = Security::varPost('q3');
		$q4 = Security::varPost('q4');
		$q5 = Security::varPost('q5');
		$q5_2 = Security::varPost('q5_2');
		$q6 = Security::varPost('q6');
		$q7 = Security::varPost('q7');
		$this->survey->fillForm($id, $q1, $q2, $q3, $q4, $q5, $q5_2, $q6, $q7);
		Utils::echoData(0, 'ok');
	}
	
	private function changeForm()
	{
		System::fixSubmit('changeForm');
		$id = (int)Security::varPost('id');
		$q1 = Security::varPost('q1');
		$q2 = Security::varPost('q2');
		$q3 = Security::varPost('q3');
		$q4 = Security::varPost('q4');
		$q5 = Security::varPost('q5');
		$q5_2 = Security::varPost('q5_2');
		$q6 = Security::varPost('q6');
		$q7 = Security::varPost('q7');
		$this->survey->changeForm($id, $q1, $q2, $q3, $q4, $q5, $q5_2, $q6, $q7);
		Utils::echoData(0, 'ok');
	}
	
	private function count()
	{
		System::fixSubmit('count');
		$this->survey->count();
	}
	
	/**
	 * 显示登录界面
	 */
	private function login()
	{
		include('view/survey/login.php');
	}
	
	private function edit()
	{
		$_level = $this->user->getLevel();
		include('view/survey/edit.php');
	}
	
	private function examine()
	{
		$_level = $this->user->getLevel();
		include('view/survey/examine.php');
	}
	
	private function failvisit()
	{
		$_level = $this->user->getLevel();
		include('view/survey/fail-visit.php');
	}
	
	private function home()
	{
		$_level = $this->user->getLevel();
		include('view/survey/home.php');
	}
	
	private function question()
	{
		$_level = $this->user->getLevel();
		include('view/survey/question.php');
	}
	
	private function thankyou()
	{
		$_level = $this->user->getLevel();
		include('view/survey/thankyou.php');
	}
	
	private function tovisit()
	{
		$_level = $this->user->getLevel();
		include('view/survey/to-visit.php');
	}
	
	private function visit()
	{
		$_level = $this->user->getLevel();
		include('view/survey/visit.php');
	}
}
?>
