<?php
/*
**Author: Saurabh Chhabra
**Description : class_subjects_details
**
*/
function class_subjects_details($db_status,$objPHPExcel,$school_id,$log,$row=1,$col=0){
	
	$end_time=date('Y-m-d H:i:s');
	
	echo PHP_EOL,"Sheet 3 Called ",PHP_EOL;
	$log->lwrite('Class Subject Details ( Sheet 3 ) Called');
	$sql=file_get_contents(__DIR__.'/sql/class_subjects_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		$sql.=' where scs.school_id='.$school_id.' group by class_name,scs.section_name,subject_name order by level_id asc; ';
	}
	//echo $sql;die;
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
	
	onbMetrics($db_status,$school_id,$log,$sheetType=3,$onbType='sonb',$num_rows);

	$objSheet = $objPHPExcel->getActiveSheet();	
	$objSheet = $objPHPExcel->createSheet();
	
	$objSheet->getColumnDimension('A')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('B')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('C')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('D')->setAutoSize(TRUE);
    $objSheet->getColumnDimension('E')->setAutoSize(TRUE);
	$objSheet->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Class Level');$col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Class Name'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Sections'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Subject'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Subject Type'); $col++;
    
		
	$row++;
	//$row++;
    while ($sqlfetch = $result->fetch_assoc()){
		//break;
		
		if($sqlfetch['subject_name'] !==NULL){
			$col =0;
			
			//print_R($sqlfetch['school_name']);die; 
			 
			if(strpos($sqlfetch['section_name'],$sqlfetch['class_name']) !==false){
				$section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
				$section=$section[1];
			}else{
				$section=$sqlfetch['section_name'];
			}
			
			$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['level_id']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['class_name']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, trim($section)); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['subject_name']); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'Core'); $col++;
			
			$row++;
			}
			//echo $row."<br/>";
		}	
        
    
    $objSheet->setTitle('Class-Subjects Details');
	
	return $objSheet;
}
?>