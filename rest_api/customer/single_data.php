<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



include 'function.php';

$the_re=$_SERVER['REQUEST_METHOD'];



if($the_re=='GET')
{
    $the_single=single_data_fetch($_GET);
    echo $the_single;
}


else
{
    $err=['status'=>'405',
           'message'=>$the_re.'method is not allowed'];

     header('http/1.0 '.$the_re.'method is not allowed');
     echo json_encode($err);

        }




?>