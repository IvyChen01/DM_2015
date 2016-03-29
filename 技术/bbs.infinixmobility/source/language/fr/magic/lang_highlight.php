<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_highlight.php by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'highlight_name'		=> 'Carte de couleur',   // Color card 
	'highlight_desc'		=> 'Surlignez le titre des Sujets',   // Highlight the title of threads // OU Mettre en surbrillance le titre des sujets
	'highlight_expiration'		=> 'Expiration',   //  Expiration
	'highlight_expiration_comment'	=> 'R&#233;glez le temps de mettre en &#233;vidence, par d&#233;faut est de 24 heures',   //  Set the time of highlighting, default is 24 hours
	'highlight_forum'		=> 'Forums Autoris&#233;s',   //  Allowed forums
	'highlight_info_tid'		=> 'Mettez en surbrillance sujet spcifique {expiration} hr, entrer ID du sujet thread',   // Highlight specific thread {expiration} hr, enter thread ID 
	'highlight_info_blogid'		=> 'Vous pouvez choisir le programme ou le titre du message et ainsi pouvoir changer la couleur',//'可以将日志或帖子的标题高亮，变更颜色', // 'You can highlight the log or the post title, change the color',
	'highlight_color'		=> 'Couleur',   // Color 
	'highlight_info_nonexistence_tid'	=> 'Svp. Veuillez sp&#233;cifi&#233; le Sujet',   //  Please specific thread
	'highlight_info_nonexistence_blogid'	=> 'Veuillez pr&#233;ciser le blog afin de le mettre en surbrillance',//'请指定要高亮的日志', // 'Please specify the blog to highlight',
	'highlight_succeed_tid'		=> 'Mis en surbrillance du sujet avec Succ&#232;s',   //  Highlight thread successfully
	'highlight_succeed_blogid'	=> 'Votre Blog a &#233;t&#233; mis en surbrillance',//'你操作的日志已高亮', // 'You have been highlighted the blog',
	'highlight_info_noperm'		=> 'D&#233;sol&#233;, vous ne pouvez pas utilisez cette accessoire dans ce forum',   //  Sorry, you cannot use this props in this forum
	'highlight_info_notype'		=> 'Erreur de param&#232;tre, le type d\'op&#233;ration n\'est pas pr&#233;cis.',//'参数错误，没有指定操作类型。', // 'Parameter error, operation type is not specified.',

	'highlight_notification'	=> 'Votre sujet <em>{subject}</em> a &#233;t&#233; utilis&#233; {magicname} par {actor}, <a href="forum.php?mod=viewthread&tid={tid}">voir</a>.',   // Your thread <em>{subject}</em> was used {magicname} by {actor}, <a href="forum.php?mod=viewthread&tid={tid}">view</a>. 
	'highlight_notification_blogid'	=> 'Cet Utilisateur {actor} a utilis&#233; une magie {magicname} sur votre blog {subject}, <a href="home.php?mod=space&do=blog&id={blogid}">Allez-y voir!</a>',//'你的日志 {subject} 被 {actor} 使用了{magicname}，<a href="home.php?mod=space&do=blog&id={blogid}">快去看看吧！</a>', // 
);

