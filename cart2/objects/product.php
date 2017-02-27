<?php

class Product{

	
	private $conn;
	private $table_name="products";

	
	public $id;
	public $name;
	public $price;
	public $stock;
	public $description;
	public $category_id;
	public $category_name;
	public $timestamp;
	
	public function __construct($db){
		$this->conn = $db;
	}
	
	function updateStock(){
		
		$query = "UPDATE
					" . $this->table_name . "
				SET
					stock = :stock
				WHERE
					id = :id";
		
		$stmt = $this->conn->prepare($query);
		
		$this->stock=htmlspecialchars(strip_tags($this->stock));
		$this->id=htmlspecialchars(strip_tags($this->id));
		
		$stmt->bindParam(':stock', $this->stock);
		$stmt->bindParam(':id', $this->id);
		
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	
	function readOne(){

	
		$query = "SELECT
					c.name as category_name, p.name, p.description, p.price, p.stock, p.category_id
				FROM
					" . $this->table_name . " p
					LEFT JOIN
						categories c
							ON p.category_id = c.id
				WHERE
					p.id = ?
				LIMIT
					0,1";

		
		$stmt = $this->conn->prepare( $query );
		
		$this->id=htmlspecialchars(strip_tags($this->id));
		
		$stmt->bindParam(1, $this->id);
		
		$stmt->execute();
	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->price = $row['price'];
		$this->stock = $row['stock'];
		$this->category_id = $row['category_id'];
		$this->category_name = $row['category_name'];
	}
	
	
	public function readByIds($ids){

		$ids_arr = str_repeat('?,', count($ids) - 1) . '?';
		
		$query = "SELECT id, name, price, stock FROM products WHERE id IN ({$ids_arr}) ORDER BY name";
		
		$stmt = $this->conn->prepare($query);
	
		$stmt->execute($ids);
	
		return $stmt;
	}


	function search($search_term, $from_record_num, $records_per_page){

		
		$query = "SELECT
					c.name as category_name, p.id, p.name, p.description, p.price, p.stock, p.category_id
				FROM
					" . $this->table_name . " p
					LEFT JOIN
						categories c
					ON
						p.category_id = c.id
				WHERE
					p.name LIKE :name
					OR p.description LIKE :description
				ORDER BY
					p.created DESC
				LIMIT
					:from_record_num, :records_per_page";

	
		$stmt = $this->conn->prepare( $query );
	
		$search_term=htmlspecialchars(strip_tags($search_term));

		$search_term = "%{$search_term}%";

		$stmt->bindParam(":name", $search_term);
		$stmt->bindParam(":description", $search_term);
		$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
	
		$stmt->execute();
		
		return $stmt;
	}
	
	public function countBySearch($search_term){

		
		$query = "SELECT count(*) FROM " . $this->table_name . " WHERE name=:name OR description=:description";
	
		$stmt = $this->conn->prepare( $query );
	
		$search_term=htmlspecialchars(strip_tags($search_term));
	
		$search_term = "%{$search_term}%";
	
		$stmt->bindParam(":name", $search_term);
		$stmt->bindParam(":description", $search_term);
	
		$stmt->execute();
	
		$rows = $stmt->fetch(PDO::FETCH_NUM);
	
		return $rows[0];
	}


	function readByCategoryId($from_record_num, $records_per_page){
	
		$query = "SELECT
					c.name as category_name, p.id, p.name, p.description, p.price, p.stock, p.category_id
				FROM
					" . $this->table_name . " p
					LEFT JOIN
						categories c
					ON
						p.category_id = c.id
				WHERE
					c.id = ?
				ORDER BY
					p.created DESC
				LIMIT
					?, ?";

	
		$stmt = $this->conn->prepare( $query );
	
		$stmt->bindParam(1, $this->category_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
	
		$stmt->execute();
	
		return $stmt;
	}

	
	function read($from_record_num, $records_per_page){

	
		$query = "SELECT
					c.name as category_name, p.id, p.name, p.description, p.price, p.stock, p.category_id
				FROM
					" . $this->table_name . " p
					LEFT JOIN
						categories c
					ON
						p.category_id = c.id
				ORDER BY
					p.created DESC
				LIMIT
					?, ?";
	
		$stmt = $this->conn->prepare( $query );

	
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
	
		$stmt->execute();
	
		return $stmt;
	}

  
	public function count(){
		
		$query = "SELECT count(*) FROM " . $this->table_name;

		$stmt = $this->conn->prepare( $query );
	
		$stmt->execute();
	
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		return $rows[0];
	}


	public function countByCategoryId(){
	
		$query = "SELECT count(*) FROM " . $this->table_name . " WHERE category_id = ?";

		$stmt = $this->conn->prepare( $query );

		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
	
		$stmt->bindParam(1, $this->category_id);

		$stmt->execute();

		$rows = $stmt->fetch(PDO::FETCH_NUM);


		return $rows[0];
	}
}
?>
