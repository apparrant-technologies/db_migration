<?php
/*
**Author: Saurabh Chhabra
**Description : user_details
**
*/


function user_details($db_status,$objPHPExcel,$school_id,$school_code,$ayid,$log,$type=false,$promotion,$batch=false,$row=1,$col=0){ 

	$end_time=date('Y-m-d H:i:s');
	
	echo PHP_EOL,"Sheet 1 Called ",PHP_EOL;
	$log->lwrite('Student Details ( Sheet 1 ) Called');
	
	$sql=file_get_contents(__DIR__.'/sql/principal.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	//   PRINCIPAL //
	$principal=mysqli_query($db_status,$sql);
	
	$writelog=PHP_EOL.'Sql Query Time End ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	
	$sql=file_get_contents(__DIR__.'/sql/school_admin.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	//   ADMIN //
	$admin=mysqli_query($db_status,$sql);
	
	$sql=file_get_contents(__DIR__.'/sql/teacher_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	//   TEACHER //
	$teacher=mysqli_query($db_status,$sql);
	
	
	
	
	
	$sql=file_get_contents(__DIR__.'/sql/class_teachers.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	// CLASS TEACHER //
	$class_teachers=mysqli_query($db_status,$sql);
	
	
	$sql=file_get_contents(__DIR__.'/sql/parent.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	// Parent //
	$parent=mysqli_query($db_status,$sql);
	
	
	$sql=file_get_contents(__DIR__.'/sql/student_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		if(isset($batch)){
		$sql.=' where m.school_id='.$school_id.' limit '.$batch.' ;';
		}else{
		$sql.=' where m.school_id='.$school_id.' ;';
		}
	}
	
	$writelog=PHP_EOL.'Sql Query Time Start ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	// Student //
	$student=mysqli_query($db_status,$sql);
	$student1=mysqli_query($db_status,$sql);
	
	
	
	//onbMetrics($db_status,$school_id,$log,$sheetType=1,$onbType='uonb',$num_rows);

	$objSheet = $objPHPExcel->getActiveSheet();	
	
	
	
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
	
    $objSheet->setCellValueByColumnAndRow($col, $row, 'schoolCode');$col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'ayid'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'groupCode'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'uuid'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'groupType'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'schoolRoleCode'); $col++;
    $objSheet->setCellValueByColumnAndRow($col, $row, 'adminUuid'); $col++;
    
	$row++;
	
    while ($sqlfetch = $admin->fetch_assoc()){
			$col =0;
			//$codes=getClassCodes($school_id,$level_id,$section);//print_r($codes);die;
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SCHG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SAD'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	while ($sqlfetch = $principal->fetch_assoc()){
			$col =0;
			//$codes=getClassCodes($school_id,$level_id,$section);//print_r($codes);die;
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SCHG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'PRI'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	while ($sqlfetch = $parent->fetch_assoc()){
			$col =0;
			//$codes=getClassCodes($school_id,$level_id,$section);//print_r($codes);die;
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SCHG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'PAR'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	while ($sqlfetch = $teacher->fetch_assoc()){
			$col =0;
			//$codes=getClassCodes($school_id,$level_id,$section);//print_r($codes);die;
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SCHG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'TEA'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	
	while ($sqlfetch = $class_teachers->fetch_assoc()){
			$col =0;
			
			if(strpos($sqlfetch['section_name'],$sqlfetch['class_name']) !==false){
                $section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
                $section=trim($section[1]);
            }else{
                $section=$sqlfetch['section_name'];
            }
			
			if($promotion=='Y' || $promotion=='y' ){
                if($sqlfetch['level_id'] ==16 || $sqlfetch['level_id'] ==15 ){
                    $level_id=($sqlfetch['level_id']-1);
                }elseif($sqlfetch['level_id'] == 14){
                    $level_id='1';
                }else{
                $level_id=($sqlfetch['level_id']+1);
                }

			}else{
                $level_id=($sqlfetch['level_id']);
            }


			
			$codes=getClassCodes($log,$school_id,$level_id,$section,$ayid);//print_r($codes);die;
			
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $codes['SectionGroupCode']); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SECG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SECT'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	while ($sqlfetch = $student1->fetch_assoc()){
			$col =0;
			
			//$codes=getClassCodes($school_id,$level_id,$section);
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SCHG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'STU'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	while ($sqlfetch = $student->fetch_assoc()){
			$col =0;
			
			if(strpos($sqlfetch['section_name'],$sqlfetch['class_name']) !==false){
                $section=explode($sqlfetch['class_name'],$sqlfetch['section_name']);
                $section=trim($section[1]);
            }else{
                $section=$sqlfetch['section_name'];
            }
			
			if($promotion=='Y' || $promotion=='y' ){
                if($sqlfetch['level_id'] ==16 || $sqlfetch['level_id'] ==15 ){
                    $level_id=($sqlfetch['level_id']-1);
                }elseif($sqlfetch['level_id'] == 14){
                    $level_id='1';
                }else{
                $level_id=($sqlfetch['level_id']+1);
                }

			}else{
                $level_id=($sqlfetch['level_id']);
            }


			
			$codes=getClassCodes($log,$school_id,$level_id,$section,$ayid);//print_r($codes);die;
			
			//$codes=getClassCodes($school_id,$level_id,$section);
			$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $ayid); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, $codes['SectionGroupCode']); $col++;	
			$objSheet->setCellValueByColumnAndRow($col, $row,$sqlfetch['UUID']); $col++;		
			$objSheet->setCellValueByColumnAndRow($col, $row, 'SECG'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'STU'); $col++;
			$objSheet->setCellValueByColumnAndRow($col, $row, 'null'); $col++;		
			$row++;
	}
	
	
			//echo $row."<br/>";
			
			
		
		$objSheet->setTitle("$school_code");
		
		
	
	return $objSheet;
}
?>