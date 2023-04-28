<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");






include "function.php";


$post=$_SERVER['REQUEST_METHOD'];


if($post=='PUT')
{
   $mess=json_decode(file_get_contents("php://input"),true);
  

      $upd=update_data($mess,$_GET);

   echo $upd;
}

else
{
    $err=['staus'=>405,
           'message'=>$post." method is not allowed"];

           header('http/1.0 405 method is not allowed');
           echo json_encode($err);
}










?>