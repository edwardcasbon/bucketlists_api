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

		// Expected / Allowed params.
		$expectedParams = array(
			"id"
		);

		// Get the expected params.
		$this->getExpectedParams($expectedParams);

		// Get the params.
		$params = $this->format($this->route->params);

		// Get the criteria (ID).
		$criteria = array("id" => $params["id"]);

		// Get the data, by removing the ID.
		unset($params["id"]);

		// Update the attachment.
		$attachment = $this->attachmentsModel->update($params, $criteria);

		// Output the updated attachment.
		$this->view->json = $attachment;
	}

	public function deleteAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("DELETE");

		// Expected / Allowed params.
		$expectedParams = array(
			"id"
		);

		// Get the expected params.
		$params = $this->getExpectedParams($expectedParams);

		// Update the attachments status code, rather than delete it completely.
		$attachment = $this->attachmentsModel->update(array("status" => 0), array("id" => $params["id"]));

		// Output the updated attachment.
		$this->view->json = $attachment;
	}

}
