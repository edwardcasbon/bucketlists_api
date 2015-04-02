<?php
class AttachmentsController extends Bucketlists_Controller {
	
	public function __construct ($route) {
		
		// Call the Bucketlists constructor.
		parent::__construct($route);
		
		// Create an instance of the model.
		$this->attachmentsModel = new Attachments($this->db);		
	}
	
	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");
		
		// Expected / Allowed params.
		$expectedParams = array(
			"id",
			"itemId"
		);
		
		// Get the params	
		$params = $this->getExpectedParams($expectedParams);
				
		// Get the attachments.
		$attachments = $this->attachmentsModel->get($this->format($params));
			
		// Output the attachments.
		$this->view->json = $attachments;
	}
	
	public function createAction () {
		
		// Validate the HTTP method.
		$this->validateHttpMethod("POST");
		
		// Format the params.
		$params = $this->format($this->route->params);
				
		// Create the attachment.
		$attachment = $this->attachmentsModel->add($params);
								
		// Output the attachment.
		$this->view->json = $attachment;		
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