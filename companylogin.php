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
            $fetch_user_query = "SELECT * FROM companies WHERE email = '$email' ";
            $fetch_user_result = mysqli_query($conn, $fetch_user_query);




            if(mysqli_num_rows($fetch_user_result)){
                $user_record = mysqli_fetch_assoc($fetch_user_result);
                $db_password = $user_record['password'];
                
                if(password_verify($password, $db_password)){
                    $_SESSION['user-id'] = $user_record['id'];

                    // set session if user is an admin
                    if($user_record['is_admin'] == 'company'){
                    
                    $arr = array(
                        'status' => true,
                        'msg' =>"This person is a company",
                     );
                        $array = json_encode($arr);
                        echo $array;
                        echo $compInfo();
                        exit();
                }else{
                    response(false,"unknown user","");
                }
            }else{
                $arr = array(
                    'status' => false,
                    'msg' =>"Incorrect username or password",
                 );
                    $array = json_encode($arr);
                    echo $array;
                    exit();
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
    response(true,"Login Successful","");

    


        
    



