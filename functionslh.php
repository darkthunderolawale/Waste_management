<?php
error_reporting(E_ALL);
include("connect.php");
function validate($data)
{

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    return $data;
}
function validateemail($data)
{

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = filter_var($data, FILTER_VALIDATE_EMAIL);

    return $data;
}
function validateNumber($data)
{

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = filter_var($data,  FILTER_VALIDATE_INT);


    return $data;
}

function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address  
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function response($x, $y, $v)
{

    $arr = array(
        'status' => $x,
        'msg' => "$y",
        'info' => $v
    );
    $array = json_encode($arr);
    echo $array;
    exit();
}
function response2($x, $y, $v)
{

    $arr = array(
        'status' => $x,
        'msg' => "$y",
        'info' => $v
    );
    $array = json_encode($arr);
    echo $array;
}

function EmailExistsusers_admin($conn, $email)
{
    $user_check_query = "SELECT * FROM users where  mail = '$email'";

    $connect = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($connect) > 0) {
        return true;
    } else {

        return false;
    }
}
function EmailExistscompany($conn, $email)
{

    $user_check_query = "SELECT * FROM companies where  email = '$email'";

    $connect = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($connect) > 0) {
        return true;
    } else {

        return false;
    }
}
$newpass = 10;
function randomPass($newpass)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $newpass; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    // return $index;
    return $randomString;
}

function isAdmin($userid)
{
    global $conn;
    $query = "SELECT is_admin FROM users WHERE id = '$userid'";
    $run = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($run)['is_admin'];
}
function userInfo()
{
    global $conn;
    $s = ("SELECT * FROM users ORDER BY id DESC");
    $result = (mysqli_query($conn, $s));
    $num = $result->num_rows;

    $postarray = array();

    $nums = mysqli_fetch_assoc($result);


    $id = $nums['id'];
    $firstname = $nums['firstname'];
    $lastname = $nums['lastname'];
    $mail = $nums['mail'];
    $number = $nums['number'];
    $is_admin = $nums['is_admin'];





    $array = array(
        'id' => "$id",
        'firstname' => "$firstname",
        'lastname' => "$lastname",
        'mail' => "$mail",
        'number' => "$number",
        'is_admin' => "$is_admin",
    );

    array_push($postarray, $array);




    $toyib = array(
        'data_count' => $num,
        'users' => $postarray
    );

    echo json_encode($toyib);

    exit;
}
function compInfo()
{
    global $conn;
    $s = ("SELECT * FROM companies ORDER BY id DESC");
    $result = (mysqli_query($conn, $s));
    $num = $result->num_rows;

    $postarray = array();

    $nums = mysqli_fetch_assoc($result);


    $id = $nums['id'];
    $firstname = $nums['firstname'];
    $lastname = $nums['lastname'];
    $compname = $nums['compname'];
    $mail = $nums['mail'];
    $number = $nums['number'];





    $array = array(
        'id' => "$id",
        'firstname' => "$firstname",
        'lastname' => "$lastname",
        'compname' => "$compname",
        'mail' => "$mail",
        'number' => "$number",
    );

    array_push($postarray, $array);




    $toyib = array(
        'data_count' => $num,
        'users' => $postarray
    );

    echo json_encode($toyib);

    exit;
}
function get_exp_time($duration, $start_time)
{
    $total_time = 60 * 60 * 24 * $duration;
    $exptime = $start_time + $total_time;
    return $exptime;
}
function pkgDuration($conn, $pkgId)
{

    $user_check_query = "SELECT * FROM packages where  id = '$pkgId'";

    $connect = mysqli_query($conn, $user_check_query);


    $user_record = mysqli_fetch_assoc($connect);
    $duration = $user_record['duration'];
    if (mysqli_num_rows($connect) > 0) {
        return $duration;
    } else {

        return false;
    }
}
function pkgAmount($conn, $pkgId)
{

    $user_check_query = "SELECT * FROM packages where  id = '$pkgId'";

    $connect = mysqli_query($conn, $user_check_query);


    $user_record = mysqli_fetch_assoc($connect);
    $amount = $user_record['amount'];


    if (mysqli_num_rows($connect) > 0) {
        return $amount;
    } else {

        return false;
    }
}
function pkgIdExists($conn, $pkgId)
{

    $user_check_query = "SELECT * FROM packages where  id = '$pkgId'";

    $connect = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($connect) > 0) {
        return true;
    } else {

        return false;
    }
}
function productIdExists($conn, $productId)
{

    $user_check_query = "SELECT * FROM products where  id = '$productId'";

    $connect = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($connect) > 0) {
        return true;
    } else {

        return false;
    }
}
function userIdExists($conn, $userId)
{

    $user_check_query = "SELECT * FROM users where  id = '$userId' ";

    $connect = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($connect) > 0) {
        return true;
    } else {

        return false;
    }
}
function activeSub($userId)
{

    global $conn;
    $s = ("SELECT * FROM subscription WHERE status = 1 AND userId = '$userId' ORDER BY id DESC");
    $result = (mysqli_query($conn, $s));
    $postarray = array();

    while ($nums = mysqli_fetch_assoc($result)) {

        $id = $nums['id'];
        $userId = $nums['userId'];
        $pkg_id = $nums['pkg_id'];
        $amount = $nums['amount'];
        $start_time = $nums['start_time'];
        $start_time = date("Y-m-d",$start_time);
        $exp_time = $nums['exp_time'];
        $exp_time = date("Y-m-d",$exp_time);





        $array = array(
            'id' => "$id",
            'userId' => "$userId",
            'pkg_id' => "$pkg_id",
            'amount' => "$amount",
            'start_time' => "$start_time",
            'exp_time' => "$exp_time"
        );

        array_push($postarray, $array);
    };
    $toyib = array(
        'activeSub' => $postarray
    );

    return ($toyib);

    exit;
}
function concludedSub($userId)
{

    global $conn;
    $s = ("SELECT * FROM subscription WHERE status = 0 AND userId = '$userId'ORDER BY id DESC");
    $result = (mysqli_query($conn, $s));
    $postarray = array();

    while ($nums = mysqli_fetch_assoc($result)) {

        $id = $nums['id'];
        $userId = $nums['userId'];
        $pkg_id = $nums['pkg_id'];
        $amount = $nums['amount'];
        $start_time = $nums['start_time'];
        $start_time = date("Y-m-d H:i:s",$start_time);
        $exp_time = $nums['exp_time'];
        $exp_time = date("Y-m-d H:i:s",$exp_time);





        $array = array(
            'id' => "$id",
            'userId' => "$userId",
            'pkg_id' => "$pkg_id",
            'amount' => "$amount",
            'start_time' => "$start_time",
            'exp_time' => "$exp_time"
        );

        array_push($postarray, $array);
    };
    $toyib = array(
        'concludedPlans' => $postarray
    );

    return ($toyib);

    exit;
}
function endOfSub($conn, $time, $exp_time, $userId)
{
    if ($exp_time < time()) {
        $fetch_user_query = "SELECT * FROM subscription WHERE exp_time <'$time' ";
        $fetch_user_result = mysqli_query($conn, $fetch_user_query);
        //  echo "$fetch_user_query";
        //  var_dump($fetch_user_result);
        //  echo time();

        if (mysqli_num_rows($fetch_user_result) > 0) {
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $update_status = "UPDATE subscription SET status = 0 WHERE userId = '$userId'";
            if ($conn->query($update_status)) {
                $arr = array(
                    'status' => true,
                    'msg' => "subscription updated successfully",
                );
                $array = json_encode($arr);
                echo $array;
                exit();
            } else {
                response(false, "Error while updating subscription", "");
            }
            // $exp_time = $user_record['exp_time'];
            // $status = $user_record['status'];
            // $exp_time = $user_record['exp_time'];

        }
        return true;
    }
}
function getUserById($userId)
{
    global $conn;
    $query = "SELECT firstname,mail,number FROM users WHERE id=$userId";
    $run = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($run);
}
function prodInfo()
{
    global $conn;

    $s = "SELECT * FROM products ORDER BY id DESC";

    $result = (mysqli_query($conn, $s));

    $postarray = array();

    while ($nums = mysqli_fetch_assoc($result)){
    $id = $nums['id'];
    $productName = $nums['productName'];
    $price = $nums['price'];
    $quantity = $nums['quantity'];
    $description = $nums['description'];

    $array = array(
        'id' => "$id",
        'productName' => "$productName",
        'price' => "$price",
        'quantity' => "$quantity",
        'description' => "$description"
    );

    array_push($postarray, $array);
 };
    $toyib = array(
        'products' => $postarray
    );

    return $toyib;

    exit;
}
