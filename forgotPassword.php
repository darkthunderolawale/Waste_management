<?php
    error_reporting(E_ALL);

    include "connection.php";
    include "functions.php";
 echo randomPass($newpass);
 exit;
    $data = file_get_contents("php://input");
    $info = json_decode($data);
 
    @$email = validateemail($info->email);

    isset($email)?:response(false, "invalid parameter", "");

    if(!$email){
        $arr = array(
            'status' => false,
            'msg' =>"Email required",
        ); 
            $array = json_encode($arr);
            echo $array;
            exit();
    }else{

        $check_mail_user = " SELECT * FROM users WHERE mail = '$email'";
        $check_user_query = mysqli_query($conn, $check_mail_user);
        $user_conn = mysqli_num_rows($check_user_query);


        $check_mail_company = "SELECT * FROM companies WHERE email = '$email'";
        $check_company_query = mysqli_query($conn, $check_mail_company);
        $company_conn = mysqli_num_rows($check_company_query);

        if($conn == true){
            if($user_conn > 0){
                $newPassword = randomPass($newpass);
                
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                $update_password = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";

                if($conn->query($update_password)){
                    $arr = array(
                        'status' => false,
                        'msg' =>"Password updated successfully",
                        'new_given_password'=> $newPassword
                    ); 
                        $array = json_encode($arr);
                        echo $array;
                        exit();
                }else{
                    response(false,"Error while updating password","");
                }

            }elseif($company_conn > 0){
                $newPassword = randomPass($newpass);
                    
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
    
                $update_password = "UPDATE companies SET password = '$hashed_password' WHERE email = '$email'";
    
                if($conn->query($update_password)){
                    $arr = array(
                        'status' => false,
                        'msg' =>"Password updated successfully",
                        'new_given_password'=> $newPassword
                    ); 
                        $array = json_encode($arr);
                        echo $array;
                        exit();
                }else{
                    response(false,"Error while updating password","");
                }
            }else{
                $arr = array(
                    'status' => false,
                    'msg' =>"Email does not exist",
                ); 
                    $array = json_encode($arr);
                    echo $array;
                    exit();
            }
        }else{
            $arr = array(
                'status' => false,
                'msg' =>"Error connecting to database",
            ); 
                $array = json_encode($arr);
                echo $array;
                exit();
        } 
    }






















