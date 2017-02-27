<?php

class ProductImage{

	
	private $conn;
	private $table_name = "product_images";

	
	public $id;
	public $product_id;
	public $name;
	public $timestamp;

	
	public function __construct($db){
		$this->conn = $db;
	}

	
	function readByProductId(){
		
		$query = "SELECT id, product_id, name
				FROM " . $this->table_name . "
				WHERE product_id = ?
				ORDER BY name ASC";

		
		$stmt = $this->conn->prepare( $query );
		
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
	
		$stmt->bindParam(1, $this->product_id);
		
		$stmt->execute();
		
		return $stmt;
	}

	
	function readFirst(){

		
		$query = "SELECT id, product_id, name
				FROM " . $this->table_name . "
				WHERE product_id = ?
				ORDER BY name DESC
				LIMIT 0, 1";

		
		$stmt = $this->conn->prepare( $query );
		
		$this->id=htmlspecialchars(strip_tags($this->id));
		
		$stmt->bindParam(1, $this->product_id);
		
		$stmt->execute();
		
		return $stmt;
	}
}
?>
