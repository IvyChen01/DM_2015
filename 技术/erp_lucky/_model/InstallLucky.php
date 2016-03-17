<?php
/**
 * 导入奖池数据
 */
class InstallLucky
{
	private $db = null;//数据库
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	
	private $tb_jiang_chi = '';//奖池表
	private $tb_zhong_jiang = '';//中奖表
	private $tb_faq_daily = '';//每日答题表
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
		
		$this->tb_jiang_chi = Config::$tb_jiang_chi;
		$this->tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->tb_faq_daily = Config::$tb_faq_daily;
	}
	
	public function install()
	{
		$this->create_table();
		$this->insert_data();
	}
	
	private function create_table()
	{
		$this->db->connect();
		$this->db->query("DROP TABLE IF EXISTS $this->tb_jiang_chi");
		$this->db->query("CREATE TABLE $this->tb_jiang_chi (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			prize_date DATE NOT NULL ,
			rate INT NOT NULL ,
			prize1 INT NOT NULL ,
			prize2 INT NOT NULL ,
			prize3 INT NOT NULL ,
			prize4 INT NOT NULL ,
			prize5 INT NOT NULL ,
			prize6 INT NOT NULL ,
			prize7 INT NOT NULL ,
			prize8 INT NOT NULL ,
			prize9 INT NOT NULL ,
			prize10 INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat; ");
	}
	
	private function insert_data()
	{
		//72
		$this->db->connect();
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/9/28', '0', '0', '0', '0', '0', '0')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/9/29', '1', '1', '2', '3', '3', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/9/30', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/8', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/9', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/10', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/11', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/13', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/14', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/15', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/16', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/17', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/18', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/20', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/21', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/22', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/23', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/24', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/25', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/27', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/28', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/29', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/30', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/10/31', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/1', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/3', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/4', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/5', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/6', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/7', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/8', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/10', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/11', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/12', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/13', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/14', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/15', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/17', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/18', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/19', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/20', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/21', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/22', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/24', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/25', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/26', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/27', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/28', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/11/29', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/1', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/2', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/3', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/4', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/5', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/6', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/8', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/9', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/10', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/11', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/12', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/13', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/15', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/16', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/17', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/18', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/19', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/20', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/22', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/23', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/24', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/25', '1', '1', '2', '2', '2', '10')");
		$this->db->query("INSERT INTO $this->tb_jiang_chi (rate, prize_date, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('20', '2014/12/26', '1', '1', '2', '2', '2', '10')");
	}
}
?>
