<?php	  
	if(isset($_GET['do'])){
		switch($_GET['do']){ 

			case 'getTables': 
				require_once('DatabaseDriver.php');		
				$dd = DatabaseDriver::getInstance(); 
				print_r(json_encode($dd -> getTables())); 
				break;  

			case 'getTableDesc': 
				require_once('DatabaseDriver.php');		
				$dd = DatabaseDriver::getInstance(); 
				print_r(json_encode($dd -> getTableDesc($_GET['table']))); 
				break;  
		}
	}
?>