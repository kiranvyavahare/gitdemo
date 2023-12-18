<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/api/Authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->mobile_no = $data->mobile_no;

$user_exists = $user->userExists();
 
// files for jwt will be here
// generate json web token
/*include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;*/
 
// check if email exists and if password is correct
if($user_exists){
 	
	// set response code
    http_response_code(200);
 
    // generate jwt
    //$jwt = JWT::encode($token, $key);
    echo json_encode(
		array(
		 "message" => "Successful login.",
		 "status"=>$user->status,
    	 "error"=>"",
			"data" => array(
			   "Enroll_id" => $user->enroll_id,
				 "fullname" => $user->fullname,
			   "mobile_no" => $user->mobile_no,
			   "email" => $user->email
		   ),
		   "is_new_user"=>$user->is_new_user,
		   "user_type"=>$user->user_type
		)
	);
}
// login failed
else{
    // set response code
    http_response_code(401);
    // tell the user login failed
    echo json_encode(
	array(
		 "message" => "Login Failed",
		 "status"=>false,
    	 "error"=>"Login Failed",
			"data" => array( ),
		   "is_new_user"=>true,
		   "user_type"=>"guest"
		)
	);
}

?>