<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "isas_api";
    private $username = "root";
    private $password = "";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            //$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn = mysql_connect($this->host ,$this->username, $this->password);
            mysql_select_db($this->db_name,$this->conn );
            //$this->conn->exec("set names utf8");
        }catch(Exception $e){
            echo "Connection error: " . $e->getMessage();
        }
 
        return $this->conn;
    }
}
?>