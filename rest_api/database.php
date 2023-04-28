<?php
$servername="localhost";
$username="root";
$password="";
$dbname="rest_api";


$conn=mysqli_connect($servername,$username,$password,$dbname);

if($conn)
{
    // echo "database is connected";
}
else
{
    echo mysqli_connect_error();
}


?>