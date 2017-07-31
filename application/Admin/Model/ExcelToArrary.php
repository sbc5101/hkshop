<?php 
	namespace app\admin\model;

	use vendor\phpexcel\PHPExcel;
	use vendor\phpexcel\PHPExcel\IOFactory;

	class ExcelToArrary  extends \think\Model
	{

		public function __construct() 
		{
	    	/*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
	     	// vendor('phpexcel.PHPExcel'); 
		}

		/**
		* 读取excel $filename 路径文件名 
		* 
		*以下基本都不要修改
		*/
		public function read($filename,$sheetName = array("Sheet1"))
		{
			// 初始化数据
			$data = [];
			vendor('phpexcel.PHPExcel.IOFactory');

			$fileType = IOFactory::identify($filename);
			$objReader = IOFactory::createReader($fileType);
			//只加载指定的sheet
			$objReader -> setLoadSheetsOnly($sheetName);
			//加载文件
			$objPHPExcel = $objReader->load($filename);
			//获取excel文件里有多少个sheet
			$sheetCount = $objPHPExcel->getSheetCount();
			$data = $objPHPExcel->getsheet()->toArray();
			return $data;
		}    
	}






 ?>