<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljlp_user extends discuz_table {

    public function __construct() {

        $this->_table = 'aljlp_user';
        $this->_pk = 'uid';
        parent::__construct();
    }
    public function update_count_by_uid($uid){
        return DB::query('update %t set count=count+1 where uid=%d',array($this->_table,$uid));
    }
    public function update_updatecount_by_uid($uid){
        return DB::query('update %t set updatecount=updatecount+1 where uid=%d',array($this->_table,$uid));
    }
    public function update_top_by_uid($uid){
        return DB::query('update %t set top=top+1 where uid=%d',array($this->_table,$uid));
    }
    public function update_last_by_uid($uid){
        return DB::query('update %t set last=%d where uid=%d',array($this->_table,TIMESTAMP,$uid));
    }

}

?>