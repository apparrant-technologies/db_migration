<?php 

require_once dirname(__FILE__) . '/../require_files.php';

define('DS', DIRECTORY_SEPARATOR); 


// Common Errors Script


Class PerformanceMetrics {


	public $ExcelFileName=__DIR__.'/../output/performance_metrics.xlsx';
	
	
	public function timeMetrics (){
		
		
		$find=array('status'=>array('$in'=>array('error','done')),'migration_school'=>array('$exists'=>true));	
		$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
		$findALL=$migrationConnection->findALL($find);
		
		
		return $this->Excelprepare($findALL);
		
		foreach($findALL as $select):
			print_r($select['created']->sec);
			
			echo date('m/d/Y h:i:m', $select['created']->sec);
			die;
		endforeach;
		
		
		
	}
	
	public function Excelprepare($result){
		
		// Create new PHPExcel object
		echo date('H:i:s') , " Create new PHPExcel object" , PHP_EOL;
		$objPHPExcel = new PHPExcel();

		// Set document properties
		echo date('H:i:s') , " Set document properties" , PHP_EOL;
		$objPHPExcel->getProperties()->setCreator("Saurabh Chhabra")
									 ->setLastModifiedBy("100rabh_Migration_Tool")
									 ->setTitle("DataMigartion")
									 ->setSubject("DataMigartion")
									 ->setDescription("Fliplearn Migration Tool")
									 ->setKeywords("fepl migartion Fliplearn Saurabh data")
									 ->setCategory("Migration");

		// Set default font
		echo date('H:i:s') , " Set default font" , PHP_EOL;
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
												  ->setSize(10);
												  
												  
												  
		$objSheet = $objPHPExcel->getActiveSheet();	
	
		$row=1;$col=0;
	
		$objSheet->getColumnDimension('A')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('B')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('C')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('D')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('E')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('F')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('G')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('H')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('I')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('J')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('K')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('L')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('M')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('N')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('O')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('P')->setAutoSize(TRUE);
		$objSheet->getColumnDimension('Q')->setAutoSize(TRUE);
		$objSheet->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("P")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objSheet->getStyle("Q")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Boarding Type');$col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'New School Code'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Old Infra School ID'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Result Excel'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Migration Excel'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Cron Start'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'Cron End'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'status'); $col++;


		
		
		//$row=1;
		$row++;
		foreach ($result as $mongoFetch){			//print_r($mongoFetch);die;
					
				$col =0;

				
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['type']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['school_code']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['migration_school']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['result_path']); $col++;
				
				
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['data_s3_path']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, date('m/d/Y h:i:m', $mongoFetch['created']->sec)); $col++;
				
				$objSheet->setCellValueByColumnAndRow($col, $row, date('m/d/Y h:i:m', $mongoFetch['updated']->sec)); $col++;
				
				$objSheet->setCellValueByColumnAndRow($col, $row, $mongoFetch['status']); $col++;

				
				$row++;
		}
				//echo $row."<br/>";
				
		
		$ExcelObject='Not Loaded   ';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		if($objWriter){
		$objWriter->save($this->ExcelFileName);
		$ExcelObject='Loaded   ';
		}
			
		$objSheet->setTitle('Wrong_Mobile ');
			
			
		
		$sendMail=new customMAIL();

		$loop=new Loop(MAIL_USER);
		$user = trim($loop->keyD);


		$loop=new Loop(MAIL_PASS);
		$password = trim($loop->keyD);

		$sendMail->onbmail($user,$password,'saurabh.chhabra@fliplearn.com',$this->ExcelFileName,'','PerformanceMetrics '.'['. date('Y-m-d') .']');
		
		
		
	
	}	


}





$metrics=new PerformanceMetrics;


$metrics->timeMetrics();