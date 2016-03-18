<?php
/**
 *	Facebook操作
 */
class Fb
{
	public $userId = 0;
	
	private $facebook = null;//Facebook API
	
	public function __construct()
	{
		if (!Config::$isFb)
		{
			return;
		}
		
		$this->facebook = new Facebook(array(
			'appId'  => Config::$fbAppId,
			'secret' => Config::$fbAppKey,
		));
		$this->userId = $this->facebook->getUser();
	}
	
	public function checkLogin()
	{
		return !empty($this->userId);
	}
	
	function getLoginUrl()
	{
		//$loginUrl = $this->facebook->getLoginUrl();
		$loginUrl = $this->facebook->getLoginUrl(array(
			"response_type"=>"token",
			"redirect_uri"=>Config::$fbAppRedirectUrl,
			'scope' => 'user_about_me,friends_about_me,publish_actions,publish_stream,status_update,read_friendlists,email,user_location,friends_location'
		));
		
		return $loginUrl;
	}
	
	/**
	 * 奇偶标识
	 */
	public function getPageFlag()
	{
		$pageFlag = isset($_SESSION[Config::$systemName . '_facebookPageFlag']) ? (int)$_SESSION[Config::$systemName . '_facebookPageFlag'] : 0;
		
		return $pageFlag;
	}
	
	/**
	 * 奇偶标识
	 */
	public function setPageFlag($value)
	{
		$_SESSION[Config::$systemName . '_facebookPageFlag'] = $value;
	}
	
	public function me()
	{
		$errorCode = 0;
		$userProfile = null;
		try
		{
			$userProfile = $this->facebook->api('/me');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'userProfile' => $userProfile);
	}
	
	public function feed()
	{
		$errorCode = 0;
		$feed = null;
		try
		{
			$feed = $this->facebook->api('/me/feed', 'post', array(
				'link' => 'http://www.geyaa.com',
				'picture' => 'http://www.geyaa.com/images/logo.png',
				'name' => 'geyaa name' . rand(1, 1000),
				'caption' => 'geyaa caption',
				'description' => 'geyaa description'
			));
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'feed' => $feed);
	}
	
	public function apprequests()
	{
		$errorCode = 0;
		$apprequests = null;
		try
		{
			$apprequests = $this->facebook->api('/me/apprequests', 'post', array(
				'message' => 'http://www.geyaa.com'
			));
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'apprequests' => $apprequests);
	}
	
	public function photos()
	{
		$errorCode = 0;
		$photos = null;
		try
		{
			$photos = $this->facebook->api('/me/photos');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'photos' => $photos);
	}
	
	public function friends()
	{
		$errorCode = 0;
		$friends = null;
		try
		{
			$friends = $this->facebook->api('/me/friends');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'friends' => $friends);
	}
	
	public function naitik()
	{
		$errorCode = 0;
		$naitik = null;
		try
		{
			$naitik = $this->facebook->api('/naitik');
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'naitik' => $naitik);
	}
	
	public function like()
	{
		$errorCode = 0;
		$info = null;
		try
		{
			//$info = $this->facebook->api('/me/og.likes');
			
			$info = $this->facebook->api('/me/og.likes', 'post', array(
				'object' => 'http://samples.ogp.me/226075010839791'
			));
			//http://samples.ogp.me/285576404819047
		}
		catch (FacebookApiException $e)
		{
			$errorCode = 1;
		}
		
		return array('code' => $errorCode, 'info' => $info);
	}
}
?>
