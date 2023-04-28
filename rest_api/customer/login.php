<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



include 'function.php';

$the_re=$_SERVER['REQUEST_METHOD'];



if($the_re=='POST')
{

    $data=json_decode(file_get_contents("php://Input"),true);

    if(empty($data))
    {
        $the_single=login_page($_POST);
        echo $the_single;
    }
    else
    {
        $the_single=login_page($data);
        echo $the_single;
    }



   
}


else
{
    $err=['status'=>'405',
           'message'=>$the_re.'method is not allowed'];

     header('http/1.0 '.$the_re.'method is not allowed');
     echo json_encode($err);

        }




?>