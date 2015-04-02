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
	
	public function format ($array) {
							
		if (count($array) === 0) {
			return array();
		}
		
		$formatted = array();
		
		foreach($array as $key => $value) {
			// Format the key from camelCase to camel_case.
			$key = strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $key));
			$formatted[$key] = $value;
		}
		
		return $formatted;
	}
	
	// Return only the requested keys from the array.
	public function getValuesFromArray ($array, $keys) {	
		$values = array();
			
		foreach($keys as $key) {
			if(array_key_exists($key, $array)) {
				$values[$key] = $array[$key];
			}
		}
			
		return $values;
	}
	
	public function getExpectedParams ($params) {
		if(count($params) === 0) {
			return array();
		}
		
		$params = $this->getValuesFromArray($this->route->params, $params);
		
		if(count($params) === 0) {
			// None of the expected params have been passed in, throw back an error.
			throw new Simps_Exception("Missing expected parameters.", 405);
		}
		
		return $params;
	}
	
}
