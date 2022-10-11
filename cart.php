<?php
require_once("./functionslh.php");
require_once("./functionsow.php");

$data = file_get_contents("php://input");
$datas = json_decode($data);

isset($datas->userId, $datas->products) ?: response(false, "invalid parameter", "");

$userId = validateNumber($datas->userId);
$products = $datas->products;

// var_dump($products);
// exit;


// function addNumbers($products){

//     $sum = 0;
//     foreach($products as $v) {
//         $sum += $v->price;
//     }
//     return $sum;
// };
// $totalAmount = addNumbers($products);





if (userIdExists($conn, $userId)) {
    $num = sizeof($products)-1;
    for ($i = 0; $i <= $num; $i++) {
        $productId = $products[$i]->id;
    
        if (productIdExists($conn, $productId)) {

            $insert = "INSERT INTO cart (userId,productId)";
            $insert.= "VALUES('$userId','$productId')";
             if($conn->query($insert)){
             response2(true,"product added to cart successfully","");
             }else{
             response2(false, "Unable to process","");
             }

        } else {
            response(false, "product does not exist", "");
        }
        
    }
    exit;
} else {
    response(false, "User not found", "");
}
