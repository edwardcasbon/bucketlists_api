<?php
class BucketsController extends Bucketlists_Controller {
	
	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");

		// Get the buckets DB model.
		$bucketsModel = new Buckets($this->db);
	
		// Get the user ID from the request.
		$userId = (int) $this->route->params['userId'];
	
		// Get the users buckets.
		$buckets = $bucketsModel->getBuckets(array("user_id" => $userId));
	
		// Output the result.
		$this->view->json = $buckets;
			
	}
	
	public function createAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("GET");
		
		$bucketsModel = new Buckets($this->db);
						
		$id = $bucketsModel->add($this->route->params);
		
		$this->view->json = $id;
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