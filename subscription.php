<?php
include("functionslh.php");
// $payment = true;
// $userId = 30;
// $date = "2022-09-27 00:00:00";
// $start_time = strtotime($date);
// $pkgId = 2;
// $duration = pkgDuration($conn,$pkgId);
// $amount = pkgAmount($conn,$pkgId);
// echo $start_time."<br>";

$data = file_get_contents("php://input");
$datas = json_decode($data);

isset($datas->userId, $datas->pkgId, $datas->start_time, $datas->payment) ?: response(false, "invalid parameter", "");

@$userId = validateNumber($datas->userId);
@$pkgId = validateNumber($datas->pkgId);
@$start_time = validate($datas->start_time);
@$payment = validate($datas->payment);

$start_time = strtotime($start_time);
$duration = pkgDuration($conn, $pkgId);

$amount = pkgAmount($conn, $pkgId);


$exp_time = get_exp_time($duration, $start_time);

$activeSub = activeSub($userId);


if (userIdExists($conn, $userId)) {

    if ($payment == true) {
        $exp_time = get_exp_time($duration, $start_time);

        $sql = "INSERT INTO subscription (userId,pkg_id,amount,start_time,exp_time,status)";
        $sql .= "VALUES('$userId','$pkgId','$amount','$start_time','$exp_time','1')";
        $time = time();
        if (endOfSub($conn, $time, $exp_time, $userId) == true) {

            if ($conn->query($update_status)) {
                response(true, "Subscription updated successfully", "");
            } else {
                response(false, "Error while updating subscription", "");
            }
        } else {
            if ($conn->query($sql)) {
                response(true, "Subscription successful.", $activeSub);
            } else {
                response(false, "Unable to process subscription", "");
            };
        }
    } else {
        echo "payment not successful";
    }
} else {
    response(false, "User not found", "");
}
