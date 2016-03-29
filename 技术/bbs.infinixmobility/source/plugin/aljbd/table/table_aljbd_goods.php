<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_goods extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_goods';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function count_by_status($status,$uid,$type,$subtype,$region,$subregion,$search){
		$con[]=$this->_table;
		$where='where 1 ';
		if($uid){
			$con[]=$uid;
			$where.='and uid=%d';
		}
		if($status){
			$con[]=$status;
			$where.=' and sign=%d';
		}
		if($type){
			$con[]=$type;
			$where.=' and type=%d';
		}
		if($subtype){
			$con[]=$subtype;
			$where.=' and subtype=%d';
		}
		if($region){
			$con[]=$region;
			$where.=' and region=%d';
		}
		if($subregion){
			$con[]=$subregion;
			$where.=' and subregion=%d';
		}
		
		if($search){
			$con[]='%'.addcslashes($search, '%_').'%';
			
			$where.=" and name like %s";
		}//debug('select count(*) from %t '.$where);
		return DB::result_first('select count(*) from %t '.$where,$con);
	}
	public function fetch_all_by_status($status,$start,$perpage,$uid,$type,$subtype,$region,$subregion,$order,$search){
		$con[]=$this->_table;
		$where='where 1 ';
		
		if($status){
			$con[]=$status;
			$where.='and sign=%d';
		}
		if($uid){
			$con[]=$uid;
			$where.=' and uid=%d';
		}
		if($type){
			$con[]=$type;
			$where.=' and type=%d';
		}
		if($subtype){
			$con[]=$subtype;
			$where.=' and subtype=%d';
		}
		if($region){
			$con[]=$region;
			$where.=' and region=%d';
		}
		if($subregion){
			$con[]=$subregion;
			$where.=' and subregion=%d';
		}
		if($search){
			$con[]='%'.addcslashes($search, '%_').'%';
			
			$where.=" and name like %s";
		}
		if($order){
			if($order=='price1'){
				$where.=' order by '.addslashes($order).' asc';
			}else{
				$where.=' order by '.addslashes($order).' desc';
			}
			
		}else{
			$where.=' order by dateline asc,view desc';
		}
		if(!empty($perpage)){
			$con[]=$start;
			$con[]=$perpage;
			$where.=' limit %d,%d';
		}
		return DB::fetch_all('select * from %t '.$where,$con);
	}
	public function count_by_type(){
		return DB::fetch_all('select type,count(*) num from %t group by type',array($this->_table));
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
	public function fetch_thread_all_block($con,$sc,$items){
		return DB::fetch_all("select * from %t $con $sc limit 0,%d",array($this->_table,$items));
	}
	public function fetch_all_by_recommend($recommend,$start,$perpage){
		return DB::fetch_all('select * from %t where sign=%d limit %d,%d',array($this->_table,$recommend,$start,$perpage));
	}
	public function update_num_by_id($id,$num) {
        return DB::query('update %t set amount=amount-%d where id=%d', array($this->_table,$num,$id));
    }
    public function update_num2_by_id($id,$num) {
        return DB::query('update %t set buyamount=buyamount+%d where id=%d', array($this->_table,$num,$id));
    }
}




?>