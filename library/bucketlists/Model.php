<?php
class Bucketlists_Model {
	protected $db;
	
	public function __construct($db) {
						
		$this->db = $db;
	}
	
	public function get($table, Array $criteria) {
		
		// Start of the SQL statement.
		$sql = "SELECT * FROM {$table}";
		
		// If a status isn't passed in, then only get the live (status=1) records.
		if(!array_key_exists("status", $criteria)) {
			$criteria["status"] = 1;
		}
		
		// If there's criteria, then build the SQL statement.
		$sql .= $this->_buildWhere($criteria);
		
		// Execute the query and return the results.
		return $this->db->query($sql)->fetchAll();
	}
	
	public function add($table, Array $data) {
				
		$keys = [];
		$values = [];
		
		// Set the status.
		$data["status"] = 1;
		
		// Loop through the data separating the keys and values.
		foreach($data as $key => $value) {
			$keys[] = $key;
			$values[] = $this->db->quote($value);
		}
		
		// Generate the SQL keys string.
		$sqlKeys = "`" . implode("`, `", $keys) . "`";
		
		// Generate the SQL values string.
		$sqlValues = implode(", ", $values);
		
		// Build the insert string.
		$sql = "INSERT INTO " . $table . " (" . $sqlKeys . ") VALUES (" . $sqlValues . ");";
				
		// Execute the insert statement.
		$this->db->query($sql);
		
		// Return the ID.
		return $this->db->lastInsertId();
	}
	
	public function update($table, Array $data, Array $criteria) {
		
		// Start of the statement.
		$sql = "UPDATE {$table} SET ";
		
		// Build the updates part of the statement.
		$updates = array();
		foreach($data as $key => $value) {
			$updates[] = $this->db->quote($key) . " = " . $this->db->quote($value);
		}
		$sql .= implode(" AND ", $updates);
		
		// Build the where part of the statement.
		$sql .= $this->_buildWhere($criteria);
		
		// Execute the query and return the results.
		return $this->db->query($sql)->fetchAll();
	}
		
	public function delete($table, Array $criteria) {
		// @TODO Finish this!
	}
	
	public function objectify(Array $array) {
		$object = new stdClass();
		foreach($array as $key => $value) {
			$object->$key = $value;
		}
		return $object;
	}
	
	protected function _buildWhere(Array $criteria) {
		if(!$criteria) {
			return false;
		}
		
		$sql .= " WHERE ";
		
		$conditions = array();
		foreach($criteria as $key => $value) {
			$conditions[] = $key . " = " . $this->db->quote($value);
		}
		
		$sql .= implode(" AND ", $conditions);
		
		return $sql;
	}
}