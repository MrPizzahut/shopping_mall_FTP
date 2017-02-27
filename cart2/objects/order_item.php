<?php

class OrderItem{

   
    private $conn;
    private $table_name = "order_items";

    
	public $id;
	public $transaction_id;
	public $product_id;
	public $price;
	public $quantity;
	public $created;
	public $modified;

	
    public function __construct($db){
        $this->conn = $db;
    }

    
    function create(){

       
        $this->created=date('Y-m-d H:i:s');

        
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					transaction_id = :transaction_id,
					product_id = :product_id,
					price = :price,
					quantity = :quantity,
					created = :created";

	
        $stmt = $this->conn->prepare($query);
	
		$this->transaction_id=htmlspecialchars(strip_tags($this->transaction_id));
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->quantity=htmlspecialchars(strip_tags($this->quantity));
		
        $stmt->bindParam(":transaction_id", $this->transaction_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":quantity", $this->quantity);
		$stmt->bindParam(":created", $this->created);

	
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
}
?>
