<?php

require_once dirname(__FILE__) . '/../require_files.php';

$db_status=dbconf(5);

$sql="select * from migration_duplicate_mobile_vw";



$result=mysqli_query($db_status,$sql); //print_r($result);die;
			
			
			
			$num_rows = mysqli_num_rows($result);
			printf(PHP_EOL."Result set has %d rows.\n",$num_rows);
			
			if($num_rows == 0){
				
				exit;
			}else{
				while ($sqlfetch = $result->fetch_assoc()){ 
				
				
					$sqlUpdate='UPDATE eol_prod.user_master SET mobile_count=1 WHERE UUID='.$sqlfetch['UUID'];
					 
					 $result_update=mysqli_query($db_status,$sqlUpdate); //print_r($db_status);die;
					 
					 $num_rows_update = mysqli_num_rows($result_update);
					 
					 if($num_rows_update !==0){
						 echo PHP_EOL,'UUID ::: '.$sqlfetch['UUID'].'  has been updated ',PHP_EOL;
					 }
				
				}
			}
				

