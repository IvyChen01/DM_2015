<?php
/**
 *	调研
 */
class Survey
{
	public function __construct()
	{
	}
	
	public function getAllCustomer()
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		Config::$db->query("SELECT * FROM $tbCustomer ORDER BY id");
		
		return Config::$db->getAllRows();
	}
	
	public function getCustomerByWeek($year, $month, $week, $country, $type, $page)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		$sqlCountry = Security::varSql($country);
		$sqlType = (int)$type;
		$page = (int)$page;
		$pagesize = Config::$customerPagesize;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		
		$sqlWhere = '';
		$whereFlag = false;
		
		if ($sqlYear > 0)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and year=$sqlYear ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " year=$sqlYear ";
			}
		}
		
		if ($sqlMonth >= 1 && $sqlMonth <= 12)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and month=$sqlMonth ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " month=$sqlMonth ";
			}
		}
		
		if ($sqlWeek >= 1 && $sqlWeek <= 5)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and week=$sqlWeek ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " week=$sqlWeek ";
			}
		}
		
		if (!empty($country))
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and country=$sqlCountry ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " country=$sqlCountry ";
			}
		}
		
		if ($sqlType >= 1 && $sqlType <= 3)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and status=$sqlType ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " status=$sqlType ";
			}
		}
		
		//Config::$db->query("SELECT * FROM $tbCustomer WHERE year=$sqlYear and month=$sqlMonth and week=$sqlWeek and country=$sqlCountry and status=$sqlType ORDER BY id LIMIT $from, $pagesize");
		
		if (empty($sqlWhere))
		{
			Config::$db->query("SELECT * FROM $tbCustomer ORDER BY id LIMIT $from, $pagesize");
		}
		else
		{
			Config::$db->query("SELECT * FROM $tbCustomer WHERE $sqlWhere ORDER BY id LIMIT $from, $pagesize");
		}
		$res = Config::$db->getAllRows();
		
		return $res;
	}
	
	public function getAllCustomerByWeek($year, $month, $week)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		
		$sqlWhere = '';
		$whereFlag = false;
		
		if ($sqlYear > 0)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and year=$sqlYear ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " year=$sqlYear ";
			}
		}
		
		if ($sqlMonth >= 1 && $sqlMonth <= 12)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and month=$sqlMonth ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " month=$sqlMonth ";
			}
		}
		
		if ($sqlWeek >= 1 && $sqlWeek <= 5)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and week=$sqlWeek ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " week=$sqlWeek ";
			}
		}
		
		//Config::$db->query("SELECT * FROM $tbCustomer WHERE year=$sqlYear and month=$sqlMonth and week=$sqlWeek and country=$sqlCountry and status=$sqlType ORDER BY id LIMIT $from, $pagesize");
		
		if (empty($sqlWhere))
		{
			Config::$db->query("SELECT * FROM $tbCustomer ORDER BY id");
		}
		else
		{
			Config::$db->query("SELECT * FROM $tbCustomer WHERE $sqlWhere ORDER BY id");
		}
		$res = Config::$db->getAllRows();
		
		return $res;
	}
	
	public function getPageCountByWeek($year, $month, $week, $country, $type)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		$sqlCountry = Security::varSql($country);
		$sqlType = (int)$type;
		$pagesize = Config::$customerPagesize;
		
		$sqlWhere = '';
		$whereFlag = false;
		
		if ($sqlYear > 0)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and year=$sqlYear ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " year=$sqlYear ";
			}
		}
		
		if ($sqlMonth >= 1 && $sqlMonth <= 12)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and month=$sqlMonth ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " month=$sqlMonth ";
			}
		}
		
		if ($sqlWeek >= 1 && $sqlWeek <= 5)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and week=$sqlWeek ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " week=$sqlWeek ";
			}
		}
		
		if (!empty($country))
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and country=$sqlCountry ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " country=$sqlCountry ";
			}
		}
		
		if ($sqlType >= 1 && $sqlType <= 3)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and status=$sqlType ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " status=$sqlType ";
			}
		}
		
		if (empty($sqlWhere))
		{
			Config::$db->query("SELECT count(*) AS num FROM $tbCustomer");
		}
		else
		{
			Config::$db->query("SELECT count(*) AS num FROM $tbCustomer WHERE $sqlWhere");
		}
		$res = Config::$db->getRow();
		
		if (empty($res))
		{
			return 0;
		}
		else
		{
			return ceil($res['num'] / Config::$customerPagesize);
		}
	}
	
	public function countByWeek($year, $month, $week, $country, $type)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		$sqlCountry = Security::varSql($country);
		$sqlType = (int)$type;
		
		$sqlWhere = '';
		$whereFlag = false;
		
		if ($sqlYear > 0)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and year=$sqlYear ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " year=$sqlYear ";
			}
		}
		
		if ($sqlMonth >= 1 && $sqlMonth <= 12)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and month=$sqlMonth ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " month=$sqlMonth ";
			}
		}
		
		if ($sqlWeek >= 1 && $sqlWeek <= 5)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and week=$sqlWeek ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " week=$sqlWeek ";
			}
		}
		
		if (!empty($country))
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and country=$sqlCountry ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " country=$sqlCountry ";
			}
		}
		
		if ($sqlType >= 1 && $sqlType <= 3)
		{
			if ($whereFlag)
			{
				$sqlWhere .= " and status=$sqlType ";
			}
			else
			{
				$whereFlag = true;
				$sqlWhere .= " status=$sqlType ";
			}
		}
		
		//Config::$db->query("SELECT count(*) AS num FROM $tbCustomer WHERE  year=$sqlYear and month=$sqlMonth and week=$sqlWeek and country=$sqlCountry and status=$sqlType");
		
		if (empty($sqlWhere))
		{
			Config::$db->query("SELECT count(*) AS num FROM $tbCustomer");
		}
		else
		{
			Config::$db->query("SELECT count(*) AS num FROM $tbCustomer WHERE $sqlWhere");
		}
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
	
	public function getCustomerByPage($page, $pagesize, $type)
	{
		Config::$db->connect();
		$page = (int)$page;
		$pagesize = (int)$pagesize;
		$type = (int)$type;
		if ($page < 1)
		{
			$page = 1;
		}
		$from = ($page - 1) * $pagesize;
		$tbCustomer = Config::$tbCustomer;
		switch ($type)
		{
			case 1:
				Config::$db->query("SELECT * FROM $tbCustomer WHERE status=1 ORDER BY id LIMIT $from, $pagesize");
				$res = Config::$db->getAllRows();
				break;
			case 2:
				Config::$db->query("SELECT * FROM $tbCustomer WHERE status=2 ORDER BY id LIMIT $from, $pagesize");
				$res = Config::$db->getAllRows();
				break;
			case 3:
				Config::$db->query("SELECT * FROM $tbCustomer WHERE status=3 ORDER BY id LIMIT $from, $pagesize");
				$res = Config::$db->getAllRows();
				break;
			default:
				$res = null;
		}
		
		return $res;
	}
	
	public function getCustomerById($id)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlId = (int)$id;
		Config::$db->query("select * from $tbCustomer where id=$sqlId");
		
		return Config::$db->getRow();
	}
	
	public function import($year, $month, $week)
	{
		$param = $this->uploadExcel();
		$filename = $param['url'];
		
		if (empty($filename))
		{
			return array('error' => 'Upload failed!', 'msg' => '');
		}
		else
		{
			$this->deleteByWeek($year, $month, $week);
			if ($this->importData($filename, $year, $month, $week))
			{
				return array('error' => '', 'msg' => 'OK!');
			}
			else
			{
				return array('error' => 'Import failed!', 'msg' => '');
			}
		}
	}
	
	private function uploadExcel()
	{
		$error = "";
		$msg = "";
		$url = '';
		$fileElementName = 'fileToUpload';
		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}
		elseif (empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		}
		else
		{
				$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
				$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
				//for security reason, we force to remove all uploaded file
				//@unlink($_FILES['fileToUpload']);
				$url = $this->getImageName($_FILES['fileToUpload']['name']);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $url);
		}
		
		return array('error' => $error, 'msg' => $msg, 'url' => $url);
	}
	
	private function getImageName($extend)
	{
		$arr = explode('.', $extend);
		return Config::$dirUploads . time() . rand(1000, 9999) . '.' . $arr[count($arr) - 1];
	}
	
	private function importData($filename, $year, $month, $week)
	{
		$data = $this->readExcel($filename);
		if (empty($data))
		{
			return false;
		}
		else
		{
			if ($this->importDb($data, $year, $month, $week))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	private function readExcel($filename)
	{
		require_once('Classes/PHPExcel.php');
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($filename);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
		$excelData = array();
		for ($row = 1; $row <= $highestRow; $row++)
		{
			for ($col = 0; $col < $highestColumnIndex; $col++)
			{
				$excelData[$row][] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			}
		}
		
		return $excelData;
	}
	
	private function importDb($data, $year, $month, $week)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$user = new User();
		$sqlUserId = (int)$user->getUserId();
		$sqlTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		
		$rowIndex = 0;
		foreach ($data as $row)
		{
			$rowIndex++;
			if (1 == $rowIndex)
			{
				continue;
			}
			
			$isEmpty = false;
			for ($i = 0; $i < 11; $i++)
			{
				if (empty($row[$i]))
				{
					$isEmpty = true;
					break;
				}
			}
			if ($isEmpty)
			{
				continue;
			}
			
			$sqlNo = Security::varSql($row[0]);
			$sqlCountry = Security::varSql($row[1]);
			$sqlDate = Security::varSql(date('Y-m-d', strtotime($row[2])));
			$sqlWoNumber = Security::varSql($row[3]);
			$sqlCustomerName = Security::varSql($row[4]);
			$sqlType = Security::varSql($row[5]);
			$sqlPhone = Security::varSql($row[6]);
			$sqlModel = Security::varSql($row[7]);
			$sqlSetReturn = Security::varSql(date('Y-m-d', strtotime($row[8])));
			$sqlWb = Security::varSql($row[9]);
			$sqlInBay = Security::varSql($row[10]);
			
			Config::$db->query("INSERT INTO $tbCustomer (no, country, date1, wo_number, customer_name, type, phone, model, set_return, wb, in_bay, import_user, import_time, year, month, week, status) VALUES ($sqlNo, $sqlCountry, $sqlDate, $sqlWoNumber, $sqlCustomerName, $sqlType, $sqlPhone, $sqlModel, $sqlSetReturn, $sqlWb, $sqlInBay, $sqlUserId, $sqlTime, $sqlYear, $sqlMonth, $sqlWeek, 1)");
		}
		
		return true;
	}
	
	public function export($year, $month, $week)
	{
		require_once('Classes/PHPExcel.php');
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
		$excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('Q')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('R')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('S')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('T')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('U')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('V')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('W')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('X')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('Y')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('Z')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AA')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AB')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AC')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AD')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AE')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AF')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AG')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$excel->getActiveSheet()->getStyle('AH')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
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
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Country')
			->setCellValue('C1', 'Date')
			->setCellValue('D1', 'WO Number')
			->setCellValue('E1', 'Customer Name')
			->setCellValue('F1', 'Type')
			->setCellValue('G1', 'Phone')
			->setCellValue('H1', 'Model')
			->setCellValue('I1', 'Set Return')
			->setCellValue('J1', 'W/B')
			->setCellValue('K1', 'InBay')
			->setCellValue('L1', 'Year')
			->setCellValue('M1', 'Month')
			->setCellValue('N1', 'Week')
			->setCellValue('O1', 'Import Time')
			->setCellValue('P1', 'Operator Fill')
			->setCellValue('Q1', 'Fill Time')
			->setCellValue('R1', 'Operator Change')
			->setCellValue('S1', 'Change Time')
			->setCellValue('T1', 'Status')
			->setCellValue('U1', 'Error Status')
			->setCellValue('V1', 'Dial Number')
			->setCellValue('W1', 'Feedback')
			->setCellValue('X1', 'Language')
			->setCellValue('Y1', 'Is Take Back')
			->setCellValue('Z1', 'Is Accept Interview')
			->setCellValue('AA1', 'Q1')
			->setCellValue('AB1', 'Q2')
			->setCellValue('AC1', 'Q3')
			->setCellValue('AD1', 'Q4')
			->setCellValue('AE1', 'Q5')
			->setCellValue('AF1', 'Q5_2')
			->setCellValue('AG1', 'Q6')
			->setCellValue('AH1', 'Q6_2');
		
		//$data = $this->getAllCustomer();
		$data = $this->getAllCustomerByWeek($year, $month, $week);
		$rowIndex = 2;
		foreach ($data as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['no'])
				->setCellValue('B' . $rowIndex, $row['country'])
				->setCellValue('C' . $rowIndex, $row['date1'])
				->setCellValue('D' . $rowIndex, $row['wo_number'])
				->setCellValue('E' . $rowIndex, $row['customer_name'])
				->setCellValue('F' . $rowIndex, $row['type'])
				->setCellValue('G' . $rowIndex, $row['phone'])
				->setCellValue('H' . $rowIndex, $row['model'])
				->setCellValue('I' . $rowIndex, $row['set_return'])
				->setCellValue('J' . $rowIndex, $row['wb'])
				->setCellValue('K' . $rowIndex, $row['in_bay'])
				->setCellValue('L' . $rowIndex, $row['year'])
				->setCellValue('M' . $rowIndex, $row['month'])
				->setCellValue('N' . $rowIndex, $row['week'])
				->setCellValue('O' . $rowIndex, $row['import_time'])
				->setCellValue('P' . $rowIndex, $row['fill_user'])
				->setCellValue('Q' . $rowIndex, $row['fill_time'])
				->setCellValue('R' . $rowIndex, $row['change_user'])
				->setCellValue('S' . $rowIndex, $row['change_time'])
				->setCellValue('T' . $rowIndex, $row['status'])
				->setCellValue('U' . $rowIndex, $row['error_status'])
				->setCellValue('V' . $rowIndex, $row['dial_number'])
				->setCellValue('W' . $rowIndex, $row['feedback'])
				->setCellValue('X' . $rowIndex, $row['language'])
				->setCellValue('Y' . $rowIndex, $row['is_take_back'])
				->setCellValue('Z' . $rowIndex, $row['is_accept_interview'])
				->setCellValue('AA' . $rowIndex, $row['q1'])
				->setCellValue('AB' . $rowIndex, $row['q2'])
				->setCellValue('AC' . $rowIndex, $row['q3'])
				->setCellValue('AD' . $rowIndex, $row['q4'])
				->setCellValue('AE' . $rowIndex, $row['q5'])
				->setCellValue('AF' . $rowIndex, $row['q5_2'])
				->setCellValue('AG' . $rowIndex, $row['q6'])
				->setCellValue('AH' . $rowIndex, $row['q7']);
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
	
	public function dial($id, $dialNum, $feedback, $language, $isTakeBack, $isAcceptInterview)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$user = new User();
		$sqlUserId = (int)$user->getUserId();
		$sqlFillTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlId = (int)$id;
		$sqlDialNum = (int)$dialNum;
		$sqlFeedback = (int)$feedback;
		$sqlLanguage = (int)$language;
		$sqlIsTakeBack = (int)$isTakeBack;
		$sqlIsAcceptInterview = (int)$isAcceptInterview;
		
		$sqlStatus = 1;
		$sqlErrorStatus = 0;
		
		if ($sqlDialNum >= 4)
		{
			$sqlStatus = 3;
			$sqlErrorStatus = 1;
		}
		else
		{
			if (0 == $sqlIsTakeBack)
			{
				$sqlStatus = 3;
				$sqlErrorStatus = 1;
			}
			else
			{
				if (0 == $sqlIsAcceptInterview)
				{
					$sqlStatus = 3;
					$sqlErrorStatus = 1;
				}
				else
				{
					$sqlStatus = 1;
					$sqlErrorStatus = 0;
				}
			}
		}
		
		Config::$db->query("update $tbCustomer set fill_user=$sqlUserId, fill_time=$sqlFillTime, status=$sqlStatus, error_status=$sqlErrorStatus, dial_number=$sqlDialNum, feedback=$sqlFeedback, language=$sqlLanguage, is_take_back=$sqlIsTakeBack, is_accept_interview=$sqlIsAcceptInterview where id=$sqlId");
	}
	
	public function drop($id, $exception)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$user = new User();
		$sqlUserId = (int)$user->getUserId();
		$sqlFillTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlId = (int)$id;
		$sqlException = (int)$exception;
		$sqlStatus = 3;
		$sqlErrorStatus = 1;
		
		Config::$db->query("update $tbCustomer set fill_user=$sqlUserId, fill_time=$sqlFillTime, status=$sqlStatus, error_status=$sqlErrorStatus where id=$sqlId");
	}
	
	public function fillForm($id, $q1, $q2, $q3, $q4, $q5, $q5_2, $q6, $q7)
	{
		Debug::log('fillForm');
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$user = new User();
		$sqlUserId = (int)$user->getUserId();
		$sqlFillTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlStatus = 2;
		$sqlErrorStatus = 0;
		$sqlId = (int)$id;
		$sqlQ1 = Security::varSql($q1);
		$sqlQ2 = Security::varSql($q2);
		$sqlQ3 = Security::varSql($q3);
		$sqlQ4 = Security::varSql($q4);
		$sqlQ5 = Security::varSql($q5);
		$sqlQ5_2 = Security::varSql($q5_2);
		$sqlQ6 = Security::varSql($q6);
		$sqlQ7 = Security::varSql($q7);
		Config::$db->query("update $tbCustomer set fill_user=$sqlUserId, fill_time=$sqlFillTime, status=$sqlStatus, error_status=$sqlErrorStatus, q1=$sqlQ1, q2=$sqlQ2, q3=$sqlQ3, q4=$sqlQ4, q5=$sqlQ5, q5_2=$sqlQ5_2, q6=$sqlQ6, q7=$sqlQ7 where id=$sqlId");
	}
	
	public function changeForm($id, $q1, $q2, $q3, $q4, $q5, $q5_2, $q6, $q7)
	{
		Debug::log('changeForm');
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$user = new User();
		$sqlUserId = (int)$user->getUserId();
		$sqlFillTime = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		$sqlId = (int)$id;
		$sqlQ1 = Security::varSql($q1);
		$sqlQ2 = Security::varSql($q2);
		$sqlQ3 = Security::varSql($q3);
		$sqlQ4 = Security::varSql($q4);
		$sqlQ5 = Security::varSql($q5);
		$sqlQ5_2 = Security::varSql($q5_2);
		$sqlQ6 = Security::varSql($q6);
		$sqlQ7 = Security::varSql($q7);
		Config::$db->query("update $tbCustomer set change_user=$sqlUserId, change_time=$sqlFillTime, q1=$sqlQ1, q2=$sqlQ2, q3=$sqlQ3, q4=$sqlQ4, q5=$sqlQ5, q5_2=$sqlQ5_2, q6=$sqlQ6, q7=$sqlQ7 where id=$sqlId");
	}
	
	public function count()
	{
		echo 'count';
	}
	
	public function checkExist($year, $month, $week)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		Config::$db->query("select * from $tbCustomer where year=$sqlYear and month=$sqlMonth and week=$sqlWeek");
		
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
	
	private function deleteByWeek($year, $month, $week)
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		$sqlYear = (int)$year;
		$sqlMonth = (int)$month;
		$sqlWeek = (int)$week;
		Config::$db->query("delete from $tbCustomer where year=$sqlYear and month=$sqlMonth and week=$sqlWeek");
	}
	
	public function getCountryList()
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		Config::$db->query("select distinct country from $tbCustomer");
		$res = Config::$db->getAllRows();
		
		$arr = array();
		foreach ($res as $value)
		{
			$arr[] = $value['country'];
		}
		
		return $arr;
	}
	
	public function getYearList()
	{
		Config::$db->connect();
		$tbCustomer = Config::$tbCustomer;
		Config::$db->query("select distinct year from $tbCustomer");
		$res = Config::$db->getAllRows();
		
		$arr = array();
		foreach ($res as $value)
		{
			$arr[] = $value['year'];
		}
		
		return $arr;
	}
}
?>
