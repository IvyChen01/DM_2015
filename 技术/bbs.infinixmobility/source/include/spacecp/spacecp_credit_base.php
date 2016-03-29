<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_credit_base.php 33663 2013-07-30 05:06:43Z nemohou $
 *	Modified by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(empty($_GET['op']))	$_GET['op'] = 'base';
if(in_array($_GET['op'], array('transfer', 'exchange'))) {
	$taxpercent = sprintf('%1.2f', $_G['setting']['creditstax'] * 100).'%';
}
if($_GET['op'] == 'base') {
	$loglist = $extcredits_exchange = array();
	if(!empty($_G['setting']['extcredits'])) {
		foreach($_G['setting']['extcredits'] as $key => $value) {
			if($value['allowexchangein'] || $value['allowexchangeout']) {
				$extcredits_exchange['extcredits'.$key] = array('title' => $value['title'], 'unit' => $value['unit']);
			}
		}
	}

	$count = C::t('common_credit_log')->count_by_uid($_G['uid']);
	if($count) {
		loadcache(array('magics'));
		foreach(C::t('common_credit_log')->fetch_all_by_uid($_G['uid'], 0, 10) as $log) {
			$credits = array();
			$havecredit = false;
			$maxid = $minid = 0;
			foreach($_G['setting']['extcredits'] as $id => $credit) {
				if($log['extcredits'.$id]) {
					$havecredit = true;
					if($log['operation'] == 'RPZ') {
						$credits[] = $credit['title'].lang('spacecp', 'credit_update_reward_clean');
					} else {
						$credits[] = $credit['title'].' <span class="'.($log['extcredits'.$id] > 0 ? 'xi1' : 'xg1').'">'.($log['extcredits'.$id] > 0 ? '+' : '').$log['extcredits'.$id].'</span>';
					}
					if($log['operation'] == 'CEC' && !empty($log['extcredits'.$id])) {
						if($log['extcredits'.$id] > 0) {
							$log['maxid'] = $id;
						} elseif($log['extcredits'.$id] < 0) {
							$log['minid'] = $id;
						}
					}
				}
			}
			if(!$havecredit) {
				continue;
			}
			$log['credit'] = implode('<br/>', $credits);
			if(in_array($log['operation'], array('RTC', 'RAC', 'STC', 'BTC', 'ACC', 'RCT', 'RCA', 'RCB'))) {
				$tids[$log['relatedid']] = $log['relatedid'];
			} elseif(in_array($log['operation'], array('SAC', 'BAC'))) {
				$aids[$log['relatedid']] = $log['relatedid'];
			} elseif(in_array($log['operation'], array('PRC', 'RSC'))) {
				$pids[$log['relatedid']] = $log['relatedid'];
			} elseif(in_array($log['operation'], array('TFR', 'RCV'))) {
				$uids[$log['relatedid']] = $log['relatedid'];
			} elseif($log['operation'] == 'TRC') {
				$taskids[$log['relatedid']] = $log['relatedid'];
			}

			$loglist[] = $log;
		}
		$otherinfo = getotherinfo($aids, $pids, $tids, $taskids, $uids);

	}

	$navtitle = lang('core', 'title_credit');
	$creditsformulaexp = str_replace('*', 'X', $_G['setting']['creditsformulaexp']);

} elseif ($_GET['op'] == 'buy') {

	if((!$_G['setting']['ec_ratio'] || (!$_G['setting']['ec_tenpay_opentrans_chnid'] && !$_G['setting']['ec_tenpay_bargainor']  && !$_G['setting']['ec_account'])) && !$_G['setting']['card']['open'] ) {
		showmessage('action_closed', NULL);
	}

	if(submitcheck('addfundssubmit')) {
		$card_id = trim($_POST['cardid']);
		$password = trim($_POST['paypassword']);
		if(!empty($card_id) && !empty($password)){
		$url = "http://third.afpayment.com/card/recharge?";
		$file_contents = @implode('',file($url."cardNum=".$card_id."&cardPw=".$password));
		$data= json_decode($file_contents, true);
			
			if($data["code"] == "0" && $data["balance"] != null){
				$paymoney = 'extcredits2';
				$jfnum = $data["balance"];
				updatemembercount($_G['uid'] , array($paymoney => $jfnum), 1, 'AFD', $_G['uid']);
				notification_add($_G['uid'],'system',"Recharge success.",0,1);
				showmessage('Recharge success.', 'home.php?mod=spacecp&ac=credit&op=base', array(), array('showdialog' => 1, 'alert' => 'right', 'showmsg' => true, 'locationtime' => true));
			}
			else 
			{
				$message = 'Recharge fail.';
				if($data["desc"] != null)
					$message = $data["desc"];
				//showmessage('memcp_credits_card_msg_card_unfined', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true, 'extrajs' => '<script type="text/javascript">updateseccode("'.$_GET['sechash'].'");</script>'));
				//showmessage('Recharge fail.', 'home.php?mod=spacecp&ac=credit&op=buy', array(), array('showdialog' => 1, 'alert' => 'error', 'showmsg' => true, 'locationtime' => true));
				showmessage($message, 'home.php?mod=spacecp&ac=credit&op=buy', array(), array('showdialog' => 1, 'alert' => 'error', 'showmsg' => true, 'locationtime' => true));
			}
	} else {
			showmessage('Recharge card ID and password cannot be empty.', 'home.php?mod=spacecp&ac=credit&op=buy', array(), array('showdialog' => 1, 'alert' => 'error', 'showmsg' => true, 'locationtime' => true));
		}
	}

} elseif ($_GET['op'] == 'transfer') {

	if(!($_G['setting']['transferstatus'] && $_G['group']['allowtransfer'])) {
		showmessage('action_closed', NULL);
	}

	if(submitcheck('transfersubmit')) {
		if($_GET['to'] == $_G['username']) {
			showmessage('memcp_credits_transfer_msg_self_incorrect', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		$amount = intval($_GET['transferamount']);
		if($amount <= 0) {
			showmessage('credits_transaction_amount_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		} elseif(getuserprofile('extcredits'.$_G['setting']['creditstransextra'][9]) - $amount < ($minbalance = $_G['setting']['transfermincredits'])) {
			showmessage('credits_transfer_balance_insufficient', '', array('title' => $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][9]]['title'], 'minbalance' => $minbalance), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		} elseif(!($netamount = floor($amount * (1 - $_G['setting']['creditstax'])))) {
			showmessage('credits_net_amount_iszero', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		$to = C::t('common_member')->fetch_by_username($_GET['to']);
		if(!$to) {
			showmessage('memcp_credits_transfer_msg_user_incorrect', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}

		loaducenter();
		$ucresult = uc_user_login(addslashes($_G['username']), $_GET['password']);
		list($tmp['uid']) = $ucresult;

		if($tmp['uid'] <= 0) {
			showmessage('credits_password_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}

		updatemembercount($_G['uid'], array($_G['setting']['creditstransextra'][9] => -$amount), 1, 'TFR', $to['uid']);
		updatemembercount($to['uid'], array($_G['setting']['creditstransextra'][9] => $netamount), 1, 'RCV', $_G['uid']);

		if(!empty($_GET['transfermessage'])) {
			$transfermessage = dhtmlspecialchars($_GET['transfermessage']);
			notification_add($to['uid'], 'credit', 'transfer', array('credit' => $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][9]]['title'].' '.$netamount.' '.$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][9]]['unit'], 'transfermessage' => $transfermessage));
		}
		showmessage('credits_transfer_succeed', 'home.php?mod=spacecp&ac=credit&op=transfer', array(), array('showdialog' => 1, 'showmsg' => true, 'locationtime' => true));
	}

} elseif ($_GET['op'] == 'exchange') {

	if(!$_G['setting']['exchangestatus']) {
		showmessage('action_closed', NULL);
	}
	$_CACHE['creditsettings'] = array();
/*vot*/	if(file_exists(DISCUZ_ROOT.'./uc_client/data/cache/creditsettings.php')) {
/*vot*/		include_once(DISCUZ_ROOT.'./uc_client/data/cache/creditsettings.php');
	}

	if(submitcheck('exchangesubmit')) {

		$tocredits = $_GET['tocredits'];
		$fromcredits = $_GET['fromcredits'];
		$exchangeamount = $_GET['exchangeamount'];
		$outexange = strexists($tocredits, '|');
		if($outexange && !empty($_GET['outi'])) {
			$fromcredits = $_GET['fromcredits_'.$_GET['outi']];
		}

		if($fromcredits == $tocredits) {
			showmessage('memcp_credits_exchange_msg_num_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		if($outexange) {
			$netamount = floor($exchangeamount * $_CACHE['creditsettings'][$tocredits]['ratiosrc'][$fromcredits] / $_CACHE['creditsettings'][$tocredits]['ratiodesc'][$fromcredits]);
		} else {
			if($_G['setting']['extcredits'][$tocredits]['ratio'] < $_G['setting']['extcredits'][$fromcredits]['ratio']) {
				$netamount = ceil($exchangeamount * $_G['setting']['extcredits'][$tocredits]['ratio'] / $_G['setting']['extcredits'][$fromcredits]['ratio'] * (1 + $_G['setting']['creditstax']));
			} else {
				$netamount = floor($exchangeamount * $_G['setting']['extcredits'][$tocredits]['ratio'] / $_G['setting']['extcredits'][$fromcredits]['ratio'] * (1 + $_G['setting']['creditstax']));
			}
		}
		if(!$outexange && !$_G['setting']['extcredits'][$tocredits]['ratio']) {
			showmessage('credits_exchange_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		if(!$outexange && !$_G['setting']['extcredits'][$fromcredits]['allowexchangeout']) {
			showmessage('extcredits_disallowexchangeout', '', array('credittitle' => $_G['setting']['extcredits'][$fromcredits]['title']), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		if(!$outexange && !$_G['setting']['extcredits'][$tocredits]['allowexchangein']) {
			showmessage('extcredits_disallowexchangein', '', array('credittitle' => $_G['setting']['extcredits'][$tocredits]['title']), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}
		if(!$netamount) {
			showmessage('memcp_credits_exchange_msg_balance_insufficient', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		} elseif($exchangeamount <= 0) {
			showmessage('credits_transaction_amount_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		} elseif(getuserprofile('extcredits'.$fromcredits) - $netamount < ($minbalance = $_G['setting']['exchangemincredits'])) {
			showmessage('credits_exchange_balance_insufficient', '', array('title' => $_G['setting']['extcredits'][$fromcredits]['title'], 'minbalance' => $minbalance), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}

		loaducenter();
		$ucresult = uc_user_login(addslashes($_G['username']), $_GET['password']);
		list($tmp['uid']) = $ucresult;

		if($tmp['uid'] <= 0) {
			showmessage('credits_password_invalid', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
		}

		if(!$outexange) {
			updatemembercount($_G['uid'], array($fromcredits => -$netamount, $tocredits => $exchangeamount), 1, 'CEC', $_G['uid']);
		} else {
			if(!array_key_exists($fromcredits, $_CACHE['creditsettings'][$tocredits]['creditsrc'])) {
				showmessage('extcredits_dataerror', NULL);
			}
			list($toappid, $tocredits) = explode('|', $tocredits);
			$ucresult = uc_credit_exchange_request($_G['uid'], $fromcredits, $tocredits, $toappid, $exchangeamount);
			if(!$ucresult) {
				showmessage('extcredits_dataerror', NULL);
			}
			updatemembercount($_G['uid'], array($fromcredits => -$netamount), 1, 'ECU', $_G['uid']);
			$netamount = $amount;
			$amount = $tocredits = 0;
		}

		showmessage('credits_transaction_succeed', 'home.php?mod=spacecp&ac=credit&op=exchange', array(), array('showdialog' => 1, 'showmsg' => true, 'locationtime' => true));
	}

} else  {
	$wheresql = '';
	$list = array();
	$rid = intval($_GET['rid']);
	if($_GET['rid']) {
		$wheresql = " AND rid='$rid'";
	}
	require_once libfile('function/forumlist');
	$select = forumselect(false, 0, $_GET['fid']);
	$keys = array_keys($_G['setting']['extcredits']);
	foreach(C::t('common_credit_rule')->fetch_all_by_rid($rid) as $value) {
		if(!helper_access::check_module('doing') && $value['action'] == 'doing') {
			continue;
		} elseif(!helper_access::check_module('blog') && $value['action'] == 'publishblog') {
			continue;
		} elseif(!helper_access::check_module('wall') && in_array($value['action'], array('guestbook', 'getguestbook'))) {
			continue;
		}
		if(empty($_GET['fid']) || in_array($value['action'], array('digest', 'post', 'reply', 'getattach', 'postattach'))) {
			if(checkvalue($value, $keys)) {
				$list[$value['action']] = $value;
			}
		}
	}
	if(!empty($_GET['fid'])) {
		$_GET['fid'] = intval($_GET['fid']);
		$foruminfo = C::t('forum_forumfield')->fetch($_GET['fid']);
		$flist = dunserialize($foruminfo['creditspolicy']);
		foreach($flist as $action => $value) {
			$list[$value['action']] = $value;
		}
	}
}
include_once template("home/spacecp_credit_base");

function checkvalue($value, $creditids) {
	$havevalue = false;
	foreach($creditids as $key) {
		if($value['extcredits'.$key]) {
			$havevalue = true;
			break;
		}
	}
	return $havevalue;
}
?>
