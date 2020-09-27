<?php
class Loader {
    
    private $controllerName;
    private $controllerClass;
    private $action;
    private $urlValues;
    
    //store the URL request values on object creation
    public function __construct() {
		$urlvalues=$_GET;
        
		if(isset($urlvalues['q']) && $urlvalues['q']!=''){
			$url_array=explode("/",$urlvalues['q']);
            if(isset($url_array[0]))
			 $this->urlValues['controller']=$url_array[0];
            if(isset($url_array[1]))
			 $this->urlValues['action']=$url_array[1];
            if(sizeof($url_array)>2)
			     $this->urlValues['remaining']=array_slice($url_array,2);
            else 
                $this->urlValues['remaining']=array("");
		} else {
             $this->urlValues['remaining']=array("");
        }
        //$this->urlValues = $_GET;
       
        if (!isset($this->urlValues['controller']) || $this->urlValues['controller']=='') {
            $this->controllerName = "home";
            $this->urlValues['controller']="home";
            $this->controllerClass = "HomeController";
            $this->urlValues['action']="index";
             $this->action = "index";
        } else {
            $this->controllerName = strtolower($this->urlValues['controller']);
            $this->controllerClass = ucfirst(strtolower($this->urlValues['controller'])) . "Controller";
        }
        
        if (!isset($this->urlValues['action']) || $this->urlValues['action'] == "") {
            $this->action = "index";
        } else {
            $this->action = $this->urlValues['action'];
        }
         
    }
                  
    //factory method which establishes the requested controller as an object
    public function createController() {
        //check our requested controller's class file exists and require it if so
        if (file_exists("controllers/" . $this->controllerName . ".php")) {
            require("controllers/" . $this->controllerName . ".php");
        } else {
            require("controllers/error.php");
            return new ErrorController("badurl",$this->urlValues);
        }
                
        //does the class exist?
        if (class_exists($this->controllerClass)) {
            $parents = class_parents($this->controllerClass);
            
            //does the class inherit from the BaseController class?
            if (in_array("BaseController",$parents)) {   
                //does the requested class contain the requested action as a method?
                if (method_exists($this->controllerClass,$this->action))
                {
                    return new $this->controllerClass($this->action,$this->urlValues);
                } else {
                    //bad action/method error
                    require("controllers/error.php");
                    return new ErrorController("badurl",$this->urlValues);
                }
            } else {
                //bad controller error
                require("controllers/error.php");
                return new ErrorController("badurl",$this->urlValues);
            }
        } else {
            //bad controller error
            require("controllers/error.php");
            return new ErrorController("badurl",$this->urlValues);
        }
    }
}

?>
