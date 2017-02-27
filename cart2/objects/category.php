<?php

class Category{

	
	private $conn;
	private $table_name = "categories";

	
	public $id;
	public $name;
	public $description;

	
	public function __construct($db){
		$this->conn = $db;
	}

	function readCategoryNameById(){


		$query = "SELECT name FROM categories WHERE id = ? limit 0,1";

		$stmt = $this->conn->prepare($query);

		$this->id=htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(1, $this->id);

		$stmt->execute();


		$row = $stmt->fetch(PDO::FETCH_ASSOC);


		$category_name=$row['name'];

		return $category_name;
	}

    function readWithoutPaging(){


        $query = "SELECT id, name, description
                FROM " . $this->table_name . "
                ORDER BY name";

        $stmt = $this->conn->prepare( $query );

        $stmt->execute();


        return $stmt;
    }
}
?>
