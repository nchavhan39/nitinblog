<?php
class ErrorController extends BaseController{
	public function __construct($action, $urlValues) {
	 	parent::__construct($action, $urlValues);
	}
	public function badurl(){
		$this->view->render("Error/404");
	}
}