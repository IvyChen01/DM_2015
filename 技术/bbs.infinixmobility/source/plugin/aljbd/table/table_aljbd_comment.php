<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_comment extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_comment';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function fetch_by_bid($bid){
		return DB::fetch_first('select * from %t where bid=%d and upid=0 and uid!=0',array($this->_table,$bid));
	}
	public function count_by_bid_upid($bid,$upid,$ask){
		return DB::result_first('select count(*) from %t where bid=%d and upid=%d and ask=%d and uid!=0',array($this->_table,$bid,$upid,$ask));
	}
	public function fetch_all_by_bid_upid($bid,$upid,$ask){
		return DB::fetch_all('select * from %t where bid=%d and upid=%d and ask=%d and uid!=0 order by id desc',array($this->_table,$bid,$upid,$ask));
	}
	public function fetch_all_by_upid($upid){
		return DB::fetch_all('select * from %t where upid=%d order by id desc',array($this->_table,$upid));
	}
	public function count_by_bid($bid){
		return DB::fetch_all('select avg(k) k,avg(h) h,avg(f) f from %t where bid=%d and ask=0',array($this->_table,$bid));
	}
	public function count_avg_by_bid($bid){
		return DB::result_first('select avg from %t where bid=%d and ask=0 and uid!=0',array($this->_table,$bid));
	}
	public function count_by_bid_all($bid){
		return DB::result_first('select count(*) from %t where bid=%d',array($this->_table,$bid));
	}
	public function fetch_all_by_bid_page($bid,$start,$perpage){
		return DB::fetch_all('select * from %t where bid=%d order by id desc limit %d,%d ',array($this->_table,$bid,$start,$perpage));
	}
	public function fetch_all_by_dianping($start,$perpage){
		return DB::fetch_all('select * from %t order by id desc limit %d,%d ',array($this->_table,$start,$perpage));
	}
}




?>