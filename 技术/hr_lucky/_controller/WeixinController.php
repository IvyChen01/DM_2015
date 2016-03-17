<?php
/**
 * 微信控制器
 */
class WeixinController
{
	private $weixin = null;//微信模型
	
	public function __construct()
	{
		$this->weixin = new Weixin();
		$action = Security::varGet('a');//操作标识
		switch ($action)
		{
			case 'test':
				return;
			default:
				$this->index();
		}
	}
	
	/**
	 * 首页
	 */
	private function index()
	{
		//$this->weixin->valid();
		//return;
		
		if ($this->weixin->checkSignature())
		{
			$this->response();
		}
		else
		{
			echo 'Request Error!';
		}
	}
	
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
			
			/*
			Debug::log('$toUserName: ' . $toUserName);
			Debug::log('$fromUserName: ' . $fromUserName);
			Debug::log('$createTime: ' . $createTime);
			Debug::log('$msgType: ' . $msgType);
			Debug::log('$content: ' . $content);
			Debug::log('$msgid: ' . $msgid);
			Debug::log('$event: ' . $event);
			*/
			
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
						case '测试抽奖':
							$key = Security::multiMd5($fromUserName, Config::$key);
							$contentStr = '点击进入：' . "\n" . '<a href="http://hr.transsion.qumuwu.com/?m=zhuanPan&a=tempCreateOpenid' . '">测试抽奖</a>';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '123':
							$key = Security::multiMd5($fromUserName, Config::$key);
							$contentStr = '点击进入：' . "\n" . '<a href="http://hr.transsion.qumuwu.com/test' . '">test</a>';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '我要抽奖':
							echo '';
							return;
							$key = Security::multiMd5($fromUserName, Config::$key);
							//$contentStr = '猛戳这里进入抽奖：' . "\n" . '<a href="www.geyaa.com/transsion_weixin/?m=lucky&a=lucky&openid=' . $fromUserName . '&key=' . $key . '">年会抽奖第一弹</a>';
							$contentStr = '转盘抽奖结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '我要抢红包':
							echo '';
							return;
							$key = Security::multiMd5($fromUserName, Config::$key);
							//$contentStr = '抢红包活动2月3日10:00开始，敬请期待~';
							//$contentStr = '猛戳这里抢红包：' . "\n" . '<a href="http://temp.qumuwu.com/?m=hong_bao&a=hong_bao&openid=' . $fromUserName . '&key=' . $key . '">传音年会抢红包</a>';
							$contentStr = '抢红包活动已经结束了哦~';
							$msgType = "text";
							$resultStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
							echo $resultStr;
							break;
						case '抢红包测试':
							echo '';
							return;
							$key = Security::multiMd5($fromUserName, Config::$key);
							//$contentStr = '猛戳这里抢红包：' . "\n" . '<a href="http://temp.qumuwu.com/?m=hong_bao&a=hong_bao_test&openid=' . $fromUserName . '&key=' . $key . '">抢红包测试</a>';
							$contentStr = '抢红包测试通道已经关闭了~';
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
							$contentStr = "欢迎来到传音\n查看历史纪录，点击右上角人像";
							//$contentStr = '终于等到你！还好你没放弃。来这儿就对了！这儿，美女如云。这儿，呈现一手花絮。这儿，更多礼物送！送！送！';
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
}
?>
