<?php

if(@$argv[1]==''){	

	echo PHP_EOL,'Do Something for Script to Work !!! , Not AI Tool',PHP_EOL;
	
	exit;
	
}

require_once dirname(__FILE__) .'/../../encryption/auth.php';
require_once dirname(__FILE__) . '/../../conf/db_conf.php';
require_once dirname(__FILE__) . '/../../encryption/DecryptionClass.php';


error_reporting(1);


class MigratePassword{


	
	public function __construct($switchdb){
		$db_status=dbconf($switchdb);	
		$this->sqlConnection   = $db_status; 
	}
	
	public function MD5_p($login_id,$pass){
		
		$hash=md5($login_id);
		$hashUpper=md5(strtoupper($login_id));
		$hashLower=md5(strtoupper($login_id));
		
		$normalPass=md5('123456');
		
		if($pass == $hash || $pass == $hashUpper || $pass == $hashLower){
			
			return 1;
		}
		
		return 0;
		
	}

	public function checkPswd(){
		
		
		$sql="SELECT login_id,password,UUID FROM eol_prod.user_master where force_password ='-1' ;";

		$result   = mysqli_query($this->sqlConnection, $sql); 
		
		
		while($userM = $result->fetch_assoc()){

			$passResult=$this->MD5_p($userM['login_id'],$userM['password']);
			
			
			//echo '---> UUID:: ',$userM['UUID'],' <------> PASS MATCH :: ';print_r($passResult);die;	
			
			
			$sqlUpdate="UPDATE eol_prod.user_master SET force_password='".$passResult."' WHERE UUID=".$userM['UUID'];
					 
			$result_update=mysqli_query($this->sqlConnection,$sqlUpdate); //print_r($db_status);die;
					 
			$num_rows_update = mysqli_num_rows($result_update);
					 
			if($num_rows_update !==0){
				echo PHP_EOL,'UUID ::: '.$userM['UUID'].'  has been updated as Result',$passResult,PHP_EOL;
			}
		
		}
	}

}


$initClass=new MigratePassword($argv[1]);

$initClass->checkPswd();

