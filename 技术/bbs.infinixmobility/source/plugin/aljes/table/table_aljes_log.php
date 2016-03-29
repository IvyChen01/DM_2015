<?php
/*
 * 作者：亮剑
 * 联系QQ:578933760
 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljes_log extends discuz_table{
	public function __construct() {

			$this->_table = 'aljes_log';
			$this->_pk    = 'day';

			parent::__construct();
	}
       
        public function update_views_by_day($day){
            return DB::query('update %t set views=views+1 where day=%d',array($this->_table,$day));
        }
		public function fetch_all_by_day(){
			return DB::fetch_all('select * from %t  order by day desc limit 0,2',array($this->_table));
		}

}




?>