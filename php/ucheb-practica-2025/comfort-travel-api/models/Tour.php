<?php
class Tour {
    private $conn;
    private $table = "tours";

    public $id;
    public $country_id;
    public $name;
    public $description;
    public $start_date;
    public $end_date;
    public $price;
    public $max_people;
    public $available_spots;
    public $created_at;
    public $country_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT 
                    t.*, 
                    c.name as country_name 
                  FROM " . $this->table . " t
                  LEFT JOIN countries c ON t.country_id = c.id
                  ORDER BY t.start_date";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readAvailable() {
        $query = "SELECT 
                    t.*, 
                    c.name as country_name 
                  FROM " . $this->table . " t
                  LEFT JOIN countries c ON t.country_id = c.id
                  WHERE t.available_spots > 0 
                    AND t.start_date > CURDATE()
                  ORDER BY t.start_date";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET country_id=:country_id, name=:name, description=:description,
                      start_date=:start_date, end_date=:end_date, price=:price,
                      max_people=:max_people, available_spots=:available_spots";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":country_id", $this->country_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":max_people", $this->max_people);
        $stmt->bindParam(":available_spots", $this->available_spots);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET country_id=:country_id, name=:name, description=:description,
                      start_date=:start_date, end_date=:end_date, price=:price,
                      max_people=:max_people, available_spots=:available_spots
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":country_id", $this->country_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":max_people", $this->max_people);
        $stmt->bindParam(":available_spots", $this->available_spots);
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