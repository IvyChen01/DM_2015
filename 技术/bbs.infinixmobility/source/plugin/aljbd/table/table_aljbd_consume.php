<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_consume extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_consume';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function count_by_uid_bid($uid,$bid,$type,$subtype,$search){
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
		if($type){
			$where[]=$type;
			$conn.=' and type=%d';
		}
		if($subtype){
			$where[]=$subtype;
			$conn.=' and subtype=%d';
		}
		if($search){
			$where[]='%'.addcslashes($search, '%_').'%';
			
			$conn.=" and subject like %s";
		}
		return DB::result_first('select count(*) from %t '.$conn,$where);
	}
	public function fetch_all_by_uid_bid($uid,$bid,$start,$perpage,$type,$subtype,$search){
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
		if($type){
			$where[]=$type;
			$conn.=' and type=%d';
		}
		if($subtype){
			$where[]=$subtype;
			$conn.=' and subtype=%d';
		}
		if($search){
			$where[]='%'.addcslashes($search, '%_').'%';
			
			$conn.=" and subject like %s";
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
	public function fetch_thread_all_block($con,$sc,$items){
		return DB::fetch_all("select * from %t $con $sc limit 0,%d",array($this->_table,$items));
	}
	public function count_by_type(){
		return DB::fetch_all('select type,count(*) num from %t group by type',array($this->_table));
	}
	public function fetch_all_by_recommend($recommend,$start,$perpage){
		return DB::fetch_all('select * from %t where sign=%d limit %d,%d',array($this->_table,$recommend,$start,$perpage));
	}
}




?>