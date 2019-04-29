<?php
/*
**Author: Saurabh Chhabra
**Description : school_details
**
*/
function school_details($db_status,$objPHPExcel,$school_id,$log,$type=false,$regNo,$sheetType=1,$createSheet=0,$onbType='SONB',$school_code=NULL,$row=1,$col=0){


	$a_UUID=$p_UUID=ADMIN_UUID;
	
	$end_time=date('Y-m-d H:i:s');
	if($onbType=='UONB' || $onbType=='SONB'){
		try{

			$cond=array("migration_school"=>$school_id,"ayid"=> "4");
			$mongoConnection= new SONBMongoConnectionClass('upload_details');
			$findUPID=$mongoConnection->findRecord($cond);
			$ID=$findUPID['school_code'];
			
			$school_code=$findUPID['school_code'];
			
			$cond=array("SchoolCode"=>(int)$ID);
			$mongoConnection= new SONBMongoConnectionClass('school_orders');
			$find_adult=$mongoConnection->findRecord($cond);
			
			$a_UUID=$a_response=$find_adult['adminUuid'];
			$p_UUID=$p_response=$find_adult['principalUuid'];
			
			$writelog= date('H:i:s') ." Admin Response. ".$a_response.PHP_EOL." Principal UUID".$p_response.PHP_EOL;
			echo $writelog;
			$writelog= date('H:i:s') ." Admin UUID. ".$a_UUID." Principal UUID".$p_UUID.PHP_EOL;
			echo $writelog;
			
			
			$log->lwrite($writelog);
			
		}catch(Exception $e){
			throw new \Exception('Some error occured in file upload.');
			$writelog= date('H:i:s') ." Some error occured in file upload. ".PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
		}
		
	}
	if($onbType=='SOONB'){
		try{
			$sql=file_get_contents(__DIR__.'/sql/school_admin.sql');
			$sql.=' where sm.school_id='.$school_id.' group by role_id,m.school_id ,m.UUID order by m.UUID desc limit 1;';
			//echo $sql;die;
			$results=mysqli_query($db_status,$sql);
			while ($result = $results->fetch_assoc()){//print_r($result['first_name']);die('11111');
			$first_name=$result['first_name'];
			$middle_name=$result['middle_name'];
			$last_name=$result['last_name'];
			$mobile_number=$result['mobile_number'];
			$email_id=$result['email_id'];
			$login_id=$result['login_id'];
			$date_of_birth=$result['date_of_birth'];
			$gender=$result['gender'];
			}
			$p_response=adultUser($log,$first_name,$middle_name,$last_name,$mobile_number,$email_id,$login_id,$date_of_birth,$gender);//print_r($p_response["user"]["uuid"]);die;
			$p_UUID=$p_response->user->uuid;
			//$p_UUID=$p_response['user']['uuid'];
			
			
			$sql=file_get_contents(__DIR__.'/sql/principal.sql');
			$sql.=' where sm.school_id='.$school_id.' group by role_id,m.school_id ,m.UUID order by m.UUID desc limit 1';
			$results=mysqli_query($db_status,$sql);
			
			while ($result = $results->fetch_assoc()){
			$first_name=$result['first_name'];
			$middle_name=$result['middle_name'];
			$last_name=$result['last_name'];
			$mobile_number=$result['mobile_number'];
			$email_id=$result['email_id'];
			$login_id=$result['login_id'];
			$date_of_birth=$result['date_of_birth'];
			$gender=$result['gender'];
			}
			if($results->num_rows==0){
				$a_UUID=$p_UUID;
			}else{
				$a_response=adultUser($log,$first_name,$middle_name,$last_name,$mobile_number,$email_id,$login_id,$date_of_birth,$gender);
				$a_UUID=$a_response->user->uuid;
			}
			
			//$a_UUID=$a_response['user']['uuid'];
			
			$writelog= date('H:i:s') ." Admin Response. ".$a_response.PHP_EOL." Principal UUID".$p_response.PHP_EOL;
			echo $writelog;
			$writelog= date('H:i:s') ." Admin UUID. ".$a_UUID." Principal UUID".$p_UUID.PHP_EOL;
			echo $writelog;
			if(empty($a_response) || empty($p_response)){
				echo 'Admin/Principal Empty';
				//exit;
			}
			
			$log->lwrite($writelog);
			
		}catch(Exception $e){
			throw new \Exception('Some error occured in file upload.');
			$writelog= date('H:i:s') ." Some error occured in file upload. ".PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
		}
	}
	
	echo PHP_EOL,"Sheet $sheetType Called ",PHP_EOL;
	$log->lwrite('School Details ( Sheet '.$sheetType.' ) Called');
	$sql=file_get_contents(__DIR__.'/sql/school_details.sql');
	if($school_id ==''){
		$writelog= date('H:i:s') ."  No School ID Was Eneterd";
		echo $writelog;
		$log->lwrite($writelog);
		die;
	}else{
		$sql.=' where sm.school_id='.$school_id.' group by sm.school_id;';
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
	
	onbMetrics($db_status,$school_id,$log,$sheetType,$onbType,$num_rows);

	$objSheet = $objPHPExcel->getActiveSheet();	
	
	if($createSheet==1){
	$objSheet = $objPHPExcel->createSheet();
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(TRUE);
        $objSheet->getColumnDimension('B')->setAutoSize(TRUE);
	$objSheet->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
        $objSheet->setCellValueByColumnAndRow($col, $row, 'School Name');$row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Registration Code'); $row++;
        //$objSheet->setCellValueByColumnAndRow($col, $row, 'School short name'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'School Description'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'City'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'State'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Complete Address'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Contacts'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Email'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Web url'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Board'); $row++;

        $objSheet->setCellValueByColumnAndRow($col, $row, 'Principal UUID'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Admin UUID'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'Ayid'); $row++;
        $objSheet->setCellValueByColumnAndRow($col, $row, 'School Code'); $row++;
		
	
        $writelog= PHP_EOL.date('H:i:s') ." Principal Admin UUID : ".$p_UUID.':::::'.$a_UUID.PHP_EOL." Respectively";
        echo $writelog;
	$log->lwrite($writelog);
        
	$row=1;
	//$row++;
    while ($sqlfetch = $result->fetch_assoc()){ //print_r();die;
        $col =1;
		
		$city=is_null($sqlfetch['city_id'])?'1':$sqlfetch['city_id'];
		$state=is_null($sqlfetch['state_id'])?'1':$sqlfetch['state_id'];
		$shuffle="61".str_shuffle("68302318");

		
		 //print_R($sqlfetch['school_name']);die; 
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['school_name']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $regNo); $row++;
		//$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['short_name']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, ''); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $city); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $state); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, toUTF($sqlfetch['address_line'])); $row++;
		if($type=='demo'){
		$objSheet->setCellValueByColumnAndRow($col, $row, $shuffle); $row++;
		}else{
		$objSheet->setCellValueByColumnAndRow($col, $row, $$sqlfetch['phone_number']); $row++;	
		}
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['email']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['web_url']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['display_name']); $row++;

		$objSheet->setCellValueByColumnAndRow($col, $row, $p_UUID); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $a_UUID); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 3); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $row++;
        
        $row++;
		
		
        }
	$row=1;	
	while ($sqlfetch = $result->fetch_assoc()){ print_r($sqlfetch);die;
        $col =2;
		
		$city=is_null($sqlfetch['city_id'])?'1':$sqlfetch['city_id'];
		$state=is_null($sqlfetch['state_id'])?'1':$sqlfetch['state_id'];
		$shuffle="61".str_shuffle("68302318");

		
		 //print_R($sqlfetch['school_name']);die; 
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['school_name']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $regNo); $row++;
		//$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['short_name']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, ''); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $city); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $state); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, toUTF($sqlfetch['address_line'])); $row++;
		if($type=='demo'){
		$objSheet->setCellValueByColumnAndRow($col, $row, $shuffle); $row++;
		}else{
		$objSheet->setCellValueByColumnAndRow($col, $row, $$sqlfetch['phone_number']); $row++;	
		}
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['email']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['web_url']); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['display_name']); $row++;

		$objSheet->setCellValueByColumnAndRow($col, $row, $p_UUID); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $a_UUID); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 3); $row++;
		$objSheet->setCellValueByColumnAndRow($col, $row, $school_code); $row++;
        
        $row++;
		
		
        }
        //echo $row."<br/>";
        
        
    
    $objSheet->setTitle('School Details');
	
	return $objSheet;
}
?>