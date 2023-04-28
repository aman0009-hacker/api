<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



require('../database.php');
include 'function.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;




 $data=json_decode(file_get_contents('php://input'),true);


    $jwt=$data['jwt'];
    
    
    $key='Testingkey123';
    
       
    
    
    try
    {
    
    
        $decoded= JWT::decode($jwt, new Key($key, 'HS256'));
        http_response_code(200);
        $err=[
              'message'=>'the user information of validate token',
              'data'=>$decoded
            ];
            echo json_encode($err); 
    }
    catch(Exception $e)
    {
        http_response_code(401);
        $err=[
        'message'=>'not accessing',
    'data'=>$e->getMessage()];
    
        
        echo json_encode($err);
    }
    







?>