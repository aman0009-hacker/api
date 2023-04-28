<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");






use Firebase\JWT\JWT;
use Firebase\JWT\Key;


include "function.php";




$post=$_SERVER['REQUEST_METHOD'];


if($post=='POST')
{
   $mess=json_decode(file_get_contents("php://input"),true);
   // echo $mess;
   if(empty($mess))
   {
      $ins=insert_data($_POST);

   }
   else
   {
      $ins=insert_data($mess);
   }
   echo $ins;
}

else
{
   // http_response_code(405);
    $err=['staus'=>405,
           'message'=>$post." method is not allowed"];

          
           echo json_encode($err);
}










?>