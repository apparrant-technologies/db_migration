<?php
/*
**Author: Saurabh Chhabra
**Description : teacher_details
**
*/
function teacher_details($db_status,$objPHPExcel,$school_id,$log,$type=false,$batch,$row=1,$col=0){
	echo PHP_EOL,"Sheet 2 Called ",PHP_EOL;
	$log->lwrite('Class Section Details ( Sheet 2 ) Called');
	$sql=file_get_contents(__DIR__.'/sql/teacher_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ; ';	
		}else{
		$sql.=' where m.school_id='.$school_id.' ; ';
		}
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
	
	onbMetrics($db_status,$school_id,$log,$sheetType=2,$onbType='uonb',$num_rows);

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
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Email Id'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Mobile Number'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Login ID'); $col++;
    //$objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Password'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'Teacher Ums ID'); $col++;
    
		
	$row++;
	//$row++;
    while ($sqlfetch = $result->fetch_assoc()){

		$col =0;
		
		$int_shuffle='3'.$sqlfetch['UUID'].str_shuffle('000000000');
		$mobile_shuffle = mb_substr($int_shuffle, 0, 10);
		
		$str_shuffle_2=trim($sqlfetch['tea_name'].$sqlfetch['UUID'].'@fliplearn.com');
		$str_shuffle_2 = str_replace(' ', '', $str_shuffle_2);
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
		
		$valEmail_tea=isValidEmail($sqlfetch['email_id']);
			if($valEmail_tea){
				$tea_email=strtolower($sqlfetch['email_id']);
			}else{
				$tea_email='';
			}
		
		
		
		 //print_R($sqlfetch['school_name']);die; 
		if(!empty($sqlfetch['migration_user_name'])){
			$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['migration_user_name']); $col++;
		}else{
			$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['tea_name']); $col++;
		}
		if($type=='demo'){		
		$objSheet->setCellValueByColumnAndRow($col, $row, $str_shuffle_2); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $mobile_shuffle); $col++;
		}else{
		$objSheet->setCellValueByColumnAndRow($col, $row, $tea_email); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $mobileNo); $col++;
		}
		if(!empty($sqlfetch['migration_login_id'])){
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['migration_login_id']); $col++;
		}else{
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['login_id']); $col++;
		}
		//$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['password']); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['ums_id']); $col++;
		
        $row++;
        }
        //echo $row."<br/>";
        
        
    
    $objSheet->setTitle('Teacher Details');
	
	return $objSheet;
}
?>