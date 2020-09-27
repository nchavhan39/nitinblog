<?php
class HomeController extends BaseController{

	public function __construct( $action, $urlValues ) {
		error_reporting(E_ALL);
		ini_set('display_errors',1);
		parent::__construct( $action, $urlValues );
		$this->load = new Load();
		$this->twigload=new Load();
		$this->common_library = $this->load->library( 'Common' );
	}
	
	public function dbconnect(){
		$this->database=$this->load->library('DB');
		$this->emp_model=$this->load->model('Emp');
		$emp_data=$this->emp_model->get_emp_data(array("")); // todo to add input parameters if required.
		$this->view->set_data('emp_data',$emp_data);
		$this->view->render('db/index');
	}

	public function index(){
		// echo "here home÷";
		$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );	# techmvc\config\responsive_constants.php
		$data=array();
		if(isset($_SESSION["nitinuserid"])){
			$this->login_success();
		}else{
			$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			echo $this->twig_library->twig->render( 'login.html', $data);
		}
	}
	public function login_check(){
		$this->database=$this->load->library('DB');
		$this->emp_model=$this->load->model('Emp');
		$user_data=$this->emp_model->admin_data($_REQUEST);
		$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
		if((int)$user_data==0){
			echo 'fail';
		}
		else{
			setcookie("login", "1");
			if(!isset($_SESSION)) 
				session_start();
			$_SESSION["nitinuserid"]=$user_data["data"][0]["id"];
			$_SESSION['guest']=$user_data["data"][0]["guest"];
			echo 'success';
		}
	}
	public function login(){
		session_destroy();
		$data=array();
		$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
		echo $this->twig_library->twig->render( 'login.html', $data);
	}
	public function login_success(){
		$data=array();
		if(isset($_SESSION["nitinuserid"])){
			$this->database=$this->load->library('DB');
			$this->emp_model=$this->load->model('Emp');
			//print_r($_REQUEST); exit;
			$data=$this->emp_model->view_blog($_REQUEST);
			if($data==null){
				$data=array();
			}
			
			$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			if($_SESSION['guest']==1){
				echo $this->twig_library->twig->render( 'login_success_guest.html', $data);
			}else{
				echo $this->twig_library->twig->render( 'login_success.html', $data);
			}
		}else{
			$this->logout();
		}
	}
	public function logout(){
			session_unset();
			//session_destroy();
			if(session_destroy()){
				$data=array();
				// $this->twig_library = $this->load->library( 'Twig', 'twig/' );
				// echo $this->twig_library->twig->render( 'login.html', $data);
				header('location: /nitin/');
			}
	}
	public function add_blog_form(){
		$data=array();
		if(isset($_SESSION["nitinuserid"])){
			$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			echo $this->twig_library->twig->render( 'add_blog.html', $data);
		}else{
			$this->logout();
		}
	}

	public function add_blog(){
		if(isset($_SESSION["nitinuserid"])){

			$this->database=$this->load->library('DB');
			$this->emp_model=$this->load->model('Emp');
			//print_r($_REQUEST); exit;
			$data=$this->emp_model->add_blog($_REQUEST);
			
			//$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			header("Location: /nitin/home/add_blog_form");
		}else{
			$this->logout();
		}	
	}

	public function edit_blog(){
		if(isset($_SESSION["nitinuserid"])){

			if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
				$this->database=$this->load->library('DB');
				$this->emp_model=$this->load->model('Emp');
				//print_r($_REQUEST); exit;
				$data=$this->emp_model->edit_blog($_REQUEST);
				
				$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
				echo $this->twig_library->twig->render( 'update_blog.html', $data);
			}else{
				header("Location: /nitin/home/login_success");
			}

		}else{
			$this->logout();
		}
	}

	public function update_blog(){
		if(isset($_SESSION["nitinuserid"])){

			$this->database=$this->load->library('DB');
			$this->emp_model=$this->load->model('Emp');
			//print_r($_REQUEST); exit;
			$data=$this->emp_model->update_blog($_REQUEST);
			
			//$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			header("Location: /nitin/home/login_success");
		}else{
			$this->logout();
		}	
	}
	public function dlt_blog(){
		if(isset($_SESSION["nitinuserid"])){

			$this->database=$this->load->library('DB');
			$this->emp_model=$this->load->model('Emp');
			//print_r($_REQUEST); exit;
			$data=$this->emp_model->dlt_blog($_REQUEST);
			
			echo json_decode($data);
		}else{
			$this->logout();
		}	
	}

	public function pagination(){
		$data=array();
		if(isset($_SESSION["nitinuserid"])){
			$this->database=$this->load->library('DB');
			$this->emp_model=$this->load->model('Emp');
			//print_r($_REQUEST); exit;
			$data=$this->emp_model->pagination($_REQUEST);
			$this->twig_library = $this->load->library( 'Twig', 'twig/home/' );
			if(isset($_REQUEST['guest']) && $_REQUEST['guest']==1){
				echo $this->twig_library->twig->render( 'pagination_guest.html', $data);
			}else{
				echo $this->twig_library->twig->render( 'pagination.html', $data);
			}
			
		}else{
			$this->logout();
		}
	}
}