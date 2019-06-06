<?php
class Employee{
 
    // database connection and table name
    private $conn;
    private $table_name = "employees_master";
 
    // object properties
    public $id;
    public $name;
    public $username;
    public $role;
    public $phone;
    public $email;
    private $pw;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
// read employees
function read(){
 
    // select all query
    $query = "SELECT * from employees_master ORDER BY id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

}


