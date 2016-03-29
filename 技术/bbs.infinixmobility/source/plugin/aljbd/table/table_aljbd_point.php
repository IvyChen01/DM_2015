<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_point extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_point';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function count_by_buid($buid){
		return DB::result_first('select count(*) from %t where buid=%d',array($this->_table,$buid));
	}
	public function fetch_all_by_buid($buid,$start,$perpage){
		return DB::fetch_all('select * from %t where buid=%d order by id desc limit %d,%d ',array($this->_table,$buid,$start,$perpage));
	}

}




?>