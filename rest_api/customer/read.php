<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");



include 'function.php';




$request=$_SERVER['REQUEST_METHOD'];




if($request=='GET')
{

    if(isset($_GET['srno']))
    {
     
        $num=single_data_fetch($_GET);
        echo $num;
       

    }

    else

    {
       
        $customerList=getCoustmerList();
        echo $customerList;
        
    }




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