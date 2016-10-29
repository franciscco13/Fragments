<?php	
	class DatabaseDriver 
	{
		private static $instance = null; 
		private $conn = null; 
		private $conn_vars = [ 
			"host"=> "localhost",
			"user"=> "root",
			"pass"=> "",
			"db"=>"dietas"
		]; 

		/////////////////////////////////////////////////////////////////
		// Singleton functions
		private function __construct() {}
		public static function getInstance( ) {
    		if (is_null(self::$instance))
      			self::$instance = new DatabaseDriver( );
    		return self::$instance;
  		}

  		/////////////////////////////////////////////////////////////////
  		// Connection methods
		private function startConnection(){  
			$this->conn  = mysqli_connect(
				$this->conn_vars['host'], 
				$this->conn_vars['user'], 
				$this->conn_vars['pass'],
				$this->conn_vars['db'])
			or die("Connection failed: " . $this->conn->connect_error);  
		}

		/////////////////////////////////////////////////////////////////
		private function closeConnection(){
			$this->conn->close(); 
		}
 
		///////////////////////////////////////////////////////////////
		public function getTables(){
			$this->startConnection();
			$array = []; 
			$query = "show tables";
			$results = $this->conn->query($query);	
			while($row = $results->fetch_assoc())
				$array [] = $row["Tables_in_".$this->conn_vars['db']];			
			return $array;
		}

		///////////////////////////////////////////////////////////////
		public function getTableDesc($table){
			$this->startConnection();
			$array = [];			 
			$query = "describe ".$table;
			$results = $this->conn->query($query);	
			while($row = $results->fetch_assoc()){
				$row['Table'] = $table; 
				$array [] = $row;		
			}			
			return $array;
		}
 
		/////////////////////////////////////////////////////////////////
		// Parse to UTF valid strings
		private function codifyUTF(&$array){
			foreach($array as &$value){
				$value = utf8_encode($value);
			}
		}
	}
?>
