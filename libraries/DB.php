<?php
/**
 * Custom class to connect to mysql database
 */
class DB_library {
	public static $conn;
	private $resultSet;
	public $affected_rows;
	private $queryData;
	
	public function __construct() {
		$this->_connect();
		
    }
	private function _connect(){
			try{
				self::$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD); // news read parameters
				self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e){
				echo "ERROR :".$e->getMessage();
			}
		
		
	}
	public function disconnect(){
		self::$conn=null;
	}
	public function get_data($stmt){
		try{
			$this->resultSet=$stmt->execute();
		}
		catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		
		$count=$stmt->rowCount();
		
		if($count>0){
			$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($row as $rows){
				$this->queryData['data'][]=$rows;
			}
			$this->queryData['count'] =$count;
			$stmt->closeCursor(); 
			$stmt = null;// this is to close the connection
			return $this->queryData;
		}
		
	}
	
	public function execute_query($stmt){
		try{
			$resultSet=$stmt->execute();
			$return_array['last_insert_id']=self::$conn->lastInsertId();
			$return_array['row_count']=$stmt->rowCount();
		}
		catch(PDOException $e){
			echo "Error:".$e->getMessage();
			echo "<br>\n".$e->getTrace();
			echo "<br>\n".$e->getTraceAsString();
			exit();
			
		}
		return $return_array;
	}
	
}