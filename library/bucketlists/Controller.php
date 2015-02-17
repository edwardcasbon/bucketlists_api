<?php

class Bucketlists_Controller extends Simps_Controller {
	
	public function __construct ($route) {
		
		// Call the SimpsController constructor.
		parent::__construct($route);
		
		// Disable the view layout.
		$this->view->disableLayout();
	}
	
	public function __destruct () {
		
		// Unset the database connection.
		unset($this->db);
		
		// Set the header to serve json
		header("Content-type: application/json");
		
		// echo the json
		echo json_encode($this->view->json);
	}
	
	public function validateHttpMethod ($validMethod) {
		
		if($this->route->method !== $validMethod) {

			// Not a valid request method, return error.
			unset($this->view->json);
			throw new Simps_Exception("Not a valid HTTP method for this API endpoint.", 405);
		}
	}
	
}
