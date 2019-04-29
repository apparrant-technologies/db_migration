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


function getClassCodes($log,$school_id,$level,$section,$ayid){

	$arg=array('migration_school'=>$school_id,'ayid'=>$ayid);
	$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
	$find=$migrationConnection->findALL($arg);
	$uploadID=array();
	$schoolCode=NUll;
	
	foreach($find as $id){
		$schoolCode=$id['school_code'];
		$uploadID[]=$id['UploadID'];
	}
	

	$findCode=array('SchoolCode'=>(int)$schoolCode,'ClassLevel'=>(int)$level,'Section'=>$section,'Subject'=>$subject,'UploadID'=>array('$in'=>$uploadID));
	
	//echo PHP_EOL;print_r(json_encode($findCode));
	
	
	$log->lwrite($findCode);


	$mongoConnection= new SONBMongoConnectionClass('school_boarding_detail');

	$find=$mongoConnection->findRecord($findCode);//print_r($find);die;


	return $_return=array('SectionCode'=>$find['SectionCode'],'SectionGroupCode'=>$find['SectionGroupCode']);

}


function getSubjectCodes($school_id,$level,$section,$subject){

	$arg=array('migration_school'=>$school_id,'ayid'=>'3');
	$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
	$find=$migrationConnection->findALL($arg);
	$uploadID=array();
	$schoolCode=NUll;
	
	foreach($find as $id){
		$schoolCode=$id['school_code'];
		$uploadID[]=$id['UploadID'];
	}
	

	$findCode=array('SchoolCode'=>(int)$schoolCode,'ClassLevel'=>(int)$level,'Section'=>$section,'Subject'=>$subject,'UploadID'=>array('$in'=>$uploadID));print_r(json_encode($findCode));


	$mongoConnection= new SONBMongoConnectionClass('school_boarding_detail');

	$find=$mongoConnection->findRecord($findCode);


	return $_return=array('SubjectCode'=>$find['SubjectCode'],'SubjectGroupCode'=>$find['SubjectGroupCode']);

}







