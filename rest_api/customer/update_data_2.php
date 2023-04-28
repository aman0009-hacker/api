<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");


include 'function.php';

$image_post=$_SERVER['REQUEST_METHOD'];

if($image_post=='POST')
{

$image=json_decode(file_get_contents("php://input"),true);

if(empty($image))
{
    $images=the_image_uploaded($_POST,$_GET,$_FILES);
    echo $images; 
}
else
{
$images=the_image_uploaded($image,$_GET);
echo $images;
}


}
else{

    http_response_code(405);
    $err=['staus'=>405,
    'message'=>$post." method is not allowed"];

   
    echo json_encode($err);
}




?>