<?php
class Items extends Bucketlists_Model {

	protected $tableName = "items";

	public function get(Array $criteria, $table) {

		// Set the table to act upon.
		$table = $this->_setTable($table);

		// Start of the SQL statement.
		if(array_key_exists("tag_id", $criteria)) {
			$sql = "SELECT items.* FROM items, tag_items";
		} else {
			$sql = "SELECT * FROM {$table}";
		}

		// If a status isn't passed in, then only get the live (status=1) records.
		if(!array_key_exists("status", $criteria)) {
			$criteria["status"] = 1;
		}

		// Table join.
		if(array_key_exists("tag_id", $criteria)) {
			$criteria["items.id"] = "tag_items.item_id";
		}

		// Update the ID key as there's 2 id fields now new table joined!
		if(array_key_exists("id", $criteria)) {
			$criteria["items.id"] = $criteria["id"];
			unset($criteria["id"]);
		}

		// If there's criteria, then build the SQL statement.
		$sql .= $this->_buildWhere($criteria);

		// Execute the query and get the results.
		$results = $this->db->query($sql)->fetchAll();
		
		// If the ID's in the criteria, then only return the single result.
		if(array_key_exists("id", $criteria)) {
			return $results[0];
		}
		
		// else, return all of the results.
		return $results;
	}

}
