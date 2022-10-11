<?php
include("connect.php");
include("functionslh.php");

$data = file_get_contents("php://input");
$datas = json_decode($data);

isset($datas->userId) ?: response(false, "invalid parameter", "");

@$userId = validateNumber($datas->userId);

if (userIdExists($conn, $userId) == true){
 echo  json_encode(activeSub($userId));
echo json_encode(concludedSub($userId));
}else {
    response(false, "User not found", "");
}
?>