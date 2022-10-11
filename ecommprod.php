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
include "./functionslh.php";

$data = file_get_contents("php://input");
$datas = json_decode($data);

isset($datas->userId,$datas->productName,$datas->price,$datas->quantity,$datas->description)?:response(false,"invalid parameter","");

$userId =validate($datas->userId);
$productName =validate($datas->productName);
$price =validateNumber($datas->price);
$quantity = validate($datas->quantity);
$description = validate($datas->description);

$prodInfo = prodInfo();
if(isAdmin($userId)){
$insert = "INSERT INTO products (productName,price, quantity,description)";
$insert.= "VALUES ('$productName','$price','$quantity', '$description')";
 if($conn->query($insert)){
 response(true,"Registration successful",$prodInfo);
 }else{
 response(false, "Unable to process".mysqli_error($conn),"");
 };
}
else{
    echo "unauthorized access",mysqli_error($conn);
}
?>
