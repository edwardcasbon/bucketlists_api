<?php
class Buckets {
	
	protected $db;
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function getBuckets ($userId) {
		$query = "SELECT * FROM buckets";
		
		if($userId) {
			$query .= " WHERE user_id = {$userId}";
		}
		
		return $this->db->query($query)->fetchAll();
	}
	
}