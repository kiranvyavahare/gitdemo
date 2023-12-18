<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/lead.php';
 
$database = new Database();
$db = $database->getConnection();
 
$lead = new Lead($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->mobile_number)
){
 
    // set lead property values
    $lead->curr_date = $data->curr_date;
	$lead->name = $data->name;
    $lead->mobile_number = $data->mobile_number;
    $lead->email = $data->email;
    $lead->course = $data->course;
    $lead->city = $data->city;
	$lead->source = $data->source;
    $lead->adset = $data->adset;
    $lead->added_date = date('Y-m-d H:i:s');
 
    // create the lead
    if($lead->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Inquiry was created."));
    }
 
    // if unable to create the lead, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Inquiry."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Inquiry. Data is incomplete."));
}
?>