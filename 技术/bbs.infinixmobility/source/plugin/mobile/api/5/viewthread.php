<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: viewthread.php 34494 2014-05-09 03:34:44Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'viewthread';
include_once 'forum.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G, $thread;
		if($GLOBALS['hiddenreplies']) {
			foreach($GLOBALS['postlist'] as $k => $post) {
				if(!$post['first'] && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$_G['forum']['ismoderator']) {
					$GLOBALS['postlist'][$k]['message'] = lang('plugin/mobile', 'mobile_post_author_visible');
					$GLOBALS['postlist'][$k]['attachments'] = array();
				}
			}
		}
		$_G['thread']['lastpost'] = dgmdate($_G['thread']['lastpost']);
		$_G['thread']['recommend'] =  $_G['uid'] && C::t('forum_memberrecommend')->fetch_by_recommenduid_tid($_G['uid'], $_G['tid']) ? 1 : 0;
        
		$variable = array(
			//'thread' => $_G['thread'],
			'fid' => $_G['fid'],
			'postlist' => array_values(mobile_core::getvalues($GLOBALS['postlist'], array('/^\d+$/'), array('subject','pid', 'tid', 'author', 'first', 'dbdateline', 'dateline', 'username', 'adminid', 'memberstatus', 'authorid', 'username', 'groupid', 'memberstatus', 'status', 'message', 'number', 'memberstatus', 'groupid', 'attachment', 'attachments', 'attachlist','position','phonetype'))),
		    'ppp' => $_G['ppp'],
		    'page'=>$GLOBALS['page'],
		    'totalpage'=>$GLOBALS['totalpage'],
			/* 'setting_rewriterule' => $_G['setting']['rewriterule'],
			'setting_rewritestatus' => $_G['setting']['rewritestatus'],
			'forum_threadpay' => $_G['forum_threadpay'],
			'cache_custominfo_postno' => $_G['cache']['custominfo']['postno'], */
		);

		if(!empty($GLOBALS['threadsortshow'])) {
			$optionlist = array();
			foreach ($GLOBALS['threadsortshow']['optionlist'] AS $key => $val) {
				$val['optionid'] = $key;
				$optionlist[] = $val;
			}
			if(!empty($optionlist)) {
				$GLOBALS['threadsortshow']['optionlist'] = $optionlist;
				$GLOBALS['threadsortshow']['threadsortname'] = $_G['forum']['threadsorts']['types'][$thread['sortid']];
			}
		}
		$threadsortshow = mobile_core::getvalues($GLOBALS['threadsortshow'], array('/^(?!typetemplate).*$/'));
		if(!empty($threadsortshow)) {
			$variable['threadsortshow'] = $threadsortshow;
		}
		foreach($variable['postlist'] as $k => $post) {
		    if($post['first'] == 1) {
		        $first_pid = $post['pid'];
		        $variable['postlist'][$k]['views'] = $_G['thread']['views'];
		        $variable['postlist'][$k]['replies'] = $_G['thread']['replies'];
		    }else {
		        $variable['postlist'][$k]['views'] = '';
		        $variable['postlist'][$k]['replies'] = '';
		    }
			if(!$_G['forum']['ismoderator'] && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($_G['thread']['digest'] == 0 && ($post['groupid'] == 4 || $post['groupid'] == 5 || $post['memberstatus'] == '-1')))) {
				$message = lang('forum/template', 'message_banned');
			} elseif(!$_G['forum']['ismoderator'] && $post['status'] & 1) {
				$message = lang('forum/template', 'message_single_banned');
			} elseif($GLOBALS['needhiddenreply']) {
				$message = lang('forum/template', 'message_ishidden_hiddenreplies');
			} elseif($post['first'] && $_G['forum_threadpay']) {
				$message = lang('forum/template', 'pay_threads').' '.$GLOBALS['thread']['price'].' '.$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['unit'].$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'];
			} elseif($_G['forum_discuzcode']['passwordlock']) {
				$message = lang('forum/template', 'message_password_exists');
			} else {
				$message = '';
			}
			if($message) {
				$variable['postlist'][$k]['message'] = $message;
			}
			if($post['anonymous'] && !$_G['forum']['ismoderator']) {
				$variable['postlist'][$k]['username'] = $variable['postlist'][$k]['author'] = '';
				$variable['postlist'][$k]['adminid'] = $variable['postlist'][$k]['groupid'] = $variable['postlist'][$k]['authorid'] = 0;
			}
			if(strpos($variable['postlist'][$k]['message'], '[/tthread]') !== FALSE) {
				$matches = array();
				preg_match('/\[tthread=(.+?),(.+?)\](.*?)\[\/tthread\]/', $variable['postlist'][$k]['message'], $matches);
				$variable['postlist'][$k]['message'] = preg_replace('/\[tthread=(.+?)\](.*?)\[\/tthread\]/', lang('plugin/qqconnect', 'connect_tthread_message', array('username' => $matches[1], 'nick' => $matches[2])), $variable['postlist'][$k]['message']);
			}
			// 增加显示主题回复的来源
			if($post['status'] & 8){
			    $variable['postlist'][$k]['from'] = "from ".$post['phonetype']." phone";  //phone_name为空来自wap版
			} else {
			    $variable['postlist'][$k]['from'] = "from PC";
			}
			$variable['postlist'][$k]['message'] = preg_replace("/<a\shref=\"([^\"]+?)\"\starget=\"_blank\">\[viewimg\]<\/a>/is", "<img src=\"\\1\" />", $variable['postlist'][$k]['message']);
			$variable['postlist'][$k]['message'] = mobile_api::_findimg($variable['postlist'][$k]['message']);
			$quote_pos = strpos($variable['postlist'][$k]['message'], '</blockquote>');
			$variable['postlist'][$k]['quote'] = '';
			if ( $quote_pos !== FALSE) {
			    $quote_matches = array();
			    preg_match("/<blockquote>(.*)<\/blockquote>/s",$variable['postlist'][$k]['message'],$quote_matches);
			    $variable['postlist'][$k]['quote'] = strip_tags($quote_matches[0]);
			    $variable['postlist'][$k]['message'] = strip_tags(substr($variable['postlist'][$k]['message'],$quote_pos));
			}else{
			    $variable['postlist'][$k]['message'] = strip_tags($variable['postlist'][$k]['message']);
			}
			$variable['postlist'][$k]['message'] = preg_replace("/\[quote\]|\[\/quote\]/",'',$variable['postlist'][$k]['message']);
			$variable['postlist'][$k]['quote'] = preg_replace("/\[quote\]|\[\/quote\]/",'',$variable['postlist'][$k]['quote']);
			if ($variable['postlist'][$k]['quote']){
			    $variable['postlist'][$k]['quote'] = preg_replace("/\[img\](.*?)\[\/img\]/",'',$variable['postlist'][$k]['quote']);
			}
			$variable['postlist'][$k]['imgage'] = array();
			
			if($GLOBALS['aimgs'][$post['pid']]) {
				$imagelist = array();
				foreach($GLOBALS['aimgs'][$post['pid']] as $aid) {
					$url = mobile_api::_parseimg('', $GLOBALS['postlist'][$post['pid']]['attachments'][$aid]['url'].$GLOBALS['postlist'][$post['pid']]['attachments'][$aid]['attachment'], '');
					$variable['postlist'][$k]['imgage'][] = array(
					    'url' =>   $url,
					    'description' => $GLOBALS['postlist'][$post['pid']]['attachments'][$aid]['description']
					);
					unset($variable['postlist'][$k]['attachments']);
					if(strexists($variable['postlist'][$k]['message'], '[attach]'.$aid.'[/attach]')) {
						$variable['postlist'][$k]['message'] = str_replace('[attach]'.$aid.'[/attach]', mobile_image($url), $variable['postlist'][$k]['message']);
						unset($variable['postlist'][$k]['attachments'][$aid]);
					} else {
						$imagelist[] = $aid;
					}
				}
				//$variable['postlist'][$k]['imagelist'] = $imagelist;
			}
			
			$variable['postlist'][$k]['subject'] = $post['subject']?$post['subject']:'';
			$variable['postlist'][$k]['message'] = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $variable['postlist'][$k]['message']);
			$variable['postlist'][$k]['message'] = preg_replace('/(&nbsp;){2,}/','',$variable['postlist'][$k]['message']);
			$variable['postlist'][$k]['avatar'] = avatar($post['authorid'], 'small', true);
			$variable['postlist'][$k]['bigavatar'] = avatar($post['authorid'],'big',true);
			$gender = C::t('common_member_profile')->get_sex_by_uid($post['authorid']);
			$variable['postlist'][$k]['gender'] = $gender['gender'];
		    $variable['postlist'][$k]['level'] = strip_tags($_G['cache']['usergroups'][$post['groupid']]['grouptitle']);
			$variable['postlist'][$k]['dateline'] = strip_tags($post['dateline']);
			$variable['postlist'][$k]['dateline'] = preg_replace("/&nbsp;/",' ',$variable['postlist'][$k]['dateline']);
			//解析文本中[img][/img]
			$img_pos = strpos($variable['postlist'][$k]['message'], '[/img]');
			
			if ($img_pos){
			    $img_matches= array();
			    $i = preg_match_all("/\[img.*?\](.*?)\[\/img\]/",$variable['postlist'][$k]['message'],$img_matches);
			    foreach ($img_matches[1] as $i => $url){
			        $message_img[$i]['url'] = str_replace('&amp;', '&', $url);
			        $message_img[$i]['description'] = "";
			    }
			    $variable['postlist'][$k]['imgage']=array_merge($message_img,$variable['postlist'][$k]['imgage']);
			    $variable['postlist'][$k]['message']=preg_replace("/(\[img\]|\[img=.*\])(.*?)\[\/img\]/", '', $variable['postlist'][$k]['message']);
			}
			/*添加加分减分次数  */
			
			$addscore= C::t('forum_ratelog')->fetch_ratenum_by_pid($post['pid'],0);
			$minusscore = C::t('forum_ratelog')->fetch_ratenum_by_pid($post['pid'],-1);
			//var_dump($expression)
			$variable['postlist'][$k]['minusscore'] = $minusscore['COUNT(*)'];
			$variable['postlist'][$k]['addscore'] = $addscore['COUNT(*)'];
			/*添加支持，反对数  */
			//$support_num = C::t('forum_hotreply_number')->fetch_by_pid($post['pid']);
			//$variable['postlist'][$k]['support'] = empty($support_num['support'])?0:$support_num['support'];
			//$variable['postlist'][$k]['unsupport'] = empty($support_num['against'])?0:$support_num['against'];
			unset($variable['postlist'][$k]['groupid']);
		}
		if(!empty($GLOBALS['polloptions'])) {
			$variable['special_poll']['polloptions'] = $GLOBALS['polloptions'];
			$variable['special_poll']['expirations'] = $GLOBALS['expirations'];
			$variable['special_poll']['multiple'] = $GLOBALS['multiple'];
			$variable['special_poll']['maxchoices'] = $GLOBALS['maxchoices'];
			$variable['special_poll']['voterscount'] = $GLOBALS['voterscount'];
			$variable['special_poll']['visiblepoll'] = $GLOBALS['visiblepoll'];
			$variable['special_poll']['allowvote'] = $_G['group']['allowvote'];
			$variable['special_poll']['remaintime'] = $thread['remaintime'];
		}
		if(!empty($GLOBALS['rewardprice'])) {
			$variable['special_reward']['rewardprice'] = $GLOBALS['rewardprice'].' '.$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]]['title'];
			$variable['special_reward']['bestpost'] = $GLOBALS['bestpost'];
		}
		if(!empty($GLOBALS['trades'])) {
			$variable['special_trade'] = $GLOBALS['trades'];
		}
		if(!empty($GLOBALS['debate'])) {
			$variable['special_debate'] = $GLOBALS['debate'];
		}
		if(!empty($GLOBALS['activity'])) {
			$variable['special_activity'] = $GLOBALS['activity'];
		}

        //$variable['forum']['password'] = $variable['forum']['password'] ? '1' : '0';
		mobile_core::result(mobile_core::variable($variable));
	}

	function _findimg($string) {
		return preg_replace('/(<img src=\")(.+?)(\".*?\>)/ise', "mobile_api::_parseimg('\\1', '\\2', '\\3')", $string);
	}

	function _parseimg($before, $img, $after) {
		$before = stripslashes($before);
		$after = stripslashes($after);
		if(!in_array(strtolower(substr($img, 0, 6)), array('http:/', 'https:', 'ftp://'))) {
			global $_G;
			$img = $_G['siteurl'].$img;
		}
		return $before.$img.$after;
	}
	

}

?>