<?php

require_once dirname(__FILE__) . '/../require_files.php';


class BackTrack{
	
	
	public function __construct(){
		
		$arg=array('status'=>'error');
		$mongoConnection= new SONBMongoConnectionClass('upload_details');
		$find=$mongoConnection->findRecord($arg);
		
		$userOrderCollection= new SONBMongoConnectionClass('user_orders');
		
		$this->errorOrders=$find;
		
	}
	
	
	public function userOrders(){
		
		
		
		
	}
	
	
	
}



function update(){
	
	
	$mongoConnection= new DataMigrationMongoConnectionClass('migration_school_orders');
	
	$arg=array('status'=>'done');
	$cond=array('status'=>'pending');
	
	$find=$mongoConnection->findRecord($arg);
		
	
	foreach($find as $f){
	
	$update=$mongoConnection->updateSchoolOrdersDetailByArg($arg,$cond);
	}
	
	
}




update();








