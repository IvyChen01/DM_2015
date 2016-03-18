<?php
/**
 * 转盘
 * @author Shines
 */
class ZhuanPan
{
	public function __construct()
	{
	}
	
	/**
	 * 抽奖
	 */
	public function lucky($openId)
	{
		//记录今天抽过奖
		$this->setLuckyToday($openId);
		
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		$date = Utils::mdate('Y-m-d');
		$sqlDate = Security::varSql($date);
		Config::$db->query("select * from $tbZpJiangChi where prizedate=$sqlDate");
		$res = Config::$db->getRow();
		if (!empty($res))
		{
			//根据设定的概率判断是否中奖
			$rand = rand(1, 100);
			if ($rand <= (int)$res['rate'])
			{
				//组合奖品id
				$prizeArr = array_merge(
					$this->joinPrize(1, $res['prize1']),
					$this->joinPrize(2, $res['prize2']),
					$this->joinPrize(3, $res['prize3']),
					$this->joinPrize(4, $res['prize4']),
					$this->joinPrize(5, $res['prize5']),
					$this->joinPrize(6, $res['prize6']),
					$this->joinPrize(7, $res['prize7']),
					$this->joinPrize(8, $res['prize8']),
					$this->joinPrize(9, $res['prize9']),
					$this->joinPrize(10, $res['prize10'])
				);
				
				//判断当天奖池中是否还有奖品
				$prizeArrCount = count($prizeArr);
				if ($prizeArrCount > 0)
				{
					$prizeRnd = rand(0, $prizeArrCount - 1);
					$prizeId = $prizeArr[$prizeRnd];
					$luckyCode = $this->genCode();
					//减少奖池中对应的奖品，保存中奖数据
					$this->reduceJiangChi($date, $prizeId);
					$this->saveLucky($openId, $prizeId, $luckyCode);
					return array('prizeId' => $prizeId, 'prizeName' => Config::$prizeName[$prizeId - 1], 'luckyCode' => $luckyCode);
				}
			}
		}
		return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
	}
	
	/**
	 * 检测今天是否抽过奖
	 */
	public function checkLuckyToday($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpDaily where fbid=$sqlOpenId and date_format(luckydate, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('isLucky' => false, 'isClick' => false);
		}
		else
		{
			$isClick = ($res['isclick'] == 0) ? false : true;
			return array('isLucky' => true, 'isClick' => $isClick);
		}
	}
	
	/**
	 * 检测是否抽过奖
	 */
	public function checkLucky($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbZpDaily where fbid=$sqlOpenId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('isLucky' => false, 'isClick' => false);
		}
		else
		{
			$isClick = ($res['isclick'] == 0) ? false : true;
			return array('isLucky' => true, 'isClick' => $isClick);
		}
	}
	
	/**
	 * 检测今天是否中奖
	 */
	public function checkWinToday($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("select * from $tbZpZhongJiang where fbid=$sqlOpenId and date_format(luckydate, '%Y-%m-%d')=$sqlDate");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prizeid'], 'prizeName' => Config::$prizeName[$res['prizeid'] - 1], 'luckyCode' => $res['luckycode']);
		}
	}
	
	/**
	 * 检测是否中奖
	 */
	public function checkWin($openId)
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		$sqlOpenId = Security::varSql($openId);
		Config::$db->query("select * from $tbZpZhongJiang where fbid=$sqlOpenId");
		$res = Config::$db->getRow();
		if (empty($res))
		{
			return array('prizeId' => 0, 'prizeName' => '', 'luckyCode' => '');
		}
		else
		{
			return array('prizeId' => $res['prizeid'], 'prizeName' => Config::$prizeName[$res['prizeid'] - 1], 'luckyCode' => $res['luckycode']);
		}
	}
	
	/**
	 * 记录今天抽过奖
	 */
	private function setLuckyToday($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
		Config::$db->query("insert into $tbZpDaily (fbid, isclick, luckydate) values ($sqlOpenId, 0, $sqlDate)");
	}
	
	/**
	 * 组合奖品
	 */
	private function joinPrize($prize, $num)
	{
		$res = array();
		for ($i = 0; $i < $num; $i++)
		{
			$res[] = $prize;
		}
		return $res;
	}
	
	/**
	 * 减少奖池里指定的奖品数量
	 */
	private function reduceJiangChi($date, $prizeId)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpJiangChi = Config::$tbZpJiangChi;
			$sqlDate = Security::varSql($date);
			$fieldName = 'prize' . $prizeId;
			Config::$db->query("update $tbZpJiangChi set $fieldName=$fieldName-1 where prizedate=$sqlDate");
		}
	}
	
	/**
	 * 保存中奖数据
	 */
	private function saveLucky($openId, $prizeId, $luckyCode)
	{
		$prizeId = (int)$prizeId;
		if ($prizeId >= 1 && $prizeId <= Config::$maxPrize)
		{
			Config::$db->connect();
			$tbZpZhongJiang = Config::$tbZpZhongJiang;
			$sqlOpenId = Security::varSql($openId);
			$sqlLuckyCode = Security::varSql($luckyCode);
			$sqlDate = Security::varSql(Utils::mdate('Y-m-d H:i:s'));
			Config::$db->query("insert into $tbZpZhongJiang (fbid, prizeid, luckycode, luckydate) values ($sqlOpenId, $prizeId, $sqlLuckyCode, $sqlDate)");
		}
	}
	
	/**
	 * 记录点击过转盘
	 */
	public function setClick($openId)
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		$sqlOpenId = Security::varSql($openId);
		$sqlDate = Security::varSql(Utils::mdate('Y-m-d'));
		Config::$db->query("update $tbZpDaily set isclick=1 where fbid=$sqlOpenId and date_format(luckydate, '%Y-%m-%d')=$sqlDate");
	}
	
	/**
	 * 获取每日抽奖数据
	 */
	public function getDaily()
	{
		Config::$db->connect();
		$tbZpDaily = Config::$tbZpDaily;
		Config::$db->query("select * from $tbZpDaily order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 获取中奖数据
	 */
	public function getZhongJiang()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select * from $tbZpZhongJiang order by id");
		return Config::$db->getAllRows();
	}
	
	/**
	 * 初始化转盘奖池
	 */
	public function initPrize()
	{
		Config::$db->connect();
		$tbZpJiangChi = Config::$tbZpJiangChi;
		Config::$db->query("delete from $tbZpJiangChi");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-9', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-10', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-11', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-12', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-13', 20, 0, 0, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-14', 20, 1, 0, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-15', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-16', 20, 0, 1, 2)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-17', 20, 0, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-18', 20, 0, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-19', 20, 0, 1, 1)");
		Config::$db->query("insert into $tbZpJiangChi (prizedate, rate, prize1, prize2, prize3) values ('2015-12-20', 20, 0, 1, 1)");
		
		Config::$db->query("select * from $tbZpJiangChi");
		$res = Config::$db->getAllRows();
		$num = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$total = 0;
		foreach ($res as $value)
		{
			for ($i = 1; $i <= 10; $i++)
			{
				$num[$i - 1] += $value['prize' . $i];
				$total += $value['prize' . $i];
			}
		}
		Utils::dump($num);
		echo '<br />total: ' . $total . '<br /><br />';
	}
	
	/**
	 * 生成随机码
	 */
	public function genCode()
	{
		Config::$db->connect();
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		for ($i = 0; $i < 10; $i++)
		{
			$rnd = rand(10000000, 99999999);
			$sqlRnd = Security::varSql($rnd);
			Config::$db->query("select id from $tbZpZhongJiang where luckycode=$sqlRnd");
			$res = Config::$db->getRow();
			if (empty($res))
			{
				return '' . $rnd;
			}
		}
		return '';
	}
	
	public function getWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, zj.prizeid as prizeid, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id desc");
		return Config::$db->getAllRows();
	}
	
	public function getAdminWinlist()
	{
		Config::$db->connect();
		$tbUser = Config::$tbUser;
		$tbZpZhongJiang = Config::$tbZpZhongJiang;
		Config::$db->query("select user.fbid as fbid, user.username as username, user.photo as photo, user.email as email, user.gender as gender, user.regtime as regtime, user.logintype as logintype, zj.prizeid as prizeid, zj.luckycode as luckycode, zj.luckydate as luckydate from $tbZpZhongJiang as zj join $tbUser as user on zj.fbid=user.fbid order by zj.id");
		return Config::$db->getAllRows();
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
		
		//设置垂直居中
		$excel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
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
			->setCellValue('D1', 'Register Date');
		
		$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$res = $this->getUserByPage(1, 100000);
		$rowIndex = 2;
		foreach ($res as $row)
		{
			$excel->getActiveSheet()
				->setCellValue('A' . $rowIndex, $row['username'])
				->setCellValue('B' . $rowIndex, $row['gender'])
				->setCellValue('C' . $rowIndex, $row['email'])
				->setCellValue('D' . $rowIndex, $row['regtime']);
			$excel->getActiveSheet()->getRowDimension($rowIndex)->setRowHeight(50);
			$rowIndex++;
		}
		
		$fileFormat = 'excel';
		if ('excel' == $fileFormat)
		{
			//输出EXCEL格式
			$filename = 'note2ng_' . Utils::mdate('Y.m.d') . '.xls';
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
			$filename = 'note2ng_' . Utils::mdate('Y.m.d') . '.pdf';
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
}
?>
