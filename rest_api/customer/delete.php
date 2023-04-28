<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



include 'function.php';




$request=$_SERVER['REQUEST_METHOD'];




if($request=='DELETE')
{

   
     
        $num=delete_data($_GET);
        echo $num;
       
 




}
else
{
    $err=[
    'status'=>405,//method not allowed
    'message'=>$request." method not allowed"];


    
header('HTTP/1.0 405 METHOD NOT ALLOWED');
echo json_encode($err);
}

?>