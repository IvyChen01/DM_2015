<?php
/**
 * 许愿墙
 * @author Shines
 */
class Wish
{
	public function __construct()
	{
	}
	
	public function getWishByFbid($fbid)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbWish = Config::$tbWish;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.localphoto as localphoto, wish.content as content, wish.bgcolor as bgcolor, wish.pubdate as pubdate from $tbUser as user join $tbWish as wish on user.fbid=wish.fbid where user.fbid=$sqlFbid");
		return Config::$db->getRow();
	}
	
	public function deleteWish($id)
	{
		Config::$db->connect();
		$tbWish = Config::$tbWish;
		$sqlId = (int)$id;
		Config::$db->query("delete from $tbWish where id=$sqlId");
	}
	
	public function getTbUser()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		Config::$db->query("select * from $tbUser");
		return Config::$db->getAllRows();
	}
	
	public function getTbWish()
	{
		Config::$db->connect();
		$tbWish = Config::$tbWish;
		Config::$db->query("select * from $tbWish");
		return Config::$db->getAllRows();
	}
	
	public function getAdminUser($page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbWish = Config::$tbWish;
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select user.photo as photo, user.localphoto as localphoto, user.username as username, user.gender as gender, user.email as email, user.regtime as regdate, wish.pubdate as wishdate, wish.content as content from $tbUser as user left join $tbWish as wish on user.fbid=wish.fbid order by user.id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function getAdminWish($page, $pagesize)
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
		$tbWish = Config::$tbWish;
		Config::$db->query("select wish.id as id, user.photo as photo, user.localphoto as localphoto, user.username as username, user.gender as gender, user.email as email, wish.pubdate as pubdate, wish.content as content from $tbUser as user join $tbWish as wish on user.fbid=wish.fbid order by wish.id limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	public function getWishCount()
	{
		Config::$db->connect();
		$tbWish = Config::$tbWish;
		Config::$db->query("select count(*) as num from $tbWish");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return (int)$res['num'];
		}
	}
	
	/**
	 * 获取愿望，分页
	 */
	public function getWish($page, $pagesize)
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
		$tbWish = Config::$tbWish;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.localphoto as localphoto, wish.content as content, wish.bgcolor as bgcolor, wish.pubdate as pubdate from $tbUser as user join $tbWish as wish on user.fbid=wish.fbid order by wish.id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 搜索愿望，分页
	 */
	public function search($keywords, $page, $pagesize)
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbWish = Config::$tbWish;
		$sqlKeywords = Security::varSql('%' . $keywords . '%');
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.localphoto as localphoto, wish.content as content, wish.bgcolor as bgcolor, wish.pubdate as pubdate from $tbUser as user join $tbWish as wish on user.fbid=wish.fbid where wish.content like $sqlKeywords or user.username like $sqlKeywords order by wish.id desc limit $from, $pagesize");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 检测是否发布过愿望
	 */
	public function checkAdded($fbid)
	{
		Config::$db->connect();
		$tbWish = Config::$tbWish;
		$sqlFbid = Security::varSql($fbid);
		Config::$db->query("select id from $tbWish where fbid=$sqlFbid");
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
	 * 发布愿望
	 */
	public function add($fbid, $content, $bgColor)
	{
		Config::$db->connect();
		$tbWish = Config::$tbWish;
		$sqlFbid = Security::varSql($fbid);
		$sqlContent = Security::varSql($content);
		$sqlBgColor = Security::varSql($bgColor);
		$sqlPubdate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbWish (fbid, content, bgcolor, pubdate) values ($sqlFbid, $sqlContent, $sqlBgColor, $sqlPubdate)");
		$id = Config::$db->getInsertId();
		return $id;
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
		if (Config::$isLocal)
		{
			$photo = isset($userProfile['photo']) ? $userProfile['photo'] : '';
		}
		else
		{
			$photo = 'https://graph.facebook.com/' . $fbid . '/picture?width=330&height=330';
		}
		
		/*
		//将facebook头像存储到服务器本地
		$content = @file_get_contents($photo);
		$localphoto = Config::$uploadsDir . 'fb_' . $fbid . '.jpg';
		$file = fopen($localphoto, 'w');
		fwrite($file, $content);
		fclose($file);
		*/
		
		$email = isset($userProfile['email']) ? $userProfile['email'] : '';
		$gender = isset($userProfile['gender']) ? $userProfile['gender'] : '';
		$regtime = Utils::mdate('Y-m-d H:i:s');
		$wishcount = 0;
		switch (Config::$deviceType)
		{
			case 'mobile':
				$logintype = 2;
				break;
			default:
				$logintype = 1;
		}
		$localphoto = '';
		$ip = Utils::getClientIp();
		
		$sqlFbid = Security::varSql($fbid);
		$sqlUsername = Security::varSql($username);
		$sqlPhoto = Security::varSql($photo);
		$sqlEmail = Security::varSql($email);
		$sqlGender = Security::varSql($gender);
		$sqlRegtime = Security::varSql($regtime);
		$sqlWishcount = (int)$wishcount;
		$sqlLogintype = (int)$logintype;
		$sqlLocalphoto = Security::varSql($localphoto);
		$sqlIp = Security::varSql($ip);
		
		Config::$db->query("insert into $tbUser (fbid, username, photo, email, gender, regtime, wishcount, logintype, localphoto, ip) values ($sqlFbid, $sqlUsername, $sqlPhoto, $sqlEmail, $sqlGender, $sqlRegtime, $sqlWishcount, $sqlLogintype, $sqlLocalphoto, $sqlIp)");
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
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(19);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
		
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
		
		//设置水平居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
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
			->setCellValue('D1', 'RegDate')
			->setCellValue('E1', 'WishDate')
			->setCellValue('F1', 'Content');
		
		$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$res = $this->getAdminUser(1, 100000);
		$rowIndex = 2;
		foreach ($res as $row)
		{
			/*
			//给单元格中放入图片
			if (empty($row['localphoto']))
			{
				$photo = $row['photo'];
			}
			else
			{
				$photo = $row['localphoto'];
			}
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Photo');
			$objDrawing->setDescription('Photo');
			$objDrawing->setPath($photo);
			$objDrawing->setWidth(60);
			$objDrawing->setHeight(60);
			$objDrawing->setCoordinates('A' . $rowIndex);
			$objDrawing->setWorksheet($excel->getActiveSheet());
			*/
			
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['gender'])
				->setCellValue('C' . $rowIndex, $row['email'])
				->setCellValue('D' . $rowIndex, $row['regdate'])
				->setCellValue('E' . $rowIndex, $row['wishdate'])
				->setCellValue('F' . $rowIndex, $row['content']);
			$excel->getActiveSheet()->getRowDimension($rowIndex)->setRowHeight(50);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$filename = 'wishwall_' . Utils::mdate('Y.m.d') . '.xls';
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
			$filename = 'wishwall_' . Utils::mdate('Y.m.d') . '.pdf';
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
	
	public function getFixWish($fbid)
	{
		$res = array();
		$wishData = $this->getWishByFbid($fbid);
		if (!empty($wishData))
		{
			$res['username'] = System::fixHtml($wishData['username']);
			/*
			if (empty($wishData['localphoto']))
			{
				$res['photo'] = System::fixHtml($wishData['photo']);
			}
			else
			{
				$res['photo'] = System::fixHtml($wishData['localphoto']);
			}
			*/
			$res['photo'] = System::fixHtml($wishData['photo']);
			$res['content'] = System::fixHtml($wishData['content']);
			$res['bgcolor'] = System::fixHtml($wishData['bgcolor']);
			$monthEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$monthNum = (int)Utils::mdate('m', $wishData['pubdate']);
			$month = $monthEn[$monthNum - 1];
			$day = Utils::mdate('d', $wishData['pubdate']);
			$res['pubdate'] = $month . ', ' . $day;
		}
		return $res;
	}
}
?>
