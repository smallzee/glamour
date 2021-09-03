<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/23/2020
 * Time: 1:07 PM
 */
require_once '../core/header.php';


// get param
@$email = strtolower($param['email']);
@$password = sha1($param['password']);

// api error status
if (@$param['action'] != "ping-login"){
    api_error_status();
    return;
}

// required data
if (empty($email) && empty($password)){
    api_error_status();
    return;
}


// login
$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email' and password ='$password'");
$num_row = $sql->rowCount();
$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($num_row == 0){
    $data['error'] = 0;
    $data['msg'] = "Invalid login details";
}elseif($rs['role'] > 1){
    $data['error'] = 0;
    $data['msg'] = "Access denied, try again";
}elseif ($rs['status'] != 1){
    $data['error'] =0;
    $data['msg'] = "Access denied";
}else{
    $data2 = $rs;
    $data['error'] =1;
    $data['msg'] = "Access granted";

    if ($data2['password'] == true){
        $data2['password'] = 'xxx';
    }

    $name = explode(" ",$data2['fname']);

    $data2['role'] = role($data2['role']);
    $data2['image'] = adorable_avatar($name[0]);
    $data2['status'] = user_status($data2['status']);
    $data2['fname'] = ucwords($data2['fname']);
    $data2['created_at'] = date('Y-m-d H:i:a',$data2['created_at']);
    $data['user_info'] = $data2;
}

echo json_encode($data);
exit();
