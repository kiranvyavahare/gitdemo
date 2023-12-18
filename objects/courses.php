<?php
include_once '../class/main.php';
class CoursesRead extends main{

    // database connection and table name
    // private $conn;
    private $table_name = "enrollment";

    /*public $cat_id;
    public $cat_name;
    public $show_for_app;

    public function __construct($db)
    {
        $this->conn=$db;
    }*/

    public function read(){

        $query="select enroll_id,name from ".$this->table_name." where 1 order by enroll_id limit 0,10";
        $stmt= $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>