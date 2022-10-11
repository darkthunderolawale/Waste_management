<?php
error_reporting(E_ALL);
$server = 'localhost';
$username   = 'fireswit_toyib';
$password   = 'id]PZ8RbN7L9';
$database   = 'fireswit_waste_management';
$conn = mysqli_connect($server, $username,$password,$database);
 
if(!$conn)
{
    exit('Error: could not establish database connection');
}else{
    // exit('Error connecting to db');
}


?>