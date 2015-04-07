<?php
class Tags extends Bucketlists_Model {

	protected $tableName = "tags";

	public function get(Array $criteria, $table) {

		// Set the table to act upon.
		$table = $this->_setTable($table);

		// If ID supplied, then get the tag.
		$id = (array_key_exists("id", $criteria)) ? true : false;

		// If itemId supplied then get tags for that item.
		$itemId = (array_key_exists("item_id", $criteria)) ? true : false;

		// If bucketId supplied then get the tags for all the items in the bucket.
		$bucketId = (array_key_exists("bucket_id", $criteria)) ? true : false;

		// If item ID and bucket ID weren't passed in, then continue as normal.
		if($id) {
			return parent::get($criteria, $table);
		}

		// If item ID passed in, then get the item tags.
		if($itemId) {
			return $this->getItemTags($criteria);
		}

		// If bucket ID passed in, then get the bucket tags.
		if($bucketId) {
			return $this->getBucketTags($criteria);
		}
	}

	public function getItemTags(Array $criteria) {

		// If a status isn't passed in, then only get the live (status=1) records.
		if(!array_key_exists("status", $criteria)) {
			$criteria["status"] = 1;
		}

		// Build the statement.
		$sql = "SELECT DISTINCT tags.* FROM tags, tag_items WHERE tags.id = tag_items.tag_id AND tag_items.item_id = " . $criteria["item_id"];

		// Get the tags.
		return $this->db->query($sql)->fetchAll();
	}

	public function getBucketTags(Array $criteria) {

		// If a status isn't passed in, then only get the live (status=1) records.
		if(!array_key_exists("status", $criteria)) {
			$criteria["status"] = 1;
		}

		// Build the statement.
		$sql = "SELECT DISTINCT tags.* FROM tags, tag_items, items WHERE tags.id = tag_items.tag_id AND items.id = tag_items.item_id AND items.bucket_id = " . $criteria["bucket_id"];

		// Get the tags.
		return $this->db->query($sql)->fetchAll();
	}

	public function add(Array $data, $table) {

		// Add the tag
		$tag = parent::add(array("label" => $data["label"]), $table);

		// If item_id supplied then link the tag to an item(s).
		if(array_key_exists("item_id", $data)) {
			$itemIds = explode(",", $data["item_id"]);
			unset($data["item_id"]);

			// Loop through the item IDs linking them to the tag.
			foreach($itemIds as $id) {

				// Build the SQL insert string.
				$sql = "INSERT INTO tag_items (`tag_id`, `item_id`) VALUES ({$tag[0]->id}, {$id});";

				// Execute the SQL.
				$this->db->exec($sql);
			}
		}

		// Return the tag.
		return $tag;
	}

}
