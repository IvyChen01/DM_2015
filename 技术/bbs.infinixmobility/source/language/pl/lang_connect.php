<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $ID: lang_connect.php by Valery Votintsev at 
 *      polish language pack by kaaleth ( kaaleth-discuzpl@windowslive.com )
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(

	'feed_sync_success'		=> 'Kanał aktywności został pomyślnie zsynchronizowany',//'同步发 Feed 成功',
	'deletethread_sync_success'	=> 'Temat został pomyślnie usunięty',//'删除主题同步成功',
	'deletethread_sync_failed'	=> 'Wystąpił błąd podczas usuwania tematu',//'删除主题同步失败',
	'server_busy'			=> 'Przepraszamy, wystąpił błąd sieci lub serwer jest zajęty. Proszę spróbować później. Dziękujemy.',//'抱歉，当前存在网络问题或服务器繁忙，请您稍候再试。谢谢。',
	'share_token_outofdate'		=> 'W celu zwiększenia bezpieczeństwa konta, ponownie zaloguj się za pośrednictwem serwisu QQ i aktywuj mechanizm ochronny.<br/><br/>Kliknij <a href={login_url}><img src=static/image/common/qq_login.gif class=vm alt="QQ login" /></a>, zostaniesz przekierowany automatycznie',//'为了您的账号安全，请使用QQ帐号重新登录，将为您升级帐号安全机制<br/><br/>点击<a href={login_url}><img src=static/image/common/qq_login.gif class=vm alt=QQ登录 /></a>页面将发生跳转',
	'share_success'			=> 'Udostępniono pomyślnie',//'分享成功',
	'broadcast_success'		=> 'Pomyślnie uruchomiono transmisje broadcast',//'转播成功',

	'qzone_title'			=> 'Tytuł',//'标题',
	'qzone_reason'			=> 'Powód',//'理由',
	'qzone_picture'			=> 'Obrazek',//'图片',
	'qzone_shareto'			=> 'Udostępnij w przestrzeni p QQ',//'分享到QQ空间',
	'qzone_to_friend'		=> 'Udostępnij znajomym',//'分享给好友',
	'qzone_reason_default'		=> 'Możesz podać powód lub szczegóły udostępnienia',//'可以在这里输入分享原因或详细内容',
	'qzone_subject_is_empty'	=> 'Tytuł udostępnienia nie może być pusty',//'分享标题不能为空',
	'qzone_subject_is_long'		=> 'Tytuł udostępnienia przekracza dopuszczalny limit znaków',//'分享标题超过了长度限制',
	'qzone_reason_is_long'		=> 'Powód udostępnienia przekracza dopuszczalny limit znaków',//'分享理由超过了长度限制',
	'qzone_share_same_url'		=> 'Udostępniłeś już to wcześniej! Prosimy nie wysyłać duplikatów.',//'该帖子您已经分享过，不需要重复分享',

	'weibo_title'			=> 'Udostępnij do mojego mikrobloga. Swoją drogą, napisz cokolwiek!',//'分享到我的微博，顺便说点什么吧',
	'weibo_input'			=> 'Możesz wykorzystać <strong id=checklen></strong> znaków',//'还能输入<strong id=checklen></strong>字',
	'weibo_select_picture'		=> 'Proszę wybrać obrazek do udostępnienia',//'请选择分享图片',
	'weibo_share'			=> 'Udostęnij',//'转播',
	'weibo_share_to'		=> 'Udostępnij do platformy Tencent',//'转播到腾讯微博',
	'weibo_reason_is_long'		=> 'Zawartość przekracza dopuszczalny limit znaków',//'微博内容超过了长度限制',
	'weibo_same_content'		=> 'Udostępniłeś już to wcześniej! Prosimy nie wysyłać duplikatów.',//'该帖子您已经转播过，不需要重复转播',
	'weibo_account_not_signup'	=> 'Przepraszamy, nie jesteś zarejestrowanym użytkownikiem. Nie możesz udostępnić żadnej zawartości. <a href=http://t.qq.com/reg/index.php target=_blank style=color:#336699>Kliknij tutaj, aby się zarejestrować</a>.',//'抱歉，您还未开通微博账号，无法分享内容，<a href=http://t.qq.com/reg/index.php target=_blank style=color:#336699>点击这里马上开通</a>',
	'user_unauthorized'		=> 'Przepraszamy, nie jesteś zalogowanym użytkownikiem. Nie możesz udostępniać żadnej zawartości. Kliknij <a href={login_url}><img src=static/image/common/qq_login.gif class=vm alt="QQ Login"/></a>, aby zalogować się.',//'抱歉，您未授权分享主题到QQ空间、腾讯微博和腾讯朋友，点击<a href={login_url}><img src=static/image/common/qq_login.gif class=vm alt=QQ登录 /></a>，马上完善授权',

	'connect_errlog_server_no_response'		=> 'Serwer nie odpowiada',//'服务器无响应',
	'connect_errlog_access_token_incomplete'	=> 'Interface AccessToken returned incomplete data',//'接口返回的AccessToken数据不完整',
	'connect_errlog_request_token_not_authorized'	=> 'User TmpToken is unauthorized or return incomplete data',//'用户TmpToken未授权或返回的数据不完整',
	'connect_errlog_sig_incorrect'			=> 'URL sygnatury jest nieprawidłowy',//'URL签名不正确',

	'connect_tthread_broadcast'	=> 'Transmisja broadcast do mikrobloga',//'转播微博',
	'connect_tthread_message'	=> '<br><br><img class="vm" src="static/image/common/weibo.png">&nbsp;<a href="http://t.qq.com/{username}" target="_blank">Od {nick} w serwisie Tencent microblog</a>',//'<br><br><img class="vm" src="static/image/common/weibo.png">&nbsp;<a href="http://t.qq.com/{username}" target="_blank">来自 {nick} 的腾讯微博</a>',
	'connect_tthread_comment'	=> 'Komentarze do mikrobloga',//'微博评论',
);

