<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/employee.php';

$database = new Database();
$db = $database->getConnection();
 

$employee = new Employee($db);

// query products
$stmt = $employee->read();
$num = $stmt->rowCount();
 
// check if more than 0 records found
if($num>0){
 
    // products array
    $emp_arr=array();
    $emp_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $cur_employee=array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "role" => $role
        );
 
        array_push($emp_arr["records"], $cur_employee);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show employee data in json format
    echo json_encode($emp_arr);
}
 
else{
 
    //this should literally never happen unless something really weird is going on
    http_response_code(404);
 
    // no employees
    echo json_encode(
        array("message" => "No employees found.")
    );
}
?>

