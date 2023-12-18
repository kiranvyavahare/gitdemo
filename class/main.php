<?php
class Main {

    // database connection and table name
    public $conn;
    //private $table_name = "course_domain_category";

    public $cat_id;
    public $cat_name;
    public $show_for_app;

    public function __construct($db)
    {
        $this->conn=$db;
    }
}
?>