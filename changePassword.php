<?php
error_reporting(E_ALL);
include "connect.php";
include "functions.php";

$data = file_get_contents("php://input");
$info = json_decode($data);

@$email = validateemail($info->email);
@$currentPassword = validate($info->currentPassword);
@$newPassword = validate($info->newpassword);
@$confirmNewPassword = validate($info->confirmNewPassword);

isset($email, $currentPassword, $newPassword, $confirmNewPassword) ?: response(false, "Invalid parameter", "");

if (!$email) {
    $arr = array(
        'status' => false,
        'msg' => "Email required",
    );
    $array = json_encode($arr);
    echo $array;
    exit();
} elseif (!$currentPassword) {
    $arr = array(
        'status' => false,
        'msg' => "Enter Your Current Password",
    );
    $array = json_encode($arr);
    echo $array;
    exit();
} elseif (!$newPassword) {
    $arr = array(
        'status' => false,
        'msg' => "Enter Your new password",
    );
    $array = json_encode($arr);
    echo $array;
    exit();
} elseif (!$confirmNewPassword) {
    $arr = array(
        'status' => false,
        'msg' => "confirm Your new Password",
    );
    $array = json_encode($arr);
    echo $array;
    exit();
} else {


    $change_password_sql_users = "SELECT * FROM users WHERE mail = '$email'";
    $fetch_user_result = mysqli_query($conn, $change_password_sql_users);
    $user_conn = mysqli_num_rows($fetch_user_result);


    $change_password_sql_companies = "SELECT * FROM companies WHERE email = '$email'";
    $fetch_companies_result = mysqli_query($conn, $change_password_sql_companies);
    $companies_conn = mysqli_num_rows($fetch_companies_result);


    if ($conn == true) {
        if ($user_conn > 0) {

            $user_record = mysqli_fetch_assoc($fetch_user_result);
            @$user_password = $user_record['password'];

            if (password_verify($currentPassword, $user_password)) {
                if ($newPassword == $confirmNewPassword) {

                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                    $update_password = "UPDATE  users SET password = '$hashed_password' WHERE mail = '$email'";

                    if ($conn->query($update_password)) {
                        response(true, "Password Updated Successfully","");
                    } else {
                        response(false, "Error while updating password" . mysqli_error($conn),"");
                    }
                } else {
                    $arr = array(
                        'status' => false,
                        'msg' => "New password does not match",
                    );
                    $array = json_encode($arr);
                    echo $array;
                    exit();
                }
            } else {
                $arr = array(
                    'status' => false,
                    'msg' => "Current password does not match",
                );
                $array = json_encode($arr);
                echo $array;
                exit();
            }
        } elseif ($companies_conn > 0) {

            $companies_record = mysqli_fetch_assoc($fetch_companies_result);
            @$companies_password = $companies_record['password'];

            if (password_verify($currentPassword, $companies_password)) {
                if ($newPassword == $confirmNewPassword) {

                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                    $update_password = "UPDATE  companies SET password = '$hashed_password' WHERE email = '$email'";

                    if ($conn->query($update_password)) {
                        response(true, "Password Updated Successfully", "");
                    } else {
                        response(false, "Error while updating password", "");
                    }
                } else {
                    $arr = array(
                        'status' => false,
                        'msg' => "New password does not match",
                    );
                    $array = json_encode($arr);
                    echo $array;
                    exit();
                }
            } else {
                $arr = array(
                    'status' => false,
                    'msg' => "Current password does not match",
                );
                $array = json_encode($arr);
                echo $array;
                exit();
            }
        } else {
            $arr = array(
                'status' => false,
                'msg' => "User does not exist",
            );
            $array = json_encode($arr);
            echo $array;
            exit();
        }
    } else {
        $arr = array(
            'status' => false,
            'msg' => "Error",
        );
        $array = json_encode($arr);
        echo $array;
        exit();
    }
}
