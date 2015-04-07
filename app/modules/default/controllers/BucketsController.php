<?php
class BucketsController extends Bucketlists_Controller {

	public function __construct ($route) {

		// Call the Bucketlists constructor.
		parent::__construct($route);

		// Create an instance of the model.
		$this->bucketsModel = new Buckets($this->db);
	}

	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");

		// Expected / Allowed params.
		$expectedParams = array(
			"id",
			"userId"
		);

		// Get the params
		$params = $this->getExpectedParams($expectedParams);

		// Get the buckets.
		$buckets = $this->bucketsModel->get($this->format($params));

		// Output the buckets.
		$this->view->json = $buckets;
	}

	public function createAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("POST");

		// Format the params.
		$params = $this->format($this->route->params);

		// Create the bucket.
		$bucket = $this->bucketsModel->add($params);

		// Output the bucket.
		$this->view->json = $bucket;
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

		// Update the bucket.
		$bucket = $this->bucketsModel->update($params, $criteria);

		// Output the updated bucket.
		$this->view->json = $bucket;
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

		// Update the buckets status code, rather than delete it completely.
		$bucket = $this->bucketsModel->update(array("status" => 0), array("id" => $params["id"]));

		// Output the updated bucket.
		$this->view->json = $bucket;
	}

}
