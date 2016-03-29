<?php
/**
 * Copyright @ 2013 Infinix. All rights reserved.
 * ==============================================
 * @Description :定时从数据库中获取数据插入infinixbbs_common_member_dailycount表中
 * @date: 2015年6月26日 上午10:32:30
 * @author: yanhui.chen
 * @version:
 */
if (! defined('IN_DISCUZ')) {
    exit('Access Denied');
}
$member_daily_count = & C::t('common_member_dailycount');
$query = DB::query("SELECT m.uid,mc.threads, mc.posts,mc.oltime, m.credits
			FROM " . DB::table('common_member') . " m
			LEFT JOIN " . DB::table('common_member_count') . " mc ON mc.uid=m.uid ");

while ($member = DB::fetch($query)) {
    $data = array(
      'uid' => $member['uid'],
      'date' => date("Y-m-d",time()),  
      'threads' => $member['threads'],
      'posts'   => $member['posts'],
      'oltime'  => $member['oltime'],
      'credits' => $member['credits'],    
    );
    $member_daily_count->insert($data);
}


		