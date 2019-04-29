<?php

if(@$argv[1]==''){	

	echo PHP_EOL,'Do Something for Script to Work !!! , Not AI Tool',PHP_EOL;
	
	exit;
	
}

require_once dirname(__FILE__) . '/../require_files.php';

error_reporting(1);


class UserProfile
{

	public $switchdb=5;
	
	public $ExcelFileName=__DIR__.'/output/user_profile.xlsx';

	



	public function mobileVal($role_id){
		
		$db_status=dbconf($this->switchdb);

		$sql="SELECT 
			distinct m.UUID,
			TRIM(CONCAT_WS(' ',
						m.first_name,
						m.middle_name,
						m.last_name)) AS tea_name,
			up.mobile_number,
			up.email_id,m.login_id,
			sm.school_id
		FROM
			eol_prod.user_master m
				LEFT JOIN
			eol_prod.user_profile up ON up.UUID = m.UUID AND m.role_id not in (2)
				LEFT JOIN
			eol_prod.school_master sm on m.school_id=sm.school_id
			where sm.school_id not in (1,2,12,39,44,51,59,60,61,66,70,71,171,268,287,754,1116,1269,1441)
			   and (up.mobile_number ='' OR up.mobile_number not regexp '^(9|8|7)' OR  up.mobile_number not regexp '[0-9]{10}' ) ; 

		";  
			
			//echo $sql;die;
			
			$result=mysqli_query($db_status,$sql); //print_r($result);die;
			
			
			
			$num_rows = mysqli_num_rows($result);
			printf(PHP_EOL."Result set has %d rows.\n",$num_rows);
			
			if($num_rows == 0){
				
				exit;
			}else{
				while ($sqlfetch = $result->fetch_assoc()){ 
				
					print_r($sqlfetch);
			 
					 //$regNo=$sqlfetch['reg_no'];
					 //$promotion=$sqlfetch['promotion'];
					 
					 $sqlUpdate='UPDATE eol_prod.user_profile SET can_migrate=0 WHERE UUID='.$sqlfetch['UUID'];
					 
					 $result_update=mysqli_query($db_status,$sqlUpdate); //print_r($db_status);die;
					 
					 $num_rows_update = mysqli_num_rows($result_update);
					 
					 if($num_rows_update !==0){
						 echo PHP_EOL,'UUID ::: '.$sqlfetch['UUID'].'  has been updated ',PHP_EOL;
					 }
					 
					 //die;
				}	
			}
			
	}
		
		
	public function mobileValidateMail(){
		
		$db_status=dbconf($this->switchdb);
		
		$sql="SELECT 
				um.UUID,login_id,TRIM(CONCAT_WS(' ',
                um.first_name,
                um.middle_name,
                um.last_name)) AS user_name,um.school_id,um.role_id,um.active,mobile_number,email_id
				FROM
					eol_prod.user_master um
						JOIN
					eol_prod.user_profile up ON up.UUID = um.UUID and up.can_migrate=0
						
					where um.school_id not in (1,2,12,39,44,51,59,60,61,66,70,71,171,268,287,754,1116,1269,1441)  ";
			
			$result=mysqli_query($db_status,$sql);print_r($result);//die;
			
			$this->ExcelprepareMobile($result);
			
			
			
			
			// 
			//
			
		
		
	}
	
	public function duplicateMobile(){
		
		$db_status=dbconf($this->switchdb);
		
		$sql="SELECT 
    sm.school_name,m.UUID,rm.role_name,
    TRIM(CONCAT_WS(' ',
                m.first_name,
                m.middle_name,
                m.last_name)) AS tea_name,
    m.role_id,
    up.mobile_number,
    up.email_id,
    m.login_id
FROM
    eol_prod.user_master m
        LEFT JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID and m.active=1
        AND m.role_id <> 2
        JOIN
    eol_prod.role_master rm ON rm.role_id = m.role_id
        JOIN
    eol_prod.school_master sm ON sm.school_id = m.school_id and sm.active=1
WHERE
    m.school_id NOT IN (1 , 2,
        12,
        39,
        44,
        51,
        59,
        60,
        61,
        66,
        70,
        71,
        171,
        268,
        287,
        754,
        1116,
        1269,
        1441)
        AND up.mobile_number in (SELECT * FROM eol_prod.migration_duplicate_mobile_vw)  ";
		
		
		$result=mysqli_query($db_status,$sql);
		
		$num_rows = mysqli_num_rows($result);
			printf(PHP_EOL."Result set has %d rows.\n",$num_rows);
			
			if($num_rows == 0){
				
				exit;
			}else{
				while ($sqlfetch = $result->fetch_assoc()){ 
				
					print_r($sqlfetch);
			 
					 //$regNo=$sqlfetch['reg_no'];
					 //$promotion=$sqlfetch['promotion'];
					 
					 $sqlUpdate='UPDATE eol_prod.user_profile SET duplicate_mobile=1 WHERE UUID='.$sqlfetch['UUID'];
					 
					 $result_update=mysqli_query($db_status,$sqlUpdate); //print_r($db_status);die;
					 
					 $num_rows_update = mysqli_num_rows($result_update);
					 
					 if($num_rows_update !==0){
						 echo PHP_EOL,'UUID ::: '.$sqlfetch['UUID'].'  has been updated ',PHP_EOL;
					 }
					 
					 //die;
				}	
			}
			
		//$this->ExcelprepareMobile($result);
		
		
		
		
		
	}
	
	public function ExcelprepareMobile($result){
		
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
		
		$objSheet->setCellValueByColumnAndRow($col, $row, 'UUID');$col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'login_id'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'user_name'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'school_id'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'role_id'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'active'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'mobile_number'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'email'); $col++;
		$objSheet->setCellValueByColumnAndRow($col, $row, 'section_name'); $col++;

		
		
		//$row=1;
		$row++;
		while ($sqlfetch = $result->fetch_assoc()){			//print_r($sqlfetch);die;
					
				$col =0;

				
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['UUID']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['login_id']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['user_name']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['school_id']); $col++;
				
				
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['role_id']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['active']); $col++;
				
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['mobile_number']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['email']); $col++;
				$objSheet->setCellValueByColumnAndRow($col, $row, $sqlfetch['section_name']); $col++;
				
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

		$sendMail->onbmail($user,$password,'ajay.jain@fliplearn.com',$this->ExcelFileName,'','Mobile Validation '.'['. date('Y-m-d') .']');
		
		
		
	
	}
	public function nameMatching(){
		
		$db_status=dbconf($this->switchdb);//print_R($db_status);
		
		$sql="SELECT 
    up.mobile_number
FROM
    eol_prod.user_master m
        JOIN
    eol_prod.user_profile up ON up.UUID = m.UUID and m.active=1
        AND m.role_id <> 2
        JOIN
    eol_prod.role_master rm ON rm.role_id = m.role_id
        JOIN
    eol_prod.school_master sm ON sm.school_id = m.school_id and sm.active=1
WHERE
    m.school_id NOT IN (1 , 2,
        12,
        39,
        44,
        51,
        59,
        60,
        61,
        66,
        70,
        71,
        171,
        268,
        287,
        754,
        1116,
        1269,
        1441)
        AND (up.mobile_number != ''
        AND up.mobile_number REGEXP '^(9|8|7)'
        AND up.mobile_number REGEXP '[0-9]{10}')
GROUP BY up.mobile_number 
HAVING COUNT(up.mobile_number) > 1 and COUNT(up.mobile_number) <=2 limit 160000,180000 ;";
		
		//echo $sql;
			
		$result=mysqli_query($db_status,$sql);//print_R($result);
		
		foreach ($result as $rows){
			//print_r($rows);
			
			$sql="select TRIM(CONCAT_WS(' ',
                um.first_name,
                um.middle_name,
                um.last_name)) AS user_name,um.first_name AS name,um.last_name AS l_name,um.UUID,um.login_id,migration_login_id,mobile_number,duplicate_mobile from eol_prod.user_master as um
			join eol_prod.user_profile up on up.UUID=um.UUID where duplicate_mobile=1  and migration_id='-1' and mobile_number =".$rows['mobile_number']."  ";
		
			//echo $sql;
			
			$checkDuplicate=mysqli_query($db_status,$sql);//print_R($checkDuplicate);die;
			//print_R($result);
			$f_rows=array();
			foreach($checkDuplicate as $f_row){
				$f_rows[]=$f_row;
				
			}
			//print_r($f_rows);
			$baseMatch=$f_rows[0]['user_name'];
			$_baseMatch=$f_rows[0]['l_name'];
			$user_name=$f_rows[0]['user_name'];
			$login_id=$f_rows[0]['login_id'];
			for($i=0;$i<=$checkDuplicate->num_rows;$i++){
				similar_text($baseMatch, $f_rows[$i]['name'], $percent);
				similar_text($f_rows[$i]['name'], $baseMatch,$percent2);
				similar_text($_baseMatch, $f_rows[$i]['l_name'], $_percent);
				//echo $percent;
				//echo $_percent;
				if($percent >= 50 || $_percent >=90 || $percent2 >=50){
					$updateLogin="update eol_prod.user_master set migration_login_id='".$login_id."' , migration_id='1' , migration_user_name='".$user_name."' where UUID=".$f_rows[$i]['UUID'];
					//echo $updateLogin;die;
					if(mysqli_query($db_status,$updateLogin)){
						echo PHP_EOL,$f_rows[$i]['login_id'] .' >>>  changed to >>>'.$f_rows[0]['login_id'];
					}
					//print_r($f_rows);
				}	
			}
			
			
			//$this->_levenshtein($);
			
		}
		
		


	}
	
	public function _levenshtein ($input,$words){
		// input misspelled word
		//$input = '9968302318';

		// array of words to check against
		//$words  = array('apple','pineapple','banana','orange',
						//'radish','carrot','pea','bean','potato');

		// no shortest distance found, yet
		$shortest = -1;

		// loop through words to find the closest
		foreach ($words as $word) {

			// calculate the distance between the input word,
			// and the current word
			$lev = levenshtein($input, $word);

			// check for an exact match
			if ($lev == 0) {

				// closest word is this one (exact match)
				$closest = $word;
				$shortest = 0;

				// break out of the loop; we've found an exact match
				break;
			}

			// if this distance is less than the next found shortest
			// distance, OR if a next shortest word has not yet been found
			if ($lev <= $shortest || $shortest < 0) {
				// set the closest match, and shortest distance
				$closest  = $word;
				$shortest = $lev;
			}
		}

		echo "Input word: $input\n";
		if ($shortest == 0) {
			echo "Exact match found: $closest\n";
		} else {
			echo "Did you mean: $closest?\n";
		}
	}

	
}


//$role_id=$argv[1];

$callFunction=$argv[1];

$userProfile=new UserProfile();

if($argv[1]=='val'){	
	$userProfile->mobileVal();
	$userProfile->mobileValidateMail();
}

if($argv[1]=='loginid'){	
	$userProfile->nameMatching();
}

if($argv[1]=='duplicate'){
	
	$userProfile->duplicateMobile();
	
}else{
	
	echo PHP_EOL,'DO Something !!! , Not AI Tool',PHP_EOL;
}








