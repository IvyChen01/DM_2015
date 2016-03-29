<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_username extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_username';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function fetch_by_uid_bid($uid,$bid){
		$conn=' where 1';
		$where[]=$this->_table;
		if($uid){
			$where[]=$uid;
			$conn.=' and uid=%d';
		}
		if($bid){
			$where[]=$bid;
			$conn.=' and bid=%d';
		}
		return DB::result_first('select count(*) from %t '.$conn,$where);
	}
	public function count_by_bid($bid){
		$conn=' where 1';
		$where[]=$this->_table;
		if($bid){
			$where[]=$bid;
			$conn.=' and bid=%d';
		}
		return DB::result_first('select count(*) from %t '.$conn,$where);
	}
	public function fetch_all_by_bid($bid,$start,$perpage){
		$conn=' where 1';
		$where[]=$this->_table;
		if($bid){
			$where[]=$bid;
			$conn.=' and bid=%d';
		}
		$conn.=' order by id desc';
		if(isset($start)&&isset($perpage)){
			$where[]=$start;
			$where[]=$perpage;
			$conn.=' limit %d,%d';
		}
		return DB::fetch_all('select * from %t '.$conn,$where);
	}
}




?>