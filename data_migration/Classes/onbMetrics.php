<?php


function onbMetrics($db_status,$school_id,$log,$sheetType,$onbType,$num_rows){
	
	$end_time=date('Y-m-d H:i:s');
	
	$onbType=strtolower($onbType);

	if($num_rows == 0){
			$updateSql="Update eol_prod.migration_performance_$onbType set sheet$sheetType='N' , end_time='$end_time' where school_id='$school_id' order by start_time desc limit 1" ;
			$updateresult=mysqli_query($db_status,$updateSql);
			
			
			$writelog= PHP_EOL.date('H:i:s') ."  No Details Was Found in Database for sheet$sheetType ".PHP_EOL." So Excel File won't be Generated";
			echo $writelog;
			$log->lwrite($writelog);
			//exit;
		}else{
			$updateSql="Update eol_prod.migration_performance_$onbType set sheet$sheetType='Y' , end_time='$end_time',sheet".$sheetType."_row='$num_rows' where school_id='$school_id' order by start_time desc limit 1";
			$updateresult=mysqli_query($db_status,$updateSql);
			
			$writelog= PHP_EOL.date('H:i:s') ."  Details Found in Database for sheet$sheetType ".PHP_EOL."So Excel File be Generated ".PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
	}




}