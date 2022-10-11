<?php
require_once("./functionslh.php");
require_once("./functionsow.php");

$data = file_get_contents("php://input");
$datas = json_decode($data);

// isset($datas->userId, $datas->products,$datas->amount) ?: response(false, "invalid parameter", "");

$userId = validateNumber($datas->userId);
@$amount = validateNumber($datas->amount);
$products = $datas->products;
$adminId = 40;

// var_dump($amount);
// exit;


function addNumbers($products)
{

    $sum = 0;
    foreach ($products as $v) {
        $sum += $v->price;
    }
    return $sum;
};
$totalAmount = addNumbers($products);





if (userIdExists($conn, $userId)) {

    $num = sizeof($products);
    for ($i = 0; $i < $num; $i++) {
        $productId = $products[$i]->id;
        $price = $products[$i]->price;

        if (productIdExists($conn, $productId)) {

            $balance =  getCreditedBalance($userId) - getDebitedBalance($userId);
            $bal = array(
                "balance" => $balance
            );
            if ($balance > $amount && $amount > $totalAmount) {
                
                if (sendMoney($adminId, $userId,$amount)){
                    $insert = "INSERT INTO records (adminId,price,productId,userId,status)";
                    $insert .= "VALUES ('$adminId','$price','$productId','$userId','paid')";
                    if ($conn->query($insert)) {
                        $sql = "DELETE FROM cart WHERE id = '$productId' AND userId = '$userId'";
                        $res = mysqli_query($conn, $sql);
                        if ($res) {
                            response2(true, "purchase successful", "");
                        } else {
                            response2(false, "error while processing", "");
                        }
                    } else {
                        response2(false, "Unable to process" . mysqli_error($conn), "");
                    };
                } else {
                    response2(false, "something went wrong, please try again after some time", "");
                }
            } else {
                response2(false, "insufficient balance", $bal);
            }
        } else {

            response2(false, "product does not exist", "");
        }
    }
    exit;
} else {
    response(false, "User not found", "");
}
