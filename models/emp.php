<?php 
class Emp_model extends BaseModel{
	private $database;
	public function __construct(){
		parent::__construct();
	}

	public function get_emp_data($arr){
		$this->database=$this->load->library('DB');
		$sql="SELECT * FROM emp_master";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
	public function add_blog($_input){
		$title=$_REQUEST['title'];
		$dis=$_REQUEST['dis'];
		$blog=$_REQUEST['blog'];
		$date=date("d-m-Y");
		$this->database=$this->load->library('DB');
		$sql="INSERT INTO `blog`(`title`, `discription`,`blog`, `date`) VALUES ('$title','$dis','$blog','$date')";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->execute_query($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
	
	public function get_user_data($_input){
		$this->database=$this->load->library('DB');
		if((isset($_REQUEST['uname']) && $_REQUEST['uname']!='') && (isset($_REQUEST['psw']) && $_REQUEST['psw']!='')){
			$id = $_REQUEST['uname'];
			$pass = $_REQUEST['psw'];
			$sql="SELECT * from user WHERE username='$id' AND password ='$pass'";
		}
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
	public function view_blog($_input){
		$this->database=$this->load->library('DB');
		$sql="SELECT * from blog";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
	public function edit_blog($_input){
		$this->database=$this->load->library('DB');
		$id=$_REQUEST['id'];
		$sql="SELECT * from blog where id=$id";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}

	public function admin_data($_input){
		$this->database=$this->load->library('DB');
		if((isset($_REQUEST['username']) && $_REQUEST['username']!='') && (isset($_REQUEST['pass']) && $_REQUEST['pass']!='')){
			$id = $_REQUEST['username'];
			$pass = $_REQUEST['pass'];
			$sql="SELECT * from user WHERE username='$id' AND password ='$pass'";
		}elseif(isset($_REQUEST['userid']) && $_REQUEST['userid']!='') {
			$id=$_REQUEST['userid'];
			$sql="SELECT * from user WHERE id='$id'";
		}
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
		//$this->database->check_data($id,$pass);
	}

	public function update_blog($_input){
		$title=$_REQUEST['title'];
		$dis=$_REQUEST['dis'];
		$blog=$_REQUEST['blog'];
		$date=date("d-m-Y");
		$id=$_REQUEST['id'];
		$this->database=$this->load->library('DB');
		$sql="UPDATE `blog` SET `title`='$title',`discription`='$dis',`blog`='$blog',`date`='$date' WHERE id=$id";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->execute_query($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
	
	public function dlt_blog($_input){

		$id=$_REQUEST['id'];
		$this->database=$this->load->library('DB');
		$sql="DELETE FROM `blog` WHERE id=$id";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->execute_query($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}

	public function pagination($_input){
		$this->database=$this->load->library('DB');
		$limit = $_REQUEST['limit'];
		$sql="SELECT * from blog LIMIT ".$limit .",3";
		$stmt=DB_library::$conn->prepare($sql);
		try{
			$res=$this->database->get_data($stmt);
		}catch(PDOException $e){
			echo "Error:".$e->getMessage();
		}
		return $res;
	}
}