<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljbd_attestation extends discuz_table {

    public function __construct() {

        $this->_table = 'aljbd_attestation';
        $this->_pk = 'bid';

        parent::__construct();
    }
	public function count_by_status($status,$search){
		if($search){
			$con[]='%'.addcslashes($search, '%_').'%';
			
			$where.=" and name like %s";
		}
		return DB::result_first("select count(*) from %t where sign=%d $where",array($this->_table,$status,$con));
	}
    public function fetch_all_by_status($status,$start,$perpage,$search){
		if($search){
			$con[]='%'.addcslashes($search, '%_').'%';
			
			$where.=" and name like %s";
		}
		return DB::fetch_all("select * from %t where sign=%d $where limit %d,%d",array($this->_table,$status,$start,$perpage,$con));
	}

}

?>