<?php
/*
 * ���ߣ�����
 * ��ϵQQ:578933760
 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljes_reflashlog extends discuz_table{
	public function __construct() {

			$this->_table = 'aljes_reflashlog';
			$this->_pk    = 'id';

			parent::__construct();
	}
       

}




?>