<?php
/*
 * 作�?：亮�?
 * 联系QQ:578933760
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_aljbd_setting extends discuz_table
{
	public function __construct() {

		$this->_table = 'aljbd_setting';
		$this->_pk    = 'key';

		parent::__construct();
	}
	public function update_value_by_key($value,$key){
		return DB::query('update %t set `value`=%s  where `key`=%s',array($this->_table,$value,$key));
	}

}

?>