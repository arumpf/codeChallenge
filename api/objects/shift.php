<?php
class Shift{
 
    // database connection and table name
    private $conn;
    private $table_name = "shifts_master";
 
    // object properties
    public $id;
    public $emp_name;
    public $start_time;
    public $end_time;
    public $length;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
// read employees
function listAll(){
 
    // select all query
    $query = "SELECT * from shifts_master ORDER BY start_time ASC, emp_name ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

public function getLatest($name, $start){
     $sqlStart = date( 'Y-m-d H:i:s',strtotime($start ));

    // get most recent shift by start_time and employee - need this to check its end_time against the start_time of the new shift
    
    $query = "SELECT * FROM shifts_master WHERE start_time < ";
    $query .= $sqlStart . " AND emp_name = " . $name . " ORDER BY START_TIME DESC LIMIT 1"; //kinda hacky, only works in mySQL to my knowledge
	//probably could be replaced with something like 
	//SELECT * FROM shifts_master where START_TIME = 
	//(SELECT MAX(START_TIME) FROM shifts_master WHERE START_TIME < ($start_time)) AND END_TIME > ($end_time);
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
	$toReturn = 0;
	if ($stmt->rowCount() > 0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

        extract($row);
		$toReturn = $end_time;
	} 
	
	    echo ("getLatest toReturn: " . $toReturn);
    return $toReturn;
}

public function findBetween($name, $start, $end){
    //get any shift that has a start or end time in between the proposed shift time (per employee) - if this finds any result the proposed shift is overlapping
    $sqlStart = date( 'Y-m-d H:i:s', strtotime($start));
	$sqlEnd = date( 'Y-m-d H:i:s', strtotime($end));
    $query = "SELECT * FROM shifts_master WHERE emp_name = " . $name . " AND (start_time BETWEEN " . $sqlStart . " AND " . $sqlEnd . " OR ";
    $query .= "end_time BETWEEN " . $sqlStart . " AND " . $sqlEnd . ")";


    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
    echo ("findBetween rowCount: " . $stmt->rowCount());
    return ($stmt->rowCount()>0);
}

// create shift
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                emp_name=:name, start_time=:start_t, length=:length, end_time=:end_t";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->emp_name=htmlspecialchars(strip_tags($this->emp_name));
    $this->start_time=htmlspecialchars(strip_tags($this->start_time));
    $this->length=htmlspecialchars(strip_tags($this->length));
    $this->end_time=htmlspecialchars(strip_tags($this->end_time));
 

    // bind values
    $stmt->bindParam(":name", $this->emp_name);
    $stmt->bindParam(":start_t", date( 'Y-m-d H:i:s',strtotime($this->start_time)));
    $stmt->bindParam(":length", $this->length);
    $stmt->bindParam(":end_t", date( 'Y-m-d H:i:s', strtotime($this->end_time)));

 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

}


