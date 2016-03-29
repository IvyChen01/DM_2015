<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_region extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_region';
			$this->_pk    = 'catid';

			parent::__construct();
	}
	public function fetch_all_by_upid($start,$limit,$upid){
		$carray[]=$this->_table;
		if($upid){
			$carray[]=$upid;
			$conn=' where upid=%d';
		}else{
			$conn=' where upid=0';
		}
		$conn.= ' order by displayorder asc ';
		if($start&&$limit){
			$carray[]=$start;
			$carray[]=$limit;
			$conn.='limit %d,%d';
		}
		
		return DB::fetch_all('select * from %t '.$conn,$carray,'catid');
	}
	public function fetch_all_by_upid_sys($upid){
		$carray[]='common_district';
		if($upid){
			$carray[]=$upid;
			$conn=' where upid=%d';
		}else{
			$conn=' where upid=0';
		}
		
		return DB::fetch_all('select * from %t '.$conn,$carray,'catid');
	}
	public function count_by_upid($upid) {
		$carray[]=$this->_table;
		if($upid){
			$carray[]=$upid;
			$conn=' where upid=%d';
		}else{
			$conn=' where upid=0';
		}
		return DB::result_first("SELECT count(*) FROM %t ".$conn,$carray,'catid');
	}
	public function fetch_first_by_name($name, $upid) {
		return DB::fetch_first("SELECT * FROM %t WHERE name = %s and upid=%d", array('common_district',$name, $upid));
	}
	public function fetch_first_by_id($id) {
		return DB::fetch_first('SELECT * FROM %t WHERE id=%d', array('common_district', $id));
	}
}




?>