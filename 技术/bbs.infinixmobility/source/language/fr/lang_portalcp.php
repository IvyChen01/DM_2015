<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *      Traduction par Andre13 27.12.2011 - Support In French discuz-fr.fr
 *      $Id: lang_portalcp.php by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array(
	'block_diy_nopreview'		=> '<p>Ce module contient du js, vous ne pouvez pas pr&#233;visualiser, Svp. veuillez enregistrer et afficher</p>',  //  '<p>This module contain js, you cannot preview, please save and view</p>'  
	'block_diy_summary_html_tag'	=> 'Erreurs personnalis&#233; de son contenu , sans doute les balises HTML:',  //  'Custom content errors, HTML tags:'  
	'block_diy_summary_not_closed'	=> ' Ne correspond pas',  // ' Does not match'   
	'block_all_category'		=> 'Toutes Cat&#233;gories',  //  All categories  
	'block_first_category'		=> 'Top Cat&#233;gories',  // Top category   
	'block_all_forum'		=> 'Tout Forums',  //  All forums  
	'block_all_group'		=> 'Tout Groupes Utilisateurs',  //  All usergroups  
	'block_all_type'		=> 'Toutes cat&#233;gories',  // All categories   
	'file_size_limit'		=> 'Le Fichier est plus grand que {size} kio, Svp. retour.',  //  File is larger than {size} kb, please return.  
	'set_to_conver'			=> 'D&#233;finir comme cover',  //  Set as cover  
	'small_image'			=> 'Petite image',//'小图',  //   'Small image',
	'insert_small_image'		=> 'Ins&#233;rez la petite image',  //  Insert small image  
	'insert_large_image'		=> 'Ins&#233;rer image de grande taille',  //   Insert large image 
	'insert_file'			=> 'Ins&#233;rer Fichier',  // Insert file   
	'delete'			=> 'Supprimer',  //  Delete  
	'upload_error'			=> 'T&#233;l&#233;chargement a &#233;chou&#233;',  //   Uploading failed 
	'upload_remote_failed'		=> 'T&#233;l&#233;chargement distant a &#233;chou&#233;',  // Remote uploading failed   
	'article_noexist'		=> 'Arcticle particulier inexistant',  // Specific arcticle does not exists   
	'article_noallowed'		=> 'Vous n&#180;&#234;tes pas autoris&#233; &#224; op&#233;rer cet article',  //  You are not allowed to operate this article  
	'article_publish_noallowed'	=> 'Vous n&#180;&#234;tes pas autoris&#233; &#224; publier cet article',  //  You are not allowed to publish article  
	'article_category_empty'	=> 'D&#233;sol&#233;, cette cat&#233;gorie ne peut pas &#234;tre vide',//'抱歉，栏目不能为空',  // 'Sorry, the category can not be empty',
	'article_edit_nopermission'	=> 'D&#233;sol&#233;, vous n&#180;avez pas l&#180;autorisation de modifier l\'article actuel',//'抱歉，您没有权限进行当前文章操作', //  'Sorry, you do not have permission to edit current article',
	'article_publish'		=> 'Publiez',  //   Publish 
	'article_manage'		=> 'G&#233;rer',  //   Manage 
	'article_tag'			=> 'Tag',  //  Tag  
	'select_category'		=> 'Choix Cat&#233;gorie',  //   Select category 
	'blockstyle_diy'		=> 'Personnalisez Mod&#232;le',  //  Customize template  

	'article_pushplus_info'	=> '<p><center><i><a href="{url}" class="xg1 xs1">Le contenu est fourni par {author}</a></i><center></p>',  //  '<p><center><i><a href="{url}" class="xg1 xs1">The content is provided by {author}</a></i><center></p>'  

	'diytemplate_name_null'	=> '[Null]',  //  '[Null]'  
	'portal_view_name'		=> ' Article vu(s) par page',//' 文章查看页',  // Article view page
	'forum_viewthread_name'		=> ' Posts Vu(s) par Page',//' 帖子查看页', //  ' Posts View Page',
	'portal/index'		=> 'Index du Portail',  // Portal Index   
	'portal/list'		=> 'Article liste page(public)',  //   Article list page(public) 
	'portal/view'		=> 'Article contenu page(public)',  // Article content page(public)   
	'portal/comment'	=> 'Article comment. page',  //  Article comment page  
	'forum/discuz'		=> 'Forum Index',  // Forum Index   
	'forum/viewthread'	=> 'Posts contenu page(public)',  // Posts content page(public)   
	'forum/forumdisplay'	=> 'Forum liste page(public)',  // Forum list page(public)   
	'group/index'		=> $_G['setting']['navs'][3]['navname'].' Index',  //  ' Index'  
	'group/group_my'	=> 'Mon'.$_G['setting']['navs'][3]['navname'].' Index',  // ' Index'    //   'My'.$_G['setting']['navs'][3]['navname'].' Index',
	'group/group'		=> $_G['setting']['navs'][3]['navname'].' contenu page',  // ' content page'   
	'home/space_home'	=> 'Espace Index',  // Space Index   
	'home/space_trade'	=> 'Espace page Commerce',  // Space trade page   
	'home/space_top'	=> 'Espace page Rang',  // Space ranking page   
	'home/space_thread'	=> 'Espace page Sujet',  // Space thread page   
	'home/space_reward'	=> 'Espace page Bonus',  //  Space reward page  
	'home/space_share_list'	=> 'Espace page Partage',  // Space share page   
	'home/space_share_view'	=> 'Espace page Partage contenu',  //  Space share content page  
	'space_share_view'	=> 'Espace page Partage vue',  //  Space share view page  
	'home/space_poll'	=> 'Espace page Sondage',  //  Space poll page  
	'home/space_pm'		=> 'Espace page M.P.',  // Space P.M. page   
	'home/space_notice'	=> 'Espace Page Avis',  //  Space notice page  
	'home/space_group'	=> 'Espace'.$_G['setting']['navs'][3]['navname'].' page',  // ' page'   
	'home/space_friend'	=> 'Espace page Amis',  // Space friends page   
	'home/space_favorite'	=> 'Espace Page Favoris',  // Space favorite page   
	'home/space_doing'	=> 'Espace page Agiss.',  //  Space doing page  
	'home/space_debate'	=> 'Espace page D&#233;bats',  // Space debate page   
	'home/space_blog_view'	=> 'Espace contenu page du Blog',  //  Space blog content page  
	'home/space_blog_list'	=> 'Espace liste page du Blog ',  //  Space blog list page  
	'home/space_album_view'	=> 'Espace contenu page Album',  // Space album content page   
	'home/space_album_pic'	=> 'Espace contenu page Image',  // Space image content page   
	'home/space_album_list'	=> 'Espace liste page Album',  //  Space album list page  
	'home/space_activity'	=> 'Espace Page Activit&#233;',  // Space activity page   
	'ranklist/ranklist'	=> 'Espace liste page Rang ',  // Space ranking list page   
	'ranklist/blog'		=> 'Blog page Rang',  //    Blog ranking page
	'ranklist/poll'		=> 'Sondage page Rang',  //  Poll ranking page  
	'ranklist/activity'	=> 'Activit&#233; page Rang',  //  Activity ranking page  
	'ranklist/forum'	=> 'Forum page Rang',  // Forum ranking page   
	'ranklist/picture'	=> 'Image page Rang',  //  Image ranking page  
	'ranklist/group'	=> 'Groupe page Rang',  //  Group ranking page  
	'ranklist/thread'	=> 'Posts page Rang',  // Posts ranking page   
	'ranklist/member'	=> 'Utilisateurs page Rang',  // Users ranking page   
	'other_page'		=> 'Aucun Module BRICO',  //   Not DIY module 
	'upload'		=> 'Charger',  //   Upload 
	'remote'		=> 'Distant',  //   Remote 
	'portal_index'		=> 'Accueil du Portail',  //  Portal Home  
	'portal_topic_blue'	=> 'Th&#232;me Bleu',  //  Blue theme  
	'portal_topic_green'	=> 'Th&#232;me Vert',  // Green theme   
	'portal_topic_grey'	=> 'Th&#232;me Gris',  //  Grey theme  
	'portal_topic_red'	=> 'Th&#232;me Rouge',  //  Red theme  

	'itemtypename0'			=> 'Auto',//'自动',
	'itemtypename1'			=> '<span style="color: #FF0000">est r&#233;par&#233;</span>',//'<span style="color: #FF0000">固定</span>',  //  '<span style="color: #FF0000">Fixed</span>',
	'itemtypename2'			=> '<span style="color: #00BFFF">a &#233;t&#233; modifi&#233;</span>',//'<span style="color: #00BFFF">编辑</span>',  //  '<span style="color: #00BFFF">Edit</span>',
	'itemtypename3'			=> '<span style="color: #0000FF">a &#233;t&#233; appuy&#233; </span>',//'<span style="color: #0000FF">推送</span>',  //  '<span style="color: #0000FF">Push</span>',

);