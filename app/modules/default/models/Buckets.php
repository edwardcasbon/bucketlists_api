<?php
class Buckets extends Bucketlists_Model {
	
	protected $tableName = "buckets";
		
	public function getBuckets ($criteria) {
			
		$buckets = $this->get($this->tableName, $criteria);
		
		return $buckets;
	}
	
}