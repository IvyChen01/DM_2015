<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_comment_consume extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_comment_consume';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function fetch_all_by_upid($upid,$bid,$nid){
		return DB::fetch_all('select * from %t where upid=%d and bid=%d and cid=%d order by id desc',array($this->_table,$upid,$bid,$nid));
	}
	public function count_by_bid_all($nid){
		return DB::result_first('select count(*) from %t where cid=%d',array($this->_table,$nid));
	}
	public function fetch_all_by_bid_page($nid,$start,$perpage){
		return DB::fetch_all('select * from %t where cid=%d order by id desc limit %d,%d ',array($this->_table,$nid,$start,$perpage));
	}
}




?>