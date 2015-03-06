<?php
class TagsController extends Bucketlists_Controller {
	
	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");
			
	}
	
	public function createAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("POST");
		
		// NOTE: Check if a tag exists before creating one. If exists, return the ID/record.
		
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