<?php

class CartItem{

    
    private $conn;
    private $table_name = "cart_items";

    
	public $id;
	public $product_id;
	public $quantity;
    public $user_id;
	public $created;
	public $modified;

	
    public function __construct($db){
        $this->conn = $db;
    }


    
    function update(){

        
        $query = "UPDATE " . $this->table_name . "
                SET quantity=:quantity
                WHERE product_id=:product_id AND user_id=:user_id";

        
        $stmt = $this->conn->prepare($query);

        
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

        
        if($stmt->execute()){
            return true;
        }

        return false;
    }

   
    public function deleteByUser(){
       
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id=:user_id";
		$stmt = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
 
        $stmt->bindParam(":user_id", $this->user_id);

		if($stmt->execute()){
			return true;
		}

        return false;
    }

   
    public function delete(){

      
        $query = "DELETE FROM " . $this->table_name . " WHERE product_id=:product_id AND user_id=:user_id";
		$stmt = $this->conn->prepare($query);
	
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
       
		$stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

		if($stmt->execute()){
			return true;
		}

        return false;
    }

  
    public function read(){

        $query="SELECT p.id, p.name, p.price, p.stock, ci.quantity, ci.quantity * p.price AS subtotal
    			FROM " . $this->table_name . " ci
    				LEFT JOIN products p
    					ON ci.product_id = p.id
                WHERE ci.user_id=:user_id";

        
		$stmt = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

		$stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

		$stmt->execute();
		
		return $stmt;
    }

   
    function create(){

        
        $this->created=date('Y-m-d H:i:s');

        
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					product_id = :product_id,
					quantity = :quantity,
					user_id = :user_id,
					created = :created";
		
        $stmt = $this->conn->prepare($query);
		
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
		$this->quantity=htmlspecialchars(strip_tags($this->quantity));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));

		
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":created", $this->created);

		
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function exists(){

       
        $query = "SELECT count(*) FROM " . $this->table_name . " WHERE product_id=:product_id AND user_id=:user_id";

        
        $stmt = $this->conn->prepare( $query );

        
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
		
		$stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $rows = $stmt->fetch(PDO::FETCH_NUM);

        
        if($rows[0]>0){
            return true;
        }

        return false;
    }

   
    public function count(){
  
        $query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id=:user_id";
        
        $stmt = $this->conn->prepare( $query );
        
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
   
        $stmt->bindParam(":user_id", $this->user_id);
  
        $stmt->execute();
       
        $rows = $stmt->fetch(PDO::FETCH_NUM);
       
        return $rows[0];
    }
}
?>
