<?php
/**
 * 安装系统
 */
class Install
{
	private $db = null;//数据库
	private $db_name = '';//数据库名
	private $db_charset = '';//数据库字符集
	private $db_collat = '';
	
	public function __construct()
	{
		$this->db = new Database(Config::$db_config);
		$this->db_name = Config::$db_config['db_name'];
		$this->db_charset = Config::$db_config['db_charset'];
		$this->db_collat = Config::$db_config['db_collat'];
	}
	
	/**
	 * 创建数据库
	 */
	public function create_database()
	{
		$this->db->connect();
		$this->db->query("CREATE DATABASE IF NOT EXISTS $this->db_name DEFAULT CHARACTER SET $this->db_charset COLLATE $this->db_collat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->create_table();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function create_table()
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$tb_user = Config::$tb_user;
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$tb_lucky_daily = Config::$tb_lucky_daily;
		
		$this->db->query("DROP TABLE IF EXISTS $tb_admin");
		$this->db->query("CREATE TABLE $tb_admin (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_user");
		$this->db->query("CREATE TABLE $tb_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			username VARCHAR( 50 ) NOT NULL ,
			password VARCHAR( 200 ) NOT NULL ,
			phone VARCHAR( 50 ) NOT NULL ,
			register_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_jiang_chi");
		$this->db->query("CREATE TABLE $tb_jiang_chi (
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
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_zhong_jiang");
		$this->db->query("CREATE TABLE $tb_zhong_jiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			prizeid INT NOT NULL ,
			prizename VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_lucky_daily");
		$this->db->query("CREATE TABLE $tb_lucky_daily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			openid VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			pan_flag INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		$this->db->connect();
		$tb_admin = Config::$tb_admin;
		$password = 'hjiccaabifhfdca71803f25aee0cd220c273baf0c0d70chcaiafajcgbfeeiccd';
		$this->db->query("INSERT INTO $tb_admin (username, password) VALUES ('admin', '$password')");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function get_all_tables()
	{
		$this->db->connect();
		return $this->db->get_all_tables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function get_all_fields($tb_name)
	{
		$this->db->connect();
		return $this->db->get_all_fields($tb_name);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function get_records($tb_name, $start = 0, $record_count = 10)
	{
		$this->db->connect();
		$res = array();
		$res_index = 0;
		$sql_start = (int)$start;
		$sql_record_count = (int)$record_count;
		$this->db->query("SELECT * FROM $tb_name LIMIT $sql_start, $sql_record_count");
		while ($row = $this->db->get_row(MYSQL_NUM))
		{
			$fields_count = count($row);
			for ($i = 0; $i < $fields_count; $i++)
			{
				$res[$res_index][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$res_index++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$dir_backup . Utils::mdate('Y-m-d') . '/';
		Utils::create_dir($path);
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$db_config['hostname'], Config::$db_config['username'], Config::$db_config['password'], Config::$db_config['db_name'], Config::$db_config['db_charset'], Config::$dir_recover);
		$db->importSql();
	}
	
	/**
	 * 升级系统
	 */
	public function sum_prize()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$this->db->query("select sum(prize1), sum(prize2), sum(prize3), sum(prize4), sum(prize5), sum(prize6) from $tb_hb_jiang_chi");
		$res = $this->db->get_row();
		print_r($res);
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		$this->db->connect();
		
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$this->db->query("update $tb_hb_zhong_jiang set openid='oSS56s4XHfcWo94svaTNdNMiZVR0' where id=243");
		
		//$tb_hb_bind_user = Config::$tb_hb_bind_user;
		//$this->db->query("update $tb_hb_bind_user set openid='oSS56s4XHfcWo94svaTNdNMiZVR0' where id=630");
		
		/*
		$tb_hb_base_user = Config::$tb_hb_base_user;
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01244', '占志诚', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01245', '黄齐欢', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01246', '刘国利', '产品规划部')");
		*/
		
		//$tb_hb_base_user = Config::$tb_hb_base_user;
		//$this->db->query("update $tb_hb_base_user set jobnum='A01121' where id=991");
		
		//$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		//$this->db->query("delete from $tb_hb_lucky_daily where id=392");
		
		//$tb_hb_bind_user = Config::$tb_hb_bind_user;
		//$this->db->query("delete from $tb_hb_bind_user where jobnum='01173'");
		
		/*
		$tb_zhong_jiang = Config::$tb_zhong_jiang;
		$this->db->query("update $tb_zhong_jiang set department='商务物流部', username='唐丹丹' where id=145");
		*/
		
		/*
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("update $tb_jiang_chi set prize4=4, prize5=8, prize6=57 where prize_date='2015-1-17'");
		*/
		
		/*
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("update $tb_jiang_chi set rate=15, prize3=1, prize4=4, prize5=6, prize6=33 where prize_date='2015-1-10'");
		$this->db->query("update $tb_jiang_chi set rate=40, prize4=4, prize5=6, prize6=32 where prize_date='2015-1-11'");
		$this->db->query("update $tb_jiang_chi set rate=20, prize4=5, prize5=6, prize6=32 where prize_date='2015-1-12'");
		$this->db->query("update $tb_jiang_chi set rate=30, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-13'");
		$this->db->query("update $tb_jiang_chi set rate=40, prize4=5, prize5=6, prize6=32 where prize_date='2015-1-14'");
		$this->db->query("update $tb_jiang_chi set rate=50, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-15'");
		$this->db->query("update $tb_jiang_chi set rate=60, prize4=4, prize5=7, prize6=32 where prize_date='2015-1-16'");
		$this->db->query("update $tb_jiang_chi set rate=100, prize4=4, prize5=6, prize6=32 where prize_date='2015-1-17'");
		*/
	}
	
	public function init_prize()
	{
		$this->db->connect();
		$tb_jiang_chi = Config::$tb_jiang_chi;
		$this->db->query("delete from $tb_jiang_chi");
		
		//Infinix平板2个，TECNO Phantom Z 2个，itel手机2个，蓝牙耳机26个，充电宝39个，彩票195张
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-5', '20', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-6', '20', '1', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-7', '30', '0', '1', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-8', '40', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-9', '50', '0', '0', '1', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-10', '50', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-11', '100', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-12', '60', '1', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-13', '60', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-14', '70', '0', '1', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-15', '80', '0', '0', '0', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-16', '90', '0', '0', '1', '2', '3', '15')");
		$this->db->query("INSERT INTO $tb_jiang_chi (prize_date, rate, prize1, prize2, prize3, prize4, prize5, prize6) VALUES ('2015-1-17', '100', '0', '0', '0', '2', '3', '15')");
	}
	
	public function install_hong_bao()
	{
		$this->create_hb_table();
		$this->init_hb_base_user();
		$this->init_hb_jiang_chi();
	}
	
	/**
	 * 创建红包表
	 */
	private function create_hb_table()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$tb_hb_zhong_jiang = Config::$tb_hb_zhong_jiang;
		$tb_hb_lucky_daily = Config::$tb_hb_lucky_daily;
		$tb_hb_bind_user = Config::$tb_hb_bind_user;
		$tb_hb_base_user = Config::$tb_hb_base_user;
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_jiang_chi");
		$this->db->query("CREATE TABLE $tb_hb_jiang_chi (
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
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_zhong_jiang");
		$this->db->query("CREATE TABLE $tb_hb_zhong_jiang (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			openid VARCHAR( 50 ) NOT NULL ,
			prizeid INT NOT NULL ,
			prizename VARCHAR( 50 ) NOT NULL ,
			lucky_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_lucky_daily");
		$this->db->query("CREATE TABLE $tb_hb_lucky_daily (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			money INT NOT NULL ,
			lucky_time DATETIME NOT NULL ,
			click_flag INT NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_bind_user");
		$this->db->query("CREATE TABLE $tb_hb_bind_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL ,
			openid VARCHAR( 50 ) NOT NULL ,
			register_time DATETIME NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
		
		$this->db->query("DROP TABLE IF EXISTS $tb_hb_base_user");
		$this->db->query("CREATE TABLE $tb_hb_base_user (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			jobnum VARCHAR( 10 ) NOT NULL ,
			username VARCHAR( 50 ) NOT NULL ,
			department VARCHAR( 50 ) NOT NULL
		) ENGINE = MYISAM CHARACTER SET $this->db_charset COLLATE $this->db_collat;");
	}
	
	private function init_hb_base_user()
	{
		$this->db->connect();
		$tb_hb_base_user = Config::$tb_hb_base_user;
		
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60442', '赵军辉', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60443', '彭建森', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60444', '詹海波', 'ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60445', '李韩', '软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60446', '王轶超', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60447', '柳佰华', '硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60448', '马帅', '结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60449', '沈丽君', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60450', '董坤伟', 'ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60451', '洪亚婷', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60452', '杨婉岑', '人事行政部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80159', '眭志伟', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80161', '杨玲', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80162', '林闽琦', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80163', '雷志强', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00001', '竺兆江', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00002', '张祺', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00004', '叶伟强', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00005', '胡盛龙', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00006', '严孟', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00007', '秦霖', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00008', '胡飞侠', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00009', 'Shyamol', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00010', '王翀', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00013', '欧阳葵', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00017', '胡蒋科', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00018', '刘井泉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00022', '邓翔', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00023', '代芳', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00025', '邓国彬', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00026', '邱能凯', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00027', '谭波', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00028', '涂才荣', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00029', '周劲', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00031', '苏磊', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00032', '梁卉卉', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00038', '何建波', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00041', '黄健', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00042', '郭磊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00043', '何紫辉', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00044', '雷伟国', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00053', '韩靖羽', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00060', '姜柏宇', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00064', '夏春雷', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00065', '胡伟平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00066', '刘仰宏', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00068', '张建', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00069', '龚金银', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00070', '戴娥英', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00075', '姚海珍', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00079', '阿里夫', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00080', '周宗政', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00082', '王齐', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00086', '俞卫国', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00087', '王成军', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00088', '刘俊杰', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00099', '刘红玲', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00111', '宋英男', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00115', '岳翠忠', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00116', '鲁荣豪', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00120', '陈方', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00129', '申瑞刚', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00131', '王海滨', '上海研发中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00132', '潘志浪', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00134', '杨晨', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00135', '许昭', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00136', '黄永源', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00141', '金卫星', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00148', '吴连军', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00150', '张艳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00151', '崔文君', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00153', '李平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00154', '代书燕', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00155', '余玟龙', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00156', '郭必亮', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00157', '宁建梅', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00163', '乐苏华', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00165', 'MOHAMMAD MAHFUZUL HUQ', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00168', '蔡海山', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00169', '彭利平', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00171', '代祥', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00173', '卢文科', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00176', '兰云贵', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00179', '刘宏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00186', '欧阳振瑞', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00195', '董丹萍', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00198', '涂才福', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00200', '高斌斌', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00201', '田孟芬', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00202', '黎广胜', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00203', '王振宇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00207', '陈燕芬', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00208', '郑显彪', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00210', '王志杰', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00228', '李戈', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00229', '刘凯', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00238', '乔世英', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00240', '吴文', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00241', '黄石娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00244', '严翠娥', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00251', '唐波', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00252', '闵晓兰', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00254', '史静', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00259', '方芳', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00262', '金燕', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00269', '杨宏', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00274', '吴海霞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00280', '邹亮', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00286', '张金花', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00289', '孙英超', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00290', '张甄楠', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00293', '李静', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00295', '石伟', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00296', '王先波', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00300', '吴胜祖', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00303', '段盛晓', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00305', '卢惠端', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00306', '党进', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00307', '陈双双', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00310', '焦永刚', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00311', '周晓玲', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00313', '谢乐斌', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00314', '谭将', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00322', '冯世君', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00323', '黄宏辉', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00324', '蔡孙荣', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00328', '邓可爽', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00342', '丁鼎', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00345', '肖辉', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00347', '李庆春', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00355', '张义', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00357', '郭耕耘', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00359', '陈慧子', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00369', '王槐碧', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00373', '李俭彬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00377', '董海忠', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00379', '汪鹏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00381', '张群', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00382', '古裕彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00386', '伍玲华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00387', '贺晓秋', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00391', '王辉', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00393', '段涵琳', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00396', '张继海', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00397', '孟志赟', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00399', '陶威', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00405', '李明', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00407', '石文彬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00419', '孙良锋', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00420', '赵仰强', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00422', '伍亮', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00427', '黄宇航', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00433', '黄仕帅', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00436', '曹跃峰', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00437', '易发云', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00439', '艾余胜', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00440', '吴松', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00447', '赵文良', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00451', '余勇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00453', '赵航', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00455', '姜曙明', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00460', '左涛', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00461', '黎镇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00463', '劳明强', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00464', '李景哲', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00468', '柯尊焱', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00469', '鲁守彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00477', '骆伊婷', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00480', '王旭芬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00489', '周金宝', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00491', '肖红', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00492', '曾忠', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00493', '王小强', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00498', '陈东东', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00499', '倪凯', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00501', '宋玮', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00502', '谭春玲', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00503', '徐烨', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00504', '刘洋', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00508', '刘杰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00509', '唐丹丹', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00510', '李小琳', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00512', '陈文臻', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00513', '鲁岚', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00514', '陈梓博', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00517', '吴赛', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00518', '肖志高', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00519', '王小龙', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00520', '陈艳霞', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00521', '周然鸣', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00522', '陆海雷', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00526', '张旭东', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00527', '黄东', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00529', '唐俊飞', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00530', '张文斌', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00531', '朱文卿', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00532', '张操', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00534', '袁丽清', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00535', '魏世兵', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00537', '张亚智', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00540', '何秀水', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00541', '廖浏平', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00543', '张欣', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00549', '王功泽', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00553', '寇士洋', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00554', '陈廷波', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00556', '李魁', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00557', '鲍彬彬', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00558', '刘小龙', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00560', '闵丽', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00561', '林宏强', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00562', '李春鹏', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00564', '陈钦明', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00566', '代元元', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00567', '彭继圭', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00569', '朱苗', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00571', '陈伏秀', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00573', '王静', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00575', '钟劲松', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00577', '刘会', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00582', '宋慈', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00583', '蒋小龙', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00584', '蔡茂', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00586', '吴国成', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00587', '莫艳勇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00589', '刘林峻', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00590', '袁雪梅', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00592', '黄明松', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00594', '周鑫', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00595', '李玥', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00597', '何艳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00598', '郭京京', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00600', '周炎福', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00602', '赵贤凯', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00604', 'Boukali Mounir', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00605', '赵震', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00606', 'Jean Sébastien COSTE', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00607', '陈肖肖', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00609', '齐战', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00610', '索超', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00611', '胡志勇', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00614', '黄彬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00615', '徐淑珍', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00616', '管银银', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00618', '李彧', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00621', '符良宏', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00622', '张丽丽', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00624', '李灿生', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00626', '齐子铭', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00628', '唐宇鑫', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00631', '涂颢', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00632', '陈周涛', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00634', '肖永辉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00639', '熊红涛', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00644', '项俊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00650', '叶淑婷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00652', '易恺', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00653', '陈娇', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00654', '刘治江', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00657', '冯士严', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00658', '雷程', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00659', '罗祖雄', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00660', '陈雨', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00662', '吕小丽', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00663', '谌思明', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00664', '肖培彪', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00665', '张仁员', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00669', '郭辉奇', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00670', '张聂', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00672', '黄友军', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00673', '胡黎', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00674', '徐斌', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00679', '吴一鸣', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00682', '王璐', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00687', '李华新', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00689', '晏鹏', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00691', '唐晓梅', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00693', '方羿', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00695', '陆翠洪', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00697', '孟凡', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00699', '李毅斌', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00700', '高亮', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00701', '周剑', '上海研发中心-INFINIX项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00702', '陈伟园', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00705', '杨道庄', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00707', '闫书红', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00708', '陈安东', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00709', '李景全', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00713', '陈慧珠', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00714', '王芳', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00715', '项赟', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00717', '李江涛', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00721', '贺利霞', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00722', '孟春东', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00723', '杨双赫', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00725', '王春生', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00727', '胡娟娟', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00728', '刘波', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00730', '关铮杰', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00731', '刘颖', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00732', '徐仁誉', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00734', '李山飞', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00736', '李广友', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00737', '李小霞', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00740', '彭星', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00741', '陈琼', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00743', '杨文龙', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00744', 'Arnaud LEFEBVRE', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00745', '张德星', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00746', '夏钊', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00747', '罗龙', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00748', '巫震宇', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00749', '柯阳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00751', '吴少波', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00754', '李丹平', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00756', '叶镇和', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00757', '郑诗慧', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00758', '陈浩', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00759', '李秀云', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00760', '蒋佳星', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00761', '徐敏', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00764', '蔡永', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00772', '卫桂芬', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00774', '孟娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00776', '黄露莎', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00777', '郭立乾', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00778', '范小娟', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00781', '官爱民', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00782', '马龙', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00783', '马晓川', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00784', '龚晓伟', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00785', '张文皓', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00787', '杨帆', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00789', '胡海瑞', '投资法务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00790', '曹振华', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00792', '陈方华', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00794', '汪虎', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00798', 'Md. Monirul Islam', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00800', 'Chidi Okonkwo', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00801', 'Joseph magloire SOFFACK -SONNA ', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00802', 'Gloria maria Anampiu', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00804', 'Ireshad Ahmed ', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00805', 'ziaur Rahman', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00806', '何自如', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00807', 'THIAM PAPA MEDOUNE', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00808', 'Talha Masharka', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00809', '李传堃', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00810', '胡伟欣', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00811', '张峰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00812', '庄恒', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00814', '李海玉', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00815', '刘晶晶', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00816', '潘胜荣', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00818', '周静', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00819', 'NAYYAR HUSSAIN ', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00820', '胡军', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00822', '欧伟哲', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00823', '王晓明', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00825', '廖菊芳', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00827', '余雷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00829', '刘明', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00832', '马骄', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00834', '竺家豪', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00835', '江雅琴', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00836', '王柯', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00840', '田长军', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00841', '马佐刚', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00843', '谭洁', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00845', '向东', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00846', '张喜鹏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00847', '吕明武', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00848', '张桂秀', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00849', '刘钦', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00850', '刘若天', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00851', '邹剑锋', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00853', '冯运通', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00854', '刘团', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00855', '周茂盛', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00856', '刘根平', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00857', '梁晰瑶', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00858', '邓慧', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00859', '辛未', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00866', '叶媛媛', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00867', '高威', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00868', '曾峰晴', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00869', '冯振洲', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00870', '罗湘陵', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00871', '马秋平', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00872', '姚长征', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00873', '洪丹玲', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00875', '莫斯淇', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00876', '蔡欣城', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00877', '陈云', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00881', '叶婷', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00883', '杜恒', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00884', '徐航', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00885', '黄凌宾', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00887', '王渊博', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00889', '王利', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00891', '张艳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00893', '左国强', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00898', '李旭啸', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00900', '方冰冰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00901', '唐善兵', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00902', '魏瑞', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00903', '娄博', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00904', '熊爽', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00905', '黄世平', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00906', '刘天明', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00909', '吴昊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00914', '姜楠', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00915', '张玉磊', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00916', '徐幼芳', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00917', '李霞', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00918', '周鸿武', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00922', '陈洋', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00923', '王青', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00924', '刘伟奇', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00925', '陈元海', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00926', '谭科', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00929', '阳娜', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00932', '张婧', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00934', '刘辉', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00935', '周勇', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00936', '徐显斌', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00937', '李婉婷', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00938', '江民烽', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00939', '黄强国', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00940', '张家威', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00941', '韩冬', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00942', '周蕾', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00944', '田旭生', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00945', '李文静', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00948', '潘小英', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00950', '张颖', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00951', '周瑾', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00952', '胡继伟', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00953', '吴青', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00954', '周红芳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00957', '叶海波', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00958', '郭雪妮', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00960', '李智', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00961', '李超', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00962', '何巍', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00963', '南彬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00964', '朱宇轩', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00969', '邓介刚', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00970', '廖京林', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00971', '肖文', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00972', '许山油', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00973', '张炳春', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00974', '孙媛媛', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00975', '陈密', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00976', '张漫', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00977', '林泽湘', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00978', '蔡思敏', '投资法务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00979', '魏海龙', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00980', '周也', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00982', '唐慰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00986', '洪东阳', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00987', '王礼安', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00988', '王正文', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00989', '刘建生', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00991', '覃纳', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00992', '杨琳莉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00993', '谢先锐', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00994', '郑善华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00995', '胡开辉', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00998', '望艳芳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00999', '杨参军', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01000', '谢关明', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01001', '徐晓玲', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01002', '徐中一', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01004', '王勋', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01005', '袁鹏', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01008', '曲文', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01009', '程刚', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01010', '郁万萍', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01012', '沈卓敏', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01014', 'Camille Louis Leon', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01015', '汪静', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01016', '盘浩', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01018', '赵向蓝', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01019', '李汶昭', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01020', '肖国庆', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01022', '沈燕', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01023', '杜灿', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01024', '马殿元', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01025', '马永刚', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01027', '周瑾妤', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01029', '林汉斌', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01030', '舒辉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01032', '蒋飞', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01035', '冼志彪', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01036', '吴琦', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01037', '徐华盛', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01038', '周惠娟', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01040', '左飞', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01041', '熊雪莹', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01042', '黄伟国', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01044', '吴长国', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01045', 'Kenome', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01046', '郝明雄', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01047', '曹豪磊', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01048', '徐超', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01050', '黄思乐', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01051', '曾续琴', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01054', '陈润东', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01056', '杨倩', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01057', '李扬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01058', '余亚鹏', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01059', '陈婷婷', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01061', '彭珺', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01062', '黄维维', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01063', '付美云', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01064', '张敏', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01065', '李姣', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01066', '崔天福', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01068', '耿丽', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01069', '赵耀', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01070', '王军蓉', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01071', '蒋慧芳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01072', '刘康', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01073', '刘光华', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01074', '廖小丽', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01075', '薛丽', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01076', '康燕', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01077', '张维', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01078', '楚聪', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01079', '金阳', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01081', '彭参', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01082', '刘正', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01085', '崔志鹏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01086', '曹美女', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01087', '武韬', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01089', '招燕玲', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01090', '韦燕羽', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01092', '徐明明', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01093', '刘望可', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01095', '金鼎', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01096', '余永利', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01097', '苏弦贤', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01098', '陈海飞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01099', '慕灵宇', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01100', '陈剑鸣', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01101', '朱丽璇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01102', '朱巧林', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01103', 'Jean-alexis', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01104', '崔效升', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01105', '涂茂婷', 'INFINIX事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01107', '莫艳莹', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01108', '梁文雅', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01109', '徐峰', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01110', '钱停秋', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01111', 'joan waithera muiyuro', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01112', '黃奕龙', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01113', 'Adamou', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01114', '方锐城', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01115', '唐华', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01118', '毛艳', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01119', '郑渝', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01120', '曾立城', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01121', '任文', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01122', '李艳杰', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01123', '姚少飞', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01124', '曾乐兴', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01125', '杨柠铭', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01126', '翁振楠', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01127', '卢丽萍', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01128', '谢碧芳', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01129', '张文浩', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01130', '游起发', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01133', '马志成', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01136', '李巧飞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01137', '潘殿好', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01138', '黄晓雪', '品牌管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01139', '杨勇', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01140', '李泽喜', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01141', '刘鑫', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01142', '肖俊婷', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01143', '孙纪兰', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01144', '刘基福', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01145', '苟桂花', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01146', '蔡宇超', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01147', 'Nourhan Mahmoud', '数字营销部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01148', '鲁林海', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01149', '孙海知', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01150', '袁杰', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01152', '蒋庆华', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01153', '张野', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01154', '黄婉如', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01155', '涂齐鹏', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01156', '邹春芳', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01157', '罗刚', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01158', '陶红珍', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01165', '陈桂君', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01166', '何志', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01167', '周永成', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01168', '刘磊', 'ITEL事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01169', '李坤', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01170', '吴志祥', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01172', '夏鹏', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01173', '邹振良', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01174', '周佳', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01175', '罗春迎', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01176', '丛曰娜', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01177', '陈博', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01178', '吴金妹', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01179', '黄善婷', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01181', '王满', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01182', '李贵品', '新事业发展部-配件业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01183', '罗闪', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01184', '徐跃华', '平台管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01185', '黄婉婷', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01186', '冯程', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01187', '孔秀敏', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01188', '彭丽', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01189', '王欣', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01191', '胡伟杰', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01192', '朱洪君', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01193', '刘敏', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01195', '万正位', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01196', '柳思琦', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01198', '唐永甜', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01199', '刘凯', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01201', '肖春霞', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01202', '何三山', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01203', '胡珍', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01204', '郭迪理', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01205', '雷富金', '客户服务中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01206', '李春秀', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01207', '刘福宏', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01208', '李义', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01209', '莫细明', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01210', '林朝升', '新事业发展部-3C业务')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01212', '蒲明海', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01213', '庞星星', 'itel事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01214', '周志晨', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01215', '邹凯', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01217', '蒲思安', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01218', '洪仲坤', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01219', '刘晨昱', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01220', '李双红', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01221', '赖让锦', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01222', '薛涵予', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01224', '林锦坤', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01225', '张镇群', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01226', '李小娇', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01227', '牛红威', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01228', '尹阳平', '商务物流部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01229', '陈瑾卿', 'TECNO事业部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01230', '陈宇', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01231', '程红俊', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01232', '汪波', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01233', '陈辉', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01234', '汪盛希', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01235', '易晓菲', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01236', '伊丽', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01237', '梅勇彬', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01238', '朱观林', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01239', '刘仔勤', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01240', '曹珍珍', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01241', '王国材', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01242', '黄伟铭', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01243', '宋立洲', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('03778', '黄丰南', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04716', '李青明', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04909', '娄华云', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05612', '朱雄', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05743', '张超叶', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('06559', '宋小伟', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07712', '李扬帆', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('09299', '杨双', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('12051', '喻培福', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60001', '肖明', '总裁办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60002', '陆伟峰', '上海研发中心')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60003', '张永乐', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60004', '孟跃龙', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60006', '曹娟', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60007', '秦进', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60008', '张兰华', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60009', '姜飞', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60010', '吉晓伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60011', '汪丽', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60013', '王栋', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60015', '金凤麟', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60017', '武长坤', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60018', '李永贤', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60020', '朱勇', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60022', '聂维祺', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60023', '张维娟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60027', '刘芳', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60033', '王忠明', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60036', '邱红', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60037', '王海军', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60040', '陈宇', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60041', '常义兵', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60045', '徐永涛', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60046', '黄宇杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60051', '熊辉', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60053', '刘彦忠', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60056', '李鸿', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60058', '占雄伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60064', '周飞', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60065', '任新泉', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60071', '林湘琦', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60072', '周凡贻', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60075', '张合乾', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60077', '李杨', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60085', '曾海荣', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60086', '崔娜娜', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60090', '刘豪杰', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60095', '赵帛羽', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60096', '李凯', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60099', '崔晓玲', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60100', '任帅帅', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60105', '韦灵春', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60108', '陈睿', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60109', '亓凯旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60118', '彭少朋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60119', '罗方丽', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60121', '叶彩梨', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60130', '胡家旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60131', '周灿', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60134', '张德祥', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60144', '夏相声', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60145', '夏霄月', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60146', '董军', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60147', '龚岐', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60150', '赵江伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60151', '张涛', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60155', '张颖瑞', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60157', '陈敏', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60161', '丁瑜', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60163', '张蕊', '运营商部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60170', '林广', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60171', '徐秦煜', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60173', '李仁志', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60174', '陶丽君', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60178', '吕帅', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60179', '顾少平', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60182', '罗丽', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60195', '王甲亮', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60196', '张锐', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60197', '龚乾坤', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60199', '王伟槐', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60200', '皇甫娜', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60203', '周庆怡', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60208', '刘毅', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60217', '闫秋雨', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60218', '任伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60222', '戴林春', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60223', '汪琳', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60224', '王陵', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60226', '黄鑫', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60227', '程慧君', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60228', '李凌志', '上海研发中心-TECNO项目部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60235', '章天璐', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60238', '周为英', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60241', '牛建伟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60247', '杨亮', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60249', '王彬', '上海研发中心-ID部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60250', '朱建刚', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60253', '朱伟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60256', '谢肖', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60259', '束陈林', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60260', '苏静', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60264', '李秀明', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60265', '章平', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60266', '陆德锁', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60268', '张丽清', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60270', '芦海龙', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60271', '所迪', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60273', '江涛', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60274', '唐圣杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60278', '张释引', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60279', '庄欢欢', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60280', '顾仁波', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60281', '张在梁', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60283', '洪宗胜', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60284', '滕帅', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60288', '张闽泉', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60292', '李琪', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60297', '姚伟', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60298', '王坤', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60299', '毛海霞', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60300', '张阿昌', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60302', '李名龙', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60303', '吴承东', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60304', '何小刚', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60309', '王福龙', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60311', '陈敏', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60313', '张浩斌', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60315', '刘波', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60316', '王政', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60317', '彭灿', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60319', '周嘉伦', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60321', '李守辉', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60322', '胡伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60323', '张少华', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60324', '毛育滔', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60325', '熊根根', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60326', '马强强', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60327', '苗春田', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60332', '舒凯', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60334', '潘文生', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60335', '周磊', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60336', '李肇光', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60342', '蒋贻峰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60344', '储昭阳', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60345', '林明锟', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60346', '高启杰', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60350', '陈冲', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60353', '马丹丹', '上海研发中心-资源开发部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60358', '林星', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60359', '剡飞龙', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60360', '梁朋朋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60362', '钟祥超', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60364', '刘世权', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60365', '朱宁波', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60366', '田超群', '上海研发中心-结构部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60367', '邵广庆', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60368', '王春生', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60369', '彭志强', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60370', '王莎莎', '上海研发中心-UX部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60371', '陆志民', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60372', '李庆', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60374', '王栋森', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60376', '姚黄鑫', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60378', '汪晗', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60379', '屈阳', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60380', '马文涛', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60383', '刘龙振', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60386', '黄猷', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60387', '蒋博', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60388', '朱诗宇', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60389', '陈二辉', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60390', '林兵', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60391', '代其全', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60392', '刘家福', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60393', '杨善雨', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60394', '王奇林', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60395', '尹固滨', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60397', '朱华敏', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60399', '顾加成', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60400', '吴昊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60402', '李晓刚', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60403', '张巍', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60405', '王鹏', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60406', '王俊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60407', '郑占飞', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60408', '李柳青', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60409', '蒋松萌', '信息管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60410', '谢志超', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60411', '宋晓彬', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60413', '庞婉晶', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60414', '朱飞', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60415', '沈海河', '财务管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60416', '卞仕功', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60417', '张开元', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60418', '丁智伟', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60420', '张金虎', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60422', '秦彬', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60423', '赵若楠', '上海研发中心-软件测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60425', '周如磊', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60426', '李文灿', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60427', '吴永胜', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60428', '仇培旋', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60429', '刘娜', '采购部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60430', '陈君', '产品规划部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60431', '沈倍佩', '人力资源部-上海行政人事')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60432', '陈云库', '上海研发中心-软件二部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60433', '刘希', '上海研发中心-软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60434', '顾志成', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60435', '张文海', '上海研发中心-系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60436', '章富洪', '上海研发中心-硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60437', '刘志强', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60438', '吴灿', '硬件部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60439', '鄢明智', '系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60440', '周乃涛', '软件一部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('60441', '安子', '系统组')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80001', '王济纬', '移动互联-总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80004', '余来志', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80005', '徐伟松', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80006', '梁发源', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80007', '邓浩', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80008', '石莹', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80009', '刘茜茜', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80011', '陈家乐', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80013', '卢健', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80015', '梁铂琚', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80016', '陈加凯', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80020', '李妮丽', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80021', '张茂军', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80024', '李靖', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80028', '刘文杰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80029', '黄恩海', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80031', '刘志', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80034', '罗远辉', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80036', '程屹东', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80039', '周仕冬', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80041', '李航', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80043', '史坤', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80044', '彭义臻', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80045', '王凡', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80047', '谭云', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80051', '韩巍', '移动互联-总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80052', '卓优', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80053', '陈忆佳', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80054', '王晓龙', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80056', '高健伦', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80058', '杨华强', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80061', '王贺', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80062', '陈小双', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80063', '吴倍苍', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80067', '王兴平', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80068', '曾婷', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80070', '雷玲玲', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80071', '刘靓', '移动互联-人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80074', '赵清华', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80075', '唐裕', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80076', '刘建军', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80078', '龙海', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80079', '韦康', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80080', '程刚', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80081', '米萌', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80083', '赵琳', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80086', '高菲云', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80087', '张伟', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80089', '李旻婧', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80092', 'Okano Gillies', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80093', 'Lawal Surajudeen Olaitan', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80094', 'Blessing Joe Ime', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80095', 'Arowolo Rachael R', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80096', 'Kpono-Abasi Ndisa Akpabio', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80097', '陈丽芬', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80098', '黄琦', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80099', '曾志英', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80100', '马丽婵', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80101', '程玉强', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80102', '谢梦晨', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80103', '成宇', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80104', '谢锦', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80106', '黄杰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80109', '黎伟强', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80111', '杨林', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80112', '姚必财', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80115', '栗小粟', '移动互联-产品部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80116', '隋军强', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80118', '马庆毅', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80120', '孙浩桓', '移动互联-海外商务平台部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80121', '黄帆', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80122', '毛健羽', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80124', '陈柳', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80125', '黎晓文', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80126', '陶凯林', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80128', '潘蒙', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80129', '孙盼', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80130', '袁庆伟', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80131', '姜薇', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80132', '李成艳', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80134', '王益', '移动互联-客户端（功能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80135', '廖阳杰', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80136', '龚腾峰', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80137', '邓如桔', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80139', '陈志萍', '移动互联-项目管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80140', '官焕静', '移动互联-技术支持部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80141', '陈继才', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80143', '成传友', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80144', '祝琼', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80145', '冯志坚', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80147', '王成君', '移动互联-客户端（智能机）部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80148', '马昭烈', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80149', '陈风斌', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80150', '李国优', '移动互联-服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80151', '王储玺', '移动互联-美术部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80152', '金路', '移动互联-产品运营部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80153', '陈竞雄', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80154', '李俊', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80155', '李冠霖', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80156', '尹金亮', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80157', '刘巧', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('80158', '邹志伟', '移动互联-palmchat服务器部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A00556', '王朝辉', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07068', '戴芳', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02766', '简繁', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z12697', '林丽琴', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('03237', '周毅', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07313', '甘泉', '总经办')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01132', '杨少华', '后勤部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01121', '何爱平', '关务部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z13497', '张玲', '人力资源部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z12706', '庞建勇', '质控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('4011', '唐小芳', '质检部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('08395', '杨汉林', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00022', '胡金', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('Z13782', '彭辉', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('00423', '李鹏', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04111', '董登峰', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A03521', '熊秉毅', '测试部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02787', '刘霞', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A03518', '黄东海', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A01095', '李超', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A02680', '唐政', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('A00949', '王智聪', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00103', '王中琦', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00825', '利波', '物控部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00894', '陈春利', '质量部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('H00105', '陈进', '工程部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('07933', '李桂胜', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('04573', '殷永祥', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('05601', '陈才', '集装箱')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('02379', '周建军', '生产部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01244', '占志诚', '制造管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01245', '黄齐欢', '质量管理部')");
		$this->db->query("INSERT INTO $tb_hb_base_user (jobnum, username, department) VALUES ('01246', '刘国利', '产品规划部')");
	}
	
	private function init_hb_jiang_chi()
	{
		$this->db->connect();
		$tb_hb_jiang_chi = Config::$tb_hb_jiang_chi;
		$this->db->query("delete from $tb_hb_jiang_chi");
		
		//2月3-8号
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-3', 80, 2, 29, 150)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-4', 80, 2, 15, 100)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-5', 80, 2, 15, 50)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-6', 80, 2, 15, 0)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-7', 80, 2, 15, 0)");
		$this->db->query("INSERT INTO $tb_hb_jiang_chi (prize_date, rate, prize1, prize2, prize3) VALUES ('2015-2-8', 100, 2, 15, 0)");
	}
}
?>
