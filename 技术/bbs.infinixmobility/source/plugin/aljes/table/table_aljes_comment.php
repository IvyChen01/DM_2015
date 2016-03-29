<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljes_comment extends discuz_table {

    public function __construct() {

        $this->_table = 'aljes_comment';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function fetch_all_by_upid($upid,$lid){
		return DB::fetch_all('select * from %t where upid=%d and lid=%d  order by id desc',array($this->_table,$upid,$lid));
	}
	public function count_by_bid_all($nid){
		return DB::result_first('select count(*) from %t where lid=%d',array($this->_table,$nid));
	}
	public function fetch_all_by_bid_page($nid,$start,$perpage){
		return DB::fetch_all('select * from %t where lid=%d order by id desc limit %d,%d ',array($this->_table,$nid,$start,$perpage));
	}

}

?>