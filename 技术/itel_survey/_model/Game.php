<?php
/**
 * 游戏
 * @author Shines
 */
class Game
{
	public function __construct()
	{
	}
	
	public function getProfile($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser where fbid=$sqlFbid");
		return Config::$db->getRow();
	}
	
	/**
	 * 检测用户是否存在
	 */
	public function existUser($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 添加用户
	 */
	public function addUser($fbid, $userProfile)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$username = isset($userProfile['name']) ? $userProfile['name'] : '';
		if (Config::$isFb)
		{
			$photo = 'https://graph.facebook.com/' . $fbid . '/picture?width=330&height=330';
		}
		else
		{
			$photo = isset($userProfile['photo']) ? $userProfile['photo'] : '';
		}
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$regtime = Utils::mdate('Y-m-d H:i:s');
		switch (Config::$deviceType)
		{
			case 'mobile':
				$logintype = 2;
				break;
			default:
				$logintype = 1;
		}
		$ip = Utils::getClientIp();
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlPhoto = Security::varSql($photo);
		$sqlEmail = Security::varSql($email);
		$sqlGender = Security::varSql($gender);
		$sqlRegtime = Security::varSql($regtime);
		$sqlLogintype = (int)$logintype;
		$sqlIp = Security::varSql($ip);
		Config::$db->query("insert into $tbUser (fbid, username, photo, email, gender, regtime, logintype, ip) values ($sqlFbid, $sqlUsername, $sqlPhoto, $sqlEmail, $sqlGender, $sqlRegtime, $sqlLogintype, $sqlIp)");
	}
	
	public function getUserByPage($page, $pagesize)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser order by id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function countUser()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select count(*) as num from $tbUser");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['num'];
		}
	}
	
	/**
	 * 导出用户数据到Excel
	 */
	public function exportUser()
	{
		require_once('extends/PHPExcel_1.8.0/PHPExcel.php');
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
		
		//设置列宽度
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
		
		/*
		//设置行高度
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(169);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(60);
		*/
		
		//设置水平居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('J')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('K')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('L')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('M')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('N')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
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
			->setCellValue('A1', 'Name')
			->setCellValue('B1', 'Gender')
			->setCellValue('C1', 'Email')
			->setCellValue('D1', 'Register Date')
			->setCellValue('E1', 'Q1')
			->setCellValue('F1', 'Q2')
			->setCellValue('G1', 'Q3')
			->setCellValue('H1', 'Q4')
			->setCellValue('I1', 'QS4')
			->setCellValue('J1', 'Q5')
			->setCellValue('K1', 'QS5')
			->setCellValue('L1', 'Q6')
			->setCellValue('M1', 'QS6')
			->setCellValue('N1', 'Q7');
		
		$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$res = $this->getAnswerData();
		$rowIndex = 2;
		foreach ($res as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['gender'])
				->setCellValue('C' . $rowIndex, $row['email'])
				->setCellValue('D' . $rowIndex, $row['regtime'])
				->setCellValue('E' . $rowIndex, $row['q1'])
				->setCellValue('F' . $rowIndex, $row['q2'])
				->setCellValue('G' . $rowIndex, $row['q3'])
				->setCellValue('H' . $rowIndex, $row['q4'])
				->setCellValue('I' . $rowIndex, $row['q4f'])
				->setCellValue('J' . $rowIndex, $row['q5'])
				->setCellValue('K' . $rowIndex, $row['q5f'])
				->setCellValue('L' . $rowIndex, $row['q6'])
				->setCellValue('M' . $rowIndex, $row['q6f'])
				->setCellValue('N' . $rowIndex, $row['q7']);
			$excel->getActiveSheet()->getRowDimension($rowIndex)->setRowHeight(30);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$filename = 'survey_' . Utils::mdate('Y.m.d') . '.xls';
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
			$filename = 'survey_' . Utils::mdate('Y.m.d') . '.pdf';
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
	
	public function checkPlayed($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select isplayed from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return false;
		}
		else
		{
			if ($res['isplayed'] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function setAnswer($fbid, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q4f, $q5f, $q6f)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$sqlQ1 = (int)$q1;
		$sqlQ2 = (int)$q2;
		$sqlQ3 = (int)$q3;
		$sqlQ4 = (int)$q4;
		$sqlQ5 = (int)$q5;
		$sqlQ6 = (int)$q6;
		$sqlQ7 = (int)$q7;
		$sqlQ4f = Security::varSql($q4f);
		$sqlQ5f = Security::varSql($q5f);
		$sqlQ6f = Security::varSql($q6f);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		
		$tbAnswer = Config::$tbAnswer;
		$tbUser = Config::$tbUser;
		Config::$db->query("insert into $tbAnswer (fbid, type, q1, q2, q3, q4, q5, q6, q7, q4f, q5f, q6f) values($sqlFbid, 1, $sqlQ1, $sqlQ2, $sqlQ3, $sqlQ4, $sqlQ5, $sqlQ6, $sqlQ7, $sqlQ4f, $sqlQ5f, $sqlQ6f)");
		Config::$db->query("update $tbUser set isplayed=1, lastplay=$sqlDate, restLucky=1 where fbid=$sqlFbid");
	}
	
	public function getRestLucky($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("select restLucky from $tbUser where fbid=$sqlFbid");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return $res['restLucky'];
		}
	}
	
	public function reduceRestLucky($fbid)
	{
		Config::$db->connect();
		$sqlFbid = Security::varSql($fbid);
		$tbUser = Config::$tbUser;
		Config::$db->query("update $tbUser set restLucky=restLucky-1 where fbid=$sqlFbid");
	}
	
	public function getAnswerData()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbAnswer = Config::$tbAnswer;
		Config::$db->query("select 
			user.fbid as fbid,
			user.username as username,
			user.gender as gender,
			user.email as email,
			user.regtime as regtime,
			answer.q1 as q1,
			answer.q2 as q2,
			answer.q3 as q3,
			answer.q4 as q4,
			answer.q5 as q5,
			answer.q6 as q6,
			answer.q7 as q7,
			answer.q4f as q4f,
			answer.q5f as q5f,
			answer.q6f as q6f
			from $tbUser as user join $tbAnswer as answer on user.fbid = answer.fbid
			order by user.id");
		$res = Config::$db->getAllRows();
		return $res;
	}
}
?>
