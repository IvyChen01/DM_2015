<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljbd_usergroup extends discuz_table{
	public function __construct() {

			$this->_table = 'aljbd_usergroup';
			$this->_pk    = 'groupid';

			parent::__construct();
	}
	

}




?>