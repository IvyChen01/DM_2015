<?php
/*
 * ���ߣ�����
 * ��ϵQQ:578933760
 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljlp_reflashlog extends discuz_table{
	public function __construct() {

			$this->_table = 'aljlp_reflashlog';
			$this->_pk    = 'id';

			parent::__construct();
	}
       

}




?>