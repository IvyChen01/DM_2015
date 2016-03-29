<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 保存发送短信表操作
* @date: 2015年5月9日 下午2:16:11
* @author: yanhui.chen
* @version:
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_sms_list extends discuz_table
{

	public function __construct() {

		$this->_table = 'common_sms_list';
		$this->_pk    = 'id';
		
		parent::__construct();
	}
	
	public function fetch_all() {
	    return DB::fetch_all('select * FROM %t ',array($this->_table),$this->_pk);
	}
	/**
	 * 根据条件查询搜索数据
	 * @param mixed array|null $condition
	 * @param string $order
	 * @param boolean $start
	 * @param number $limit
	 * @return array
	 */
	public function fetch_all_search($start=0,$limit=20){
	    $sql='SELECT * FROM %t order by id desc limit '.$start.','.$limit;
	    return DB::fetch_all($sql,array($this->_table));
	}
	
	
}

?>