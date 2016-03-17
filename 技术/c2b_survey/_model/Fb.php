<?php
/**
 *	Facebook操作
 */
class Fb
{
	public $user_id = 0;
	
	private $facebook = null;//Facebook API
	
	public function __construct()
	{
		$this->facebook = new Facebook(array(
			'appId'  => Config::$app_id,
			'secret' => Config::$app_key,
		));
		$this->user_id = $this->facebook->getUser();
	}
	
	public function check_login()
	{
		return !empty($this->user_id);
	}
	
	function get_login_url()
	{
		$loginUrl = $this->facebook->getLoginUrl();
		
		return $loginUrl;
	}
	
	/**
	 * 奇偶标识
	 */
	public function get_page_flag()
	{
		$page_flag = isset($_SESSION[Config::$system_name . '_facebook_page_flag']) ? (int)$_SESSION[Config::$system_name . '_facebook_page_flag'] : 0;
		
		return $page_flag;
	}
	
	/**
	 * 奇偶标识
	 */
	public function set_page_flag($value)
	{
		$_SESSION[Config::$system_name . '_facebook_page_flag'] = $value; 
	}
	
	public function me()
	{
		$error_code = 0;
		$user_profile = null;
		try
		{
			$user_profile = $this->facebook->api('/me');
		}
		catch (FacebookApiException $e)
		{
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'user_profile' => $user_profile);
	}
	
	public function feed()
	{
		$error_code = 0;
		$feed = null;
		try
		{
			$feed = $this->facebook->api('/me/feed', 'post', array(
				'link' => 'http://www.baidu.com',
				'picture' => 'http://www.baidu.com/images/logo.png',
				'name' => 'baidu name' . rand(1, 1000),
				'caption' => 'baidu caption',
				'description' => 'baidu description'
			));
		}
		catch (FacebookApiException $e)
		{
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'feed' => $feed);
	}
	
	public function apprequests()
	{
		$error_code = 0;
		$apprequests = null;
		try
		{
			$apprequests = $this->facebook->api('/me/apprequests', 'post', array(
				'message' => 'http://www.baidu.com'
			));
		}
		catch (FacebookApiException $e)
		{
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'apprequests' => $apprequests);
	}
	
	public function photos()
	{
		$error_code = 0;
		$photos = null;
		try
		{
			$photos = $this->facebook->api('/me/photos');
		}
		catch (FacebookApiException $e)
		{
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'photos' => $photos);
	}
	
	public function friends()
	{
		$error_code = 0;
		$friends = null;
		try
		{
			$friends = $this->facebook->api('/me/friends');
		}
		catch (FacebookApiException $e)
		{
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'friends' => $friends);
	}
	
	public function like()
	{
		$error_code = 0;
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
			$error_code = 1;
		}
		
		return array('code' => $error_code, 'info' => $info);
	}
}
?>
