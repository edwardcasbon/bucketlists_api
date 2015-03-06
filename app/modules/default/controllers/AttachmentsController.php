<?php
class AttachmentsController extends Bucketlists_Controller {
	
	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");
			
	}
	
	public function createAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("POST");
		
	}
	
	public function updateAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("PUT");
		
	}
	
	public function deleteAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("DELETE");
		
		// Remember to update the status code of the record, rather than delete 
		// the record entirely!
		
	}
	
}