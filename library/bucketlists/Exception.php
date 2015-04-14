<?php

class Bucketlists_Exception extends Simps_Exception {
	
	public function handleException ($message, $statusCode) {
				
		// Set the header
		header("HTTP/1.1 " . $statusCode . " " . $this->_requestStatus($statusCode));
		
		// Set the header to serve json
		header("Content-type: application/json");
		
		// Set the access control header
		header("Access-Control-Allow-Origin: *");
		
		// echo the json
		echo json_encode($message);
	}
	
}