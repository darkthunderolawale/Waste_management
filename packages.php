<?php
// date_default_timezone_set("Africa/Lagos");
// // $seconds = time();
// // echo "The time is " . date("h:i:sa",$seconds);
// // echo "The time is " . date("h:i:sa");
// // $seconds = 11111111111111;
// // echo gmdate("H:i:s", $seconds);
// // $post_timestamp = time();
// // echo (time() - $post_timestamp) . " seconds ago";
// // $cur =1764276907;
// // $exp = time()+604800;
// // echo $cur."<br>";
// // echo $exp;
// // if($cur > $exp){
// //     echo "sub has ended";
// // }
// $date1 = strtotime("2022-09-27 00:00:00");
//  echo (time() - $date1) . " seconds ago";
?>

<?php
include 'connection.php';
include "./functions.php";

$data = file_get_contents("php://input");
$datas = json_decode($data);

@$userId =validate($datas->userId);
@$type =validate($datas->type);
@$duration =validate($datas->duration);
@$features = validate($datas->features);
@$amount = validatenumber($datas->amount);

isset($datas->userId,$datas->type,$datas->duration,$datas->features,$datas->amount,$datas->password,$datas->cpassword)?:response(false,"invalid parameter","");

if(isAdmin($userId)){
$insert = "INSERT INTO packages (type,duration,amount,features)";
$insert.= "VALUES ('$type','$duration','$amount', '$features')";
 if($conn->query($insert)){
 response(true,"Registration successful","");
 }else{
 response(false, "Unable to process".mysqli_error($conn),"");
 };
}
else{
    response(false, "Unauthorized access".mysqli_error($conn),"");
}
?>
