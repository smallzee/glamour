<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/23/2020
 * Time: 4:00 PM
 */

require_once '../core/header.php';

// accept data from users
@$email = strtolower($param['email']);
@$password = $param['password'];
@$cpassword = $param['cpassword'];
@$phone = $param['phone'];
@$fname = $param['fname'];

// api error status
if (@$param['action'] != "ping-reg"){
    api_error_status();
    return;
}

// all data is required
if (empty($email) or empty($password) or empty($cpassword) or empty($phone) or empty($fname)){
    api_error_status();
    return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
$num_row = $sql->rowCount();

$error_count = count($error);
$all_errors = array();

if ($num_row >= 1){
    $data['error'] = 0;
    $all_errors[] = $data['msg'] = "Email address has already been used by another user";
    
}

if (strlen($fname) < 8 or strlen($fname) > 100){
    $data['error'] = 0;
    $all_errors[] = $data['msg'] = "Full name should be between 8 - 100 characters";
    //return;
}

if (validate_phone_number($phone) != true){
    $data['error'] =0;
    $all_errors[] = $data['msg'] = "Invalid phone number entered\n";
}

if ($password != $cpassword){
    $data['error'] =0;
    $all_errors[] = $data['msg'] = "Your password did not match confirm password";
}

if (strlen($password) < 6){
    $data['error'] = 0;
    $all_errors[] = $data['msg'] = "Your password should more than 6 characters";
}

if (strlen($email) < 8 or strlen($email) > 100){
    $data['error'] = 0;
    $all_errors[] = $data['msg'] = "Your email address should be between 8 - 100 characters";
}

if(count($all_errors) == 0){
    $data['error'] = 1;
    $data['msg'] = "Account created successfully, login to continue";

    $password2 = sha1($password);
    $created_at = time();

    $in = $db->query("INSERT INTO ".DB_PREFIX."users (fname,email,password,phone,created_at)
    VALUES('$fname','$email','$password2','$phone','$created_at')");

    $subject = "Account Details";
    $msg_body = "<p>Dear ".ucwords($fname)."</p>";
    $msg_body.= "<p> Your account details are stated below! </p>";

    $msg_body.="<ol>".
            "<li> Full Name : ".$fname."</li>".
            "<li> Email Address : ".$email."</li>".
            "<li> Phone Number : ".$phone."</li>".
            "<li> Account status : Approved</li>"
        ."</ol>";
    $msg_body.='<p>Thanks for creating account with us </p>'; 
    $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

    send_mail($msg_body,$subject,$email);

    }else{

    $data['error'] = 0;

    $err_msg = count($all_errors) == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";

    foreach ($all_errors as $key) {
        $err_msg .= "$key \n";
    }

    $data['msg'] = $err_msg;

}
echo json_encode($data);
exit();