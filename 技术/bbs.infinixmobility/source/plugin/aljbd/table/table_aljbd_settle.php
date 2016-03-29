<?php

/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_aljbd_settle extends discuz_table {

    public function __construct() {

        $this->_table = 'aljbd_settle';
        $this->_pk = 'settleid';

        parent::__construct();
    }
	
}

?>