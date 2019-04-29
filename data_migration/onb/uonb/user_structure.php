<?php
/*
**Author: Saurabh Chhabra
**Description : user structure
**
**
 * PHPExcel
 *
 *
*/
/* Infinite Timeout Script*/
ini_set('max_execution_time', 0);

ini_set('memory_limit',-1);
/** More like Session Creation / Output Buffering by Saurabh Chhabra **/

ob_implicit_flush(true);
ob_start();
//@ob_end_clean();



$col=0;
$row=1;
$FileName=rand(15, 15).date('ymdHis');
$ExcelFileName=__DIR__.'/../output/uonb/'.$FileName.'.xlsx';

/*** Include PHPExcel */
require_once dirname(__FILE__) . '/../require_files.php';


graphics();

$start_time=date('Y-m-d H:i:s');

//Log Class Creation & Save on Rquired positions

$log = new Logging();
$log->lfile(__DIR__.'/../tmp/masterlog-'.$FileName.'.txt');
$log->start("----------------------------------------------------------------------------------------------------------------------------------------------------------------\n");
$log->lwrite('Program Execution Starts');

/** Command Line + HTTP call switch**/

if (!isset($_SERVER["HTTP_HOST"])) {
    // script is not interpreted due to some call via http, so it must be called from the commandline
	$sapi_type = php_sapi_name();
	if (substr($sapi_type, 0, 3) == 'cgi') {
	
	echo PHP_EOL.'Params 1 : '.$_GET['db'];  // db switch
	echo PHP_EOL.'Params 2 : '.$_GET['school_id'].PHP_EOL; // school id
	echo PHP_EOL.'Params 3 : '.$_GET['type'].PHP_EOL; // school id

    $db_type=$_GET['db']; // use $_POST instead if you want to
	$school_id=$_GET['school_id'];
	$type=$_GET['type'];
	
	$log->lwrite('******* Called Form Command Line (PHP-CGI) Script**********');

		
	}
	if(PHP_SAPI == 'cli'){
	$cli=array();
		foreach(@$argv as $ar){
			@list($key, $val) = explode('=', @$ar);
			array_push($cli,array($key=>$val));
		}
	
	
	$sqlType=array('slave'=>0,'master'=>1,'dev'=>2,'int'=>3,'stg'=>4,'migration'=>5);
	//print_r($cli[1]['db']);die;
	

	//parse_str($argv[1], $cli);
	echo PHP_EOL.'Params 1 : '.$cli[1]['db'].PHP_EOL;  // db switch
	echo PHP_EOL.'Params 2 : '.$cli[2]['school_id'].PHP_EOL; // school id
	echo PHP_EOL.'Params 3 : '.$cli[3]['type'].PHP_EOL; // school id
	echo PHP_EOL.'Params 4 : '.$cli[4]['ayid'].PHP_EOL; // school id

    $db_type	=	$sqlType[$cli[1]['db']]; // use $_POST instead if you want to
	$school_id	=	$cli[2]['school_id'];
	$type		=	$cli[3]['type'];
	$ayid		=	$cli[4]['ayid'];
	
	
	if($debug=='true'||$debug==1){
		error_reporting(1);
	}else{
		error_reporting(0);
	}
	
	$log->lwrite('******* Called Form Command Line (CLI) Script**********');
	}
}else{
	
	if (PHP_SAPI == 'cgi') {
	
	echo PHP_EOL.'Params 1 : '.$_GET['db'];  // db switch
	echo PHP_EOL.'Params 2 : '.$_GET['school_id'].PHP_EOL; // school id
	echo PHP_EOL.'Params 3 : '.$_GET['type'].PHP_EOL; // school id

    $db_type=$_GET['db']; // use $_POST instead if you want to
	$school_id=$_GET['school_id'];
	$type=$_GET['type'];
	
	$log->lwrite('******* Called Form Command Line (PHP-CGI) Script**********');

		
	}
	else{
		$db_type=$_REQUEST['db'];
		$school_id=$_REQUEST['school_id'];
		$type=$_REQUEST['type'];
		$log->lwrite('******* Called Form HTTP Script Call********');
	}
}
$db_status=dbconf($db_type);
//echo "<pre>";
//print_r($db_status);die;


$migrationRules=migrationRules($db_status,$log,$school_id);


while ($sqlfetch = $migrationRules->fetch_assoc()){
	 
	 $regNo=$sqlfetch['reg_no'];
	 $promotion=$sqlfetch['promotion'];

 }

$sql="Insert into eol_prod.migration_performance_uonb (`school_id`,`start_time`,`end_time`)  values ('$school_id','$start_time','$start_time')";

$result=mysqli_query($db_status,$sql);

if($result==1){
	
	$writelog=PHP_EOL.'Performance Metrics Started ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	
	
}else{
	
	$writelog=PHP_EOL.'Performance Metrics Not Started (Mysql Insertion Error) ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	
	exit;
	
}





//die($REQUEST);

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
										  

										  
//Get School Code 

$arg=array('migration_school'=>$school_id,'ayid'=>$ayid);
$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
$find=$migrationConnection->findRecord($arg);
$school_code=$find['school_code'];										  
//print_r($school_code);die;
										  
// Call School_Details Sheet(1)	

							  
$sheet1=user_details($db_status,$objPHPExcel,$school_id,$school_code,$ayid,$log,$type,$promotion,$batch);
/*$sheet2=teacher_details($db_status,$objPHPExcel,$school_id,$log,$type,$batch);
$sheet3=class_teachers($db_status,$objPHPExcel,$school_id,$log,$type,$batch);
$sheet4=subject_teachers($db_status,$objPHPExcel,$school_id,$log,$type,$batch);
$sheet5=section_details($objPHPExcel,$school_code,$log,$type,$batch);
$sheet6=subject_details($objPHPExcel,$school_code,$log,$type,$batch);
$sheet7=school_details($db_status,$objPHPExcel,$school_id,$log,$type,$regNo,7,1,$onbType='UONB',$school_code);*/
//$sheet3=class_subjects_details($db_status,$objPHPExcel,$school_id,$log);


// Performance / Time Recording
$callStartTime = microtime(true);
// Save Excel File
$ExcelObject='Not Loaded   ';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
if($objWriter){
//$objWriter->setSheetIndex(1); 
//$objWriter->setDelimiter(';');
$objWriter->save($ExcelFileName);
$ExcelObject='Loaded   ';
}


$inputFileType = PHPExcel_IOFactory::identify($ExcelFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setReadDataOnly(true);   
$objPHPExcel = $objReader->load($ExcelFileName);
// Export to CSV file.
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
//$objWriter->setSheetIndex(1);   // Select which sheet.
//$objWriter->setDelimiter(';');  // Define delimiter
$objWriter->save(__DIR__."/../output/uonb/$school_code.csv");


// Record Log
$log->lwrite('Creation Of Excel File (time):'.$callStartTime.PHP_EOL.'Excel Object Loaded or Not ?? :'.$ExcelObject.'ExcelFileName: '.$ExcelFileName);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , $ExcelFileName, PHP_EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , PHP_EOL;
// Echo memory usage
$memoryUsage=date('H:i:s') . ' Current memory usage: ' . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
echo $memoryUsage;


echo date('H:i:s') , " Reload workbook from saved file" , PHP_EOL;
$callStartTime = microtime(true);
// Record Final Log
$T_mode=0;
$log->lwrite('Total Creation Time(sec):'.sprintf('%.4f',$callTime) .'Seconds'.PHP_EOL.'Memory usage While Processing Excel File :'.$memoryUsage.'Testing Mode: '.$T_mode);

exit;



echo PHP_EOL,'------------------------------------------------------------',PHP_EOL;

$server=rand(1,10);

if($mongo =='y' || $mongo =='Y'):

	$assetCall=_moveFile($ExcelFileName,ASSET_SONB_PATH,$log,$type='UONB',$emailid='saurabhchhabra018@gmail.com');
	//print_r($assetCall);

	$writelog= date('H:i:s') ." UONB Upload Status is ".$assetCall['status'].PHP_EOL.PHP_EOL.json_encode($assetCall,JSON_PRETTY_PRINT).PHP_EOL;
	echo $writelog;
	$log->lwrite($writelog);

	echo PHP_EOL,'------------------------------------------------------------',PHP_EOL;
	$insertUpload=insertUploadDetails($assetCall,$log,$type='UONB',$emailid='saurabhchhabra018@gmail.com',$school_code,3);
	//print_r($assetCall);

	$writelog= date('H:i:s') ." UONB Mongo Insertion : ".$insertUpload['details']['status'].PHP_EOL.PHP_EOL.json_encode($insertUpload,JSON_PRETTY_PRINT).PHP_EOL;
	echo $writelog;
	$log->lwrite($writelog);

	echo PHP_EOL,'------------------------------------------------------------',PHP_EOL;

	$UploadID=$insertUpload['details']['UploadID'];//echo $UploadID;

		if(!empty($UploadID)){
			$arg=array('UploadID'=>$UploadID);
			$cond=array("migration_school"=>$school_id,'status'=>'pending','server'=>'','verifiedBy'=>'unverified');
			$mongoConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);
				$writelog= date('H:i:s') ." UONB Mongo Connection Object : ".$insertUpload['details']['status'].PHP_EOL.PHP_EOL.json_encode($mongoConnection,JSON_PRETTY_PRINT).PHP_EOL;
				echo $writelog;
				$log->lwrite($writelog);
				$update=$mongoConnection->updateExistingUploadOrdersDetailByArg($arg,$cond);
				if($update['ok']==1){
					$writelog= date('H:i:s') ." UONB Mongo Update Migration School Object : ".$insertUpload['details']['status'].PHP_EOL.PHP_EOL.json_encode($update,JSON_PRETTY_PRINT).PHP_EOL;
					echo $writelog;
					$log->lwrite($writelog);

				}
			
			$find=$mongoConnection->findRecord($arg);print_r($find);	
			$migrationConnection= new DataMigrationMongoConnectionClass('migration_user_orders');//print_r($mongoConnection);	
			$insert=$migrationConnection->insertUploadOrdersDetailByArg($find);
			if($insert['ok']==1){
				$writelog= date('H:i:s') ." UONB Migration School Details For Ref updated : ".$find.PHP_EOL.PHP_EOL.json_encode($insert,JSON_PRETTY_PRINT).PHP_EOL;
				echo $writelog;
				$log->lwrite($writelog);

			}
				
		}
endif;

if($mongo =='n' || $mongo =='N'):
	echo PHP_EOL,'Mongo DB CRON WILL NOT EXECUTE',PHP_EOL;
endif;


$sendMail=new customMAIL();

$loop=new Loop(MAIL_USER);
$user = trim($loop->keyD);


$loop=new Loop(MAIL_PASS);
$password = trim($loop->keyD);

$sendMail->onbmail($user,$password,$mail,$ExcelFileName,'','UONB For School '.$school_id.'['. date('Y-m-d') .']');
$writelog= date('H:i:s') ." UONB MAIL FUNCTION RESPONSE ".PHP_EOL.PHP_EOL.json_encode($sendMail,JSON_PRETTY_PRINT).PHP_EOL;
echo $writelog;
$log->lwrite($writelog);


//print_r($sendMail);