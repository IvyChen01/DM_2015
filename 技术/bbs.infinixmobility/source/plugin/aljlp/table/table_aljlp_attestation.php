<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljlp_attestation extends discuz_table {

    public function __construct() {

        $this->_table = 'aljlp_attestation';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function fetch_uid_type($uid,$type) {
		$con[] = $this->_table;
        $where = 'where 1 ';
		if ($uid) {
            $con[] = $uid;
            $where.=" and uid = %d";
        }
		if ($type) {
            $con[] = $type;
            $where.=" and type = %d";
        }
        return DB::result_first("select count(*) from %t ". $where, $con);
    }
	public function fetch_uid_type_sign($uid,$type,$sign) {
		$con[] = $this->_table;
        $where = 'where 1 ';
		if ($uid) {
            $con[] = $uid;
            $where.=" and uid = %d";
        }
		if ($type) {
            $con[] = $type;
            $where.=" and type = %d";
        }
		if ($sign) {
            $con[] = $sign;
            $where.=" and sign = %d";
        }
        return DB::fetch_first("select * from %t ". $where, $con);
    }
   public function count_by_status($status){
		return DB::result_first("select count(*) from %t where sign=%d",array($this->_table,$status));
	}
    public function fetch_all_by_status($status,$start,$perpage){
		return DB::fetch_all("select * from %t where sign=%d limit %d,%d",array($this->_table,$status,$start,$perpage));
	}

}

?>