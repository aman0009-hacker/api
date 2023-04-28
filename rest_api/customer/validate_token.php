<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



require('../database.php');
include 'function.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;




    $get_header=getallheaders();
    $get_code=trim($get_header['Authorization']);
    
    $token=substr($get_code,7);
    
    $key='Testingkey123';
    
       
    
    
    try
    {
    
    
        $decoded= JWT::decode($token, new Key($key, 'HS256'));
        http_response_code(200);
        $err=['status'=>200,
              'message'=>'the user information of validate token',
              'data'=>$decoded
            ];
            echo json_encode($err);
    }
    catch(Exception $e)
    {
        $err=['staus'=>405,
        'message'=>'not accessing',
    'data'=>$e->getMessage()];
    
        header('http/1.0 405 not accessing');
        echo json_encode($err);
    }
    







?>