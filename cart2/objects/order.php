<?php

class Order{

   
    private $conn;
    private $table_name = "orders";

    
	public $id;
	public $transaction_id;
	public $user_id;
	public $firstname;
	public $lastname;
	public $total_cost;
	public $status;
	public $created;

	
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
       
        $this->created=date('Y-m-d H:i:s');
 
        $query = "INSERT INTO " . $this->table_name . "
                SET
					transaction_id = :transaction_id,
					user_id = :user_id,
					total_cost = :total_cost,
                    status = :status,
					created = :created";
		
        $stmt = $this->conn->prepare($query);

		$this->transaction_id=htmlspecialchars(strip_tags($this->transaction_id));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		$this->total_cost=htmlspecialchars(strip_tags($this->total_cost));
		
        $stmt->bindParam(":transaction_id", $this->transaction_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":total_cost", $this->total_cost);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->created);

		
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}
