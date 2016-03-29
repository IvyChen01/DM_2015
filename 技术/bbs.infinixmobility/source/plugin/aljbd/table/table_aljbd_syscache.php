<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_plugin_lj_exam.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_aljbd_syscache extends discuz_table
{
	public function __construct() {

		$this->_table = 'aljbd_syscache';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function fetch_all_by_sign($sign){
		return DB :: fetch_all("select * from %t where plugin_sign=%d",array($this->_table,$sign));
	} 
	public function fetch_count($sign){
		return DB :: result_first("select count(*) from %t where plugin_sign=%d",array($this->_table,$sign));
	}
	public function fetch_count_sign($plugin_b,$sign){
		return DB :: result_first("select count(*) from %t where plugin_sign=%d and plugin_b=%s",array($this->_table,$sign,$plugin_b));
	}
	public function fetch_all_by_con($con,$sign){
		return DB :: fetch_all("select * from ".DB::table($this->_table)." $con and plugin_sign=$sign");
	}
}


?>