<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :infinixbbs_common_member_dailycount表
* @date: 2015年6月26日 下午12:09:23
* @author: yanhui.chen
* @version:
*/
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class table_common_member_dailycount extends discuz_table{

    public function __construct() {
    
        $this->_table = 'common_member_dailycount';
        $this->_pk    = 'id';
        
        parent::__construct();
    }
}