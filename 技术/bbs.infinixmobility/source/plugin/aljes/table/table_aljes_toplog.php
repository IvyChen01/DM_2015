<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljes_toplog extends discuz_table {

    public function __construct() {

        $this->_table = 'aljes_toplog';
        $this->_pk = 'id';

        parent::__construct();
    }
    public function fetch_all_by_dateline(){
        return DB::fetch_all('select b.* from %t a left join %t b on a.lid=b.id where a.dateline>%d-86400',array($this->_table,'aljes',TIMESTAMP));
    }

}

?>