<?php
// //connect.php
// $server = 'localhost';
// $username   = 'root';
// $password   = '';
// $database   = 'waste';
// $conn = mysqli_connect($server, $username,  $password,$database);
 
// if(!$conn)
// {
//     exit('Error: could not establish database connection');
// }
$conn = mysqli_connect("localhost","root","","waste");
    if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
	}

date_default_timezone_set('Africa/Lagos');
$error="";
?>