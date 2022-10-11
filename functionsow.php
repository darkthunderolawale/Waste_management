<?php
session_start();
require_once "./connect.php";

//if it is empty
// if(!txn_data.user_mobile_no || !txn_data.amount){
//     ("enter user mobile and amount to send money");
//     return 0;
//     }

//for validating signup form
function validateSignup($data)
{
    $full_name = $data["full_name"] ?? "";
    $mobile = $data["mobile"] ?? "";
    $email = $data["email"] ?? "";
    $password = $data["password"] ?? "";
    
    $return_data = [
        "status" => true,
        "msg" => "all fields are perfect",
    ];

    if (!$password) {
        $return_data["status"] = false;
        $return_data["msg"] = "Password is blank";
        $return_data["field"] = "password";
    }

    if (!$email) {
        $return_data["status"] = false;
        $return_data["msg"] = "Email Id is blank";
        $return_data["field"] = "email";
    }

    if (!$mobile) {
        $return_data["status"] = false;
        $return_data["msg"] = "Mobile is blank";
        $return_data["field"] = "mobile";
    }
    if (!$full_name) {
        $return_data["status"] = false;
        $return_data["msg"] = "Full name is blank";
        $return_data["field"] = "full_name";
    }


// check if user is already registered

if (checkDuplicateEmail($email)) {
    $return_data["status"] = false;
    $return_data["msg"] = "Email Id Is Already Registered !";
    $return_data["field"] = "email";
}

if (checkDuplicateMobile($mobile)) {
    $return_data["status"] = false;
    $return_data["msg"] = "Mobile no is already registered !";
    $return_data["field"] = "mobile";
}



    return $return_data;
}

//for showing error messages
function showError($field)
{
    if (isset($_SESSION["error"]) && $_SESSION["error"]["field"] == $field) {
        echo ' <div class="alert alert-danger mt-2" role="alert">' .
            $_SESSION["error"]["msg"] .
            "</div>";
        unset($_SESSION["error"]);
    }
}

//for showing previous submited form values
function showFormValue($field)
{
    if (isset($_SESSION["form_data"])) {
        return $_SESSION["form_data"][$field];
    }
    return "";
}

//for checking email id is already registered or not
function checkDuplicateEmail($email){
global $conn;
$query="SELECT COUNT(*) as row FROM users WHERE email='$email'";
$run = mysqli_query($conn,$query);
$return_data = mysqli_fetch_assoc($run);
return $return_data['row'];
}

//for checking email id is already registered or not
function checkDuplicateMobile($mobile){
    global $conn;
    $query="SELECT COUNT(*) as row FROM users WHERE mobile='$mobile'";
    $run = mysqli_query($conn,$query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
}


//for creating new user
// function createUser($data){
//     global $conn;
//     $full_name =mysqli_real_escape_string($conn,$data["full_name"]);
//     $mobile = mysqli_real_escape_string($conn,$data["mobile"]);
//     $email = mysqli_real_escape_string($conn,$data["email"]);
//     $password = mysqli_real_escape_string($conn,$data["password"]);

//     $query = "INSERT INTO users (full_name,mobile,email,password) ";
//     $query.= " VALUES ('$full_name','$mobile','$email','$password')";

//     if(mysqli_query($conn,$query)){
//         $just_created_user_id = mysqli_insert_id($conn);
//         addJoiningBalance($just_created_user_id);

//         return true;
//     }

//     return false;


// }

// for checking user is exist or not
function checkUser($mobile_or_email,$password){
    global $conn;
    $query="SELECT * FROM users WHERE (mobile='$mobile_or_email' || email='$mobile_or_email') && password='$password'";

    $run = mysqli_query($conn,$query);
    $return_data = mysqli_fetch_assoc($run) ?? array();
    return $return_data;
}

//for adding 1000 rs for new users
function addJoiningBalance($userId,$type,$bags){
    global $conn;
    if($type == "glass"){

        $recycoin = $bags * 100;
        $query="INSERT INTO trans(from_user_id,to_user_id,amount,type,bags) VALUES(40,'$userId','$recycoin','$type','$bags')";
        return mysqli_query($conn,$query);

    }elseif($type == "bottle"){

        $recycoin = $bags * 10;
        $query="INSERT INTO trans(from_user_id,to_user_id,amount,type,bags) VALUES(40,'$userId','$recycoin','$type','$bags')";
        return mysqli_query($conn,$query);

    }else{
       response(false,"recycle type doesn't exist","");
    }
}

//for knowing the credited balance of user
function getCreditedbalance($userId){
    global $conn;
    $query="SELECT SUM(amount) as credit FROM trans WHERE to_user_id=$userId";
    $run = mysqli_query($conn,$query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['credit'];
}

//for knowing the debited balance of user
function getDebitedbalance($userId){
    global $conn;
    $query="SELECT SUM(amount) as debit FROM trans WHERE from_user_id=$userId";
    $run = mysqli_query($conn,$query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['debit'];
}


//for getting transection history of user
function getTransHistory($userId){
    global $conn;
    $query="SELECT * FROM trans WHERE from_user_id=$userId || to_user_id=$userId ORDER BY ID DESC";
    $run = mysqli_query($conn,$query);
    return mysqli_fetch_all($run,true);
}


//for geting user information by id


//for geting user_id by mobile o
// function getUserIconnyMobileNo($mobile_no){
//     global $conn;
//     $query="SELECT id FROM users WHERE mobile='$mobile_no'";
//     $run = mysqli_query($conn,$query);
//     return mysqli_fetch_assoc($run)['id']; 
// }

//for sending the money
function sendMoney($adminId,$userId,$amount){
    global $conn;
    $query="INSERT INTO trans(from_user_id,to_user_id,amount) VALUES('$userId','$adminId','$amount')";
    return mysqli_query($conn,$query);
}