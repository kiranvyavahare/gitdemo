<?php
class Lead{
 
    // database connection and table name
    private $conn;
    private $table_name = "ga_leads";
 
    // object properties
    public $curr_date;
    public $name;
    public $mobile_number;
    public $email;
    public $course;
    public $source;
    public $adset;
 	public $added_date;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read Leads
    function read(){
    
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    date=:date, name=:name, mobile_number=:mobile_number, email=:email, course=:course, city=:city, source=:source, adset=:adset, added_date=:added_date";
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->curr_date=htmlspecialchars(strip_tags($this->curr_date));
		$this->name=htmlspecialchars(strip_tags($this->name));
        $this->mobile_number=htmlspecialchars(strip_tags($this->mobile_number));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->course=htmlspecialchars(strip_tags($this->course));
        $this->city=htmlspecialchars(strip_tags($this->city));
		$this->source=htmlspecialchars(strip_tags($this->source));
        $this->adset=htmlspecialchars(strip_tags($this->adset));
        $this->added_date=htmlspecialchars(strip_tags($this->added_date));
     
        // bind values
        $stmt->bindParam(":date", $this->curr_date);
		$stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":mobile_number", $this->mobile_number);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course", $this->course);
        $stmt->bindParam(":city", $this->city);
		$stmt->bindParam(":source", $this->source);
        $stmt->bindParam(":adset", $this->adset);
        $stmt->bindParam(":added_date", $this->added_date);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    // update the product
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    price = :price,
                    description = :description,
                    category_id = :category_id
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // delete the product
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // search products
    function search($keywords){
    
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                ORDER BY
                    p.created DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}
?>