<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/shift.php';

$database = new Database();
$db = $database->getConnection();
 

$shift = new Shift($db);

// query products
$stmt = $shift->listAll();
$num = $stmt->rowCount();
 
// check if more than 0 records found
if($num>0){
 
    // shifts array
    $shift_arr=array();
    $shift_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $cur_shift=array(
            "id" => $id,
            "emp_name" => $emp_name,
            "start_time" => $start_time,
            "length" => $length,
            "end_time" => $end_time
        );
 
        array_push($shift_arr["records"], $cur_shift);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show shift data in json format
    echo json_encode($shift_arr);
}
 
else{
 

    http_response_code(404);
 
//no shifts found
    echo json_encode(
        array("message" => "No shifts found.")
    );
}
?>

