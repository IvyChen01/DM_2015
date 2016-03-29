<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_winfo extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_winfo';
			$this->_pk    = 'uid';

			parent::__construct();
	}
	public function count_by_bid($bid){
		return DB::result_first('select count(*) from %t where bid=%d',array($this->_table,$bid));
	}
	public function fetch_all_by_bid($bid,$start,$perpage){
		return DB::fetch_all('select * from %t where bid=%d order by id desc limit %d,%d ',array($this->_table,$bid,$start,$perpage));
	}

}




?>