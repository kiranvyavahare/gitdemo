<?php
include_once '../class/main.php';
class DomainCategory extends main{

    // database connection and table name
   // private $conn;
    private $table_name = "course_domain_category";

    /*public $cat_id;
    public $cat_name;
    public $show_for_app;

    public function __construct($db)
    {
        $this->conn=$db;
    }*/

    public function read(){

        $query=" Select cat_id,cat_name from ".$this->table_name." where show_for_app='y' order by cat_id asc";
        $stmt= $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

?>