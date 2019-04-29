<?php

require_once dirname(__FILE__) . '/../require_files.php';

$db_status=dbconf(5);






	
$migrationConnection= new SONBMongoConnectionClass('upload_details');//print_r($mongoConnection);	
//$migrationConnection= new DataMigrationMongoConnectionClass('migration_school_orders');//print_r($mongoConnection);	
//$migrationConnection= new DataMigrationMongoConnectionClass('migration_school_orders');//print_r($mongoConnection);	
$findALL=$migrationConnection->findALL(array("results" => "Admin UUID can not be blank."));

$school_id=NULL;
foreach($findALL as $schools){
	
	$school_id=" insert into eol_prod.migration_rules_adult (school_id,reg_no,promotion,migrated) values ('".$schools['migration_school']."','REG-".$schools['migration_school']."','N','N');";
	echo PHP_EOL;
	print_r($school_id);
	
}
	
	
	

	