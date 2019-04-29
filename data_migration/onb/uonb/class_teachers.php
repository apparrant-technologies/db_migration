<?php
/*
**Author: Saurabh Chhabra
**Description : class_teachers
**
*/


function class_teachers($db_status,$objPHPExcel,$school_id,$log,$type=false,$batch,$row=1,$col=0){
	echo PHP_EOL,"Sheet 3 Called ",PHP_EOL;
	$log->lwrite('Class Subject Details ( Sheet 3 ) Called');
	$sql=file_get_contents(__DIR__.'/sql/class_teachers.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
			$sql.=' where m.school_id='.$school_id.' group by m.UUID order by level_id asc limit '.$batch.'; ';
		}else{
		$sql.=' where m.school_id='.$school_id.' group by m.UUID order by level_id asc; ';
		}
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
	
	onbMetrics($db_status,$school_id,$log,$sheetType=3,$onbType='uonb',$num_rows);

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
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Name');$col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Mobile Number'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Class Level'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Sections'); $col++;
	$objSheet->setCellValueByColumnAndRow($col, $row, 'Section Code'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'SectionGroupCode'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'UmsID'); $col++;
    
		
	$row++;
	//$row++;
    while ($sqlfetch = $result->fetch_assoc()){

		$col =0;
		
		$writelog= PHP_EOL.date('H:i:s') ." [INFO] Class Teachers :: Excel Processing for Row ".($row-1).PHP_EOL."--------------------------^^^^^^^^^^--------------------------------".PHP_EOL;
		echo $writelog;
		$log->lwrite($writelog);
		
		//print_R($sqlfetch['school_name']);die; 
		 
		//$section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
		
		
		$int_shuffle='3'.$sqlfetch['UUID'].str_shuffle('000000000');
		$mobile_shuffle = mb_substr($int_shuffle, 0, 10);
		
		if(strpos($sqlfetch['section_name'],$sqlfetch['class_name']) !==false){
			$section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
			$section=trim($section[1]);
		}else{
			$section=$sqlfetch['section_name'];
		}
		
		 $admNo=!empty($sqlfetch['admission_number'])?$sqlfetch['admission_number']:'FEPL-'.$sqlfetch['UUID'];
		 //$mobileNo=!empty($sqlfetch['mobile_number'])?$sqlfetch['mobile_number']:$mobile_shuffle;
		 
		
		if(strlen($sqlfetch['mobile_number'])==10 ){
			$stuM=isValidIndianMobile($sqlfetch['mobile_number']);
				 if($stuM){
					 $mobileNo=!empty($sqlfetch['mobile_number'])?$sqlfetch['mobile_number']:$mobile_shuffle;	
				 }else{
					$mobileNo=$mobile_shuffle; 
				 }
		}
		if(strlen($sqlfetch['mobile_number'])!==10) {
			$mobileNo=$mobile_shuffle;
		}
		
		$str_shuffle=trim($sqlfetch['stu_name'].'@fliplearn.com');
		$str_shuffle_2 = str_replace(' ', '', $str_shuffle_2);
		//$mail_shuffle = mb_substr($str_shuffle, 0, 10);
		//print_r($mobile_shuffle);die;
		
		 //print_R($sqlfetch['school_name']);die; 
		 
		 
		$codes=getClassCodes($school_id,$sqlfetch['level_id'],$section);//print_r($codes['SectionCode']);die;
		if(!empty($sqlfetch['migration_user_name'])){
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['migration_user_name']); $col++;
		}else{
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['tea_name']); $col++;
		}
		//$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['tea_name']); $col++;
		if($type=='demo'){
		$objSheet->setCellValueByColumnAndRow($col, $row, $mobile_shuffle); $col++;
		}else{
		$objSheet->setCellValueByColumnAndRow($col, $row, $mobileNo); $col++;
		}
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['level_id']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $section); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $codes['SectionCode']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $codes['SectionGroupCode']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $codes['ums_id']); $col++;
		
        $row++;
        }
        //echo $row."<br/>";
        
        
    
    $objSheet->setTitle('Class Teachers');
	
	return $objSheet;
}
?>