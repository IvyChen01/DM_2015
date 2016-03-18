<?php
/**
 *	Facebook操作
 */
class Fb
{
	private $facebook = null;
	private $token = '';
	
	public function __construct()
	{
		if (!Config::$isFb)
		{
			return;
		}
		
		require_once('extends/facebook4.5/autoload.php');
		$this->facebook = new Facebook\Facebook([
			'app_id' => Config::$fbAppId,
			'app_secret' => Config::$fbAppKey,
			'default_graph_version' => 'v2.4',
		]);
	}
	
	function getLoginUrl()
	{
		$helper = $this->facebook->getRedirectLoginHelper();
		//$permissions = ['email', 'public_profile', 'user_friends']; // optional
		$permissions = ['public_profile', 'email']; // optional
		$loginUrl = $helper->getLoginUrl(Config::$siteUrl, $permissions);
		return $loginUrl;
	}
	
	public function checkLogin()
	{
		$token = $this->getToken();
		$userId = $this->getUserId();
		return !empty($token) && !empty($userId);
	}
	
	public function initToken()
	{
		$this->token = $this->getToken();
		if (empty($this->token))
		{
			$helper = $this->facebook->getRedirectLoginHelper();
			try {
				$this->token = $helper->getAccessToken();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				//echo 'Graph returned an error: ' . $e->getMessage();
				//exit;
				$this->token = '';
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				//echo 'Facebook SDK returned an error: ' . $e->getMessage();
				//exit;
				$this->token = '';
			}
			$this->setToken($this->token);
			
			/*
			// OAuth 2.0 client handler
			$oAuth2Client = $this->facebook->getOAuth2Client();
			// Exchanges a short-lived access token for a long-lived one
			$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($this->token);
			*/
		}
	}
	
	public function me()
	{
		if (empty($this->token))
		{
			return array('code' => 1, 'userProfile' => null);
		}
		
		//$this->facebook->setDefaultAccessToken($this->token);
		try {
			$response = $this->facebook->get('/me?fields=id,name,email,gender', $this->token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			//echo 'Graph returned an error: ' . $e->getMessage();
			//exit;
			return array('code' => 1, 'userProfile' => null);
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			//echo 'Facebook SDK returned an error: ' . $e->getMessage();
			//exit;
			return array('code' => 1, 'userProfile' => null);
		}
		$userProfile = $response->getGraphUser();
		$this->setUserId($userProfile['id']);
		return array('code' => 0, 'userProfile' => $userProfile);
	}
	
	private function getToken()
	{
		$token = isset($_SESSION[Config::$systemName . '_facebookToken']) ? $_SESSION[Config::$systemName . '_facebookToken'] : '';
		return (string)$token;
	}
	
	private function setToken($value)
	{
		$_SESSION[Config::$systemName . '_facebookToken'] = (string)$value;
	}
	
	public function getUserId()
	{
		$userId = isset($_SESSION[Config::$systemName . '_facebookUserId']) ? $_SESSION[Config::$systemName . '_facebookUserId'] : '';
		return (string)$userId;
	}
	
	public function setUserId($value)
	{
		$_SESSION[Config::$systemName . '_facebookUserId'] = (string)$value;
	}
}
?>
