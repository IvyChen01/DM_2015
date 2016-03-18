<?php
/**
 * 聊天控制器
 * @author Shines
 */
class ChatController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'main':
				$this->main();
				return;
			default:
				$this->main();
		}
	}
	
	/**
	 * 管理首页
	 */
	private function main()
	{
		include(Config::$templatesDir . 'chat/main.php');
	}
}
?>
