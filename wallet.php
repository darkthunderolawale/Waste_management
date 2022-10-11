<?php
require_once("./functionslh.php");
require_once("./functionsow.php");

$data = file_get_contents("php://input");
$datas = json_decode($data);


isset($datas->adminId, $datas->userId, $datas->bags, $datas->type) ?: response(false, "invalid parameter", "");

$adminId = validateNumber($datas->adminId);
$userId = validateNumber($datas->userId);
$bags = validateNumber($datas->bags);
$type = validate($datas->type);
if (isAdmin($adminId)) {
    if (userIdExists($conn, $userId)) {
        $addJoiningBalance = addJoiningBalance($userId, $type, $bags);
        $balance =  getCreditedBalance($userId) - getDebitedBalance($userId);
        $bal = array(
            "balance"=>$balance
        );

        response(true, "recycoin paid successfully", $bal);
    } else {
        response(false, "User not found", "");
    }
}else {
    response(false, "Unauthorized access", "");
}
