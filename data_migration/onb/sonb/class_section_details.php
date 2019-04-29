<?php
/*
**Author: Saurabh Chhabra
**Description : class_section_details
**
*/




function class_section_details($db_status,$objPHPExcel,$school_id,$log,$row=1,$col=0){
	
	
	
	$level_id=array(1=>'Class 1',2=>'Class 2',3=>'Class 3',4=>'Class 4',5=>'Class 5',6=>'Class 6',7=>'Class 7',8=>'Class 8',9=>'Class 9',10=>'Class 10',11=>'Class 11',12=>'Class 12',13=>'LKG',14=>'KG',15=>'Nursery',16=>'Pre-Nursery');
	
	$start_time=date('Y-m-d H:i:s');
	
	echo PHP_EOL,"Sheet 2 Called ",PHP_EOL;
	$log->lwrite('Class Section Details ( Sheet 2 ) Called');
	$sql=file_get_contents(__DIR__.'/sql/class_section_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		$sql.=' where sm.school_id='.$school_id.'; ';
	}
	//echo $sql;//die;
	//$sql='select * from eol_prod.user_master limit 1;';
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	$result=mysqli_query($db_status,$sql);
	
	$writelog=PHP_EOL.'Sql Query Time End ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	
	//print_R($result);die;
	
	$num_rows = mysqli_num_rows($result);
	printf(PHP_EOL."Result set has %d rows.\n",$num_rows);
	
	onbMetrics($db_status,$school_id,$log,$sheetType=2,$onbType='sonb',$num_rows);

	$objSheet = $objPHPExcel->getActiveSheet();	
	$objSheet = $objPHPExcel->createSheet();
	
	$objSheet->getColumnDimension('A')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('B')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('C')->setAutoSize(TRUE);
	$objSheet->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Class Level');$col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Class Name'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Section'); $col++;
    
		
	$row++;
	//$row++;
    while ($sqlfetch = $result->fetch_assoc()){

		$col =0;
		
		
		
		if(strpos($sqlfetch['section_name'],$sqlfetch['class_name']) !==false){
			$section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
			$section=$section[1];
		}else{
			$section=$sqlfetch['section_name'];
		}
		
		 //print_R($sqlfetch['school_name']);die; 
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['level_id']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['class_name']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, trim($section)); $col++;
		
        $row++;
        }
        //echo $row."<br/>";
        
        
    
    $objSheet->setTitle('Class Section Details');
	
	return $objSheet;
}
?>