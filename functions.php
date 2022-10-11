<?php
error_reporting(E_ALL);
include("connection.php");
function validate($data){

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    return $data;

 }
function validateemail($data){

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = filter_var($data,FILTER_VALIDATE_EMAIL);
    
    return $data;
}
function validatenumber($data){

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = filter_var($data,  FILTER_VALIDATE_INT);
    
   
    return $data;

 }
 
 function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
function response($x,$y,$v){

    $arr = array(
        'status' => $x,
        'msg' =>"$y",
        'user'=>"$v"
     );
        $array = json_encode($arr);
        echo $array;
         exit();
}

function EmailExistsusers_admin($conn, $email){
    
 $user_check_query = "SELECT * FROM users where  mail = '$email'";

 $connect = mysqli_query($conn, $user_check_query);

    if(mysqli_num_rows($connect) >0 ){
        return true;
    }else{
    
    return false;
    
}

}
function EmailExistscompany($conn, $email){
    
 $user_check_query = "SELECT * FROM companies where  email = '$email'";

 $connect = mysqli_query($conn, $user_check_query);

    if(mysqli_num_rows($connect) >0 ){
        return true;
    }else{
    
    return false;
    
}

}
$newpass=10;
function randomPass($newpass) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $newpass; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    // return $index;
    return $randomString;
}

function isAdmin($userid){
    global $conn;
    $query="SELECT is_admin FROM users WHERE id = '$userid'";
    $run = mysqli_query($conn,$query);
    return mysqli_fetch_assoc($run)['is_admin']; 
}
function userInfo(){
    global $conn;
    $s = ("SELECT * FROM users ORDER BY id DESC");
    $result = (mysqli_query($conn,$s));
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


function compInfo(){
    global $conn;
    $s = ("SELECT * FROM companies ORDER BY id DESC");
    $result = (mysqli_query($conn,$s));
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
    
function pkgInfo(){
    global $conn;
    $s = ("SELECT * FROM packages ORDER BY id DESC");
    $result = (mysqli_query($conn,$s));
    $num = $result->num_rows;
     
    $postarray = array();
    
    $nums = mysqli_fetch_assoc($result);
    
    
        $id = $nums['id'];
        $amount = $nums['amount'];
            
        $array = array(
            'id' => "$id",
            'amount' => "$amount"
      );

      array_push($postarray, $array);




$toyib = array(
   'data_count' => $num,
   'users' => $postarray
);

echo json_encode($toyib);

exit;

}

function get_exp_time($duration,$start_time){
    $total_time = 60*60*$duration;
    $exptime = $start_time + $total_time;
    return $exptime;
}
