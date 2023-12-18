<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "enrollment";
 
    // object properties
    public $enroll_id;
    public $fullname;
    public $mobile_no;
    public $email;
   // public $password;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	// create() method will be here
	// create new user record
	/*function create(){
	 
		// insert query
		$query = "INSERT INTO " . $this->table_name . "
				SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					password = :password";
	 
		// prepare the query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->password=htmlspecialchars(strip_tags($this->password));
	 
		// bind the values
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
	 
		// hash the password before saving to database
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
	 
		// execute the query, also check if query was successful
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}*/
	 
	// emailExists() method will be here
	// check if given email exist in the database
	function userExists(){
	 
		// query to check if email exists
		$query = "SELECT enroll_id, name, mail, contact
				FROM " . $this->table_name . "
				WHERE contact = ?
				LIMIT 0,1";
	 	
		// prepare the query
		$stmt = $this->conn->prepare( $query );
	 
		// sanitize
		$this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
	 
		// bind given email value
		$stmt->bindParam(1, $this->mobile_no);
	 
		// execute the query
		$stmt->execute();
	 
		// get number of rows
		$num = $stmt->rowCount();
	 
		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){
	 
			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
			// assign values to object properties
			$this->enroll_id = $row['enroll_id'];
			$this->fullname = $row['name'];
			$this->mobile_no = $row['contact'];
			$this->email = $row['mail'];
			$this->user_type = "student";
	 		$this->is_new_user = false;
			$this->status=true;
			// return true because email exists in the database
			return true;
		}
		else
		// return false if email does not exist in the database
		return false;
	}
	 
	// update() method will be here
}