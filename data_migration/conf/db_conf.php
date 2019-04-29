<?php
/***
***
*** @Author Saurabh Chhabra
*** Date: 21-01-2016
*** Description : DB Change Master to Slave 
***
***/
function dbconf($dbtoggle){
	if($dbtoggle==0){
		echo date('H:i:s') , " Slave DB Params",PHP_EOL;
		$servername = "";
		$username = "";
		ob_start();
		$loop=new Loop(SQL_SLAVE_PASS);
		$password = trim($loop->keyD);
		ob_get_clean();

		$dbname='SlaveDB';
		$db_char= "  _________.____       _________   _______________
 /   _____/|    |     /  _  \   \ /   /\_   _____/
 \_____  \ |    |    /  /_\  \   Y   /  |    __)_ 
 /        \|    |___/    |    \     /   |        \
/_______  /|_______ \____|__  /\___/   /_______  /
        \/         \/       \/                 \/ ";
	}
	if($dbtoggle==1){//die('SecurityReasons');
		echo date('H:i:s') , " Master Connection Params",PHP_EOL;
		$servername = "";
		$username = "";
		ob_start();
		$loop=new Loop(SQL_MASTER_PASS);
		$password = trim($loop->keyD);
		ob_end_clean();
		$dbname='MasterDB';
		$db_char='   _____      _____    _________________________________________ 
  /     \    /  _  \  /   _____/\__    ___/\_   _____/\______   \
 /  \ /  \  /  /_\  \ \_____  \   |    |    |    __)_  |       _/
/    Y    \/    |    \/        \  |    |    |        \ |    |   \
\____|__  /\____|__  /_______  /  |____|   /_______  / |____|_  /
        \/         \/        \/                    \/         \/ ';
	}
	if($dbtoggle==2){
		echo date('H:i:s') , " DEV Connection Params",PHP_EOL;
		$servername = "";
		$username = "";
		$loop=new Loop(SQL_MASTER_PASS);
		ob_start();
		$password = trim($loop->keyD);
		ob_end_clean();
		$dbname='DEV';
		$db_char=' /$$$$$$$  /$$$$$$$$/$$    /$$
| $$__  $$| $$_____/ $$   | $$
| $$  \ $$| $$     | $$   | $$
| $$  | $$| $$$$$  |  $$ / $$/
| $$  | $$| $$__/   \  $$ $$/ 
| $$  | $$| $$       \  $$$/  
| $$$$$$$/| $$$$$$$$  \  $/   
|_______/ |________/   \_/    
                              
                              
                              ';
	}
	if($dbtoggle==3){
		echo date('H:i:s') , " INT Connection Params",PHP_EOL;
		$servername = "";
		$username = "";
		$loop=new Loop(SQL_MASTER_PASS);
		ob_start();
		$password = trim($loop->keyD);
		ob_end_clean();
		$dbname='INT';
		$db_char=' /$$$$$$ /$$   /$$ /$$$$$$$$
|_  $$_/| $$$ | $$|__  $$__/
  | $$  | $$$$| $$   | $$   
  | $$  | $$ $$ $$   | $$   
  | $$  | $$  $$$$   | $$   
  | $$  | $$\  $$$   | $$   
 /$$$$$$| $$ \  $$   | $$   
|______/|__/  \__/   |__/   
                            
                            
                            ';
	}
	if($dbtoggle==4){
		echo date('H:i:s') , " STG Connection Params",PHP_EOL;
		$servername = "";
		$username = "";
		$loop=new Loop(SQL_MASTER_PASS);
		ob_start();
		$password = trim($loop->keyD);
		ob_end_clean();
		$dbname='STG';
		$db_char='  /$$$$$$  /$$$$$$$$/$$$$$$ 
 /$$__  $$|__  $$__/$$__  $$
| $$  \__/   | $$ | $$  \__/
|  $$$$$$    | $$ | $$ /$$$$
 \____  $$   | $$ | $$|_  $$
 /$$  \ $$   | $$ | $$  \ $$
|  $$$$$$/   | $$ |  $$$$$$/
 \______/    |__/  \______/ 
                            
                            
                            ';
	}
	
	if($dbtoggle==5){//die('SecurityReasons');
		echo date('H:i:s') , " Migration Connection Params",PHP_EOL;
		$servername = "";
		$username = "";
		ob_start();
		$loop=new Loop(SQL_MASTER_PASS);
		$password = trim($loop->keyD);
		ob_end_clean();
		$dbname='SOA MasterDB';
		$db_char=' 
	
.d8888b.   .d88888b.        d8888 
d88P  Y88b d88P" "Y88b      d88888 
Y88b.      888     888     d88P888 
 "Y888b.   888     888    d88P 888 
    "Y88b. 888     888   d88P  888 
      "888 888     888  d88P   888 
Y88b  d88P Y88b. .d88P d8888888888 
 "Y8888P"   "Y88888P" d88P     888 
                                   
                                   
                                   ';
	}
	//echo $servername;
	// Create connection
	$conn = new mysqli($servername, $username, $password);
	unset($password);
	

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		echo PHP_EOL.PHP_EOL;
		echo date('H:i:s') ,' ',$dbname," Connected",PHP_EOL;
		echo $db_char.PHP_EOL.PHP_EOL;
		
	}
	//echo "Connected successfully";
	return $conn;

}

?>