<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljbd_wuliu extends discuz_table {

    public function __construct() {

        $this->_table = 'aljbd_wuliu';
        $this->_pk = 'orderid';

        parent::__construct();
    }
}

?>