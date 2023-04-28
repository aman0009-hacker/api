<?php

require('../database.php');
require('phpjwt/src/BeforeValidException.php');
require('phpjwt/src/CachedKeySet.php');
require('phpjwt/src/ExpiredException.php');
require('phpjwt/src/JWK.php');
require('phpjwt/src/JWT.php');
require('phpjwt/src/Key.php');
require('phpjwt/src/SignatureInvalidException.php');


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

error_reporting(0);


function error422($the_val)
{
    $err=['staus'=>422,
    'message'=>$the_val];

    header('http/1.0 422 empty entity');
    echo json_encode($err);

    exit();
}


function insert_data($insert_all_data)
{

global $conn;

$name=mysqli_real_escape_string($conn,$insert_all_data['name']);
$password=mysqli_real_escape_string($conn,$insert_all_data['password']);
$pass=password_hash($password,PASSWORD_DEFAULT);
$city=mysqli_real_escape_string($conn,$insert_all_data['city']);


if(empty(trim($name)))
{ 

return error422("Enter your name");
}
else if(empty(trim($password)))
{
    return error422("Enter your password");
}
else if(empty(trim($city)))
{
    return error422("Enter your city");
}
else
{
    $in="insert into api (name,password,city) VALUES ('$name','$pass','$city')";
    $inrun=mysqli_query($conn,$in);
 
    if($inrun)
    {
        $err=['staus'=>201,
    'message'=>"the records are inserted"];

    header('http/1.0 201 the records are inserted successfully');
    return json_encode($err);
               
    }
    else

    {
        $err=['staus'=>500,
        'message'=>'internal server error'];
    
        header('http/1.0 500 internal server error');
        return json_encode($err);
    }
    
}
}


















function getCoustmerList()
{
    global $conn;
    $quer='select * from api';
    $quer_re=mysqli_query($conn,$quer);

    if($quer)
    {
       if(mysqli_num_rows($quer_re)>0)

       {
              $fet=mysqli_fetch_all($quer_re,MYSQLI_ASSOC);
              $err=[
                'status'=>200,//customers details not found
                'message'=>" customer list fetched succesfully",
                  'data'=>$fet];
            
            
                
            header('HTTP/1.0 200  ok');
            return json_encode($err);
       }
       else
       {
        $err=[
            'status'=>404,//customers details not found
            'message'=>" customers details not found"];
        
        
            
        header('HTTP/1.0 404  customers details not found');
        return json_encode($err);
       }
    }

    else
    {
        $err=[
            'status'=>500,//method not allowed
            'message'=>"INTERNAL SERVER ERROR"];
        
        
            
        header('HTTP/1.0 500  INTERNAL SERVER ERROR');
        return json_encode($err);
    }



}


function single_data_fetch($single_id)
{

global $conn;
if(!isset($single_id['srno']))
{
    error422("the srno is not found in url ");
}
if($single_id['srno']=='')
{
   
    error422("enter your id");
}

else

{
    $customer_id=mysqli_real_escape_string($conn,$single_id['srno']);
    $single="select * from api where srno='$customer_id'";
    $single_d=mysqli_query($conn,$single);

    if(mysqli_num_rows($single_d)==1)
    {
        $sdata=mysqli_fetch_assoc($single_d);
        http_response_code(200);
        $err=[
            'status'=>200,//method not allowed
            'message'=>" single data showing",
             'data'=>$sdata];
                   
        
            
       
        return json_encode($err);

    }
    else
    {
        $err=[
            'status'=>405,//method not allowed
            'message'=>" not found any data"];
        
        
            
        header('HTTP/1.0 405  not found any data');
        return json_encode($err);
    }
}




}






function update_data($inputs_all,$param)
{

global $conn;
if(!isset($param['srno']))
{
error422('the serial no is not found in url');
}
elseif(isset($param['srno']) && $param['srno']=='')
{
    error422('Enter your srno');
}
else
{

$updated_id=mysqli_real_escape_string($conn,$param['srno']);



$name=mysqli_real_escape_string($conn,$inputs_all['name']);
$password=mysqli_real_escape_string($conn,$inputs_all[password]);
$city=mysqli_real_escape_string($conn,$inputs_all['city']);

if(empty(trim($name)))
{ 

return error422("Enter your name");
}
elseif(empty(trim($password)))
{
    return error422("Enter your age");
}
elseif(empty(trim($city)))
{
    return error422("Enter your city");
}
else

{

  
    $in="update api SET name='$name',age='$password',city='$city' where srno='$updated_id'";
    $inrun=mysqli_query($conn,$in);
 
    if($inrun)
    {
        $err=['staus'=>200,
    'message'=>"the records are updated successfuly"];

    header('http/1.0 200 the records are updated successfully');
    return json_encode($err);
               
    }
    else

    {
        $err=['staus'=>500,
        'message'=>'internal server error'];
    
        header('http/1.0 500 internal server error');
        return json_encode($err);
    }
    
}



}


}


function delete_data($alltheid)
{
    global $conn;
    if(!isset($alltheid['srno']))
    {
     error422('the srno not found in the url ');    
     }
     else
     {
        $the_id=mysqli_real_escape_string($conn,$alltheid['srno']);

        if($the_id==1)
        {
            $del="delete from api where srno='$the_id'";
            $del_res=mysqli_query($conn,$del);

            if($del_res)
            {
                $err=["staus"=>200,
                       "message"=>"the data is successfully deleted"];

                       header("http:/200 the data is succesfully deleted");       
                    
                        return json_encode($err);
                    }



        }
        
        else
        {
            $err=["staus"=>404,
            "message"=>"the id is not exist"];

            header("http:/200 the id is not exist");       
         
             return json_encode($err);
        }
     }
     
}

function login_page($the_post_method)
{
 global $conn;
    if(!isset($the_post_method['name']))
    {
        error422("enter the name field ");
    }
    elseif(!isset($the_post_method['password']))
    {
        error422("enter the password field ");
    }   
    if($the_post_method['name']=='')
    {
       
        error422("enter the value of name");
    }
    elseif($the_post_method['password']=='')
    {
       
        error422("enter the value of password");
    }
    
    else
    
    {
        $customer_name=mysqli_real_escape_string($conn,$the_post_method['name']);
        $customer_password=mysqli_real_escape_string($conn,$the_post_method['password']);

     
    
        $single="select * from api where name='$customer_name'";
        $single_d=mysqli_query($conn,$single);
    
        if(mysqli_num_rows($single_d)==1)
        {

            
            $sdata=mysqli_fetch_assoc($single_d);
            $verify=password_verify($customer_password,$sdata['password']);
            
           
                $key = 'Testingkey123';
               $payload=array(
                "srn"=>$sdata['srno'],
                'name'=>$sdata['name'],
                'city'=>$sdata['city'],
                'password'=>$sdata['password']
               );




               if($verify)
               {
   
                
                $jwt = JWT::encode($payload, $key, 'HS256');

             

               $sdata['jwt']=$jwt;

               $err=[
                'status'=>200,
                'message'=>" login successful",
                 'data'=>$sdata];
                       
            
                
               header('HTTP/1.0 200  login successful');
                return json_encode($err);

               }
               else
               {
                $err=[
                    'status'=>404,//method not allowed
                    'message'=>" password unsuccessful"];
                           
                
                    
                header('HTTP/1.0 404  password_unsuccessful');
                  return json_encode($err);
               }

                 



            
           
            }
        
        else
        { 
            $err=[
                'status'=>405,//method not allowed
                'message'=>" not found any data"];
            
            
                
            header('HTTP/1.0 405  not found any data');
            return json_encode($err);
        }
    }
    


}


function the_image_uploaded($inputss,$id)
{
global $conn;

$name=mysqli_real_escape_string($conn,$inputss['name']);
$city=mysqli_real_escape_string($conn,$inputss['city']);
$image=mysqli_real_escape_string($conn,$_FILES['image']['name']);

    move_uploaded_file($_FILES['image']['tmp_name'],$image);
$srno=mysqli_real_escape_string($conn,$id['srno']);


    if(!isset($id['srno']))
    {
        error422('please enter the srno'); 
    }
   elseif(empty($inputss['name']))
   {
    error422('please enter the name');
   }
   elseif(!isset($inputss['city']))
   {
    error422('please enter the city');
   }
   elseif(!isset($_FILES['image']))
   {
    error422('please enter the image');
   }
   else
   {

$update="update api set name='$name',city='$city',image='$image' where srno='$srno'";

if(mysqli_query($conn,$update))
{
    $err=[
        'status'=>200,//method not allowed
        'message'=>" sucessfully uploaded"];
    
    
        
    header('HTTP/1.0 200  sucessfully uploaded');
    return json_encode($err);
}
else
{
    $err=[
        'status'=>405,//method not allowed
        'message'=>" query is not executed"];
    
    
        
    header('HTTP/1.0 405  query is not executed');
    return json_encode($err);
}


   }






}
?>