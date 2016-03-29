<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljes extends discuz_table {

    public function __construct() {

        $this->_table = 'aljes';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function update_views_by_id($id) {
        DB::query('update %t set views=views+1 where id=%d', array($this->_table, $id));
    }

    public function count_by_status($conndtion) {
        $con[] = $this->_table;
        $where = 'where state=0 ';
        if ($conndtion['uid']) {
            $con[] = $conndtion['uid'];
            $where.=" and uid = %d";
        }
        if ($conndtion['search']) {
            $con[] = '%' . addcslashes($conndtion['search'], '%_') . '%';
            $where.=" and title like %s";
        }
        if ($conndtion['rid']) {
            $con[] = $conndtion['rid'];
            $where.=" and region = %d";
        }
        if ($conndtion['subrid']) {
            $con[] = $conndtion['subrid'];
            $where.=" and region1 = %d";
        }
        if ($conndtion['zufangtype']) {
            $con[] = $conndtion['zufangtype'];
            $where.=" and zufangtype = %d";
        }
        if ($conndtion['pay1']) {
			if(!$conndtion['pay2']){
				$con[] = $conndtion['pay1'];
				$where.=" and zujin < %d";
			}else{
				$con[] = $conndtion['pay1'];
				$where.=" and zujin > %d";
			}
        }
        if ($conndtion['pay2']) {
            if(!$conndtion['pay1']){
				$con[] = $conndtion['pay2'];
				$where.=" and zujin > %d";
			}else{
				$con[] = $conndtion['pay2'];
				$where.=" and zujin < %d";
			}
        }
		if ($conndtion['wanted']) {
            $con[] = $conndtion['wanted'];
			if($conndtion['wanted']=='2'){
				$where.=" and wanted = %d or wanted=0";
			}else{
				$where.=" and wanted = %d";
			}
        }
		if ($conndtion['new']) {
            $con[] = $conndtion['new'];
            $where.=" and new = %d ";
        }
        return DB::result_first('select count(*) from %t ' . $where, $con);
    }

    public function fetch_all_by_addtime($start, $perpage, $conndtion) {
        $con[] = $this->_table;
        $where = 'where state=0 ';
        if ($conndtion['search']) {
            $con[] = '%' . addcslashes($conndtion['search'], '%_') . '%';

            $where.=" and title like %s";
        }
        if ($conndtion['rid']) {
            $con[] = $conndtion['rid'];
            $where.=" and region = %d";
        }
        if ($conndtion['subrid']) {
            $con[] = $conndtion['subrid'];
            $where.=" and region1 = %d";
        }
        if ($conndtion['zufangtype']) {
            $con[] = $conndtion['zufangtype'];
            $where.=" and zufangtype = %d";
        }
        if ($conndtion['pay1']) {
			if(!$conndtion['pay2']){
				$con[] = $conndtion['pay1'];
				$where.=" and zujin < %d";
			}else{
				$con[] = $conndtion['pay1'];
				$where.=" and zujin > %d";
			}
        }
        if ($conndtion['pay2']) {
            if(!$conndtion['pay1']){
				$con[] = $conndtion['pay2'];
				$where.=" and zujin > %d";
			}else{
				$con[] = $conndtion['pay2'];
				$where.=" and zujin < %d";
			}
        }
		if ($conndtion['uid']) {
            $con[] = $conndtion['uid'];
            $where.=" and uid = %s";
        }
		if ($conndtion['wanted']) {
            $con[] = $conndtion['wanted'];
			if($conndtion['wanted']=='2'){
				$where.=" and wanted = %d or wanted=0";
			}else{
				$where.=" and wanted = %d";
			}
        }
		if ($conndtion['new']) {
            $con[] = $conndtion['new'];
            $where.=" and new = %d ";
        }
        $con[] = $start;
        $con[] = $perpage;
		
        return DB::fetch_all('select * from %t ' . $where . ' order by topetime desc, updatetime desc,addtime desc limit %d,%d', $con);
    }
    public function update_updatetime_by_id($id){
        return DB::query('update %t set updatetime=%d where id=%d',array($this->_table,TIMESTAMP,$id));
    }

}

?>