<?php
/*
**Author: Saurabh Chhabra
**Description : subject_details
**
*/


function subject_details($objPHPExcel,$school_code,$log,$type=false,$batch,$row=1,$col=0){
	echo PHP_EOL,"Sheet 6 Called ",PHP_EOL;
	$log->lwrite('Section Details ( Sheet 6 ) Called');
	
	//$arg=array('SchoolCode'=>$school_code);
	
	$arg=array('school_code'=>$school_code,'ayid'=>'3');
	$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
	$find=$migrationConnection->findALL($arg);
	$uploadID=array();
	//$schoolCode=NUll;
	
	foreach($find as $id){
		//$schoolCode=$id['school_code'];
		$uploadID[]=$id['UploadID'];
	}
	
	
	$mongoConnection= new SONBMongoConnectionClass('school_boarding_detail');//print_r($mongoConnection);die;
	
		
	$find=$mongoConnection->_connection->aggregateCursor(array( 
    array( '$match' => array("SchoolCode" => $school_code ,'UploadID'=>array('$in'=>$uploadID),'SectionCode' => array('$ne'=> null),'SubjectCode' => array('$ne'=> null))),
	array('$group'=>array('_id'=>array('ClassLevel'=>'$ClassLevel','ClassName'=>'$ClassName','Section'=>'$Section','SectionCode'=>'$SectionCode','SectionGroupCode'=>'$SectionGroupCode','Subject'=>'$Subject','SubjectGroupCode'=>'$SubjectGroupCode','SubjectCode'=>'$SubjectCode')))));
	
	//print_R($result);die;
	

	
	$objSheet = $objPHPExcel->getActiveSheet();	
	$objSheet = $objPHPExcel->createSheet();
	
	$objSheet->getColumnDimension('A')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('B')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('C')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('D')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('E')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('F')->setAutoSize(TRUE);
	$objSheet->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objSheet->setCellValueByColumnAndRow($col, $row, 'SectionMatch');$col++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'ClassLevel'); $col++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'ClassName'); $col++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Section'); $col++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'SubjectName'); $col++;
	$objSheet->setCellValueByColumnAndRow($col, $row, 'SubjectCode'); $col++;
	$objSheet->setCellValueByColumnAndRow($col, $row, 'SubjectGroupCode'); $col++;
    
		
	$row++;
	//$row++;
    foreach($find as $mongofetch){  //print_r($mongofetch);die;
		
		
		
			$col =0;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['ClassLevel'].$mongofetch['_id']['Section']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['ClassLevel']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['ClassName']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['Section']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['Subject']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['SubjectCode']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $mongofetch['_id']['SubjectGroupCode']); $col++;
			$row++;
		
        
        } 
        //echo $row."<br/>";
        
        
    
    $objSheet->setTitle('SubjectDetails');
	
	return $objSheet;
}
?>