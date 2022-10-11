<?php
include 'connection.php';
include "functions.php";

$data = file_get_contents("php://input");
$datas = json_decode($data);

        @$email = validate($datas->email);
        @$password = validate($datas->password);

        isset($datas->email,$datas->password)?:response(false,"invalid parameter","");
        if(!$email){
            $arr = array(
                'status' => false,
                'msg' =>"Email required",
             );
                $array = json_encode($arr);
                echo $array;
                exit();
        } elseif(!$password){
            $arr = array(
                'status' => false,
                'msg' =>"password required",
             );
                $array = json_encode($arr);
                echo $array;
                exit();
        }else{
            $fetch_user_query = "SELECT * FROM users WHERE mail = '$email' ";
            $fetch_user_result = mysqli_query($conn, $fetch_user_query);

            if(mysqli_num_rows($fetch_user_result) > 0){
                $user_record = mysqli_fetch_assoc($fetch_user_result);
                $db_password = $user_record['password'];
                
                if(password_verify($password, $db_password)){
                    $_SESSION['user-id'] = $user_record['id'];

                    // set session if user is an admin
                    if($user_record['is_admin'] == 'user'){
                    
                    $arr = array(
                        'status' => true,
                        'msg' =>"This person is a user",
                     );
                        $array = json_encode($arr);
                        echo $array;
                        exit();
                }else{
                response(false,"this person is not a user","$user");
            }
            }else{
                response(false,"incorrect username or password","$user");
            }
        }else{
            $arr = array(
                'status' => false,
                'msg' =>"User not found",
             );
                $array = json_encode($arr);
                echo $array;
                exit();
        }
    }

    


        
    



