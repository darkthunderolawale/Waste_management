<?php
include("connection.php");

function userInfo(){
$s = ("SELECT * FROM users ORDER BY id DESC");
$result = (mysqli_query($conn,$s));
$num = $result->num_rows;




$postarray = array();

while ($nums = mysqli_fetch_assoc($result)){


    $id = $nums['id'];
    $firstname = $nums['firstname'];
    $lastname = $nums['lastname'];
    $mail = $nums['mail'];
    $number = $nums['number'];

   //  $ip = str_replace('\\','',$ip);



      $array = array(
            'id' => "$id",
            'Username' => "$name",
            'firstname' => "$firstname",
            'lastname' => "$lastname",
            'mail' => "$mail",
      );

      array_push($postarray, $array);


};

$toyib = array(
   'data_count' => $num,
   'users' => $postarray
);

echo json_encode($toyib);

exit;



}

?>