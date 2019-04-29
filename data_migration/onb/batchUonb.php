<?php

require_once dirname(__FILE__) . '/require_files.php';

define('DS', DIRECTORY_SEPARATOR); 


//print_r($argv[1]);die;

if(PHP_SAPI == 'cli'){
		
	$cli=array();
	foreach(@$argv as $ar){
		@list($key, $val) = explode('=', @$ar);
		array_push($cli,array($key=>$val));
	}
	
	echo PHP_EOL.'Params 1 : '.$cli[1]['start'].PHP_EOL;  // db switch
	echo PHP_EOL.'Params 2 : '.$cli[2]['end'].PHP_EOL; // school id


    $start	=	$cli[1]['start']; // use $_POST instead if you want to
	$end	=	$cli[2]['end'];
	
	$find=array('status'=>'pending');	
	$migrationConnection= new DataMigrationMongoConnectionClass('migration_school_orders');//print_r($mongoConnection);	
	$findALL=$migrationConnection->findALL($find);
	
}


while($start){
@ob_end_flush();	

	$sonb='php '.__DIR__.DS.'uonb'.DS.'user_structure.php db=migration school_id='.$start.' type=live mongo=y debug=1 mail=saurabhchhabra018@gmail.com';
	
	//echo $sonb;die;
	$output = shell_exec($sonb);
	echo "$output";
	//echo $start;
	
		$arg=array('migration_school'=>$start,'status'=>'pending');
		$cond=array('status'=>'done');
		$checkUpdate=$migrationConnection->updateSchoolOrdersDetailByArg($arg,$cond);
		
		if($checkUpdate['ok']==1){
			
			echo PHP_EOL,'Status has been updated',PHP_EOL	;
		}
	
	if($start==$end){
			break;
	}
	
	
	++$start;
	
}







