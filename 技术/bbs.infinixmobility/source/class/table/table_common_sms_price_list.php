<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description : 保存各国短信价格等信息
* @date: 2015年5月9日 下午2:16:54
* @author: yanhui.chen
* @version:
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_sms_price_list extends discuz_table
{

	public function __construct() {

		$this->_table = 'common_sms_price_list';
		$this->_pk    = 'id';
		
		parent::__construct();
	}

	/**
	     * @Description: 查找相同国籍的手机号码国家编号价格等信息
	     * @param variable $nation
	     * @return return_type array
	     * @author : yanhui.chen
	     * @date: 2015年5月9日 上午10:11:36
	     */
	    public function fetch_priceinfo_by_nation($nation) {
	        if ($nation =='Cote dIvoire') {
	            $nation = 'Ivory Coast';
	        }
	        return DB::fetch_first('select prefix,price FROM %t WHERE countryname=%s',array($this->_table,$nation),$this->_pk);
	    }
}

?>