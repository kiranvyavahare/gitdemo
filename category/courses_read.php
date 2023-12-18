<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/courses.php';

$database=new Database();
$db=$database->getConnection();

$domainCat=new CoursesRead($db);
$stmt=$domainCat->read();
//echo json_encode($stmt);
$numCnt=$stmt->rowCount();

if($numCnt>0)
{
    $domainCategories_arr=array();
    $domainCategories_arr["records"]=array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $domain_items=array(
            "enroll_id"=>$enroll_id,
            "name"=>$name
           /* "course_id"=>$cat_id,
            "course_name"=>$cat_name,
            "course_description"=>$course_description,
            "course_duration"=>$course_duration*/
        );
        array_push($domainCategories_arr["records"],$domain_items);
    }

    http_response_code(200);
    echo json_encode($domainCategories_arr);
}
else
{
    http_response_code(404);
 
    // tell the user no categories found
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>