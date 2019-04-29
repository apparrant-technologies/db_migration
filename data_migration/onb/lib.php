<?php
/***
***
*** @Author Saurabh Chhabra
*** Date: 21-01-2016
*** Description : Errors ON / Debuging and Library Include
***
***/
echo PHP_EOL,PHP_EOL;
echo "   ____   __    ____   ___    __    ____   ___    ___    _  __        __  ___   ____  _____   ___    ___  ______   ____  ____    _  __
  / __/  / /   /  _/  / _ \  / /   / __/  / _ |  / _ \  / |/ /       /  |/  /  /  _/ / ___/  / _ \  / _ |/_  __/  /  _/ / __ \  / |/ /
 / _/   / /__ _/ /   / ___/ / /__ / _/   / __ | / , _/ /    /       / /|_/ /  _/ /  / (_ /  / , _/ / __ | / /    _/ /  / /_/ / /    / 
/_/    /____//___/  /_/    /____//___/  /_/ |_|/_/|_| /_/|_/       /_/  /_/  /___/  \___/  /_/|_| /_/ |_|/_/    /___/  \____/ /_/|_/  
                                                                                                                                      ";

echo PHP_EOL,PHP_EOL;
error_reporting(E_ALL);
ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE); 
date_default_timezone_set('Asia/Kolkata');

define(PHP_EOL,(PHP_SAPI == 'cli') ? PHP_EOL : PHP_EOL);


echo "***************DATA***********MIGRATION*************".PHP_EOL."***********************BY********************\n".PHP_EOL;
//"*************100RABH********CHHABRA****************\n" , PHP_EOL;


/** Include PHPExcel */
if(require_once dirname(__FILE__) . '/../Classes/PHPExcel.php'){
	echo "\n******************************************************* " , PHP_EOL;
	echo date('H:i:s') , " Library Loaded " , PHP_EOL;
	echo "******************************************************* " , PHP_EOL;
}
else{
	echo date('H:i:s') , " Library Loading Fails " , PHP_EOL;
	echo date('H:i:s') , " Exiting " , PHP_EOL;
	exit;
}



?>