<?php
class Database{
  
  private $host_name = '127.0.0.1';//'db5000095468.hosting-data.io';
  private $database =  'codechallengelocal';//'dbs90026';
  private $user_name = 'testUser';//'dbu91168';
  private $password = 'tesT_DB-12';
 // $dbh = null;
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
  try {
    $this->conn = new PDO("mysql:host=127.0.0.1; dbname=codechallengelocal", 'testUser', 'tesT_DB-12');
  } catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";}
 
        return $this->conn;
    }
  }
?>
