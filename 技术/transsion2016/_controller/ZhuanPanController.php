<?php
/**
 * 转盘控制器
 * @author Shines
 */
class ZhuanPanController
{
	private $zhuanPan = null;
	private $weiXin = null;
	private $admin = null;
	private $install = null;
	
	public function __construct()
	{
		$this->zhuanPan = new ZhuanPan();
		$this->weiXin = new WeiXin();
		$this->admin = new Admin();
		$this->install = new Install();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'lucky':
				$this->lucky();
				break;
			case 'doLogin':
				$this->doLogin();
				break;
			case 'doLucky':
				$this->doLucky();
				break;
			case 'dbJiangChi':
				if ($this->admin->checkLogin())
				{
					$this->dbJiangChi();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'winner':
				if ($this->admin->checkLogin())
				{
					$this->winner();
				}
				else
				{
					$this->showLogin();
				}
				break;
			case 'dataCount':
				if ($this->admin->checkLogin())
				{
					$this->dataCount();
				}
				else
				{
					$this->showLogin();
				}
				break;
			default:
				$this->main();
		}
	}
	
	/**
	 * 抽奖主界面
	 */
	private function lucky()
	{
		System::fixSubmit('lucky');
		$openId = trim(Security::varGet('openId'));
		$key = trim(Security::varGet('key'));
		$srcKey = Security::multiMd5($openId, Config::$key);
		
		/////// debug
		if (Config::$isLocal)
		{
			//$openId = rand(1, 1000000000);
			//$openId = '001';
			//$key = Security::multiMd5($openId, Config::$key);
			//$srcKey = Security::multiMd5($openId, Config::$key);
		}
		
		if ($key == $srcKey && !empty($openId))
		{
			$profile = $this->zhuanPan->getProfile($openId);
			if (empty($profile))
			{
				$isLogin = false;
				$restLucky = 0;
			}
			else
			{
				$isLogin = true;
				if ($this->zhuanPan->checkLuckyToday($openId))
				{
					$restLucky = 0;
				}
				else
				{
					$restLucky = 1;
				}
			}
			System::setSession('openId', $openId);
			$pics = array(
				'lose1.png',
				'lose2.png',
				'lose3.png',
				'lose4.png',
				'lose5.png',
				'lose6.png',
				'lose7.png',
				'lose8.png',
				'lose9.gif',
				'lose10.png',
				'lose11.gif'
			);
			$loseIndex = rand(0, 10);
			$losePic = $pics[$loseIndex];
			$timeNum = Utils::mdate('H') * 10000 + Utils::mdate('i') * 100 + Utils::mdate('s');
			
			///////// debug
			if (Config::$isLocal)
			{
				//$timeNum = 165901;
			}
			
			if ($timeNum < 165900)
			{
				$isLockTime = true;
			}
			else
			{
				$isLockTime = false;
			}
			//include(Config::$viewDir . 'zhuanpan/main.php');
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '抽奖已结束了哦~';
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	private function doLogin()
	{
		echo '';
		return;
		
		System::fixSubmit('doLogin');
		$openId = System::getSession('openId');
		if (empty($openId))
		{
			System::echoData(Config::$msg['expired']);
		}
		else
		{
			$jobnum = strtoupper(trim(Security::varPost('jobnum')));
			$username = trim(Security::varPost('username'));
			$dept = $this->zhuanPan->getDept($jobnum, $username);
			if (empty($dept))
			{
				System::echoData(Config::$msg['jobnumError']);
			}
			else
			{
				if ($this->zhuanPan->existUser($openId, $jobnum))
				{
					System::echoData(Config::$msg['binded']);
				}
				else
				{
					$this->zhuanPan->addUser($openId, $jobnum, $username, $dept);
					System::echoData(Config::$msg['ok'], array('restLucky' => 1));
				}
			}
		}
	}
	
	private function doLucky()
	{
		echo '';
		return;
		
		///////////// debug
		if (Config::$isLocal)
		{
			//System::echoData(Config::$msg['ok'], array('prizeId' => 0));
			//return;
		}
		
		System::fixSubmit('doLucky');
		$openId = System::getSession('openId');
		if (empty($openId))
		{
			System::echoData(Config::$msg['expired']);
		}
		else
		{
			$profile = $this->zhuanPan->getProfile($openId);
			if (empty($profile))
			{
				System::echoData(Config::$msg['noLogin']);
			}
			else
			{
				if ($this->zhuanPan->checkLuckyToday($openId))
				{
					System::echoData(Config::$msg['played']);
				}
				else
				{
					$timeNum = Utils::mdate('H') * 10000 + Utils::mdate('i') * 100 + Utils::mdate('s');
					
					///////// debug
					if (Config::$isLocal)
					{
						//$timeNum = 165901;
					}
					
					if ($timeNum < 165900)
					{
						System::echoData(Config::$msg['lockTime']);
					}
					else
					{
						$info = $this->zhuanPan->lucky($openId);
						$prizeId = $info['prizeId'];
						System::echoData(Config::$msg['ok'], array('prizeId' => $prizeId));
					}
				}
			}
		}
	}
	
	private function main()
	{
		$this->weiXin->valid();
		if ($this->weiXin->checkSignature())
		{
			$this->response();
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
	/**
	 * 微信消息处理
	 */
	private function response()
	{
		//get post data, May be due to the different environments
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
		
		//extract post data
		if (!empty($postStr))
		{
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$toUserName = $postObj->ToUserName;
			$fromUserName = $postObj->FromUserName;
			$createTime = $postObj->CreateTime;
			$msgType = $postObj->MsgType;
			$content = trim($postObj->Content);
			$msgid = $postObj->MsgId;
			$event = $postObj->Event;
			
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
			$time = time();
			
			switch ($msgType)
			{
				case 'text':
					switch ($content)
					{
						case '我要抽奖':
							$key = Security::multiMd5($fromUserName, Config::$key);
							//$contentStr = '猛戳这里进入抽奖：' . "\n" . '<a href="http://transsion.qumuwu.com/?a=lucky&openId=' . $fromUserName . '&key=' . $key . '">传音年会大福利</a>';
							$contentStr = '抽奖已结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						default:
							echo '';
					}
					break;
				case 'event':
					switch ($event)
					{
						case 'subscribe':
							//$contentStr = "欢迎来到传音\n查看历史纪录，点击右上角人像";
							$contentStr = '终于等到你！还好你没放弃。来这儿就对了！这儿，美女如云。这儿，呈现一手花絮。这儿，更多礼物送！送！送！';
							//$contentStr = '这儿，美女如云。这儿，更多一手花絮，深情表白，匿名点歌。天青色等烟雨，长腿欧巴就在这等着你！！';
							//$contentStr = '非常感谢你的关注！小编将为您爆料2015传音年会最劲爆动态，最逗B的花絮敬请期待。';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case 'unsubscribe':
							echo '';
							break;
						default:
							echo '';
					}
					break;
				default:
					echo '';
			}
		}
		else
		{
			echo '';
		}
	}
	
	/**
	 * 显示管理员登录页
	 */
	private function showLogin()
	{
		include(Config::$viewDir . 'admin/login.php');
	}
	
	/**
	 * 显示数据库数据页
	 */
	private function showDb($_tableList)
	{
		include(Config::$viewDir . 'admin/db.php');
	}
	
	private function dbJiangChi()
	{
		$allTables = array(Config::$tbZpJiangChi);
		$_tableList = array();
		foreach ($allTables as $tbName)
		{
			$tableInfo = array();
			$tableInfo['tbname'] = $tbName;
			$tableInfo['fields'] = $this->install->getAllFields($tbName);
			$tableInfo['records'] = $this->install->getRecords($tbName, 0, 100000);
			$_tableList[] = $tableInfo;
		}
		$this->showDb($_tableList);
	}
	
	private function winner()
	{
		$res = $this->zhuanPan->getAllWinner();
		$winner = array();
		foreach ($res as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($winner[$date]))
			{
				$winner[$date] = array('date' => $date, 'list' => array());
			}
			$winner[$date]['list'][] = array(
				'dept' => $value['dept'],
				'username' => $value['username'],
				'jobnum' => $value['jobnum'],
				'address' => $value['address'],
				'prize' => Config::$prizeName[$value['prize_id'] - 1]
			);
		}
		include(Config::$viewDir . 'zhuanpan/winner.php');
	}
	
	private function dataCount()
	{
		$users = $this->zhuanPan->getAllUsers();
		$daily = $this->zhuanPan->getAllDaily();
		$winner = $this->zhuanPan->getZhongJiang();
		$dayList = array();
		$totalUser = 0;
		$totalPlay = 0;
		$totalWinner = 0;
		
		foreach ($users as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['register_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['userNum']++;
			$totalUser++;
		}
		
		foreach ($daily as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['playNum']++;
			$totalPlay++;
		}
		
		foreach ($winner as $value)
		{
			$date = Utils::mdate('Y-m-d', $value['lucky_date']);
			if (!isset($dayList[$date]))
			{
				$dayList[$date] = array();
				$dayList[$date]['date'] = $date;
				$dayList[$date]['userNum'] = 0;
				$dayList[$date]['playNum'] = 0;
				$dayList[$date]['winner'] = 0;
			}
			$dayList[$date]['winner']++;
			$totalWinner++;
		}
		include(Config::$viewDir . 'zhuanpan/count.php');
	}
}
?>
