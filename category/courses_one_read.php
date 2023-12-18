<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/courses.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

$courses= new Course($db);
//$courses->course_domain_id = isset($_GET['id']) ? $_GET['id'] : die();
$stmt=$courses->read_one();
echo json_encode($stmt);
$numCnt = $stmt->rowCount();
echo $numCnt;
if($numCnt>0)
{
    $courses_arr=array();
    $courses_arr["records"]=array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $course_items=array(
            "course_id"=> $course_id,
            "course_name"=> $course_name,
            "course_description"=> $course_description,
            "course_duration"=> $course_duration
        );
        array_push($courses_arr["records"],$course_items);

    }
    http_response_code(200);
    echo json_encode($courses_arr);
}
else
{
    http_response_code(404);
 
    // tell the user no categories found
    echo json_encode(
        array("message" => "No Courses found for this domain.")
    );
}
?>