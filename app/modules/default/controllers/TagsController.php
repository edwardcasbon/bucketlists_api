<?php
class TagsController extends Bucketlists_Controller {
	
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
		
	}
	
}