<?php


//require __DIR__.'/../conf/dbmongo.php';
//require __DIR__.'/../conf/dbmongo_int.php';


class SONBMongoConnectionClass
{
	private $_host;
	private $_port;
	private $_db_name;
	public $_connection;
	private $_username;
	
	
	
	
	public function __construct($collection_name){
			try {
				$connection = new MongoClient("mongodb://".MONGO_DB_IP.":".MONGO_DB_PORT);
				$database = $connection->selectDB(MONGO_DB_NAME);
				if(isset($database)){
					$this->_connection=$database;
					$this->_host=MONGO_DB_IP;
					$this->_port=MONGO_DB_PORT;
					$this->_db_name=MONGO_DB_NAME;
                    $this->_connection = $this->_connection->$collection_name;
					//echo "Conencted",PHP_EOL;
				}
				//$collection = $database->selectCollection('upload_details');
				
			} catch(MongoConnectionException $e) {
				die("Failed to connect to database ".$e->getMessage());
				}
				
		return $this->_connection;
	}
	
	public function findRecord($arg = array()){
            //return $this->_connection->insert($arg);
		return $this->_connection->findOne($arg);
	}
	
	public function findALL($arg = array()){
            //return $this->_connection->insert($arg);
		return $this->_connection->find($arg);
	}
	
	public function command($arg = array()){
            //return $this->_connection->insert($arg);
		return $this->selectCollection('$cmd')->findOne($data);
	}
        public function distinct($key,$query=array()){
            //return $this->_connection->insert($arg);
		return $this->distinct($key,$query=array());
	}
	
	public function updateExistingUploadOrdersDetailByArg($arg = array(), $cond=array(), $multiple = false){
            //return $this->_connection->insert($arg);
		return $this->_connection->update($arg, array('$set' => $cond), array('multiple' => $multiple));
	}
  
	
}




?>