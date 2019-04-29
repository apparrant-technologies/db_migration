<?php





function migrationRules($db_status,$log,$school_id){
	
	// check if school exists in migration table
	
	$sql='select * from eol_prod.migration_rules where active=1 and school_id='.$school_id;
	
	//echo $sql;die;
	
	$result=mysqli_query($db_status,$sql); //print_r($db_status);die;
	
	$writelog=PHP_EOL.'Sql Query Start Time Checking Rules ['. date('H:i:s Y-m-d') .']';
	echo $writelog;
	$log->lwrite($writelog);
	
	$num_rows = mysqli_num_rows($result);
	printf(PHP_EOL."Result set has %d rows.\n",$num_rows);
	
	if($num_rows == 0){
		$writelog= PHP_EOL.date('H:i:s') ."  No School ID Was Found for Migrating".PHP_EOL." So Excel File won't be Generated";
		echo $writelog;
		$log->lwrite($writelog);
		exit;
	}else{
		$writelog= PHP_EOL.date('H:i:s') ."  School ID Found in Database".PHP_EOL."So Migration will proceed ".PHP_EOL;
		echo $writelog;
		$log->lwrite($writelog);
		
		return $result;
	}
	
	
	
	
	
}