<?php
class TagsController extends Bucketlists_Controller {

	public function __construct ($route) {

		// Call the Bucketlists constructor.
		parent::__construct($route);

		// Create an instance of the model.
		$this->tagsModel = new Tags($this->db);
	}

	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");

		// Expected / Allowed params.
		$expectedParams = array(
			"id",
			"itemId",
			"bucketId"
		);

		// Get the params
		$params = $this->getExpectedParams($expectedParams);

		// Get the tags.
		$tags = $this->tagsModel->get($this->format($params));

		// Output the tags.
		$this->view->json = $tags;
	}

	public function createAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("POST");

		// Format the params.
		$params = $this->format($this->route->params);

		// Create the tag.
		$tag = $this->tagsModel->add($params);

		// Output the tag.
		$this->view->json = $tag;
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

		// Update the tag.
		$tag = $this->tagsModel->update($params, $criteria);

		// Output the updated tag.
		$this->view->json = $tag;
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

		// Update the tags status code, rather than delete it completely.
		$tag = $this->tagsModel->update(array("status" => 0), array("id" => $params["id"]));

		// Output the updated tag.
		$this->view->json = $tag;
	}

}
