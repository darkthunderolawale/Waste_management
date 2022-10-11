<?php
error_reporting(E_ALL);
include 'connection.php';
include "functions.php";
$data = file_get_contents("php://input");
$datas = json_decode($data);


@$firstname =validate($datas->compname);
@$lastname =validate($datas->firstname);
@$compname =validate($datas->lastname);
@$number = validate($datas->number);
@$email = validate($datas->email);
@$pass = validate($datas->password);
@$cpass = validate($datas->cpassword);

isset($datas->compname,$datas->firstname,$datas->lastname,$datas->number,$datas->email,$datas->password,$datas->cpassword)?:response(false,"invalid parameter","");



if(!$compname){
    response(false,"enter your compname","");
}
if(!$firstname){
    response(false,"enter your firstname","");
}
if(!$lastname){
    response(false,"enter your lastnmae","");
}
if(!$number){
    response(false,"enter your number","");
}elseif(!$email){
    response(false,"enter your email","");
} elseif(strlen($pass) < 8 || strlen($cpass) < 8){
    response(false,"password should be 8+ characters","");
}else{
if(strlen($pass) < 8 || strlen($cpass) < 8){
    response(false,"password should be 8+ characters","");
}else{
if($pass !== $cpass){
    $arr = array(
        'status' => false,
        'msg' =>"password dont match ",
     );
        $array = json_encode($arr);
        echo $array;
}else{
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    if(EmailExistscompany($conn, $email) == true ){
    
        response(false, 'Email already exists', null);
    
        
        
    }else{
        
       $insert_user_query = "INSERT INTO companies (compname,firstname,lastname,email,number, password,is_admin)";
          $insert_user_query.= "VALUES('$compname','$lastname','$firstname','$email', '$number', '$hashed_password','company')";
            if($conn->query($insert_user_query)){
            response(true,"Registration successful. pls Login","");
            }else{
            response(false, "Unable to process".mysqli_error($conn),"");
            };
        
        
    }
}
}
}
?>