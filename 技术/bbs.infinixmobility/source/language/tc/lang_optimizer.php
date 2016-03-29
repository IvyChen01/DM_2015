<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_optimizer.php 33906 2013-08-29 09:40:37Z jeffjzhang $
 *	Modified by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'optimizer_dbbackup_advice' => '三個月沒有進行數據備份了,建議立即備份數據',
	'optimizer_dbbackup_lastback' => '上次數據備份於',
	'optimizer_dbbackup_clean_safe' => '沒有檢測到數據庫備份文件，無安全問題',
	'optimizer_dbbackup_clean_delete' => '檢測到 {filecount} 個數據備份文件(目錄: ./data/backup_xxx)，<br>請盡快手工複製到安全位置備份，然後刪除這些文件',
	'optimizer_filecheck_advice' => '三個月沒有進行文件校驗了,建議立即進行校驗',
	'optimizer_filecheck_lastcheck' => '上次文件校驗於',
	'optimizer_log_clean' => '有 {count} 個日誌表可以清理優化',
	'optimizer_log_not_found' => '未發現可清理的日誌表',
	'optimizer_patch_have' => '您有 {patchnum} 個，請盡快更新',
	'optimizer_patch_check_safe' => '檢測安全',
	'optimizer_plugin_new_plugin' => '您有 {newversion} 款應用有可用更新',
	'optimizer_plugin_no_upgrade' => '不需要應用更新',
	'optimizer_post_need_split' => '帖子表及分表有 {count} 個需要優化',
	'optimizer_post_not_need' => '不需要優化',
	'optimizer_seo_advice' => '建議您完善SEO設置',
	'optimizer_seo_no_need' => '發現已經完善了seo設置',
	'optimizer_setting_cache_index' => '緩存論壇首頁',
	'optimizer_setting_cache_index_desc' => '開啟此功能可減輕服務器負載',
	'optimizer_setting_cache_optimize_desc' => '設置緩存時間為900秒',
	'optimizer_setting_cache_post' => '緩存帖子',
	'optimizer_setting_cache_post_desc' => '開啟此功能可減輕服務器負載',
	'optimizer_setting_cache_post_optimize_desc' => '設置緩存時間為900秒',
	'optimizer_setting_optimizeviews' => '優化更新主題瀏覽量',
	'optimizer_setting_optimizeviews_desc' => '開啟此功能可減輕更新主題瀏覽量時對服務器產生的負載',
	'optimizer_setting_optimizeviews_optimize_desc' => '開啟此功能',
	'optimizer_setting_delayviewcount' => '附件下載量延遲更新',
	'optimizer_setting_delayviewcount_desc' => '延遲更新附件的瀏覽量，可明顯降低訪問量很大的站點的服務器負擔',
	'optimizer_setting_delayviewcount_optimize_desc' => '開啟此功能',
	'optimizer_setting_preventrefresh' => '查看數開啟防刷新',
	'optimizer_setting_preventrefresh_desc' => '開啟防刷新，可明顯降低服務器壓力',
	'optimizer_setting_preventrefresh_optimize_desc' => '開啟此功能',
	'optimizer_setting_nocacheheaders' => '禁止瀏覽器緩衝',
	'optimizer_setting_nocacheheaders_desc' => '可用於解決極個別瀏覽器內容刷新不正常的問題，本功能會加重服務器負擔',
	'optimizer_setting_nocacheheaders_optimize_desc' => '關閉此功能',
	'optimizer_setting_jspath' => 'JS 文件緩存',
	'optimizer_setting_jspath_desc' => '當腳本為緩存目錄時，系統會將默認目錄中的 *.js 文件進行壓縮然後保存到緩存目錄以提高讀取速度',
	'optimizer_setting_jspath_optimize_desc' => '修改js路徑到緩存目錄',
	'optimizer_setting_lazyload' => '圖片延時加載',
	'optimizer_setting_lazyload_desc' => '頁面中的圖片在瀏覽器的當前窗口時再加載，可明顯降低訪問量很大的站點的服務器負擔',
	'optimizer_setting_lazyload_optimize_desc' => '開啟此功能',
	'optimizer_setting_sessionclose' => '關閉session機制',
	'optimizer_setting_sessionclose_desc' => '關閉session機制以後，可明顯降低站點的服務器負擔，建議在線用戶數超過2萬時開啟本功能<br>注意：遊客數和用戶的在線時長將不再進行統計，論壇首頁和版塊列表頁面的在線用戶列表功能將不可用',
	'optimizer_setting_sessionclose_optimize_desc' => '開啟此功能',
	'optimizer_setting_need_optimizer' => '有 {count} 個設置項可以優化',
	'optimizer_setting_no_need' => '設置項無需優化',
	'optimizer_thread_need_optimizer' => '需要優化您的主題表了',
	'optimizer_thread_no_need' => '不需要優化',
	'optimizer_upgrade_need_optimizer' => '有新版本，及時更新到最新版本',
	'optimizer_upgrade_no_need' => '已經是最新版',
	'optimizer_setting_rewriteguest' => 'Rewrite僅針對遊客',
	'optimizer_setting_rewriteguest_desc' => '開啟此項，則 Rewrite功能只對遊客和搜索引擎有效，可減輕服務器負擔',
	'optimizer_setting_rewriteguest_optimize_desc' => '開啟此功能',
	'optimizer_inviteregister_tip' => '註冊項中開啟邀請註冊後,設置不受邀請碼限制的地方列表,適合地方社區設置',
	'optimizer_iniviteregister_normal' => '檢測設置正常',
	'optimizer_emailregister_normal' => '已設置該項,請查看是否配置郵件服務器',
	'optimizer_emailregister_tip' => '此設置可以提升用戶質量',
	'optimizer_pwlength_need' => '密碼最小長度過低，不安全',
	'optimizer_pwlength_no_need' => '經檢測密碼長度設置正常',
	'optimizer_regmaildomain_need' => '需要優化黑名單列表',
	'optimizer_regmaildomain_tip' => '可以設置郵箱域名限制阻止垃圾註冊',
	'optimizer_ipregctrl_no_need' => '已經設置了限時註冊IP列表',
	'optimizer_ipregctrl_tip' => '當有某些IP段在惡意註冊時，可以將惡意的IP地址錄入',
	'optimizer_newbiespan_no_need' => '已經設置了見習時間',
	'optimizer_newbiespan_need' => '設置一下見習時間更安全',
	'optimizer_editperdel_no_need' => '已經設置了此設置項',
	'optimizer_editperdel_need' => '需要優化此項',
	'optimizer_recyclebin_no_need' => '版塊都已經開啟回收站了',
	'optimizer_recyclebin_need' => '版塊沒有開啟回收站<br>{forumdesc}',
	'optimizer_forumstatus_no_need' => '無隱藏版塊或者隱藏版塊都已經設置了訪問權限',
	'optimizer_forumstatus_need' => '隱藏版塊還沒有設置訪問權限<br>{forumdesc}',
	'optimizer_usergroup9_no_need' => '限制會員用戶組設置正常',
	'optimizer_usergroup9_need' => '請關閉 "{desc}" 這些選項',
	'optimizer_usergroup4_need' => '請關閉 "{desc}" 這些選項',
	'optimizer_usergroup5_need' => '請關閉 "{desc}" 這些選項',
	'optimizer_usergroup6_need' => '請關閉 "{desc}" 這些選項',
	'optimizer_usergroup_need_allowsendpm' => '是否允許發短消息',
	'optimizer_usergroup_need_allowposturl' => '是否允許發站外URL',
	'optimizer_usergroup_need_allowgroupposturl' => '群組是否允許發站外URL',
	'optimizer_usergroup_need_allowpost' => '允許發新話題',
	'optimizer_usergroup_need_allowreply' => '允許發表回復',
	'optimizer_usergroup_need_allowdirectpost' => '允許直接發帖',
	'optimizer_usergroup_need_allowgroupdirectpost' => '群組允許直接發帖',
	'optimizer_usergroup4_no_need' => '禁止發言用戶組設置正常',
	'optimizer_usergroup5_no_need' => '禁止訪問用戶組設置正常',
	'optimizer_usergroup6_no_need' => '禁止IP用戶組設置正常',
	'optimizer_cloudsecurity_no_need' => '防水牆已開啟',
	'optimizer_cloudsecurity_need' => '防水牆可以有效的防止垃圾帖,提升網站內容質量,降低管理成本，非常建議安裝此應用',
	'optimizer_cloudsecurity_setting_need' => '防水牆設置被修改',
	'optimizer_attachexpire_need' => '設置後可以起到防盜鏈的作用',
	'optimizer_attachexpire_no_need' => '已經設置了此項',
	'optimizer_attachrefcheck_need' => '設置後可以起到防盜鏈的作用',
	'optimizer_attachrefcheck_no_need' => '已經設置了此項',
	'optimizer_loginpwcheck_need' => '弱密碼登錄檢測未開啟',
	'optimizer_loginpwcheck_no_need' => '弱密碼登錄檢測已開啟',
	'optimizer_loginoutofdate_need' => '異常登錄檢測未開啟',
	'optimizer_loginoutofdate_no_need' => '異常登錄檢測已開啟',
	'optimizer_postqqonly_need' => '發帖需要綁定QQ號檢測未開啟',
	'optimizer_postqqonly_no_need' => '發帖需要綁定QQ號檢測已開啟',
	'optimizer_aggid_need' => '「管理員，超級版主，版主」QQ登錄檢測未開啟',
	'optimizer_aggid_no_need' => '「管理員，超級版主，版主」QQ登錄檢測已開啟',
	'optimizer_eviluser_need' => '防水牆識別到違規用戶，請及時處理',
	'optimizer_eviluser_no_need' => '未發現違規用戶',
	'optimizer_white_list_need' => '您設置了防水牆白名單，白名單用戶發垃圾貼不被處理，請慎重',
	'optimizer_white_list_no_need' => '未設置白名單',
	'optimizer_security_daily_need' => '開啟防水牆每日優化，可清除刪帖後首頁痕跡',
/*vot*/	'optimizer_security_daily_no_need' => '該計劃任務已開啟',
);
?>