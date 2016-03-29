<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_admincp_menu.php 34034 2013-09-24 01:23:05Z nemohou $
 *	Modified by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(


	'header_index' => '首頁',
	'header_global' => '全局',
	'header_forum' => '論壇',
	'header_user' => '用戶',
	'header_topic' => '內容',
	'header_extended' => '運營',
	'header_plugin' => '應用',
	'header_style' => '界面',
	'header_adv' => '廣告',
	'header_tools' => '工具',
	'header_uc' => 'UCenter',
	'header_welcome' => '您好',
	'header_logout' => '退出',
	'header_bbs' => '站點首頁',
	'header_portal' => '門戶',
	'header_group' => '群組',
	'header_safe' => '防灌水',
	'header_founder' => '站長',
	'header_cloudaddons' => '應用中心',


	'menu_home' => '管理中心首頁',
	'menu_home_clearhistorymenus' => '清空歷史操作',

	'menu_setting_basic' => '站點信息',
	'menu_setting_access' => '註冊與訪問控制',
	'menu_setting_customnav' => '導航設置',
	'menu_setting_styles' => '界面設置',
	'menu_setting_optimize' => '性能優化',
	'menu_setting_seo' => 'SEO設置',
	'menu_setting_functions' => '站點功能',
	'menu_setting_domain' => '域名設置',
	'menu_setting_user' => '用戶權限',
	'menu_setting_credits' => '積分設置',
	'menu_setting_mail' => '郵件設置',
	'menu_setting_sec' => '防灌水設置',
	'menu_setting_datetime' => '時間設置',
	'menu_setting_attachments' => '上傳設置',
	'menu_setting_imgwater' => '水印設置',
	'menu_setting_uc' => 'UCenter 設置',
	'menu_setting_uchome' => 'UCHome 設置',
	'menu_setting_follow' => '廣播設置',
	'menu_setting_home' => '空間設置',
	'menu_setting_search' => '搜索設置',
	'menu_setting_district' => '地區設置',
	'menu_setting_ranklist' => '排行榜設置',
	'menu_setting_mobile' => '手機版訪問設置',
	'menu_setting_tag' => '標籤管理',
	'menu_setting_antitheft' => '防採集設置',

	'menu_forums' => '版塊管理',
	'menu_forums_merge' => '版塊合併',
	'menu_forums_threadtypes' => '主題分類',
	'menu_forums_infotypes' => '分類信息',
	'menu_forums_infooption' => '分類信息選項',
	'menu_grid' => '首頁四格',

	'menu_members_add' => '添加用戶',
	'menu_members_edit' => '用戶管理',
	'menu_members_newsletter' => '發送通知',
	'menu_members_mobile' => '發送手機通知',
	'menu_usertag' => '用戶標籤',
	'menu_members_edit_ban_user' => '禁止用戶',
	'menu_members_ipban' => '禁止 IP',
	'menu_members_credits' => '積分獎懲',
	'menu_members_profile' => '用戶欄目',
	'menu_members_profile_group' => '用戶欄目分組',
	'menu_members_verify_setting' => '認證設置',
	'menu_members_stat' => '資料統計',
	'menu_moderate_modmembers' => '審核用戶',
	'menu_profilefields' => '用戶欄目定制',
	'menu_admingroups' => '管理組',
	'menu_usergroups' => '用戶組',
	'menu_follow' => '推薦關注',
	'menu_defaultuser' => '推薦好友',

	'menu_moderate_posts' => '內容審核',
	'menu_moderate_blogs' => '審核日誌',
	'menu_moderate_doings' => '審核記錄',
	'menu_moderate_pictures' => '審核圖片',
	'menu_moderate_shares' => '審核分享',
	'menu_moderate_comments' => '審核評論/留言',
	'menu_moderate_articles' => '審核文章',
	'menu_moderate_articlecomments' => '審核文章評論',
	'menu_maint_threads' => '論壇主題管理',
	'menu_maint_prune' => '論壇批量刪帖',
	'menu_maint_attaches' => '論壇附件管理',
	'menu_maint_threads_group' => '群組主題管理',
	'menu_maint_prune_group' => '群組批量刪帖',
	'menu_maint_attaches_group' => '群組附件管理',
	'menu_setting_collection' => '淘帖管理',
	'menu_posting_tags' => '標籤管理',
	'menu_posting_censors' => '詞語過濾',
	'menu_maint_report' => '用戶舉報',
	'menu_threads_forumstick' => '版塊/群組置頂',
	'menu_post_position_index' => '帖子優化',
	'menu_postcomment' => '帖子點評管理',
	'menu_maint_doing' => '記錄管理',
	'menu_maint_blog' => '日誌管理',
	'menu_maint_blog_recycle_bin' => '日誌回收站',
	'menu_maint_feed' => '動態管理',
	'menu_maint_album' => '相冊管理',
	'menu_maint_pic' => '圖片管理',
	'menu_maint_comment' => '評論/留言管理',
	'menu_maint_share' => '分享管理',

	'menu_posting_attachtypes' => '附件類型尺寸',
	'menu_moderate_recyclebin' => '主題回收站',
	'menu_moderate_recyclebinpost' => '回帖回收站',

	'menu_founder' => '站點信息',
	'menu_founder_perm' => '後台管理團隊',
	'menu_founder_groupperm' => '編輯團隊職務權限 - {group}',
	'menu_founder_permgrouplist' => '編輯權限 - {perm}',
	'menu_founder_memberperm' => '編輯團隊成員 - {username}',

	'menu_patch' => '安全中心',
	'menu_upgrade' => '在線升級',
	'menu_optimizer' => '優化大師',
	'menu_security' => '安全大師',

	'menu_addons' => '應用中心',
	'menu_plugins' => '插件',
	'menu_tasks' => '站點任務',
	'menu_magics' => '道具中心',
	'menu_medals' => '勳章中心',
	'menu_misc_help' => '站點幫助',
	'menu_google' => 'Google 搜索',
	'menu_ec' => '電子商務',
	'menu_card' => '充值卡密',

	'menu_styles' => '風格管理',
	'menu_styles_templates' => '模板管理',
	'menu_posting_smilies' => '表情管理',
	'menu_click' => '表態動作',
	'menu_thread_icon' => '主題圖標',
	'menu_thread_stamp' => '主題鑒定',
	'menu_posting_editor' => '編輯器設置',
	'menu_misc_onlinelist' => '在線列表圖標',

	'menu_misc_link' => '友情鏈接',
	'menu_misc_relatedlink' => '關聯鏈接',
	'memu_focus_topic' => '站長推薦',
	'menu_adv_custom' => '站點廣告',

	'menu_misc_announce' => '站點公告',
	'menu_tools_updatecaches' => '更新緩存',
	'menu_tools_postposition' => '高樓帖優化',
	'menu_tools_updatecounters' => '更新統計',
	'menu_tools_javascript' => '數據調用',
	'menu_tools_relatedtag' => ' 標籤聚合',
	'menu_tools_creditwizard' => '積分策略嚮導',
	'menu_tools_fileperms' => '文件權限檢查',
	'menu_tools_hookcheck' => '嵌入點校驗',
	'menu_tools_filecheck' => '文件校驗',
	'menu_forum_scheme' => '站點方案管理',
	'menu_db' => '數據庫',
	'menu_postsplit' => '帖子分表',
	'menu_threadsplit' => '主題分表',
	'menu_membersplit' => '用戶表優化',
	'menu_logs' => '運行記錄',
	'menu_custommenu_manage' => '常用操作管理',
	'menu_misc_cron' => '計劃任務',

	'menu_article' => '文章管理',
	'menu_portalcategory' => '頻道欄目',
	'menu_blogcategory' => '日誌分類',
	'menu_albumcategory' => '相冊分類',
	'menu_block' => '模塊管理',
	'menu_blockstyle' => '模塊模板',
	'menu_portalpermission' => '權限列表',
	'menu_blockxml' => '第三方模塊',
	'menu_topic' => '專題管理',
	'menu_html' => 'HTML管理',
	'menu_diytemplate' => '頁面管理',

	'menu_group_setting' => '群組設置',
	'menu_group_type' => '群組分類',
	'menu_group_manage' => '群組管理',
	'menu_group_userperm' => '群主權限',
	'menu_group_level' => '群組等級',
	'menu_group_mod' => '審核群組',

	'menu_safe_setting' => '基本設置',
	'menu_safe_security' => '防水牆',
	'menu_safe_seccheck' => '驗證設置',
	'menu_safe_accountguard' => '帳號保鏢',

	'menu_setting_manyou' => 'Manyou 設置',
	'menu_setting_qqconnect' => 'QQ 綁定設置',

	'menu_cloud_doctor' => '診斷工具',

	'admincp_title' => $_G['setting']['bbname'].' 管理中心',

// Added by Valery Votintsev
	'menu_setting_language'		=> '語言',//'Languages',
);

