<?php
/**
 * 手机预订
 * @author Shines
 */
class Order
{
	public function __construct()
	{
	}
	
	/**
	 * 生成验证码
	 */
	public function getVerify()
	{
		Image::buildImageVerify('48', '22', null, Config::$systemName . '_orderVerify');
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify($code)
	{
		$verify = isset($_SESSION[Config::$systemName . '_orderVerify']) ? $_SESSION[Config::$systemName . '_orderVerify'] : '';
		unset($_SESSION[Config::$systemName . '_orderVerify']);
		if (!empty($verify) && $code == $verify)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 添加产品
	 */
	public function add($region, $username, $email, $tel)
	{
		Config::$db->connect();
		$sqlRegion = Security::varSql($region);
		$sqlUsername = Security::varSql($username);
		$sqlEmail = Security::varSql($email);
		$sqlTel = Security::varSql($tel);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$tbOrder = Config::$tbOrder;
		Config::$db->query("insert into $tbOrder (region, username, email, tel, orderdate) values ($sqlRegion, $sqlUsername, $sqlEmail, $sqlTel, $sqlDate)");
	}
}
?>
