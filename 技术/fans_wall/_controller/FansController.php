<?php
class FansController
{
	public function __construct()
	{
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'byTime':
				$this->byTime();
				return;
			case 'byLike':
				$this->byLike();
				return;
			case 'like':
				$this->like();
				return;
			case 'share':
				$this->share();
				return;
			default:
				$this->byTime();
		}
	}
	
	private function byTime()
	{
		$fans = new Fans();
		$like = $fans->getLikeArr();
		$share = $fans->getShareArr();
		$ip = Utils::getClientIp();
		$date = Utils::mdate('Y-m-d H:i:s');
		$_fans = $fans->getFansByTime();
		foreach ($_fans as $key => $value)
		{
			$_fans[$key]['year'] = Utils::mdate('Y', $value['pubtime']);
			$month = Utils::mdate('m', $value['pubtime']);
			if ($month < 1 || $month > 12)
			{
				$month = 1;
			}
			$_fans[$key]['month'] = Config::$monthEn[$month - 1];
			$_fans[$key]['day'] = Utils::mdate('d', $value['pubtime']);
			
			if (isset($like[$ip . '_' . $value['id']]))
			{
				
				if (Utils::restSeconds($like[$ip . '_' . $value['id']], $date) < 24 * 3600)
				{
					$_fans[$key]['liked'] = 1;
				}
				else
				{
					$_fans[$key]['liked'] = 0;
				}
			}
			else
			{
				$_fans[$key]['liked'] = 0;
			}
			
			if (isset($share[$ip . '_' . $value['id']]))
			{
				if (Utils::restSeconds($share[$ip . '_' . $value['id']], $date) < 24 * 3600)
				{
					$_fans[$key]['shared'] = 1;
				}
				else
				{
					$_fans[$key]['shared'] = 0;
				}
			}
			else
			{
				$_fans[$key]['shared'] = 0;
			}
		}
		$_sortText = 'RANK BY TIME';
		$_sortLink = '?m=fans&a=byLike';
		include('view/index.php');
	}
	
	private function byLike()
	{
		$fans = new Fans();
		$like = $fans->getLikeArr();
		$share = $fans->getShareArr();
		$ip = Utils::getClientIp();
		$date = Utils::mdate('Y-m-d H:i:s');
		$_fans = $fans->getFansByLike();
		foreach ($_fans as $key => $value)
		{
			$_fans[$key]['year'] = Utils::mdate('Y', $value['pubtime']);
			$month = Utils::mdate('m', $value['pubtime']);
			if ($month < 1 || $month > 12)
			{
				$month = 1;
			}
			$_fans[$key]['month'] = Config::$monthEn[$month - 1];
			$_fans[$key]['day'] = Utils::mdate('d', $value['pubtime']);
			
			if (isset($like[$ip . '_' . $value['id']]))
			{
				
				if (Utils::restSeconds($like[$ip . '_' . $value['id']], $date) < 24 * 3600)
				{
					$_fans[$key]['liked'] = 1;
				}
				else
				{
					$_fans[$key]['liked'] = 0;
				}
			}
			else
			{
				$_fans[$key]['liked'] = 0;
			}
			
			if (isset($share[$ip . '_' . $value['id']]))
			{
				if (Utils::restSeconds($share[$ip . '_' . $value['id']], $date) < 24 * 3600)
				{
					$_fans[$key]['shared'] = 1;
				}
				else
				{
					$_fans[$key]['shared'] = 0;
				}
			}
			else
			{
				$_fans[$key]['shared'] = 0;
			}
		}
		$_sortText = 'RANK BY LIKE';
		$_sortLink = '?m=fans&a=byTime';
		include('view/index.php');
	}
	
	private function like()
	{
		$photoId = Security::varPost('id');
		Debug::log('$photoId: ' . $photoId);
		$fans = new Fans();
		$flag = $fans->setLike($photoId);
		if ($flag)
		{
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['liked']);
		}
	}
	
	private function share()
	{
		$photoId = Security::varPost('id');
		$fans = new Fans();
		$flag = $fans->setShare($photoId);
		if ($flag)
		{
			System::echoData(Config::$msg['ok']);
		}
		else
		{
			System::echoData(Config::$msg['shared']);
		}
	}
}
?>
