<?php
/**
 * 预订控制器
 * @author Shines
 */
class OrderController
{
	private $order = null;
	
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		$this->order = new Order();
		switch ($action)
		{
			case 'verify':
				$this->verify();
				break;
			case 'order':
				$this->order();
				break;
			case 'demo':
				$this->showDemo();
				break;
			default:
				$this->showMain();
		}
	}
	
	/**
	 * 生成验证码
	 */
	private function verify()
	{
		$this->order->getVerify();
	}
	
	private function order()
	{
		$verify = Security::varPost('verify');
		$region = Security::varPost('region');
		$username = Security::varPost('username');
		$email = Security::varPost('email');
		$tel = Security::varPost('tel');
		if (!$this->order->checkVerify($verify))
		{
			System::echoData(Config::$msg['verifyError']);
			return;
		}
		if (empty($username))
		{
			System::echoData(Config::$msg['nameEmpty']);
			return;
		}
		if (!Check::email($email))
		{
			System::echoData(Config::$msg['emailFormatError']);
			return;
		}
		$this->order->add($region, $username, $email, $tel);
		System::echoData(Config::$msg['ok']);
	}
	
	private function showDemo()
	{
		include(Config::$viewDir . 'order/demo.php');
	}
	
	private function showMain()
	{
		switch (Config::$configType)
		{
			case 3:
				include(Config::$viewDir . 'order/order_fr.php');
				break;
			default:
				include(Config::$viewDir . 'order/order.php');
		}
	}
}
?>
