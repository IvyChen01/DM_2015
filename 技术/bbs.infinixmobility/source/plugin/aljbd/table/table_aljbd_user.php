<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_user extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_user';
			$this->_pk    = 'uid';

			parent::__construct();
	}
}




?>