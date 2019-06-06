<?php
// required headers - why am I getting a CORS origin exception here even with the Access-Control-Allow-Origin: *???  TODO:fix this
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// shift definition
include_once '../objects/shift.php';
 
$database = new Database();
$db = $database->getConnection();
 
$shift = new Shift($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->emp_name) &&
    !empty($data->start_time) &&
    !empty($data->length)
){
 
    // set shift property values
    $shift->emp_name = $data->emp_name;
    $shift->start_time = $data->start_time;
    $shift->length = $data->length;
	$lenInHours = new DateInterval("PT" . $data->length . "H");

	$e_time = strtotime($data->start_time);
	$e_time = $e_time + ($data->length * 60 * 60 * 1000);
    $e_time = date("Y-m-d h:i:sa", $e_time);	//milliseconds to hours
	//date_add($e_time, date_interval_create_from_date_string($data->length . " hours"));
//	$end_time = 
    $shift->end_time = $e_time;


 
    // create the shift
if (!($shift->findBetween($shift->emp_name, $shift->start_time, $shift->end_time)) && (($shift->getLatest($shift->emp_name, $shift->start_time)) == 0 || ($shift->getLatest($shift->emp_name, $shift->start_time) < $data->start_time))){
//the above check SHOULD find any instances of the employee scheduled for a shift overlapping itself (checking start and end times that are between the proposed new start and end times, and then
//ensuring that if the employee has an existing shift prior to the proposed shift, the end_time of the existing shift is prior to the start_time of the proposed shift (for the case where a proposed
//shift would otherwise fall entirely within another shift).  That said, it's not working, it's something to do with the conversions from HTML datetimes to PHP timestamps to JSON strings to SQL datetimes....
    if($shift->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Shift added to schedule."));
    }
 
    // if unable to create the shift, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create shift - service temporarily unavailable."));
    }

 

}
else {
     //shift overlaps
     http_response_code(400);
     echo json_encode(array("message" => "Unable to create shift.  Overlaps existing shift for " . $data->emp_name . "."));}

}

// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
echo json_encode(array("message" => "Unable to create shift. Data is incomplete."));}
?>
