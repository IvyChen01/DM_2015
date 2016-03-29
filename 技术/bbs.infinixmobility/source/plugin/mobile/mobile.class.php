<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mobile.class.php 34605 2014-06-10 02:37:15Z nemohou $
 */

define("MOBILE_PLUGIN_VERSION", "5");
define("REQUEST_METHOD_DOMAIN", 'http://wsq.discuz.qq.com');

class mobile_core {

	function result($result) {
		global $_G;
		ob_end_clean();
		function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();
		header("Content-type: application/json");
		mobile_core::make_cors($_SERVER['REQUEST_METHOD'], REQUEST_METHOD_DOMAIN);
		$result = mobile_core::json(mobile_core::format($result));
		if(defined('FORMHASH')) {
			echo empty($_GET['jsoncallback_'.FORMHASH]) ? $result : $_GET['jsoncallback_'.FORMHASH].'('.$result.')';
		} else {
			echo $result;
		}
		exit;
	}

	function format($result) {
		switch (gettype($result)) {
			case 'array':
				foreach($result as $_k => $_v) {
					$result[$_k] = mobile_core::format($_v);
				}
				break;
			case 'boolean':
			case 'integer':
			case 'double':
			case 'float':
				$result = (string)$result;
				break;
		}
		return $result;
	}

	function json($encode) {
		if(!empty($_GET['debug']) && defined('DISCUZ_DEBUG') && DISCUZ_DEBUG) {
			return debug($encode);
		}
		require_once 'source/plugin/mobile/json.class.php';
		return CJSON::encode($encode);
	}

	function getvalues($variables, $keys, $subkeys = array()) {
		$return = array();
		foreach($variables as $key => $value) {
			foreach($keys as $k) {
				if($k{0} == '/' && preg_match($k, $key) || $key == $k) {
					if($subkeys) {
						$return[$key] = mobile_core::getvalues($value, $subkeys);
					} else {
						if(!empty($value) || !empty($_GET['debug']) || (is_numeric($value) && intval($value) === 0 )) {
							$return[$key] = is_array($value) ? mobile_core::arraystring($value) : (string)$value;
						}
					}
				}
			}
		}
		return $return;
	}

	function arraystring($array) {
		foreach($array as $k => $v) {
			$array[$k] = is_array($v) ? mobile_core::arraystring($v) : (string)$v;
		}
		return $array;
	}

	function variable($variables = array()) {
		global $_G;
		if(in_array('mobileoem', $_G['setting']['plugins']['available'])) {
			$check = C::t('#mobileoem#mobileoem_member')->fetch($_G['uid']);
		}
		$globals = array(
			'cookiepre' => $_G['config']['cookie']['cookiepre'],
			'auth' => $_G['cookie']['auth'],
			'saltkey' => $_G['cookie']['saltkey'],
			'member_uid' => $_G['member']['uid'],
			'member_username' => $_G['member']['username'],
			'groupid' => $_G['groupid'],
			'formhash' => FORMHASH,
			'ismoderator' => $_G['forum']['ismoderator'],
			'readaccess' => $_G['group']['readaccess'],
			'notice' => array(
				'newpush' => $check['newpush'] ? 1 : 0,
				'newpm' => dintval($_G['member']['newpm']),
				'newprompt' => dintval(($_G['member']['newprompt'] - $_G['member']['category_num']['mypost']) >= 0 ? ($_G['member']['newprompt'] - $_G['member']['category_num']['mypost']) : 0),
				'newmypost' => dintval($_G['member']['category_num']['mypost']),
			)
		);
		if(!empty($_GET['submodule']) == 'checkpost') {
			$apifile = 'source/plugin/mobile/api/'.$_GET['version'].'/sub_checkpost.php';
			if(file_exists($apifile)) {
				require_once $apifile;
				$globals = $globals + mobile_api_sub::getvariable();
			}
		}
		$xml = array(
			'Version' => $_GET['version'],
			'Charset' => strtoupper($_G['charset']),
		    'sys_authkey' =>md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']),
			'Variables' => array_merge($globals, $variables),
		);
		if(!empty($_G['messageparam'])) {
			$message_result = lang('plugin/mobile', $_G['messageparam'][0], $_G['messageparam'][2]);
			if($message_result == $_G['messageparam'][0]) {
				$vars = explode(':', $_G['messageparam'][0]);
				if (count($vars) == 2) {
					$message_result = lang('plugin/' . $vars[0], $vars[1], $_G['messageparam'][2]);
					$_G['messageparam'][0] = $vars[1];
				} else {
					$message_result = lang('message', $_G['messageparam'][0], $_G['messageparam'][2]);
				}
			}
			$message_result = strip_tags($message_result);

			if(defined('IS_WEBVIEW') && IS_WEBVIEW && in_array('mobileoem', $_G['setting']['plugins']['available'])) {
				include_once DISCUZ_ROOT.'./source/plugin/mobileoem/discuzcode.func.php';
				include mobileoem_template('common/showmessage');
				if(!empty($_GET['debug'])) {
					exit;
				}
				$content = ob_get_contents();
				ob_end_clean();
				$xml['Variables']['datatype'] = -1;
				$xml['Variables']['webview_page'] = $content;
				return $xml;
			}

			if($_G['messageparam'][4]) {
				$_G['messageparam'][0] = "custom";
			}
			if ($_G['messageparam'][3]['login'] && !$_G['uid']) {
				$_G['messageparam'][0] .= '//' . $_G['messageparam'][3]['login'];
			}
			$xml['Message'] = array("messageval" => $_G['messageparam'][0], "messagestr" => $message_result);
			if($_GET['mobilemessage']) {
				$return = mobile_core::json($xml);
				header("HTTP/1.1 301 Moved Permanently");
				header("Location:discuz://" . rawurlencode($_G['messageparam'][0]) . "//" . rawurlencode(diconv($message_result, $_G['charset'], "utf-8")) . ($return ? "//" . rawurlencode($return) : '' ));
				exit;
			}
		}
		return $xml;
	}

	function diconv_array($variables, $in_charset, $out_charset) {
		foreach($variables as $_k => $_v) {
			if(is_array($_v)) {
				$variables[$_k] = mobile_core::diconv_array($_v, $in_charset, $out_charset);
			} elseif(is_string($_v)) {
				$variables[$_k] = diconv($_v, $in_charset, $out_charset);
			}
		}
		return $variables;
	}

	function make_cors($request_method, $origin = '') {

		$origin = $origin ? $origin : REQUEST_METHOD_DOMAIN;

		if ($request_method === 'OPTIONS') {
			header('Access-Control-Allow-Origin:'.$origin);

			header('Access-Control-Allow-Credentials:true');
			header('Access-Control-Allow-Methods:GET, POST, OPTIONS');


			header('Access-Control-Max-Age:1728000');
			header('Content-Type:text/plain charset=UTF-8');
			header("status: 204");
			header('HTTP/1.0 204 No Content');
			header('Content-Length: 0',true);
			flush();
		}

		if ($request_method === 'POST') {

			header('Access-Control-Allow-Origin:'.$origin);
			header('Access-Control-Allow-Credentials:true');
			header('Access-Control-Allow-Methods:GET, POST, OPTIONS');
		}

		if ($request_method === 'GET') {

			header('Access-Control-Allow-Origin:'.$origin);
			header('Access-Control-Allow-Credentials:true');
			header('Access-Control-Allow-Methods:GET, POST, OPTIONS');
		}

	}
}

class base_plugin_mobile {

	function common() {
		global $_G;
		if(!defined('IN_MOBILE_API')) {
			return;
		}
		if(!$_G['setting']['mobile']['allowmobile']) {
			mobile_core::result(array('error' => 'mobile_is_closed'));
		}
		if(!empty($_GET['tpp'])) {
			$_G['tpp'] = intval($_GET['tpp']);
		}
		if(!empty($_GET['ppp'])) {
			$_G['ppp'] = intval($_GET['ppp']);
		}
		$_G['pluginrunlist'] = array('mobile', 'qqconnect', 'wechat');
		$_G['siteurl'] = preg_replace('/api\/mobile\/$/', '', $_G['siteurl']);
		$_G['setting']['msgforward'] = '';
		$_G['setting']['cacheindexlife'] = $_G['setting']['cachethreadlife'] = false;
		if(!$_G['setting']['mobile']['nomobileurl'] && function_exists('diconv') && !empty($_GET['charset'])) {
			$_GET = mobile_core::diconv_array($_GET, $_GET['charset'], $_G['charset']);
		}
		if(class_exists('mobile_api', false) && method_exists('mobile_api', 'common')) {
			mobile_api::common();
		}
	}

	function discuzcode($param) {
		if(!defined('IN_MOBILE_API') || $param['caller'] != 'discuzcode') {
			return;
		}
		global $_G;
		if(defined('IS_WEBVIEW') && IS_WEBVIEW && in_array('mobileoem', $_G['setting']['plugins']['available'])) {
			include_once DISCUZ_ROOT.'./source/plugin/mobileoem/discuzcode.func.php';
			include_once mobileoem_template('forum/discuzcode');
			$_G['discuzcodemessage'] = mobileoem_discuzcode($param['param']);
		} elseif($_GET['version'] == 4) {
			include_once 'discuzcode.func.php';
			$_G['discuzcodemessage'] = mobile_discuzcode($param['param']);
		} else {
			$_G['discuzcodemessage'] = preg_replace(array(
				"/\[size=(\d{1,2}?)\]/i",
				"/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
				"/\[\/size]/i",
			), '', $_G['discuzcodemessage']);
		}
		if(in_array('soso_smilies', $_G['setting']['plugins']['available'])) {
			$sosoclass = DISCUZ_ROOT.'./source/plugin/soso_smilies/soso.class.php';
			if(file_exists($sosoclass)) {
				include_once $sosoclass;
				$soso_class = new plugin_soso_smilies;
				$soso_class->discuzcode($param);
			}
		}
	}

	function global_mobile() {
		if(!defined('IN_MOBILE_API')) {
			return;
		}
		if(class_exists('mobile_api', false) && method_exists('mobile_api', 'output')) {
			mobile_api::output();
		}
	}

}

class base_plugin_mobile_forum extends base_plugin_mobile {

	function post_mobile_message($param) {
		if(!defined('IN_MOBILE_API')) {
			return;
		}
		if(class_exists('mobile_api', false) && method_exists('mobile_api', 'post_mobile_message')) {
			list($message, $url_forward, $values, $extraparam, $custom) = $param['param'];
			mobile_api::post_mobile_message($message, $url_forward, $values, $extraparam, $custom);
		}
	}

	function misc_mobile_message($param) {
		if(!defined('IN_MOBILE_API')) {
			return;
		}
		if(class_exists('mobile_api', false) && method_exists('mobile_api', 'misc_mobile_message')) {
			list($message, $url_forward, $values, $extraparam, $custom) = $param['param'];
			mobile_api::misc_mobile_message($message, $url_forward, $values, $extraparam, $custom);
		}
	}

	function viewthread_postbottom_output() {
		global $_G, $postlist;
		foreach($postlist as $k => $post) {
			if($post['mobiletype'] == 1) {
				$post['message'] .= lang('plugin/mobile', 'mobile_fromtype_ios');
			} elseif($post['mobiletype'] == 2) {
				$post['message'] .= lang('plugin/mobile', 'mobile_fromtype_android');
			} elseif($post['mobiletype'] == 3) {
				$post['message'] .= lang('plugin/mobile', 'mobile_fromtype_windowsphone');
			} elseif($post['mobiletype'] == 5) {
				$threadmessage = $_G['setting']['wechatviewpluginid'] ? lang('plugin/'.$_G['setting']['wechatviewpluginid'], 'lang_wechat_threadmessage', array('tid' => $_G['tid'], 'pid' => $post['pid'])) : array();
				$post['message'] .= $threadmessage ? $threadmessage : '';
			}
			$postlist[$k] = $post;
		}
		return array();
	}

}

class base_plugin_mobile_misc extends base_plugin_mobile {

	function mobile() {
		global $_G;
		if(empty($_GET['view']) && !defined('MOBILE_API_OUTPUT')) {
			if(in_array('mobileoem', $_G['setting']['plugins']['available'])) {
				loadcache('mobileoem_data');
			}
			$_G['setting']['pluginhooks'] = array();
			$qrfile = DISCUZ_ROOT.'./data/cache/mobile_siteqrcode.png';
			if(!file_exists($qrfile) || $_G['adminid'] == 1) {
				require_once DISCUZ_ROOT.'source/plugin/mobile/qrcode.class.php';
				QRcode::png($_G['siteurl'], $qrfile);
			}
			define('MOBILE_API_OUTPUT', 1);
			$_G['disabledwidthauto'] = 1;
			define('TPL_DEFAULT', true);
			include template('mobile:mobile');
			exit;
		}
	}

}

class plugin_mobile extends base_plugin_mobile {}
class plugin_mobile_forum extends base_plugin_mobile_forum {
	function post_mobile_message($param) {
		parent::post_mobile_message($param);
		list($message) = $param['param'];
		if(in_array($message, array('post_reply_succeed', 'post_reply_mod_succeed'))) {
			include_once 'source/plugin/mobile/api/4/sub_sendreply.php';
		}
	}
}

class plugin_mobile_misc extends base_plugin_mobile_misc {}
class mobileplugin_mobile extends base_plugin_mobile {
	function global_header_mobile() {
		if(in_array('mobileoem', $_G['setting']['plugins']['available'])) {
			loadcache('mobileoem_data');
			if($_G['cache']['mobileoem_data']['iframeUrl']) {
				return;
			}
		}
		if(IN_MOBILE === '1' || IN_MOBILE === 'yes' || IN_MOBILE === true) {
			return;
		}
	}
}
class mobileplugin_mobile_forum extends base_plugin_mobile_forum {
	function post_mobile_message($param) {
		parent::post_mobile_message($param);
		list($message) = $param['param'];
		if(in_array($message, array('post_reply_succeed', 'post_reply_mod_succeed'))) {
			include_once 'source/plugin/mobile/api/4/sub_sendreply.php';
		}
	}
}
class mobileplugin_mobile_misc extends base_plugin_mobile_misc {}

class plugin_mobile_connect extends plugin_mobile {

	function login_mobile_message($param) {
		global $_G;
		if(substr($_GET['referer'], 0, 7) == 'Mobile_') {
			if($_GET['referer'] == 'Mobile_iOS' || $_GET['referer'] == 'Mobile_Android') {
				$_GET['mobilemessage'] = 1;
			}
			$param = array('con_auth_hash' => $_G['cookie']['con_auth_hash']);
			mobile_core::result(mobile_core::variable($param));
		}
	}

}
function parse_post_attach($attachtids, $attachpids, $prikey = 'tid', $options = array('query_download' => false,'thumb_image_width'=>300,'thumb_image_height'=>300)) {
    global $_G;
    if (empty($attachpids) || empty($attachtids)) {
        return;
    }
    $options['thumb_image_width'] = getgpc('thumb_image_width') ? getgpc('thumb_image_width') : $options['thumb_image_width'];
    $options['thumb_image_height'] = getgpc('thumb_image_height') ? getgpc('thumb_image_height') : $options['thumb_image_height'];
    $attachs = $attachlist = $aids = array();
    foreach (array_unique(array_values($attachtids)) as $tid) {
        foreach(C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$tid, 'pid', $attachpids) as $attach) {
            $url = $_G['siteurl'] . ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/';
            $attach['isimage'] = $attach['isimage'] && !$_G['setting']['attachimgpost'] ? 0 : $attach['isimage'];
            $attach['dateline'] = dgmdate($attach['dateline'], 'u');
            $attachs[$attach['aid']] = array(
                'aid' => $attach['aid'],
                $prikey => $attach[$prikey],
                'filename' => $attach['filename'],
                'isimage' => $attach['isimage'],
                'attachment' => $url.$attach['attachment'],
                'dateline' => $attach['dateline']
            );
            if($attach['isimage'] && ($options['thumb_image_width'] || $options['thumb_image_height'])){
                $attachs[$attach['aid']]['attachment'] = $_G['siteurl'].getforumimg($attach['aid'], 0, $options['thumb_image_width'], $options['thumb_image_height'], 'fixnone');
            }
            $options['query_download'] && $aids[] = $attach['aid'];
        }
    }

    if ($options['query_download'] && !empty($aids)) {
        foreach (C::t('forum_attachment')->fetch_all($aids) as $aid => $attach) {
            if ($attachs[$attach['aid']]) {
                $attachs[$attach['aid']]['downloads'] = $attach['downloads'];
            }
        }
    }
    foreach ($attachs as $aid => $attach) {
        if ($attach['isimage']) {
            $attachlist[$attach[$prikey]]['imagelist'][] = $attach;
        } else {
            $attachlist[$attach[$prikey]]['attachlist'][] = $attach;
        }
    }
    if(!empty($_G['forum_imageurls'])){
        foreach ($_G['forum_imageurls'] as $pid=>$imgurls){
            foreach ($imgurls as $src){
                if(preg_match("/^http[s]?:\/\/(.)+/i",$src) && !strpos($src, '/static/image/')){
                    $key = $prikey == 'tid' ? $attachtids[$pid] : $pid;
                    $picname = substr($src, strripos($src, '/') + 1);
                    /* $src = $_G['siteurl'].'forum.php?mod=image&size='.$options['thumb_image_width'].'x'
                     .$options['thumb_image_height'].'&type=fixnone&image_src='.rawurlencode($src); */
                    $attachlist[$key]['imagelist'][] = array(
                        'aid' => 0,
                        $prikey=>$key,
                        'filename' => $picname,
                        'isimage' => 1,
                        'attachment' => $src,
                        'dateline' => date('Y-m-j H:i',TIMESTAMP)
                    );
                }
            }
        }
    }
    unset($attachs, $aids, $attach);
    return $attachlist;
}

function parse_post_message($post) {
    global $_G;
    $post['message'] = strtolower($post['message']);
    if($post['attachment']) {
        $_G['forum_attachpids'][] = $post['pid'];
        $_G['forum_attachtids'][$post['pid']] = $post['tid'];
    }
    if (strpos($post['message'], '[/i]') !== FALSE) {
        $post['message'] = preg_replace("/\s*\[i=s\][\n\r]*(.+?)[\n\r]*\[\/i\]\s*/is", '', $post['message']);
    }
    if (strpos($post['message'], '[/hide]') !== FALSE) {
        $post['message'] = preg_replace("/\[hide.*?\]\s*(.*?)\s*\[\/hide\]/ies", "", $post['message']);
        /* if(strpos($post['message'], '[hide=') !== FALSE) {
         $message = preg_replace("/\[hide=(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/ies", "removestr_in_mobile('\\1','\\2','\\3')", $post['message']);
         }
         if(strpos($post['message'], '[hide]') !== FALSE) {
         $post['message'] = preg_replace("/\[hide\]\s*(.*?)\s*\[\/hide\]/is", '', $post['message']);
        } */
    }
    if(strpos($post['message'], '[/img]') !== FALSE && defined('IN_MOBILE_API')) {
        $imageurls = array();
        if (preg_match_all("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies", $post['message'], $matchulrs)) {
            $imageurls = $matchulrs[1];
            unset($matchulrs);
        }
        if (preg_match_all("/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies", $post['message'], $matchulrs)) {
            $imageurls = array_merge($imageurls,$matchulrs[3]);
            unset($matchulrs);
        }
        $_G['forum_imageurls'][$post['pid']] = $imageurls;
        $post['message'] = preg_replace(array(
            "/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies",
            "/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies"
        ),array("","") , $post['message']);
    }

    $imgcontent = $post['first'] ? getstatus($_G['forum_thread']['status'], 15) : 0;

    if ($post['first']) {
        $messageindex = false;
        if(strpos($post['message'], '[/index]') !== FALSE) {
            $post['message'] = preg_replace("/\s?\[index\](.+?)\[\/index\]\s?/ies", "parseapiindex('\\1', '$post[pid]')", $post['message']);
            $messageindex = true;
            unset($_GET['threadindex']);
        }
        if (strpos($post['message'], '[page]') !== FALSE) {
            if ($_GET['cp'] != 'all') {
                $postbg = '';
                if (strpos($post['message'], '[/postbg]') !== FALSE) {
                    preg_match("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", $post['message'], $r);
                    $postbg = $r[0];
                }
                $messagearray = explode('[page]', $post['message']);
                $cp = max(intval($_GET['cp']), 1);
                $post['message'] = $messagearray[$cp - 1];
                if ($postbg && strpos($post['message'], '[/postbg]') === FALSE) {
                    $post['message'] = $postbg.$post['message'];
                }
                unset($postbg);
            } else {
                $cp = 0;
                $post['message'] = preg_replace("/\s?\[page\]\s?/is", '', $post['message']);
            }

        }
    }

    if (!$imgcontent) {
        $post['message'] = discuzcode_in_mobile($post['message'], 1, 0, 0, 1, 1, (CURMODULE == 'index' || $_G['forum']['allowimgcode'] && $_G['setting']['showimages'] ? 1 : 0), (CURMODULE == 'index' || $_G['forum']['allowhtml']), ($_G['forum']['jammer'] && $post['authorid'] != $_G['uid'] ? 1 : 0), 0, $post['authorid'], $_G['cache']['usergroups'][$post['groupid']]['allowmediacode'] && (CURMODULE == 'index' || $_G['forum']['allowmediacode']), $post['pid'], $_G['setting']['lazyload'], $post['dbdateline'], $post['first']);
        if ($post['first']) {
            $_G['relatedlinks'] = '';
            $relatedtype = !$_G['forum_thread']['isgroup'] ? 'forum' : 'group';
            if (!$_G['setting']['relatedlinkstatus']) {
                $_G['relatedlinks'] = get_related_link($relatedtype);
            } else {
                $post['message'] = parse_related_link($post['message'], $relatedtype);
            }
            if (strpos($post['message'], '[/begin]') !== FALSE) {
                $post['message'] = preg_replace("/\[begin(=\s*([^\[\<\r\n]*?)\s*,(\d*),(\d*),(\d*),(\d*))?\]\s*([^\[\<\r\n]+?)\s*\[\/begin\]/ies", $_G['cache']['usergroups'][$post['groupid']]['allowbegincode'] ? "parseapibegin('\\2', '\\7', '\\3', '\\4', '\\5', '\\6');" : '', $post['message']);
            }
        }
    }

    if (!$post['first']) {
        if (strpos($post['message'], '[page]') !== FALSE) {
            $post['message'] = preg_replace("/\s?\[page\]\s?/is", '', $post['message']);
        }
        if (strpos($post['message'], '[/index]') !== FALSE) {
            $post['message'] = preg_replace("/\s?\[index\](.+?)\[\/index\]\s?/is", '', $post['message']);
        }
        if (strpos($post['message'], '[/begin]') !== FALSE) {
            $post['message'] = preg_replace("/\[begin(=\s*([^\[\<\r\n]*?)\s*,(\d*),(\d*),(\d*),(\d*))?\]\s*([^\[\<\r\n]+?)\s*\[\/begin\]/ies", '', $post['message']);
        }
    }

    if (strpos($post['message'], '[/attach]') !== FALSE) {
        $post['message'] = preg_replace("/\[attach\](\d+)\[\/attach\]/i", '', $post['message']);
    }

    if ((strpos($post['message'], '[/code]') || strpos($post['message'], '[/CODE]')) !== FALSE) {
        $post['message'] = preg_replace("/\s?\[code\](.+?)\[\/code\]\s?/ies", "", $post['message']);
    }
    if (strpos($post['message'], '[/quote]') !== FALSE) {
        $message = preg_replace("/\s?\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s?/is", '', $post['message']);
    }
    if (strpos($post['message'], '[/free]') !== FALSE) {
        $post['message'] = preg_replace("/\s*\[free\][\n\r]*(.+?)[\n\r]*\[\/free\]\s*/is", '', $post['message']);
    }
    if ($imgcontent) {
        $post['message'] = '<img id="threadimgcontent" src="./'.stringtopic('', $post['tid']).'">';
    }
    return $post['message'];
}

function parseapiindex($nodes, $pid) {
    global $_G;
    $nodes = dhtmlspecialchars($nodes);
    $nodes = preg_replace('/(\**?)\[#(\d+)\](.+?)[\r\n]/', "<a page=\"\\2\" sub=\"\\1\">\\3</a>", $nodes);
    $nodes = preg_replace('/(\**?)\[#(\d+),(\d+)\](.+?)[\r\n]/', "<a tid=\"\\2\" pid=\"\\3\" sub=\"\\1\">\\4</a>", $nodes);
    $_G['forum_posthtml']['header'][$pid] .= '<div id="threadindex">'.$nodes.'</div><script type="text/javascript" reload="1">show_threadindex('.$pid.', '.($_GET['from'] == 'preview' ? '1' : '0').')</script>';
    return '';
}

function parseapibegin($linkaddr, $imgflashurl, $w = 0, $h = 0, $type = 0, $s = 0) {
    static $begincontent;
    if ($begincontent || $_GET['from'] == 'preview') {
        return '';
    }
    preg_match("/((https?){1}:\/\/|www\.)[^\[\"']+/i", $imgflashurl, $matches);
    $imgflashurl = $matches[0];
    $fileext = fileext($imgflashurl);
    $randomid = 'swf_'.random(3);
    $w = ($w >=400 && $w <=1024) ? $w : 900;
    $h = ($h >=300 && $h <=640) ? $h : 500;
    $s = $s ? $s*1000 : 5000;
    switch($fileext) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':
            $content = '<img style="position:absolute;width:'.$w.'px;height:'.$h.'px;" src="'.$imgflashurl.'" />';
            break;
        case 'flv':
            $content = '<span id="'.$randomid.'" style="position:absolute;"></span>'.
                '<script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML='.
                'AC_FL_RunContent(\'width\', \''.$w.'\', \'height\', \''.$h.'\', '.
                '\'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', '.
                '\'src\', \''.STATICURL.'image/common/flvplayer.swf\', '.
                '\'flashvars\', \'file='.rawurlencode($imgflashurl).'\', \'quality\', \'high\', '.
                '\'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
            break;
        case 'swf':
            $content = '<span id="'.$randomid.'" style="position:absolute;"></span>'.
                '<script type="text/javascript" reload="1">$(\''.$randomid.'\').innerHTML='.
                'AC_FL_RunContent(\'width\', \''.$w.'\', \'height\', \''.$h.'\', '.
                '\'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', '.
                '\'src\', encodeURI(\''.$imgflashurl.'\'), \'quality\', \'high\', \'bgcolor\', \'#ffffff\', '.
                '\'wmode\', \'transparent\', \'allowfullscreen\', \'true\');</script>';
            break;
        default:
            $content = '';
    }
    if ($content) {
        if ($type == 1) {
            $content = '<div id="threadbeginid" style="display:none;">'.
                '<div class="flb beginidin"><span><div id="begincloseid" class="flbc" title="'.lang('core', 'close').'">'.lang('core', 'close').'</div></span></div>'.
                $content.'<div class="beginidimg" style=" width:'.$w.'px;height:'.$h.'px;">'.
                '<a href="'.$linkaddr.'" target="_blank" style="display: block; width:'.$w.'px; height:'.$h.'px;"></a></div></div>'.
                '<script type="text/javascript">threadbegindisplay(1, '.$w.', '.$h.', '.$s.');</script>';
        } else {
            $content = '<div id="threadbeginid">'.
                '<div class="flb beginidin">
					<span><div id="begincloseid" class="flbc" title="'.lang('core', 'close').'">'.lang('core', 'close').'</div></span>
					</div>'.
					$content.'<div class="beginidimg" style=" width:'.$w.'px; height:'.$h.'px;">'.
					'<a href="'.$linkaddr.'" target="_blank" style="display: block; width:'.$w.'px; height:'.$h.'px;"></a></div>
					</div>'.
					'<script type="text/javascript">threadbegindisplay('.$type.', '.$w.', '.$h.', '.$s.');</script>';
        }
    }
    $begincontent = $content;
    return $content;
}
?>