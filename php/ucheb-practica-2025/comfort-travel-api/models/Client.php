<?php
class Client {
    private $conn;
    private $table = "clients";

    public $id;
    public $full_name;
    public $passport_number;
    public $phone;
    public $email;
    public $birth_date;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET full_name=:full_name, passport_number=:passport_number, 
                      phone=:phone, email=:email, birth_date=:birth_date";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":passport_number", $this->passport_number);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":birth_date", $this->birth_date);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET full_name=:full_name, passport_number=:passport_number, 
                      phone=:phone, email=:email, birth_date=:birth_date 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":passport_number", $this->passport_number);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":birth_date", $this->birth_date);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>