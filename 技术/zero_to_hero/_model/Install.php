<?php
/**
 * 安装系统
 */
class Install
{
	public function __construct()
	{
	}
	
	/**
	 * 创建数据库
	 */
	public function createDatabase()
	{
		$dbName = Config::$dbConfig['dbName'];
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		Config::$db->connect();
		Config::$db->query("create database if not exists $dbName default character set $dbCharset collate $dbCollat");
	}
	
	/**
	 * 安装系统
	 */
	public function install()
	{
		$this->createTable();
		$this->insert();
	}
	
	/**
	 * 创建表
	 */
	private function createTable()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbAdmin");
		Config::$db->query("create table $tbAdmin (
			id int not null auto_increment primary key,
			username varchar(50) not null,
			password varchar(200) not null
		) engine = myisam character set $dbCharset collate $dbCollat;");
		
		Config::$db->query("drop table if exists $tbUser");
		Config::$db->query("create table $tbUser (
			id int not null auto_increment primary key,
			username varchar(100) not null,
			password varchar(200) not null,
			fbid varchar(50) not null,
			phone varchar(50) not null,
			email varchar(320) not null,
			photo varchar(256) not null,
			link varchar(256) not null,
			realname varchar(50) not null,
			gender varchar(50) not null,
			timezone varchar(10) not null,
			locale varchar(50) not null,
			age int not null,
			register_time datetime not null,
			login_time datetime not null,
			upload_times int not null,
			agreement int not null,
			login_type int not null,
			imei varchar(50) not null,
			uid varchar(50) not null,
			login_status int not null,
			local_photo varchar(256) not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbPic");
		Config::$db->query("create table $tbPic (
			id int not null auto_increment primary key,
			pic varchar(256) not null,
			small_pic varchar(256) not null,
			user_id int not null,
			do_time datetime not null,
			login_type int not null
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbLike");
		Config::$db->query("create table $tbLike (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			week int not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id),
			index (user_id)
		) engine = myisam character set $dbCharset collate $dbCollat; ");
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			content varchar(3010) not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 插入记录
	 */
	private function insert()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$sqlPassword = Security::multiMd5('admin', Config::$key);
		Config::$db->query("insert into $tbAdmin (username, password) values ('admin', '$sqlPassword')");
	}
	
	/**
	 * 获取所有的表名
	 */
	public function getAllTables()
	{
		Config::$db->connect();
		return Config::$db->getAllTables();
	}
	
	/**
	 * 获取指定表的所有字段名
	 */
	public function getAllFields($tbName)
	{
		Config::$db->connect();
		return Config::$db->getAllFields($tbName);
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function getRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		Config::$db->query("select * from $tbName limit $sqlStart, $sqlRecordCount");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	/**
	 * 备份数据库
	 */
	public function backup()
	{
		$path = Config::$dirBackup . Utils::mdate('Y-m-d') . '/';
		Utils::createDir($path);
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], $path);
		$tableArray = $db->getTables();
		$db->exportSql($tableArray);
	}
	
	/**
	 * 恢复数据库
	 */
	public function recover()
	{
		$db = new Dbbak(Config::$dbConfig['hostname'], Config::$dbConfig['username'], Config::$dbConfig['password'], Config::$dbConfig['dbName'], Config::$dbConfig['dbCharset'], Config::$dirRecover);
		$db->importSql();
	}
	
	public function find($keywords)
	{
		Config::$db->connect();
		$res = array();
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$tables = $this->getAllTables();
		foreach ($tables as $tb)
		{
			echo '$tb: ' . $tb . '<br />';
			$fields = $this->getAllFields($tb);
			foreach ($fields as $fd)
			{
				if ('register_time' == $fd)
				{
					continue;
				}
				echo '$fd: ' . $fd . '<br />';
				$sqlTb = '`' . $tb . '`';
				$sqlFd = '`' . $fd . '`';
				Config::$db->query("select $sqlFd from $sqlTb where $sqlFd like $sqlKeywords");
				$rows = Config::$db->getAllRows();
				if (!empty($rows))
				{
					$tableInfo = array();
					$tableInfo['tbname'] = $tb;
					$tableInfo['fields'] = array($fd);
					$tableInfo['records'] = $rows;
					$res[] = $tableInfo;
				}
			}
		}
		
		return $res;
	}
	
	private function createComment()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		$dbCharset = Config::$dbConfig['dbCharset'];
		$dbCollat = Config::$dbConfig['dbCollat'];
		
		Config::$db->query("drop table if exists $tbComment");
		Config::$db->query("create table $tbComment (
			id int not null auto_increment primary key,
			pic_id int not null,
			user_id int not null,
			content varchar(3010) not null,
			do_time datetime not null,
			login_type int not null,
			index (pic_id)
		) engine = myisam character set $dbCharset collate $dbCollat;");
	}
	
	/**
	 * 获取指定表的所有记录
	 */
	public function getUserRecords($tbName, $start = 0, $recordCount = 10)
	{
		Config::$db->connect();
		$res = array();
		$resIndex = 0;
		$sqlStart = (int)$start;
		$sqlRecordCount = (int)$recordCount;
		//Config::$db->query("select * from $tbName where realname='' limit $sqlStart, $sqlRecordCount");
		//Config::$db->query("select * from $tbName where username='' limit $sqlStart, $sqlRecordCount");
		Config::$db->query("select * from $tbName limit 0, 100");
		while ($row = Config::$db->getRow(MYSQL_NUM))
		{
			$fieldsCount = count($row);
			for ($i = 0; $i < $fieldsCount; $i++)
			{
				$res[$resIndex][$i] = htmlspecialchars($row[$i], ENT_QUOTES);
			}
			$resIndex++;
		}
		
		return $res;
	}
	
	public function exportUser()
	{
		require_once('classes/PHPExcel.php');
		$excel = new PHPExcel();
		//设置文件的详细信息
		$excel->getProperties()->setCreator("Administrators")
			->setLastModifiedBy("Administrators")
			->setTitle("Data")
			->setSubject("")
			->setDescription("")
			->setKeywords("")
			->setCategory("");
		
		//操作第一个工作表
		$excel->setActiveSheetIndex(0);
		//设置工作薄名称
		$excel->getActiveSheet()->setTitle('Data');
		//设置默认字体和大小
		$excel->getDefaultStyle()->getFont()->setName('Times New Roman');
		$excel->getDefaultStyle()->getFont()->setSize(14);
		
		/*
		//设置列宽度
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(148);
		*/
		
		/*
		//设置行高度
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(169);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(60);
		*/
		
		/*
		//设置水平居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		*/
		
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		/*
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		*/
		
		/*
		//合并单元格
		$excel->getActiveSheet()->mergeCells('A1:D1');
		*/
		
		/*
		//给单元格中放入图片
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('images/test.png');
		$objDrawing->setWidth(148);
		$objDrawing->setHeight(169);
		$objDrawing->setCoordinates('D2');
		$objDrawing->setWorksheet($excel->getActiveSheet());
		*/
		
		//设置单元格数据
		$excel->getActiveSheet()
			->setCellValue('A1', 'Nickname')
			->setCellValue('B1', 'Email')
			->setCellValue('C1', 'Gender')
			->setCellValue('D1', 'Age')
			->setCellValue('E1', 'Register Time');
		
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser");
		$res = Config::$db->getAllRows();
		$rowIndex = 2;
		foreach ($res as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['email'])
				->setCellValue('C' . $rowIndex, $row['gender'])
				->setCellValue('D' . $rowIndex, $row['age'])
				->setCellValue('E' . $rowIndex, $row['register_time']);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		$filename = 'data.xls';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			//从浏览器直接输出$filename
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/vnd.ms-excel;");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
		else if ('pdf' == $fileFormat)
		{
			//输出PDF格式
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'PDF');
			$objWriter->setSheetIndex(0);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type: application/pdf");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=" . $filename);
			header("Content-Transfer-Encoding:binary");
			$objWriter->save("php://output");
		}
	}
	
	private function fixStr($str)
	{
		$newStr = '';
		$strLen = strlen($str);
		for ($i = 0; $i < $strLen; $i++)
		{
			//$char = substr($str, $i, 1);
			$char = $str[$i];
			if ($char == ' ' || $char == '@' || $char == "'")
			{
				break;
			}
			$newStr .= $char;
		}
		return $newStr;
	}
	
	private function fixEmail()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where email=''");
		$res = Config::$db->getAllRows();
		foreach ($res as $value)
		{
			$id = (int)$value['id'];
			$sqlEmail =  Security::varSql($this->fixStr($value['username']) . '@gmail.com');
			Config::$db->query("update $tbUser set email=$sqlEmail where id=$id");
		}
	}
	
	/**
	 * 升级系统
	 */
	public function upgrade()
	{
		Config::$db->connect();
		$tbAdmin = Config::$tbAdmin;
		$tbUser = Config::$tbUser;
		$tbPic = Config::$tbPic;
		$tbLike = Config::$tbLike;
		$tbComment = Config::$tbComment;
		
		//Config::$db->query("select * from $tbUser where email=''");
	}
}
?>
