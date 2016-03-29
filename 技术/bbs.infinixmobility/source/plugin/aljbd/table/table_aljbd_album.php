<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_album extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_album';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function count_by_uid_bid($uid,$bid){
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
	public function fetch_all_by_uid_bid($uid,$bid,$start,$perpage){
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
		$conn.=' order by id desc';
		if(isset($start)&&isset($perpage)){
			$where[]=$start;
			$where[]=$perpage;
			$conn.=' limit %d,%d';
		}
		return DB::fetch_all('select * from %t '.$conn,$where);
	}
	public function fetch_all_by_uid_bid_view($uid,$bid,$start,$perpage){
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
		$conn.=' order by view desc';
		if(isset($start)&&isset($perpage)){
			$where[]=$start;
			$where[]=$perpage;
			$conn.=' limit %d,%d';
		}
		return DB::fetch_all('select * from %t '.$conn,$where);
	}
	public function update_view_by_gid($gid){
		return DB::query('update %t set view=view+1 where id=%d',array($this->_table,$gid));
	}
	public function fetch_all_by_status($con){
		return DB::fetch_all("select * from %t $con ",array($this->_table));
	}
}




?>