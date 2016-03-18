<?php
/**
 * 游戏
 * @author Shines
 */
class Game
{
	public function __construct()
	{
	}
	
	/**
	 * 检测用户是否存在
	 */
	public function existUser($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 添加用户
	 */
	public function addUser($fbid, $userProfile)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$username = isset($userProfile['name']) ? $userProfile['name'] : '';
		if (Config::$isFb)
		{
			$photo = 'https://graph.facebook.com/' . $fbid . '/picture?width=330&height=330';
		}
		else
		{
			$photo = isset($userProfile['photo']) ? $userProfile['photo'] : '';
		}
		
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$regtime = Utils::mdate('Y-m-d H:i:s');
		switch (Config::$deviceType)
		{
			case 'mobile':
				$logintype = 2;
				break;
			default:
				$logintype = 1;
		}
		$localphoto = '';
		$ip = Utils::getClientIp();
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlPhoto = Security::varSql($photo);
		$sqlEmail = Security::varSql($email);
		$sqlGender = Security::varSql($gender);
		$sqlRegtime = Security::varSql($regtime);
		$sqlLogintype = (int)$logintype;
		$sqlLocalphoto = Security::varSql($localphoto);
		$sqlIp = Security::varSql($ip);
		$sqlInviteScore = Config::$inviteScore;
		
		Config::$db->query("insert into $tbUser (fbid, username, photo, email, gender, regtime, logintype, localphoto, ip) values ($sqlFbid, $sqlUsername, $sqlPhoto, $sqlEmail, $sqlGender, $sqlRegtime, $sqlLogintype, $sqlLocalphoto, $sqlIp)");
	}
}
?>
