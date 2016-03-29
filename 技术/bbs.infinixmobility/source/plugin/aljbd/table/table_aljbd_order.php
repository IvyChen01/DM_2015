<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljbd_order extends discuz_table {

    public function __construct() {

        $this->_table = 'aljbd_order';
        $this->_pk = 'orderid';

        parent::__construct();
    }
	public function fetch_all_by_uid($uid){
		return DB::fetch_all('select * from %t where uid=%d order by submitdate desc',array($this->_table,$uid));
	}
	public function fetch_all_by_sid($sid,$start,$perpage){
		return DB::fetch_all('select * from %t where sid=%d group by uid  order by submitdate desc limit %d,%d',array($this->_table,$sid,$start,$perpage));
	}
	public function update_status_by_orderid($orderid){
		DB::query('update %t set status=3 where orderid=%s',array($this->_table,$orderid));
	}
}

?>