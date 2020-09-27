<?php
ob_start();
session_start();
 // error_reporting(E_ALL);
require("classes/basecontroller.php");  
require("classes/basemodel.php");
require("classes/view.php");
require("classes/viewmodel.php");
require("classes/loader.php");
require("classes/load.php");
require("config/constants.php");
if(isset($_GET['q'])){ 
	$q=$_GET['q'];
	$q_arr=explode("/",$q);
	$controller=$q_arr[0];
	$configfile="config/".$controller."_constants.php";
	if(file_exists($configfile)){
		require_once($configfile);
	}
}
// end secondary config include

$loader = new Loader(); //create the loader object
$controller = $loader->createController(); //creates the requested controller object based on the 'controller' URL value
$controller->load=new Load();
$controller->executeAction(); //execute the requested controller's requested method based on the 'action' URL value. Controller methods output a View.

?>