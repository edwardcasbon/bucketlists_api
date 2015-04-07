<?php
class ItemsController extends Bucketlists_Controller {

	public function __construct ($route) {

		// Call the Bucketlists constructor.
		parent::__construct($route);

		// Create an instance of the model.
		$this->itemsModel = new Items($this->db);
	}

	public function indexAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("GET");

		// Expected / Allowed params.
		$expectedParams = array(
			"id",
			"bucketId",
			"tagId"
		);

		// Get the params
		$params = $this->getExpectedParams($expectedParams);

		// Get the items.
		$items = $this->itemsModel->get($this->format($params));

		// Output the items.
		$this->view->json = $items;
	}

	public function createAction () {

		// Validate the HTTP method.
		$this->validateHttpMethod("POST");

		// Format the params.
		$params = $this->format($this->route->params);

		// Create the item.
		$item = $this->itemsModel->add($params);

		// Output the item.
		$this->view->json = $item;
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

		// Update the item.
		$item = $this->itemsModel->update($params, $criteria);

		// Output the updated item.
		$this->view->json = $item;
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

		// Update the items status code, rather than delete it completely.
		$item = $this->itemsModel->update(array("status" => 0), array("id" => $params["id"]));

		// Output the updated item.
		$this->view->json = $item;
	}

}
