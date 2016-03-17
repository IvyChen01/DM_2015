<?php
class TestController
{
	private $test = null;//管理员模型
	private $install = null;//安装模型
	
	public function __construct()
	{
		$this->test = new Test();
		$this->install = new Install();
		$action = isset($_GET['a']) ? $_GET['a'] : '';//操作标识
		
		$this->test();
	}
	
	private function test()
	{
		$this->test->test_for();
	}
}
?>
