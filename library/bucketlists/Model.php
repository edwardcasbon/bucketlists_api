<?php
class Bucketlists_Model {
	protected $db;
	
	protected $tableName;
	
	public function __construct($db) {					
		$this->db = $db;
	}
	
	public function get(Array $criteria, $table) {
		
		// Set the table to act upon.
		$table = $this->_setTable($table);
		
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
	
	public function add(Array $data, $table) {
		
		// Set the table to act upon.
		$table = $this->_setTable($table);
				
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
		$this->db->exec($sql);
		
		// Get the ID.
		$id = $this->db->lastInsertId();
		
		// Return the new record.
		return $this->get(array("id" => $id));
	}
	
	public function update(Array $data, Array $criteria, $table) {
		
		// Set the table to act upon.
		$table = $this->_setTable($table);
		
		// Start of the statement.
		$sql = "UPDATE {$table} SET ";
		
		// Build the updates part of the statement.
		$updates = array();
		foreach($data as $key => $value) {
			$updates[] = "`" . $key . "` = " . $this->db->quote($value);
		}
		$sql .= implode(", ", $updates);
		
		// Update the updated timestamp.
		$sql .= ", `updated_datetime` = NOW()";
		
		// Build the where part of the statement.
		$sql .= $this->_buildWhere($criteria);
		
		// Execute the update query.
		$this->db->exec($sql);
		
		// Return the record.
		return $this->get($criteria, $table);
	}
		
	public function delete(Array $criteria, $table) {

		// Set the table to act upon.
		$table = $this->_setTable($table);

		// Start of the statement
		$sql = "DELETE FROM {$table}";
		
		// Build the where part of the statement.
		$sql .= $this->_buildWhere($criteria);
		
		// Execute the query.
		$rows = $this->db->exec($sql);
		
		// Return the number of rows deleted.
		return $rows;
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
		
		// Start of the WHERE part of the statement.
		$sql .= " WHERE ";
		
		// Loop through the criteria array, building up the conditions.
		$conditions = array();
		foreach($criteria as $key => $value) {
			$conditions[] = $key . " = " . $this->db->quote($value);
		}
		
		// Implode the conditions array to build the where string.
		$sql .= implode(" AND ", $conditions);
		
		// Return the built string.
		return $sql;
	}
	
	protected function _setTable($table) {
		if(isset($table)) {
			return $table;
		}
		return $this->tableName;
	}
}